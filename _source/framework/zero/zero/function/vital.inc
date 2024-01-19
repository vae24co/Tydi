<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* VITAL ~ The Essential Functions • VERSION » alpha-0.0.4 ***/

//*----------- oTraceX -----------*//
function oTraceX($i, $print=true){
	if($print){
		echo nl2br(oTraceX($i, false));
		return true;
	}
	$o = '';
	if(is_array($i)){
		$label = 'array';
		$o .= '<em style="color:#FFD700;">is_'.$label.'</em>';
		$o .='<div style="margin: 0px 0 4px 6px; padding: 4px 6px 6px 12px; border-left: 1px dotted #FFD700;">';
		foreach ($i as $key => $value){
			$o .= '<strong style="color:#A52A2A;">'.$key.': </strong>';
			if(is_bool($value) === true){
				if($value === true){$o .= ' → oTRUE<span> ';}
				elseif($value === false){$o .= ' → oFALSE<span> ';}
				$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
			}
			elseif(is_array($value)){
				$o .= oTraceX($value, false);
			}
			elseif(is_object($value)){ // TODO: improve display
				$o .= '<pre><tt>'.var_export($value, true).'</tt></pre>';
			}
			else {
				$o .= $value.'<span><br>';
			}
		}
		$o .= '</div>';
	}
	elseif(is_bool($i) === true){
		$label = 'boolean';
		$o .= '<em style="color:#FFD700;">is_'.$label.'</em>';
		if($i === true){$o .= ' → oTRUE<span><br>';}
		elseif($i === false){$o .= ' → oFALSE<span><br>';}
		$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
	}
	elseif(is_object($i)){
		$o .= '<pre><tt>'.var_export($i, true).'</tt></pre>';
	}
	else {
		$o .= print_r($i, true);
	}
	return $o;
}





//*----------- oTraceXSort -----------*//
function oTraceXSort($input, $to=''){
	if(is_array($input)){ksort($input);}
	if($to === 'JSON'){
		JSONX::display($input);
		exit;
	}
	return oTraceX($input);
}





//*----------- oJSONX -----------*//
function oJSONX($input){
	return oTraceXSort($input, 'JSON');
}





//*----------- oEnvX -----------*//
function oEnvX($i='IS'){
	if(!defined('ENV')){
		#TODO: ERROR
	}
	else {
		$env = ENV;
		if(($i === 'PROD' && $env === 'PRODUCTION') || ($i === 'STAGE' && $env === 'STAGING') || ($i === 'DEV' && $env === 'DEVELOPMENT')){
			return true;
		}
		elseif($i === 'IS'){return $env;}
	}
	return false;
}





//*----------- oIsErrorX -----------*//
function oIsErrorX($error){
	if($error === 'FAILED'){$e = ['code' => 'FAILED', 'message' => 'The requested operation failed'];}
	if($error === 'NO_RESPONSE'){$e = ['code' => 'C204SE', 'extra' => 'Possible:: Programmer Error'];}
	if($error === 'METHOD_NODATA'){$e = ['code' => 'C400IE', 'message' => 'No input data captured', 'extra' => 'Possible:: User Error, No input data captured'];}
	if($error === 'PARAM_REQUIRED'){$e = ['code' => 'C428IE', 'title' => 'Param Required'];}
	if($error === 'INPUT_REQUIRED'){$e = ['code' => 'C428IE', 'title' => 'Input Required'];}
	if($error === 'PRECONDITION'){$e = ['code' => 'C428IE'];}
	if($error === 'METHOD_INVALID'){$e = ['code' => 'C405IE'];}
	if($error === 'REQUEST_FORBIDDEN'){$e = ['code' => 'R403SD'];}
	return $e;
}





//*----------- oErrorX -----------*//
function oErrorX($error=[], $flag='AUTO', $exit=true){
	$error = oErrorDataX($error);
	$error = oResponseX($error);

	//TODO: determine how to display & log based on environment and platform (app, site or api)
	if(!empty($error)){
		if ($flag === 'AUTO') {

			if(defined('SETTING')){
				if(!empty(SETTING['API']['VIEW'])){$flag = SETTING['API']['VIEW'];}
			}

			if($flag === 'AUTO'){
				if(RouteX::isapi()){$flag = 'JSON';}
				else {$flag = 'TRACE';}
			}
		}

		if($flag === 'JSON'){
			JSONX::display($error);
			exit;
		}

		if($flag === 'TRACE'){
			oTraceX($error);
			exit;
		}

		if($flag === 'RETURN'){
			return oTraceX($error);
		}

	}
	return false;
}





