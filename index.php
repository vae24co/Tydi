<?php //*** Index - The entry point » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// ◇ Customization
const FRAMEWORK = 'Tydi';
const SYSTEM = 'ONLINE';
const ENVIRONMENT = 'DEVELOPMENT';
const MACHINE = 'LOCAL';


// ◇ Load Customizr
$customizr = 'customizr.php';
if (!is_file($customizr)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • Customizr Unavailable! → [<em>' . $customizr . '</em>]';
	exit($error);
}

include $customizr;
?>