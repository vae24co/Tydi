<div class="row g-4">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<strong><?php echo VarX::say($content->breadcrumb->title); ?></strong>
			</div>
			<?php App::form('hmo' . DS . 'search', $content); ?>
		</div>
	</div>
</div>