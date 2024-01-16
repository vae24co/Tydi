<div class="d-flex h100vh">
	<div class="d-flex align-items-center auth-main w-100">
		<div class="auth-box">
			<div class="top mb-4">
				<div class="logo">
					<img src="<?php echo App::$ario;?>/logo-white.png" class="ao-login-logo">
				</div>
			</div>
			<div class="card mb-4 p-2">
				<div class="card-header bg-transparent border-bottom-0 py-3">
					<p class="fs-5 mb-0">Login to your account</p>
				</div>
				<div class="card-body">
					<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="loginForm">
						<div class="mb-3 form-floating">
							<input type="text" class="form-control" id="signin-email" value="" placeholder="UserID" name="userid">
							<label for="signin-email">UserID</label>
						</div>
						<div class="mb-4 form-floating">
							<input type="password" class="form-control" id="signin-password" value="" placeholder="Password" name="password">
							<label for="signin-password">Password</label>
						</div>
						<div class="form-check mb-4">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">Remember Me</label>
						</div>
						<button type="submit" class="btn btn-primary w-100 mb-3">LOGIN</button>
						<div class="bottom text-center">
							<span class="helper-text mb-3 mt-2 d-block"><i class="fa fa-lock"></i> <a href="<?php echo LinkUtil::navigator('auth/forgot-password'); ?>">Forgot password?</a></span>
							<span>Don't have an account? <a href="<?php echo LinkUtil::navigator('auth/register'); ?>">Register</a></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>