<?php
/* HTML ~ HTML Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class HTML {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- Translator • Yandex Translator »
	public static function translator($req = 'yandex'){
		if(VarX::isNotEmpty($req)){
			$req = strtolower($req);

			// » Yandex Translator
			if($req === 'yandex'){
				return '<div class="language-menu">
				<style>
					#yt-widget .yt-listbox__col {display: block !important;	list-style: none;	vertical-align: top; max-width: 90% !important;}
				.yt-listbox {min-width: 200px !important;	max-width: 500px !important;	max-height: 500px !important;	padding: 10px 10px !important;	overflow: auto !important;}
					#yt-widget.yt-state_bottom .yt-listbox {bottom: unset !important;}
				.yt-listbox li {display: block !important;}
				.yt-servicelink {display: none !important;}
				</style>
				<div id="ytWidget"></div>
				<script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=true" type="text/javascript"></script>
				</div>';
			}
		}
		return false;
	}





	// ◇ ---- REDIRECTING • Redirecting to URL »
	public static function redirecting($link, $delay = 1, $message = 'AUTO', $action = 'EXIT') {
		if ($message === 'AUTO') {
			echo '<div class="accent accent-notice"><p class="accent-message"><strong>Redirecting</strong> → <a href="' . $link . '">' . $link . '</a></p></div>' . "\n\r";
		}
		Redirect::meta($link, $delay, $action);
	}





	// ◇ ---- VIEWPORT • HTML viewport
	public static function viewport() {
		if (ClientQ::deviceType() !== 'DESKTOP') {
			return '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3">' . "\n";
		}
	}



	// ◇ ---- XUA • HTML XUA compatible
	public static function xua() {
		if (!Env::is('DEV')) {
			return '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">' . "\n";
		}
	}


	// ◇ ---- CHARSET •
	public static function charset() {
		if (ClientQ::deviceType() === 'DESKTOP' && BrowserQ::ie('<', 9)) {
			$o = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		} else {
			$o = '<meta charset="utf-8">';
		}
		return $o . "\n";
	}




	// ◇ ---- NOTIFY •
	public static function notify($messages = '', $state = 'oAuto') {
		$errors = array('error', 'danger');
		$warnings = array('invalid', 'warning');
		$successes = array('success', 'done');
		if ($state == 'oAuto') {
			// Todo: Work on this line
			// $state = Route::state();
		}
		if ($state == 'default') {
			$type = 'primary';
		} elseif (in_array($state, $successes)) {
			$type = 'success';
		} elseif (in_array($state, $errors)) {
			$type = 'danger';
		} elseif (in_array($state, $warnings)) {
			$type = 'warning';
		}
		if (!is_array($messages)) {
			$message = $messages;
		} elseif (!empty($messages[$state])) {
			$message = $messages[$state];
		}
		$o = '<div class="o-notify text-' . $type . '">' . $message . '</div>';
		return $o;
	}

} // End Of Class ~ HTML