<?php
/*** AACE ~ Fusion » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

// ~ ERROR CHECK
if (VarX::isNot($base)) {
	ErrorX::is('FUSION', 'Base is required');
} elseif (VarX::isNot($base->domain)) {
	ErrorX::is('FUSION', 'Base domain is required');
}



// ~ INITIALIZE
$initialize['source'] = Folder::name(__DIR__);



// ~ VERSION & ENVIRONMENT
$platform = strtoupper(Route::platform());
$uri = Route::uri('IS');
$initialize['version'] = 'oreo';

if ($platform === 'API') {

	// ... Production
	$initialize['version'] = 'onion';
	Env::$machine = 'production';

	// ... Staging
	if (StringX::contain($uri, '/stage/')) {
		$initialize['version'] = 'stage';
		Env::$machine = 'staging';
	}

	// ... Development
	if (StringX::contain($uri, '/oreo/')) {
		Env::$machine = 'development';
	}
}