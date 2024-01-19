<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* APP ~ App Routzr • VERSION » alpha-0.0.7 ***/

$url = URLX::fixer('APP');
if($url === true){
	if(oEnvX('STAGE') || oEnvX('PROD')){
		header('Location: https://www.app.co');
		exit;
	}

	$app = new APPX();
	$app->initialize();

	if($app->model === 'index'){RedirectX::goto('admin/login/');}
	if($app->model === 'admin'){
		$admin = new AdminApp;
		$admin->initialize($admin);
	}

}