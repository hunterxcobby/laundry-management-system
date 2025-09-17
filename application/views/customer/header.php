<?php
include('system_currency.php');
$active_menu=$this->session->userdata('menu');
$active_submenu=$this->session->userdata('submenu');
date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
$title=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name;
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title; ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		
		
		<!-- page specific plugin styles -->
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.min.css" />
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-colorpicker.min.css" />
		
		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.min.css" />
		
		
		
		

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		
		<script src="<?php echo base_url();?>assets/js/ace-extra.min.js"></script>
		

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url();?>assets/js/html5shiv.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							<!--<i class="fa fa-truck"></i>-->
							<img src='<?php echo base_url(); ?>assets/images/logo.png' style="height:30px; width:30px;">
							<?php echo $title; ?>
						</small>
					</a>
				</div>

				</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts" style='margin-top:10px;'>
					 <img src="<?php echo base_url();?>/assets/images/avatars/avatar.png" class="msg-photo" alt="Users" style='width:25px;height:25px;' />

					<strong class="red"> Welcome, <?php echo strtoupper($this->session->userdata('user_name')); ?> </strong>
					<!-- 
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						
							<a class="btn btn-success" href="<?php echo base_url();?>index.php/customer/orders"> 
								<i class="ace-icon fa fa-list-ol" title="Orders" style="color:white;"></i>
							</a>	
						

						
							<a class="btn btn-info" href="<?php echo base_url();?>index.php/customer/customers"> 
							<i class="ace-icon fa fa-users" title="Customers" style="color:white;"></i>
							</a>
						
					
							<a class="btn btn-warning" href="<?php echo base_url();?>index.php/customer/cloth_prices"> 
							<i class="ace-icon fa fa-inr" title="Price_List" style="color:white;"></i>
							</a>
					

						
							<a class="btn btn-danger" href="<?php echo base_url();?>index.php/cuatomer/reports"> 
							<i class="ace-icon fa fa-file-o" title="Reports" style="color:white;"></i>
							</a>
						
						

						
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div> -->
					
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="<?php if($active_menu=='dashboard') echo "active"; ?>">
						<a href="<?php echo base_url();?>index.php/customer">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($active_menu=='orders') echo "active open"; ?>"">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Job Order </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($active_submenu=='orders') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/customer/customer_orders/session_partyname">
									<i class="menu-icon fa fa-caret-right"></i>
									Orders
								</a>

								<b class="arrow"></b>
							</li>

							
						</ul>
					</li>

					<!-- <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> Reports </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="form-elements.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Order Report
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="form-wizard.html">
									<i class="menu-icon fa fa-caret-right"></i>
									 Due Amount Report
								</a>

								<b class="arrow"></b>
							</li>

														
						</ul>
					</li> -->

					
					<li class="">
						<a href="<?php echo base_url();?>index.php/customer/address_crud/show">
							<i class="menu-icon fa fa-map-marker "></i>
							<span class="menu-text"> Address </span>
						</a>

						<b class="arrow"></b>
					</li>
					
					<li class="">
						<a href="<?php echo base_url();?>index.php/customer/profile">
							<i class="menu-icon glyphicon glyphicon-edit"></i>
							<span class="menu-text"> Profile </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="<?php echo base_url();?>index.php/customer/logout">
							<i class="menu-icon glyphicon glyphicon-log-out"></i>
							<span class="menu-text"> Log Out </span>
						</a>

						<b class="arrow"></b>
					</li>

					

					</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>