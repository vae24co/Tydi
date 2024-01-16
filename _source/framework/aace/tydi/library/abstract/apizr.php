<?php
/*** APIOrganizr ~ API Organizr » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

abstract class APIOrganizr {

	// ◇ PROPERTY
	protected $response = [];
	protected $API;
	protected $SAAS;
	public $Token;





	// ◇ ----- ABSTRACT METHOD •
	abstract public function initialize();





	// ◇ ----- CHILD • Child Method »
	public function child($method, ...$argument) {
		if (method_exists($this, $method)) {
			return $this->$method(...$argument);
		}
		return false;
	}





	// ◇ ----- CONSTRUCT •
	public function __construct() {
		$response = [
			'data' => [],
			'count' => 0,
		];
		$this->response = $response;
		$this->initialize();
	}





	// ◇ ----- oRESPONSE •
	public function oResponse($response = '') {
		if (VarX::stringAcceptable($response)) {
			if (StringX::begin($response, 'ERROR_')) {
				$response = ErrorX::string(StringX::cropBegin($response, 'ERROR_'));
			}
		}
		if (VarX::isArray($response)) {
			$this->response = array_merge($this->response, $response);
		}
		if (ArrayX::isKey($this->response, 'data')) {
			$this->response['data'] = DataQ::read($this->response['data']);
		}
		return $this->response;
	}





	// ◇ ----- oCALLBACK •
	public function oCallback($response) {
		$response = $this->oResponse($response);
		return API::resolve($response);
	}





	// ◇ ----- oHTTP •
	public function oHTTP($method) {
		if (API::isNotMethod($method)) {
			$error = ['code' => 'C405IE', 'message' => 'Oh!, HTTP method is not supported'];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- oPARAM REQUIRED •
	public function oParamRequired($data, $param) {
		$check = ParamQ::verify($data, $param, 'REQUIRED');
		if (VarX::hasData($check)) {
			$error = ['code' => 'C428IE', 'detail' => 'Param :: ' . ucwords($check['param']), 'object' => 'PARAM', 'message' => $check['summary']];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- oPARAM OPTIONAL •
	public function oParamOptional($data, $param, $requireOne = true) {
		$check = ParamQ::verify($data, $param, 'EMPTY');
		if (VarX::hasData($check)) {
			$error = ['code' => 'C428IE', 'detail' => 'Param :: ' . ucwords($check['param']), 'object' => 'PARAM', 'message' => $check['summary']];
			return $this->oCallback($error);
		} elseif ($requireOne === true && VarX::isBoolean($check)) {
			$find = ParamQ::isFound($data, $param, true);
			if (!VarX::isTrue($find)) {
				$error = ['code' => 'C428IE', 'detail' => 'Param :: Required', 'object' => 'PARAM', 'message' => 'Oh!, your must specify a parameter'];
				return $this->oCallback($error);
			}
		}
		return true;
	}





	// ◇ ----- oPARAM •
	public function oParam($method, $requiredParam, $electiveParam = [], $requireOneElective = true) {

		// * Verify HTTP Method
		$this->oHTTP($method);

		$data = HTTP::data(strtoupper($method));

		// * If $data contains no data
		if (VarX::hasNoData($data)) {
			$error = ['code' => 'C428IE', 'detail' => 'Param :: Required', 'object' => 'PARAM'];
			return $this->oCallback($error);
		}

		// * Check for Required Parameter...
		if (VarX::hasData($requiredParam)) {
			$this->oParamRequired($data, $requiredParam);
		}

		// * Check for Optional Parameter...
		if (VarX::hasData($electiveParam)) {
			if (VarX::hasData($requiredParam)) {
				$requireOneElective = false;
			}
			$this->oParamOptional($data, $electiveParam, $requireOneElective);
		}

		return true;
	}





	// ◇ ----- oAPI VERIFY • Verify API Key & Set API Data
	public function oAPIVerify($method, $param, $keyModel) {
		$column = ['key', 'osaas', 'tuid' => 'bind', 'type', 'client', 'status'];
		$filter = [$param => HTTP::param($param)];
		$record = $keyModel->oFindOne($filter, $column);
		if ($record === 'NO_RESULT') {
			$error = [
				'code' => 'C498IE',
				'title' => 'Incorrect Key',
				'message' => 'Oh!, Incorrect API Key provided',
				'detail' => 'Param :: API Key - ' . HTTP::param($param)
			];
			return $this->oCallback($error);
		}
		$this->API = $record;
		return true;
	}





	// ◇ ----- oAPI VALIDATE •
	public function oAPIValidate() {

		// + Check if API Key is valid for the current SAAS
		if ($this->API['osaas'] !== $this->SAAS['bind']) {
			$error = [
				'code' => 'C498IE',
				'title' => 'Invalid SAAS Key',
				'message' => 'Oh!, Invalid API Key for SAAS',
				'detail' => 'Param :: API Key - ' . $this->API['key']
			];
			return $this->oCallback($error);
		}


		// + Check if API Key is valid for the current environment
		if (!Env::is($this->API['type'])) {
			$error = [
				'code' => 'C498IE',
				'title' => 'Wrong SAAS Key',
				'message' => 'Oh!, Wrong API Key for SAAS',
				'detail' => 'Param :: API Key Environment - ' . $this->API['key']
			];
			return $this->oCallback($error);
		}

		// + Check if API Key is active
		if ($this->API['status'] !== 'ACTIVE') {
			$error = [
				'code' => 'C422SE',
				'title' => 'Inactive SAAS Key',
				'message' => 'Oh!, Inactive API Key provided',
				'detail' => 'Param :: API Key Inactive - ' . $this->API['key']
			];
			return $this->oCallback($error);
		}

		return true;
	}




	// ◇ ----- oTOKEN INITIALIZE •
	public function oTokenInitialize($tokenModel) {

		// * Generate Token
		$input['token'] = Random::token();

		// * Collect Information
		$input['device'] = HTTP::param('device');
		$input['authorized'] = 'YES';
		$input['okey'] = $this->API['bind'];
		$input['osaas'] = $this->API['osaas'];
		$input['type'] = $this->API['type'];
		$input['client'] = $this->API['client'];
		$input['status'] = $this->API['status'];
		$input['timeout'] = Time::SQL('DATETIME', TOKEN_TIMEOUT);

		if (!VarX::isJSON($input['device'])) {
			return ['code' => 'C498IE', 'title' => 'Invalid Input', 'object' => 'DEVICE'];
		}

		// * Add Record to Database
		$record = $tokenModel->oCreate($input, ['token', 'status']);

		// * Return Token
		if (DataQ::isRowColumn($record, 'token')) {
			return ['code' => 'R200SD', 'data' => $record, 'title' => 'Token Initialized', 'count' => 1];
		}

		// * Return Error
		return ['code' => 'C417DE', 'title' => 'Initialization Failed', 'detail' => ['problem' => 'Token :: Creation Failed', 'reason' => 'Possible code or database response'], 'object' => 'TOKEN'];
	}





	// ◇ ----- oTOKENIZE •
	public function oTokenize($keyModel, $tokenModel) {
		$this->oParam('POST', ['key', 'device']);

		// + Verify API & Set Data
		$this->oAPIVerify('POST', 'key', $keyModel);

		// + Validate API (Check SAAS & Environment)
		$this->oAPIValidate();

		// + Generate & Authorize Token, then return Token
		$token = self::oTokenInitialize($tokenModel);
		if (VarX::isNotEmptyArray($token)) {
			return $this->oCallback($token);
		}

		return true;
	}





	// ◇ ----- isTOKEN PARAM •
	private function isTokenParam($bearer = '') {
		if (VarX::hasNoData($bearer)) {
			$error = [
				'code' => 'C428IE',
				'title' => 'Token Required',
				'message' => 'Oh!, you must provide a token',
				'detail' => 'Token :: Required',
				'object' => 'BEARER'
			];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- isTOKEN •
	protected function isToken($bearer, $tokenModel) {
		$column = ['tuid' => 'bind', 'token', 'oauthid', 'okey', 'osaas', 'type', 'status', 'client', 'authorized', 'authenticated'];
		$filter = [
			'token' => $bearer,
			'osaas' => $this->SAAS['bind'],
		];
		$record = $tokenModel->oFindOne($filter, $column);

		// + If token not found
		if ($record === 'NO_RESULT') {
			$error = [
				'code' => 'C498IE',
				'title' => 'Invalid Token',
				'message' => 'Oh!, Invalid Bearer Token',
				'detail' => 'Token :: BEARER - ' . $bearer
			];
			return $this->oCallback($error);
		}

		// + If token is not authorized
		elseif ($record['authorized'] === 'NO') {
			$error = [
				'code' => 'C498SE',
				'title' => 'Unauthorized Token',
				'message' => 'Sorry, Unauthorized Bearer Token',
				'detail' => 'Token :: BEARER - ' . $bearer
			];

			return $this->oCallback($error);
		}

		return $record;
	}





	// ◇ ----- isTOKEN ENV •
	protected function isTokenEnv($record, $bearer = '') {
		if (!Env::is($record['type'])) {
			$error = [
				'code' => 'C498IE',
				'title' => 'Wrong Token',
				'message' => 'Oh!, Wrong Token provided',
				'detail' => 'Bearer :: Wrong Token Environment - ' . $bearer
			];
			return $this->oCallback($error);
		}
		return true;
	}





	// • ----- oTokenTimed - Set a token as TIMED
	protected function oTokenTimed($bearer, $tokenModel) {
		$record = $tokenModel->oFindOne(['token' => $bearer], 'puid');
		if (DataQ::isRowColumn($record, 'puid')) {
			$record = $tokenModel->oUpdateOne($record, ['status' => 'TIMED']);
		}
		return $record;
	}





	// ◇ ----- isTOKEN ACTIVE • Check if Token Timed Out or is Inactive
	protected function isTokenActive($record, $bearer, $tokenModel) {
		if (strtoupper($record['status']) === 'TIMEOUT' || strtoupper($record['status']) === 'TIMED') {
			$error = [
				'code' => 'C422SE',
				'title' => 'Expired Token',
				'message' => 'Oh!, Token no longer active',
				'detail' => 'Bearer :: Token Expired - ' . $bearer
			];

			// * Update Token as TIMED
			$this->child('oTokenTimed', $bearer, $tokenModel);

			return $this->oCallback($error);
		} elseif (strtoupper($record['status']) !== 'ACTIVE') {
			$error = [
				'code' => 'C422SE',
				'title' => 'Inactive Token',
				'message' => 'Oh!, Inactive Token',
				'detail' => 'Bearer :: Token Inactive - ' . $bearer
			];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- isTOKEN Authenticated •
	public function isTokenAuthenticated($record = '', $bearer = '') {

		if (VarX::hasNoData($record)) {
			$record = $this->Token;
		}

		if ($record['authenticated'] === 'NO') {
			$error = [
				'code' => 'C498SE',
				'title' => 'Authentication Required',
				'message' => 'Sorry, authenticate your token',
				'detail' => 'Token :: BEARER - ' . $bearer
			];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- oTOKEN VERIFY • Verify & Set Token
	public function oTokenVerify($tokenModel) {

		$bearer = TokenQ::bearer();

		// * Check if token param exist
		$this->isTokenParam($bearer);

		// * Check if token exist in database and return;
		$token = $this->isToken($bearer, $tokenModel);

		// * Check if token is not for current environment
		$this->isTokenEnv($token, $bearer);

		// * Check if token is not active
		$this->isTokenActive($token, $bearer, $tokenModel);

		// * Set Token Data
		$this->Token = $token;

		// * Unset API
		unset($this->API);

		return true;
	}





	// ◇ ----- oSAAS • Find & Set $SAAS
	public function oSAAS($saasID, $SAASModel) {
		$saas = $SAASModel->dataBySaaSID($saasID);
		if ($saas === 'NO_RESULT') {
			$error = [
				'code' => 'C498DE',
				'title' => 'Invalid SAAS',
				'message' => 'Oh!, Invalid SAAS ID provided',
				'detail' => 'Param :: SaaSID - ' . $saasID
			];
			return $this->oCallback($error);
		}
		$this->SAAS = $saas;
		return true;
	}





	// ◇ ----- oSAAS VERIFY •
	public function oSAASVerify() {
		if (VarX::hasNoData($this->SAAS)) {
			//TODO::
		} elseif (VarX::isNotArray($this->SAAS)) {
			//TODO::
		} elseif (ArrayX::isNotKeyOrEmpty($this->SAAS, 'status')) {
			//TODO::
		} elseif ($this->SAAS['status'] !== 'ACTIVE') {
			$error = [
				'code' => 'C501SE',
				'title' => 'Inactive SAAS',
				'message' => 'Oh!, SAAS is not active',
			];
			return $this->oCallback($error);
		}
		return true;
	}





	// ◇ ----- oSANITIZE • Email, Phone & Username
	public function oSanitize(&$input, $field) {
		if (ArrayX::isKey($input, $field)) {

			// * Email
			if ($field === 'email') {
				$label = 'email address';
				$sanitize = SanitizeQ::isEmail($input[$field], 'DATA');
			}

			// * Username
			if ($field === 'username') {
				$label = 'username';
				$sanitize = SanitizeQ::isUsername($input[$field], 'DATA');
			}

			// * Phone Number
			if ($field === 'phone') {
				$label = 'phone number';
				$sanitize = SanitizeQ::isPhone($input[$field], 'DATA');
			}


			if (VarX::isFalse($sanitize)) {
				$error = ['code' => 'C498UE', 'message' => 'Your ' . $label . ' appears invalid', 'title' => 'Invalid ' . ucwords($label)];
				$error['data'] = [$field => $input[$field]];
				return $this->oCallback($error);
			} elseif ($field === 'username' && !VarX::isTrue($sanitize) && VarX::hasData($sanitize)) {
				$error = ['code' => 'C498UE', 'message' => 'Your ' . $sanitize, 'title' => ucwords($label) . ' Error'];
				$error['data'] = [$field => $input[$field]];
				return $this->oCallback($error);
			}
		}

		return true;
	}





	// ◇ ----- oSUCCESS •
	public function oSuccess($response = []) {
		SetQ::isNotKeyOrEmpty($response, 'code', 'R200SD');
		if (ArrayX::isKeyNotEmpty($response, 'data')) {
			$this->response['count'] = DataQ::countRow($response['data']);
		}
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oNO RECORD •
	public function oNoRecord($response = []) {
		SetQ::isNotKeyOrEmpty($response, 'code', 'R204UE');
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oRECORD •
	public function oRecord($data, $response = [], $label = 'record') {
		if (VarX::isNotEmptyArray($data)) {
			$tasq = SentenceQ::record($data, 'found', $label);
			$response['data'] = $tasq['data'];
			$response['count'] = $tasq['count'];
			SetQ::isNotKeyOrEmpty($response, 'title', $tasq['title']);
			SetQ::isNotKeyOrEmpty($response, 'message', $tasq['message']);
		}
		if (VarX::isNotEmptyArray($response)) {
			$this->response = array_merge($this->response, $response);
		}
		if ($this->response['count'] > 0) {
			SetQ::isNotKeyOrEmpty($this->response, 'code', 'R200SD');
		}
		return $this->response;
	}





	// ◇ ----- oFAILURE •
	public function oFailure($response = []) {
		SetQ::isNotKeyOrEmpty($response, 'code', 'R417SE');
		if (ArrayX::isKeyNotEmpty($response, 'data')) {
			$this->response['count'] = DataQ::countRow($response['data']);
		}
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oERROR •
	public function oError($response = []) {
		SetQ::isNotKeyOrEmpty($response, 'code', 'ERROR');
		if (ArrayX::isKeyNotEmpty($response, 'data')) {
			$this->response['count'] = DataQ::countRow($response['data']);
		}
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oUPDATE FAILURE •
	public function oUpdateFailure($response = []) {
		SetQ::isNotKeyOrEmpty($response, 'code', 'R304UE');
		SetQ::isNotKeyOrEmpty($response, 'title', 'Not Modified');
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oERROR STRING •
	public function oErrorString($error, $response = []) {
		if (VarX::isNotEmpty($error)) {
			$error = StringX::cropBegin($error, 'ERROR_');
			$error = ErrorX::string($error);
			$response = array_merge($error, $response);
		}
		SetQ::isNotKeyOrEmpty($this->response, 'status', 'F9');
		$this->response = array_merge($this->response, $response);
		return $this->response;
	}





	// ◇ ----- oCREATED
	public function oCreated(array $data = [], array $response = []) {

		SetQ::isNotKeyOrEmpty($response, 'code', 'R200SD');
		SetQ::isNotKeyOrEmpty($response, 'status', 'OK');

		if (VarX::isNotEmptyArray($data)) {
			$resp = SentenceQ::record($data, 'created');
			$response['data'] = $resp['data'];
			$response['count'] = $resp['count'];
			SetQ::isNotKeyOrEmpty($response, 'title', $resp['title']);
			SetQ::isNotKeyOrEmpty($response, 'message', $resp['message']);
		}

		SetQ::isNotKeyOrEmpty($response, 'title', 'Record Created');
		SetQ::isNotKeyOrEmpty($response, 'message', 'Your record has been created');

		if (VarX::isNotEmptyArray($response)) {
			$this->response = array_merge($this->response, $response);
		}

		return $this->response;
	}





	// ◇ ----- LANDING •
	public function landing() {
	}

} // End Of Class ~ APIOrganizr