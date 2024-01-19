<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* API ~ API Setting • VERSION » alpha-0.0.7 ***/

//*----------- DISPLAY -----------*//
$SETTING['API']['VIEW'] = 'JSON';





//*----------- API KEYS -----------*//
$APIKeyDBA = [
	'user' => $SETTING['NETWORK']['DATABASE']['USER'],
	'password' => $SETTING['NETWORK']['DATABASE']['PASSWORD'],
	'name' => $SETTING['NETWORK']['DATABASE']['NAME'],
	'table' => $SETTING['NETWORK']['DATABASE']['TABLE']['NETWORK']
];

$APIKeys = oAPIKeys($APIKeyDBA);
if(empty($APIKeys)){$APIKeys = ['DevAPI' => 'DevZuD1XpcKR6g63i'];}
$SETTING['API']['KEY'] = $APIKeys;

unset($APIKeys);
unset($APIKeyDBA);





//*----------- ROUTES -----------*//
$SETTING['API']['ROUTE'] = [
	'index',
	'ping' => ['error', 'failure', 'success', 'project'],
	'lime' => [
		'installAuth', 'installNetwork', 'installPatrevo',
		'feedbackAll', 'feedbackIs', 'feedbackCreate', 'feedbackSearch', 'feedbackUpdate', 'feedbackDelete', 'feedbackInstall',
		'parishAll', 'parishIs', 'parishCreate', 'parishSearch', 'parishUpdate', 'parishDelete',
		'harvestpadSignupAdmin', 'harvestpadSignup',
		'wocaSignup',
	],
	// 'auth' => ['user',  'login', 'session', 'authorization'],

	// 'lime' => [
	// 	'authData',  'authPasswordUpdate', 'authSignup',
	// 	'profileInstall', 'profileAll', 'profileUpdate',
	// 	'authInstall', 'authAll', 'authIs', 'authOnboard',
	// 	'wocaUserInstall', 'wocaSignup',
	// 	'harvestpadInstall', 'harvestpadSignup',
	// 	'', 'patrevoSignup', 'patrevoCupidUpdate',
	// 	'wowUserAll', 'wowUserIs', 'wowUser',
	// ],
];