<?php //*** Index » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// ◇ Customization
const FRAMEWORK = 'Tydi';
const ENVIRONMENT = 'DEVELOPMENT';
const MACHINE = 'LOCAL';
const SYSTEM = 'ONLINE';


// ◇ Load Customizr
$file = 'customizr.php';
if (!is_file($file)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • Customizr Unavailable! → [<em>' . $file . '</em>]';
	exit($error);
}

include $file;