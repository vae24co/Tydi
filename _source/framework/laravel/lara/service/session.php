<?php //*** oSessionService » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Service;

use Zero\Spry\oCollectionX;
use Zero\Spry\oDebugX;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Zero\Zero;
use Zero\Spry\oHandlerX;
use Zero\Spry\oResponseX;
use Zero\Spry\oTimeX;
use Zero\Provider\Collection\oInitializationCollection;
use Zero\Provider\Collection\oSessionCollection;
use Zero\Provider\Log\oJourneyLog;

class oSessionService extends oService {

	// • ==== initialize → initialize session »
	public function initialize(array $input) {
		$connectionName = Zero::getConnectionName();
		DB::connection($connectionName)->beginTransaction();
		try {
			$Initialization = (new oInitializationCollection)->create($input);
			unset($input);

			$input['oinitialization'] = $Initialization->puid;
			$Session = (new oSessionCollection)->create($input);

			$input['osession'] = $Session->puid;
			$input['module'] = 'Session';
			$input['action'] = 'Initialization';
			$input['description'] = 'Session initialized';
			(new oJourneyLog)->create($input);

			DB::connection($connectionName)->commit();
			$data = [
				'token' => $Initialization->token,
				'session' => $Session->token,
				'expires' => oTimeX::human($Session->timeout)
			];
			return oResponseX::data($data, 1, 'Your session has initialized successfully.', 'Session Initialized');
		} catch (QueryException $e) {

			DB::connection($connectionName)->rollBack();
			return oResponseX::database($e);

		} catch (Exception $e) {
			return oResponseX::exceptions(oHandlerX::exceptions($e));
		}
	}





	// • ==== refresh → refresh session token »
	public function refresh(string $bearerToken) {
		$connectionName = Zero::getConnectionName();
		DB::connection($connectionName)->beginTransaction();
		try {
			$Token = (new oInitializationCollection())->findByToken($bearerToken);
			if ($Token) {
				$input['oinitialization'] = $Token->puid;
				$Session = (new oSessionCollection)->create($input);

				$input['osession'] = $Session->puid;
				$input['module'] = 'Session';
				$input['action'] = 'Refreshed';
				$input['description'] = 'Session refreshed';
				(new oJourneyLog)->create($input);

				DB::connection($connectionName)->commit();

				$data = [
					'token' => $Token->token,
					'session' => $Session->token,
					'expires' => oTimeX::human($Session->timeout)
				];
				$title = 'Session Refreshed';
				$message = 'Your session has refreshed successfully.';
			} else {
				return oResponseX::unauthorized('Oh!, bearer token is invalid', 'Invalid Token');
			}
		} catch (QueryException $e) {
			DB::connection($connectionName)->rollBack();
			return oResponseX::database($e);
		} catch (Exception $e) {
			return oResponseX::exceptions(oHandlerX::exceptions($e));
		}
		return oResponseX::data($data, 1, $message, $title);
	}





	// • ==== extend → extend session timeout »
	public function extend(string $token, int $timeout = 1) {
		$oSession = new oSessionCollection();
		$affectedRow = $oSession->extendTimeout($token, $timeout);
		if (oCollectionX::isOkay($affectedRow)) {
			$collection = $oSession->findTokensByToken($token);
			if (oCollectionX::isOkay($collection)) {
				$log = oCollectionX::toArray($collection);
				$log['module'] = 'Session';
				$log['action'] = 'Extended';
				$log['description'] = 'Session extended';
				(new oJourneyLog)->create($log);
			}
			oResponseX::success('Your session has been extended', 'Session Extended');
			return;
		} else {
			$status = $oSession->findStatusByToken($token);
			if (oCollectionX::isOkay($status)) {
				if ($status === 'TERMINATED') {
					oResponseX::hint('You may not extend a logged out session');
					oResponseX::failure('Your session is logged out', 'Session Inactive');
					return;
				}
			}
		}
		oResponseX::failure();
		return;
	}





	// • ==== terminate → terminate session »
	public function terminate(string $token) {
		$oSession = new oSessionCollection();
		$this->tryCatch(
			function () use ($oSession, $token) {
				if ($oSession->terminateStatus($token)) {
					$collection = $oSession->findTokensByToken($token);
					if ($collection) {
						$log = oCollectionX::toArray($collection);
						if (is_array($log)) {
							$log['module'] = 'Session';
							$log['action'] = 'Terminated';
							$log['description'] = 'Session terminated';
							(new oJourneyLog())->create($log);
						}
					}
					return oResponseX::success('Your session has been terminated', 'Session Terminated');
				}
			}
		);
	}






	// • ==== getToken → ... »
	public function getToken(string $token) {
		try {
			$SessionToken = (new oSessionCollection)->findTokenByToken($token, 'token');
			if (!$SessionToken) {
				return oResponseX::noRecord();
			}
		} catch (QueryException $e) {
			return oResponseX::database($e);
		} catch (Exception $e) {
			return oResponseX::exceptions(oHandlerX::exceptions($e));
		}
		oResponseX::data(['token' => $SessionToken]);
		oResponseX::title('Session Token');
		return true;
	}





	// • ==== getTokenData →... »
	public function getTokenData(string $token, $column = 'token') {
		try {
			$column = "'token', 'status', 'timeout'";
			$record = (new oSessionCollection)->findTokenByToken($token, $column);
			if (!$record) {
				return oResponseX::noRecord();
			}
		} catch (QueryException $e) {
			return oResponseX::database($e);
		} catch (Exception $e) {
			return oResponseX::exceptions(oHandlerX::exceptions($e));
		}
		oResponseX::collection($record);
		oResponseX::title('Session Token');
		return true;
	}





	// • ==== tokenHasUser →... »
	public function tokenHasUser(string $token) {
		$collection = (new oSessionCollection())->findByToken($token);
		if ($collection) {
			$has = $collection->user()->exists();
			if ($has) {
				return oResponseX::success();
			}
		}
		return oResponseX::failure();
	}





	// • ==== bearerHasUser →... »
	public function bearerHasUser(string $token) {
		$collection = (new oInitializationCollection())->findByToken($token);
		if ($collection) {
			$has = $collection->user()->exists();
			if ($has) {
				return oResponseX::success();
			}
		}
		return oResponseX::failure();
	}





	// • ==== bearerIsAuth →... »
	public function bearerIsAuth(string $token) {
		$status = (new oInitializationCollection)->findStatusByToken($token);
		if (!$status) {
			return oResponseX::noRecord();
		}
		if ($status === 'AUTHENTICATED') {
			return oResponseX::success('Yeah, token is authenticated', 'Token Authenticated');
		}
		return oResponseX::failure('Oops!, token is not authenticated', 'Token Unauthenticated');
	}

} //> end of oSessionService
