<?php //*** Core - The core handler » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • INITIALIZATION
defined('TYDI') || define('TYDI', 'Tydi');
defined('PS') || define('PS', '/');
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('RD') || define('RD', __DIR__ . DS);

$LIBRY = RD . 'libry' . DS;
$ORIG = RD . 'orig' . DS;
$ASSET = PS . 'asset' . PS;

$PATH = [
	'LIBRY' => $LIBRY,
	'ORIG' => $ORIG,

	'ASSET' => [
		'O' => $ASSET,
	]
];

defined('PATH') || define('PATH', $PATH);

// • SYSTEM [maintenance | offline | online]
if (defined('SYSTEM') && SYSTEM === 'OFFLINE') {
	exit('<strong>' . TYDI . '™</strong> • OFFLINE → [<em>The project is offline!</em>]');
}

// • CLEAN - constant for clean string
const CS = ['@<script[^>]*?>.*?</script>@si', '@<[\ /\!]*?[^<>]*?>@si', '@<style[^>]*?>.*?</style>@siU', '@<![\s\S]*?--[ \t\n\r]*>@'];

// • TYDI - load tydi class
$tydi = PATH['LIBRY'] . 'tydi.php';
if (!is_file($tydi)) {
	exit('<strong>' . TYDI . '™</strong> • Tydi Unavailable! → [<em>' . $tydi . '</em>]');
}
require_once $tydi;