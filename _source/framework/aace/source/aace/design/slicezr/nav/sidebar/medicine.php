<li class="<?php LinkUtil::isActiveGroup('medicine'); ?>">
	<a href="#medicine" class="has-arrow"><i class="fa-solid fa-capsules fa-fw me-4"></i></i><span>Medicine</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('medicine'); ?>">
		<li class="<?php LinkUtil::isActive('medicine/create') ?>"><a href="<?php echo LinkUtil::navigator('medicine/create'); ?>"><i class="fa-regular fa-file-circle-plus fa-fw me-2"></i> Create Medicine</a></li>
		<li class="<?php LinkUtil::isActive('medicine/list') ?>"><a href="<?php echo LinkUtil::navigator('medicine/list'); ?>"><i class="fa-regular fa-file-lines fa-fw me-2"></i> List Medicine</a></li>
		<li class="<?php LinkUtil::isActive('medicine/search') ?>"><a href="<?php echo LinkUtil::navigator('medicine/search'); ?>"><i class="fa-regular fa-magnifying-glass fa-fw me-2"></i> Search for Medicine</a></li>
		<li class="<?php LinkUtil::isActive('medicine/list/unlist') ?>"><a href="<?php echo LinkUtil::navigator('medicine/list/unlist'); ?>"><i class="fa-regular fa-ban fa-fw me-2"></i> Unlist Medicine</a></li>
		<li class="<?php LinkUtil::isActive('medicine/list/delete') ?>"><a href="<?php echo LinkUtil::navigator('medicine/list/delete'); ?>"><i class="fa-regular fa-trash-can fa-fw me-2"></i> Delete Medicine</a></li>
	</ul>
</li>