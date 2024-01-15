<?php //*** DebugX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Tydi\Spry;

class DebugX {

	// • ==== style → ... »
	private static function style($flag) {

		switch ($flag) {
			case 'label':
				$style = 'color:#FFD700;';
				break;

			case 'key':
				$style = 'color:#A52A2A;';
				break;

			case 'value':
				$style = 'color:#D2B48C; display: inline-block; padding-left: 2px;';
				break;

			case 'title':
				$style = 'color:#0F0F0F; margin:0; line-height:1.5; display:block;';
				break;

			case 'content':
				$style = 'color:purple;';
				break;

			case 'partition':
				$style = 'border-left: 1px dotted #FFD700; margin: 5px 8px; padding: 2px 6px; line-height:1.36';
				break;

			case 'container':
				$style = 'border: 1px dashed tan; padding: 5px 10px; margin-bottom:6px;';
				break;

			default:
				$style = '';
				break;
		}

		return $style;
	}





	// • ==== value → ... »
	protected static function value($value) {
		if (is_string($value) || is_numeric($value)) {
			return '<span style="' . self::style('content') . '">' . $value . '</span>';
		}
		if (is_bool($value)) {
			if ($value === true) {
				$value = 'True';
			} else {
				$value = 'False';
			}
			return '<span style="' . self::style('content') . '">' . $value . '</span>';
		}
		if (is_array($value)) {
			return self::array($value);
		}
	}





	// • ==== string → ... »
	protected static function string(string $var) {
		return self::value($var);
	}





	// • ==== boolean → ... »
	protected static function boolean(bool $var) {
		return '<strong style="' . self::style('key') . '">Boolean: </strong>' . self::value($var);
	}





	// • ==== array → ... »
	protected static function array(array $var) {
		$o = '<em style="' . self::style('label') . '">is_array</em>';
		$o .= '<div style="' . self::style('partition') . '">';
		foreach ($var as $key => $value) {
			$o .= '<div><strong style="' . self::style('key') . '">' . $key . ': </strong>' . self::value($value) . '</div>';
		}
		$o .= '</div>';
		return $o;
	}





	// • ==== object → ... »
	protected static function object(object $var) {
		$o = '<em style="' . self::style('label') . '">is_object</em>';
		$o .= '<div style="' . self::style('partition') . '">';
		foreach ($var as $key => $value) {
			$o .= '<div><strong style="' . self::style('key') . '">' . $key . ' → </strong>' . self::value($value) . '</div>';
		}
		$o .= '</div>';
		return $o;
	}





	// • ==== go → ... »
	public static function go($var, string $title = null) {
		$o = '<div style="' . self::style('container') . '">';

		if (!empty($title)) {
			$o .= '<strong style="' . self::style('title') . '">' . $title . '</strong> ';
		}

		switch (true) {
			case is_string($var) || is_integer($var) || is_numeric($var):
				$o .= self::string($var);
				break;

			case is_bool($var):
				$o .= self::boolean($var);
				break;

			case is_array($var):
				$o .= self::array($var);
				break;

			case is_object($var):
				$o .= self::object($var);
				break;
		}

		$o .= '</div>';
		echo $o;

		return;
	}





























	// • ==== exit → output and exit »
	// public static function exit($var, string $title = null) {
	// 	if (empty($title)) {
	// 		$title = env('FRAMEWORK');
	// 	}
	// 	echo self::dump($var, $title);
	// 	exit;
	// }





	// • ==== type → output variable type and exit »
	// public static function type($var){
	// 	return self::exit(gettype($var));
	// }















	// • ==== variable → output variable »
	// public static function variablex($var, string $title = null) {
	// 	$o = '<div style="border: 1px solid tan; padding: 5px 10px; margin-bottom:6px;">';
	// 	if (!is_null($title) && $title !== '') {
	// 		$o .= '<strong style="margin:0; line-height:1.6; color: brown;">' . $title . ':</strong> ';
	// 	}

	// 	if (is_string($var)) {
	// 		$o .= ' <span style="color: purple;">' . $var . '</span>';
	// 	} else {
	// 		$o .= ' <div style="color: purple;"><pre><tt>' . var_export($var, true) . '</tt></pre></div>';
	// 	}
	// 	$o .= '</div>';
	// 	return $o;
	// }





	// • ==== oversight → output error »
	// public static function oversight($label, $message, $extra = null, $exit = true) {
	// 	if (strpos($label, env('FRAMEWORK')) === false) {
	// 		$label = env('FRAMEWORK') . '™ • ' . $label;
	// 	}
	// 	$e = '<strong>' . ucwords($label) . '</strong> | ' . $message;
	// 	if (!is_null($extra) && $extra != '') {
	// 		if (is_array($extra)) {
	// 			if (count(array_filter(array_keys($extra), 'is_numeric')) === count($extra)) {
	// 				$extra = implode(' • ', $extra);
	// 			} else {
	// 				$append = '';
	// 				foreach ($extra as $key => $val) {
	// 					$append .= $key . ': ' . $val . ' • ';
	// 				}
	// 				$extra = trim($append, ' • ');
	// 			}
	// 		}
	// 		if (is_string($extra)) {
	// 			$e .= ' → <em>[' . $extra . ']</em>';
	// 		}
	// 	}
	// 	echo self::dump($e);
	// 	if ($exit) {
	// 		exit();
	// 	}
	// }


} //> end of DebugX