<?php
/*** Routes ~ Route Configuration » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

// • API Routes
$APIDispatch = SOURCE['dispatch'] . 'api.php';
if (File::is($APIDispatch)) {
	define("API_ROUTES", require($APIDispatch));
}
else {
	define("API_ROUTES", []);
}



// • APP Routes
$APPDispatch = SOURCE['dispatch'] . 'app.php';
if (File::is($APPDispatch)) {
	define("APP_ROUTES", require($APPDispatch));
}
else {
	define("APP_ROUTES", []);
}