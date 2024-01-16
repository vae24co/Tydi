<?php
/*** Tydi ~ Tydi Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class Tydi {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}

	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}

	// ◇ ----- END • End Program »
	public static function end() {
		return exit;
	}

	// ◇ ----- DEBUG • Dump & End Program »
	public static function debug($var) {
		echo var_export($var);
		return exit;
	}

	// ◇ ----- DUMP • Dump & End Program »
	public static function dump($var) {
		var_dump($var);
		return exit;
	}

	// ◇ ----- ABORT • Trace & End Program »
	public static function abort($i, $print = true) {
		self::trace($i, $print);
		return exit;
	}

	// ◇ ----- BLEND • Blend Config »
	public static function blend($append, $current = '') {

		//...If $current is empty
		if (VarX::isEmpty($current)) {
			$current = $append;
		}

		//...If $current is not empty
		else {
			foreach ($append as $key => $database) {
				if (ArrayX::isKeyNotEmpty($current, $key)) {
					$current[$key] = ArrayX::blend($current[$key], $append[$key]);
				} else {
					$current[$key] = $database;
				}
			}
		}

		return $current;
	}

	// ◇ ----- HANDLER • ... »
	public static function handler($var, $label = 'ERROR') {
		if (VarX::isArray($var) && ArrayX::isKeyNotEmpty($var, 'HAS_ERROR')) {
			unset($var['HAS_ERROR']);
			if (Route::isAPI()) {
				return API::resolve($var);
			}
			return self::abort([$label => $var]);
		}
		return $var;
	}

	// ◇ ----- DISPLAY • Output API Response »
	public static function display($response, $view = 'TRACE') {

		if (isset($response['response']['error'])) {
			// TODO: Remove from display based on Environment
			// self::display($response['response']['error']);
		}

		//...JSON
		if ($view === 'JSON') {
			if (VarX::isObject($response)) {
				$response = ObjectX::toArray($response);
			}
			if (VarX::isArray($response)) {
				$response = ArrayX::toJSON($response);
			}
			JSON::display($response);
		}

		//...PRINT
		elseif ($view === 'PRINT') {
			print_r($response);
		}

		//...DUMP
		elseif ($view === 'DUMP') {
			var_dump($response);
		}

		//...STRING
		elseif ($view === 'STRING') {
			if (VarX::isObject($response)) {
				$response = ObjectX::toArray($response);
			}
			if (VarX::isArray($response)) {
				$response = ArrayX::toString($response);
			}
			echo $response;
		}

		//...TRACE
		elseif ($view === 'TRACE') {
			return self::trace($response);
		}

		//...Response
		else {
			return $response;
		}

		return exit;
	}

	// ◇ ----- RESOLVER • ... »
	public static function resolver($resp = []) {

		//...TERMINUS
		if (ArrayX::isNotKey($resp, 'terminus')) {
			$resp['terminus'] = Route::property('uri');
		}

		//...VERSION
		if (ArrayX::isNotKey($resp, 'version')) {
			$resp['version'] = ucwords(Route::property('link')->version);
		}

		//...RESPONSE
		if (ArrayX::isNotKey($resp, 'response')) {
			$resp['response'] = [];
		}

		//...CODE
		if (ArrayX::isKey($resp, 'code')) {
			$resp['response']['code'] = $resp['code'];
			unset($resp['code']);
		}

		//...TITLE
		if (ArrayX::isKey($resp, 'title')) {
			$resp['response']['title'] = $resp['title'];
			unset($resp['title']);
		}

		//...MESSAGE
		if (ArrayX::isKey($resp, 'message')) {
			$resp['response']['message'] = $resp['message'];
			unset($resp['message']);
		}

		//...COUNT
		if (ArrayX::isKey($resp, 'count')) {
			$resp['response']['count'] = $resp['count'];
			unset($resp['count']);
		} elseif (ArrayX::isNotKey($resp['response'], 'count')) {
			$resp['response']['count'] = 0;
		}

		//...DATA
		if (ArrayX::isKey($resp, 'data')) {
			$resp['response']['data'] = $resp['data'];
			unset($resp['data']);
		} elseif (ArrayX::isNotKey($resp['response'], 'data')) {
			$resp['response']['data'] = [];
		}

		//...SUMMARY
		if (ArrayX::isKey($resp, 'summary')) {
			$resp['response']['error']['summary'] = $resp['summary'];
			unset($resp['summary']);
		}

		//...ERROR_ID
		if (ArrayX::isKey($resp, 'errorid')) {
			$resp['response']['error']['errorid'] = $resp['errorid'];
			unset($resp['errorid']);
		}

		//...ERROR_CODE
		if (ArrayX::isKey($resp, 'errcode')) {
			$resp['response']['error']['errcode'] = $resp['errcode'];
			unset($resp['errcode']);
		}

		//...AUTHOR
		if (ArrayX::isKey($resp, 'author')) {
			$resp['response']['error']['author'] = $resp['author'];
			unset($resp['author']);
		}

		//...EXTRA
		if (ArrayX::isKey($resp, 'detail')) {
			$resp['response']['error']['detail'] = $resp['detail'];
			unset($resp['detail']);
		}

		if ($resp['status'] === 'F9') {
			if (ArrayX::isNotKey($resp['response']['error'], 'summary')) {
				$resp['response']['error']['summary'] = $resp['response']['error']['errorid'];
				if (ArrayX::isKey($resp['response'], 'title')) {
					$resp['response']['error']['summary'] .= ' • ' . $resp['response']['title'];
				}
				if (isset($resp['object'])) {
					$resp['response']['error']['summary'] .= ' » ' . $resp['object'];
					unset($resp['object']);
				}
				$resp['response']['error']['summary'] .= ' • ' . $resp['terminus'];
			}
		}

		if ($resp['status'] === 'OK') {
			unset($resp['response']['error']);
		}
		// ksort($resp);
		return $resp;
	}

	// ◇ ----- TRACE • Useful for Debugging »
	public static function trace($i, $print = true) {
		if ($print) {
			echo nl2br(self::trace($i, false));
			return;
		}
		$o = '';
		if (is_array($i)) {
			$label = 'array';
			$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
			$o .= '<div style="margin: 0px 0 4px 6px; padding: 4px 6px 6px 12px; border-left: 1px dotted #FFD700;">';
			foreach ($i as $key => $value) {
				$o .= '<strong style="color:#A52A2A;">' . $key . ': </strong>';
				if (is_bool($value) === true) {
					if ($value === true) {
						$o .= ' → oTRUE<span> ';
					} elseif ($value === false) {
						$o .= ' → oFALSE<span> ';
					}
					$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
				} elseif (is_array($value)) {
					$o .= self::trace($value, false);
				} elseif (is_object($value)) {
					$o .= '<pre><tt>' . var_export($value, true) . '</tt></pre>';
				} else {
					$o .= $value . '<span><br>';
				}
			}
			$o .= '</div>';
		} elseif (is_bool($i) === true) {
			$label = 'boolean';
			$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
			if ($i === true) {
				$o .= ' → oTRUE<span><br>';
			} elseif ($i === false) {
				$o .= ' → oFALSE<span><br>';
			}
			$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
		} elseif (is_object($i)) {
			$o .= '<pre><tt>' . var_export($i, true) . '</tt></pre>';
		} else {
			$o .= print_r($i, true);
		}
		return $o;
	}

	// ◇ ----- JSON • JSON Display »
	public static function json($var) {

		if (VarX::stringAcceptable($var)) {
			$var['response'] = $var;
		}

		if (VarX::isArray($var)) {
			$var = ArrayX::toJSON($var);
		}

		return JSON::display($var);
	}





	// ◇ ----- oCLASS • »
	public static function oClass($className, $req) {
		$resolve = [];
		$reflection = new ReflectionClass($className);
		$properties = $reflection->getProperties();
		foreach ($properties as $property) {
			$property->setAccessible(true);
			$resolve['PROPERTY'][$property->getName()] = $property->getValue(new $className);
		}

		$methods = $reflection->getMethods();
		foreach ($methods as $method) {
			$modifier = Reflection::getModifierNames($method->getModifiers());
			$resolve['METHOD'][$method->getName().'()'] = $modifier[0];
		}

		if (strtoupper($req) === 'PROPERTY') {
			return $resolve['PROPERTY'];
		}

		if (strtoupper($req) === 'METHOD') {
			return $resolve['METHOD'];
		}

		return $resolve;
	}

} // End Of Class ~ Tydi