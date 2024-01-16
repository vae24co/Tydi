<?php
/*** Core ~ The Core » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

// + SEPARATOR
const PS = '/';
const DS = DIRECTORY_SEPARATOR;



// + DIRECTORY
const RD = __DIR__ . DS;
define("FD", RD . strtolower(FRAMEWORK) . DS);
const LIBRARY = [
	'abstract' => FD . 'library' . DS . 'abstract' . DS,
	'essential' => FD . 'library' . DS . 'essential' . DS,
	'helper' => FD . 'library' . DS . 'helper' . DS,
	'interface' => FD . 'library' . DS . 'interface' . DS,
	'object' => FD . 'library' . DS . 'object' . DS,
	'plugin' => FD . 'library' . DS . 'plugin' . DS,
	'spry' => FD . 'library' . DS . 'spry' . DS,
	'trait' => FD . 'library' . DS . 'trait' . DS
];
const SD = RD . 'source' . DS;
const VENDOR = [
	'vendor' => FD . 'vendor' . DS,
	'brux' => FD . 'vendor' . DS . 'brux' . DS
];



// + PATH
const PATH = [
	'ario' => PS . 'ario' . PS,
	'css' => PS . 'css' . PS,
	'font' => PS . 'font' . PS,
	'js' => PS . 'js' . PS,
	'audio' => PS . 'audio' . PS,
	'document' => PS . 'document' . PS,
	'image' => PS . 'image' . PS,
	'video' => PS . 'video' . PS,
	'cloud' => PS . 'cloud' . PS,
	'redirect' => PS . 'redirect' . PS,
];



// + LIBRARY
require LIBRARY['spry'] . 'autoload.php';
require LIBRARY['spry'] . 'clean.php';
require LIBRARY['spry'] . 'env.php';
require LIBRARY['spry'] . 'var.php';
Env::essential();
Env::extendable('trait');
Env::extendable('abstract');
Env::extendable('interface');



// + PHP • Minimum Required
Env::php('7.4');



// + ERROR REPORTING & HTTP HANDLING
if (Env::is('PROD')) {
	error_reporting(0);
	HTTP::errorInit('HTML');
} elseif (Env::is('STAG')) {
	HTTP::errorInit('PRINT');
} elseif (Env::is('DEV')) {
	HTTP::errorInit('RAW');
}



// + REDIRECT • HTTP Initiated
HTTP::redirect();



// + SESSION
$Session = new Session;
$Session->start();



// + FUSION
Link::initialize();
$base = Link::property('base');
$uri = Link::property('uri');
$initialize = [];
$env = RD . 'env.php';
if (File::isNot($env)) {
	$env = RD . 'env' . DS . strtolower(Env::is('ABBR')) . '.php';
}
if (File::check($env)) {
	require $env;
	if (VarX::hasData($fusion) && File::check($fusion)) {
		require $fusion;
	}
}



// + ROUTER
Route::initialize($initialize);



// + DIRECTORY • Project
if (!defined('PD')) {
	$source = 'zero' . DS;
	if (!empty(Route::property('source'))) {
		$source = Route::property('source') . DS;
	}
	define('PD', SD . $source);
}
const SOURCE = [
	'ario' => PD . 'ario' . DS,

	'api' => PD . 'build' . DS . 'apizr' . DS,
	'app' => PD . 'build' . DS . 'appzr' . DS,
	'control' => PD . 'build' . DS . 'controlizr' . DS,
	'dispatch' => PD . 'build' . DS . 'dispatchzr' . DS,
	'model' => PD . 'build' . DS . 'modelizr' . DS,
	'organ' => PD . 'build' . DS . 'organizr' . DS,
	'util' => PD . 'build' . DS . 'utilizr' . DS,

	'cloud' => PD . 'cloud' . DS,

	'layout' => PD . 'design' . DS . 'layoutzr' . DS,
	'page' => PD . 'design' . DS . 'pagezr' . DS,
	'form' => PD . 'design' . DS . 'formzr' . DS,
	'table' => PD . 'design' . DS . 'tablezr' . DS,
	'slice' => PD . 'design' . DS . 'slicezr' . DS,
	'view' => PD . 'design' . DS . 'viewzr' . DS,

	'init' => PD . 'engine' . DS . 'initzr' . DS,
	'rout' => PD . 'engine' . DS . 'routzr' . DS,
	'setzr' => PD . 'engine' . DS . 'setzr' . DS
];



// + AUTOLOAD
Env::autoload();



// + ENFORCE SSL
Env::secure();



// + SETTINGS
$env = strtolower(Env::is('ABBR'));
$platform = Link::platform();
File::load(SOURCE['init'] . 'routes.php', 'routes config');
File::load(SOURCE['init'] . 'config.php', 'custom config');
File::append(SOURCE['init'] . $env . DS . 'env.php');
File::append(SOURCE['init'] . $platform . '.php');
File::append(SOURCE['init'] . $env . DS . $platform . '.php');



// + TIMEZONE
Env::Timezone();



// + ROUTER
Route::routzr();



// + PLAYBOX • Development Only
Env::playbox();