<?php //*** oValidateX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Facades\Validator;

class oValidateX {

	// • ==== input → validate input » array (error) | boolean (true)
	public static function input(array $constraint = [], $request) {
		$message = 'Oh!, something went wrong';
		$validator = Validator::make($request->all(), $constraint);
		if ($validator->fails()) {
			$errors = $validator->errors();
			$message = 'Oh!, ' . lcfirst($errors->first());
			$errors = $errors->toArray();
			foreach ($errors as $key => $value) {
				if (is_array($value)) {
					$error[$key] = $value[0];
				} else {
					$error[$key] = $value;
				}
			}
			return ['message' => $message, 'error' => $error, 'has_error' => true];
		}
		return true;
	}

} //> end of oValidateX