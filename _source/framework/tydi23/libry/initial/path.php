<?php //*** Path » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// • Directory & Path
$LIBRY = RD . 'libry' . DS;
$ORIG = RD . 'orig' . DS;
$ASSET = PS . 'asset' . PS;

$BACKEND = $ORIG . 'backend' . DS;
$FRONTEND = $ORIG . 'frontend' . DS;

$PATH = [
	'LIBRY' => $LIBRY,
	'ORIG' => $ORIG,

	'CRUCIAL' => $LIBRY . 'crucial' . DS,
	'HELPER' => $LIBRY . 'helper' . DS,

	'BACKEND' => [
		'O' => $BACKEND,
	],

	'FRONTEND' => [
		'O' => $FRONTEND,
		'LAYOUT' => $FRONTEND . 'layout' . DS,
		'PIECE' => $FRONTEND . 'piece' . DS,
		'VIEW' => $FRONTEND . 'view' . DS
	],

	'ASSET' => [
		'O' => $ASSET,
	]
];

defined('PATH') || define('PATH', $PATH);