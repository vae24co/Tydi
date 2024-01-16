<div class="row clearfix">
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header">Blank</div>
			<div class="card-body">
				<h4 class="text-primary">Blank!</h4>
				<p>This is a view is a default placeholder.</p>
				<p class="text-danger mt-3"><?php if (VarX::hasData($view)) {
					Tydi::trace('<strong>Possibly Missing → </strong> [' . $view.']');
				} ?></p>
			</div>
		</div>
	</div>
</div>