<?php
if (VarX::isEmpty($meta)) {
	$meta = ObjectX::make();
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo '<title>' . $meta->title . '</title>' . PHP_EOL; ?>
		<link rel="stylesheet" type="text/css" href="/accent.css">
		<style type="text/css">
			body {
				margin: 0 auto;
			}

			h1 {
				color: beige;
				background-color: tan;
				padding: 6px 10px;
				margin: 0;
				font-size: 1.5em;
				font-weight: normal;
			}

			#container {
				padding: 10px;
			}

			#path {
				background-color: brown;
				color: white;
				padding: 6px 10px;
				margin: 50px auto 10px;
				text-align: center;
				line-height: 2;
				max-width: 600px;
			}
		</style>
	</head>

	<body>
		<h1><?php echo $meta->document; ?> - Not Found</h1>
		<section id="container">
			<p>Sorry, the resource you requested on <a href="<?php echo $meta->uri; ?>" title="<?php echo Site::property('PROJECT_TITLE') . ' ' . $meta->document; ?>"><?php echo '[<strong>' . $meta->uri . '</strong>]'; ?></a>
				responded with a HTTP error 404 as the content was not found on the Server!</p>
			<p>You may want to contact <a href="mailto:<?php echo Site::property('SUPPORT_EMAIL'); ?>"><?php echo Site::property('SUPPORT_EMAIL'); ?></a> to report this.</p>
			<div id="path">
				<small>
					E404 | <strong><?php echo Env::errorReport($meta->uri, $filename, '...'); ?></strong>
				</small>
			</div>
		</section>
	</body>

</html>