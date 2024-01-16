<!doctype html>
<html lang="en">

	<head>
		<?php App::slice('head', $content); ?>
	</head>

	<body>
		<div id="layout" class="theme-orange">
			<?php App::slice('loader', $content); ?>
			<div id="wrapper">
				<?php App::slice('navbar', $content); ?>
				<?php App::slice('sidebar', $content); ?>
				<div id="main-content">
					<div class="container-fluid">
						<?php
						App::slice('header', $content);
						App::view($content, $view);
						?>
					</div>
				</div>
			</div>
		</div>
		<?php App::slice('js'); ?>
		<?php App::slice('fouc'); ?>
	</body>

</html>