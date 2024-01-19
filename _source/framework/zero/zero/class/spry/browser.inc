<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* BrowserX ~ Browser Utility • VERSION » alpha-0.0.1 ***/

class BrowserX {

	#IS • Return browser agent
	public static function is(){
		return strtolower($_SERVER['HTTP_USER_AGENT']);
	}


	public static function IE($operator=false, $ver=NULL){
		if(!preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches)
			|| preg_match('#Opera#', $_SERVER['HTTP_USER_AGENT'])){
			return false === $operator ? false : NULL;
		}

		if(false !== $operator
			&& in_array($operator, array('<', '>', '<=', '>=', '==', '!='))
			&& in_array((int)$ver, array(5,6,7,8,9,10))){
			return eval('return ('.$matches[1].$operator.$ver.');');
		}
		else {return (int)$matches[1];}
	}


	public static function isIE($operator='', $ver=''){
		if(!empty($operator) && !empty($ver)){
			$o = self::IE($operator, $ver);
		} else {
			$o = self::IE();
		}
		if(!$o){return false;}
		return true;
	}


	public static function isOpera($i='iMobi'){
		if($i == 'iMobi'){
			if(StringX::in(self::is(), 'opera mobi')){return true;}
		}
		elseif($i == 'iMini'){
			if(StringX::in(self::is(), 'opera mini')){return true;}
		}
		return false;
	}


	public static function info(){
		if(self::isIE()){$o = 'ie';}
		elseif(self::isOpera('iMobi')){$o = 'operamobi';}
		elseif(self::isOpera('iMini')){$o = 'operamini';}
		else {$o = self::is();}
		return strtolower($o);
	}

} /*** End Of ~BrowserX ***/