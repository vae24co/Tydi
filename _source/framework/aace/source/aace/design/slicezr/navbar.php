<nav class="navbar navbar-fixed-top p-0">
	<div class="container-fluid">
		<!-- Responsive Menu Button -->
		<div class="navbar-btn p-0">
			<button type="button" class="btn-toggle-offcanvas"><i class="fa fa-bars"></i></button>
		</div>
		<!-- Brand Logo -->
		<div class="navbar-brand">
			<a href="<?php echo LinkUtil::navigator('/'); ?>" class="logo">
				<!-- <img src="<?php echo App::$ario; ?>/logo.png" class="ao-logo"> -->
				<svg width="85px" viewBox="0 0 85 25">
					<path d="M12.3,7.2l1.5-3.7l8.1,19.4H19l-2.4-5.7H8.2l1.1-2.5h6.1L12.3,7.2z M14.8,20.2l1,2.7H0L9.5,0h3.1L4.3,20.2H14.8
z M29,18.5v-14h1.6v12.6h6.2v1.5H29V18.5z M49.6,4.5v9.1c0,1.6-0.5,2.9-1.5,3.8s-2.3,1.4-4,1.4s-3-0.5-3.9-1.4s-1.4-2.2-1.4-3.8V4.5
h1.6v9.1c0,1.2,0.3,2.1,1,2.7c0.6,0.6,1.6,0.9,2.8,0.9s2.1-0.3,2.7-0.9c0.6-0.6,1-1.5,1-2.7V4.5H49.6z M59.4,5.7
c-1.5,0-2.8,0.5-3.7,1.5s-1.3,2.4-1.3,4.2s0.4,3.3,1.3,4.3c0.9,1,2.1,1.5,3.7,1.5c1,0,2.1-0.2,3.4-0.5v1.4c-1,0.4-2.2,0.5-3.6,0.5
c-2.1,0-3.7-0.6-4.8-1.9s-1.7-3-1.7-5.4c0-1.4,0.3-2.7,0.8-3.8c0.5-0.9,1.3-1.8,2.3-2.4s2.2-0.9,3.6-0.9c1.5,0,2.8,0.3,3.9,0.8
l-0.7,1.4C61.5,6,60.4,5.7,59.4,5.7z M65.8,18.5v-14h1.6v14.1h-1.6V18.5z M82.5,11.3c0,2.3-0.6,4.1-1.9,5.3s-3.1,1.8-5.4,1.8h-3.9
V4.5h4.3c2.2,0,3.9,0.6,5.1,1.8S82.5,9.2,82.5,11.3z M80.8,11.4c0-1.8-0.5-3.2-1.4-4.1s-2.3-1.4-4.1-1.4h-2.4v11.2h2
c1.9,0,3.4-0.5,4.4-1.4S80.8,13.3,80.8,11.4z" />
				</svg>
			</a>
		</div>
		<!-- NavBar Group -->
		<div class="navbar-right">
			<!-- NavBar Search -->
			<form id="navbar-search" class="navbar-form search-form float-start mt-1 p-0 position-relative me-3 d-none d-md-block me-3 p-0 position-relative d-none d-md-block">
				<input value="" class="form-control" placeholder="Search here..." type="text">
				<button type="button" class="btn btn-secondary"><i class="fa fa-search"></i></button>
			</form>
			<!-- NavBar Right Links -->
			<div id="navbar-menu" class="float-end">
				<ul class="navbar-nav flex-row align-items-center">
					<li class="d-none d-md-inline-block"><a href="app-events.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="fa fa-calendar"></i></a></li>
					<li class="d-none d-md-inline-block"><a href="app-chat.html" class="icon-menu d-none d-sm-block"><i class="fa fa-comments"></i></a></li>
					<li class="d-none d-md-inline-block"><a href="app-inbox.html" class="icon-menu d-none d-sm-block"><i class="fa fa-envelope"></i><span class="notification-dot"></span></a></li>
					<li class="dropdown d-md-inline-block">
						<a class="dropdown-toggle icon-menu" href="#" role="button" id="notificationsBtn" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-bell-o"></i>
							<span class="notification-dot"></span>
						</a>
						<ul class="dropdown-menu notifications" aria-labelledby="notificationsBtn">
							<li class="header"><strong>You have 4 new Notifications</strong></li>
							<li>
								<a class="d-flex mb-3" href="javascript:void(0);">
									<i class="fa fa-info text-warning"></i>
									<div class="ms-3 w-100">
										<p class="text">Campaign <strong>Holiday Sale</strong> is nearly
											reach budget limit.</p>
										<span class="timestamp">10:00 AM Today</span>
									</div>
								</a>
							</li>
							<li>
								<a class="d-flex mb-3" href="javascript:void(0);">
									<i class="fa fa-thumbs-up text-success"></i>
									<div class="ms-3 w-100">
										<p class="text">Your New Campaign <strong>Holiday Sale</strong> is
											approved.</p>
										<span class="timestamp">11:30 AM Today</span>
									</div>
								</a>
							</li>
							<li>
								<a class="d-flex mb-3" href="javascript:void(0);">
									<i class="fa fa-pie-chart text-success"></i>
									<div class="ms-3 w-100">
										<p class="text">Website visits from Twitter is 27% higher than last
											week.</p>
										<span class="timestamp">04:00 PM Today</span>
									</div>
								</a>
							</li>
							<li>
								<a class="d-flex mb-3" href="javascript:void(0);">
									<i class="fa fa-info text-danger"></i>
									<div class="ms-3 w-100">
										<p class="text">Error on website analytics configurations</p>
										<span class="timestamp">Yesterday</span>
									</div>
								</a>
							</li>
							<li class="footer"><a href="javascript:void(0);" class="more">See all
									notifications</a></li>
						</ul>
					</li>
					<li class="dropdown d-md-inline-block">
						<a class="dropdown-toggle icon-menu" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-sliders"></i></a>
						<ul class="dropdown-menu user-menu menu-icon list-unstyled">
							<li class="menu-heading">ACCOUNT SETTINGS</li>
							<li><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"></i><span>Basic</span></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-sliders fa-rotate-90"></i><span>Preferences</span></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-lock"></i><span>Privacy</span></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-bell"></i><span>Notifications</span></a></li>
							<li class="menu-heading">BILLING</li>
							<li><a href="javascript:void(0);"><i class="fa fa-credit-card"></i><span>Payments</span></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-print"></i><span>Invoices</span></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-refresh"></i><span>Renewals</span></a></li>
						</ul>
					</li>
					<li class="d-md-inline-block"><a href="page-login.html" class="icon-menu"><i class="fa fa-sign-out"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</nav>