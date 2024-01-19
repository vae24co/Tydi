<?php
namespace Zero\API;

use Illuminate\Support\Facades\Route;

use Zero\Utilizer\Information;


class Response {

	private static $response;
	private static $init;
	private static $version = 'OREO';





	private static function init() {
		if (!self::$init) {
			$route = Route::current();
			if ($route) {
				$uri = $route->uri();
			} else {
				$uri = app('request')->path();
			}

			$version = env('ZERO_API_VERSION');
			if (!empty($version)) {
				self::$version = $version;
			}

			$title = "Request Complete";
			self::$response = [
				'status' => 'completed', # [unknown|error|failure|success]
				'version' => self::$version,
				'terminus' => '/' . $uri,
				'response' => [
					'code' => 'C204SE',
					'title' => ucwords($title),
					'message' => "Sorry, no message returned for completed request",
					'count' => 0,
					'data' => []
				]
			];
			self::$init = true;
		}
	}





	private static function merge(array $response = null) {
		self::init();
		if ($response && is_array($response)) {
			if (isset(self::$response['response']) && isset($response['response'])) {
				self::$response['response'] = array_merge(self::$response['response'], $response['response']);
				unset($response['response']);
			}
			if (!empty($response)) {
				self::$response = array_merge(self::$response, $response);
			}
			return true;
		}
		return false;
	}





	public static function hint(string $hint = null) {
		if ($hint) {
			$response['response']['hint'] = $hint;
		}
		self::merge($response);
	}





	public static function success(string $message = null, string|null $title = 'Request Successful', array $data = []) {
		if (empty($message)) {
			$message = "You request has been successfully";
		}
		$response['status'] = 'success';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'R200SD';
		if (!empty($data) && is_array($data)) {
			$response['response']['data'] = $data;
		}
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
	}





	public static function data(array $data, $count = null, $message = null, string $title = 'Record Found') {
		if (!empty($count)) {
			self::count($count);
		} else {
			self::count($data);
		}
		if (empty($message)) {
			$message = "Your request returned result.";
		}
		return self::success($message, $title, $data);
	}





	public static function error(string $message = null, $title = 'Error Occurred', string $code = 'C501AE', array $error = []) {
		if (empty($message)) {
			$message = "Oh!, sorry an error occured.";
		}
		$response['status'] = 'error';
		if (!empty($code)) {
			$response['response']['code'] = $code;
		}
		$response['response']['message'] = $message;
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		if (!empty($error)) {
			$response['response']['error'] = $error;
		}
		self::merge($response);
	}





	public static function database($e) {
		$code = $e->getCode();
		$error = [
			'id' => Information::id(),
			'type' => 'Critical',
			'summary' => $e->getMessage()
		];

		if ((int) $code === 22001) {
			$message = 'Data too long for entry';
			$code = 'C501DE';
		}

		return self::error($message, 'Database Error', $code, $error);
	}





	public static function invalid(string $message = null, string $title = 'Value Incorrect', array $error = []) {
		if (empty($message)) {
			$message = "Oh!, incorrect parameter value provided.";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C498IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
	}





	public static function exceed(string $message = null, string $title = 'Resource Limit', array $error = []) {
		if (empty($message)) {
			$message = "Oh!, you have exceeded the allocated resource at this time.";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C509IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
	}





	public static function precondition(string $message = null, string $title = 'Precondition Ignored', array|string|null $error = []) {
		if (!$message) {
			$message = "Oh!, required conditions ignored";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C428IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}

		if (!empty($error)) {
			$response['response']['error'] = $error;
		}
		self::merge($response);
	}





	public static function parameter(string $message = null, string $title = 'Parameter Required', $error = null) {
		self::precondition($message, $title, $error);
	}





	public static function responder() {
		self::init();
		return self::$response;
	}





	public static function count($var = null) {
		$count = 0;
		if (is_numeric($var)) {
			$count = (int) $var;
		} elseif (!empty($var) && is_array($var)) {
			$isMulti = count($var) !== count($var, COUNT_RECURSIVE);
			if ($isMulti) {
				$count = count($var);
			} else {
				$count = 1;
			}
		}

		$response['response']['count'] = $count;
		self::merge($response);
	}




	public static function title(string $title) {
		$response['response']['title'] = $title;
		self::merge($response);
	}





	public static function message(string $message) {
		$response['response']['message'] = $message;
		self::merge($response);
	}





	public static function notFound(string $message = null, string $title = 'Resource Unavailable', array $error = []) {
		if (empty($message)) {
			$message = "Oh!, resource is not found.";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C404IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
		self::hint('Requested resource may not be supported');
	}





	public static function notMethod(string $message = null, string $title = 'Method Unsupported', array $error = []) {
		if (empty($message)) {
			$message = "Oh!, HTTP method is not allowed.";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C405IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
		self::hint('Request method may not be supported');
	}





	public static function code() {
		self::init();
		$response = self::$response;
		if (!empty($response['response']['code'])) {
			return $response['response']['code'];
		}
		return false;
	}





	public static function HTTPCode() {
		$code = self::code();
		if (!empty($code) && is_string($code) && strlen($code) > 5) {
			$code = substr($code, 1);
			$code = substr($code, 0, -2);
		}
		if ($code === '204') {
			$code = '202';
		}
		if (empty($code)) {
			$code = '200';
		}
		return (int) $code;
	}

}