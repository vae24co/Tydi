<?php //*** oKeyMiddlewareAPI » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Zero\Spry\oEnvX;
use Zero\Spry\oInputX;
use Zero\Spry\oAPIResponseX;

class oKeyMiddlewareAPI {

	// • ==== property
	private static $oKey;
	private static $oAttempt = 30;
	private static $oSeconds = 30;





	// • ==== handle → ... »
	public function handle(Request $request, Closure $next): Response {


		// » implement throttling
		// TODO: Test for [possible gotcha with users on same WiFi] & implement a fix if necessary
		$oResponseX = new oAPIResponseX();
		$APIThrottleKey = 'oAPIThrottleKey: ' . $request->ip();
		$callback = function () { };
		$attempt = self::$oAttempt;
		$seconds = self::$oSeconds;
		$isAllowed = RateLimiter::attempt($APIThrottleKey, $attempt, $callback, $seconds);
		if (!$isAllowed) {
			$delay = RateLimiter::availableIn($APIThrottleKey);
			$hint = 'a while';
			if (!empty($delay)) {
				$hint = $delay;
				if ($delay > 1) {
					$hint = $hint . ' seconds';
				} else {
					$hint = $hint . ' second';
				}
			}
			$oResponseX::exceed('Oh!, API calls exceed limit');
			$oResponseX::hint('Please hold off on making new API requests for ' . $hint);
			return $oResponseX::dispatch();
		}
		RateLimiter::hit($APIThrottleKey);


		// » implement key required
		$key = oInputX::apiKey('HEADER');
		if (!$key) {
			$oResponseX::parameter('Oh!, API access key is required');
			$oResponseX::hint('Please include parameter [APIKey] within headers');
			return $oResponseX::dispatch();
		}


		// » implement key validation
		if ($key !== self::$oKey) {
			$oResponseX::invalid('Oh!, incorrect API access key provided', 'APIKey Incorrect');
			$oResponseX::hint('Please value for parameter [APIKey] within headers');
			return $oResponseX::dispatch();
		}

		return $next($request);
	}





	// • ==== init → ... »
	public static function init($key, $attempt = 5, $seconds = 10) {
		self::$oKey = oEnvX::retrieve($key);
		self::$oSeconds = $seconds;
		self::$oAttempt = $attempt;
	}

} //> end of oKeyMiddlewareAPI