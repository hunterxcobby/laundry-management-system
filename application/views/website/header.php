<?php include('system_currency.php'); date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone); $active_menu=$this->session->userdata('webmenu'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="fav.ico">
	<title> <?php echo $TITLE=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?> </title>
  <script>if ( top !== self && ['iPad', 'iPhone', 'iPod'].indexOf(navigator.platform) >= 0 ) top.location.replace( self.location.href );</script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?php echo base_url(); ?>web/external/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/fonts/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/external/animate/animate.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/external/slick/slick.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/external/slick/slick-theme.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/external/magnific-popup/magnific-popup.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/external/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>web/css/style.css" rel="stylesheet">
	<!-- REVOLUTION STYLE SHEETS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>web/external/revolution/css/settings.css">
	<!-- REVOLUTION LAYERS STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>web/external/revolution/css/layers.css">
	<!-- REVOLUTION NAVIGATION STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>web/external/revolution/css/navigation.css">
	
	
</head>

<body>
					
					
	
	<header>
		<div class="container" style="margin-top:-35px;" >
			<div class="row">
				<div class="col-sm-12 visible-sm visible-xs">
					<!-- box-telephone -->
					<div class="box-telephone ">
						<address>
							<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_phone; ?>
						</address>
				<?php
				
				if($this->session->userdata('cust_id')=="")
				{
				?>	
						<div class="time visible-sm visible-xs"><a class="btn btn-success btn-top" style="width:90px;" data-toggle="modal" data-target="#login" href="#"> <span style="color:white;"> Login </span> </a> &nbsp <a class="btn btn-primary btn-top" style="width:90px;" data-toggle="modal" data-target="#Register" href="#"> <span style="color:white;" > Register </span> </a></div>
				<?php
				}		
				else
				{
				?>
						<div class="time visible-sm visible-xs"><a class="btn btn-primary btn-top" style="width:90px;" href="<?php echo base_url();?>index.php/website/webcust_orderlist"> <span style="color:white;"> My Account </span> </a> <a class="btn btn-danger btn-top" style="width:90px;" href="<?php echo base_url();?>index.php/website/logout" onclick="return confirm('Are you sure you want to logging out?');"> <span style="color:white;"> Logout </span> </a> </div> 
				<?php		
				}		
				?>
			

					</div>
					<!-- /box-telephone -->
				</div>
				
				<div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:15px;">
					<!-- logo -->
					
					<a class="logo" title="Laundry & Dry Cleaning" href="<?php echo base_url();?>index.php/website" style="text-decoration:none;"> 
					
					<!--<span style="font-size:25px;font-weight:bold;color:green;"> <i> <?php echo $TITLE; ?> </i> </span> <span style="font-size:25px;font-weight:bold;color:blue;"> <i> <?php //echo $shop[1] ." ". $shop[2]; ; ?> </i> </span> <br/> <span style="margin-top:-100px;font-size:18px;clear:top;"> <?php echo $slogon="<span style='color:#8E44AD;font-size:16px;'> <i> Laundry & Dry Cleaning System </i></span>"; ?>  </span> </a> -->
				        <img src="<?php echo base_url();?>assets/images/logo.png" style="height:120px;width:350px;margin-left:-50px;margin-top:-15px;overflow:auto;"> 
				        </a>
					<!-- /logo -->
				</div>
				
				
				<div class="col-sm-12 col-md-4 col-lg-4 hidden-sm hidden-xs ">
					<!-- box-location -->
					<address class="box-location">
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add1; ?> <br> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add2; ?> <br/> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_city; ?>, <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_state; ?> - <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_zip; ?>
					</address>
					<!-- /box-location -->
				</div>
				
				<div class="col-sm-12 col-md-4 col-lg-4 hidden-sm hidden-xs">
					<!-- box-telephone -->
					<div class="box-telephone">
						<address>
							<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_phone; ?>
						</address>
				
				<?php
				//echo $this->session->userdata('cust_id');
				if($this->session->userdata('cust_id')=="")
				{
				?>		
						<div><a class="btn btn-success btn-top" style="width:90px;" data-toggle="modal" data-target="#login" href="#"> <span style="color:white;"> Login </span> </a> &nbsp <a class="btn btn-primary btn-top" style="width:90px;" data-toggle="modal" data-target="#Register" href="#"> <span style="color:white;" > Register </span> </a></div>
				<?php
				}
				else
				{
				?>		
						<div>
						<a class="btn btn-primary btn-top" style="width:90px;" href="<?php echo base_url();?>index.php/website/webcust_orderlist"> <span style="color:white;"> My Account </span> </a>
						<a class="btn btn-danger btn-top" style="width:90px;" href="<?php echo base_url();?>index.php/website/logout" onclick="return confirm('Are you sure you want to logging out?');"> <span style="color:white;"> Logout </span> </a> </div> 
				<?php
				}		
				?>	
					</div>
					<!-- /box-telephone -->
				</div>
			</div>
		</div>
					
					
		<div class="box-nav">
			<div class="container">
				<div class="row">
					<div class="center">
						<a id="touch-menu" class="mobile-menu" href="#">
							<span class="icon-menu-button-of-three-horizontal-lines"></span>
						</a>
						<nav class="top-menu">
							<ul class="menu">
								<li class="<?php if($active_menu=='home') echo "active"; ?>"><a href="<?php echo base_url();?>index.php/website">Home</a></li>
								<li class="<?php if($active_menu=='about') echo "active"; ?>"><a href="<?php echo base_url();?>index.php/website/about">About</a></li>
								<!--
								<li>
									<a href="#">Services</a>
									<ul>
										<li><a href="#">Laundry Service</a></li>
										<li><a href="#">Dry Cleaning</a></li>
										<li><a href="#">Leather & Suede Cleaning</a></li>
										<li><a href="#">Wedding Gown Cleaning & Preservation</a></li>
										<li><a href="#">Tailoring & Alterations</a></li>
										<li><a href="#">Pillow Refurbishing</a></li>
										<li><a href="#">Linen, Upholstery, & Area Rug Cleaning</a></li>
									</ul>
								</li> -->
								
								<li class="<?php if($active_menu=='prices') echo "active"; ?>"><a href="<?php echo base_url();?>index.php/website/pricelist">Prices</a></li>
								<!--
								<li>
									<a href="#">Blog</a>
									<ul>
										<li><a href="#">Blog Classic</a></li>
										<li><a href="#">Blog Post Card</a></li>
										<li><a href="#">Blog Single post</a></li>
									</ul>
								</li> -->
								
								<?php
								if($this->session->userdata('cust_id')!="")
								{ ?>
								<li > <a href="#modalOrder" class="popup-link"> Order Online </a> </li>
								
								<?php
								}
								else
								{
								?>
								<li > <a href="<?php echo base_url();?>index.php/website/auth" > Order Online </a> </li>
								<?php
								}
								?>
								
								
								
								
								<li class="<?php if($active_menu=='faq') echo "active"; ?>" ><a href="<?php echo base_url();?>index.php/website/faq">FAQ</a></li>
								
								<li class="<?php if($active_menu=='contacts') echo "active"; ?>"><a href="<?php echo base_url(); ?>index.php/website/contact">Contacts</a></li>
								
								
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
					<center>
					<?php
					if($this->session->userdata('cust_id')!="") {
					$this->db->where('coupon' ,'yes');
					$promo = $this->db->get('tax_charges');
					
					echo '<MARQUEE style="border:0px solid gray;padding:5px;width:85%;"><b> COUPON OFFERS </b> -';
					foreach($promo->result() as $prow) :
					{	
						echo $prow->charge_remarks.'-> [ '.$prow->charge_name.' ],&nbsp;&nbsp; ';
					}
					endforeach;	
					echo '</MARQUEE>'; }
					?> </center>