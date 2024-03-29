<?php //*** Customizr » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • Customization
defined('FRAMEWORK') || define('FRAMEWORK', 'Tydi');
defined('PS') || define('PS', '/');
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('RD') || define('RD', __DIR__ . DS);

defined('SYSTEM') || define('SYSTEM', 'ONLINE'); # [ONLINE|OFFLINE]
defined('ENVIRONMENT') || define('ENVIRONMENT', 'DEVELOPMENT'); # [DEVELOPMENT|STAGING|PRODUCTION]
defined('MACHINE') || define('MACHINE', 'LOCAL'); # [LOCAL|REMOTE]


// • Clean String
const CS = ['@<script[^>]*?>.*?</script>@si', '@<[\ /\!]*?[^<>]*?>@si', '@<style[^>]*?>.*?</style>@siU', '@
		<![\s\S]*?--[ \t\n\r]*>@'];


// • Directory
$ORIG = RD . 'orig' . DS;
$LIBRY = RD . 'libry' . DS;
$LIBRY = [
	'INIT' => $LIBRY . 'init' . DS,
	'OBJ' => $LIBRY . 'obj' . DS,
	'SPRY' => $LIBRY . 'spry' . DS
];

defined('LIBRY') || define('LIBRY', $LIBRY);


// • Autoloader (LoaderX)
$file = LIBRY['INIT'] . 'loader.php';
if (!is_file($file)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • LoaderX Unavailable! → [<em>' . $file . '</em>]';
	exit($error);
}
require $file;
LoaderX::init();
$file = LIBRY['INIT'] . 'namespace.php';
if (is_file($file)) {
	$map = require $file;
	LoaderX::map($map);
}


// • Custom Directory & Path
$BACKEND = 'backend' . DS;
$FRONTEND = 'frontend' . DS;
$PAGE = $FRONTEND . 'pagezr' . DS;
$STORAGE = 'source' . DS . 'upload' . DS;
$CLOUD = PS . 'cloud' . PS;

$PATH = [
	'BACKEND' => [
		'CONTROL' => $BACKEND . 'controlizr' . DS,
		'MODEL' => $BACKEND . 'modelizr' . DS,
		'ORGAN' => $BACKEND . 'organizr' . DS,
		'ROUT' => $BACKEND . 'routzr' . DS,
		'UTIL' => $BACKEND . 'utilizr' . DS
	],

	'FRONTEND' => [
		'LAYOUT' => $FRONTEND . 'layout' . DS,
		'PAGE' => $PAGE,
		'VIEW' => $PAGE . 'viewzr' . DS,
		'FORM' => $PAGE . 'formzr' . DS,
		'SLICE' => $FRONTEND . 'slicezr' . DS
	],

	'STORAGE' => [
		'AUDIO' => $STORAGE . 'audio' . DS,
		'DOCUMENT' => $STORAGE . 'document' . DS,
		'IMAGE' => $STORAGE . 'image' . DS,
		'VIDEO' => $STORAGE . 'video' . DS
	],

	'ASSET' => [
		'ASSET' => PS . 'asset' . PS,
		'CSS' => PS . 'css' . PS,
		'JS' => PS . 'js' . PS,
		'MEDIA' => PS . 'media' . PS,
		'ICON' => PS . 'icon' . PS,
		'PLUGIN' => PS . 'plugin' . PS
	],

	'CLOUD' => [
		'CLOUD' => $CLOUD,
		'AUDIO' => $CLOUD . 'audio' . PS,
		'DOCUMENT' => $CLOUD . 'document' . PS,
		'IMAGE' => $CLOUD . 'image' . PS,
		'VIDEO' => $CLOUD . 'video' . PS
	],
];

defined('PATH') || define('PATH', $PATH);


// • If System Offline or Undefined
if (!defined('SYSTEM') || SYSTEM === 'OFFLINE') {
	exit('<strong>' . FRAMEWORK . '™</strong> • OFFLINE → [<em>The project is offline!</em>]');
}



// • AutoloadX
$autoload = LIBRY['INIT'] . 'autoload.php';
if (is_file($autoload)) {
	require $autoload;
	if (function_exists('AutoloadX')) {
		spl_autoload_register('AutoloadX');
	}
}


// • Initialize Path
PathX::init(['ORIG' => $ORIG]);


// • Load Environment
$env = PathX::env('app');
EnvX::load($env);
EnvX::init();


// • Load Router
$file = PathX::routzr('app');
require $file;




// • Load Debugger
PathX::load('DEBUG');
// TODO: Implement Fusion to Determine ORIG Directory
// TODO: Implement File Loader with Framework Error