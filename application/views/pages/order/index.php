<div class="container">

	<div class="row mt-4">
		<div class="col-10">
			<h3>List Users Orders</h3>
		</div>
	</div>

	<?php $this->load->view('layouts/_alert') ?>

	<div class="row mt-4">

	</div>

	<div class="row mt-4">
		<div class="col bg-light p-4" style="text-align:left;">
			Sisa Saldo Uniplay : Rp<?=number_format($saldo_uniplay->saldo, 0, ',', '.')?>
		</div>
		<div class="col bg-light p-4" style="text-align:right;">
			<a href="<?=site_url('order')?>" class="text-dark my-auto">
				Payment
			</a>
			|
			<a href="<?=site_url('order/expired')?>" class="text-dark my-auto">
				Payment Failed
			</a>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col bg-light p-4">
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th>Pengguna</th>
						<th>Invoice</th>
						<th>Date</th>
						<th>Total</th>
						<th>Status Mcpayment</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($orders as $o) : ?>
						<tr>
							<td><?= $o['user_name'] ?></td>
							<td><a href="<?= base_url('order/detail/' . $o['id']) ?>"><strong><?= $o['invoice'] ?></strong></a></td>
							<td><?= $o['date'] ?></td>
							<td align="right">Rp. <?= number_format($o['total'], 2, ',', '.') ?></td>
							<td>
								<?php if($o['status'] == 'REQUEST') : ?>
									<span class="btn-primary btn-sm">Menunggu Pembayaran</span>
								<?php elseif($o['status'] == 'SUCCESS') : ?>
									<span class="btn-success btn-sm text-light">Sudah Dibayar</span>
								<?php elseif($o['status'] == 'CANCEL') : ?>
									<span class="btn-warning btn-sm">Dibatalkan</span>
								<?php elseif($o['status'] == 'FAILED') : ?>
									<span class="btn-danger btn-sm">Gagal</span>
								<?php elseif($o['status'] == 'EXPIRED') : ?>
									<span class="btn-danger btn-sm">Expired VA</span>
								<?php endif; ?>
							</td>
						</tr>
						<?php if($o['status'] == 'SUCCESS') { ?>
							<?php if(isset($o['order_detail']) && count($o['order_detail']) > 0) { ?>
								<tr>
									<td colspan="5">
										<table class="table table-bordered text-center" style="border: double;">
											<?php foreach ($o['order_detail'] as $key_detail => $value_detail) { ?>
												<?php if($value_detail['kategori'] != 1) { ?>
													<?php
													$get_detail_status_uniplay = $this->order->getOrderDetailUniplay($value_detail['id']);
													if(count($get_detail_status_uniplay) > 0) {
													?>
														<tr style="border: double;"><th colspan="4">Uniplay Status <?=$value_detail['name'];?></th></tr>
														<tr>
															<th>Transaction Date</th>
															<th>Transaction Number</th>
															<?php if($value_detail['kategori'] == 3) { ?>
																<th>Voucher Number</th>
															<?php } ?>
															<th>Status Uniplay</th>
															<!-- <th>Action</th> -->
														</tr>
														<tr>
															<td><?=$get_detail_status_uniplay['trx_date'] != "" ? $get_detail_status_uniplay['trx_date'] : "---" ;?></td>
															<td><?=$get_detail_status_uniplay['trx_number'];?></td>
															<?php if($value_detail['kategori'] == 3) { ?>
																<td><?=$get_detail_status_uniplay['code_voucher']?></td>
															<?php } ?>
															<td align="center">
																<?php 
																if($o['status'] == 'REQUEST') {
																	?>
																	<span class="btn-info btn-sm">Transaction hold</span>
																	<?php
																} else if($o['status'] == 'SUCCESS') {
																	if($get_detail_status_uniplay['inquiry_id'] != NULL && $get_detail_status_uniplay['order_id'] == NULL) {
																		if($get_detail_status_uniplay['code_status_uniplay_payment'] != "200") {
																			?>
																			<span class="btn-danger btn-sm">Transaction failed</span>
																			<br><br>
																			<span class="btn-danger btn-sm"><?=$get_detail_status_uniplay['text_status_uniplay_payment']?></span>
																			<br><br>
																			<a href="<?=site_url('order/repeat_order/' . $value_detail['id'])?>" class="repeat_order" onclick="return confirm('Are you sure to make a payment ?')">
																				<span class="btn btn-primary btn-sm">Repeat uniplay payment </span>
																			</a>
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
																} else if($o['status'] == 'CANCEL' || $o['status'] == 'FAILED' || $o['status'] == 'EXPIRED') {
																	?>
																	<?php if($o['status'] == 'CANCEL') : ?>
																		<span class="btn-warning btn-sm">Dibatalkan</span>
																	<?php elseif($o['status'] == 'FAILED') : ?>
																		<span class="btn-danger btn-sm">Gagal</span>
																	<?php elseif($o['status'] == 'EXPIRED') : ?>
																		<span class="btn-danger btn-sm">Expired VA</span>
																	<?php endif; ?>
																	<?php
																}
																?>
															</td>
														</tr>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</table>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
