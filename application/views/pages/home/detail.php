<div class="container produk-description mb-5 p-5">
	<!-- Alert -->
	<?php $this->load->view('layouts/_alert') ?>
	<!-- End of alert -->
	<!-- Hero -->
	<div class="produk mt-5">
		<div class="image-produk ml-4">
			<div class="row">		
				<div class="col" style="padding-right: 30px;">
					<img src="<?= base_url() ?>/images/game/<?= $game['image'] ?>" class="card-img-top image-detail-product" alt="<?= $game['name'] ?>" style="width:330px;">
				</div>	
			</div>
		</div>
		<div class="detail-produk" style="width: 300px;">
			<h2 class="font-weight-bold" style="width: 700px;"><?= $game['name'] ?></h2>
			<?php if ($game['kategori'] == 1) { ?>
				<h4 class="font-weight-normal"><?=  ucfirst($game['edition']) ?> Edition</h4>
				<p class="font-weight-bold">EDITION</p>
				<h5><span class="badge badge-info badge-pill p-2"><?=  ucfirst($game['edition']) ?></span></h5>	
				<div class="">
					<div class="text-info font-weight-bold">
						<h6 class="badge badge-info badge-pill p-2 mt-3">Rp.<?= number_format($game['price']); ?></h6>
						<form action="<?= base_url('cart/add') ?>" method="POST" id="FormAdd">
							<input type="hidden" name="product_id" value="<?= $game['id'] ?>">
							<button type="submit" class="btn btn-large btn-success btn-block badge badge-info badge-pill p-2 mt-5">ADD</button>
						</form>
					</div>
				</div>
			<?php } else { ?>
				<h4 class="font-weight-normal"><?=  ucfirst($game['kategori_name']) ?></h4>
				<p class="font-weight-bold">PRICE</p>
				<h5><span class="badge badge-info badge-pill p-2" style="margin-bottom: 10px;">Denom</span></h5>	
				<div class="">
					<?php
					if($game['kategori'] == 3) {
						$action = "cart/add_voucher";
					} else if($game['kategori'] == 2) {
						$action = "cart/add_top_up";
					}
					?>
					<form action="<?= base_url($action) ?>" method="POST" id="FormAdd">
						<div class="text-info font-weight-bold" style="width: 700px;">
							<?php if (count($game['denom']) > 0) { ?>
								<?php if (($game['kategori']) == 2) { ?>
									<div class="form-group" style="margin-left: -12px;">
										<label for="input" class="col-sm-2 control-label">Player ID :</label>
										<div class="col-sm-10">
											<input type="text" name="player_id" id="input" class="form-control" value="" required title="">
										</div>
									</div>
									<?php if (($game['flag_server_id']) == 1) { ?>
										<?php if (($game['slug_key_uniplay']) == "lifeafter") { ?>
											<div class="form-group" style="margin-left: -12px;">
												<label for="input" class="col-sm-2 control-label">Server ID :</label>
												<div class="col-sm-10">
													<select name="server_id" class="server_id form-control second-input" required="required">
														<option value="" selected="selected">Server</option>
														<option value="500001">MiskaTown (NA)</option>
														<option value="500002">SandCastle (NA)</option>
														<option value="500003">MouthSwamp (NA)</option>
														<option value="500004">RedwoodTown (NA)</option>
														<option value="500005">Obelisk (NA)</option>
														<option value="510001">FallForest (AU)</option>
														<option value="510002">MountSnow (AU)</option>
														<option value="520001">NancyCity (SEA)</option>
														<option value="520002">CharlesTown (SEA)</option>
														<option value="520003">SnowHighlands (SEA)</option>
														<option value="520004">Santopany (SEA)</option>
														<option value="520005">LevinCity (SEA)</option>
														<option value="500006">NewLand (NA)</option>
														<option value="520006">MileStone (SEA)</option>
														<option value="500007">ChaosOutpost (NA)</option>
														<option value="520007">ChaosCity (SEA)</option>
														<option value="520008">TwinIslands (SEA)</option>
														<option value="520009">HopeWall (SEA)</option>
														<option value="500008">IronStride (NA)</option>
													</select>
												</div>
											</div>
										<?php } else { ?>
											<div class="form-group" style="margin-left: -12px;">
												<label for="input" class="col-sm-2 control-label">Server ID :</label>
												<div class="col-sm-10">
													<input type="text" name="server_id" id="input" class="form-control" value="" required title="">
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<!-- Foreach Denom -->
								<?php foreach ($game['denom'] as $key => $value) { ?>
									<h6 class="badge badge-info badge-pill p-2 mt-3 badge-filling" name="rad_denom">
										<label id="option_<?=$value['id']?>" class="denom" denom_id="<?=$value['id']?>" style="margin-bottom: 0;">
											<input type="radio" name="denom_id" value="<?=$value['id']?>" <?=$key==0?"checked":""?>> <br> <?=$value['name']?> <br> Rp<?= number_format($value['price'], 0, ', ', '.'); ?> <br> &nbsp;
										</label>
									</h6>
								<?php } ?>
								<input type="hidden" name="product_id" value="<?= $game['id'] ?>">
								<button type="submit" class="btn btn-large btn-success btn-block badge badge-info badge-pill p-2 mt-5">ADD</button>
							<?php } ?>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>	
	
	<!-- End of hero -->

	<!-- description -->
	<div class="description-produk">
		<div class="row mt-5 mb-2">
			<div class="col">
				<h3 id="description">Description</h3>
			</div>
		</div>
		<div class="row">
			<div class="col bg-light p-5">
				<?= $game['description'] ?>
			</div>
		</div>
	</div>
	<!-- End of description -->
	<!-- System requirements -->
	<?php if($game['requirements'] != "") { ?>
	<div class="requirements-produk">

		<div class="row mt-5 mb-2">
			<div class="col">
				<h3>System Requirements</h3>
			</div>
		</div>

		<div class="row mb-5">
			<div class="col bg-light p-5">
				<?= $game['requirements'] ?>
			</div>
		</div>
	</div>
	
	<?php } ?>
	<!-- End of System requirements -->
</div>
<script type="text/javascript">
	jQuery("#FormAdd").submit(function (evt) {
		// pengecekan jika admin tidak bisa add produk
		<?php if(is_admin_boolean() == TRUE) { ?>
			alert("Admin can't add product!");
			return false;
		<?php } ?>

		<?php if ($game['kategori'] != 1) { ?>
			<?php if (count($game['denom']) > 0) { ?>
				<?php if (($game['kategori']) == 2) { ?>
					// produk dtu
					if (jQuery("input[Name='player_id']").val() == "") {
						alert("Field player id is required!");
						evt.preventDefault();
						return;
					}

					<?php if (($game['flag_server_id']) == 1) { ?>
						
						if (jQuery("input[Name='server_id']").val() == "") {
							alert("Field server id is required!");
							evt.preventDefault();
							return;
						}
						let confirmAction = confirm("Are you sure to add the game to the cart? make sure the player id and server id entered are correct.");
						if (!confirmAction) {
							return false;
						}

					<?php } else { ?>
						
						let confirmAction = confirm("Are you sure to add the game to the cart? make sure the player id entered are correct.");
						if (!confirmAction) {
							return false;
						}
					<?php } ?>
				<?php } else { ?>
					// produk voucher
					let confirmAction = confirm("Are you sure to add the game to the cart?");
					if (!confirmAction) {
						return false;
					}
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
			// produk installer
			let confirmAction = confirm("Are you sure to add the game to the cart?");
			if (!confirmAction) {
				return false;
			}
		<?php } ?>
	});
</script>
