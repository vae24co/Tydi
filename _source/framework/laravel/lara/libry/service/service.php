<?php //*** oService » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Service;

use Exception;
use Illuminate\Database\QueryException;
use Zero\Spry\oHandlerX;
use Zero\Spry\oResponseX;


class oService {

	// • ==== tryCatch → ... »
	protected function tryCatch(callable $callback) {
		try {
			return $callback();
		} catch (QueryException $e) {
			return oResponseX::database($e);
		} catch (Exception $e) {
			$exception = oHandlerX::exceptions($e);
			return oResponseX::exceptions($exception);
		}
	}





	// • ==== tryCatchRollback → ... »
	protected function tryCatchRollback(callable $callback) {
	}

} //> end of oService