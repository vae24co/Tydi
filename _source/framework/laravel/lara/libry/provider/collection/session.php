<?php //*** oSessionCollection » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Provider\Collection;

use Zero\Provider\oProvider;
use Zero\Spry\oDebugX;
use Zero\Spry\oVariableX;
use Zero\Spry\oRandomX;
use Zero\Spry\oDataX;
use Carbon\Carbon;

class oSessionCollection extends oProvider {

	// • ==== property
	protected $table = 'osession';
	protected $fillable = [
		'puid', 'suid', 'tuid', 'author',
		'ouser', 'token', 'oinitialization', 'timeout', 'status'
	];





	// • ==== user → ... »
	public function user() {
		return $this->belongsTo(oUserCollection::class, 'ouser', 'puid');
	}





	// • ==== initialization → ... »
	public function initialization() {
		return $this->belongsTo(oInitializationCollection::class, 'oinitialization', 'puid');
	}





	// • ==== create → ... »
	public function create(array $input = [], int $hour = 2) {
		$input = oDataX::create($input);
		oVariableX::setIfNot($input['token'], oRandomX::token());
		oVariableX::setIfNot($input['timeout'], now()->addHours($hour));
		return parent::create($input);
	}





	// • ==== terminateStatus → ... »
	public function terminateStatus(string $token) {
		return parent::where('token', '=', $token)->update(
			[
				'status' => 'TERMINATED'
			]
		);
	}





	// • ==== extendTimeout → ... »
	public function extendTimeout(string $token, int $hour = 2) {
		return parent::where('token', '=', $token)
			->where('status', '!=', 'TERMINATED')
			->update(
				[
					'status' => 'CONTINUED',
					'timeout' => now()->addHours($hour),
				]
			);
	}






	// • ==== isToken → ... »
	public function isToken($token) {
		return parent::where('token', '=', $token)->exists();
	}





	// • ==== findByToken → ... »
	public function findByToken($token) {
		return parent::where('token', '=', $token)->first();
	}





	// • ==== findTokenByToken → ... »
	public function findTokenByToken($token, $column = 'token') {
		if ($column === 'token') {
			return parent::where('token', '=', $token)->value('token');
		}
		return parent::where('token', '=', $token)->select('token', 'status', 'timeout')->get();
	}





	// • ==== findTokensByToken → ... »
	public function findTokensByToken($token) {
		return parent::where('token', '=', $token)->select('puid as osession', 'oinitialization', 'ouser')->get();
	}





	// • ==== findStatusByToken → ... »
	public function findStatusByToken($token) {
		return parent::where('token', '=', $token)->value('status');
	}





	// • ==== verifyToken → ... »
	public function verifyToken($token, $bearer, $user) {
		if ($bearer === 'NO_CHECK' && $user === 'NO_CHECK') {
			$verify = parent::where('token', '=', $token)->exists();
		} elseif ($bearer === 'NO_CHECK') {
			$verify = parent::where('token', '=', $token)->where('ouser', '=', $user)->exists();
		} elseif ($user === 'NO_CHECK') {
			$verify = parent::where('token', '=', $token)->where('oinitialization', '=', $bearer)->exists();
		} else {
			$verify = parent::where('token', '=', $token)->where('oinitialization', '=', $bearer)->where('ouser', '=', $user)->exists();
		}
		return parent::where('token', '=', $token)->exists();
	}





	// • ==== isTokenExpired → ... » boolen | null (record not found)
	public function isTokenExpired($token) {
		$model = parent::where('token', '=', $token)->select('status', 'timeout')->get();
		if (oVariableX::isCollection($model)) {
			$session = oDataX::collection($model, 0);
			if ($session->status === 'EXPIRED' || $session->status === 'TERMINATED') {
				return true;
			}
			$timestamp = Carbon::parse($session->timeout);
			if ($timestamp->isPast() || ($timestamp->diffInSeconds(now()) <= 2)) {
				parent::where('token', '=', $token)->update(['status' => 'EXPIRED']);
				return true;
			}
			return false;
		}
		return null;
	}





	// • ==== findUserByToken → ... »
	public function findUserByToken(string $token) {

		// $o = $this->sessions()->where('token', '=', $sessionToken)->first();
		// $o = $this->initialization()->find(1);
		// oDebugX::exit($o->author);

	}


} //> end of oSessionCollection