<?php //*** oHandlerX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Exception;
use Illuminate\Database\QueryException;

class oHandlerX {

	// • ==== exceptions → ... »
	public static function exceptions($e) {

		// ~ QueryException
		if ($e instanceof QueryException) {
			$res['connection'] = $e->getConnectionName();
			$res['sql'] = $e->getSql();
			$res['bindings'] = $e->getBindings();
			return $res;
		}

		if ($e instanceof Exception) {
			$res = [
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'trace' => $e->getTrace(),
			];
			if ($e->getPrevious() !== null) {
				$res['previous'] = self::exceptions($e->getPrevious());
			}
			return $res;
		}

	}

} //> end of oHandlerX