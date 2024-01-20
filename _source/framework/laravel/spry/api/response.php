<?php //*** oAPIResponseX - API response » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Collection;

class oAPIResponseX {

	// • ==== property
	private static $init;
	private static $response;
	private static $terminus;
	protected static $hint;
	private static $code = 'C204SR';
	private static $version = 'OREO';
	protected static $count = 0;
	protected static $data = [];
	protected static $error = [];
	protected static $status = 'completed';
	protected static $title = 'Request Complete';
	protected static $message = 'Your request is complete';





	// • ==== init → initialize »
	private static function init() {
		if (!self::$init) {
			self::terminus(true);
			self::$init = true;
		}
		return;
	}





	// • ==== terminus → set or get terminus » boolean|string
	protected static function terminus(bool $set = false) {
		if ($set === true) {
			$terminus = app('request')->path();
			if (!empty($terminus)) {
				self::$terminus = $terminus;
			}
		}
		return self::$terminus;
	}





	// • ==== version → set or get version » boolean|string
	public static function version($version = null) {
		if (!empty($version)) {
			self::$version = $version;
		}
		return self::$version;
	}





	// • ==== code → set or get code » boolean|string
	public static function code($code = null) {
		if (!empty($code)) {
			self::$code = $code;
		}
		return self::$code;
	}





	// • ==== count → ... »
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

