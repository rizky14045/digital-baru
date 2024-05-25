<div class="container">
	<div class="row justify-content-center mt-4">
		<div class="col-12">
			<div class="card">
				<h5 class="card-header text-center"><strong>Order Detail #<?= $order['invoice'] ?></strong></h5>
				<div class="card-body">
					<ul>
						<li>Date : <?= $order['date'] ?></li>
						<li>Name    : <?= $order['name1'] ?></li>
						<li>Phone : <?= $order['phone'] ?></li>
						<li>Address  : <?= $order['address'] ?></li>
						<li>Status  : 
							<?php if( $detailTransaksi['status'] == 'REQUEST') : ?>
								<span class="badge badge-primary">Menunggu Pembayaran</span>
							<?php elseif($detailTransaksi['status'] == 'SUCCESS') : ?>
								<span class="badge badge-success text-light">Sudah Dibayar</span>
							<?php elseif($detailTransaksi['status'] == 'CANCEL') : ?>
								<span class="badge badge-warning">Dibatalkan</span>
							<?php elseif($detailTransaksi['status'] == 'FAILED') : ?>
								<span class="badge badge-danger">Gagal</span>
							<?php elseif($detailTransaksi['status'] == 'EXPIRED') : ?>
								<span class="badge badge-danger">Expired VA</span>
							<?php endif; ?>
						</li>
					</ul>

					<table class="table table-bordered text-center">
						<thead class="thead-dark">
							<tr>
								<th width="20%">Game</th>
								<th width="20%">Kategori</th>
								<th width="20%">No Voucher</th>
								<th width="20%">Status</th>
								<th width="20%">Price</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($order_detail as $od) : ?>
								<?php
								$get_detail_status_uniplay = $this->order->getOrderDetailUniplay($od['id']);
								?>
								<tr>
									<td>
										<img src="<?= base_url('images/game/' . $od['image']) ?>" style="width:200px">
									</td>
									<td><?=$od['kategori_name']?></td>
									<td  width="100">
										<?=$get_detail_status_uniplay['code_voucher'] != "" ? str_replace(";", " ", $get_detail_status_uniplay['code_voucher']) : "---" ?>
									</td>
									<td>
										<?php
										if($od['kategori'] != 1) {
											if($detailTransaksi['status'] == 'REQUEST') {
												?>
												<span class="btn-info btn-sm">Transaction hold</span>
												<?php
											} else if($detailTransaksi['status'] == 'SUCCESS') {
												if($get_detail_status_uniplay['inquiry_id'] != NULL && $get_detail_status_uniplay['order_id'] == NULL) {
													if($get_detail_status_uniplay['code_status_uniplay_payment'] != "200") {
														?>
														<span class="btn-danger btn-sm">Transaction failed</span>
														<br><br>
														<span class="btn-danger btn-sm"><?=$get_detail_status_uniplay['text_status_uniplay_payment']?></span>
														<?php
													} else {
														?>
														<span class="btn-warning btn-sm">Transaction processed</span>
														<?php
													}
												} else {
													if($get_detail_status_uniplay['status_uniplay'] == "done" || $get_detail_status_uniplay['status_uniplay'] == "payment_received") {
														?>
														<span class="btn-success btn-sm">Transaction successful</span>
														<?php
													}
												}
											} else if($detailTransaksi['status'] == 'CANCEL' || $detailTransaksi['status'] == 'FAILED' || $detailTransaksi['status'] == 'EXPIRED') {
												?>
												<?php if($detailTransaksi['status'] == 'CANCEL') : ?>
													<span class="btn-warning btn-sm">Dibatalkan</span>
												<?php elseif($detailTransaksi['status'] == 'FAILED') : ?>
													<span class="btn-danger btn-sm">Gagal</span>
												<?php elseif($detailTransaksi['status'] == 'EXPIRED') : ?>
													<span class="btn-danger btn-sm">Expired VA</span>
												<?php endif; ?>
												<?php
											}
										} else {
											?>
											<?php if($detailTransaksi['status'] == 'REQUEST') : ?>
												<span class="btn-primary btn-sm">Menunggu Pembayaran</span>
											<?php elseif($detailTransaksi['status'] == 'SUCCESS') : ?>
												<span class="btn-success btn-sm text-light">Sudah Dibayar</span>
											<?php elseif($detailTransaksi['status'] == 'CANCEL') : ?>
												<span class="btn-warning btn-sm">Dibatalkan</span>
											<?php elseif($detailTransaksi['status'] == 'FAILED') : ?>
												<span class="btn-danger btn-sm">Gagal</span>
											<?php elseif($detailTransaksi['status'] == 'EXPIRED') : ?>
												<span class="btn-danger btn-sm">Expired VA</span>
											<?php endif; ?>
											<?php
										}
										?>
									</td>
									<td><h5>Rp. <?= number_format($od['subtotal'], 2, ',', '.') ?></h5></td>
								</tr>
							<?php endforeach ?>
						</tbody>
						<tfoot class="bg-success text-light">
							<tr>
								<td><strong>Total</strong></td>
								<td></td>
								<td></td>
								<td></td>
								<td><h5><strong>Rp. <?= number_format(array_sum(array_column($order_detail, 'subtotal')), 2, ',', '.') ?></strong></h5></td>
								<!-- <td></td> -->
							</tr>
						</tfoot>
					</table>
				</div>
				
			</div>
		</div>
	</div>
	<div class="row mt-3 mb-5">
		<div class="col-8">
			<div class="card">
				<h5 class="card-header">Payments Confirmation</h5>
				<div class="card-body">
					<p>Virtual Account Number: <strong class="text-info"><?= $detailTransaksi['payment_code']?></strong></p>
					<?php
					$bank = explode("_",$detailTransaksi['payment_channel']);
					?>
					<p>Bank Name: <strong class="text-info"><?= $bank[1]?></strong></p>
					<p>Nominal: <strong class="text-info">Rp.<?=number_format($detailTransaksi['amount'])?> </strong></p>
				</div>
			</div>
		</div>
	</div>
</div>
