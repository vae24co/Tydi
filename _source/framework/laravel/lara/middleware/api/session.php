<?php //*** oSessionMiddlewareAPI » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Zero\Spry\oDebugX;
use Zero\Spry\oInputX;
use Zero\Spry\oAPIResponseX;
use Zero\Provider\Collection\oSessionCollection;

class oSessionMiddlewareAPI {

	// • ==== handle → ... »
	public function handle(Request $request, Closure $next): Response {

		// » Collect Session Token
		$token = oInputX::sessionToken('HEADER');

		// » Require Session Token
		if (empty($token)) {
			oAPIResponseX::parameter('Oh!, session token is required');
			oAPIResponseX::hint('Please include session token (SessionID) within headers');
			return oAPIResponseX::dispatch();
		}


		// » Collect Bearer Token
		$bearer = oInputX::bearerToken('HEADER');

		// » Verify Session Token
		$isVerified = (new oSessionCollection())->verifyToken($token, $bearer, 'NO_CHECK');
		if (!$isVerified) {
			oAPIResponseX::invalid('Oh!, session token is invalid', 'Invalid Session');
			return oAPIResponseX::dispatch();
		}


		// » Check Session Timeout
		$isExpired = (new oSessionCollection())->isTokenExpired($token);
		if ($isExpired === null) {
			oAPIResponseX::invalid('Oh!, session token is invalid', 'Invalid Session');
			return oAPIResponseX::dispatch();
		} elseif ($isExpired === true) {
			oAPIResponseX::unauthorized('Oh!, session token has expired', 'Expired Session');
			return oAPIResponseX::dispatch();
		}

		return $next($request);
	}

} //> end of oSessionMiddlewareAPI