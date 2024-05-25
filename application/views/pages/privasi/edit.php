<div class="container">
	<div class="row mt-4">
		<div class="col">
			<h2 class="text-center">Update Bank</h2>
		</div>
	</div>

	<div class="row bg-light p-3 mt-4 mb-5">
		<div class="col">

        <?= form_open_multipart(base_url('privasi/edit/'.$privasi['id'])) ?>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">Description</label>
					<div class="col-sm-10">
						<textarea class="form-control description-add" id="description-add" name="description" >
						<?= $privasi['description'] ?>
					</textarea>
						<?= form_error('description', '<small class="form-text text-danger">', '</small>') ?>
					</div>
				</div>	
				<div class="row">
					<div class="col">
						<a href="<?= base_url('bank') ?>" class="btn btn-secondary btn-sm">
							<i class="fa fa-arrow-left mr-1"></i>
							Back
						</a>
						<button type="submit" class="btn btn-info btn-sm float-right">
							<i class="fa fa-save mr-2"></i>
							Save
						</button>
					</div>
				</div>
                <?= form_close() ?>		
		</div>
	</div>
</div>

