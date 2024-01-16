<div class="d-flex h100vh">
	<div class="d-flex align-items-center auth-main w-100">
		<div class="auth-box">
			<div class="top mb-4">
				<div class="logo">
				<img src="<?php echo App::$ario;?>/logo-white.png" class="ao-login-logo">
				</div>
			</div>
			<div class="card mb-4 p-2">
				<div class="card-body">
					<div class="text-center mb-4">
						<img src="<?php echo App::$ario; ?>/images/user-small.png" class="rounded-circle" alt="Avatar">
						<h4 class="name m-t-10">Chandler Bing</h4>
						<p>info@example.com</p>
					</div>
					<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="oForm">
						<div class="mb-4 form-floating">
							<input type="password" class="form-control" id="password" value="" placeholder="Password" name="password">
							<label for="password">Your Password</label>
						</div>
						<button type="submit" class="btn btn-primary w-100 mb-3">CONTINUE</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>