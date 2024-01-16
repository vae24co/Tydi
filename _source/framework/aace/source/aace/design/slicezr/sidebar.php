<div id="left-sidebar" class="sidebar">
	<div class="sidebar-scroll">
		<!-- User Account -->
		<div class="user-account mx-3 my-4 text-start">
			<div class="d-flex">
				<img src="<?php echo App::$ario; ?>/images/user.png" class="rounded-circle user-photo me-3" alt="User Profile Picture">
				<div class="dropdown">
					<span class="d-block">Welcome,</span>
					<a href="#" class="dropdown-toggle user-name" data-bs-toggle="dropdown"><strong>Dr. Chandler Bing</strong></a>
					<ul class="dropdown-menu account">
						<li><a href="page-profile2.html"><i class="fa fa-user"></i>My Profile</a></li>
						<li><a href="app-inbox.html"><i class="fa fa-envelope-open"></i>Messages</a></li>
						<li><a href="javascript:void(0);"><i class="fa fa-cog"></i>Settings</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo LinkUtil::navigator('auth/logout'); ?>"><i class="fa fa-power-off"></i>Logout</a></li>
					</ul>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-4">
					<small>Experience</small>
					<h6 class="mb-0">14+</h6>
				</div>
				<div class="col-4">
					<small>Awards</small>
					<h6 class="mb-0">18</h6>
				</div>
				<div class="col-4">
					<small>Clients</small>
					<h6 class="mb-0">250+</h6>
				</div>
			</div>
		</div>
		<!-- Nav tabs -->
		<?php App::slice('nav' . DS . 'navigator', $content); ?>
		<!-- Nav Tabs Content -->
		<div class="tab-content px-0" id="leftTabContent">
			<?php App::slice('nav' . DS . 'tab' . DS . 'menu', $content); ?>
			<?php App::slice('nav' . DS . 'tab' . DS . 'chat', $content); ?>
			<?php App::slice('nav' . DS . 'tab' . DS . 'settings', $content); ?>
		</div>
	</div>
</div>