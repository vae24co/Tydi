<!doctype html>
<html lang="en">

	<head>
		<?php App::slice('head', $content); ?>
	</head>

	<body>
		<div id="layout" class="theme-orange">
			<div id="wrapper">
				<?php App::view($content); ?>
			</div>
		</div>
		<?php App::slice('fouc'); ?>
	</body>

</html>