<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* AdminApp ~ Index API Organizr • VERSION » alpha-0.0.7 ***/

class AdminApp extends AppOrganizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(&$object){
	oTraceX($object);


	}





	//*----------- LANDING -----------*//
	public function landing(&$object){
	}





	//*----------- LOGIN -----------*//
	public function login(&$object){
		$this->instance = $object;
		$outlinzr = OUTLINZR.'admin'.DS.'auth.inc';
		if(oIsFileX($outlinzr)){
			require $outlinzr;
		}
	}




















} /*** End Of ~AdminApp ***/