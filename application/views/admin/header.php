<?php
include('system_currency.php');
$active_menu=$this->session->userdata('menu');
$active_submenu=$this->session->userdata('submenu');

date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
$title=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name;

$MasterAdmin=$this->session->userdata('user_from');
$storeId=$this->session->userdata('store_id');
$modelpermission=array('desktop','master','garment','services','joborder','reports','settings','groupanduser');

if($MasterAdmin=="admin")
{	// Admin Menu Permission 
	$modelpermission=array('desktop','master','garment','services','joborder','reports','settings','groupanduser');


}
elseif($MasterAdmin=="store")
{	// Laundry Store Menu Permission 
	$modelpermission=array('desktop','master','garment','services','joborder','reports');
	
}	
else
{	// Employee Menu Permission 
	$modelpermission=array('desktop','master','garment','services','joborder','reports','settings','groupanduser');
	$Group_ID=$this->session->userdata('group_id');
	$model_permission = $this->db->get_where('mem_group' , array('id' =>$Group_ID))->row()->group_permission;
	$modelpermission=unserialize($model_permission);
}	

$helppath="https://laundry.redplanetcomputers.com/docs";
$logoutmsg=lang('Logoutmsg'); 
	
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title; ?> </title>

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
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/search.css" />
		
				

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

	<!-- Order Model -->
		

	<body class="no-skin">
				<!-- (Ajax Modal)-->
			<div class="modal fade" id="modal_order_date">
				<div class="modal-dialog">
					<div class="modal-content">
						
						<div class="modal-header" style="background:#fbeed5;" >
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><?php echo "Add Item "; ?></h4>
						</div>
						
						<div class="modal-body" style="height:500px; overflow:auto;">
						
							
							
						</div>
					   <!-- 
						<div class="modal-footer" style="background:#fbeed5;">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						-->
					</div>
				</div>
			</div>
			
				<!------------------>	
		
	
		<div id="navbar" class="navbar navbar-default" style="background:#4cae4c!important;">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<!--<i class="fa fa-truck"></i>-->
							<span class="red"><img src="<?php echo base_url();?>assets/images/logo.png" style="height:50px;width:180px;overflow:auto;margin-left:-18px;"></span>
							
						</small>
					</a>
					
				</div> <!--
				<div class="navbar-header pull-right">
						<a href="<?php echo base_url();?>index.php/admin/systemset#language" class="navbar-brand"  style="font-size:14px;" >
						
						<small>
							
						</small>
					</a>
					
				</div> -->
				
				</div><!-- /.navbar-container -->
				<span style="float:right;color:white;padding-right:30px;margin-top:15px;"> <i class="ace-icon fa fa-user" title="Invoice List" style="color:white;"></i> &nbsp; <?php echo lang('welcome'); ?>, <?php echo ($this->session->userdata('login_user'));?> 
				
				<a href="<?php echo base_url();?>index.php/login/logout" onclick="return confirm('<?php echo $logoutmsg; ?>');" style="margin-left:10px;color:white;font-size:13px;">
							<i class="menu-icon glyphicon glyphicon-log-out"></i>
							<span class="menu-text"> <?php echo lang('Logout'); ?>  </span>
						</a>  


				<?php
					$sys_lang=$this->db->get_where('settings' , array('id' =>'1'))->row()->sys_lang;

					if($sys_lang=='english') $disp_lang='English';
					if($sys_lang=='hindi') $disp_lang=' हिंदी ';
					if($sys_lang=='arabic') $disp_lang='عربى  ';
					if($sys_lang=='chinese') $disp_lang='中文 ';
					if($sys_lang=='russian') $disp_lang='русский';
					if($sys_lang=='bengali') $disp_lang='বাঙালি ';
					if($sys_lang=='spanish') $disp_lang='Español ';
					if($sys_lang=='french') $disp_lang='français ';
					if($sys_lang=='portuguese') $disp_lang='Português ';
					if($sys_lang=='indonesia') $disp_lang='Bhasa Indonesian ';
					if($sys_lang=='philippines') $disp_lang='Pilipinas ';
							
				?>
							
