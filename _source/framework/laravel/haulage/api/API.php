<?php
namespace Zero\API;

use Zero\API\Response as APIResponse;
use Zero\API\Validate as APIValidate;

class API {
	public static function response() {
		return new APIResponse();
	}





	public static function validate() {
		return new APIValidate();
	}
}