		self::$count = $count;
		return;
	}





	// • ==== status → set or get status » boolean|string
	public static function status($status = null) {
		if (!empty($status)) {
			$statuses = ['unknown', 'error', 'failure', 'success', 'completed'];
			if (!in_array($status, $statuses)) {
				$status = 'unknown';
			}
			self::$status = $status;
		}
		return self::$status;
	}





	// • ==== title → set or get title » boolean|string
	public static function title($title = null) {
		if (!empty($title)) {
			self::$title = $title;
		}
		return self::$title;
	}





	// • ==== message → set or get message » boolean|string
	public static function message(string $message = null) {
		$message = !empty($message) ? $message : 'Your request is completed';
		self::$message = $message;
		return self::$message;
	}





	// • ==== success → success response »
	public static function success(string $message = null, string $title = null) {
		$title = empty($title) ? "Request Successful" : $title;
		$message = empty($message) ? "You request was successful." : $message;
		self::$status = 'success';
		self::$code = 'R200SR';
		self::$title = $title;
		self::$message = $message;
		return;
	}





	// • ==== failure → failure response »
	public static function failure(string $message = null, string $title = null) {
		$title = empty($title) ? "Request Failied" : $title;
		$message = empty($message) ? "You request was unsuccessful." : $message;
		self::$status = 'failure';
		self::$code = 'F200SR';
		self::$title = $title;
		self::$message = $message;
		return;
	}





	// • ==== error → set or get error » boolean|array
	public static function error($error = null) {
		if (!empty($error)) {
			self::$error = $error;
		}
		return self::$error;
	}





	// • ==== data → make data response »
	public static function data(array $data, $count = null, string $message = null, string $title = null) {
		$title = empty($title) ? "Record Found" : $title;
		$message = empty($message) ? "Your request returned result." : $message;
		if (is_array($data)) {
			self::$data = $data;
		}
		if (!empty($count)) {
			self::count($count);
		} else {
			self::count($data);
		}
		self::success($message, $title);
		return;
	}





	// • ==== collection → make data response from collection »
	public static function collection(Collection $collection, $count = null, string $message = null, string $title = null) {
		$data = $collection->toArray();
		if (oArrayX::isMultiWithOne($data)) {
			return self::data($data[0], $count, $message, $title);
		}
		return;
	}





	// • ==== hint → prepare hint »
	public static function hint(string $hint = null) {
		if (!empty($hint)) {
			self::$hint = $hint;
		}
		return;
	}





	// • ==== notFound → resource not found »
	public static function notFound(string $message = null, string $title = null) {
		$title = empty($title) ? "Resource Unavailable" : $title;
		$message = empty($message) ? "Oh!, resource not found." : $message;
		self::$status = 'error';
		self::$code = 'C404IE';
		self::$title = $title;
		self::$message = $message;
		self::hint('You may have requested an invalid resource');
		return;
	}





	// • ==== noRecord → record not found »
	public static function noRecord(string $message = null, string $title = null) {
		$title = empty($title) ? "No Record" : $title;
		$message = empty($message) ? "Oh!, record not found." : $message;
		self::$status = 'failure';
		self::$code = 'C204SR';
		self::$title = $title;
		self::$message = $message;
		self::hint('Your request returned no result');
		return;
	}





	// • ==== forbidden → resource not found »
	public static function forbidden(string $message = null, string $title = null) {
		$title = empty($title) ? "Resource Forbidden" : $title;
		$message = empty($message) ? "Oh!, resource not allowed." : $message;
		self::$status = 'error';
		self::$code = 'C403IE';
		self::$title = $title;
		self::$message = $message;
		self::hint('You may have requested an bad resource');
		return;
	}





	// • ==== exceed → limit exceeded »
	public static function exceed(string $message = null, string $title = null) {
		$title = empty($title) ? "Resource Limit" : $title;
		$message = empty($message) ? "Oh!, you have exceeded the allocated resource at this time." : $message;
		self::$status = 'failure';
		self::$code = 'C509SR';
		self::$title = $title;
		self::$message = $message;
		return;
	}





	// • ==== invalid → invalid record »
	public static function invalid(string $message = null, string $title = null) {
		$title = empty($title) ? "Value Incorrect" : $title;
		$message = empty($message) ? "Oh!, incorrect parameter value provided." : $message;
		self::$status = 'error';
		self::$code = 'C498IE';
		self::$title = $title;
		self::$message = $message;
		return;
	}





	// • ==== unauthorized → access denied »
	public static function unauthorized(string $message = null, string $title = null) {
		$title = empty($title) ? "Unauthorized Access" : $title;
		$message = empty($message) ? "Oh!, your access is denied." : $message;
		self::$status = 'failure';
		self::$code = 'C401SR';
		self::$title = $title;
		self::$message = $message;
		return;
	}





	// • ==== precondition → precondition ignored »
	public static function precondition(string $message = null, string $title = null, array|string|null $error = []) {
		$title = empty($title) ? "Precondition Ignored" : $title;
		$message = empty($message) ? $message = "Oh!, required conditions ignored" : $message;
		self::$status = 'error';
		self::$code = 'C428IE';
		self::$title = $title;
		self::$message = $message;
		if (!empty($error)) {
			self::$error = $error;
		}
		return;
	}





	// • ==== parameter → parameter required »
	public static function parameter(string $message = null, string $title = null, $error = null) {
		$title = empty($title) ? "Parameter Required" : $title;
		self::precondition($message, $title, $error);
		return;
	}





	// • ==== exceptions → ... »
	public static function exceptions($exception) {
		self::title('Exception Error');
		self::message('Oops, a critical error occurred');
		self::error($exception);
		return;
	}





	// • ==== database → ... »
	public static function database($e, $message = null) {
		$error = [
			'id' => oRandomX::id(),
			'type' => 'Critical',
			'code' => $e->getCode(),
			'summary' => $e->getMessage(),
			'description' => $e->errorInfo[2]
		];

		if ($error['code'] === '22001') {
			$title = 'Excessive Length';
			$code = 'C500IE';
		}

		if ($error['code'] === '42S22') {
			$title = 'Column Unavailable';
			$code = 'C500DE';
		}

		if ($error['code'] === '23000') {
			$title = 'Integrity Violation';
			$code = 'C500DE';
		}

		if ($error['code'] === '01000') {
			$title = 'Data Violation';
			$code = 'C500DE';
		}

		$title = empty($title) ? "Database Error" : $title;
		$message = empty($message) ? "Oops, something went wrong." : $message;
		$code = empty($code) ? "C500DB" : $code;


		if (empty($error['title'])) {
			$error['title'] = $title;
		}
		if ($title !== 'Database Error') {
			$error['title'] = 'DB: ' . $title;
		}

		self::status('error');
		self::title($title);
		self::message($message);
		self::code($code);
		self::error($error);
		self::hint('A database operation failed');
		return;
	}





	// • ==== badMethod → http method not allowed »
	public static function badMethod(string $message = null, string $title = null) {
		$title = empty($title) ? "Method Unsupported" : $title;
		$message = empty($message) ? "Oh!, HTTP method not allowed." : $message;
		self::$status = 'error';
		self::$code = 'C405IE';
		self::$title = $title;
		self::$message = $message;
		self::hint('Your have used an unsupported http method');
		return;
	}





	// • ==== response → prepare response »
	public static function response() {
		self::init();
		self::$response = [
			'status' => strtoupper(self::$status),
			'version' => self::$version,
			'terminus' => '/' . self::$terminus,
			'response' => [
				'code' => self::$code,
				'title' => ucwords(self::$title),
				'message' => self::$message,
				'count' => self::$count,
				'data' => self::$data,
				'hint' => self::$hint,
				'error' => self::$error
			]
		];

		if (empty(self::$response['response']['hint'])) {
			unset(self::$response['response']['hint']);
		}
		if (empty(self::$response['response']['error'])) {
			unset(self::$response['response']['error']);
		}
	}





	// • ==== httpCode → prepare http code » integer
	public static function httpCode() {
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





	// • ==== dispatch → output response » json
	public static function dispatch($headers = null) {
		self::response();
		$headers = empty($headers) ? ['Content-Type' => 'application/json'] : $headers;
		return response()->json(self::$response, self::httpCode(), $headers);
	}

} //> end of oAPIResponseX