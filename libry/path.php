<?php //*** Path » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

$BACKEND = ORIG . 'backend' . DS;
$FRONTEND = ORIG . 'frontend' . DS;
$STORAGE = ORIG . 'source' . DS . 'upload' . DS;
$CLOUD = PS . 'cloud' . PS;

$PATH = [
	'BACKEND' => [
		'CONTROL' => $FRONTEND . 'controlizr' . DS,
		'MODEL' => $FRONTEND . 'modelizr' . DS,
		'ORGAN' => $FRONTEND . 'organizr' . DS,
		'ROUT' => $FRONTEND . 'routz' . DS,
		'UTIL' => $FRONTEND . 'utilizr' . DS
	],

	'FRONTEND' => [
		'LAYOUT' => $FRONTEND . 'layout' . DS,
		'SLICE' => $FRONTEND . 'slicezr' . DS,
		'VIEW' => $FRONTEND . 'viewzr' . DS
	],

	'STORAGE' => [
		'AUDIO' => $STORAGE . 'audio' . DS,
		'DOCUMENT' => $STORAGE . 'document' . DS,
		'IMAGE' => $STORAGE . 'image' . DS,
		'VIDEO' => $STORAGE . 'video' . DS
	],

	'ASSET' => [
		'ASSET' => PS . 'asset' . PS,
		'CSS' => PS . 'css' . PS,
		'JS' => PS . 'js' . PS,
		'MEDIA' => PS . 'media' . PS
	],

	'CLOUD' => [
		'CLOUD' => $CLOUD,
		'AUDIO' => $CLOUD . 'audio' . PS,
		'DOCUMENT' => $CLOUD . 'document' . PS,
		'IMAGE' => $CLOUD . 'image' . PS,
		'VIDEO' => $CLOUD . 'video' . PS
	],
];

defined('PATH') || define('PATH', $PATH);