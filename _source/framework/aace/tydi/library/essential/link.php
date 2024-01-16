<?php
/*** URI ~ URI Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class Link {

	// ◇ PROPERTY
	private static $request;
	protected static $base;
	protected static $link;
	protected static $uri;
	protected static $url;
	protected static $platform;





	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- LINK_ERROR • Check for link error » Boolean
	private static function linkError($link, $uri) {

		// ...Clean link
		$linkIndex = ['index', '/index', 'index/'];
		if (ArrayX::isValue($linkIndex, $link) || VarX::isEmpty($link)) {
			$link = 'index';
		}

		// ...API
		if (StringX::begin($uri, '/api/')) {
			$uri = StringX::cropBegin($uri, '/api/');
		}

		// ...APP
		elseif (StringX::begin($uri, '/app/')) {
			$uri = StringX::cropBegin($uri, '/app/');
		}

		// ...
		elseif (StringX::begin($uri, '/')) {
			$uri = StringX::cropBegin($uri, '/');
		}


		// ...Clean URI
		if ($uri === '/' || VarX::isEmpty($uri)) {
			$uri = 'index';
		}

		if ($uri !== $link) {
			return true;
		}

		return false;
	}





	// ◇ ----- PROPERTY • Get Class Property » Boolean | Mixed
	public static function property($req) {
		if (VarX::isEmpty($req)) {
			return false;
		} elseif (StringX::is($req)) {
			if ($req === 'PROPERTIES') {
				return Tydi::reflectClass(__CLASS__, 'PROPERTY');
			} elseif (isset(self::$$req)) {
				return self::$$req;
			}
		} elseif (ArrayX::is($req)) {
			$res = [];
			foreach ($req as $property) {
				if (isset(self::$$property)) {
					$res[$property] = self::$$property;
				}
			}
			return $res;
		}
		return false;
	}





	// ◇ ----- PLATFORM • Set/Get/Compare (platform) » Boolean | String
	public static function platform($req = 'DATA') {

		// » Prepare platform & return true
		if ($req === 'SET') {
			if (ObjectX::isKeyNotEmpty(self::$request, 'oplatform')) {
				self::$platform = self::$request->oplatform;
			}

			if (self::$platform !== 'api' && (strtolower(self::$request->ospring) === 'api' || strtolower(self::$request->oplatform) === 'api')) {
				self::$platform = 'api';
			}
			if (self::$platform !== 'api' && (strtolower(self::$request->ospring) === 'app' || strtolower(self::$request->oplatform) === 'app')) {
				self::$platform = 'app';
			}
			if (self::$platform !== 'api' && self::$platform !== 'app') {
				self::$platform = 'site';
			}
			return true;
		}


		// » Retrieve value of platform
		if ($req === 'DATA') {
			return self::$platform;
		}


		// » Does input match platform?
		elseif (($req === 'SITE' || $req === 'APP' || $req === 'API') && strtolower($req) === self::$platform) {
			return true;
		}

		return false;
	}





	// ◇ ----- METHOD • Get/Compare (HTTP Method) » Boolean | String
	public static function method($req = 'IS') {
		if (VarX::isNotEmpty($req)) {
			return HTTP::method($req);
		}
		return false;
	}





	// ◇ ----- BASE • Set/Get/Compare ($base object & keys) » Boolean | String
	public static function base($req, $libraryOfSubdomain = []) {

		// » Prepare base & return true
		if ($req === 'SET') {
			$base = [];

			$base['url'] = URL::base();
			$base['hostname'] = URL::to('BASE', 'HOSTNAME');
			$base['domain'] = StringX::cropBegin(URL::to('BASE', 'DOMAIN', $libraryOfSubdomain), 'zero.');

			if (isset(self::$request->ospring)) {
				$base['spring'] = self::$request->ospring;
			}
			if (isset(self::$request->ohost)) {
				$base['host'] = self::$request->ohost;
			}
			if (isset(self::$request->otld)) {
				$base['tld'] = self::$request->otld;
			}

			self::$base = ArrayX::toObj($base);
			return true;
		}


		// » Retrieve value of base
		elseif ($req === 'IS') {
			return self::$base;
		}


		// » Return specific base-property
		elseif (StringX::is($req) && isset(self::$base->$req)) {
			return self::$base->$req;
		}


		// » Does input match base-property?
		elseif (ArrayX::is($req)) {
			$key = ArrayX::firstKey($req);
			if (isset(self::$base->$key) && $req[$key] === self::$base->$key) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- REF • Referrer ... »
	public static function ref($req) {

		// » Prepare referer & return true;
		if ($req === 'SET') {
			self::$link->ref = URL::ref();
			return true;
		}

		// » Retrieve value of referer
		elseif ($req === 'IS') {
			return self::$link->ref;
		}


		// » Does input match referer?
		elseif (StringX::is($req) && $req === self::$link->ref) {
			return true;
		}
		return false;
	}





	// ◇ ----- URI • Set/Get/Compare (URI) » String | Boolean
	public static function uri($req, $method = 'REQUEST') {

		// » Prepare URI & return true
		if ($req === 'SET') {
			$uri = URL::uri();

			// ...Handle possible /auth/index
			if ($uri !== 'index' && $uri !== 'index/') {
				$uri = StringX::cropEnd($uri, 'index/');
				$uri = StringX::cropEnd($uri, 'index');
			}

			// ...Handle possible //link (// in uri)
			$uri = StringX::swap($uri, '//', '/');


			self::$uri = $uri;
			return true;
		}


		// » Retrieve value of URI
		elseif ($req === 'IS') {
			return self::$uri;
		}


		// » Does input match URI & method?
		elseif (StringX::is($req) && StringX::is($method)) {
			if ($req === self::$uri && self::method($method)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- SET • Set link object » Boolean [True]
	public static function set() {

		// ...Create link object if doesn't exist
		if (!ObjectX::is(self::$link)) {
			self::$link = ObjectX::make();
		}


		// ...Create request object if doesn't exist
		if (ObjectX::isEmpty(self::$request)) {
			self::$request = ArrayX::toObj(HTTP::get('DATA'));
		}

		// ...Prepare link object
		$request = self::$request;
		if (ObjectX::isKey($request, 'olink')) {
			$link = $request->olink;

			if ($link !== 'index' && $link !== 'index/') {
				$link = StringX::cropEnd($link, 'index/');
				$link = StringX::cropEnd($link, 'index');
			}
		}

		if (StringX::contain(self::$uri, '?')) {
			$uri = StringX::before(self::$uri, '?');
		} else {
			$uri = self::$uri;
		}

		if (VarX::is($link)) {
			$linkError = self::linkError($link, $uri);
			if ($linkError) {
				// Tydi::display('ERROR: A critical error - Possibly on htaccess');
				die('ERROR: Critical - Issues with URL (Possibly on htaccess)');
			}
		} else {
			die('ERROR: Critical - No Link');
		}


		// » Prepare link-version
		if (VarX::isNotEmpty(self::$link->version)) {
			$link = StringX::cropBegin($link, self::$link->version . '/');
		}


		// » Prepare link-status
		if (StringX::contain($link, '!')) {
			$status = StringX::after($link, '!');
			$link = StringX::before($link, '!');
		}
		if (VarX::isEmpty($status)) {
			self::$link->status = 'default';
		} else {
			$status = StringX::swap($status, '/', '-');
			$status = StringX::swap($status, '_', '-');
			self::$link->status = StringX::crop($status, '-');
		}


		// » Prepare link-action
		if (StringX::contain($link, '/')) {
			$action = StringX::after($link, '/');
			$link = StringX::before($link, '/');
		}
		if (VarX::isEmpty($action)) {
			$action = 'landing';
		}

		if (VarX::isNotEmpty($action)) {
			$action = StringX::swap($action, '_', '-');
			$action = StringX::swap($action, '/', '-');
			self::$link->action = StringX::crop($action, '-');
		}


		// » Create link-is
		if (VarX::isNotEmpty($link)) {
			$link = StringX::swap($link, '_', '-');
		}

		if (VarX::isNotEmpty($link)) {
			self::$link->is = StringX::crop($link, '-');
		} else {
			self::$link->is = 'index';
		}

		return true;
	}





	// ◇ ----- VERSION • Set/Get ($link->version) » String | Boolean
	public static function version($req = 'DATA') {

		// » Prepare link-version & return true
		if (StringX::isNotEmpty($req)) {
			self::$link->version = $req;
			self::set();
			return true;
		}


		// » Retrieve value of link-version
		elseif ($req === 'DATA') {
			return self::$link->version;
		}

		return false;
	}





	// ◇ ----- INITIALIZE • Initialize » Boolean
	public static function initialize(array $setting = [], array $libraryOfSubdomain = []) {
		if (!ObjectX::is(self::$request)) {
			self::$request = ObjectX::make();
		}
		if (!ObjectX::is(self::$base)) {
			self::$base = ObjectX::make();
		}
		if (!ObjectX::is(self::$link)) {
			self::$link = ObjectX::make();
		}
		if (ObjectX::isEmpty(self::$request)) {
			self::$request = ArrayX::toObj(HTTP::get('DATA'));
		}

		self::base('SET', $libraryOfSubdomain);
		self::ref('SET');
		self::uri('SET');
		self::$url = self::$base->url . self::$uri;

		if (VarX::isNotEmpty($setting['version'])) {
			self::version($setting['version']);
		}

		self::set();
		self::platform('SET');
		return true;
	}





	// ◇ ----- IS • Get/Compare ($link->is) » Boolean | String
	public static function is($req = 'IS', $method = 'REQUEST') {

		// » Retrieve value of link-is
		if ($req === 'IS') {
			return self::$link->is;
		}


		// » Does input match link-is & method?
		elseif (VarX::isNotEmpty($req) && VarX::isNotEmpty($method)) {
			if ($req === self::$link->is && self::method($method)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- IS_ACTION • Get/Compare ($link->action) » Boolean | String
	public static function isAction($req = 'IS', $method = 'REQUEST') {

		// » Retrieve value of link-action
		if ($req === 'IS') {
			return self::$link->action;
		}


		// » Does input match link-action & method?
		elseif (VarX::isNotEmpty($req) && VarX::isNotEmpty($method)) {
			if ($req === self::$link->action && self::method($method)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- IS_STATUS • Get/Compare ($link->status) » Boolean | String
	public static function isStatus($req = 'IS', $method = 'REQUEST') {

		// » Retrieve value of link-status
		if ($req === 'IS') {
			return self::$link->status;
		}


		// » Does input match link-status & method?
		elseif (VarX::isNotEmpty($req) && VarX::isNotEmpty($method)) {
			if ($req === self::$link->status && self::method($method)) {
				return true;
			}
		}

		return false;
	}






	// ◇ ----- INDEX • Check if Link is Index » Boolean
	public static function isIndex($method = 'REQUEST') {
		if (self::method($method) && self::$link->is === 'index') {
			return true;
		}
		return false;
	}




	// ◇ ----- ROUTE • URI is exactly » Boolean
	public static function route($input, $method = 'REQUEST', $strip = '') {
		$input = StringX::cropBegin($input, '/');
		$uri = StringX::cropBegin(self::$uri, '/');
		if (VarX::isNotEmpty($strip)) {
			if (StringX::end($strip, '/')) {
				$uri = StringX::cropBegin($uri, $strip);
			} else {
				$uri = StringX::cropBegin($uri, $strip . '/');
			}
		}

		if (StringX::compare($uri, $input, false) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ----- BEGIN • URI begins with » Boolean
	public static function begin($input, $method = 'REQUEST', $strip = '') {
		$input = StringX::cropBegin($input, '/');
		$uri = StringX::cropBegin(self::$uri, '/');
		if (VarX::isNotEmpty($strip)) {
			if (StringX::end($strip, '/')) {
				$uri = StringX::cropBegin($uri, $strip);
			} else {
				$uri = StringX::cropBegin($uri, $strip . '/');
			}
		}

		if (StringX::begin($uri, $input) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ----- END • URI ends with » Boolean
	public static function end($input, $method = 'REQUEST') {
		$input = StringX::crop($input, '/');
		$uri = StringX::crop(self::$uri, '/');
		if (StringX::end($uri, $input) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ----- CONTAIN • URI contains » Boolean
	public static function contain($input, $method = 'REQUEST') {
		if (StringX::contain(self::$uri, $input) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ----- PATTERN • Match URI » Boolean & ...
	public static function pattern($pattern, $method = 'REQUEST') {
		if (self::method($method)) {
			// » Pattern :: Link (/user/admin-login)
			if ($pattern === 'link') {
				// TODO: - Improve & Segment Custom Pattern
				$pattern = "/^[A-Z0-9-\/\?\_\!]+$/i";
			}

			if ($pattern === self::$uri) {
				return true;
			}
			return StringX::pattern(self::$uri, $pattern);
		}
		return false;
	}





	// ◇ ----- IS_GET • Match Link Pattern (Get Method) » Boolean
	public static function isGet($pattern = null) {
		if (VarX::hasNoData($pattern)) {
			return self::isMethod('GET');
		}
		return self::pattern($pattern, 'GET');
	}





	// ◇ ----- IS_POST • Match Link Pattern (Post Method) » Boolean
	public static function isPost($pattern = null) {
		if (VarX::hasNoData($pattern)) {
			return self::isMethod('POST');
		}
		return self::pattern($pattern, 'POST');
	}





	// ◇ ----- IS_REQUEST • Match Link Pattern (Request Method) » Boolean
	public static function isRequest($pattern) {
		return self::pattern($pattern, 'REQUEST');
	}





	// ◇ ----- TO_WWW • Redirect to www » Boolean
	public static function toWWW() {
		if (self::$platform === 'site') {
			$url = 'https://www.' . self::$base->domain;
			if (StringX::begin(self::$base->hostname, 'zero.') && self::$base->spring === 'zero') {
				return Redirect::instant($url);
			} elseif (!StringX::begin(self::$base->hostname, 'www.') && self::$base->spring === 'zero' && self::$base->spring !== 'www') {
				return Redirect::instant($url);
			}
		}
		return true;
	}





	// ◇ ----- IS_SECURE • Check if URL is HTTPS » Boolean
	public static function isSecure() {
		if (StringX::begin(self::$base->url, 'https://')) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS METHOD • Compare (HTTP Method) » Boolean
	public static function isMethod($method) {
		if ($method === 'REQUEST') {
			return HTTP::method('REQUEST');
		}
		if (self::method('IS') === strtoupper($method)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT METHOD • Compare (HTTP Method) » Boolean
	public static function isNotMethod($method) {
		if (!self::isMethod($method)) {
			return true;
		}
		return false;
	}

} // End Of Class ~ Link