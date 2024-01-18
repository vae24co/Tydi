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
		return self::enact($uri, 'GET');
	}





	// • ==== post → ... »
	public static function post($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['POST'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~post: "' . $uri . '"');
		}
		self::$routes['POST'][$uri] = $handler;
		return self::enact($uri, 'POST');
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
		return self::enact($uri, 'ANY');
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
	protected static function pattern($route) {
		$pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $route);
		$pattern = str_replace('/', '\/', $pattern);
		$pattern = '/^' . $pattern . '$/';
		return $pattern;
	}





	// • ==== ismethod → ... »
	protected static function ismethod($method) {
		if ($method === 'ANY' && (self::$is->method === 'GET' || self::$is->method === 'POST')) {
			return true;
		} elseif ($method === self::$is->method) {
			return true;
		}
		return false;
	}





	// • ==== isuri → ... »
	protected static function isuri($uri) {
		if ($uri === self::$is->route) {
			return true;
		}
		return false;
	}





	// • ==== inroute → ... »
	protected static function inroute($uri, $method) {
		if ($method === 'ANY') {
			$method = 'GET';
		}
		if (array_key_exists($uri, self::$routes[$method])) {
			return true;
		}
		return false;
	}





	// • ==== ismatch → ... »
	protected static function ismatch($uri, $method) {
		if (self::inroute($uri, $method)) {
			if (StringX::contain($uri, '{')) {
				$pattern = self::pattern($uri);
				if (preg_match($pattern, self::$is->route, $matches)) {
					array_shift($matches);
					return ['handler' => self::$routes[$method][$uri], 'params' => $matches];
				}
			} elseif (self::isuri($uri) && self::ismethod($method)) {
				return ['handler' => self::$routes[$method][$uri], 'params' => []];
			}
		}
		return false;
	}





	// • ==== enact → ... »
	protected static function enact($uri, $method) {
		$ismatch = self::ismatch($uri, $method);
		if ($ismatch !== false) {
			return self::handler($ismatch['handler'], $ismatch['params']);
		}
		return;
	}





	// • ==== handler → ... »
	protected static function handler($handler, $params = []) {
		if (is_callable($handler)) {
			return call_user_func_array($handler, $params);
		} elseif (is_string($handler) && strpos($handler, '::') !== false) {
			list($organizr, $action) = explode('::', $handler);
			return self::organizr($organizr, $action, $params);
		} else {
			// TODO: Clean this up
			return DebugX::oversight(__CLASS__, 'Handler Error', self::$is);
		}
	}





	// • ==== organizr → ... »
	protected static function organizr($organizr, $action, $params = []) {
		$instance = new $organizr();
		if(method_exists($instance, $action)){
			return call_user_func_array([$instance, $action], $params);
		}
		return DebugX::oversight($organizr, 'Organizr: Method Unavailable', $action);
	}

} //> end of RouteX



class User {
	public function index() {
		echo 'Index of User';
		return;
	}



	public function name($name = 'John') {
		// echo 'Hello ' . urldecode($name);
		if (StringX::isEncoded($name)) {
			$name = urldecode($name);
		}
		echo 'Dear ' . $name;
		return;
	}
}