//*----------- oDBErrorX -----------*//
function oDBErrorX(array $error, $object='DB'){
	if(!empty($error['SQL'])){$error['extra']['sql'] = $error['SQL']; unset($error['SQL']);}
	if(!empty($error['PARAMSET'])){$error['extra']['paramset'] = $error['PARAMSET']; unset($error['PARAMSET']);}
	if(empty($error['status'])){$error['status'] = 'F9';}
	// if(empty($error['errorid'])){$error['errorid'] = 'ORIG';}
	if(!empty($object)){$error['object'] = $object;} else {$object = 'Database';}
	return oErrorX($error);
}





//*----------- oErrorHandlerX -----------*//
function oErrorHandlerX($error, $message=''){
	$e = [];
	if($error === 'PARAM_EMPTY'){$e = ['code' => 'C428IE', 'title' => 'Param Empty', 'message' => $message];}
	if($error === 'PARAM_REQUIRED'){$e = ['code' => 'C428IE', 'title' => 'Param Required', 'message' => $message];}
	if($error === 'INPUT_REQUIRED'){$e = ['code' => 'C428IE', 'title' => 'Input Required', 'message' => $message];}
	return $e;
}





//*----------- oFuncX -----------*//
function oFuncX($function, $filepath='', $error=[]){
	if(!function_exists($function)){
		if(empty($error['code'])){$error['code'] = 'C501SE';}
		if(!empty($class)){$error['object'] = 'FUNCTION';}
		if(empty($error['summary'])){$error['summary'] = $function.' :: Function Undefined';}
		if(!empty($filepath)){$error['extra'] = $filepath;}
		return oErrorX($error);
	}
	return true;
}





//*----------- oFuncLoadX -----------*//
function oFuncLoadX($filepath, $load=false, $function='', $error=[]){
	if(!file_exists($filepath)){
		if(empty($error['code'])){$error['code'] = 'C404SE';}
		if(!empty($class)){$error['object'] = 'FUNCTION';}
		if(empty($error['summary'])){$error['summary'] = $function.' :: Function File Missing';}
		if(!empty($filepath)){$error['extra'] = $filepath;}
		return oErrorX($error);
	}
	if($load === true){require $filepath;}
	return true;
}





//*----------- oClassX -----------*//
function oClassX($class, $filepath='', $error=[]){
	if(!class_exists($class)){
		if(empty($error['code'])){$error['code'] = 'C501SE';}
		if(!empty($class)){$error['object'] = $class;}
		if(empty($error['summary'])){$error['summary'] = $class.' :: Class Undefined';}
		if(!empty($filepath)){$error['extra'] = $filepath;}
		return oErrorX($error);
	}
	return true;
}





//*----------- oClassLoadX -----------*//
function oClassLoadX($filepath, $load=false, $class='', $error=[]){
	if(!file_exists($filepath)){
		if(empty($error['code'])){$error['code'] = 'C404SE';}
		if(!empty($class)){$error['object'] = $class;}
		if(empty($error['summary'])){$error['summary'] = $class.' :: Class File Missing';}
		if(empty($error['extra']) && !empty($filepath)){$error['extra'] = $filepath;}
		return oErrorX($error);
	}
	if($load === true){require $filepath;}
	if(!empty($class)){return oClassX($class, $filepath);}
	return true;
}





//*----------- oFileX -----------*//
function oFileX($filepath, $object='', $flag='CHECK', $error=[]){
	if(!file_exists($filepath)){
		if($flag === 'CHECK'){return false;}
		if($flag === 'REPORT' || $flag === 'LOAD'){
			if(empty($error['errorid'])){$error['errorid'] = 'ZERO';}
			if(empty($error['code'])){$error['code'] = 'CE404AE';}
			if(!empty($object)){$error['object'] = $object;}
			if(!empty($filepath)){$error['extra'] = $filepath;}
			if(empty($error['title'])){$error['title'] = 'Not Found';}
			return oErrorX($error);
		}
	}

	if($flag === 'LOAD'){require $filepath;}
	return true;
}





