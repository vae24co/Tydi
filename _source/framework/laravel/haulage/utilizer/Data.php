<?php
namespace Zero\Utilizer;

use Illuminate\Support\Str;

class Data {


	// • ==== debugX → output variable »
	public static function debug($var, string $title = null) {
		$o = '<div style="border: 1px solid tan; padding: 5px 10px; margin-bottom:6px;">';
		if (!is_null($title) && $title !== '') {
			$o .= '<strong style="margin:0; line-height:1.6; color: brown;">' . $title . ':</strong> ';
		}

		if (is_string($var)) {
			$o .= ' <span style="color: purple;">' . $var . '</span>';
		} elseif (is_array($var)) {
			foreach ($var as $key => $value) {
				$o .= ' <div style="color: purple;">' . $key . ': <span style="color: grey;">' . $value . '</span></div>';

			}
		} else {
			$o .= ' <div style="color: purple;"><pre><tt>' . var_export($var, true) . '</tt></pre></div>';
		}
		$o .= '</div>';
		echo $o;
		exit;
	}





	public static function create(array $input) {
		$input['puid'] = $input['puid'] ?? Str::random(20);
		$input['suid'] = $input['suid'] ?? Str::random(40);
		$input['tuid'] = $input['tuid'] ?? Str::random(70);
		$input['author'] = $input['author'] ?? 'ZERO';
		return $input;
	}
}