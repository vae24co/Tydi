<?php //*** Customizr » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • Customization
defined('FRAMEWORK') || define('FRAMEWORK', 'Tydi');
defined('PS') || define('PS', '/');
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('RD') || define('RD', __DIR__ . DS);

defined('SYSTEM') || define('SYSTEM', 'ONLINE'); # [ONLINE|OFFLINE]
defined('ENVIRONMENT') || define('ENVIRONMENT', 'DEVELOPMENT'); # [DEVELOPMENT|STAGING|PRODUCTION]
defined('MACHINE') || define('MACHINE', 'LOCAL'); # [LOCAL|REMOTE]


// • Clean String
const CS = ['@<script[^>]*?>.*?</script>@si', '@<[\ /\!]*?[^<>]*?>@si', '@<style[^>]*?>.*?</style>@siU', '@<![\s\S]*?--[ \t\n\r]*>@'];


// • If System Offline or Undefined
if (!defined('SYSTEM') || SYSTEM === 'OFFLINE') {
	exit('<strong>' . FRAMEWORK . '™</strong> • OFFLINE → [<em>The project is offline!</em>]');
}


// • Include Tydi Framework
$file = RD . 'libry' . DS . 'tydi.php';
if (!is_file($file)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • File Unavailable! → [<em>' . $file . '</em>]';
	exit($error);
}
include $file;


// • Include Initial Files
$files = ['path', 'string', 'env', 'session', 'autoload'];
$path = RD . 'libry' . DS . 'initial' . DS;
Tydi::inc($files, $path);



// • Autoload
if (function_exists('Autoload')) {
	spl_autoload_register('Autoload');
}


// • PHP - Minimum Required
Env::php('8.0');


// • Session
$Session = new Session;
$Session->start();


// • Error Reporting
if (Env::isProduction()) {
	error_reporting(0);
}