//*----------- oFileLoadX -----------*//
function oFileLoadX($filepath, $object='', $error=[]){
	return oFileX($filepath, $object, 'LOAD', $error);
}






//*----------- oIsFileX -----------*//
function oIsFileX(&$filepath){
	if(!file_exists($filepath)){
		exit('Unavailable File: ['.$filepath.']');
	}
	return true;
}





//*----------- oCaseX -----------*//
function oCaseX($input, $flag=''){
	if($flag === 'LOWERCASE'){$input = strtolower($input);}
	if($flag === 'UPPERCASE'){$input = strtoupper($input);}
	if($flag === 'UPPERCASE_WORD'){
		$input = strtolower($input);
		$input = ucwords($input);
	}
	return $input;
}





//*----------- oCleanX -----------*//
function oCleanX($input, $case=''){
	if(!is_array($input)){
		$input = trim($input);
		$input = StringX::clean($input);
		if(!StringX::empty($case)){$input = oCaseX($input, $case);}
	}
	return $input;
}





//*----------- oRequestX -----------*//
function oRequestX(){
	return ($_REQUEST);
}





//*----------- oPostX -----------*//
function oPostX(){
	return ($_POST);
}





//*----------- oGetX -----------*//
function oGetX(){
	return ($_GET);
}





//*----------- oResponseX -----------*//
function oResponseX($resp=[]){
	if(empty($resp['terminus'])){$resp['terminus'] = RouteX::get('LINK');}
	if(empty($resp['status'])){
		if(!empty($resp['errorid'])){$resp['status'] = 'F9';}
		else {$resp['status'] = 'DONE';}
	}
	if(empty($resp['title'])){$resp['title'] = 'Request Done';}
	if(empty($resp['message'])){$resp['message'] = 'No message returned';}
	if(empty($resp['code'])){$resp['code'] = 'DONE';}
	if(!isset($resp['count'])){$resp['count'] = 0;}
	if(!isset($resp['data'])){$resp['data'] = [];}
	if($resp['status'] === 'F9' && isset($resp['errorid'])){
		$error = [];

		if(isset($resp['errorid'])){$error['errorid'] = $resp['errorid']; unset($resp['errorid']);}
		elseif($resp['code'] !== 'DONE'){$error['errorid'] = $resp['code'];}
		else {$error['errorid'] = 'GENRIQ';}

		if(isset($resp['object'])){$error['object'] = $resp['object']; unset($resp['object']);}

		if(isset($resp['summary'])){$error['summary'] = $resp['summary']; unset($resp['summary']);}
		else {
			$error['summary'] = $resp['terminus'].' - '. $resp['title'];
			if(!empty($error['object'])){$error['summary'] .= ' ~ '.$error['object'];}
		}

		if(isset($resp['extra'])){$error['extra'] = $resp['extra']; unset($resp['extra']);}
		if(isset($resp['errcode'])){$error['errcode'] = $resp['errcode'];}
	}
	if(isset($resp['errcode'])){unset($resp['errcode']);}
	$resp['response']['code'] = $resp['code']; unset($resp['code']);
	$resp['response']['title'] = $resp['title']; unset($resp['title']);
	$resp['response']['message'] = $resp['message']; unset($resp['message']);
	$resp['response']['count'] = $resp['count']; unset($resp['count']);
	$resp['response']['data'] = $resp['data']; unset($resp['data']);
	if(isset($error)){$resp['response']['error'] = $error; unset($error);}
	return $resp;
}





//*----------- oUseFilterX -----------*//
function oUseFilterX($trigger, $input){
	foreach($trigger as $field){
		if(isset($input[$field])){return true;}
	}
	return false;
}





//*----------- oCounterX -----------*//
function oCounterX($label='', $print=false){
	static $count = 0;
	$count++;
	if($print === true){
		$o = '';
		if(!empty($label)){
			$o .= '<strong>'.$label.'</strong>: ';
		}
		echo $o.$count.'<br>';
		return;
	}
	return $count;
}





