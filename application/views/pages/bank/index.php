<div class="container">
	<div class="row mt-4 mb-3">
		<div class="col-11">
			<h2>Bank</h2>
		</div>
		<div class="col float-right">
			<a href="<?= base_url('bank/add') ?>" class="btn btn-primary btn-sm">
				<i class="fas fa-plus"></i>
				Bank
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
						<th>Bank</th>
						<th>Payment Channel</th>
						<th>Secret Key</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; foreach($bank as $data) : ?>
						<tr>
							<td><?= $no++ ?></td>
							<td><?= $data['nama_bank'] ?></td>
							<td><?= $data['payment_channel'] ?></td>
							<td><?= $data['secret_key'] ?></td>	
							<td>
								<a href="<?= base_url('bank/edit/' . $data['id']) ?>" class="btn btn-warning btn-sm">
									<i class="fas fa-edit text-light"></i>
								</a>
								<a href="<?= base_url('bank/delete/' . $data['id']) ?>" class="btn btn-danger btn-sm">
									<i class="fas fa-trash"></i>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
