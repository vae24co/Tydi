<li class="<?php LinkUtil::isActiveGroup('patient'); ?>">
	<a href="#patient" class="has-arrow"><i class="fa-solid fa-user fa-fw me-4"></i></i><span>Patient</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('patient'); ?>">
		<li class="<?php LinkUtil::isActive('patient/create') ?>"><a href="<?php echo LinkUtil::navigator('patient/create'); ?>"><i class="fa-regular fa-file-circle-plus fa-fw me-2"></i> Create Patient</a></li>
		<li class="<?php LinkUtil::isActive('patient/list') ?>"><a href="<?php echo LinkUtil::navigator('patient/list'); ?>"><i class="fa-regular fa-hospital-user fa-fw me-2"></i> List Patient</a></li>
		<li class="<?php LinkUtil::isActive('patient/search') ?>"><a href="<?php echo LinkUtil::navigator('patient/search'); ?>"><i class="fa-regular fa-magnifying-glass fa-fw me-2"></i> Search for Patient</a></li>
		<li class="<?php LinkUtil::isActive('patient/list/unlist') ?>"><a href="<?php echo LinkUtil::navigator('patient/list/unlist'); ?>"><i class="fa-regular fa-ban fa-fw me-2"></i> Unlist Patient</a></li>
	</ul>
</li>