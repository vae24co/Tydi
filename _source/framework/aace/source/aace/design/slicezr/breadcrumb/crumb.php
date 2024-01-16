<div class="col-lg-6 col-md-8 col-sm-12">
	<h2 class="m-0 fs-5">
		<a href="javascript:void(0);" class="btn btn-sm btn-link ps-0 btn-toggle-fullwidth"><i class="fa-solid fa-arrow-left"></i></a>
		<?php echo VarX::say($content->breadcrumb->title); ?>
	</h2>
	<ul class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="<?php echo LinkUtil::navigator('home'); ?>"><i class="fa-solid fa-house"></i></a></li>
		<li class="breadcrumb-item active"><?php echo $content->breadcrumb->primary; ?></li>
		<?php if(isset($content->breadcrumb->secondary)){?>
			<li class="breadcrumb-item active"><?php echo $content->breadcrumb->secondary;?></li>
			<?php } ?>
	</ul>
</div>