<?php
/*** AACE ~ API Development Configuration » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

// • View
$config['view'] = 'JSON';



// • Routes
$config['routes'] = [
	'oreo' => [
		'index',
		'error',
		'ping' => PING_API_ROUTES,
		'aace' => API_ROUTES
	]
];



// • Append Config
Env::config($config);



// • CORS Domain Allowed
const CORS = '*';