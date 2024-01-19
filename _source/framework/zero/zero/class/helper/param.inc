<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ParamQ ~ Parameter Utility • VERSION » alpha-0.0.1 ***/

class ParamQ {

	#GRAB • Grab data from file, method or session  → FALSE | DATA_ARRAY
	public static function grab($type='', array $field=[]){
		$types = ['GET', 'POST', 'REQUEST', 'SESSION', 'FILE'];
		if(in_array($type, $types)){
			if($type === 'GET' && StringX::empty($_GET) === false){$dataset = $_GET;}
			elseif($type === 'POST' && StringX::empty($_POST) === false){$dataset = $_POST;}
			elseif($type === 'REQUEST' && StringX::empty($_REQUEST) === false){$dataset = $_REQUEST;}
			elseif($type === 'SESSION' && StringX::empty($_SESSION) === false){$dataset = $_SESSION;}
			elseif($type === 'FILE' && StringX::empty($_FILES)  === false){$dataset = $_FILES;}
		}
		if(isset($dataset)){
			foreach($field as $label){
				if(isset($dataset[$label])){$param[$label] = $dataset[$label];}
			}
			if(isset($param)){return $param;}
			if(empty($field) && !empty($dataset)){return $dataset;}
		}
		return false;
	}





	public static function isCheck($dataset, $rule, array $field){
		$param = array();
		foreach($field as $index => $value){
			if(is_numeric($index)){$param[$value] = $value;}
			else {$param[$index] = $value;}
		}

		if(!empty($param)){
			$require = '';
			if($rule === 'UNSET'){
				foreach($param as $label){
					if(!isset($dataset[$label])){$require .= $label.', ';}
				}
			}
			if($rule === 'EMPTY'){
				foreach($param as $label){
					if(!isset($dataset[$label]) || (isset($dataset[$label]) && (StringX::empty($dataset[$label]) === true))){$require .= $label.', ';}
				}
			}
			if($rule === 'NO_EMPTY'){
				foreach($dataset as $label => $value){
					if(StringX::empty($value) === true){$require .= $label.', ';}
				}
			}
			if($rule === 'FILE'){
				foreach($param as $label){
					if(!isset($dataset[$label]) || empty($dataset[$label])){$require .= $label.', ';}
					else {
						$file = $dataset[$label];
						if(!is_array($file) || (is_array($file) && (empty($file['size']) || !empty($file['error'])))){$require .= $label.', ';}
					}
				}
			}
			if(!empty($require)){return StringX::swap($require, ', ', '', 'LAST');}
		}
		return false;
	}



	#IS_EMPTY •
	public static function isEmpty($dataset, $field){
		$required = self::isCheck($dataset, 'NO_EMPTY', $field);
		if($required !== false){
			if(StringX::in($required, ',')){$o = 'The parameters ('.$required.') contain no value';}
			else {$o = 'The parameter ('.$required.') contain no value';}
			return $o;
		}
		return false;
	}



	#IS_REQUIRED •
	public static function isRequired($dataset, $field, $rule){
		$required = self::isCheck($dataset, $rule, $field);
		if($required !== false){
			if(StringX::in($required, ',')){$o = 'The parameters ('.$required.') are required';}
			else {$o = 'The parameter ('.$required.') is required';}
			return $o;
		}
		return false;
	}




	#REQUIRE • Make sure parameter exist or/and is not empty → FALSE | ERROR_ARRAY [code, title, message]
	public static function require($dataset, $rule='NO_EMPTY', array $field=[], $res='BOOL'){
		if(!empty($dataset) && !is_array($dataset)){$dataset = self::grab($dataset);}
		if(!empty($dataset) && is_array($dataset)){
			if($rule === 'EMPTY'){
				$require = self::isEmpty($dataset, $field);
				if(!$require){
					if(empty($field)){$field = ArrayX::keys($dataset);}
					$require = self::isRequired($dataset, $field, 'EMPTY');
				}
			}
			elseif($rule === 'NO_EMPTY'){
				$require = self::isEmpty($dataset, $field);
			}
			else {
				$require = self::isRequired($dataset, $field, $rule);
			}

			if($require !== false){
				if($rule === 'NO_EMPTY' && empty($field)){return oErrorHandlerX('PARAM_EMPTY', $require);}
				elseif($rule === 'UNSET'){return oErrorHandlerX('PARAM_REQUIRED', $require);}
				return oErrorHandlerX('INPUT_REQUIRED', $require);
			}
		}
		if($res === 'DATA'){return ['oDATA' => $dataset];}
		return false;
	}



} /*** End Of ~ParamQ ***/
