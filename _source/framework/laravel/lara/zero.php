<?php //*** Zero » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero;

class Zero {

	// • ==== property
	protected static $connectionName;
	protected static $APIVersion;
	protected static $APIKey;
	protected static $API;





	// • ==== setProperty →
	public static function setProperty($property){
		if(is_array($property)){
			foreach($property as $key => $value){
				self::${$key} = $value;
			}
		}
		return;
	}





	// • ==== getProperty →
	public static function getProperty($property){
		if(isset(self::${$property})){
			return self::${$property};
		}
		return false;
	}





	// • ==== getConnectionName →
	public static function getConnectionName(){
		return self::$connectionName;
	}






	// • ==== isAPI →
	public static function isAPI(){
		if(isset(self::$API) && self::$API === true){
			return true;
		}
		return false;
	}

} //> end of Zero