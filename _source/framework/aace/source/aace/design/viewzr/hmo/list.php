<div class="row clearfix">
	<div class="col-md-12">
		<div class="card mb-4">
			<div class="card-header"><strong><?php echo VarX::say($content->breadcrumb->title); ?></strong></div>
			<div class="card-body">
				<?php App::table('hmo' . DS . 'list', $content->data); ?>
			</div>
		</div>
	</div>
</div>