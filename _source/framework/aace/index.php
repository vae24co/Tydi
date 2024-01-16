<?php
/*** Index ~ Entry Point » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

// + DEFINITION
const FRAMEWORK = 'Tydi';
const SYS = 'online';
const ENV = 'development';



// + SYSTEM REGULARIZATION
if (SYS === 'offline') {
	exit('Project is offline!');
}



// + CORE FILE
$core = 'core.php';



// + TRIGGER ERROR • If core file is not found
if (!is_file($core)) {
	$error = '<strong>' . FRAMEWORK . '™</strong> • Core Unavailable!';
	if (ENV === 'production') {
		$extra = $core;
	} elseif (ENV === 'staging') {
		$extra = DIRECTORY_SEPARATOR . $core;
	} elseif (ENV === 'development') {
		$extra = __DIR__ . DIRECTORY_SEPARATOR . $core;
	}
	exit($error . ' <em>(' . $extra . ')</em>');
}



// + LOAD CORE
require $core;
?>