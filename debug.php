<?php //*** Debugger » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

// RouteX::any('/contact', function () {
// Load the 'contact' view directly
// include_once __DIR__ . '/views/contact.php';
// });

// RouteX::post('/home', function () {
// });

// RouteX::get('/home', function () {
// });

// RouteX::any('/homes', function () {
// });




// RouteX::get('/', function () {
// 	echo 'Index';
// });
// RouteX::post('/home', function () {
// 	echo 'Home! POST';
// });

// RouteX::get('/home', function () {
// 	echo 'Home!';
// });

// RouteX::get('/bio', function () {
// 	echo 'Biography!';
// });

// RouteX::any('/contact', 'User::name');

RouteX::get('/user/{id}', function () {
	echo 'User!';
});

$debug = RouteX::routes();
// DebugX::go($debug);
?>