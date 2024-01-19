<?php //*** Namespace » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
$namespace = [
	'Zero\Zero' => 'libry/zero.php',


	'Zero\Spry\oDebugX' => 'libry/spry/debug.php',
	'Zero\Spry\oEnvX' => 'libry/spry/env.php',
	'Zero\Spry\oVariableX' => 'libry/spry/variable.php',
	'Zero\Spry\oValidateX' => 'libry/spry/validate.php',
	'Zero\Spry\oClientX' => 'libry/spry/client.php',
	'Zero\Spry\oRandomX' => 'libry/spry/random.php',
	'Zero\Spry\oDataX' => 'libry/spry/data.php',
	'Zero\Spry\oTimeX' => 'libry/spry/time.php',
	'Zero\Spry\oInputX' => 'libry/spry/input.php',
	'Zero\Spry\oArrayX' => 'libry/spry/array.php',
	'Zero\Spry\oHandlerX' => 'libry/spry/handler.php',
	'Zero\Spry\oResponseX' => 'libry/spry/response.php',
	'Zero\Spry\oRequestX' => 'libry/spry/request.php',
	'Zero\Spry\oCollectionX' => 'libry/spry/collection.php',
	'Zero\Spry\oAPIResponseX' => 'libry/spry/api/response.php',
	'Zero\Spry\oAPIValidateX' => 'libry/spry/api/validate.php',


	'Zero\Middleware\oKeyMiddlewareAPI' => 'libry/middleware/api/key.php',
	'Zero\Middleware\oBearerMiddlewareAPI' => 'libry/middleware/api/bearer.php',
	'Zero\Middleware\oSessionMiddlewareAPI' => 'libry/middleware/api/session.php',


	'Zero\Controller\oControllerAPI' => 'libry/controller/api/controller.php',
	'Zero\Controller\oSessionContrAPI' => 'libry/controller/api/session.php',
	'Zero\Controller\oAuthContrAPI' => 'libry/controller/api/auth.php',


	'Zero\Service\oService' => 'libry/service/service.php',
	'Zero\Service\oSessionService' => 'libry/service/session.php',
	'Zero\Service\oAuthService' => 'libry/service/auth.php',


	'Zero\Provider\oProvider' => 'libry/provider/provider.php',

	'Zero\Provider\Collection\oInitializationCollection' => 'libry/provider/collection/initialization.php',
	'Zero\Provider\Collection\oSessionCollection' => 'libry/provider/collection/session.php',
	'Zero\Provider\Collection\oUserCollection' => 'libry/provider/collection/user.php',
	'Zero\Provider\Collection\oAuthCollection' => 'libry/provider/collection/auth.php',

	'Zero\Provider\Log\oJourneyLog' => 'libry/provider/log/journey.php',
];
LoaderX::register();
LoaderX::config($namespace);


// *** Comment
// ! Comment
// * Comment
// ◇ Comment
// • Comment
// ~ Comment
// > Comment
// + Comment
// » Comment
// → Comment