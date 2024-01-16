<?php
/*** AACE ~ Router » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

$init = [];
$config = Env::property('config');



// ~ Routing::API
if (Route::isAPI()) {
	SetQ::isKeyNotEmptyCopy($config, $init, 'project');
	SetQ::isKeyNotEmptyCopy($config, $init, 'timezone');
	SetQ::isKeyNotEmptyCopy($config, $init, 'routes');
	SetQ::isKeyNotEmptyCopy($config, $init, 'view');
	$api = new API();
	$api::initialize($init);
	$api::ignite();
	$api::terminate();
}



// ~ Routing::App
elseif (Route::isAPP()) {
	SetQ::isKeyNotEmptyCopy($config, $init, 'project');
	SetQ::isKeyNotEmptyCopy($config, $init, 'timezone');
	$app = new App();
	$app::initialize($init);
	$app::ignite();
	$app::terminate();
}



// ~ Routing::Site
elseif (Route::isSite()) {
	$init = array_merge($init, ['langpath' => false, 'spet' => false]);
	SetQ::isKeyNotEmptyCopy($config, $init, 'project');
	SetQ::isKeyNotEmptyCopy($config, $init, 'timezone');
	$site = new Site();
	$site::initialize($init);
	$site::toWWW();
	$site::launch();
	$site::terminate();
}