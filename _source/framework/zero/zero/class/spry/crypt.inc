<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* CryptX ~ Crypt Utility • VERSION » alpha-0.0.1 ***/

class CryptX {
	protected static $method = 'aes-128-ctr';
	private static $key;


	#BASE64 • Encode/Decode in base64 (returns value|FALSE)
	public static function base($input='', $flag='ENCODE'){
		if(!empty($input)){
			if($flag === 'ENCODE'){$input = base64_encode($input);}
			if($flag === 'DECODE'){$input = base64_decode($input);}
			return $input;
		}
		return false;
	}


	#PASSWORD • Password Encryption
	public static function password($input, $cost='DEFAULT'){
		if(!empty($cost) && is_int($cost) && $cost > 4){
			return password_hash($input, PASSWORD_BCRYPT, array('cost' => $cost));
		}
		elseif ($cost == 'DEFAULT'){
			return password_hash($input, PASSWORD_BCRYPT);
		}
		return password_hash($input, PASSWORD_BCRYPT);
	}


	#PASSWORD • Password Verification
	public static function isPassword($password, $hash){
		return password_verify($password, $hash);
	}


	#PREPARE • Prepare Cipher
	protected static function ivBytes(){
		return openssl_cipher_iv_length(self::$method);
	}


	#PREPARE • Prepare Encryption
	public static function prepare($key=false, $method=false){
		if(!$key || empty($key)){$key = php_uname();} #use default encryption key if none supplied
		if(ctype_print($key)){$key = openssl_digest($key, 'SHA256', TRUE);} #convert ASCII keys to binary format
		if($method){
			if(in_array(strtolower($method), openssl_get_cipher_methods())){self::$method = $method;}
			else {
				$error = ['code' => 'DE402CE', 'object' => __METHOD__, 'message' => 'Unrecognized cipher method - '.$method];
				return oErrorX($error);
			}
		}
	}


	#EN • Encryption
	public static function en($input='', $key=false, $method=false){
		if(!empty($input)){
			self::prepare($key, $method);
			$iv = openssl_random_pseudo_bytes(self::ivBytes());
			return bin2hex($iv) . openssl_encrypt($input, self::$method, self::$key, 0, $iv);
		}
		return false;
	}


	#DE • Decryption
	public static function de($input='', $key=false, $method=false){
		if(!empty($input)){
			self::prepare($key, $method);
			$iv_strlen = 2  * self::ivBytes();
			if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $input, $regs)) {
				list(, $iv, $crypted_string) = $regs;
				if(ctype_xdigit($iv) && strlen($iv) % 2 == 0) {
					return openssl_decrypt($crypted_string, self::$method, self::$key, 0, hex2bin($iv));
				}
			}
		}
		return false;
	}


	#RUN • Run Encryption
	public static function run($input='', $type = 'CRYPT', $key=false, $method=false){
		if(!empty($input)){
			if($type == 'CRYPT'){
				$o = hash("md5", $input);
				$o = sha1($o);
				$o = md5($o);
			}
			elseif($type == 'ENCRYPT'){
				return self::en($input, $key, $method);
			}
			elseif($type == 'DECRYPT'){
				return self::de($input, $key, $method);
			}
			if(!empty($o)){return $o;}
		}
		return false;
	}

	//TODO: Test Class Methods

} /*** End Of ~CryptX ***/