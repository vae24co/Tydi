<div class="row g-4 clearfix">
	<h6 class="small ao-section-title">Medicine Information</h6>
	<div class="col-md-3 col-sm-12">
		<div class="form-floating">
			<input type="text" class="form-control" placeholder="Generic Name" name="generic">
			<label>Generic Name</label>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="form-floating">
			<input type="text" class="form-control" placeholder="Medicine Name" name="title">
			<label>Medicine Name</label>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="form-floating">
			<select class="form-select" name="type">
				<option selected>- Select -</option>
				<option value="SYRUP">Syrup</option>
				<option value="CAPSULE">Capsule</option>
				<option value="TABLET">Tablet</option>
				<option value="INJECTION">Injection</option>
				<option value="CREAM">Cream</option>
			</select>
			<label>Medicine Type</label>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="form-floating">
			<select class="form-select" name="storage">
				<option selected>- Select -</option>
				<option value="ROOM_TEMPERATURE">Room Temperature</option>
				<option value="FRIDGE">Fridge</option>
				<option value="SHELF">Shelf</option>
				<option value="INJECTION">Injection</option>
				<option value="DISPENSARY">Dispensary</option>
			</select>
			<label>Medicine Storage</label>
		</div>
	</div>
	<div class="col-md-4 col-sm-6">
		<div class="form-floating">
			<input type="text" class="form-control" placeholder="Side Effect" name="effect">
			<label>Side Effect</label>
		</div>
	</div>
	<div class="col-md-4 col-sm-6">
		<div class="form-floating">
			<input type="text" class="form-control" placeholder="Vendor" name="vendor">
			<label>Vendor</label>
		</div>
	</div>
	<div class="col-md-4 col-sm-6">
		<div class="form-floating">
			<input type="number" class="form-control" placeholder="Vendor" name="price">
			<label>Price</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-floating">
			<textarea placeholder="Description" class="form-control" name="description"></textarea>
			<label>Description</label>
		</div>
	</div>
</div>
<div class="row g-4 clearfix mt-3 mb-4">
	<div class="col-sm-12">
		<button type="submit" class="btn btn-primary btn-lg">Create</button>
	</div>
</div>