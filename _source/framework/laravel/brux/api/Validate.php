<?php
namespace Zero\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Zero\API\Response;

class Validate {

	public static function input(array $constraint = [], Request $request) {
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

			return Response::precondition($message, 'Precondition Ignored', $error);
		}

		return true;
	}

}