<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ERROR ~ The Error Library Function • VERSION » alpha-0.0.3 ***/

/*** ERROR LEGEND
* C - CRITITAL | R - REGULAR | G - GENERAL
* SE - SOURCE [ORIG] | DE - DEVELOPER [iDEV] | IE - IMPLEMENTATION [IMPL] | UE - USER [APPUSER] | PE - PROJECT_DESIGN | AE - ANY [ERROR] | DB - DATABASE [MYSQL]
***/

function oErrorDataX($e=''){

	//*----------- GENERAL -----------*//
	$error['DONE'] = ['title' => 'Request Completed', 'message' => 'Your request has been completed', 'status' => 'OK'];
	$error['SUCCESS'] = ['title' => 'Request Successful', 'message' => 'Your request was successful', 'status' => 'OK'];
	$error['FAILED'] = ['title' => 'Request Failed', 'message' => 'Your request has failed', 'status' => 'F9', 'errorid' => 'GENRQ'];
	$error['ERROR'] = ['title' => 'Request Error', 'message' => 'Your request returned error', 'status' => 'F9', 'errorid' => 'GENRQ'];

	$error['CEF9AE'] = ['status' => 'F9', 'errorid' => 'GENRQ', 'title' => 'Request Failed', 'message' => 'Your request has failed'];
	$error['C520AE'] = ['status' => 'F9', 'errorid' => 'GENRQ', 'title' => 'Undefined Error!', 'message' => 'Your request returned an undefined error'];





	//*----------- SYSTEM DESIGN -----------*//
	$error['R200SD'] = ['status' => 'OK', 'title' => 'Request Complete', 'message' => 'Your request is complete'];
	$error['R204SD'] = ['status' => 'F9', 'errorid' => 'USER', 'title' => 'No Content', 'message' => 'Your request returned no record'];
	$error['R304SD'] = ['status' => 'F9', 'errorid' => 'USER', 'title' => 'Not Modified', 'message' => 'Your request modified no record'];
	$error['R403SD'] = ['status' => 'F9', 'errorid' => 'USER', 'title' => 'Request Prohibited', 'message' => 'Your request is currently not permitted'];
	$error['R417SD'] = ['status' => 'F9', 'errorid' => 'USER', 'title' => 'Request Failed', 'message' => 'Your request was unsuccessful'];
	$error['R428SD'] = ['status' => 'F9', 'errorid' => 'USER', 'title' => 'Precondition Required', 'message' => 'Your request ignored the required condition'];





	//*----------- SOURCE -----------*//
	$error['C204SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'No Response', 'message' => 'Sorry, request returned no response'];
	$error['C400SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'Malformed Request', 'message' => 'Sorry, the request was incorrectly formed internally'];
	$error['C404SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'Resource Unavailable', 'message' => 'Sorry, resource is unavailable'];
	$error['C428SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'Precondition Required', 'message' => 'Sorry, request ignored requirement'];
	$error['C500SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'Not Completed', 'message' => 'Sorry, request was not completed'];
	$error['C501SE'] = ['status' => 'F9', 'errorid' => 'ORIG', 'title' => 'Resource Inaccessible', 'message' => 'Sorry, resource not accessible'];





	//*----------- DEVELOPER -----------*//
	$error['C400DE'] = ['status' => 'F9', 'errorid' => 'iDEV', 'title' => 'Malformed Handling', 'message' => 'Sorry, handler incorrectly formed'];
	$error['C428DE'] = ['status' => 'F9', 'errorid' => 'iDEV', 'title' => 'Precondition Required', 'message' => 'Sorry, essential condition ignored'];
	$error['C501DE'] = ['status' => 'F9', 'errorid' => 'iDEV', 'title' => 'Resource Undefined', 'message' => 'Sorry, resource not defined'];





	//*----------- IMPLEMENTATION -----------*//
	$error['C400IE'] = ['status' => 'F9', 'errorid' => 'IMPL', 'title' => 'Malformed Request', 'message' => 'Oh!, you initiated a bad request'];
	$error['C428IE'] = ['status' => 'F9', 'errorid' => 'IMPL', 'title' => 'Precondition Required', 'message' => 'Oh!, you ignored the required condition'];
	$error['C498IE'] = ['status' => 'F9', 'errorid' => 'IMPL', 'title' => 'Invalid Provision', 'message' => 'Oh!, you provided an invalid data'];
	$error['C405IE'] = ['status' => 'F9', 'errorid' => 'IMPL', 'title' => 'Unsupported Method', 'message' => 'Oh!, your method of request is not supported'];
	$error['C406IE'] = ['status' => 'F9', 'errorid' => 'IMPL', 'title' => 'Not Acceptable', 'message' => 'Oh!, your request is not acceptable'];





	//*----------- DATABASE [MySQL] -----------*//
	$error['CE1F9DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Database Error', 'message' => 'Connection failed'];
	$error['CE428DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Database Error', 'message' => 'Whoa!, pre-condition required'];
	$error['CE498DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Database Error', 'message' => 'Whoa!, Possible :: invalid connection object'];
	$error['C1045DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Access Denied', 'message' => 'Whoa!, incorrect credential'];
	$error['C1049DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Database Unknown', 'message' => 'Whoa!, selected database is unknown'];
	$error['C2002DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Connection Refused', 'message' => 'Whoa!, the target machine actively refused connection'];

	$error['CHY000DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Database Error', 'message' => 'Whoa!, an error occured'];
	$error['C22007DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Incorrect Data', 'message' => 'Whoa!, Possible :: incorrect date value'];
	$error['C23000DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Duplicate Record', 'message' => 'Whoa!, record already exist'];
	$error['C3D000DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'No Database', 'message' => 'Whoa!, no database selected'];
	$error['C42000DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Syntax Error', 'message' => 'Whoa!, Possible :: syntax error or access violation'];
	$error['C42S02DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Table Unknown', 'message' => 'Whoa!, Possible :: bad syntax ~ table name does not exist'];
	$error['C42S22DB'] = ['status' => 'F9', 'errorid' => 'CRIT', 'title' => 'Column Unknown', 'message' => 'Whoa!, Possible :: bad syntax ~ column name is unknown'];





	//*----------- CUSTOM [AO] -----------*//







	// $error['CE2000DB'] = ['status' => 'F9', 'title' => 'Database Error', 'message' => 'Whoa!, unknown database error occured'];
	//TODO: ~check for this type of db error code validity
	// $error['CE425F9DB'] = ['code' => 'CE425F9DB', 'status' => 'F9', 'subject' => 'Database Error', 'message' => 'Database operation failed'];





	if(empty($e)){return false;}

	if(!is_array($e)){$code = $e; $e = [];}
	elseif(isset($e['code'])){$code = $e['code'];}
	else {$code = 'NoCODE';}

	if(!empty($e['status'])){$status = $e['status'];}


	if(!empty($error[$code])){
		$errorset = $error[$code];
		if(isset($status)){$errorset['status'] = $status;}
	}
	else {
		$errorset = [];
		$e['errcode'] = $code;
	}

	if(!empty($errorset)){$resp = $errorset;}
	$resp['code'] = $code;
	if(!empty($e)){$resp = array_merge($resp, $e);}
	return $resp;
}