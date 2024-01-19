<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ENV ~ Environment Setting • VERSION » alpha-0.0.7 ***/

//*----------- DATABASE -----------*//
$SETTING['DATABASE'] = [
	'USER' => 'ao',
	'PASSWORD' => 'AO21',
	'NAME' => 'ziux'
];





//*----------- DOMAIN -----------*//
$SETTING['PROTOCOL'] = 'https://';
$SETTING['DOMAIN'] = 'woca.co';





//*----------- BASEURL -----------*//
$SETTING['API']['BASEURL'] = $SETTING['PROTOCOL'].'api.'.$SETTING['DOMAIN'];
$SETTING['APP']['BASEURL'] = $SETTING['PROTOCOL'].'app.'.$SETTING['DOMAIN'];
$SETTING['SITE']['BASEURL'] = $SETTING['PROTOCOL'].'www.'.$SETTING['DOMAIN'];





//*----------- NETWORK DB -----------*//
$SETTING['NETWORK'] = [
	'DATABASE' => [
		'NAME' => $SETTING['DATABASE']['NAME'],
		'USER' => $SETTING['DATABASE']['USER'],
		'PASSWORD' => $SETTING['DATABASE']['PASSWORD'],
		'TABLE' => [
			'NETWORK' => 'networko',
			'AUTH' => 'autho',
			'PROFILE' => 'profileo',
			'USER' => 'usero',
			'FEEDBACK' => 'feedbacko',
			'PARISH' => 'parisho',
			'HARVESTPAD_USER' => 'oharvestpad_usero',
		],
	],
];





//*----------- PATREVO DB -----------*//
$SETTING['PATREVO'] = [
	'DATABASE' => [
		'NAME' => $SETTING['DATABASE']['NAME'],
		'USER' => $SETTING['DATABASE']['USER'],
		'PASSWORD' => $SETTING['DATABASE']['PASSWORD'],
		'TABLE' => [
			'CUPID' => 'opatrevo_cupido',
			'SWIPE' => 'opatrevo_swipeo',
		],
	],
];