<form class="form-auth-small" method="post" action="<?php echo App::$url; ?>" name="oForm" id="oForm">

	<div class="card-body">
		<div class="row g-4 clearfix">
			<h6 class="small ao-section-title">HMO Information</h6>
			<div class="col-md-8 col-sm-12">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="HMO Title" name="title">
					<label>HMO Title</label>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="HMO Code" name="code">
					<label>HMO Code</label>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-floating">
					<input type="email" class="form-control" placeholder="Email Address" name="email">
					<label>Email Address</label>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="Phone Number" name="phone">
					<label>Phone Number</label>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="Website" name="website">
					<label>Website</label>
				</div>
			</div>
			<div class="col-12">
				<div class="form-floating">
					<textarea placeholder="Address" class="form-control" rows="4" name="address" style="height: 100%;"></textarea>
					<label>Address</label>
				</div>
			</div>
		</div>
		<div class="row g-4 clearfix mt-3">
			<h6 class="small ao-section-title">HMO Contact Person</h6>
			<div class="col-md-12">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="Contact Person" name="contact[name]">
					<label>Contact Person</label>
				</div>
			</div>
			<div class="col-md-8 col-sm-6">
				<div class="form-floating">
					<input type="email" class="form-control" placeholder="Contact Email" name="contact[email]">
					<label>Contact Email</label>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-floating">
					<input type="text" class="form-control" placeholder="Contact Number" name="contact[phone]">
					<label>Contact Number</label>
				</div>
			</div>
		</div>
		<div class="row g-4 clearfix mt-3 mb-4">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary btn-lg">Create</button>
			</div>
		</div>

</form>