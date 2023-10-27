<?php //*** Index - The entry point » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// ◇ Customization
const FRAMEWORK = 'Tydi';
const SYSTEM = 'ONLINE';
const ENVIRONMENT = 'DEVELOPMENT';
const MACHINE = 'LOCAL';


// ◇ Load Customizr
$file = 'customizr.php';
if (!is_file($file)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • Customizr Unavailable! → [<em>' . $file . '</em>]';
	exit($error);
}

include $file;
?>