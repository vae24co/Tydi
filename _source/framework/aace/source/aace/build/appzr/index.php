<?php
class IndexApp extends Organizr {

	// » INITIALIZE •
	public function initialize() {
		$link = LinkUtil::navigator('auth/login');
		Redirect::instant($link);
	}

} // End Of Class ~ IndexApp