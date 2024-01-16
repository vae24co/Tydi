<li class="<?php LinkUtil::isActiveGroup('laboratory'); ?>">
	<a href="#laboratory" class="has-arrow"><i class="fa-solid fa-flask-vial fa-fw me-4"></i></i><span>Laboratory</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('laboratory'); ?>">
		<li class="<?php LinkUtil::isActive('laboratory/create') ?>"><a href="<?php echo LinkUtil::navigator('laboratory/create'); ?>"><i class="fa-regular fa-file-circle-plus fa-fw me-2"></i> Create Laboratory</a></li>
		<li class="<?php LinkUtil::isActive('laboratory/list') ?>"><a href="<?php echo LinkUtil::navigator('laboratory/list'); ?>"><i class="fa-regular fa-file-lines fa-fw me-2"></i> List Laboratory</a></li>
		<li class="<?php LinkUtil::isActive('laboratory/search') ?>"><a href="<?php echo LinkUtil::navigator('laboratory/search'); ?>"><i class="fa-regular fa-magnifying-glass fa-fw me-2"></i> Search for Laboratory</a></li>
		<li class="<?php LinkUtil::isActive('laboratory/list/unlist') ?>"><a href="<?php echo LinkUtil::navigator('laboratory/list/unlist'); ?>"><i class="fa-regular fa-ban fa-fw me-2"></i> Unlist Laboratory</a></li>
		<li class="<?php LinkUtil::isActive('laboratory/list/delete') ?>"><a href="<?php echo LinkUtil::navigator('laboratory/list/delete'); ?>"><i class="fa-regular fa-trash-can fa-fw me-2"></i> Delete Laboratory</a></li>
	</ul>
</li>