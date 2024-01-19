<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* SITE ~ Site Routzr • VERSION » alpha-0.0.7 ***/

$url = URLX::fixer('SITE');

if($url === true){
	if(oEnvX('STAGE') || oEnvX('PROD')){
		header('Location: https://www.site.co');
		exit;
	}

	$site = new SITEX();
}