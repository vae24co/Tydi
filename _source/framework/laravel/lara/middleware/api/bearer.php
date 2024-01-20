<?php //*** oBearerMiddlewareAPI » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Zero\Spry\oDebugX;
use Zero\Spry\oInputX;
use Zero\Spry\oAPIResponseX;
use Zero\Provider\Collection\oInitializationCollection;

class oBearerMiddlewareAPI {

	// • ==== handle → ... »
	public function handle(Request $request, Closure $next): Response {

		// » Collect Bearer Token
		$token = oInputX::bearerToken('HEADER');

		// » Require Bearer Token
		if (empty($token)) {
			oAPIResponseX::parameter('Oh!, bearer token is required');
			oAPIResponseX::hint('Please include bearer token within headers');
			return oAPIResponseX::dispatch();
		}


		// » Verify Bearer Token
		$isValidToken = (new oInitializationCollection())->isTokenValid($token);
		if (!$isValidToken) {
			oAPIResponseX::unauthorized('Oh!, bearer token is invalid', 'Invalid Token');
			return oAPIResponseX::dispatch();
		}

		return $next($request);
	}

} //> end of oBearerMiddlewareAPI