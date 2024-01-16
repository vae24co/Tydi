<div class="row clearfix">

	<div class="col-md-12">
		<div class="card mb-4">
			<div class="card-header"><strong><?php echo VarX::say($content->breadcrumb->title); ?></strong></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table center-aligned-table">
						<?php
						if ($content->data === 'NO_RESULT') { ?>
							<thead>
								<tr>
									<th class="text-center">NO RECORD</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center">No records found</td>
								</tr>
							</tbody>
						<?php } elseif (VarX::hasNoData($content->data->plan)) { ?>
							<thead>
								<tr>
									<th class="text-center">NO PLANS</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center">No HMO Plans found</td>
								</tr>
							</tbody>
						<?php } else {
							App::table('hmo' . DS . 'plans', $content);
						} ?>
					</table>
				</div>

				<div class="row">
					<div class="col-md-4 mt-4 mb-4">
						<a href="<?php echo LinkUtil::navigator('hmo/create-plan/?id=') . $content->data->puid; ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-plus fa-fw"></i> Create Plan</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>