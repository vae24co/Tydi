<title><?php echo VarX::say($content->title->page) ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="<?php echo App::$ario; ?>/favicon.ico" type="image/x-icon">

<style>
	#wrapper {
		display: none;
	}
</style>

<?php if ($content->layout === 'main') { ?>
	<link rel="stylesheet" href="<?php echo App::$ario; ?>/plugin/chartist/css/chartist.min.css">
	<link rel="stylesheet" href="<?php echo App::$ario; ?>/plugin/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js">

	<link rel="stylesheet" href="<?php echo App::$ario; ?>/css/bootstrapDatepicker.min.css">
	<link rel="stylesheet" href="<?php echo App::$ario; ?>/css/dropify.min.css">
<?php } ?>
<link rel="stylesheet" href="<?php echo App::$ario; ?>/css/main.css">

<link href="<?php echo App::$ario; ?>/fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="<?php echo App::$ario; ?>/fontawesome/css/brands.css" rel="stylesheet">
<link href="<?php echo App::$ario; ?>/fontawesome/css/solid.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo App::$ario; ?>/ao/ao.css">
