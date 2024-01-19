<?php //*** oResponseX - API response » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Zero\Zero;
use Zero\Spry\oAPIResponseX;
use Illuminate\Support\Collection;

class oResponseX {

	// • ==== title → ...»
	public static function title(string $title) {
		if (Zero::isAPI()) {
			return oAPIResponseX::title($title);
		}
		return;
	}





	// • ==== data → ... »
	public static function data(array $data, $count = null, string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::data($data, $count, $message, $title);
		}
		return;
	}





	// • ==== collection → ... »
	public static function collection(Collection $collection, $count = null, string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::collection($collection, $count, $message, $title);
		}
		return;
	}





	// • ==== hint → ... »
	public static function hint(string $hint = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::hint($hint);
		}
		return;
	}





	// • ==== invalid → ...»
	public static function invalid(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::invalid($message, $title);
		}
		return;
	}





	// • ==== unauthorized → ...»
	public static function unauthorized(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::unauthorized($message, $title);
		}
		return;
	}





	// • ==== notFound → ... »
	public static function notFound(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::notFound($message, $title);
		}
		return;
	}





	// • ==== noRecord → ...»
	public static function noRecord(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::noRecord($message, $title);
		}
		return;
	}





	// • ==== database → ... »
	public static function database($e, $message = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::database($e, $message);
		}
		return;
	}





	// • ==== badMethod → ... »
	public static function badMethod(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::badMethod($message, $title);
		}
		return;
	}





	// • ==== exceptions → ... »
	public static function exceptions($exception) {
		if (Zero::isAPI()) {
			return oAPIResponseX::exceptions($exception);
		}
		return;
	}





	// • ==== success → ... »
	public static function success(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::success($message, $title);
		}
		return;
	}





	// • ==== failure → ... »
	public static function failure(string $message = null, string $title = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::failure($message, $title);
		}
		return;
	}





	// • ==== dispatch → output response » json
	public static function dispatch($headers = null) {
		if (Zero::isAPI()) {
			return oAPIResponseX::dispatch($headers);
		}
		return;
	}

} //> end of oResponseX