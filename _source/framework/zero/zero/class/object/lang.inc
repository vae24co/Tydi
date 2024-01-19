<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* oLang ~ Lang Utility • VERSION » alpha-0.0.1 ***/

class oLang {
	private $lang;

	#CONSTRUCT • Auto Set Language
	public function __construct(){
		$this->set();
	}


	#GET • Get Language
	public function get(){
		if(isset($this->lang)){return $this->lang;}
		return false;
	}


	#IS • Check for language
	public function is($lang){
		if(!empty($lang) && (strtolower($lang) === strtolower($this->lang))){
			return true;
		}
		return false;
	}


	#SET • Set Language
	public function set($lang=''){
		if(!empty($lang)){
			$this->lang = $lang;
			$_SESSION['olang'] = $lang;
		}
		else {
			if(!empty($_GET['olang'])){$_SESSION['olang'] = $_GET['olang'];}
			elseif(!empty($_POST['olang'])){$_SESSION['olang'] = $_POST['olang'];}
			elseif(empty($_SESSION['olang'])){$_SESSION['olang'] = 'en';}
			if(!empty($_SESSION['olang'])){$this->lang = $_SESSION['olang'];}
		}
		return true;
	}

} /*** End Of ~oLang ***/
