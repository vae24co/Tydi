<?php //*** Customizr » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • Customization
defined('FRAMEWORK') || define('FRAMEWORK', 'Tydi');
defined('PS') || define('PS', '/');
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('RD') || define('RD', __DIR__ . DS);

defined('SYSTEM') || define('SYSTEM', 'ONLINE'); # [ONLINE|OFFLINE]
defined('ENVIRONMENT') || define('ENVIRONMENT', 'DEVELOPMENT'); # [DEVELOPMENT|STAGING|PRODUCTION]
defined('MACHINE') || define('MACHINE', 'LOCAL'); # [LOCAL|REMOTE]


// • Load Initial Files
$files = ['path'];
$path = RD . 'libry' . DS . 'initial' . DS;
foreach ($files as $file) {
	$file = $path . $file . '.php';
	if (!is_file($file)) {
		$error = '<strong>' . FRAMEWORK . '™</strong> • File Unavailable! → [<em>' . $file . '</em>]';
		exit($error);
	}
	include $file;
}