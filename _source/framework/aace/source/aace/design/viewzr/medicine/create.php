<div class="row g-4">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<strong><?php echo VarX::say($content->breadcrumb->title); ?></strong>
			</div>
			<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="oForm" id="oForm">
				<div class="card-body">
					<?php App::form('medicine'.DS.'create', $content); ?>
				</div>
			</form>
		</div>
	</div>
</div>