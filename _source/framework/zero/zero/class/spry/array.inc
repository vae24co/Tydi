<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ArrayX ~ Array Utility • VERSION » alpha-0.0.1 ***/

class ArrayX {

	//*----------- filterExtract -----------*//
	public static function filterExtract(&$input, $param){
		if(!empty($input) && !empty($param)){
			if(!is_array($param)){
				if(isset($input[$param])){
					$filter[$param] = $input[$param];
					unset($input[$param]);
				}
			}
			else {
				foreach($param as $key => $value){
					if(is_numeric($key)){
						if(isset($input[$value])){
							$filter[$value] = $input[$value];
							unset($input[$value]);
						}
					}
					else {
						if(isset($input[$key])){
							$filter[$value] = $input[$key];
							unset($input[$key]);
						}
					}
				}
			}
			if(!empty($filter)){return $filter;}
		}
		return false;
	}











	#IS •
	public static function is($input){
		if(is_array($input)){return true;}
		return false;
	}


	#IS_MULTI •
	public static function isMulti($input){
		if(self::is($input)){
			$i = array_filter($input, 'is_array');
			if(count($i) > 0){return true;}
		}
		return false;
	}

	#IS_NUMERIC_KEY •
	public static function isNumericKey(array $array){
		foreach($array as $key => $value){
			if(!is_numeric($key)){return false;}
		}
		return true;
	}


	#UNIQUE_VALUE • Prevent duplicate array values
	public static function uniqueValue(array $array){
		if(self::isMulti($array)){
			foreach($array as $index => $value){
				if(self::is($array[$index])){
					$array[$index] = self::uniqueValue($array[$index]);
				}
			}
		}
		return array_unique($array, SORT_REGULAR);
	}


	#TO_OBJ • Returns object from array
	public static function toObj(array $array){
		if(self::isMulti($array)){
			return json_decode(json_encode($array), false);
		}
		else {
			return (object) $array;
		}
	}


	#TO_STRING • Returns string from array
	public static function toString(array $array, $flag='STRING', $separator='DEFAULT'){
		if(self::isMulti($array)){
			foreach($array as $index => $value){
				if(self::is($array[$index])){
					$array[$index] = self::toString($array[$index]);
				}
			}
		}
		if($flag === 'URI'){
			if(empty($separator) || $separator === 'DEFAULT'){return http_build_query($array);}
			return http_build_query($array, '', $separator);
		}
		return implode($separator, $array);
	}


	#TO_JSON •
	public static function toJSON(array $array, $depth=false){
		if($depth === false){
			return json_encode($array);
		}
		return json_encode($array, JSON_FORCE_OBJECT);
	}


	#REINDEX • Returns re-indexed array
	public static function reIndex(array $array, array $reindex){
		foreach($array as $key => $value){
			if(array_key_exists($key, $reindex)){
				$o[$reindex[$key]] = $value;
				unset($array[$key]);
			}
		}
		if(!empty($array) && !empty($o)){$o = array_merge($o, $array);}
		if(!empty($o)){return $o;} else {return $array;}
	}


	#RE_INDEX_NUMERIC • Returns re-indexed array
	public static function reIndexNumeric(array $array){
		if(self::isNumericKey($array)){
			foreach($array as $index => $value){$o[$index+1] = $value;}
		}
		if(!empty($o)){return $o;} else {return $array;}
	}


	#KEY_TO_VALUE •
	public static function keyToValue($array){
		if(self::is($array)){
			return array_flip($array);
		}
		return false;
	}


	#KEYS • Return array keys (indexed numerically) or false
	public static function keys($array){
		if(self::is($array)){
			return array_keys($array);
		}
		return false;
	}



	public static function key($array, $flag){
		if($flag === 'FIRST'){return array_key_first($array);}
		if($flag === 'LAST'){return array_key_last($array);}
	}


	public static function value($array, $flag){
		if($flag === 'FIRST'){return reset($array);}
		if($flag === 'LAST'){return end($array);}
	}


	#VALUES • Return array values (indexed numerically) or false
	public static function values($array, $search=''){
		if(self::is($array)){
			return array_values($array, $search);
		}
		return false;
	}


	#FLIP •
	public static function flip($array, $flag){
		if(self::is($array)){
			if($flag === 'KEY_TO_VALUE'){$o = self::keyToValue($array);}
			elseif($flag === 'REVERSE'){$o = array_reverse($array);}
			elseif($flag === 'REVERSE_PRESERVE'){$o = array_reverse($array, true);} //? Preserve numeric keys
			if(!empty($o)){return $o;}
		}
		return false;
	}


	#REMOVE •
	public static function remove($input, $filter=''){
		if(!is_array($filter)){
			if(isset($input[$filter])){unset($input[$filter]);}
		}
		else {
			foreach($filter as $index => $value){
				if(isset($input[$index])){unset($input[$index]);}
			}
		}
		return $input;
	}


	#FILTER • Return only filtered index & values from array
	public static function filter(array $input, $filter, $drop='NONE'){
		$o = array();
		if(is_array($filter)){
			foreach($filter as $index){
				if(isset($input[$index])){$o[$index] = $input[$index];}
				else {$o[$index] = '';}
			}
		}
		else {
			if(isset($input[$filter])){$o[$filter] = $input[$filter];}
			else {$o[$filter] = '';}
		}

		if($drop === 'EMPTY'){
			if(is_array($o)){
				foreach($o as $key => $value){
					if(StringX::empty($value)){unset($o[$key]);}
				}
			}
		}

		if($drop === 'UNSET'){
			if(is_array($o)){
				foreach($o as $key => $value){
					if(!isset($input[$key])){unset($o[$key]);}
				}
			}
		}

		return $o;
	}


	#GRAB • Returns data from post/get/request/session
	public static function grab($input, $filter='', $drop='NONE'){
		if(!empty($input)){
			if($input === 'POST' && StringX::empty($_POST)  === false){$o = $_POST;}
			elseif($input === 'GET' && StringX::empty($_GET)  === false){$o = $_GET;}
			elseif($input === 'FILE' && StringX::empty($_FILES)  === false){$o = $_FILES;}
			elseif($input === 'REQUEST' && StringX::empty($_REQUEST)  === false){$o = $_REQUEST;}
			elseif($input === 'SESSION' && StringX::empty($_SESSION)  === false){$o = $_SESSION;}
			else {$o = $input;}
		}
		if(!empty($o)){
			if(!empty($filter)){
				if(is_array($filter)){return self::filter($o, $filter, $drop);}
				elseif(isset($o[$filter])){return array($filter => $o[$filter]);}
			}
			elseif(empty($filter)){
				return $o;
			}
		}
		return false;
	}


	#CLEAN •
	public static function clean(array $array){
		foreach($array as $key => $value){
			$array[$key] = StringX::clean($value);
		}
		return $array;
	}

} /*** End Of ~ArrayX ***/