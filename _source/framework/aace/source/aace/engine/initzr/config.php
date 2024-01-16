<?php
/* AACE ~ Custom Configuration » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

// • Timezone
$config['timezone'] = 'Africa/Lagos';



// • Project
$config['project'] = [
	'title' => 'Aace Plus',
	'brand' => 'AACE™',
	'copyright' => '© January ' . date('Y'),
	'version' => "alpha-0.0.23",
	'email' => 'hello@aaceplus.com',
	'url' => "https://www.aaceplus.com",
	'support' => [
		'email' => 'help@aaceplus.com',
		'phone' => '2347061439834'
	],
	'author' => [
		'name' => "Anthony Osawere",
		'brand' => "AO™ • @iamodao",
		'email' => 'anthony@osawere.com',
		'url' => "https://www.osawere.com",
		'phone' => '2349026636728'
	]
];



// • Define Token Timeout
const TOKEN_TIMEOUT = '+10 minutes';



// • Database
$config['database'] = [
	'aace' => [
		'driver' => 'PDO',
		'type' => 'SQL',
		'persist' => false,
		'tables' => [
			'auth' => 'auth',
			'error' => 'error',
			'key' => 'key',
			'profile' => 'profile',
			'saas' => 'saas',
			'token' => 'token',
			'http' => 'http',
			'hmo' => 'hmo',
			'medicine' => 'medicine',
		]
	]
];



// • Append Config
Env::config($config);



// • API Routes
const PING_API_ROUTES = ['forbidden', 'error', 'failure', 'success', 'author', 'project', 'list'];