//*----------- oPreCheck -----------*//
function oPreCheck($method, $paramset){
	if(!ServerX::isRequest($method)){return 'ERROR_METHOD_INVALID';}
	else {
		if($paramset === 'GET_DATA' && empty($_GET)){return 'ERROR_PARAM_REQUIRED';}
		if($paramset === 'POST_DATA' && empty($_POST)){return 'ERROR_PARAM_REQUIRED';}
		if($paramset === 'REQUEST_DATA' && empty($_REQUEST)){return 'ERROR_PARAM_REQUIRED';}
		if($paramset === 'FILE_DATA' && empty($_FILES)){return 'ERROR_PARAM_REQUIRED';}
		if($paramset === 'SESSION_DATA' && empty($_SESSION)){return 'ERROR_PARAM_REQUIRED';}
	}
	return true;
}






//*----------- oFormCheck -----------*//
function oFormCheck($field, $essential, $type='POST', $appendToRequired=[]){
	$entry = DataQ::grab($type, $field, 'UNSET');
	$inputfield = ArrayX::keys($entry);
	$require = DataQ::isEmpty($entry, $inputfield, 'EMPTY');
	if($require !== false){return oErrorHandlerX('PARAM_EMPTY', $require);}
	if($essential === 'SAME'){$essential = $field;}
	if(!empty($essential)){
		if($essential === 'ENTRY'){$essential = ArrayX::keys($entry);}
		if(!empty($appendToRequired)){$essential = array_merge($essential, $appendToRequired);}
		$requireParam = DataQ::isRequired($entry, $essential, 'UNSET');
		if($requireParam !== false){return oErrorHandlerX('PARAM_REQUIRED', $requireParam);}
		$requireInput = DataQ::isRequired($entry, $essential, 'EMPTY');
		if($requireInput !== false){return oErrorHandlerX('INPUT_REQUIRED', $requireInput);}
	}
	return ['oDATA' => $entry];
}






//*----------- oPreCheckInputSanitize -----------*//
function oPreCheckInputSanitize($precheck=[]){
	if(is_array($precheck) && isset($precheck['oDATA'])){
		$input = $precheck['oDATA'];
		if(!empty($input)){
			$input = SanitizeQ::input($input);
			return $input;
		}
	}
	return false;
}





//*----------- oAPIKeys -----------*//
function oAPIKeys($config=[]){
	if(!empty($config) && isset($config['table'])){
		$db = new oPDO;
		$db->initialize($config);
		$db->verify();
		$db->connect();
		if(isset($config['table'])){
			$table = $config['table'];
			$column = ['staging' => 'STAGING', 'web' => 'WEB', 'android' => 'ANDROID', 'ios' => 'iOS', 'key' => 'KEY'];
			$result = $db->allRecord($table, $column, 'NO_LIMIT');
			return $result;
		}
	}
	elseif(!isset($config['table'])){
		//TODO: Trigger Error!
	}
	return false;
}





//*----------- oFindAPIKey -----------*//
function oFindAPIKey(string $label, string $key, array $keyset){
	if(ArrayX::isMulti($keyset)){
		$keys =  array_column($keyset, $label);
		if(!empty($keys)){
			$keys = ArrayX::reIndexNumeric($keys);
			$found = array_search($key, $keys);
			if(!empty($found)){return true;}
		}
	}
	else {
		if(array_key_exists($label, $keyset) && $keyset[$label] === $key){return true;}
	}
	return false;
}





//*----------- oUserIDToColumn -----------*//
function oUserIDToColumn($userid){
	if(!empty($userid)){
		if(SanitizeQ::isEmail($userid, 'BOOL') === true){return ['email' => $userid];}
		elseif(strlen($userid) == 70 && ctype_alnum($userid)){return ['oauthid' => $userid];}
		elseif(strlen($userid) == 90 && ctype_alnum($userid)){return ['token' => $userid];}
		elseif(is_numeric($userid)){return ['phone' => $userid];}
		else {return ['username' => $userid];}
	}
	return false;
}