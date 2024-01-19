<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* CORE ~ The Core • VERSION » alpha-0.0.7 ***/

//*----------- PHP VERSION -----------*//
$phpversion = floatval(phpversion());
if($phpversion < 7.4){
	exit('<strong>PHP • Version Unsupported</strong> (<em>'.$phpversion.'</em>)');
}





//*----------- SEPARATOR -----------*//
const PS = '/';
const DS = DIRECTORY_SEPARATOR;





//*----------- DIRECTORY -----------*//
const RD = __DIR__.DS;
const ASSET = RD.'asset'.DS;
const BUILD = RD.'build'.DS;
const CLOUD = RD.'cloud'.DS;
const ZERO = [
	'HELPER' => RD.'zero'.DS.'class'.DS.'helper'.DS,
	'OBJ' => RD.'zero'.DS.'class'.DS.'object'.DS,
	'SPRY' => RD.'zero'.DS.'class'.DS.'spry'.DS,
	'INTERFACE' => RD.'zero'.DS.'class'.DS.'interface'.DS,
	'FUNC' => RD.'zero'.DS.'function'.DS,
	'VENDOR' => RD.'zero'.DS.'vendor'.DS
];





//*----------- PATH -----------*//
const PATH = [
	'ASSET' => PS.'asset'.PS,
	'CLOUD' => PS.'cloud'.PS,
	'CSS' => PS.'css'.PS,
	'JS' => PS.'js'.PS,
	'ICON' => PS.'icon'.PS,
	'MEDIA' => PS.'media'.PS,
	'PLUGIN' => PS.'plugin'.PS,
	'REDIRECT' => PS.'redirect'.PS,
];





//*----------- AUTOLOAD FUNCTION LIBRARY -----------*//
if(is_dir(ZERO['FUNC'])){
	$function = scandir(ZERO['FUNC'], 1);
	if(in_array('.', $function)){
		$index = array_search('.', $function);
		unset($function[$index]);
	}
	if(in_array('..', $function)){
		$index = array_search('..', $function);
		unset($function[$index]);
	}
	foreach ($function as $file){
		if(is_file(ZERO['FUNC'].$file) && file_exists(ZERO['FUNC'].$file)){
			require ZERO['FUNC'].$file;
		}
	}
}





//*----------- AUTOLOAD INTERFACE/ABSTRACT -----------*//
if(is_dir(ZERO['INTERFACE'])){
	$interface = scandir(ZERO['INTERFACE'], 1);
	if(in_array('.', $interface)){
		$index = array_search('.', $interface);
		unset($interface[$index]);
	}
	if(in_array('..', $interface)){
		$index = array_search('..', $interface);
		unset($interface[$index]);
	}
	foreach ($interface as $file){
		if(is_file(ZERO['INTERFACE'].$file) && file_exists(ZERO['INTERFACE'].$file)){
			require ZERO['INTERFACE'].$file;
		}
	}
}





//*----------- AUTOLOAD CLASS LIBRARY -----------*//
oFuncX('oLoadX', ZERO['FUNC'].'load.inc');
spl_autoload_register('oLoadX');





//*----------- CUSTOMIZATION -----------*//
RouteX::initialize();

if(!defined('PROJECT')){
	define('PROJECT', BUILD.RouteX::get('SOURCE').DS);
}

const LAYOUT = PROJECT.'layout'.DS;
const ARCZR = LAYOUT.'arczr'.DS;
const BITZR = LAYOUT.'bitzr'.DS;
const OUTLINZR = LAYOUT.'outlinzr'.DS;
const SLICEZR = LAYOUT.'slicezr'.DS;
const VIEWZR = LAYOUT.'viewzr'.DS;
const APP_VIEWZR = VIEWZR.'app'.DS;

const PROGRAM = PROJECT.'program'.DS;
const CONTROLIZR = PROGRAM.'controlizr'.DS;
const MODELIZR = PROGRAM.'modelizr'.DS;
const ORGANIZR = PROGRAM.'organizr'.DS;
const APIZR = ORGANIZR.'api'.DS;
const APPZR = ORGANIZR.'app'.DS;
const UTILIZR = PROGRAM.'utilizr'.DS;

const SETUP = PROJECT.'setup'.DS;
const INITZR = SETUP.'initzr'.DS;
const SETZR = SETUP.'setzr'.DS;
const ROUTZR = SETUP.'routzr'.DS;





//*----------- LOAD CUSTOM SETTINGS -----------*//
if(oFileX(INITZR.'config.inc', 'INITZR', 'REPORT')){require INITZR.'config.inc';}
if(file_exists(INITZR.'env.dev.inc')){require INITZR.'env.dev.inc';}
elseif(file_exists(INITZR.'env.inc')){require INITZR.'env.inc';}
else {oFileX(INITZR.'env.inc', 'ENVZR', 'REPORT');}

$setzr = SETZR.RouteX::get('ROUTZR').'.inc';
if(file_exists($setzr)){require $setzr;}

if(!empty($SETTING)){define('SETTING', $SETTING);} else {define('SETTING', []);}





//*----------- ERROR_REPORTING -----------*//
if(!oEnvX('DEV')){error_reporting(0);}





//*----------- SESSION -----------*//
$oSession = new oSession;
$oSession->start();
if(empty(SETTING['TIMEZONE'])){TimeX::zone();} else {TimeX::zone(SETTING['TIMEZONE']);}





//*----------- ROUTER -----------*//
$routzr = ROUTZR.RouteX::get('ROUTZR').'.inc';
if(oFileX($routzr, 'ROUTZR', 'REPORT')){
	require $routzr;
}