<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* CurlQ ~ Curl Utility • VERSION » alpha-0.0.1 ***/

class CurlQ {

	#INIT • Check if cURL exist (return FALSE|curl_init)
	private static function initialize(){
		if(function_exists('curl_init')){
			return curl_init();
		}
		return false;
	}


	#GET • Initiate cURL HTTP GET request
	public static function get($url, $data=[]){
		if(!empty($data) && !is_array($data)){
			$error = ['code' => 'C428DE', 'object' => 'CURL', 'message' => 'Invalid data type', 'extra' => 'Array required, NOT '.gettype($data)];
			return oErrorX($error);
		}
		$curl = self::initialize();
		curl_setopt($curl, CURLOPT_URL, $url);
		if(empty($data)){
			curl_setopt($curl, CURLOPT_URL, $url);
		}
		else {
			curl_setopt($curl, CURLOPT_URL, $url.'?'.http_build_query($data));
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		$exec = curl_exec($curl);
		$error = curl_errno($curl);
		if(!empty($error)){
			$error = ['code' => 'CEF9AE', 'object' => 'CURL', 'extra' => curl_error($curl), $error.' - '.$url];
			return oErrorX($error);
		}
		curl_close($curl);
		return $exec;
	}


	#POST • Initiate cURL HTTP POST request
	public static function post($url, $data=[]){
		if(!empty($data) && !is_array($data)){
			$error = ['code' => 'C428DE', 'object' => 'CURL', 'message' => 'Invalid data type', 'extra' => 'Array required, NOT '.gettype($data)];
			return oErrorX($error);
		}
		$curl = self::initialize();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		$exec = curl_exec($curl);
		$error = curl_errno($curl);
		if(!empty($error)){
			$error = ['code' => 'CEF9AE', 'object' => 'CURL', 'extra' => curl_error($curl), $error.' - '.$url];
			return oErrorX($error);
		}
		curl_close($curl);
		return $exec;
	}


	#HTTP • Initiate cURL HTTP request
	public static function http($url, $method='GET', $data=[]){
		if($method === 'GET'){return self::get($url, $data);}
		elseif($method === 'POST'){return self::post($url, $data);}
		return false;
	}

} /*** End Of ~CurlQ ***/