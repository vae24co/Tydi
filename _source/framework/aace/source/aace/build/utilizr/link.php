<?php
class LinkUtil {

	// → NAVIGATOR •
	public static function navigator($link, $sect = null) {
		$uri = App::uri('IS');
		if ($link === '/') {
			$link = '';
		}
		if (StringX::begin($uri, '/app/')) {
			$link = '/app/' . $link;
		}
		if (!StringX::begin($link, '/')) {
			$link = '/' . $link;
		}

		if (VarX::hasData($sect)) {
			$link .= '?sect=' . $sect;
		}
		return $link;
	}





	// → IS URI •
	public static function isURI() {
		$uri = App::uri('IS');
		if (StringX::begin($uri, '/app/')) {
			$uri = StringX::cropBegin($uri, '/app/');
		}
		return $uri;
	}





	public static function isActive($link, $append = 'active') {
		$uri = self::isURI();
		if (StringX::end($uri, $link)) {
			echo $append;
			return true;
		}
		return false;
	}





	public static function isActiveGroup($group, $display = true, $append = 'active mm-active') {
		$uri = self::isURI();
		$links = [];
		$path = '';

		if ($group === 'hmo') {
			$path = 'hmo/';
			$links = ['create', 'list', 'edit', 'activate', 'deactivate', 'search', 'delete', 'plans'];
		}

		if ($group === 'medicine') {
			$links = ['medicine/create', 'medicine/list', 'medicine/search', 'medicine/list/delete'];
		}

		if ($group === 'radiology') {
			$links = ['radiology/create', 'radiology/list', 'radiology/search', 'radiology/list/delete'];
		}

		if ($group === 'laboratory') {
			$links = ['laboratory/create', 'laboratory/list', 'laboratory/search', 'laboratory/list/delete'];
		}

		foreach ($links as $link) {
			if (StringX::contain($uri, $path.$link)) {
				if ($display) {
					echo $append;
				}
				return true;
			}
		}

		return false;
	}





	public static function isExpandGroup($group, $display = true, $append = 'mm-collapse mm-show') {
		if (self::isActiveGroup($group, false) !== false) {
			if ($display) {
				echo $append;
			}
			return true;
		}
		return false;
	}
}