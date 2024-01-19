<?php
namespace Zero\API;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

use Zero\API\Response as APIResponse;




class Regulator {

	public function handle(Request $request, Closure $next): Response {

		// • API Throttling
		$APIThrottleKey = 'APIThrottleKey: ' . $request->ip();
		$callback = function () { };
		$attempt = 10;
		$seconds = 20;


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

			APIResponse::exceed('Oh!, API calls exceed the limit');
			APIResponse::hint('Pause from making API calls for ' . $hint);
			$response = APIResponse::responder();
			$code = APIResponse::HTTPCode();
			return response()->json($response, $code);
		}

		RateLimiter::hit($APIThrottleKey);


		// • AccessKey Checking
		$key = $request->header('AccessKey');
		if (!$key) {
			APIResponse::parameter('Oh!, API access key is required');
			APIResponse::hint('Include AccessKey parameter within headers');
			$response = APIResponse::responder();
			$code = APIResponse::HTTPCode();
			return response()->json($response, $code);
		}



		// • AccessKey Validity
		if ($key !== env('ZERO_API_ACCESS_KEY')) {
			APIResponse::invalid('Oh!, incorrect API access key provided', 'AccessKey Incorrect');
			APIResponse::hint('Provide a valid AccessKey within headers');
			$response = APIResponse::responder();
			$code = APIResponse::HTTPCode();
			return response()->json($response, $code);

		}

		return $next($request);
	}
}