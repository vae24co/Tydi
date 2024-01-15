<?php
//*** CustomizeX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
function CustomizeX() {

	// • Load custom settings
	FileX('setting.php', ORIG['INIT']);


	$env = strtolower(Env::getEnvAbbr());
	$platform = strtolower(Link::getPlatform());

	// • Load custom platform environment (optional)
	FileX::append(ORIG['INIT'] . 'platform' . DS . $platform . '.php');


	// • Load custom machine environment
	$machine = strtolower(Env::getMachine());
	$path = ORIG['INIT'] . 'machine' . DS;
	$file = $path . $machine . DS . strtolower($env) . '.php';
	if (!is_file($file)) {
		$file = $path . strtolower($env) . '.php';
	}
	if (!is_file($file)) {
		$file = $path . $machine . '.php';
	}
	FileX::load($file);


	// • Load custom setup files
	LoaderX::directoryFile(ORIG['SET']);


	// • Customize Utilizr - for project custom utilizr
	UtilizrX::customizr();

	return true;
}