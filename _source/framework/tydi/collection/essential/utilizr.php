<?php
//*** UtilizrX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class UtilizrX {

	// ◇ property
	public static $utilizr;
	protected static $codify;
	protected static $initLink;
	private static $counter = 0;




	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$utilizr = ucfirst(StringX::toCamelCase($method)) . 'Util';
		if (class_exists($utilizr, false)) {
			return new $utilizr;
		}
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== customizr →
	public static function customizr() {
		$filenames = LoaderX::getDirectoryFile(ORIG['UTIL'], 'php');
		if (!empty($filenames)) {
			foreach ($filenames as $key => $filename) {
				$filename = strtolower(StringX::cropEnd($filename, '.php'));
				$class = ucfirst(StringX::toCamelCase($filename)) . 'Util';
				if (class_exists($class)) {
					self::$utilizr[$filename] = $class;
				}
			}
		}
		return true;
	}




	// ◇ ==== counter → increment counter » [numeric]
	public static function counter($counter = null) {
		if (!empty($counter)) {
			self::$counter = $counter;
		}
		self::$counter++;
		return self::$counter;
	}




	// ◇ ==== version → append version to query » [string]
	public static function version() {
		if (Env::isProduction() || Env::isStaging()) {
			$version = Env::getVersion();
			if (Vars::noData($version)) {
				if (!isset($_SESSION['version'])) {
					$_SESSION['version'] = RandomQ::version();
				}
				$version = $_SESSION['version'];
			}
		} else {
			$version = RandomQ::version();
		}
		return $version;
	}





	// ◇ ==== base64ToJpeg →
	public static function base64ToJpeg($base64, $fileDestination) {
		$ifp = fopen($fileDestination, 'wb');
		$data = explode(',', $base64);
		if (count($data) > 1) {
			fwrite($ifp, base64_decode($data[1]));
			fclose($ifp);
			return true;
		}
		fclose($ifp);
		return false;
	}




	// ◇ ==== uploadPhoto → handle image upload
	public static function uploadPhoto(array &$input, string $label, string $filename = null, $oldFilename = null) {
		$files = DataQ::grab('FILE');
		$file = DataQ::stackOne($files, $label);
		if (Vars::isNotEmptyArray($file) && isset($file['tmp_name'])) {
			$fileTemp = $file['tmp_name'];
			$extension = UploadQ::fileExtension($fileTemp, 'IMAGE');
			if (Vars::isNull($filename)) {
				$filename = RandomQ::filename();
			}
			$filename .= '.' . $extension;
			$destination = ORIG['CLOUD'] . $label . DS;
			if (!FolderX::is($destination)) {
				FolderX::create($destination);
			}
			if (is_writable($destination)) {
				if (UploadQ::basic($fileTemp, $destination, $filename)) {
					$input[$label] = $filename;
				}
			}
		}

		if (DataQ::isRowColumn($input, $label)) {
			if (Vars::hasData($oldFilename)) {
				FileX::delete($oldFilename);
			}
			return true;
		}
		return false;
	}




	// ◇ ==== uploadCamera → handle camera image upload
	public static function uploadCamera(array &$input, string $base64, string $label, string $filename = null, $oldFilename = null) {
		if (Vars::isNull($filename)) {
			$filename = RandomQ::filename() . '.jpg';
		}
		$destination = ORIG['CLOUD'] . $label . DS;
		if (!FolderX::is($destination)) {
			FolderX::create($destination);
		}
		if (is_writable($destination)) {
			if (self::base64ToJpeg($base64, $destination . $filename)) {
				$input[$label] = $filename;
			}
		}
		if (DataQ::isRowColumn($input, $label)) {
			if (Vars::hasData($oldFilename)) {
				FileX::delete($oldFilename);
			}
			return true;
		}
		return false;
	}




	// ◇ ==== uploadCameraOrPhoto →
	public static function uploadCameraOrPhoto(array &$input, string $fileField, array $option) {

		$filename = null;
		if (!empty($option['filename'])) {
			$filename = $option['filename'];
		}

		$oldFilename = null;
		if (!empty($option['oldFilename'])) {
			$oldFilename = $option['oldFilename'];
		}

		$base64 = 'NONE';
		if (!empty($option['base64'])) {
			$base64Field = $option['base64'];
			if (isset($input[$base64Field])) {
				$base64 = $input[$base64Field];
				unset($input[$base64Field]);
			}
		}

		if ($base64 === 'NONE') {
			return self::uploadPhoto($input, $fileField, $filename, $oldFilename);
		} elseif (Vars::hasData($base64)) {
			return self::uploadCamera($input, $base64, $fileField, $filename, $oldFilename);
		}
	}




	// ◇ ==== image → safely return image name to load
	public static function image($image, $req) {
		if ($req === 'DP') {
			if (Vars::hasData($image)) {
				$file = ORIG['CLOUD'] . 'dp' . DS . $image;
				if (FileX::is($file)) {
					return AssetQ::path('CLOUD_DP') . PS . $image;
				}
			}
			return AssetQ::path('CLOUD_DP') . PS . 'none.png';
		}

		if ($req === 'SIGN') {
			if (Vars::hasData($image)) {
				$file = ORIG['CLOUD'] . 'sign' . DS . $image;
				if (FileX::is($file)) {
					return AssetQ::path('CLOUD_SIGN') . PS . $image;
				}
			}
			return AssetQ::path('CLOUD_SIGN') . PS . 'none.png';
		}
	}




	// ◇ ==== uri →
	public static function uri($print = true, $trimStatus = true) {
		$uri = Route::property('uri');
		if (StringX::contain($uri, '!') && $trimStatus) {
			$uri = StringX::before($uri, '!');
		}
		if ($print === true) {
			echo $uri;
			return true;
		}
		return $uri;
	}




	// ◇ ==== linkStatus →
	public static function linkStatus() {
		return Route::property('link')->status;
	}




	// ◇ ==== isLinkStatus →
	public static function isLinkStatus($status) {
		if (self::linkStatus() === $status) {
			return true;
		}
		return false;
	}




	// ◇ ==== initLink →
	public static function initLink() {
		if (Vars::noData(self::$initLink)) {
			self::$codify = App::$codify;
			unset(self::$codify->name);
			self::$initLink = true;
		}
	}




	// ◇ ==== isModel →
	public static function isModel($model) {
		self::initLink();
		if (self::$codify->model === $model) {
			return true;
		}
		return false;
	}




	// ◇ ==== isMethod →
	public static function isMethod($method) {
		self::initLink();
		if (self::$codify->method === $method) {
			return true;
		}
		return false;
	}




	// ◇ ==== isActiveLinkCheck →
	public static function isActiveLinkCheck($model, $method = null, $status = null) {
		self::initLink();
		$isModel = self::isModel($model);
		$isMethod = self::isMethod($method);
		$isStatus = Utilizr::isLinkStatus($status);
		return ['isModel' => $isModel, 'isMethod' => $isMethod, 'isStatus' => $isStatus];
	}




	// ◇ ==== isActiveLink →
	public static function isActiveLink($link = null) {
		self::initLink();
		if (StringX::begin($link, '/')) {
			$link = StringX::cropBegin($link, '/');
		}
		$model = StringX::before($link, '/');
		if (Vars::noData($model)) {
			$model = $link;
		}
		$method = StringX::after($link, '/');
		if (Vars::noData($method)) {
			$method = 'landing';
		}

		$status = null;

		if (StringX::contain($method, '!')) {
			$method = StringX::before($method, '!');
			$status = StringX::after($link, '!');
		}

		$method = StringX::swapSpace($method, '-', true);
		$method = StringX::swapSpace($method, '_', true);
		$method = lcfirst(StringX::noSpace(ucwords(strtolower($method))));

		return self::isActiveLinkCheck($model, $method, $status);
	}




	// ◇ ==== linkIs → check value against active link » [boolean]
	public static function linkIs($link, $param = null) {
		if (StringX::begin($link, '/app/')) {
			$link = StringX::cropBegin($link, '/app');
		} elseif (StringX::begin($link, '/api/')) {
			$link = StringX::cropBegin($link, '/api');
		}

		$isActive = self::isActiveLink($link);

		// » If link has status, thus status check is required
		$status = StringX::after($link, '!');
		if ($status !== false) {
			if ($isActive['isModel'] === true && $isActive['isMethod'] === true && $isActive['isStatus'] === true) {
				return true;
			}
		}

		// » Ignore status check on link
		else {
			if ($isActive['isModel'] === true && $isActive['isMethod'] === true) {
				return true;
			}
		}

		return false;
	}




	// ◇ ==== isActiveCSS →
	public static function isActiveCSS(string $link, string $append) {
		if (StringX::begin($link, '/app/')) {
			$link = StringX::cropBegin($link, '/app');
		}
		$isActive = self::isActiveLink($link);
		if ($isActive['isModel'] === true && $isActive['isMethod'] === true) {
			echo $append;
			return true;
		}
		return false;
	}




	// ◇ ==== isGroupCSS →
	public static function isGroupCSS(string $group, bool $display, string $append) {
		if (self::isModel($group)) {
			if ($display) {
				echo $append;
			}
			return true;
		}
		return false;
	}




	// ◇ ==== cssNotifyBG →
	public static function cssNotifyBG(bool $print = true) {
		$css = '';
		if (self::isLinkStatus('success')) {
			$css = ' bg-success text-white';
		} elseif (self::isLinkStatus('failure') || self::isLinkStatus('error')) {
			$css = ' bg-danger text-white';
		} elseif (self::isLinkStatus('warning')) {
			$css = ' bg-warning text-white';
		}
		if ($print === true) {
			echo $css;
			return true;
		}
		return $css;
	}




	// ◇ ==== notifySuccess →
	public static function notifySuccess(string $message) {
		if (self::isLinkStatus('success')) {
			echo '<p class="text-success">' . $message . '</p>';
			return true;
		}
		return false;
	}




	// ◇ ==== notifyFailure →
	public static function notifyFailure(string $message) {
		if (self::isLinkStatus('failure')) {
			echo '<p class="text-danger">' . $message . '</p>';
			return true;
		}
		return false;
	}




	// ◇ ==== alert →
	public static function alert(string $message) {
		if (self::isLinkStatus('default')) {
			echo '<div class="alert alert-light" role="alert">' . $message . '</div>';
			return true;
		}
		return false;
	}




	// ◇ ==== alertFailure →
	public static function alertFailure(string $message) {
		if (self::isLinkStatus('failure')) {
			echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-info"></i> ' . $message . '</div>';
			return true;
		}
		return false;
	}




	// ◇ ==== alertExpired →
	public static function alertExpired(string $message) {
		if (self::isLinkStatus('expired')) {
			echo '<div class="alert alert-warning" role="alert"><i class="fa-solid fa-circle-exclamation"></i> ' . $message . '</div>';
			return true;
		}
		return false;
	}




	// ◇ ==== alertLogout →
	public static function alertLogout(string $message) {
		if (self::isLinkStatus('logout')) {
			echo '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $message . '</div>';
			return true;
		}
		return false;
	}




	// ◇ ==== alertChangePW →
	public static function alertChangePW(string $message) {
		if (self::isLinkStatus('password-changed')) {
			echo '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> ' . $message . '</div>';
			return true;
		}
		return false;
	}




	// ◇ ==== isNoResultAlert →
	public static function isNoResultAlert($record, $isAlert = false, $message = 'No Record Found') {
		if (DataQ::isNoResult($record)) {
			if ($isAlert) {
				echo '<div class="alert alert-danger">' . $message . '</div>';
			} else {
				echo '<div class="alert text-danger">' . $message . '</div>';
			}
			return true;
		}
		return false;
	}

} //> end of UtilizrX