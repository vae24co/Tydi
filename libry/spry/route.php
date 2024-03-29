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




	// • ==== clean → ... »
	private static function clean($uri, $isInput = true) {
		if ($isInput) {
			if ($uri === 'index' || $uri === '/index') {
				$uri = '/';
			}
			if (!StringX::beginWith($uri, '/')) {
				$uri = '/' . $uri;
			}
			if (strlen($uri) > 1 && StringX::endWith($uri, '/')) {
				$uri = StringX::cropEnd($uri, '/');
			}
		} else {
			if ($uri === '/') {
				$uri = 'index';
			} elseif (StringX::beginWith($uri, '/')) {
				$uri = StringX::cropBegin($uri, '/');
			}
		}
		return $uri;
	}





	// • ==== make → ... »
	private static function make($method, $uri, $handler) {
		$uri = self::clean($uri, true);
		self::$routes[strtoupper($method)][$uri] = $handler;
		return;
	}





	// • ==== organizr → ... »
	protected static function organizr($organizr, $action, $params = []) {
		$instance = new $organizr();
		if (method_exists($instance, $action)) {
			return call_user_func_array([$instance, $action], $params);
		}
		return DebugX::oversight($organizr, 'Organizr: Method Unavailable', $action);
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





	// • ==== enact → ... »
	protected static function enact($uri, $method) {
		$uri = self::clean($uri, true);
		$ismatch = self::ismatch($uri, $method);
		if ($ismatch !== false) {
			return self::handler($ismatch['handler'], $ismatch['params']);
		}
		return;
	}





	// • ==== get → ... »
	public static function get($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['GET'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~get: "' . $uri . '"');
		}
		self::make('GET', $uri, $handler);
		return self::enact($uri, 'GET');
	}





	// • ==== post → ... »
	public static function post($uri, $handler) {
		self::init();
		if (array_key_exists($uri, self::$routes['POST'])) {
			return DebugX::oversight(__CLASS__, 'Route Duplicate', '~post: "' . $uri . '"');
		}
		self::make('POST', $uri, $handler);
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
		self::make('GET', $uri, $handler);
		self::make('POST', $uri, $handler);
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
	public static function ismethod($method) {
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
	protected static function ismatch($uri, $method, $returnBool = false) {
		$uri = self::clean($uri, true);
		if (self::inroute($uri, $method)) {
			if (StringX::contain($uri, '{')) {
				$pattern = self::pattern($uri);
				if (preg_match($pattern, self::$is->route, $matches)) {
					array_shift($matches);
					if ($returnBool) {
						return true;
					}
					return ['handler' => self::$routes[$method][$uri], 'params' => $matches];
				}
			} elseif (self::isuri($uri) && self::ismethod($method)) {
				if ($returnBool) {
					return true;
				}
				if ($method === 'ANY') {
					$method = 'GET';
				}
				return ['handler' => self::$routes[$method][$uri], 'params' => []];
			}
		}
		return false;
	}





	// • ==== is → ... »
	public static function is($route = null, $method = 'ANY') {
		if (is_null($route)) {
			$route = self::$is->route;
			return self::clean($route, false);
		} elseif (strlen($route) > 0) {
			return self::ismatch($route, $method, true);
		}
	}





	// • ==== isGet → ... »
	public static function isGet($route = null) {
		return self::is($route, 'GET');
	}





	// • ==== isPost → ... »
	public static function isPost($route = null) {
		return self::is($route, 'POST');
	}





	// • ==== isAny → ... »
	public static function isAny($route = null) {
		return self::is($route, 'ANY');
	}





	// • ==== to → ... »
	public static function to($route) {
		if (StringX::beginWithAny($route, ['https://', 'http://'])) {
			return $route;
		}
		//TODO: improve code
		$uri = self::clean($route);
		return $uri;
	}





	// • ==== redirect → ... »
	public static function redirect($route){
		$uri = self::to($route);
		return RedirectX::now($uri);
	}






	// • ==== e404 → ... »
	public static function e404($view = '404') {
		self::init();
		$valid = self::inroute(self::$is->route, self::$is->method);
		if (!$valid) {
			if (!is_null($view)) {
				return FrontendX::view($view);
			}
			// TODO: improve code
		}
	}


} //> end of RouteX
