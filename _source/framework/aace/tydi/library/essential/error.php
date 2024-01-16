<?php
/*** ErrorX ~ Error Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class ErrorX {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return self::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return self::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- IS • Trigger Error »
	public static function is($label, $message, $extra = '') {
		$error = '<strong>' . ucwords($label) . '</strong> | ' . $message;
		if (VarX::isNotEmpty($extra)) {
			if (VarX::isArray($extra)) {
				$extra = ArrayX::toString($extra, 'STRING', ' • ');
			}
			if (VarX::stringAcceptable($extra)) {
				$error .= ' → <em>(' . $extra . ')</em>';
			}
		}
		return exit($error);
	}





	// ◇ ----- STRING • ... »
	public static function string($error) {
		switch ($error) {

			case 'NO_UPDATE':
				$e = ['code' => 'R422SE', 'title' => 'No Changes', 'message' => 'Sorry, no changes were made'];
				break;

			case 'CANT_UPDATE':
				$e = ['code' => 'R422IE', 'title' => 'Update Impossible', 'message' => 'Oh, cannot update your record'];
				break;





			// * User Errors
			case 'INVALID_PASSWORD':
				$e = ['code' => 'C498UE', 'title' => 'Invalid Password', 'message' => 'You provided an invalid password'];
				break;

			// * Access Errors
			case 'PERSON_ONLY':
				$e = ['code' => 'C403SE', 'title' => 'Access Prohibited', 'message' => 'Access denied for non-personal accounts'];
				break;

			case 'OFFICE_ONLY':
				$e = ['code' => 'C403SE', 'title' => 'Access Prohibited', 'message' => 'Access denied for non-office accounts'];
				break;

			case 'ROLE_RESTRICTED':
				$e = ['code' => 'C403SE', 'title' => 'Access Restricted', 'message' => 'You do not have privileged access'];
				break;



			case 'NO_RESPONSE':
				$e = 'S204DE';
				break;

			case 'FAILURE':
				$e = 'FAILURE';
				break;

			case 'METHOD_NODATA':
				$e = ['code' => 'C400IE', 'message' => 'No input data captured', 'detail' => 'Possible:: User Error, No input data captured'];
				break;

			case 'PARAM_REQUIRED':
				$e = ['code' => 'C428IE', 'title' => 'Param Required', 'object' => 'PARAM'];
				break;

			case 'INPUT_REQUIRED':
				$e = ['code' => 'C428IE', 'title' => 'Input Required', 'object' => 'INPUT'];
				break;

			case 'PRECONDITION':
				$e = 'C428IE';
				break;

			case 'METHOD_INVALID':
				$e = 'C405IE';
				break;

			case 'REQUEST_FORBIDDEN':
				$e = ['code' => 'R403SE', 'title' => 'Request Forbidden'];
				break;

			case 'ACCESS_DENIED':
				$e = ['code' => 'R403SE', 'title' => 'Access Denied'];
				break;







			case 'ADMIN_ONLY':
				$e = ['code' => 'C403SE', 'title' => 'Request Denied', 'message' => 'Your request has been denied', 'detail' => 'DENIAL :: Access denied for non-admin network application'];
				break;

			default:
				$e = 'S204DE';
				break;
		}

		return $e;
	}





	// ◇ ----- SETS • ... » Array
	public static function sets($code) {
		// * LEGEND :: FLAG [C-CRITICAL | R-REGULAR | A-APPLICATION | S-SYSTEM]
		// * LEGEND :: CODE - [HTTP_CODE] ~ (Relevant HTTP Codes)
		// * LEGEND :: AUTHOR [IE-IMPLEMENTER | DE-DEVELOPER (PROGRAMER) | UE-USER | SE-STANDARD | GE-GENERAL | SD-STANDARD_DESIGN]
		// * LEGEND :: FORMAT [C404DE] ~ Critical Not Found Developer Error





		// * NO RECORD
		$error['R204SD'] = ['title' => 'No Content', 'message' => 'No content returned', 'status' => 'OK'];
		$error['S204DE'] = ['title' => 'No Response', 'message' => 'Oops, no response returned', 'detail' => 'Possible :: Omission in Response'];
		$error['C204IE'] = ['title' => 'No Provision', 'message' => 'Oh, no such provision available', 'detail' => 'Possible :: Error in Request Data'];
		$error['R204UE'] = ['title' => 'Not Found', 'message' => 'Your request returned no record', 'detail' => 'Possible :: Incorrect Input'];
		$error['R204SE'] = ['title' => 'No Record', 'message' => 'Sorry, no record found'];

		// * NOT MODIFIED
		$error['R304UE'] = ['title' => 'Update Failed', 'message' => 'Your record did not update'];
		$error['R304SE'] = ['title' => 'Not Modified', 'message' => 'Sorry, no record was modified'];


		// * BAD REQUEST
		$error['C400DE'] = ['title' => 'Malformed Handling', 'message' => 'Oops, an incorrect resource handling'];
		$error['C400IE'] = ['title' => 'Malformed Request', 'message' => 'Oh, you initiated a flawed request'];
		$error['C400UE'] = ['title' => 'Malformed Request', 'message' => 'You made a bad request.'];
		$error['C400SE'] = ['title' => 'Malformed Request', 'message' => 'Sorry, your request was wrongly formed.'];


		// * NOT PERMITTED
		$error['C403IE'] = ['title' => 'Request Prohibited', 'message' => 'Oh, your request is not permitted'];
		$error['R403UE'] = ['title' => 'Request Prohibited', 'message' => 'Your request is not allowed.'];
		$error['R403SE'] = ['title' => 'Request Prohibited', 'message' => 'Sorry, your request is not permitted.'];


		// * NOT FOUND
		$error['C404DE'] = ['title' => 'Resource Unavailable', 'message' => 'Oops, the resource is unavailable'];
		$error['C404IE'] = ['title' => 'Resource Unavailable', 'message' => 'Oh, the resource is unavailable'];
		$error['C404SE'] = ['title' => 'Resource Unavailable', 'message' => 'Sorry, the resource is unavailable'];

		// * UNSUPPORTED
		$error['C405IE'] = ['title' => 'Unsupported Method', 'message' => 'Oh, no support for your approach'];


		// * NOT ACCEPTABLE
		$error['C406IE'] = ['title' => 'Not Acceptable', 'message' => 'Oh, your request is unacceptable.'];
		$error['C406SE'] = ['title' => 'Not Acceptable', 'message' => 'Sorry, your request is unacceptable.'];


		// * FAILURE
		$error['C417DE'] = ['title' => 'Resource Failed', 'message' => 'Oops, a resource failure occurred.'];
		$error['C417IE'] = ['title' => 'Request Failed', 'message' => 'Oh, your request was unsuccessful.'];
		$error['R417UE'] = ['title' => 'Request Failed', 'message' => 'Your request was unsuccessful.'];
		$error['R417SE'] = ['title' => 'Request Failed', 'message' => 'Sorry, your request was unsuccessful.'];


		// * UNPROCESSABLE
		$error['C422IE'] = ['title' => 'Unprocessable', 'message' => 'Oh, your request cannot be processed'];
		$error['R422UE'] = ['title' => 'Unprocessable', 'message' => 'Your request cannot be processed'];
		$error['R422SE'] = ['title' => 'Unprocessable', 'message' => 'Sorry, your request cannot be processed'];


		// * IGNORED
		$error['C428DE'] = ['title' => 'Requirement Ignored', 'message' => 'Oops, a requirement is unresolved.'];
		$error['C428IE'] = ['title' => 'Precondition Ignored', 'message' => 'Oh, a necessary condition, was ignored.'];
		$error['C428UE'] = ['title' => 'Precondition Ignored', 'message' => 'You ignored the requirement.'];
		$error['C428SE'] = ['title' => 'Precondition Ignored', 'message' => 'Sorry, your request ignored the requirement.'];
		$error['C428DB'] = ['title' => 'Database Precondition Ignored', 'message' => 'Whoa, necessary requirement ignored.'];


		// * INVALID
		$error['C498IE'] = ['title' => 'Invalid Provision', 'message' => 'Oh, you provided invalid data', 'object' => 'INPUT'];
		$error['C498UE'] = ['title' => 'Invalid Data', 'message' => 'You provided an invalid data', 'object' => 'VALUE'];
		$error['C498SE'] = ['title' => 'Invalid Resource', 'message' => 'Sorry, invalid resource requested', 'object' => 'INPUT'];
		$error['C498DB'] = ['title' => 'Invalid Database Resource', 'message' => 'Whoa, possible invalid connection object'];


		// * NOT IMPLEMENTED
		$error['C501DE'] = ['title' => 'Resource Undefined', 'message' => 'Oops, the resource is not defined'];
		$error['C501SE'] = ['title' => 'Resource Inaccessible', 'message' => 'Sorry, the resource is not accessible/'];










		$error['E5201B'] = ['code' => 'E5202B', 'status' => 'F9', 'subject' => 'Unknown Error', 'message' => 'An unknown error occurred'];

		// » Design
		$error['R200SD'] = ['title' => 'Request Complete', 'message' => 'Your request is complete', 'status' => 'OK'];


		// » Standard Error
		$error['C500SE'] = ['title' => 'Not Completed', 'message' => 'Sorry, request was not completed'];




		// » General Error
		$error['DONE'] = ['title' => 'Request Completed', 'message' => 'Your request has been completed', 'status' => 'OK'];
		$error['SUCCESS'] = ['title' => 'Request Successful', 'message' => 'Your request was successful', 'status' => 'OK'];
		$error['FAILURE'] = ['title' => 'Request Failed', 'message' => 'Your request has failed', 'status' => 'F9'];
		$error['ERROR'] = ['title' => 'Request Error', 'message' => 'Your request returned an error', 'status' => 'F9'];
		$error['NOCODE'] = ['title' => 'Unknown Error', 'message' => 'Your request returned an unknown error'];
		$error['CF9GE'] = ['title' => 'Request Failed', 'message' => 'Your request has failed'];
		$error['C520GE'] = ['title' => 'Undefined Error!', 'message' => 'Your request returned an undefined error'];




		// » MySQL Error
		$error['C1045DB'] = ['title' => 'Database - Access Denied', 'message' => 'Whoa, incorrect credential provided'];
		$error['C1F9DB'] = ['title' => 'Database - Connection Error', 'message' => 'Whoa, database connection failed'];
		$error['C1049DB'] = ['title' => 'Database Unknown', 'message' => 'Whoa, selected database is unknown'];
		$error['C2002DB'] = ['title' => 'Connection Refused', 'message' => 'Whoa, the target machine actively refused connection'];

		$error['CHY000DB'] = ['title' => 'Database Error', 'message' => 'Whoa, an error occurred'];
		$error['C22007DB'] = ['title' => 'Database - Invalid Entry', 'message' => 'Whoa, a possible enry violation'];
		$error['C23000DB'] = ['title' => 'Database - Duplicate Record', 'message' => 'Whoa, record already exist'];
		$error['C3D000DB'] = ['title' => 'Database - None', 'message' => 'Whoa, no database selected'];
		$error['C42000DB'] = ['title' => 'Database - Syntax Error', 'message' => 'Whoa, a possible syntax error or access violation'];
		$error['C42S02DB'] = ['title' => 'Database - Table Unknown', 'message' => 'Whoa, a possible bad syntax ~ table name does not exist'];
		$error['C42S22DB'] = ['title' => 'Database - Column Unknown', 'message' => 'Whoa, a possible bad syntax ~ column name is unknown'];

		$error['C425F9DB'] = ['title' => 'Database Error', 'message' => 'Database operation failed'];
		$error['C1292DB'] = ['title' => 'Data Error', 'message' => 'Incorrect datetime value'];
		$error['CE1F9DB'] = ['title' => 'Database Error', 'message' => 'Connection failed'];



		//...If error is found withing set
		if (ArrayX::isKeyNotEmpty($error, $code)) {
			$dataset = $error[$code];
		}

		//...If error not found withing set
		else {
			$dataset = [];
		}

		return $dataset;
	}





	// ◇ ----- DATA • Error Data
	public static function data($e = '') {

		if (VarX::isEmpty($e)) {
			return false;
		}

		// * Error Code
		if (VarX::stringAcceptable($e)) {
			$code = $e;
			$e = [];
		} elseif (ArrayX::isKeyNotEmpty($e, 'code')) {
			$code = $e['code'];
		} else {
			$code = 'NOCODE';
		}

		// * Prepare Data from Code
		if (StringX::end($code, 'IE')) {
			$id = 'IMP';
			$author = 'IMPLEMENTATION';
			$status = 'F9';
		} elseif (StringX::end($code, 'DE')) {
			$id = 'DEV';
			$author = 'DEVELOPER';
			$status = 'F9';
		} elseif (StringX::end($code, 'UE')) {
			$id = 'USR';
			$author = 'USER';
			$status = 'F9';
		} elseif (StringX::end($code, 'SE')) {
			$id = 'SDR';
			$author = 'STANDARD';
			$status = 'F9';
		} elseif (StringX::end($code, 'GE')) {
			$id = 'GEN';
			$author = 'GENERAL';
			$status = 'F9';
		} elseif (StringX::end($code, 'DB')) {
			$id = 'DB';
			$author = 'DATA';
			$status = 'F9';
		}

		// * Genriq Error
		$genriq = ['FAILURE', 'ERROR'];
		if (ArrayX::isValue($genriq, $code)) {
			$id = 'GNQ';
			$author = 'GENRIQ';
		}

		// * Status
		if (ArrayX::isKeyNotEmpty($e, 'status')) {
			$status = $e['status'];
		}


		// * Error Sets
		$dataset = self::sets($code);

		// * Update Error Sets
		if (ArrayX::isNotKeyOrEmpty($dataset, 'status')) {
			if (VarX::isNotEmpty($status)) {
				$dataset['status'] = $status;
			} else {
				$dataset['status'] = 'UNKNOWN';
			}
		}

		if (VarX::isNotEmpty($author)) {
			$dataset['author'] = $author;
		} elseif ($dataset['status'] === 'F9') {
			$dataset['author'] = 'GENRIQ';
		}

		if (VarX::isNotEmpty($id)) {
			$dataset['errorid'] = $id;
		}

		if (VarX::isNotEmpty($code)) {
			$dataset['code'] = $code;
		}

		if (VarX::isNotEmpty($title)) {
			$dataset['title'] = $title;
		}

		if (VarX::isNotEmpty($message)) {
			$dataset['message'] = $message;
		}

		if (ArrayX::isKeyEmpty($dataset, 'title') && ArrayX::isKeyNotEmpty($dataset, 'author')) {
			$dataset['title'] = ucfirst(strtolower($dataset['author'])) . ' Error';
		}

		if (ArrayX::isKeyEmpty($dataset, 'message')) {
			if (StringX::end($code, 'IE')) {
				$dataset['message'] = 'An ';
			} else {
				$dataset['message'] = 'A ';
			}
			$dataset['message'] .= strtolower($dataset['title']) . ' occurred!';
		}

		if (VarX::isNotEmpty($e)) {
			$dataset = array_merge($dataset, $e);
		}

		return $dataset;
	}

} // End Of Class ~ ErrorX