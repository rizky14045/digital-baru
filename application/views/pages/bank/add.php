<div class="container">
	<div class="row mt-4">
		<div class="col">
			<h2 class="text-center">Add Bank</h2>
		</div>
	</div>

	<div class="row bg-light p-3 mt-4">
		<div class="col">

        <?= form_open_multipart(base_url('bank/add')) ?>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">Nama Bank</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nama_bank">
						<?= form_error('nama_bank', '<small class="form-text text-danger">', '</small>') ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">Payment Channel</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="payment_channel">
						<?= form_error('payment_channel', '<small class="form-text text-danger">', '</small>') ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label font-weight-bold">Secret Key</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="secret_key">
						<?= form_error('secret_key', '<small class="form-text text-danger">', '</small>') ?>
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

