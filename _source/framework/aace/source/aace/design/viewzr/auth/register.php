<div class="d-flex h100vh">
	<div class="d-flex align-items-center auth-main w-100">
		<div class="auth-box">
			<div class="top mb-4">
				<div class="logo">
					<img src="<?php echo App::$ario; ?>/logo-white.png" class="ao-login-logo">
				</div>
			</div>
			<div class="card mb-4 p-2">
				<div class="card-header bg-transparent border-bottom-0 py-3">
					<p class="fs-5 mb-0">Create an account</p>
				</div>
				<div class="card-body">
					<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="registerForm">
						<div class="mb-3 form-floating">
							<input type="text" class="form-control" id="name" value="" placeholder="Fullname" name="name">
							<label for="name">Fullname</label>
						</div>
						<div class="mb-3 form-floating">
							<input type="text" class="form-control" id="phone" value="" placeholder="Phone Number" name="phone">
							<label for="phone">Phone Number</label>
						</div>
						<div class="mb-3 form-floating">
							<input type="email" class="form-control" id="email" value="" placeholder="Email Address" name="email">
							<label for="email">Email Address</label>
						</div>
						<div class="mb-4 form-floating">
							<input type="password" class="form-control" id="password" value="" placeholder="Password" name="password">
							<label for="password">Password</label>
						</div>
						<button type="submit" class="btn btn-primary w-100 mb-3">REGISTER</button>
						<div class="bottom text-center">
							<span class="helper-text mt-2 mb-3 d-block">Already have an account? <a href="<?php echo LinkUtil::navigator('auth/login'); ?>">Login</a></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>