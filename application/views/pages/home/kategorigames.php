
<!-- List Item -->
<div class="content-home container mt-5 mb-5">
	<div class="row mt-5 content-header p-3">
			<h5><?=$title?></h5>
	</div>
	<div class="row mb-5 p-4">
		<?php foreach($games as $game) : ?>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mt-4">
				<div class="card-game card p-2">
					<img src="<?= base_url() ?>/images/game/<?= $game['image'] ?>" class="card-img-top card-image-content" alt="<?= $game['name'] ?>">
					<div class="card-body">
						<h6 class="card-title font-weight-bold"><?= $game['name'] ?></h6>
						<?php if ($game['kategori'] == 1) { ?>
							<h6 class="text-muted"><?= ucfirst($game['edition']) ?></h6>
							<h3 class="text-right text-warning price mt-4">Rp.<?= number_format($game['price']); ?></h3>
						<?php } else { ?>
							<h6 class="text-muted"><?= ucfirst($game['kategori_name']) ?></h6>
							<h3 class="text-right text-warning price mt-4">&nbsp;</h3>
						<?php } ?>
						<a href="<?= base_url('/home/detail/' . $game['id']) ?>" class="btn btn-outline-info btn-sm btn-block mt-3">See More</a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<!-- End of List Item -->
