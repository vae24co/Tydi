<?php
//*** Crucial Functions » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//


// ◇ ==== TraceX →
function TraceX($i, $print = true) {
	if ($print) {
		echo nl2br(TraceX($i, false));
		return;
	}
	$o = '';
	if (is_array($i)) {
		$label = 'array';
		$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
		$o .= '<div style="margin: 0px 0 4px 6px; padding: 4px 6px 6px 12px; border-left: 1px dotted #FFD700;">';
		foreach ($i as $key => $value) {
			$o .= '<strong style="color:#A52A2A;">' . $key . ': </strong>';
			if (is_bool($value) === true) {
				if ($value === true) {
					$o .= ' → oTRUE<span>';
				} elseif ($value === false) {
					$o .= ' → oFALSE<span>';
				}
				$o .= ' <em style="color:#D2B48C;">(boolean)</em><br>';
			} elseif (is_null($value) === true) {
				$o .= '<span> → oNULL</span><br>';
			} elseif (is_array($value)) {
				$o .= TraceX($value, false);
			} elseif (is_object($value)) {
				$o .= '<pre><tt>' . var_export($value, true) . '</tt></pre>';
			} else {
				$o .= $value . '<span><br>';
			}
		}
		$o .= '</div>';
	} elseif (is_bool($i) === true) {
		$label = 'boolean';
		$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
		if ($i === true) {
			$o .= ' → oTRUE<span>';
		} elseif ($i === false) {
			$o .= ' → oFALSE<span>';
		}
		$o .= ' <em style="color:#D2B48C;">(boolean)</em><br>';
	} elseif (is_object($i)) {
		$o .= '<pre><tt>' . var_export($i, true) . '</tt></pre>';
	} else {
		$o .= print_r($i, true);
	}
	return $o;
}




// ◇ ==== DebugX → function for debugging code
function DebugX($i, $print = true) {
	TraceX($i, $print);
	exit;
}




// ◇ ==== FileX →
function FileX($filename, $path = null) {
	if (is_null($path)) {
		$filepath = $filename;
	} elseif (strlen($path) > 1) {
		if (substr($path, -(strlen(DS))) === DS) {
			$filepath = $path . $filename;
		} else {
			$filepath = $path . DS . $filename;
		}
	}

	if (is_file($filepath)) {
		require_once $filepath;
	} else {
		$file = pathinfo($filepath, PATHINFO_FILENAME);
		$e = '<strong>' . TYDI . '™ • ' . ucfirst($file) . '</strong> | File Unavailable!';
		if (defined('ENV')) {
			if (ENV === 'STAGING') {
				$extra = basename($filename);
			} elseif (ENV === 'DEVELOPMENT') {
				$extra = $filepath;
			}
			if (ENV !== 'PRODUCTION') {
				$e .= ' → [<em>' . $extra . '</em>]';
			}
		}
		exit($e);
	}
}




// ◇ ==== OversightX →
function OversightX($label, $message, $extra = null, $exit = true) {

	if (strpos($label, TYDI) === false) {
		$label = TYDI . '™ • ' . $label;
	}

	$e = '<strong>' . ucwords($label) . '</strong> | ' . $message;
	if (!is_null($extra) && $extra != '') {
		if (is_array($extra)) {
			if (count(array_filter(array_keys($extra), 'is_numeric')) === count($extra)) {
				$extra = implode(' • ', $extra);
			} else {
				$append = '';
				foreach ($extra as $key => $val) {
					$append .= $key . ': ' . $val . ' • ';
				}
				$extra = trim($append, ' • ');
			}
		}
		if (is_string($extra)) {
			$e .= ' → <em>[' . $extra . ']</em>';
		}
	}
	if ($exit) {
		exit($e);
	} else {
		echo '<pre><tt>' . var_export($e, true) . '</tt></pre>';
	}
}




// ◇ ==== CallerX →
function CallerX($caller, $type, &$file = null) {
	if ($type === 'CLASS' && !class_exists($caller) || $type === 'FUNCTION' && !function_exists($caller)) {
		return OversightX($caller, ucfirst(strtolower($type)) . ' Unavailable!', $file);
	}
	return true;
}