<li class="<?php LinkUtil::isActiveGroup('hmo'); ?>">
	<a href="#hmo" class="has-arrow"><i class="fa-solid fa-square-h fa-fw me-4"></i></i><span>HMO</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('hmo'); ?>">
		<li class="<?php LinkUtil::isActive('hmo/create') ?>"><a href="<?php echo LinkUtil::navigator('hmo/create'); ?>"><i class="fa-regular fa-file-circle-plus fa-fw me-2"></i> Create HMO</a></li>
		<li class="<?php LinkUtil::isActive('hmo/list') ?>"><a href="<?php echo LinkUtil::navigator('hmo/list'); ?>"><i class="fa-regular fa-file-lines fa-fw me-2"></i> List All HMO</a></li>
		<li class="<?php LinkUtil::isActive('hmo/search') ?>"><a href="<?php echo LinkUtil::navigator('hmo/search'); ?>"><i class="fa-regular fa-magnifying-glass fa-fw me-2"></i> Search for HMO</a></li>
		 <li class="<?php LinkUtil::isActive('hmo/list/unlist') ?>"><a href="<?php echo LinkUtil::navigator('hmo/list/unlist'); ?>"><i class="fa-regular fa-ban fa-fw me-2"></i> Unlist HMO</a></li>
		<li class="<?php LinkUtil::isActive('hmo/list/delete') ?>"><a href="<?php echo LinkUtil::navigator('hmo/list/delete'); ?>"><i class="fa-regular fa-trash-can fa-fw me-2"></i> Delete HMO</a></li>
	</ul>
</li>