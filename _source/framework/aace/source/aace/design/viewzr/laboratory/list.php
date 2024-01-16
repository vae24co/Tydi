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
						<?php } else { ?>
							<thead>
								<tr>
									<th class="col-md-3">TITLE</th>
									<th class="col-md-3">GENERIC</th>
									<th class="col-md-1">TYPE</th>
									<th>PRICE</th>
									<th>STATUS</th>
									<th class="col-md-4" colspan="4">MANAGE</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$data = $content->data;
								$sn = 0;
								foreach ($data as $row) {?>
									<tr>
										<td><?php echo VarX::say($row->title); ?></td>
										<td><?php echo VarX::say($row->generic); ?></td>
										<td><?php echo VarX::say($row->type); ?></td>
										<td><?php echo VarX::say($row->price); ?></td>
										<td><label class="badge bg-warning"><?php echo VarX::say($row->status); ?></label></td>
										<td><a href="javascript:void(0);" class="btn btn-secondary btn-sm">Detail</a></td>
										<td><button class="btn btn-info btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i> Edit</button></td>
										<td><button class="btn btn-warning btn-sm"><i class="fa-solid fa-ban fa-fw"></i> Unlist</button></td>
										<td><button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i> Delete</button></td>
									</tr>
								<?php } ?>
							</tbody>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>