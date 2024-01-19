<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* RedirectX ~ Redirect Utility • VERSION » alpha-0.0.7 ***/

class RedirectX {

	//*----------- GOTO -----------*//
	public static function goto($link){
		header('Location: '. $link);
		exit;
	}






	#META • Redirect URL using http-equiv
	public static function meta($link, $time=0, $exit=false){
		$o = '<meta http-equiv="refresh" content="'.$time.'; url='.$link.'">';
		if($exit){exit($o);}
		return $o;
	}


	#TO • Redirect URL using headers
	public static function to($link, $time=0, $exit=false){
		if(!headers_sent($filename, $linenum)){
			if(!empty($time)){
				header('Refresh:'.$time.';url='.$link);
			}
			else {
				header('Location: '.$link);
			}
			if($exit){exit();}
		}
		else {
			#Use meta redirect (Headers already sent in $filename on line $linenum)
			return self::meta($link, $time, $exit);
		}
	}


	#EXIT • Redirect and exit
	public static function now($link){
		return self::to($link, 0, true);
	}


	#IS • Return redirect to link or auto-redirect and exit
	//TODO:
	public static function is($link='', $base='AUTO'){
		if(!empty($link)){
			$link = URLX::prepare($link, $base);
		}
		elseif(empty($link) && !empty($_GET['goto'])){
			$link = URLX::prepare($_GET['goto']);
		}
		if(!empty($link) && $link != URLX::current()){
			return self::now(strtolower($link));
		}
		return false;
	}

} /*** End Of ~RedirectX ***/