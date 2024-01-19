<!DOCTYPE html>
<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title></title>
		<?php #oFileLoadX(BITZR.'meta.inc');?>
		<?php #oFileLoadX(BITZR.'favicon.inc');?>
		<?php #oFileLoadX(BITZR.'css.inc');?>
	</head>

	<body><?php echo $this->instance->title();?>
		<?php
		// if(in_array($this->site->model(), $auths)){
		// 	oFileLoadX(OUTLINZR.'auth.inc');
		// }
// echo $this->site->action();
#	?>
		<?php #oFileLoadX(BITZR.'js.inc');?>
	</body>

</html>