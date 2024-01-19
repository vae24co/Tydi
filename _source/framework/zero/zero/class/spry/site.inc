<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* SITEX ~ SITE Utility • VERSION » alpha-0.0.1 ***/

class SITEX {

	//*----------- PAGE -----------*//
	public static function page(){
		if(RouteX::issite()){
			$page = RouteX::get('LINK');
			$page = StringX::swap($page, '/', '-');
			if(StringX::last($page) == '-'){$page = StringX::swap($page, '-', '', 'LAST');}
			if(!empty($page)){return $page;}
		}
		return false;
	}





	//*----------- TITLE -----------*//
	public static function title($title=''){
		if(empty($title)){
			$page = self::page();
			if($page === 'index'){$title = 'Home';}
			else {
				$title = $page;
				if(StringX::in($title, '-')){
					$title = StringX::swap($title, '-', ' ');
					$title = ucwords($title);
				}
			}
		}
		if(!empty(SETTING['PROJECT']['Title'])){$title .= ' • '.SETTING['PROJECT']['Title'];}
		if(!empty(SETTING['PROJECT']['Brand'])){$title .= ' - '.SETTING['PROJECT']['Brand'];}
		return $title;
	}





	//*----------- ACTION -----------*//
	public static function action(){
		return RouteX::get('ACTION');
	}





	//*----------- MODEL -----------*//
	public static function model(){
		return RouteX::get('MODEL');
	}


} /*** End Of ~SITEX ***/