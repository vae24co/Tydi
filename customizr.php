<?php //*** Customizr » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • Customization
defined('FRAMEWORK') || define('FRAMEWORK', 'Tydi');
defined('PS') || define('PS', '/');
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('RD') || define('RD', __DIR__ . DS);

defined('SYSTEM') || define('SYSTEM', 'ONLINE'); # [ONLINE|OFFLINE]
defined('ENVIRONMENT') || define('ENVIRONMENT', 'DEVELOPMENT'); # [DEVELOPMENT|STAGING|PRODUCTION]
defined('MACHINE') || define('MACHINE', 'LOCAL'); # [LOCAL|REMOTE]

defined('LIBRY') || define('LIBRY', RD . 'libry' . DS);
defined('ORIG') || define('ORIG', RD . 'orig' . DS);


// • Clean String
const CS = ['@<script[^>]*?>.*?</script>@si', '@<[\ /\!]*?[^<>]*?>@si', '@<style[^>]*?>.*?</style>@siU', '@<![\s\S]*?--[ \t\n\r]*>@'];


// • If System Offline or Undefined
if (!defined('SYSTEM') || SYSTEM === 'OFFLINE') {
	exit('<strong>' . FRAMEWORK . '™</strong> • OFFLINE → [<em>The project is offline!</em>]');
}


// • Include Loader
$file = LIBRY . 'loader.php';
if (!is_file($file)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • LoaderX Unavailable! → [<em>' . $file . '</em>]';
	exit($error);
}
include $file;


// • Autoloader (Initialize & Load files for Libry & Orig)
LoaderX::init();

$namespaces = [
	'libry' => LIBRY,
	'orig' => ORIG,
];

foreach ($namespaces as $namespace) {
	$namespace .= 'namespace.php';
	if (is_file($namespace)) {
		$map = include $namespace;
		LoaderX::map($map);
	}
}


if (is_file(RD . 'dev.php')) {
	include RD . 'dev.php';
}