<div class="container">
	<div class="row mt-4">
		<div class="col">
			<div class="card">
				<h5 class="card-header">Checkout Failed</h5>	
				<div class="card-body">
					<h4 class="text-danger"><strong><?= $content['status_message'] ?></strong></h4>
					<!--<p>If you have already made a payment, please send proof of transfer<a href="<?= base_url('myorder/detail/' . $content['invoice']) ?>"> to this link</a></p> -->
					<a href="<?= base_url('home') ?>" class="btn btn-primary btn-sm">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>
