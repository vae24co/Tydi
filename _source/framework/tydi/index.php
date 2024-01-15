<?php
//*** Index - Entry » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
const TYDI = 'Tydi';
const DS = DIRECTORY_SEPARATOR;
const RD = __DIR__ . DS;
const PS = '/';


// • require config file
$file = RD . 'config.php';
if (is_file($file)) {
	require $file;
} else {
	$e = '<strong>' . TYDI . '™</strong> | Config • File Unavailable! → [<em>' . $file . '</em>]';
	exit($e);
}


// • require core file
$file = 'core.php';
if (is_file(MD['LIBRY'] . $file)) {
	require MD['LIBRY'] . $file;
} else {
	$e = '<strong>' . TYDI . '™</strong> | Core • File Unavailable!';
	if (defined('ENV')) {
		if (ENV === 'STAGING') {
			$core = DS . $file;
		} elseif (ENV === 'DEVELOPMENT') {
			$core = MD['LIBRY'] . $file;
		}
		$e .= ' → [<em>' . $core . '</em>]';
	}
	exit($e);
}
?>