<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* API ~ API Routzr • VERSION » alpha-0.0.7 ***/

$api = new APIX();
if(isset(SETTING['API'])){
	$api->initialize(SETTING['API']);
	$api->verify();
	$api->ignite();
}