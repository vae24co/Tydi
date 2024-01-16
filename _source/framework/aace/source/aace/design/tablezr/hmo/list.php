<div class="table-responsive">
	<table class="table table-hover center-aligned-table">
		<?php
		if ($content === 'NO_RESULT') { ?>
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
			<thead class="table-dark">
				<tr>
					<th colspan="1">S/N</th>
					<th colspan="1" class="col-md-4">HMO</th>
					<th colspan="1" class="col-md-1">CODE</th>
					<th colspan="1" class="col-md-2">PHONE</th>
					<th colspan="1" class="col-md-2">EMAIL</th>
					<th colspan="1" class="col-md-1">PACKAGE</th>
					<th colspan="1" class="col-md-1 text-center">STATUS</th>
					<th colspan="4" class="col-md-4 text-center">MANAGE</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$data = $content;
				$sn = 1;
				foreach ($data as $row) { ?>
					<tr>
						<td><?php echo $sn++; ?></td>
						<td><strong><a href="<?php echo LinkUtil::navigator('hmo/detail?id=') . $row->puid; ?>" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="<?php echo VarX::say($row->title); ?>"><?php echo VarX::say($row->title); ?></a></strong></td>
						<td><?php echo VarX::say($row->code); ?></td>
						<td><?php echo VarX::say($row->phone); ?></td>
						<td><?php echo VarX::say($row->email); ?></td>

						<td><a href="<?php echo LinkUtil::navigator('hmo/plans?id=') . $row->puid; ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-cubes fa-fw"></i> Package</a></td>

						<td class="text-center">
						<?php if ($row->status === 'INACTIVE'){ ?>
							<label class="badge bg-danger"><?php echo VarX::say($row->status); ?></label>
						<?php } elseif($row->status !== 'ACTIVE'){?>
							<label class="badge bg-warning"><?php echo VarX::say($row->status); ?></label>
						<?php } else {?>
							<label class="badge bg-success"><?php echo VarX::say($row->status); ?></label>
						<?php } ?>
						</td>

						<td class="col-md-1 text-center">
						<?php if($row->status !== 'ACTIVE'){?>
						<a href="<?php echo LinkUtil::navigator('hmo/activate?id=') . $row->puid; ?>" class="btn text-success btn-sm"><i class="fa-solid fa-toggle-on fa-fw fa-2x" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="ACTIVATE"></i></a>
						<?php } else {?>
						<a href="<?php echo LinkUtil::navigator('hmo/deactivate?id=') . $row->puid; ?>" class="btn text-danger btn-sm"><i class="fa-solid fa-toggle-off fa-fw fa-2x" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="DEACTIVATE"></i></a>
						<?php } ?>
						</td>

						<td><a href="<?php echo LinkUtil::navigator('hmo/edit?id=') . $row->puid; ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i> Edit</a></td>

						<?php if($row->status !== 'UNLIST'){?>
						<td><a href="<?php echo LinkUtil::navigator('hmo/unlist?id=') . $row->puid; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-ban fa-fw"></i> Unlist</a></td>
						<?php } elseif($row->status === 'UNLIST'){?>
						<td><a href="<?php echo LinkUtil::navigator('hmo/enlist?id=') . $row->puid; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-circle fa-fw"></i> Enlist</a></td>
						<?php } ?>

						<td class="text-center"><a href="<?php echo LinkUtil::navigator('hmo/delete?id=') . $row->tuid; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i> Delete</a></td>
					</tr>
				<?php } ?>
			</tbody>
		<?php } ?>
	</table>
</div>
