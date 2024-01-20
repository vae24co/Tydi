<?php //*** oAuthContrAPI - Description » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Controller;

use Illuminate\Http\Request;
use Zero\Service\oAuthService;
use Zero\Spry\oRandomX;
use Zero\Spry\oVariableX;
use Zero\Spry\oDebugX;

class oAuthContrAPI extends oControllerAPI {

	// • ==== initializeEmailOTP → ... »
	public function initializeEmailOTP(Request $request) {
		$constraint = ['email' => 'required|email|max:100'];
		if ($this->evaluate()::input($constraint, $request) === true) {
			$email = $request->all()['email'];
			return (new oAuthService())->initializeEmailOTP($email);
		}
		return $this->response()::dispatch();
	}





	// • ==== initializePhoneOTP → ... »
	public function initializePhoneOTP(Request $request) {
		$constraint = ['phone' => 'required|string|max:100'];
		if ($this->evaluate()::input($constraint, $request) === true) {
			$phone = $request->all()['phone'];
			if (oVariableX::isPhone($phone)) {
				return (new oAuthService())->initializePhoneOTP($phone);
			} else {
				$this->response()::invalid();
				$this->response()::hint('Possibly a wrong input format for phone number');
			}
		}
		return $this->response()::dispatch();
	}





	// • ==== initializeOTP → ... »
	public function initializeOTP(Request $request) {
		$constraint = ['userid' => 'required|string|max:100'];
		if ($this->evaluate()::input($constraint, $request) === true) {
			$input = $request->all()['userid'];
			$oAuth = new oAuthService();
			if (oVariableX::isEmail($input)) {
				return $oAuth->initializeEmailOTP($input);
			} elseif (oVariableX::isPhone($input)) {
				return $oAuth->initializePhoneOTP($input);
			} else {
				$this->response()::invalid();
				$this->response()::hint('Possibly a wrong input format (email or phone)');
			}
		}
		return $this->response()::dispatch();
	}





	// • ==== resendOTP → ... »
	public function resendOTP() {
		return $this->response()::dispatch();
	}





	// • ==== authorizeOTP → ... »
	public function authorizeOTP() {
		return $this->response()::dispatch();
	}





	// • ==== setPIN → ... »
	public function setPIN() {
		return $this->response()::dispatch();
	}





	// • ==== changePIN → ... »
	public function changePIN() {
		return $this->response()::dispatch();
	}





	// • ==== removePIN → ... »
	public function removePIN() {
		return $this->response()::dispatch();
	}





	// • ==== setPassword → ... »
	public function setPassword() {
		return $this->response()::dispatch();
	}





	// • ==== changePassword → ... »
	public function changePassword() {
		return $this->response()::dispatch();
	}





	// • ==== removePassword → ... »
	public function removePassword() {
		return $this->response()::dispatch();
	}




	// • ==== login → ... »
	public function login() {
		return $this->response()::dispatch();
	}





	// • ==== logout → ... »
	public function logout() {
		$this->grabToken();
		// $this->auth()->logout($this->sessionToken);
		return $this->response()::dispatch();
	}

} //> end of oAuthContrAPI