<?php //*** Index - The entry point » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// ◇ Initialization
const TYDI = 'Tydi';
const PS = '/';
const DS = DIRECTORY_SEPARATOR;
const RD = __DIR__ . DS;

define('SYSTEM', 'ONLINE');

// ◇ Core
$core = RD . 'core.php';
if (!is_file($core)) {
	exit('<strong>' . TYDI . '™</strong> • Core Unavailable! → [<em>' . $core . '</em>]');
}
require $core;