<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* DataQ ~ Data Utility • VERSION » alpha-0.0.1 ***/

class DataQ {

	public static function jumble($input){
		return RandomX::initialize($input, 'AUTO');
	}

	public static function toObj($input){
		return json_decode(json_encode($input));
	}

	public static function nameToNames($name=''){
		$input = ['firstname' => $name];
		if(!empty($name)){
			$name = StringX::toArray($name, 'SPACE');
			$count = count($name);

			if($count === 3){
				$input['firstname'] = $name[0];
				$input['middlename'] = $name[1];
				$input['lastname'] = $name[2];
			}
			elseif($count === 2){
				$input['firstname'] = $name[0];
				$input['lastname'] = $name[1];
			}
			else {
				$input['firstname'] = $name[0];
			}
		}
		return $input;
	}


	public static function paramToKey($data, $reverse=false){
		if(!ArrayX::isMulti($data)){
			$o = [];
			foreach($data as $key => $value){
				if(StringX::in($key, ':')){
					$index = StringX::swap($key, ':', '', 'FIRST');
					$o[$index] = $value;
				}
			}
			return $o;
		}
		else {
			foreach($data as $key => $entry){
				$data[$key] = self::paramToKey($entry, $reverse);
			}
			return $data;
		}
	}


	public static function filter($data, $filter){
		return ArrayX::filter($data, $filter, 'EMPTY');
	}


	public static function param($data, $res){
		if(is_array($data)){
			if(ArrayX::isMulti($data) && ArrayX::isNumericKey($data)){
				if(isset($data[0])){$data = ArrayX::reIndexNumeric($data);}
				if($res === 'ROW'){return $data[1];}
				if($res === 'ROWS'){return $data;}
				if($res === 'COUNT'){return count($data);}
			}
			else {
				if($res === 'ROW'){return $data;}
				if($res === 'ROWS'){return [1 => $data];}
				if($res === 'COUNT'){return 1;}
			}

			if(!is_array($res)){$res = [$res];}
			if(ArrayX::isMulti($data) && ArrayX::isNumericKey($data)){
				foreach($data as $index => $row){
					$record = DataQ::grab($row, $res, 'UNSET');
					if(!empty($record)){$o[$index] = $record;}
				}
				if(!empty($o)){return $o;}
			}
			return self::grab($data, $res, 'UNSET');
		}
		return false;
	}


	#GRAB •
	public static function grab($input, $filter='', $flag=''){
		return ArrayX::grab($input, $filter, $flag);
	}


	public static function remove($input, $filter=''){
		return ArrayX::remove($input, $filter);
	}


	#REQUIRED • Return required input from array
	public static function required($input, $required, $flag='EMPTY'){
		$field = ''; $prepared = array();

		#prepare required
		foreach($required as $index => $value){
			if(is_numeric($index)){$prepared[$value] = $value;}
			else {$prepared[$index] = $value;}
		}

		#run required on prepared
		if(!empty($prepared)){
			foreach($prepared as $label){
				if($flag === 'FILE'){
					if(!isset($input[$label]) || empty($input[$label])){$field .= $label.', ';}
					else {
						$file = $input[$label];
						if(!is_array($file) || (is_array($file) && (empty($file['size']) || !empty($file['error'])))){$field .= $label.', ';}
					}
				}
				if($flag === 'UNSET' && !isset($input[$label])){$field .= $label.', ';}
				if($flag === 'EMPTY' && (!isset($input[$label]) || (isset($input[$label]) && (StringX::empty($input[$label]) === true)))){$field .= $label.', ';}
				if($flag === 'NO_EMPTY' && (isset($input[$label]) && StringX::empty($input[$label]) === true)){$field .= $label.', ';}
			}
		}
		if(!empty($field)){return StringX::swap($field, ', ', '', 'LAST');}
		return false;
	}


	#IS_REQUIRED •
	public static function isRequired($input, $field, $flag){
		$required = self::required($input, $field, $flag);
		if($required !== false){
			if(StringX::in($required, ',')){$o = 'The parameters ('.$required.') are required';}
			else {$o = 'The parameter ('.$required.') is required';}
			return $o;
		}
		return false;
	}



	#IS_EMPTY •
	public static function isEmpty($input, $field, $flag){
		$required = self::required($input, $field, $flag);
		if($required !== false){
			if(StringX::in($required, ',')){$o = 'The parameters ('.$required.') contain no value';}
			else {$o = 'The parameter ('.$required.') contain no value';}
			return $o;
		}
		return false;
	}


















	public static function oRead($input, $data){
		if(is_array($data)){

			if(!empty($data[$input])){return $data[$input];}
			elseif(isset($data[$input])){return '';}
		}
		return FALSE;
	}

	public static function read($input, $filter, $ret=''){
		$input = self::filter($input, $filter);
		if($ret === 'OBJECT'){return self::toObj($input);}
		return $input;
	}


	public static function encode($input, $flag='HTML', $inverse=false){
		if($flag === 'HTML'){
			if($inverse === false){
				return htmlentities($input);
				#return htmlentities($i, ENT_COMPAT|ENT_QUOTES,'ISO-8859-1', true);
			}
			else {
				return html_entity_decode($input);
			}
		}
		return $input;
	}

	public static function identify($input){
		if(ArrayX::isMulti($input) === 'YEAP'){$type = 'MULTI_ARRAY';}
		elseif(ArrayX::is($input) === 'YEAP'){$type = 'ARRAY';}
		else {
			if(SanitizeQ::isEmail($input, 'BOOL') !== 'NOPE'){$type = 'EMAIL';}
			elseif(is_numeric($input)){$type = 'NUMBER';}
			else {$type = strtoupper(gettype($input));}
		}
		return $type;
	}


	public static function reIndex($input, $reindex){
		if(ArrayX::isMulti($input) === 'YEAP' && ArrayX::isNumericKey($input) === 'YEAP'){
			foreach($input as $i => $row){
				$set[$i] = ArrayX::reIndex($row, $reindex);
			}
			$input = $set;
		}
		else {
			$input = ArrayX::reIndex($input, $reindex);
		}
		return $input;
	}

} /*** End Of ~DataQ ***/