<?php
//*** Config - Configuration » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
const MD = [
	'LIBRY' => RD . 'libry' . DS,
	'ORIG' => RD . 'orig' . DS
];
const MACHINE = 'LOCAL'; #LOCAL|LIVE
const ENV = 'DEVELOPMENT'; #DEVELOPMENT|STAGING|PRODUCTION
const SYS = 'ONLINE';
const HOSTNAME = 'tydi.co';
$zero = ['ZERO' => HOSTNAME];
$hosts = [
	'JORE' => 'jore.co',
	'CANTEEN' => 'canteen.co',
	'LESL' => 'lesl.co',
	'HAULAGE' => 'haulage.co'
];
define('HOST', array_merge($zero, $hosts));