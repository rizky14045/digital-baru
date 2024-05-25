<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/fontawesome/css/all.min.css">
   <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/summernote/dist/summernote-bs4.css"> -->
   <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <title>Digital Baru - <?= $title ?></title>
   <style>
	 @media (max-width: 576px) { 
      .carousel-banner{
         width: 100% !important;
         height:100% !important;
         box-shadow: 0px 0px 10px 0px #333333 !important;
      
      }
      .carousel-image {
      height: 100% !important;
      /* background-position: center; */
      background-size: cover;
      /* object-fit: cover; */
   }
   .card-game{
      margin:auto;
      width:240px !important;
   }
   .card-image-content{
      width:224px !important;
      height:300px!important;
      background-size: cover;
   }
	}
   </style>

   <script src="<?= base_url() ?>assets/vendors/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>assets/vendors/popper/popper.min.js"></script>
   <script src="<?= base_url() ?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
   <!-- <script src="<?= base_url() ?>assets/vendors/summernote/dist/summernote.min.js"></script> -->
   <script src="//cdn.ckeditor.com/4.10.0/full-all/ckeditor.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>

	<!-- Navbar -->
	<?php $this->load->view('layouts/_navbar') ?>
   <!-- End of Navbar -->

	<!-- Content -->
	<?php $this->load->view($page) ?>
	<!-- End for Content -->

   <!-- Footer -->
<?php $this->load->view('layouts/_footer') ?>
<!-- End of footer -->
	<script>
        CKEDITOR.replace( 'description-add' );
    </script>
	<script>
        CKEDITOR.replace( 'system-requirements-add' );
    </script>
	<script>
		$(document).ready(function() {
			$('.select-2').select2();
		});
	</script>	
</body>
</html>
