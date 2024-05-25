<div class="container">
	<div class="row mt-4 mb-3">
		<div class="col-11">
			<h2>Privasi</h2>
		</div>
		<div class="col float-right">
			<a href="<?= base_url('privasi/add') ?>" class="btn btn-primary btn-sm">
				<i class="fas fa-plus"></i>
				Privasi
			</a>
		</div>
	</div>

	<?php $this->load->view('layouts/_alert') ?>
	
	<div class="row mt-3">
		<div class="col">
			<table class="table table-bordered table-light text-center">
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
						<tr>
							<td>1</td>
							<td><?= $privasi['description'] ?></td>
							<td>
								<a href="<?= base_url('privasi/edit/' . $privasi['id']) ?>" class="btn btn-warning btn-sm d-inline-block">
									<i class="fas fa-edit text-light"></i>
								</a>
								<a href="<?= base_url('privasi/delete/' . $privasi['id']) ?>" class="btn btn-danger btn-sm">
									<i class="fas fa-trash"></i>
								</a>
							</td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
