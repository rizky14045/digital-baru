<div class="container">
	<div class="row mt-4">
		<div class="col">
			<h2 class="text-center">Update Game</h2>
		</div>
	</div>

	<div class="row bg-light p-3 mt-4">
		<div class="col">

			<?= form_open_multipart(base_url('product_uniplay/edit/' . $product['id'])) ?>
				<input type="hidden" name="id" value="<?= $product['id'] ?>">
				<div class="form-group row">
					<label for="name" class="col-sm-2 col-form-label font-weight-bold">Game Name</label>
					<div class="col-sm-10">
						<label for="name" class="col-sm-10 col-form-label font-weight-bold"><?= $product['name'] ?></label>
					</div>
				</div> 
				<?php foreach ($product_denom as $key => $value) { ?>
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label font-weight-bold">Price <?=$value['name']?></label>
						<div class="col-sm-2">
							<input type="number" class="form-control" name="price[<?=$value['id']?>]" value="<?= $value['price'] != NULL ? $value['price'] : $value['price_reseller'] ?>">
							<?= form_error('price['.$value['id'].']', '<small class="form-text text-danger">', '</small>') ?>
						</div>
						<div class="col-sm-5">
							<label for="name" class="col-sm-5 col-form-label">Reseller Price</label>
							<label for="name" class="col-sm-5 col-form-label">Rp<?=number_format($value['price_reseller'], 0, ', ', '.')?></label>
						</div>
					</div> 
				<?php } ?>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">Description</label>
					<div class="col-sm-10">
						<textarea class="form-control description-add" id="description-add" name="description">
							<?= $product['description'] ?>
						</textarea>
						<?= form_error('description', '<small class="form-text text-danger">', '</small>') ?>
					</div>
				</div>	
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">System Requirements</label>
					<div class="col-sm-10">
						<textarea class="form-control system-requirements-add" id="system-requirements-add" name="requirements">
							<?= $product['requirements'] ?>
						</textarea>
						<?= form_error('requirements', '<small class="form-text text-danger">', '</small>') ?>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<a href="<?= base_url('product_uniplay') ?>" class="btn btn-secondary btn-sm">
							<i class="fa fa-arrow-left mr-1"></i>
							Back
						</a>
						<button type="submit" class="btn btn-info btn-sm float-right">
							<i class="fa fa-save mr-2"></i>
							Update
						</button>
					</div>
				</div>
			<?= form_close() ?>			
		</div>
	</div>
</div>

