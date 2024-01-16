<div class="row clearfix">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header bg-success text-white"><?php echo VarX::say($content->data->title);?> Unlisted</div>
			<div class="card-body">
				<p class="text-success"><?php echo VarX::say($content->data->title);?> has been unlisted successfully.<br> <a href="<?php echo LinkUtil::navigator('hmo/list');?>" class="text-primary">See HMO List</a></p>
			</div>
		</div>
	</div>
</div>