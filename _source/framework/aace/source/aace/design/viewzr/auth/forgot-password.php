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
					<p class="fs-5 mb-0">Recover my password</p>
				</div>
				<div class="card-body">
					<p>Please enter your email address below to receive instructions for resetting password.</p>
					<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="forgotPW">
						<div class="mb-4 form-floating">
							<input type="email" class="form-control" id="email" value="" placeholder="Password" name="email">
							<label for="email">Email Address</label>
						</div>
						<button type="submit" class="btn btn-primary w-100 mb-3">RESET PASSWORD</button>
						<div class="bottom text-center">
							<span class="helper-text mt-2 mb-2 d-block">Know your password? <a href="<?php echo LinkUtil::navigator('auth/login'); ?>">Login</a></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>