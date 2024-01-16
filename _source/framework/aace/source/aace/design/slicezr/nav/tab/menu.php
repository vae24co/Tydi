<?php $sidebarnavpath = 'nav' . DS . 'sidebar' . DS; ?>
<div class="tab-pane fade show active" id="menu_menu" role="tabpanel" aria-labelledby="menu-tab">
	<nav class="sidebar-nav">
		<ul class="main-menu metismenu list-unstyled">
			<li class="<?php LinkUtil::isActive('dashboard') ?>"><a href="<?php echo LinkUtil::navigator('dashboard'); ?>"><i class="fa-solid fa-gauge me-4"></i></i><span>Dashboard</span></a></li>

			<?php #App::slice($sidebarnavpath . 'patient', $content); ?>
			<?php #App::slice($sidebarnavpath . 'hr', $content); ?>
			<?php App::slice($sidebarnavpath . 'hmo', $content); ?>
			<?php #App::slice($sidebarnavpath . 'medicine', $content); ?>
			<?php #App::slice($sidebarnavpath . 'radiology', $content); ?>
			<?php #App::slice($sidebarnavpath . 'laboratory', $content); ?>
















			<!-- <li><a href="app-appointment.html"><i class="fa fa-calendar me-4"></i>Appointment</a></li>
			<li><a href="app-taskboard.html"><i class="fa fa-list me-4"></i>Taskboard</a></li>
			<li><a href="app-inbox.html"><i class="fa fa-home me-4"></i>Inbox App</a></li>
			<li><a href="app-chat.html"><i class="fa fa-comments-o me-4"></i>Chat App</a></li>
			<li>
				<a href="#Doctors" class="has-arrow"><i class="fa fa-user-md me-4"></i><span>Doctors</span></a>
				<ul class="list-unstyled">
					<li><a href="doctors-all.html">All Doctors</a></li>
					<li><a href="doctor-add.html">Add Doctor</a></li>
					<li><a href="doctor-profile.html">Doctor Profile</a></li>
					<li><a href="doctor-events.html">Doctor Schedule</a></li>
				</ul>
			</li>
			<li><a href="#Patients" class="has-arrow"><i class="fa fa-user me-4"></i><span>Patients</span></a>
				<ul class="list-unstyled">
					<li><a href="patients-all.html">All Patients</a></li>
					<li><a href="patient-add.html">Add Patient</a></li>
					<li><a href="patient-profile.html">Patient Profile</a></li>
					<li><a href="patient-invoice.html">Invoice</a></li>
				</ul>
			</li>
			<li><a href="#Payments" class="has-arrow"><i class="fa fa-credit-card me-4"></i><span>Payments</span></a>
				<ul class="list-unstyled">
					<li><a href="payments.html">Payments</a></li>
					<li><a href="payments-add.html">Add Payment</a></li>
					<li><a href="payments-invoice.html">Invoice</a></li>
				</ul>
			</li>
			<li><a href="#Departments" class="has-arrow"><i class="fa fa-database me-4"></i><span>Departments</span></a>
				<ul class="list-unstyled">
					<li><a href="depa-add.html">Add</a></li>
					<li><a href="depa-all.html">All Departments</a></li>
					<li><a href="javascript:void(0);">Cardiology</a></li>
					<li><a href="javascript:void(0);">Pulmonology</a></li>
					<li><a href="javascript:void(0);">Gynecology</a></li>
					<li><a href="javascript:void(0);">Neurology</a></li>
					<li><a href="javascript:void(0);">Urology</a></li>
					<li><a href="javascript:void(0);">Gastrology</a></li>
					<li><a href="javascript:void(0);">Pediatrician</a></li>
					<li><a href="javascript:void(0);">Laboratory</a></li>
				</ul>
			</li>
			<li><a href="our-centres.html"><i class="fa fa-map-marker me-4"></i>WorldWide Centres</a></li>
			<li>
				<a href="#Authentication" class="has-arrow"><i class="fa fa-lock me-4"></i><span>Authentication</span></a>
				<ul class="list-unstyled">
					<li><a href="page-login.html">Login</a></li>
					<li><a href="page-register.html">Register</a></li>
					<li><a href="page-lockscreen.html">Lockscreen</a></li>
					<li><a href="page-forgot-password.html">Forgot Password</a></li>
					<li><a href="page-404.html">Page 404</a></li>
					<li><a href="page-403.html">Page 403</a></li>
					<li><a href="page-500.html">Page 500</a></li>
					<li><a href="page-503.html">Page 503</a></li>
				</ul>
			</li>
			<li>
				<a href="#Widgets" class="has-arrow"><i class="fa fa-puzzle-piece me-4"></i><span>Widgets</span></a>
				<ul class="list-unstyled">
					<li><a href="widgets-statistics.html">Statistics Widgets</a></li>
					<li><a href="widgets-data.html">Data Widgets</a></li>
					<li><a href="widgets-chart.html">Chart Widgets</a></li>
					<li><a href="widgets-weather.html">Weather Widgets</a></li>
					<li><a href="widgets-social.html">Social Widgets</a></li>
				</ul>
			</li>
			<li>
				<a href="#Pages" class="has-arrow"><i class="fa fa-file-o me-4"></i><span>Extra Pages</span></a>
				<ul class="list-unstyled">
					<li><a href="page-blank.html">Blank Page</a></li>
					<li><a href="doctor-profile.html">Profile</a></li>
					<li><a href="page-gallery.html">Image Gallery <span class="badge bg-secondary float-end">v1</span></a></li>
					<li><a href="page-gallery2.html">Image Gallery <span class="badge bg-warning float-end">v2</span></a></li>
					<li><a href="page-timeline.html">Timeline</a></li>
					<li><a href="page-timeline-h.html">Horizontal Timeline</a></li>
					<li><a href="page-pricing.html">Pricing</a></li>
					<li><a href="page-search-results.html">Search Results</a></li>
					<li><a href="page-helper-class.html">Helper Classes</a></li>
					<li><a href="page-maintenance.html">Maintenance</a></li>
					<li><a href="page-testimonials.html">Testimonials</a></li>
					<li><a href="page-faq.html">FAQs</a></li>
				</ul>
			</li> -->
		</ul>
	</nav>
</div>