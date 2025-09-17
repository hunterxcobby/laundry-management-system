<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> <?php echo $TITLE=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?> </title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>webnew/img/favicon.png" rel="icon">
  <link href="<?php echo base_url(); ?>webnew/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>webnew/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>webnew/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(); ?>webnew/css/style.css" rel="stylesheet">

  <!-- Whatapp Float Button -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>webnew/whatapp/floating-wpp.css">

  <!-- =======================================================
  * Template Name: Resi - v2.0.0
  * Template URL: https://bootstrapmade.com/resi-free-bootstrap-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- <h1 class="logo"><a href="index.html"> SpeedywashIndia</a></h1> -->
      <!-- Uncomment below if you prefer to use an image logo -->
       <a href="<?=base_url()?>" class="logo"><img src="<?php echo base_url(); ?>webnew/img/logo.png" alt="" class="img-fluid" style="height:75px;width:auto;"></a>

      <nav class="nav-menu d-none d-lg-block ml-auto pr-5 mr-5">
        <ul>
          <li class="active"><a href="<?=base_url()?>#header">Home</a></li>
             <li><a href="<?=base_url()?>#about">About</a></li>
          <li><a href="<?=base_url()?>#services">Services</a></li>
          <!-- <li><a href="#portfolio">Portfolio</a></li> -->
          <li><a href="<?=base_url()?>index.php/web/pricing">Pricing</a></li>
          <li><a href="<?=base_url()?>#packages">Packages</a></li>
         
             <!-- <li><a href="#about">FAQ</a></li> -->
          <li><a href="<?=base_url()?>#contact">Contact</a></li>

        </ul>
      </nav><!-- .nav-menu -->

      <a href="#about" class="get-started-btn scrollto text-white" style="font-size:15px;background:#006bad;"><i class="icofont-phone"></i>  <span class="my-auto"> 77539 69990 </span> </a>

    </div>
  </header><!-- End Header -->