<!--
				<a href="<?php echo base_url();?>index.php/admin/systemset#language " style="margin-left:10px;color:white;font-size:12px;">
							
							<span class="menu-text pull-right"> [ Language :  <?php echo $disp_lang ; ?> ]	 </span>
						</a>  		
-->
				</span>


				

				
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						
							
							<a class="btn btn-info" href="<?php echo base_url();?>index.php/admin/customers"> 
							<i class="ace-icon fa fa-users" title="Customers" style="color:white;"></i>
							</a>
						
					
							<a class="btn btn-warning" href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list"> 
							<i class="ace-icon fa fa-list" title="Invoice List" style="color:white;"></i>
							</a>
					

						
							<a class="btn btn-danger" href="<?php echo base_url();?>index.php/admin/orderreport/date_view"> 
							<i class="ace-icon fa fa-pencil-square-o" title="Reports" style="color:white;"></i>
							</a>
						
					    	<a class="btn btn-success" href="<?php echo base_url();?>index.php/welcome"> 
								<i class="ace-icon fa fa-tachometer" title=" Settings" style="color:white;"></i>
							</a>
						

						
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-green3"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="<?php if($active_menu=='dashboard') echo "active"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("desktop", $modelpermission))  
							{ ?>
							<a href="<?php echo base_url();?>index.php/welcome">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> <?php echo lang('Dashboard'); ?>  </span>
							</a>
							<?php
							}
							else
							{	
							?>
							<a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-tachometer red"></i>
							<span class="menu-text"> <?php echo lang('Dashboard'); ?> </span>
							</a>
							<?php
							}
						}
						
						?>
										
						

						<b class="arrow"></b>
					</li>
					
					<li class="">
						<?php if(isset($_SESSION['shopping_cart'])){ unset($_SESSION['shopping_cart']); unset($_SESSION['party_name']); $this->session->set_userdata('UpdateOrder','add_order'); } ?>
						<!-- <a href="<?php echo base_url();?>index.php/pos"> -->
						<a href="<?php echo base_url();?>index.php/admin/customer_orders/neworder">
							<i class="menu-icon glyphicon glyphicon-transfer"></i>
							<span class="menu-text"> <?php echo lang('Quick PoS'); ?> </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="" >
						<a href="#" onclick="showAjaxPickupModel('<?php echo base_url();?>index.php/admin/new_pickup_direct');" >
							<i class="menu-icon glyphicon glyphicon-earphone" style="color:#D35400;"></i>
							<span class="menu-text" style="color:#D35400;"> New Pickup Order </span>
						</a>

						<b class="arrow"></b>
					</li>
					

					<li class="<?php if($active_menu=='master') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("master", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								<?php echo lang('Master'); ?> 
							</span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-desktop red"></i>
							<span class="menu-text"> <?php echo lang('Master'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							
							
							<li class="<?php if($active_submenu=='customers') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/customers">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Customer'); ?> 
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='employee') echo "active"; ?>">
							
								<?php if ($MasterAdmin=="admin" )
								{ 
								?> 
							
								<a href="<?php echo base_url();?>index.php/admin/employee">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Employee'); ?> 
								</a>

								<b class="arrow"></b>
								<?php } ?>
							</li>
							
							<li class="<?php if($active_submenu=='expensestype') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/expenses_type">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Expenses Type'); ?> 
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='messagetemplate') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/message_template">
									<i class="menu-icon fa fa-caret-right"></i>
									Message Templates 
								</a>

								<b class="arrow"></b>
							</li>
							
						 </ul>
					</li>
					
					<li class="<?php if($active_menu=='garment') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("garment", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon glyphicon glyphicon-tint"></i>
							<span class="menu-text">
								<?php echo lang('Garments'); ?> 
							</span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon glyphicon glyphicon-tint red"></i>
							<span class="menu-text"> <?php echo lang('Garments'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							
							
							<li class="<?php if($active_submenu=='gar_type') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/cloth_type">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Garment Type'); ?> 
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='gar_colors') echo "active"; ?>">
							
								<?php if ($MasterAdmin!="")
								{ 
								?> 
							
								<a href="<?php echo base_url();?>index.php/garment/gar_color">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Garment Color'); ?> 
								</a>

								<b class="arrow"></b>
								<?php } ?>
							</li>
							
							
							
							<li class="<?php if($active_submenu=='gar_brand') echo "active"; ?>">
							
								<?php if ($MasterAdmin!="")
								{ 
								?> 
							
								<a href="<?php echo base_url();?>index.php/garment/gar_brand">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Garment Brand'); ?> 
								</a>

								<b class="arrow"></b>
								<?php } ?>
							</li>
							
							<li class="<?php if($active_submenu=='gar_defects') echo "active"; ?>">
							
								<?php if ($MasterAdmin!="")
								{ 
								?> 
							
								<a href="<?php echo base_url();?>index.php/garment/gar_defect">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Garment Defects'); ?> 
								</a>

								<b class="arrow"></b>
								<?php } ?>
							</li>
							
							
							</ul>
					</li>
					
					
					<li class="<?php if($active_menu=='services') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission) ) 
						{ if (in_array("services", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-truck"></i>
							<span class="menu-text">
								<?php echo lang('Services'); ?>   
							</span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-truck red"></i>
							<span class="menu-text"> <?php echo lang('Services'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						
						?>
						
						
						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if($active_submenu=='services') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/laundry_services">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Laundry Services'); ?> 
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='category') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/laundry_category">
									<i class="menu-icon fa fa-caret-right"></i>
									Laundry Category
								</a>

								<b class="arrow"></b>
							</li> 
							
							<li class="<?php if($active_submenu=='pricelist') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/cloth_prices">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Price List'); ?> 
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='packages') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/packages">
									<i class="menu-icon fa fa-caret-right"></i>
									Laundry Packages
								</a>

								<b class="arrow"></b>
							</li>
							
							
							
							<li class="<?php if($active_submenu=='charges') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/tax_charges">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Discount/Charges'); ?> 
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='coupons') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/promo_code">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Promo / Coupons'); ?>  
								</a>

								<b class="arrow"></b>
							</li> 
							
							
							
							

						</ul>
						
						
					</li>
					
					<li class="<?php if($active_menu=='job_order') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("joborder", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> <?php echo lang('Job Order'); ?> </span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-list red"></i>
							<span class="menu-text"> <?php echo lang('Job Order'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if($active_submenu=='neworder') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/customer_orders/neworder">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('New Order'); ?> 
								</a>

								<b class="arrow"></b>
							</li> 
							
							<li class="<?php if($active_submenu=='invoicelist') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list">
									<i class="menu-icon fa fa-caret-right"></i>
									Invoice List  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='packagelist') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/package/package_list">
									<i class="menu-icon fa fa-caret-right"></i>
									Packages List
								</a>

								<b class="arrow"></b>
							</li>
							
							
														

							<li class="<?php if($active_submenu=='expenses') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/expenses">
									<i class="menu-icon fa fa-caret-right"></i>
									Expense / Purchase 
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='outstanding') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/outstanding_list">
									<i class="menu-icon fa fa-caret-right"></i>
									Outstanding List 
								</a>

								<b class="arrow"></b>
							</li>

							<!--<li class="<?php if($active_submenu=='online_payment') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/online_payment_list">
									<i class="menu-icon fa fa-caret-right"></i>
									Online Payment List 
								</a>

								<b class="arrow"></b>
							</li> -->

						</ul>
					</li>

					<li class="<?php if($active_menu=='reports') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("reports", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> <?php echo lang('Reports'); ?> </span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-pencil-square-o red"></i>
							<span class="menu-text"> <?php echo lang('Reports'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($active_submenu=='daterep') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/orderreport/date_view" >
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Datewise Report'); ?>  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='monthrep') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/orderreport/month_view" >
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Monthly Report'); ?>   
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='income') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/income_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Income Report'); ?>  
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='expenses') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/expenses_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Expenses Report'); ?>  
								</a>

								<b class="arrow"></b>
							</li>
							
							
							<li class="<?php if($active_submenu=='profitloss') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/profitloss_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Profit and Loss'); ?>  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='outstand') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/outstand_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									Outstanding Report  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='dailycollect') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/daily_collection_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									Daily Collection Report  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='dailycredit') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/daily_credit_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									Datewise Credit Report  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='monthlycredit') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/monthly_credit_report" >
									<i class="menu-icon fa fa-caret-right"></i>
									Monthly Credit Report  
								</a>

								<b class="arrow"></b>
							</li>

							<li class="<?php if($active_submenu=='online_payment') echo "active"; ?>">
								<a data-toggle="" href="<?php echo base_url();?>index.php/admin/online_payment_list" >
									<i class="menu-icon fa fa-caret-right"></i>
									Online Payment Report  
								</a>

								<b class="arrow"></b>
							</li>
						
						</ul>
						
					</li>

					
					<li class="<?php if($active_menu=='settings') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("settings", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cog"></i>
							<span class="menu-text"> Settings  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-cog red"></i>
							<span class="menu-text"> <?php echo lang('Settings'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($active_submenu=='sysset') echo ""; ?>">
								<a href="<?php echo base_url();?>index.php/admin/systemset#language">
									<i class="menu-icon fa fa-caret-right"></i>
									Choose Language 
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='sysset') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/systemset">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('General Settings'); ?> 
								</a>

								<b class="arrow"></b>
							</li>
							
							
							
							<li class="<?php if($active_submenu=='stores') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/stores">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Laundry Stores'); ?>  
								</a>

								<b class="arrow"></b>
							</li>
							
							<!--
							<li class="<?php if($active_submenu=='bulksms') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/bulk_sms_email">
									<i class="menu-icon fa fa-caret-right"></i>
									Bulk Email, SMS
								</a>

								<b class="arrow"></b>
							</li>
							-->


							<?php if ($this->session->userdata('user_from') !="")
							{ 
							?>
							<li class="<?php if($active_submenu=='adminprofile') echo "active"; ?>">
								
								
								<a href="<?php echo base_url();?>index.php/admin/profile">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Admin Profile'); ?>  
								</a>
							
								<b class="arrow"></b>
							</li>
							<?php 
							}
							?>

						</ul>
						
						
					</li>

					

					
					
					<li class="<?php if($active_menu=='groupusers') echo "active open"; ?>">
						<?php 
						if (!empty($modelpermission)) 
						{ if (in_array("groupanduser", $modelpermission))  
							{ ?>
							<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> <?php echo lang('Groups_Role'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a>
							<?php
							}
							else
							{
							?>
							<!-- <a href="#" onclick="alert('<?php echo lang('nopermission'); ?>')">
							<i class="menu-icon fa fa-users red"></i>
							<span class="menu-text"> <?php echo lang('Groups_Role'); ?>  </span>
							<b class="arrow fa fa-angle-down"></b>
							</a> -->
							<?php
							}
						}
						?>
						
						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($active_submenu=='groups') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/groups">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Groups'); ?>  
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($active_submenu=='permission') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/group_permission">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo lang('Role'); ?>  
								</a>

								<b class="arrow"></b>
							</li>

							
							
							
						</ul>
						
						
					</li>

					<li class="<?php if($active_menu=='banners') echo "active open"; ?>">
						
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-image"></i>
							<span class="menu-text"> Banners</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($active_submenu=='banner_list') echo "active"; ?>">
								<a href="<?php echo base_url();?>index.php/admin/banner">
									<i class="menu-icon fa fa-caret-right"></i>
									Add Banner  
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="<?php echo base_url();?>index.php/admin/banner">
									<i class="menu-icon fa fa-caret-right"></i>
									Banner List 
								</a>

								<b class="arrow"></b>
							</li>

							
							
							
						</ul>
					</li>
					

					
					
					<?php if ($this->session->userdata('user_from')=="")
					{ 
					?>
							
					<li class="">
						<a href="<?php echo base_url();?>index.php/admin/emp_password">
							<i class="menu-icon glyphicon glyphicon-pencil"></i>
							<span class="menu-text"> <?php echo lang('Change Password'); ?>  </span>
						</a>

						<b class="arrow"></b>
					</li>
					<?php
					}
					?>

					
					<li class="">
						<a href="<?php echo base_url();?>index.php/login/logout" onclick="return confirm('<?php echo $logoutmsg; ?>');">
							<i class="menu-icon glyphicon glyphicon-log-out"></i>
							<span class="menu-text"> <?php echo lang('Logout'); ?>  </span>
						</a>

						<b class="arrow"></b>
					</li>

					

					</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>
