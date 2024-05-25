<div class="container">
	<div class="row mt-4 mb-3">
		<div class="col-11">
			<h2>List Games Uniplay</h2>
		</div>
	</div>

	<?php $this->load->view('layouts/_alert') ?>

	<div class="row mt-3">
		<div class="col">
			<?php if($status !== "200") { ?>
			<?php } else { ?>
				<table class="table table-light text-center">
					<thead class="thead-dark">
						<tr>
							<th>
								<input type="checkbox" id="chk_game_all" checked/>
							</th>
							<th style="text-align: left;" width="20%">Name</th>
							<th style="text-align: left;" width="20%">Publisher</th>
							<th style="text-align: left;" width="10%">Category</th>
							<th style="text-align: center;"width="20%">Publish</th>
							<th style="text-align: center;"width="20%">Status</th>
							<th width="20%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?= form_open_multipart(base_url('product_uniplay/add'), 'id="formadd"') ?>
						<?php $no = 1; foreach($product as $p) : ?>
							<tr>
								<td>
									<?php if($p['publish'] == FALSE) { ?>
										<input type="checkbox" class="chk_game" name="chk_game[]" value="<?=$p['slug']?>" checked />
									<?php } ?>
								</td>
								<td align="left"><?= $p['name'] ?></td>
								<td align="left"><?= substr_replace(ucfirst($p['publisher']), " ...", 20) ?></td>
								<td align="left"><?= ucfirst($p['kategori']) ?></td>

								<!-- Status Pembaharuan dari Uniplay, data sudah tidak ada di uniplay -->
								<!-- Status Pembaharuan dari Uniplay, array denom ada tambahan data denom baru -->
								<!-- Status Pembaharuan dari Uniplay, array denom harga resellernya update dari uniplay -->
								<!-- <td align="left">Published, The price has been determined, Please specify the price, Game is not active from Uniplay, Reseller price changed from Uniplay</td> -->
								<td align="center"><?=$p['publish'] == TRUE ? '<span class="btn-success btn-sm">Published</span>' : '<span class="btn-info btn-sm">Ready to sync</span>'?></td>
								<td align="center">
									<?php
									if($p['status'] == "Product available to buy") {
										?>
										<span class="btn-success btn-sm"><?=$p['status']?></span>
										<?php
									} elseif($p['status'] == "Please specify the price") {
										?>
										<span class="btn-warning btn-sm"><?=$p['status']?></span>
										<?php
									}
									?>
								</td>
								<td>
									<!-- Tombol edit tampil jika sudah data sudah masuk ke database produk -->
									<!-- Redirect pengeditan kembali ke listing produk uniplay -->
									<?php if($p['publish'] == TRUE) { ?>
										<a href="<?= base_url('product_uniplay/edit/' . $p['product_id']) ?>" class="btn btn-warning btn-sm">
											<i class="fas fa-edit text-light"></i>
										</a>
									<?php } ?>

									<!-- Pengecekan tombol delete tampil jika sudah masuk ke database produk -->
									<!-- Tampilkan popup konfirmasi data yang hapus adalah didatabase akan unpublish game dari dashboard -->
									<!-- Redirect penghapusan kembali ke listing produk uniplay -->
									<?php if($p['publish'] == TRUE) { ?>
										<a href="<?= base_url('product_uniplay/delete/' . $p['product_id']) ?>" class="btn btn-danger btn-sm delete-product">
											<i class="fas fa-trash"></i>
										</a>
									<?php } ?>
								</td>
							</tr>
						<?php endforeach ?>
						<tr>
							<td colspan="7" align="left">
								<button type="submit" id="formadd" class="btn btn-success btn-sm">Sync Uniplay Product</button>
							</td>
						</tr>
						<?= form_close() ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#chk_game_all").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$("#formadd").submit(function(){
		if ($('.chk_game').filter(':checked').length < 1){
			alert("Please Check at least one checkbox");
			return false;
		}
	});

	$('.delete-product').click(function(){
		return confirm("Are you sure you want to delete?");
	})


</script>