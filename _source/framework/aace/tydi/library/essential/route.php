<?php
/*** Route ~ Route Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

class Route extends Link {

	// ◇ PROPERTY
	public static $codify;
	public static $ario;
	protected static $source;
	protected static $project;
	protected static $routes = [];





	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
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

			// » URL
			elseif ($req === 'URL') {
				return parent::$base->url;
			}

			// » Hostname
			elseif ($req === 'HOSTNAME') {
				return parent::$base->hostname;
			}

			// » Domain
			elseif ($req === 'DOMAIN') {
				return parent::$base->domain;
			}

			// » Spring
			elseif ($req === 'SPRING') {
				return parent::$base->spring;
			}

			// » Host
			elseif ($req === 'HOST') {
				return parent::$base->host;
			}

			// » TLD
			elseif ($req === 'TLD') {
				return parent::$base->tld;
			}

			// » VERSION
			elseif (strtoupper($req) === 'VERSION') {
				return parent::$link->version;
			}

			// » STATUS
			elseif ($req === 'STATUS') {
				return parent::$link->status;
			}

			// » ACTION
			elseif ($req === 'ACTION') {
				return parent::$link->action;
			}

			// » REFERRER
			elseif ($req === 'REFERRER') {
				return parent::$link->ref;
			}

			// » LINK
			elseif (strtoupper($req) === 'LINK') {
				return parent::$link->is;
			}

			// » URI
			elseif (strtoupper($req) === 'URI') {
				return self::$uri;
			}

			// » PROJECT TITLE
			elseif ($req === 'PROJECT_TITLE') {
				return self::$project['title'];
			}

			// » PROJECT BRAND
			elseif ($req === 'BRAND') {
				return self::$project['brand'];
			}

			// » SUPPORT EMAIL
			elseif ($req === 'SUPPORT_EMAIL') {
				if (VarX::is(self::$project['support']['email'])) {
					return self::$project['support']['email'];
				}
			}

			// » ROUTES
			elseif (strtoupper($req) === 'ROUTES') {
				return self::$routes;
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





	// ◇ ----- INITIALIZE • Initialize » Boolean [True]
	public static function initialize($setting = [], $libraryOfSubdomain = []) {

		// » ARIO - Set
		if (ArrayX::isKeyNotEmpty($setting, 'ario')) {
			self::$ario = $setting['ario'];
		}

		// » Initialize link
		if (ArrayX::isKeyNotEmpty($setting, 'version')) {
			parent::initialize(['version' => $setting['version']], $libraryOfSubdomain);
		} else {
			parent::initialize([], $libraryOfSubdomain);
		}

		// » ROUTES - Set
		if (ArrayX::isKeyNotEmpty($setting, 'routes')) {
			self::$routes = $setting['routes'];
		}

		// » Prepare & Set source
		if (ArrayX::isKeyNotEmpty($setting, 'source')) {
			self::$source = $setting['source'];
		}
		if (VarX::isEmpty(self::$source)) {
			$source = parent::$base->spring;
			if (VarX::isNotEmpty($source) && ArrayX::isNotValue(['api', 'app', 'www'], $source)) {
				self::$source = $source;
			} else {
				self::$source = 'zero';
			}
		}


		// » Prepare & Set Project
		if (ArrayX::isKeyNotEmpty($setting, 'project')) {
			self::$project = $setting['project'];
		} else {
			self::$project = ['title' => FRAMEWORK];
		}
		self::$project['engine'] = FRAMEWORK . '™';

		return true;
	}





	// ◇ ----- ROUTZR • Load Routzr (detected or provided - if available) »
	public static function routzr($routzr = '') {
		if (VarX::isNotEmpty($routzr)) {
			File::load($routzr, '', [], 'Routzr');
		} else {
			File::append(SOURCE['rout'] . parent::$platform . '.php');
			File::append(SOURCE['rout'] . 'routzr.php');
			File::append(SD . 'routzr.php');
		}

		Tydi::trace('<p><b>WARNING</b> :: Routzr • Unavailable or Not Terminated! <br><em>(If intentional, comment line ' . __LINE__ . ' on ' . File::base(__FILE__) . ')</em></p>');
	}





	// ◇ ----- URL •
	public static function isURL($req = 'DATA', $method = 'REQUEST') {
		if ($req === 'DATA') {
			return parent::$base->url;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === parent::$base->url && parent::method($method)) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- HOST •
	public static function isHost($req = 'DATA', $method = 'REQUEST') {
		if ($req === 'DATA') {
			return parent::$base->host;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === parent::$base->host && parent::method($method)) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- HOSTNAME •
	public static function isHostname($req = 'DATA', $method = 'REQUEST') {
		if ($req === 'DATA') {
			return parent::$base->hostname;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === parent::$base->hostname && parent::method($method)) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- DOMAIN •
	public static function isDomain($req = 'DATA', $method = 'REQUEST') {
		if ($req === 'DATA') {
			return parent::$base->domain;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === parent::$base->domain && parent::method($method)) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- SPRING •
	public static function isSpring($req = 'DATA') {
		if ($req === 'DATA') {
			return parent::$base->spring;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === parent::$base->spring) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- SOURCE •
	public static function isSource($req = 'DATA') {
		if ($req === 'DATA') {
			return self::$source;
		} elseif (VarX::isNotEmpty($req)) {
			if ($req === self::$source) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- PROJECT •
	public static function isProject() {
		return self::$project;
	}





	// ◇ ----- IS_SITE •
	public static function isSite() {
		if (self::platform('DATA') === 'site') {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_APP •
	public static function isApp() {
		if (self::platform('DATA') === 'app') {
			return true;
		}
		return false;
	}






	// ◇ ----- IS_API •
	public static function isAPI() {
		if (self::platform('DATA') === 'api') {
			return true;
		}
		return false;
	}





	// ◇ ----- IS LANDING •
	public static function isLanding($model = '', $routes = [], $action = '') {
		if (VarX::isEmpty($model)) {
			$model = self::$codify->model;
		}

		if (VarX::isEmpty($action)) {
			$action = self::$link->action;
		}

		if (VarX::isEmpty($routes)) {
			$routes = self::$routes;
		}

		if ($action === 'landing') {
			if (ArrayX::isKey($routes, $model) || (ArrayX::isValue($routes, $model) && is_numeric(ArrayX::keyByValue($routes, $model)))) {
				return true;
			}
		}

		return false;
	}










	// ◇ ----- IS MODEL •
	public static function isModel($req = 'IS') {
		// » Retrieve value of link-action
		if ($req === 'IS') {
			return self::$codify->model;
		}
	}





	// ◇ ----- IS VALID •
	public static function isValid($model = '', $action = '', $routes = []) {
		if (VarX::isEmpty($model)) {
			$model = self::$codify->model;
		}

		if (VarX::isEmpty($action)) {
			$action = self::$link->action;
		}

		if (VarX::isEmpty($routes)) {
			$routes = self::$routes;
		}

		if ($action === 'landing') {
			return self::isLanding($model, $routes, $action);
		} else {
			if (ArrayX::isKey($routes, $model) && ArrayX::isValue($routes[$model], $action)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- CODIFY • Set Class & Method for Link » Boolean
	public static function codify() {
		$codify = [];

		// » Model
		$model = StringX::swap(parent::$link->is, '-', '_');
		$model = StringX::noSpace(strtolower($model));
		if (VarX::isNotEmpty($model)) {
			$codify['model'] = $model;
		}

		// » Name
		$name = StringX::swapSpace(parent::$link->is, '-', true);
		$name = StringX::swapSpace($name, '_', true);
		$name = StringX::noSpace(ucwords(strtolower($name)));
		if (VarX::isNotEmpty($name)) {
			$codify['name'] = $name;
		}

		// » Method
		$method = StringX::swapSpace(parent::$link->action, '-', true);
		$method = StringX::swapSpace($method, '_', true);
		$method = lcfirst(StringX::noSpace(ucwords(strtolower($method))));
		if (VarX::isNotEmpty($method)) {
			$codify['method'] = $method;
		}

		// » View
		$view = '';


		self::$codify = ArrayX::toObj($codify);
		return true;
	}





	// ◇ ----- ORGANIZR • Organizer »
	public static function organizr() {
		if (parent::$platform === 'site') {
			$file = SOURCE['organ'] . 'site.php';
		}

		//...If platform is not Site
		else {
			$directory = SOURCE['organ'];
			$platformDirectory = SOURCE[parent::$platform];

			if (VarX::isNotEmpty(parent::$link->version) && Folder::is($directory . parent::$link->version . DS)) {
				$directory .= parent::$link->version . DS;
			}

			if (VarX::isNotEmpty(parent::$link->version) && Folder::is($platformDirectory . parent::$link->version . DS)) {
				$platformDirectory .= parent::$link->version . DS;
			}

			$uri = self::property('URI');
			if (StringX::contain($uri, PS . 'master' . PS)) {
				$file = $platformDirectory . 'master' . DS . strtolower(self::$codify->name) . '.php';
			} elseif (StringX::contain($uri, PS . 'admin' . PS)) {
				$file = $platformDirectory . 'admin' . DS . strtolower(self::$codify->name) . '.php';
			} elseif (StringX::contain($uri, PS . 'user' . PS)) {
				$file = $platformDirectory . 'user' . DS . strtolower(self::$codify->name) . '.php';
			} else {
				$file = $platformDirectory . strtolower(self::$codify->name) . '.php';
			}

			if (!File::is($file)) {
				$file = StringX::stripLast($platformDirectory, parent::$link->version . DS) . strtolower(self::$codify->name) . '.php';
			}

			if (!File::is($file)) {
				$file = $directory . strtolower(self::$codify->name) . '.php';
			}

			if (!File::is($file)) {
				$file = StringX::stripLast($directory, parent::$link->version . DS) . strtolower(self::$codify->name) . '.php';
			}

			if (!File::is($file)) {
				$file = $directory . parent::$platform . '.php';
			}

			if (!File::is($file)) {
				$file = SOURCE['organ'] . strtolower(self::$codify->name) . '.php';
			}
		}

		return $file;
	}





	// ◇ ----- MODELIZR • Model »
	public static function modelizr() {
		$file = SOURCE['model'] . parent::$platform . DS . strtolower(self::$codify->name) . '.php';
		if (!File::is($file)) {
			$file = SOURCE['model'] . parent::$platform . '.php';
		}
		if (!File::is($file)) {
			$file = SOURCE['model'] . strtolower(self::$codify->name) . '.php';
		}
		return $file;
	}





	// ◇ ----- TITLE •
	public static function title() {
		$title = '';

		if (self::$codify->method !== 'landing') {
			$title .= ucwords(StringX::uppercaseToSpace(self::$codify->method)) . ' ';
		}
		if (self::$codify->name !== 'Index') {
			if (StringX::uppercaseCount(self::$codify->method) > 0) {
				$title .= '| ';
			}
			$title .= ucwords(self::$codify->name) . ' ';
		}
		if (VarX::hasData($title)) {
			$title .= ' - ';
		}
		$title .= self::$project['title'] . ' ';
		$title .= ' • ' . self::$project['brand'];
		return $title;
	}





	// ◇ ----- TERMINATE • End Program »
	public static function terminate() {
		return Tydi::end();
	}

} // End Of Class ~ Route