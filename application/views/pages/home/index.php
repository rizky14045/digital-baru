<!-- Carousel -->
<div id="carouselExampleCaptions" class="carousel slide carousel-banner mt-5" data-ride="carousel">
	<div class="carousel-inner">
		<?php $no = 0;?>
		<?php foreach($banners as $b) : ?>
			<?php $no++;  ?>
			<div class="carousel-item <?php if($no <= 1) { echo "active"; } ?>">
			<?php if($b['product_id']==0 ) :?>
				<a href="<?= base_url('home/allgames') ?>">
				<img src="<?= base_url() ?>images/banner/<?= $b['image'] ?>" class="img-fluid carousel-image">
			</a>
			<?php else: ?>
				<a href="<?= base_url('home/detail/' . $b['product_id']) ?>">
				<img src="<?= base_url() ?>images/banner/<?= $b['image'] ?>" class="img-fluid carousel-image">
			</a>
			<?php endif;?>
			</div>
		<?php endforeach ?> 
	</div>
	<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
	<i style="font-size: 40px; color:blue;" class="fas fa-caret-left"></i>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
	<i style="font-size: 40px; color:blue;" class="fas fa-caret-right"></i>
		<span class="sr-only">Next</span>
	</a>
</div>
<!-- End of Carousel -->

<!-- List Item -->

<div class="content-home container mt-5 mb-5">
	<div class="row mt-5 content-header p-3">
			<h5>Latest releases</h5>
			<a href="<?= base_url('home/allgames') ?>" class="text-dark my-auto">
				More...
			</a>
	</div>
	<div class="row mb-5 p-4">
	<?php foreach($games_last as $key_game => $game) : ?>
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

<?php foreach($games as $key => $arr_game) : ?>
<div class="content-home container mt-5 mb-5">
	<div class="row mt-5 content-header p-3">
			<h5><?=$key?></h5>
			<a href="<?= base_url('home/allGamesKategori/' . $key) ?>" class="text-dark my-auto">
				More...
			</a>
	</div>
	<div class="row mb-5 p-4">
	<?php foreach($arr_game as $key_game => $game) : ?>
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
<?php endforeach; ?>
<!-- End of List Item -->

