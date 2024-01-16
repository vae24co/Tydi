<?php
/*** Site ~ Site Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

declare(strict_types=1);

class Site extends Route {

	// ◇ PROPERTY
	public static $lang;
	protected static $directory;
	protected static $ehttp;
	private static $page;
	private static $spet;





	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL STATIC • Non-Existent Static Method » Error
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





	// ◇ ----- INITIALIZE • ... » Boolean
	public static function initialize($setting = [], $libraryOfSubdomain = []) {

		//...Verify that platform is Site
		if (!parent::isSite()) {
			return false;
		}



		//...Set Language (from setting or url)
		if (ArrayX::isKeyNotEmpty($setting, 'lang')) {
			self::$lang = LangQ::set($setting['lang']);
			unset($setting['lang']);
		} else {
			self::$lang = LangQ::is('DATA');
		}



		//...Initialize & Set SPET
		if (ArrayX::isKeyNotEmpty($setting, 'spet')) {
			self::$spet = $setting['spet'];
			unset($setting['spet']);
		} else {
			self::$spet = false;
		}



		//...Initialize & Set Directory (append lang path, if available in settings)
		if (VarX::isEmpty(self::$directory)) {
			self::$directory = ObjectX::make();
			self::$directory->append = '';
		}

		if (ArrayX::isKeyNotEmpty($setting, 'langpath') && $setting['langpath']) {
			if (self::$lang !== 'en' && VarX::isNotEmpty(self::$lang)) {
				self::$directory->append = self::$lang . DS;
			}
			unset($setting['langpath']);
		}

		self::$directory->layoutzr = SOURCE['layout'] . self::$directory->append;
		self::$directory->pagezr = SOURCE['page'] . self::$directory->append;
		self::$directory->slicezr = SOURCE['slice'] . self::$directory->append;



		//...Set HTTP Error Page (from setting)
		if (ArrayX::isKeyNotEmpty($setting, 'ehttp')) {
			self::$ehttp = $setting['ehttp'];
			unset($setting['ehttp']);
		} else {
			self::$ehttp = SOURCE['page'] . 'ehttp.php';
		}



		//...Initialize/Re-Initialize Route
		if (VarX::isNotEmpty($setting)) {
			parent::initialize($setting, $libraryOfSubdomain);
		}


		//...Codify
		parent::codify();


		//...Initialize, Prepare & Set Page Object
		if (VarX::isEmpty(self::$page)) {
			self::$page = ObjectX::make();
		}

		//...Page Title
		if (parent::$codify->model === 'index') {
			self::$page->title = 'Home';
			self::$page->is = 'Home';
		} else {
			self::$page->title = StringX::crop(self::$uri, '/');
			self::$page->title = StringX::swapLast(self::$page->title, '/', ' » ');
			self::$page->title = StringX::swap(self::$page->title, '/', ' | ');
		}
		self::$page->title = StringX::swap(self::$page->title, '-', ' ');
		self::$page->title = StringX::swap(self::$page->title, '_', ' ');

		if(VarX::isEmpty(self::$page->is)){
			self::$page->is = ucwords(self::$page->title);
		}

		if (!empty(parent::$project['title'])) {
			self::$page->title .= ' • ' . parent::$project['title'];
		}
		if (!empty(parent::$project['brand'])) {
			self::$page->title .= ' - ' . parent::$project['brand'];
		}
		self::$page->title = ucwords(self::$page->title);


		//...Return True
		return true;
	}





	// ◇ ----- MAKER • The Maker »
	public static function maker($res = []) {

		//...Meta
		$res['meta']['uri'] = parent::$uri;
		$res['meta']['link'] = parent::$link->is;
		$res['meta']['model'] = parent::$codify->name;
		$res['meta']['method'] = parent::$codify->method;


		//...HTTP Error
		if (VarX::isEmpty($res['meta']['ehttp'])) {
			$res['meta']['ehttp'] = self::$ehttp;
		}


		//...Document
		if (VarX::isEmpty($res['meta']['document'])) {
			$res['meta']['document'] = self::$page->is;
		}


		//...Page
		if (VarX::isEmpty($res['meta']['page'])) {
			$res['meta']['page'] = self::$directory->pagezr . parent::$codify->model;
			if (parent::$codify->method !== 'landing') {
				$res['meta']['page'] .= DS . strtolower(parent::$codify->method);
			}
			$res['meta']['page'] .= '.php';
		}


		//...Title
		if (VarX::isEmpty($res['meta']['title'])) {
			$res['meta']['title'] = self::$page->title;
		}


		//...Content
		if (VarX::isEmpty($res['content'])) {
			$res['content'] = [];
		}

		return $res;
	}





	// ◇ ----- RENDER • Render Content »
	public static function render($filename, $content, $meta) {
		if (File::is($filename)) {
			return require $filename;
		}

		//...HTTP 404
		else {
			if (File::is($meta->ehttp)) {
				return require $meta->ehttp;
			} elseif (File::is(VENDOR['brux'] . '404.php')) {
				return require(VENDOR['brux'] . '404.php');
			} else {
				$accent = array_merge(HTTP::get('DATA'), ['type' => '404']);
				if (Env::is('DEV')) {
					return HTTP::error('PRINT', $accent);
				} else {
					return HTTP::error('HTML', $accent);
				}
			}
		}
	}





	// ◇ ----- LAUNCH • Auto Launch »
	public static function launch() {
		$dataset = [];
		$organizr = parent::organizr();
		if (File::is($organizr)) {
			$object = 'Sitezr';
			$method = lcfirst(parent::$codify->name);
			$caller = new $object;
			if (method_exists($caller, $method)) {
				$dataset = $caller::$method();
			}
		}
		else {
			// TODO: Trigger Error, Possibly
		}

		$maker = ArrayX::toObj(self::maker($dataset));

		//...IF $spet is false
		if (VarX::isFalse(self::$spet)) {
			return self::render($maker->meta->page, $maker->content, $maker->meta);
		}

		//...IF $spet is true
		else {
			$path = self::$directory->pagezr;
			$file = File::base($maker->meta->page, true);
			$tag = ObjectX::combine($maker->meta, $maker->content);

			$spet = new SpetQ;
			$spet->initialize($file, $tag, $path);

			if (VarX::isNotEmpty($maker->layout)) {
				foreach ($maker->layout as $slice => $boolean) {
					$spet->layout($slice);
				}
			}

			$spet->render();
			$spet->display();
		}
		return true;
	}





	// ◇ ----- IS • ... »
	public static function is($req = 'SITE', $method = 'REQUEST') {

		//...Check if Platform is SITE
		if ($req === 'SITE') {
			return parent::isSite();
		}

		//...Check from Parent class
		else {
			return parent::is($req, $method);
		}
	}





	// ◇ ----- SPET • Set $spet » Boolean
	public static function spet($req = true) {
		if (VarX::isBoolean($req)) {
			self::$spet = $req;
		}
		return true;
	}

} // End Of Class ~ Site