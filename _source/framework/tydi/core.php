<?php
//*** Core - The Core » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • SYSTEM [offline | online]
if (defined('SYS') && SYS === 'OFFLINE') {
	exit('<p><strong>' . TYDI . '™</strong> • OFFLINE → <em>The project is offline!</em></p>');
}


// • CLEAN - constant for clean string
const CLEAN_STRING = [
	#Strip out JS
	'@<script[^>]*?>.*?</script>@si',

	#Strip out HTML tags
	'@<[\ /\!]*?[^<>]*?>@si',

	#Strip style tags properly
	'@<style[^>]*?>.*?</style>@siU',

	#Strip multi-line comments
	'@<![\s\S]*?--[ \t\n\r]*>@'
];


// • DIRECTORY
const LIBRY = [
	'CRUCIAL' => MD['LIBRY'] . 'collection' . DS . 'crucial' . DS,
	'SPRY' => MD['LIBRY'] . 'collection' . DS . 'spry' . DS,

	'ABSTRACT' => MD['LIBRY'] . 'concept' . DS . 'abstract' . DS,
	'INTERFACE' => MD['LIBRY'] . 'concept' . DS . 'interface' . DS,
	'TRAIT' => MD['LIBRY'] . 'concept' . DS . 'trait' . DS,
	'ESSENTIAL' => MD['LIBRY'] . 'collection' . DS . 'essential' . DS,
	'INITIAL' => MD['LIBRY'] . 'collection' . DS . 'initial' . DS,
	'INSTANCE' => MD['LIBRY'] . 'helper' . DS . 'instance' . DS,
	'ROUTE' => MD['LIBRY'] . 'helper' . DS . 'route' . DS,
	'VENDOR' => MD['LIBRY'] . 'vendor' . DS
];


// • PATH
const PATH = [
	'js' => PS . 'js' . PS,
	'css' => PS . 'css' . PS,
	'xhr' => PS . 'xhr' . PS,
	'ario' => PS . 'ario' . PS,
	'font' => PS . 'font' . PS,
	'audio' => PS . 'audio' . PS,
	'image' => PS . 'image' . PS,
	'video' => PS . 'video' . PS,
	'cloud' => PS . 'cloud' . PS,
	'redirect' => PS . 'redirect' . PS
];


// • LIBRARY - Crucial, Initial, Other Files & Autoload
$files = scandir(LIBRY['CRUCIAL']);
foreach ($files as $file) {
	if ($file !== '.' && $file !== '..') {
		if (is_file(LIBRY['CRUCIAL'] . $file)) {
			require_once LIBRY['CRUCIAL'] . $file;
		}
	}
}

$files = ['autoload', 'session', 'env', 'vars', 'customize'];
LoaderX::directoryFile(LIBRY['INITIAL'], $files);
if (function_exists('Autoload')) {
	spl_autoload_register('Autoload');
}
LoaderX::directoryFile(LIBRY['ESSENTIAL']);


// • FUSE - Project Directory
FuseX::ignite();
if (!defined('PD')) {
	define('PD', FuseX::getPD());
}
const ORIG = [
	'ARIO' => PD . 'ario' . DS,
	'CONTROL' => PD . 'build' . DS . 'controlizr' . DS,
	'MODEL' => PD . 'build' . DS . 'modelizr' . DS,
	'ORGAN' => PD . 'build' . DS . 'organizr' . DS,
	'API' => PD . 'build' . DS . 'apizr' . DS,
	'APP' => PD . 'build' . DS . 'appzr' . DS,
	'UTIL' => PD . 'build' . DS . 'utilizr' . DS,
	'CLOUD' => PD . 'cloud' . DS,
	'LAYOUT' => PD . 'design' . DS . 'layoutzr' . DS,
	'XHR' => PD . 'design' . DS . 'xhrzr' . DS,
	'PAGE' => PD . 'design' . DS . 'pagezr' . DS,
	'SLICE' => PD . 'design' . DS . 'slicezr' . DS,
	'BIT' => PD . 'design' . DS . 'bitzr' . DS,
	'PIECE' => PD . 'design' . DS . 'piecezr' . DS,
	'FORM' => PD . 'design' . DS . 'formzr' . DS,
	'CHUNK' => PD . 'design' . DS . 'chunkzr' . DS,
	'TABLE' => PD . 'design' . DS . 'tablezr' . DS,
	'VIEW' => PD . 'design' . DS . 'viewzr' . DS,
	'INIT' => PD . 'engine' . DS . 'initzr' . DS,
	'ROUT' => PD . 'engine' . DS . 'routzr' . DS,
	'SET' => PD . 'engine' . DS . 'setzr' . DS
];


// • PHP - Minimum Required
Env::php('8.0');


// • SESSION
$Session = new Session;
$Session->start();


// • ERROR REPORTING
if (Env::isProduction()) {
	error_reporting(0);
}


// • TIMEZONE
Env::setTimezone();


// • REDIRECT - HTTP Triggered
RedirectX::http();



// • CUSTOMIZE - Project Settings & Customization
CustomizeX();

UtilizrX::jomo()::name();

// // ◇ ENFORCE SSL
// ServerX::secure();


// // ◇ ROUTER
// Route::routzr();



// • PLAYGROUND (for development environment, only)
Env::playground();


// $ro = Link::setPlatform();
// DebugX($ro);