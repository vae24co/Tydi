<?php
//*** Link » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Link {

	// ◇ property
	private static $request;
	protected static $base;
	protected static $link;
	protected static $uri;
	protected static $url;
	protected static $platform;




	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return oversight(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return oversight(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== isError → check for link error or bad link » [boolean]
	private static function isError($link, $uri) {

		// @ clean link
		$linkIndex = ['index', '/index', 'index/'];
		if (ArrayX::isValue($linkIndex, $link) || Vars::isEmpty($link)) {
			$link = 'index';
		}

		// @ URI (Api | App | Link)
		if (StringX::begin($uri, '/api/')) {
			$uri = StringX::cropBegin($uri, '/api/');
		} elseif (StringX::begin($uri, '/app/')) {
			$uri = StringX::cropBegin($uri, '/app/');
		} elseif (StringX::begin($uri, '/')) {
			$uri = StringX::cropBegin($uri, '/');
		}

		// @ clean URI
		if ($uri === '/' || Vars::isEmpty($uri)) {
			$uri = 'index';
		}

		// @ return boolean
		if ($uri !== $link) {
			return true;
		}
		return false;
	}




	// ◇ ---- PROPERTY • Get & Set Class Property » Boolean | Mixed
	public static function property($property, $req = 'GET') {
		if (Vars::isEmpty($property) || Vars::isEmpty($req)) {
			return false;
		}

		// • GET
		elseif ($req === 'GET') {
			if (Vars::isString($property) && isset(self::$$property)) {
				return self::$$property;
			}

			// » Array
			elseif (Vars::isArray($property)) {
				$o = [];
				foreach ($property as $value) {
					if (isset(self::$$value)) {
						$o[$value] = self::$$value;
					}
				}
				return $o;
			}
		}

		// • SET
		elseif ($req === 'SET') {
		}

		return false;
	}











	// ◇ ---- METHOD • Get/Compare (HTTP Method) » Boolean | String
	public static function method($req = 'IS') {
		if (Vars::isNotEmpty($req)) {
			return HTTPX::method($req);
		}
		return false;
	}





	// ◇ ---- BASE • Set/Get/Compare ($base object & keys) » Boolean | String
	public static function base($req, $libraryOfSubdomain = []) {

		// • Prepare base & return true
		if ($req === 'SET') {
			$base = [];

			$base['url'] = URLX::base();
			$base['hostname'] = URLX::to('BASE', 'HOSTNAME');
			$base['domain'] = StringX::cropBegin(URLX::to('BASE', 'DOMAIN', $libraryOfSubdomain), 'zero.');

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


		// • Retrieve value of base
		elseif ($req === 'IS') {
			return self::$base;
		}


		// • Return specific base-property
		elseif (StringX::is($req) && isset(self::$base->$req)) {
			return self::$base->$req;
		}


		// • Does input match base-property?
		elseif (ArrayX::is($req)) {
			$key = ArrayX::firstKey($req);
			if (isset(self::$base->$key) && $req[$key] === self::$base->$key) {
				return true;
			}
		}

		return false;
	}





	// ◇ ---- REF • Referrer ... »
	public static function ref($req) {

		// • Prepare referer & return true;
		if ($req === 'SET') {
			self::$link->ref = URLX::ref();
			return true;
		}

		// • Retrieve value of referer
		elseif ($req === 'IS') {
			return self::$link->ref;
		}


		// • Does input match referer?
		elseif (StringX::is($req) && $req === self::$link->ref) {
			return true;
		}
		return false;
	}





	// ◇ ---- URI • Set/Get/Compare (URI) » String | Boolean
	public static function uri($req, $method = 'REQUEST') {

		// • Prepare URI & return true
		if ($req === 'SET') {
			$uri = URLX::uri();

			// » Handle possible /auth/index
			if ($uri !== 'index' && $uri !== 'index/') {
				$uri = StringX::cropEnd($uri, 'index/');
				$uri = StringX::cropEnd($uri, 'index');
			}

			// » Handle possible //link (// in uri)
			$uri = StringX::swap($uri, '//', '/');


			self::$uri = $uri;
			return true;
		}


		// • Retrieve value of URI
		elseif ($req === 'IS') {
			return self::$uri;
		}


		// • Does input match URI & method?
		elseif (StringX::is($req) && StringX::is($method)) {
			if ($req === self::$uri && self::method($method)) {
				return true;
			}
		}

		return false;
	}




	// ◇ ---- SET • Set link object » Boolean [True]
	public static function set() {

		// @ CREATE: link object if doesn't exist
		if (!ObjectX::is(self::$link)) {
			self::$link = ObjectX::make();
		}


		// @ CREATE: request object if doesn't exist
		if (ObjectX::isEmpty(self::$request)) {
			self::$request = ArrayX::toObj(HTTPX::get('DATA'));
		}

		// @ PREPARE: link object
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


		if (Vars::is($link)) {
			$linkError = self::isError($link, $uri);
			if ($linkError) {
				oversight('Link', 'Critical - Issues with URL (Possibly on htaccess)');
			}
		} elseif (!HTTPX::isHTTPError($request)) {
			$getRequest = HTTPX::get('DATA');
			oversight('Link', ' Critical - No Link', $getRequest);
		}


		// • Prepare link-version
		if (Vars::isNotEmpty(self::$link->version)) {
			$link = StringX::cropBegin($link, self::$link->version . '/');
		}


		// • Prepare link-status
		if (StringX::contain($link, '!')) {
			$status = StringX::after($link, '!');
			$link = StringX::before($link, '!');
		}
		if (Vars::isEmpty($status)) {
			self::$link->status = 'default';
		} else {
			$status = StringX::swap($status, '/', '-');
			$status = StringX::swap($status, '_', '-');
			self::$link->status = StringX::crop($status, '-');
		}


		// • Prepare link-action
		if (StringX::contain($link, '/')) {
			$action = StringX::after($link, '/');
			$link = StringX::before($link, '/');
		}
		if (Vars::isEmpty($action)) {
			$action = 'landing';
		}

		if (Vars::isNotEmpty($action)) {
			$action = StringX::swap($action, '_', '-');
			$action = StringX::swap($action, '/', '-');
			self::$link->action = StringX::crop($action, '-');
		}


		// • Create link-is
		if (Vars::isNotEmpty($link)) {
			$link = StringX::swap($link, '_', '-');
		}

		if (Vars::isNotEmpty($link)) {
			self::$link->is = StringX::crop($link, '-');
		} else {
			self::$link->is = 'index';
		}

		return true;
	}





	// ◇ ---- VERSION • Set/Get ($link->version) » String | Boolean
	public static function version($req = 'DATA') {

		// • Prepare link-version & return true
		if (StringX::isNotEmpty($req)) {
			self::$link->version = $req;
			self::set();
			return true;
		}


		// • Retrieve value of link-version
		elseif ($req === 'DATA') {
			return self::$link->version;
		}

		return false;
	}





	// ◇ ---- INITIALIZE • Initialize » Boolean
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
			self::$request = ArrayX::toObj(HTTPX::get('DATA'));
		}

		self::base('SET', $libraryOfSubdomain);
		self::ref('SET');
		self::uri('SET');
		self::$url = self::$base->url . self::$uri;

		if (Vars::isNotEmpty($setting['version'])) {
			self::version($setting['version']);
		}

		self::set();
		self::platform('SET');
		return true;
	}





	// ◇ ---- IS • Get/Compare ($link->is) » Boolean | String
	public static function is($req = 'IS', $method = 'REQUEST') {

		// • Retrieve value of link-is
		if ($req === 'IS') {
			return self::$link->is;
		}


		// • Does input match link-is & method?
		elseif (Vars::isNotEmpty($req) && Vars::isNotEmpty($method)) {
			if ($req === self::$link->is && self::method($method)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ---- IS_ACTION • Get/Compare ($link->action) » Boolean | String
	public static function isAction($req = 'IS', $method = 'REQUEST') {

		// • Retrieve value of link-action
		if ($req === 'IS') {
			return self::$link->action;
		}


		// • Does input match link-action & method?
		elseif (Vars::isNotEmpty($req) && Vars::isNotEmpty($method)) {
			if ($req === self::$link->action && self::method($method)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ---- IS_STATUS • Get/Compare ($link->status) » Boolean | String
	public static function isStatus($req = 'IS', $method = 'REQUEST') {

		// • Retrieve value of link-status
		if ($req === 'IS') {
			return self::$link->status;
		}


		// • Does input match link-status & method?
		elseif (Vars::isNotEmpty($req) && Vars::isNotEmpty($method)) {
			if ($req === self::$link->status && self::method($method)) {
				return true;
			}
		}

		return false;
	}






	// ◇ ---- INDEX • Check if Link is Index » Boolean
	public static function isIndex($method = 'REQUEST') {
		if (self::method($method) && self::$link->is === 'index') {
			return true;
		}
		return false;
	}




	// ◇ ---- ROUTE • URI is exactly » Boolean
	public static function route($input, $method = 'REQUEST', $strip = '') {
		$input = StringX::cropBegin($input, '/');
		$uri = StringX::cropBegin(self::$uri, '/');
		if (Vars::isNotEmpty($strip)) {
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





	// ◇ ---- BEGIN • URI begins with » Boolean
	public static function begin($input, $method = 'REQUEST', $strip = '') {
		$input = StringX::cropBegin($input, '/');
		$uri = StringX::cropBegin(self::$uri, '/');
		if (Vars::isNotEmpty($strip)) {
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





	// ◇ ---- END • URI ends with » Boolean
	public static function end($input, $method = 'REQUEST') {
		$input = StringX::crop($input, '/');
		$uri = StringX::crop(self::$uri, '/');
		if (StringX::end($uri, $input) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ---- CONTAIN • URI contains » Boolean
	public static function contain($input, $method = 'REQUEST') {
		if (StringX::contain(self::$uri, $input) && self::method($method)) {
			return true;
		}
		return false;
	}





	// ◇ ---- PATTERN • Match URI » Boolean & ...
	public static function pattern($pattern, $method = 'REQUEST') {
		if (self::method($method)) {
			// • Pattern :: Link (/user/admin-login)
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





	// ◇ ---- IS_GET • Match Link Pattern (Get Method) » Boolean
	public static function isGet($pattern = null) {
		if (Vars::noData($pattern)) {
			return self::isMethod('GET');
		}
		return self::pattern($pattern, 'GET');
	}





	// ◇ ---- IS_POST • Match Link Pattern (Post Method) » Boolean
	public static function isPost($pattern = null) {
		if (Vars::noData($pattern)) {
			return self::isMethod('POST');
		}
		return self::pattern($pattern, 'POST');
	}





	// ◇ ---- IS_REQUEST • Match Link Pattern (Request Method) » Boolean
	public static function isRequest($pattern) {
		return self::pattern($pattern, 'REQUEST');
	}




















	// ◇ ==== toWWW → redirect site url to www » [boolean]
	public static function toWWW() {
		if (self::$platform === 'site') {
			$url = 'https://www.' . self::$base->domain;
			if (StringX::begin(self::$base->hostname, 'zero.') && self::$base->spring === 'zero') {
				return RedirectX::instant($url);
			} elseif (!StringX::begin(self::$base->hostname, 'www.') && self::$base->spring === 'zero' && self::$base->spring !== 'www') {
				return RedirectX::instant($url);
			}
		}
		return true;
	}




	// ◇ ==== isSecure → check if url is HTTPS » [boolean]
	public static function isSecure() {
		if (StringX::begin(self::$base->url, 'https://')) {
			return true;
		}
		return false;
	}





















	// ◇ ---- IS METHOD • Compare (HTTP Method) » Boolean
	public static function isMethod($method) {
		if ($method === 'REQUEST') {
			return HTTPX::method('REQUEST');
		}
		if (self::method('IS') === strtoupper($method)) {
			return true;
		}
		return false;
	}





	// ◇ ---- IS NOT METHOD • Compare (HTTP Method) » Boolean
	public static function isNotMethod($method) {
		if (!self::isMethod($method)) {
			return true;
		}
		return false;
	}





	// ◇ ---- APPEND •
	public static function append($append, $uri = null) {
		if (Vars::noData($uri)) {
			$uri = App::property('uri');
		}
		if (Vars::hasData($append)) {
			$param = StringX::after($uri, '?');
			if (Vars::hasData($param)) {
				$param = '?' . $param;
				$uri = StringX::swap($uri, $param, '');
			}
			if (!StringX::contain($uri, $append)) {
				if (StringX::contain($uri, '!')) {
					$uri = StringX::before($uri, '!');
				}
				$uri .= $append;
			}
			return $uri . $param;
		}
		return $uri;
	}





	// ◇ ---- APPEND SUCCESS •
	public static function appendSuccess($uri = null) {
		return self::append('!success', $uri);
	}





	// ◇ ---- APPEND FAILURE •
	public static function appendFailure($uri = null) {
		return self::append('!failure', $uri);
	}





	// ◇ ---- APPEND_ERROR •
	public static function appendError($uri = null) {
		return self::append('!error', $uri);
	}

} // End Of Class ~ Link