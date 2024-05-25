<div class="container">
	<div class="row mt-4">
		<div class="col">

			<?php $this->load->view('layouts/_alert') ?>

			<div class="card">
				<h5 class="card-header text-center"><strong>My Orders</strong></h5>
				<div class="card-body">
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th>Invoice</th>
								<th>Date</th>
								<th>Total</th>
								<th>Status</th>
								<th>Expired Time</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($orders as $o) : ?>
								<tr>
									<td><strong><a href="<?= base_url('myorder/detail/' . $o['invoice']) ?>"><?= $o['invoice'] ?></a></strong></td>
									<td><?= $o['date'] ?></td>
									<td>Rp. <?= number_format($o['total'], 2, ',', '.') ?></td>
									
									<td><?php if($o['status'] == 'REQUEST') : ?>
										<span class="btn-primary btn-sm">Menunggu Pembayaran</span>
									<?php elseif($o['status'] == 'SUCCESS') : ?>
										<span class="btn-success btn-sm text-light">Sudah Dibayar</span>
									<?php elseif($o['status'] == 'CANCEL') : ?>
										<span class="btn-warning btn-sm">Dibatalkan</span>
									<?php elseif($o['status'] == 'FAILED') : ?>
										<span class="btn-danger btn-sm">Gagal</span>
									<?php elseif($o['status'] == 'EXPIRED') : ?>
										<span class="btn-danger btn-sm">Expired VA</span>
									<?php endif; ?></td>
									<td>
										<?= date('F j Y H:i:s', strtotime($o['expired_time']));?>
									</td>
									<td><?php if($o['status'] == 'REQUEST') : ?>
										<a href="<?= base_url('myorder/cancel/' . $o['id']) ?>" class="badge badge-danger" onclick="return confirm('Apakah yakin transaksi akan di batalkan ?')">Batalkan</a>
									<?php endif; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
