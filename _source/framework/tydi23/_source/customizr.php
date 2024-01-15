<?php

die;
// • Function: Include
function inc(string|array $file, string $path = null, closure $action = null) {
	if (is_string($file)) {
		$files = [$file];
	} else if (is_array($file)) {
		$files = $file;
	}

	$path = $path ?? '';

	foreach ($files as $file) {
		$file = $path . $file . '.php';
		if (!is_file($file)) {
			$error = '<strong>' . FRAMEWORK . '™</strong> • File Unavailable! → [<em>' . $file . '</em>]';
			exit($error);
		}
		include $file;

		if (is_callable($action)) {
			$action();
		}

		return true;
	}
}

function SayMe($name) {
	return ' Say me, ' . $name;
}
$func = SayMe('Anthony Osawere');

// inc('rice', RD, function () {
// 	echo 'Brymo!';
// });

inc('rice', RD, function () use ($func) {
	echo 'Brymo!';
	echo $func;
});