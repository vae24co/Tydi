<?php //*** RouteX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class RouteX {

	// • property
	private static $init;
	protected static $is; # [route, method]
	protected static $routes;





	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'method unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'static: method unreachable', $caller);
	}





	// • ==== init → ... »
	private static function init() {
		if (!self::$init) {
			self::$routes = [
				'GET' => [],
				'POST' => []
			];

			self::$is = new \stdClass();
			self::$is->route = HttpX::uriWithoutParam();
			echo self::$is->route;
			self::$is->method = HttpX::request();

			self::$init = true;
		}
		return;
	}





	// • ==== get → ... »
	public static function get($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['GET'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~get: "' . $uri . '"');
		}
		self::$routes['GET'][$uri] = $handler;
		if (self::isActive($uri, 'GET') === true) {
			return self::enact($uri, 'GET');
		}
	}





	// • ==== post → ... »
	public static function post($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['POST'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~post: "' . $uri . '"');
		}
		self::$routes['POST'][$uri] = $handler;
		if (self::isActive($uri, 'POST') === true) {
			return self::enact($uri, 'POST');
		}
	}





	// • ==== any → ... »
	public static function any($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['GET']) && array_key_exists($uri, self::$routes['POST'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~any: "' . $uri . '"');
		} elseif (array_key_exists($uri, self::$routes['GET'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~get: "' . $uri . '"');
		} elseif (array_key_exists($uri, self::$routes['POST'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~post: "' . $uri . '"');
		}
		self::$routes['GET'][$uri] = $handler;
		self::$routes['POST'][$uri] = $handler;
		if (self::isActive($uri, 'ANY') === true) {
			return self::enact($uri, 'ANY');
		}
	}





	// • ==== routes → ... »
	public static function routes($method = null) {
		self::init();
		if ($method === 'GET' || $method === 'ANY') {
			return self::$routes['GET'];
		}
		if ($method === 'POST') {
			return self::$routes['POST'];
		}
		return self::$routes;
	}





	// • ==== pattern → ... »
	protected function pattern($route) {
		$pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $route);
		$pattern = str_replace('/', '\/', $pattern);
		$pattern = '/^' . $pattern . '$/';
		return $pattern;
	}





	// • ==== isActive → ... »
	protected static function isActive($uri, $method) {
		if ($uri === self::$is->route) {
			if ($method === self::$is->method) {
				return true;
			} elseif ($method === 'ANY' && (self::$is->method === 'GET' || self::$is->method === 'POST')) {
				return true;
			} else {
				// TODO: pattern matching url
			}
		}
		return false;
	}





	// • ==== enact → ... »
	protected static function enact($uri, $method) {
		$routes = self::routes($method);
		if (empty($routes)) {
			// TODO: Improve error for proper handling
			return DebugX::oversight(__CLASS__, 'No Routes Defined', $method);
		}

		if (!array_key_exists($uri, $routes)) {
			// TODO: Improve error for proper handling
			return DebugX::oversight(__CLASS__, 'Route Not Found', $method . ': "' . $uri . '"');
		}


		// TODO: check pattern matching

		$handler = $routes[$uri];

		return self::handler($handler);
	}





	// • ==== handler → ... »
	protected static function handler($handler, $params = []) {
		if (is_callable($handler)) {
			return call_user_func_array($handler, $params);
		} elseif (is_string($handler) && strpos($handler, '::') !== false) {
			list($organizr, $action) = explode('::', $handler);
			return self::organizr($organizr, $action, $params);
		} else {
			return DebugX::oversight(__CLASS__, 'Handler Error', $handler);
		}
	}





	// • ==== organizr → ... »
	protected static function organizr($organizr, $action = 'index', $params = []) {
		$instance = new $organizr();
		return call_user_func_array([$instance, $action], $params);
	}

} //> end of RouteX



class User {
	public function index() {
		echo 'Index of User';
		return;
	}



	public function name($name = 'John') {
		echo 'Hello ' . $name;
		return;
	}
}