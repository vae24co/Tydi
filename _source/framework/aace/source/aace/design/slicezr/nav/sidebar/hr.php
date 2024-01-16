<li class="<?php LinkUtil::isActiveGroup('hr'); ?>">
	<a href="#hr" class="has-arrow"><i class="fa-solid fa-users fa-fw me-4"></i></i><span>Human Resource</span></a>
	<ul class="list-unstyled <?php LinkUtil::isExpandGroup('hr'); ?>">
		<li class="<?php LinkUtil::isActive('hr/doctor') ?>"><a href="<?php echo LinkUtil::navigator('hr/doctor'); ?>"><i class="fa-regular fa-user-doctor fa-fw me-2"></i> Doctor</a></li>
		<li class="<?php LinkUtil::isActive('hr/nurse') ?>"><a href="<?php echo LinkUtil::navigator('hr/nurse'); ?>"><i class="fa-regular fa-user-nurse fa-fw me-2"></i> Nurse</a></li>
		<li class="<?php LinkUtil::isActive('hr/pharmacist') ?>"><a href="<?php echo LinkUtil::navigator('hr/pharmacist'); ?>"><i class="fa-regular fa-prescription-bottle fa-fw me-2"></i> Pharmacist</a></li>
		<li class="<?php LinkUtil::isActive('hr/laboratorist') ?>"><a href="<?php echo LinkUtil::navigator('hr/laboratorist'); ?>"><i class="fa-regular fa-vials fa-fw me-2"></i> Laboratorist</a></li>
		<li class="<?php LinkUtil::isActive('hr/radiologist') ?>"><a href="<?php echo LinkUtil::navigator('hr/radiologist'); ?>"><i class="fa-regular fa-file-prescription fa-fw me-2"></i> Radiologist</a></li>
		<li class="<?php LinkUtil::isActive('hr/accountant') ?>"><a href="<?php echo LinkUtil::navigator('hr/accountant'); ?>"><i class="fa-regular fa-money-bill-transfer fa-fw me-2"></i> Accountant</a></li>
		<li class="<?php LinkUtil::isActive('hr/receptionist') ?>"><a href="<?php echo LinkUtil::navigator('hr/receptionist'); ?>"><i class="fa-regular fa-person-shelter fa-fw me-2"></i> Receptionist</a></li>
	</ul>
</li>