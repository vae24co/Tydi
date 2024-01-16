<?php
/*** APP ~ APP Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/
class App extends Route {

	// ◇ PROPERTY
	protected static $directory;





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
			} else {
				return parent::property($req);
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




	// ◇ ----- RESOLVE • Resolve & Return Response »
	public static function resolve($response) {
		if (VarX::isEmpty($response)) {
			$response = ErrorX::string('NO_RESPONSE');
		} elseif (VarX::stringAcceptable($response) && StringX::begin($response, 'ERROR_')) {
			$response = ErrorX::string(StringX::cropBegin($response, 'ERROR_'));
		}

		$response = ErrorX::data($response);
		if (ArrayX::isKeyNotEmpty($response, 'status') && $response['status'] === 'F9') {
			// TODO: Log Error!
		}
		$response = Tydi::resolver($response);
		return Tydi::display($response, 'TRACE');
	}







	// ◇ ----- INITIALIZE • Initialize API » Boolean
	public static function initialize($setting = [], $libraryOfSubdomain = []) {


		// + Initialize/Re-Initialize Route
		if (VarX::isNotEmpty($setting)) {
			parent::initialize($setting, $libraryOfSubdomain);
		}


		// + Codify
		parent::codify();


		// + Initialize & Set Directory (append version path, if available)
		if (VarX::isEmpty(self::$directory)) {
			self::$directory = ObjectX::make();
		}

		self::$directory->utilizr = SOURCE['util'];
		if (Folder::is(self::$directory->utilizr . parent::$link->version)) {
			self::$directory->utilizr .= parent::$link->version . DS;
		}

		self::$directory->layoutzr = SOURCE['layout'];
		if (Folder::is(self::$directory->layoutzr . parent::$link->version)) {
			self::$directory->layoutzr .= parent::$link->version . DS;
		}

		self::$directory->slicezr = SOURCE['slice'];
		if (Folder::is(self::$directory->slicezr . parent::$link->version)) {
			self::$directory->slicezr .= parent::$link->version . DS;
		}

		self::$directory->formzr = SOURCE['form'];
		if (Folder::is(self::$directory->formzr . parent::$link->version)) {
			self::$directory->formzr .= parent::$link->version . DS;
		}

		self::$directory->viewzr = SOURCE['view'];
		if (Folder::is(self::$directory->viewzr . parent::$link->version)) {
			self::$directory->viewzr .= parent::$link->version . DS;
		}

		self::$directory->tablezr = SOURCE['table'];
		if (Folder::is(self::$directory->tablezr . parent::$link->version)) {
			self::$directory->tablezr .= parent::$link->version . DS;
		}


		// + Return True
		return true;
	}





	// ◇ ----- IS •
	public static function is($req = 'APP', $method = 'REQUEST') {

		//...Check if Platform is APP
		if ($req === 'APP') {
			return parent::isApp();
		}

		//...Check from Parent class
		else {
			return parent::is($req, $method);
		}
	}





	// ◇ ----- LAYOUT •
	public static function layout($layout, &$content = [], $view = null) {
		$layout = self::$directory->layoutzr . $layout . '.php';
		if (File::is($layout)) {
			if (VarX::isNotEmptyArray($content)) {
				$content = ArrayX::toObj($content);
			}
			require $layout;
		} else {
			return File::check($layout, 'layout');
		}
	}





	// ◇ ----- SLICE •
	public static function slice($slice = null, &$content = []) {
		if (VarX::hasNoData($slice)) {
			$slice = self::isAction();
		}
		$slice = self::$directory->slicezr . $slice . '.php';
		if (File::is($slice)) {
			if (VarX::isNotEmptyArray($content)) {
				$content = ArrayX::toObj($content);
			}
			require $slice;
		} else {
			return Tydi::trace('<p><strong>Slice Unavailable → </strong> ['.$slice.']</p>');
		}
	}





	// ◇ ----- FORM •
	public static function form($form = null, &$content = []) {
		if (VarX::hasNoData($form)) {
			$form = self::isAction();
		}
		$form = self::$directory->formzr . $form . '.php';
		if (File::is($form)) {
			if (VarX::isNotEmptyArray($content)) {
				$content = ArrayX::toObj($content);
			}
			require $form;
		} else {
			return Tydi::trace('<p><strong>Form Unavailable → </strong> ['.$form.']</p>');
		}
	}





	// ◇ ----- TABLE •
	public static function table($table, &$content = []) {
		$table = self::$directory->tablezr . $table . '.php';
		if (File::is($table)) {
			if (VarX::isNotEmptyArray($content)) {
				$content = ArrayX::toObj($content);
			}
			require $table;
		} else {
			return Tydi::trace('<p><strong>Table Unavailable → </strong> ['.$table.']</p>');
		}
	}





	// ◇ ----- VIEW •
	public static function view(&$content = [], $view = null, $fallback = null) {

		if (VarX::hasNoData($view)) {
			$view = self::$directory->viewzr;
			if (Folder::is($view . self::isModel())) {
				$view .= self::isModel() . DS . self::isAction() . '.php';
			} else {
				$file = $view . self::isModel() . '.php';
				if (File::isNot($file)) {
					$file = $view . self::isAction() . '.php';
				}
				$view = $file;
			}
		}
		if (VarX::hasNoData($fallback)) {
			$fallback = self::$directory->viewzr . 'fallback.php';
		}
		if (File::is($view)) {
			if (VarX::isNotEmptyArray($content)) {
				$content = ArrayX::toObj($content);
			}
			require $view;
		} else {
			if (VarX::hasData($fallback)) {
				if (File::is($fallback)) {
					require $fallback;
				} else {
					Tydi::trace('ERROR:: <em>(' . $view . ')</em>');
				}
			} else {
				return File::check($view, 'view');
			}
		}
	}





	// ◇ ----- IGNITE •
	public static function ignite() {
		$organizr = parent::organizr();
		$object = parent::$codify->name;
		$method = parent::$codify->method;
		if (StringX::contain($organizr, DS . 'appzr' . DS)) {
			$object .= 'App';
		} elseif (StringX::contain($organizr, DS . 'organizr' . DS)) {
			$object .= 'zr';
		}
		File::load($organizr, 'load App', '', $object);
		$caller = new $object;
		$method = lcfirst($method);
		if (!method_exists($caller, $method)) {
			$error = ['code' => 'C501DE', 'title' => 'Route Undefined', 'object' => $object . '::' . $method . '()'];
			return self::resolve($error);
		}

		return $caller->$method();
	}

}