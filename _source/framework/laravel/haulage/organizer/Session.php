<?php
namespace Zero\Organizer;

use Illuminate\Support\Facades\DB as Database;
use Illuminate\Database\QueryException;

use App\Models\Session as mSession;
use Zero\Utilizer\Data;
use Zero\Utilizer\Information;
use Zero\API\Response;
use Exception;


class Session {


	// • Initialize App Session
	public function initialize(array $input) {
		// $data['ip_address'] = $this->getClientIP();
		// $data['isp'] = $this->getClientISP($data['ip_address']);
		// if (empty($data['isp'])) {
		// 	unset($data['isp']);
		// }


		$input = Data::create($input);
		$input['token'] = Information::token();
		Database::beginTransaction();
		try {
			mSession::create($input);
			Database::commit();
			Response::data(['token' => $input['token']], 1, 'Your session has initialized successfully.', 'Session Initialized');
		} catch (QueryException $e) {
			Database::rollBack();
			return Response::database($e);
		}
	}
}