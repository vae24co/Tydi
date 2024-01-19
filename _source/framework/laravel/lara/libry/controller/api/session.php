<?php //*** oSessionContrAPI - Description » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Controller;

use Illuminate\Http\Request;
use Zero\Controller\oControllerAPI;
// use Zero\Spry\oInputX;
// use Zero\Spry\oAPIResponseX;
// use Zero\Service\oSessionService;
use Zero\Spry\oAPIValidateX;

class oSessionContrAPI extends oControllerAPI {

	// • ==== initialize → ... »
	public function initialize(Request $request) {
		$constraint = [
			'device' => 'required|string|max:200',
			"os" => "required|string",
			"api" => "required|string",
			"app" => "required|string",
			"agent" => "sometimes|required|filled|string"
		];
		if ($this->evaluate()::input($constraint, $request) === true) {
			$this->session()->initialize($request->all());
		}
		return $this->response()::dispatch();
	}





	// • ==== refresh → ... »
	public function refresh(Request $request) {
		$this->grabToken();
		$this->session()->refresh($this->bearerToken);
		return $this->response()::dispatch();
	}





	// • ==== extend → ... »
	public function extend(Request $request) {
		$this->grabToken();
		$this->session()->extend($this->sessionToken);
		return $this->response()::dispatch();
	}





	// • ==== terminate → ... »
	public function terminate() {
		$this->grabToken();
		$this->session()->terminate($this->sessionToken);
		return $this->response()::dispatch();
	}





	// • ==== token → ... »
	public function token(Request $request) {
		$this->grabToken();
		$this->session()->getToken($this->sessionToken);
		return $this->response()::dispatch();
	}





	// • ==== tokenDetail → ... »
	public function tokenDetail(Request $request) {
		$this->grabToken();
		$this->session()->getTokenData($this->sessionToken);
		return $this->response()::dispatch();
	}





	// • ==== tokenHasUser → ... »
	public function tokenHasUser(Request $request) {
		$this->grabToken();
		$this->session()->tokenHasUser($this->sessionToken);
		return $this->response()::dispatch();
	}





	// • ==== bearerHasUser → ... »
	public function bearerHasUser(Request $request) {
		$this->grabToken();
		$this->session()->bearerHasUser($this->bearerToken);
		return $this->response()::dispatch();
	}





	// • ==== bearerIsAuth → ... »
	public function bearerIsAuth(Request $request) {
		$this->grabToken();
		$this->session()->bearerIsAuth($this->bearerToken);
		return $this->response()::dispatch();
	}

} //> end of oSessionContrAPI