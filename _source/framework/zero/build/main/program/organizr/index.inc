<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* IndexO ~ Index Organizr • VERSION » alpha-0.0.7 ***/

class IndexO extends Organizr {
	public $site;

	//*----------- INITIALIZE -----------*//
	public function initialize(&$site){
		if(!empty($site)){$this->site = $site;}
	}

} /*** End Of ~IndexO ***/