<?php //*** Routzr - API » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

use Zero\Zero;
use Zero\Spry;
use Zero\Middleware;
use Zero\Controller;

$zero = [
	'connectionName' => 'brux',
	'APIVersion' => env('BRUX_API_VERSION'),
	'APIKey' => env('BRUX_API_KEY'),
	'API' => true
];

Zero::setProperty($zero);
Spry\oAPIResponseX::version(Zero::getProperty('APIVersion'));
Middleware\oKeyMiddlewareAPI::init(Zero::getProperty('APIKey'), 10, 10);



// ~ Regulate API requests
Route::group(['middleware' => Middleware\oKeyMiddlewareAPI::class], function () {

	// → INITIALIZATION
	Route::post('/session/initialize', [Controller\oSessionContrAPI::class, 'initialize']);



	// ~ Require & Verify Bearer Token
	Route::group(['middleware' => Middleware\oBearerMiddlewareAPI::class], function () {

		// → REFRESH
		Route::post('/session/refresh', [Controller\oSessionContrAPI::class, 'refresh']);

		// → EXTEND
		Route::post('/session/extend', [Controller\oSessionContrAPI::class, 'extend']);


		// ~ Require, Verify & Validate Session Token
		Route::group(['middleware' => Middleware\oSessionMiddlewareAPI::class], function () {

			// → SESSION
			Route::prefix("session")->group(function () {
				Route::post('/terminate', [Controller\oSessionContrAPI::class, 'terminate']);

				Route::get('/token', [Controller\oSessionContrAPI::class, 'token']);
				Route::get('/token/detail', [Controller\oSessionContrAPI::class, 'tokenDetail']);
				Route::post('/token/is-user', [Controller\oSessionContrAPI::class, 'tokenHasUser']);

				Route::post('/bearer/is-user', [Controller\oSessionContrAPI::class, 'bearerHasUser']);
				Route::post('/bearer/is-auth', [Controller\oSessionContrAPI::class, 'bearerIsAuth']);
			});


			// → AUTH
			Route::prefix("auth")->group(function () {
				Route::post('/otp/initialize', [Controller\oAuthContrAPI::class, 'initializeOTP']);
				Route::get('/otp/authorize', [Controller\oAuthContrAPI::class, 'authorizeOTP']);
				Route::get('/otp/resend', [Controller\oAuthContrAPI::class, 'resendOTP']);

				Route::get('/pin/set', [Controller\oAuthContrAPI::class, 'setPIN']);
				Route::get('/pin/change', [Controller\oAuthContrAPI::class, 'changePIN']);
				Route::get('/pin/remove', [Controller\oAuthContrAPI::class, 'removePIN']);

				Route::get('/password/set', [Controller\oAuthContrAPI::class, 'setPassword']);
				Route::get('/password/change', [Controller\oAuthContrAPI::class, 'changePassword']);
				Route::get('/password/remove', [Controller\oAuthContrAPI::class, 'removePassword']);

				Route::get('/login', [Controller\oAuthContrAPI::class, 'login']);
				Route::post('/logout', [Controller\oAuthContrAPI::class, 'logout']);
			});

		}); // ~ end of oSessionMiddlewareAPI

	}); // ~ end of oBearerMiddlewareAPI



	// → PING
	Route::prefix("ping")->group(function () {
		Route::any('/', function () {
			Spry\oAPIResponseX::success('Ping received successfully', 'Ping Received');
			return Spry\oAPIResponseX::dispatch();
		});
	});


	// → INDEX
	Route::any('/', function () {
		Spry\oAPIResponseX::forbidden();
		return Spry\oAPIResponseX::dispatch();
	});

}); // ~ end of oKeyMiddlewareAPI