<li class="<?php LinkUtil::isActiveGroup('radiology'); ?>">
	<a href="#radiology" class="has-arrow"><i class="fa-solid fa-x-ray fa-fw me-4"></i></i><span>Radiology</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('radiology'); ?>">
		<li class="<?php LinkUtil::isActive('radiology/create') ?>"><a href="<?php echo LinkUtil::navigator('radiology/create'); ?>"><i class="fa-regular fa-file-circle-plus fa-fw me-2"></i> Create Radiology</a></li>
		<li class="<?php LinkUtil::isActive('radiology/list') ?>"><a href="<?php echo LinkUtil::navigator('radiology/list'); ?>"><i class="fa-regular fa-file-lines fa-fw me-2"></i> List Radiology</a></li>
		<li class="<?php LinkUtil::isActive('radiology/search') ?>"><a href="<?php echo LinkUtil::navigator('radiology/search'); ?>"><i class="fa-regular fa-magnifying-glass fa-fw me-2"></i> Search for Radiology</a></li>
		<li class="<?php LinkUtil::isActive('radiology/list/unlist') ?>"><a href="<?php echo LinkUtil::navigator('radiology/list/unlist'); ?>"><i class="fa-regular fa-ban fa-fw me-2"></i> Unlist Radiology</a></li>
		<li class="<?php LinkUtil::isActive('radiology/list/delete') ?>"><a href="<?php echo LinkUtil::navigator('radiology/list/delete'); ?>"><i class="fa-regular fa-trash-can fa-fw me-2"></i> Delete Radiology</a></li>
	</ul>
</li>