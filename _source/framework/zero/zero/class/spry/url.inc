<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* URLX ~ URL Utility • VERSION » alpha-0.0.1 ***/

class URLX {

	#REF • Get http referrer
	public static function ref(){
		if(!empty($_SERVER['HTTP_REFERER'])){
			return strtolower($_SERVER['HTTP_REFERER']);
		}
		return false;
	}


	#URI • Get URI
	public static function uri(){
		if(!empty($_SERVER['REQUEST_URI'])){
			return strtolower($_SERVER['REQUEST_URI']);
		}
		return false;
	}


	#QUERY • Get query string
	public static function query(){
		if(!empty($_SERVER['QUERY_STRING'])){
			return strtolower($_SERVER['QUERY_STRING']);
		}
		return false;
	}


	#PAGE • Get current php file
	public static function page(){
		if(!empty($_SERVER['PHP_SELF'])){
			return strtolower($_SERVER['PHP_SELF']);
		}
		return array('error' => ['CE' => 'F9']);
	}


	#PROTOCOL • Get url protocol
	public static function protocol(){
		return SSLX::https() ? 'https' : 'http';
	}


	#ACTIVE • Get current base URL
	public static function active(){
		return self::protocol().'://'.ServerX::host();
	}


	#CURRENT • Get current full path URL
	public static function current(){
		return self::active().self::uri();
	}





	//*----------- PREPARE -----------*//
	public static function prepare($link, $base=''){
		if(!empty($link)){
			$url = '';
			if($base === 'AUTO'){
				$url .= self::active();
			}
			elseif(!empty($base)){
				$url .= $base;
			}
			$url .= $link;
			return $url;
		}
		return false;
	}





	#FIXER • URL redirect if requested live URL is not set BASE URL
	public static function fix($seturl='', $comparison='ACTIVE', $uri=true, $sleep=false, $action='REDIRECT'){
		if(!empty($seturl)){
			if(empty($comparison) || $comparison === 'ACTIVE'){$comparison = self::active();}
			if($comparison !== $seturl){
				$location = $seturl;
				if($uri === true && is_bool($uri)){$location .= self::uri();}
				elseif(!empty($uri)){$location .= $uri;}
				if($sleep !== false){sleep($sleep);}
				if($action === 'REDIRECT'){
					header('Location: '.$location);
					exit;
				}
				elseif($action === 'RETURN'){
					return $location;
				}
			}
			return true;
		}
		return false;
	}


	#FIX •
	public static function fixer($i = ''){
		if($i === 'SITE' && isset(SETTING['SITE']['BASEURL'])){
			return self::fix(SETTING['SITE']['BASEURL'], 'ACTIVE');
		}

		if($i === 'APP'){
			$uri = URLX::uri();
			if(StringX::in($uri, '/app/')){
				$url = StringX::swap($uri, '/app', '', 'FIRST');
				return self::fix(SETTING['APP']['BASEURL'], 'ACTIVE', $url);
			}
			return self::fix(SETTING['APP']['BASEURL'], 'ACTIVE', true);
		}

		if($i === 'API'){
			$uri = URLX::uri();
			if(StringX::in(URLX::uri(), '/api/')){
				$url = StringX::swap($uri, '/api', '', 'FIRST');
				return URLX::fix(SETTING['API']['BASEURL'], 'ACTIVE', $uri, false, 'RETURN');
			}
			return URLX::fix(SETTING['API']['BASEURL'], 'ACTIVE', true, false, 'RETURN');
		}
	}


	#DOMAIN • Get Domain from URL
	public static function domain($url){
		if (empty($url)) {
			//TODO: Trigger error
		}
		#$url = parse_url($url);
		$url = parse_url($url, PHP_URL_HOST);
		// $lib = ['https://', 'http://', 'www.', 'api.', 'app.', 'en.', 'uk.', 'us.', 'ng.'];
		// foreach($lib as $bit){
			// 	if(StringX::in($url, $bit)){
				// 		$url = StringX::swap($url, $bit, '', 'FIRST');
				// 	}
				// }
				return $url;
			}
		} /*** End Of ~URLX ***/