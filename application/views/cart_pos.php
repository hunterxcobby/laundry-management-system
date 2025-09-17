<?php
date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
$title=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name;
include('admin/system_currency.php');
?>
<?php if ($this->session->flashdata('alert_message')): ?>
    <script>
        alert("<?= $this->session->flashdata('alert_message'); ?>");
    </script>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title; ?> </title>

		<meta name="description" content="This is page-header (.page-header &gt; h1)" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.min.css" />
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-colorpicker.min.css" />
		

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/loading.css" />
		
		

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

		<style>
		/*table,tr,td { border :1px solid black; }*/
		</style>
		
	</head>

	<body class="no-skin">
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
							<img src="<?php echo base_url();?>assets/images/logo.png" style="height:50px;width:180px;overflow:auto;margin-left:-18px;">
						</small>
					</a>
				</div>


				</div><!-- /.navbar-container -->
				<span style="float:right;color:white;padding-right:30px;margin-top:15px;"> <i class="ace-icon fa fa-user" title="Invoice List" style="color:white;"></i> &nbsp; <?php echo lang('welcome'); ?>, <?php echo ucwords($this->session->userdata('login_user'));?> </span>
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo base_url();?>index.php/welcome"><?php echo lang('Dashboard'); ?> </a>
							</li>

							<li>
								<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list"> <i class="ace-icon fa fa-list"></i> <?php echo lang('Orders List'); ?>  </a>
							</li>
							<li> <a href="<?php echo base_url();?>index.php/login/logout"> <?php echo lang('Logout'); ?>  </a> </li>
							
							<span style="margin-left:390px;"><img src="<?php echo base_url();?>/assets/images/full.png" onclick="toggleFullScreen(document.body)" style="height:30px;width:30px;border:1px solid #D3D3D3; padding:2px;" title="<?php echo lang('FullScr'); ?>"> </span>
							
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									
									<?php
									$ChkOrderStatus="add_order";
									
									if($this->session->userdata('UpdateOrder')!="") $ChkOrderStatus=$this->session->userdata('UpdateOrder');
									$OrderStatus=""; $PaymentStatus=""; $LaundryStore="";
									$OrderAutoId=$this->session->userdata('order_auto_id');
									$formaction="quick_insert_order"; 
									$action="Save"; $Invoice=date('d-m-Y');
									
									if($ChkOrderStatus=="update_order") 
									{ $selet="disabled"; $action="Update"; $formaction="quick_update_order"; $date=date('d-m-Y',strtotime($this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->delivery_date)); $Invoice=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->invoice_no; 
									$OrderStatus=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->order_status;
									$OrderType=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->order_type;
									$PaymentStatus=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->amt_paidby;
									$PickupBy=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->pickup_by;
									$LaundryStore=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->laundry_store;
									$PromoCode=$this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->promocode; 
									$CustServices=unserialize($this->db->get_where('customer_order' , array('auto_id' => $OrderAutoId) )->row()->services); 
									}
									
									if($ChkOrderStatus=="add_order") 
									{ $selet="enable"; $action="Save"; $formaction="quick_insert_order"; $date=date('d-m-Y',strtotime('+3 days')); $Invoice=date('d-m-Y'); $PromoCode=''; $CustServices=''; $OrderType=''; }
												
									?>
											
									<div class="col-sm-6">
										<div class="widget-box  widget-color-blue">
											<div class="widget-header widget-header-primary" >
												<h4 class="widget-title white" > <?php echo lang('Order Details'); ?>  (<?php echo $Invoice; ?>) <?php echo '<span style="font-size:10px;">'.strtoupper($OrderType).'</span>'; ?>
												<?php //$cust_sel_services=unserialize($invoicerow->services);
																
																if($CustServices!="") {
																echo "<span style='font-size:9px;'> [ "; $Service="";														
																foreach($CustServices as $servicerow):
																
																$Service.=strtoupper($servicerow)." / "; 
																endforeach;
																echo substr($Service, 0, -2). "] </span>";
																}
																?>
																
													
												<?php $ChargeType='Charges'; if($PromoCode!='') { echo "<span style='color:yellow;font-size:12px;float:right;margin-right:10px;'> Applied Coupon : " . strtoupper($PromoCode); $ChargeType='Coupons'; } ?> </span> </h4>
													
												
											</div>
											
											
													  
											<div class="widget-body">
											
											<form name="quickpos_form" <?php if($ChkOrderStatus=="add_order") echo 'id="quickpos_form"'; ?> class="form-horizontal" id="quickpos-form" method="post" action="<?php echo base_url();?>index.php/admin/quick_pos/<?php echo $formaction; ?>" >
											
											
											
											<input type="hidden" name="order_date" id="order_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d'); ?>" />
											
												
												
												
												<div class="form-group" style="padding:10px;margin-top:0px;">
													
													
													
													<div class="col-sm-5">
													  
														
													<select class="chosen-select form-control" name="party_name" id="party_name" data-placeholder="<?php echo lang('Choose Customer'); ?>" <?php echo $selet; ?> required >
													<option value="" selected> </option>
													<?php 
													$CustDisc="";
													$PartyCustId=$this->session->userdata('party_name');
													$this->db->order_by("id","desc");
													$Customers = $this->db->get_where('users',array('id'=>$PartyCustId));
													$storeId=$this->session->userdata('store_id');
													if($storeId!='')
													$Customers = $this->db->get_where('users' , array('laundry_store' =>$storeId )); 	
													foreach ($Customers->result() as $custrow): 
													
													$PartyName=$custrow->first_name." ".$custrow->last_name ."- ".$custrow->mobile;
													
													$Address = $custrow->address1." ".$custrow->address2." ".$custrow->city." ".$custrow->state." - ".$custrow->zipcode ;
													
													$LaundryStoreCust = $custrow->laundry_store;
													$storeTaxable=$this->db->get_where('stores' , array('id' =>$LaundryStoreCust))->row()->store_taxable;
													$custrowid=$this->session->userdata('party_name');
													/* Outstanding AMount */
													$this->db->select();
													$this->db->select_sum('total_paid');
													$this->db->where("customer_id",$custrowid);
													$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

													$this->db->select();
													$this->db->select_sum('amt_paid');
													$this->db->where("customer_id",$custrowid);
													$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

													$OldOustandingAmt=$this->db->get_where('users',array('id' => $custrowid))->row()->outstand_amt;

													$OutStandAmount=($OldOustandingAmt+$TotalAmount)-$PaidAmount;

													if($storeTaxable=='yes')
													{
														$vatAmt=$TotalAmount*5/100;
														$OutStandAmount=$OutStandAmount+$vatAmt;
													}	
													/* End Outstand Amount */
																										
													if($custrow->id==$this->session->userdata('party_name')) { 
													$CustCharge=$custrow->cust_charges; $cust_charge=unserialize($CustCharge); $CustDisc=$custrow->cust_discount; 

													echo "<option value='$custrow->id' selected>". $PartyName ."</option>"; 
													} else {
													echo "<option value='$custrow->id'>". $PartyName ."</option>"; 	
													}
													
													?>
													
													<?php  endforeach;   ?>
													
													</select>
													<span style="width:700px;">
													<?php 
													if($this->session->userdata('party_name')!="")
													{
														$custrowid=$this->session->userdata('party_name');
													echo $this->db->get_where('users' , array('id' =>$custrowid ))->row()->address1; echo "<br/>".$this->db->get_where('users' , array('id' =>$custrowid ))->row()->city; echo " ".$this->db->get_where('users' , array('id' =>$custrowid ))->row()->state; echo" ". $this->db->get_where('users' , array('id' =>$custrowid ))->row()->zipcode; 
													$laundrystorecust=$this->db->get_where('users' , array('id' =>$custrowid ))->row()->laundry_store; if($laundrystorecust!=0) echo "<br/><span style='color:#6FB3E0!important;'>[Store -".$this->db->get_where('stores' , array('id' =>$laundrystorecust ))->row()->store_name."]</span>";

													echo "<br/> <span style='color:red;'> [Out Stand Amount : ".sprintf('%0.3f',$OutStandAmount)."] </span>";
													
													}
													?>
													</span>
													</div>
													<?php
													
													if($ChkOrderStatus=="add_order")
													{ 
													?>	
													<div class="col-sm-1" >
											
													<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/direct_cust');" style='text-decoration:none;' title="New Customer">  <span class="btn btn-white btn-sm btn-success btn-bold middle" style="font-size:20px; border:1px solid gray;padding:1px;padding-left:5px;padding-right:5px;margin-left:-10px;"> <i class="ace-icon fa fa-plus default" > </i>  </span> </a> </label>
										
													</div>
													<?php
													}
													?>
													
													<?php
													if($this->session->userdata('party_name')!="")
													{	
													?>
													
													<div class="col-sm-2" >
											
													<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_discount/create');" style='text-decoration:none;' title="Discount">  <span class="btn btn-white btn-sm btn-danger middle"> <i class="ace-icon fa fa-gift default" style="height:20px;"> </i> <?php echo lang('Discount'); ?>  </span> </a> 
													
													</div>
													
													
													
													
													<div class="col-sm-2" >
											
													<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_charges/selection/<?php echo $ChargeType; ?>');" style='text-decoration:none;' title="Charges">  <span class="btn btn-white btn-sm btn-success  middle"> <i class="ace-icon fa fa-credit-card default" style="height:20px;"> </i> <?php echo lang(''.$ChargeType.''); ?>  </span> </a> 
													
													</div>
													
													<div class="col-sm-1" >
											
													<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_remarks/create');" style='text-decoration:none;' title="Discount">  <span class="btn btn-white btn-sm btn-warning  middle"> <i class="ace-icon fa fa-info-circle default" style="height:20px;"> </i> <?php echo lang('Remarks'); ?>  </span> </a> 
													
													</div>
													
													
													
													
													<?php } ?>
													
													
													
													
													

													
											
												</div>
												
											</div>
											
													
											
											<div class="table-responsive"> 
										
													<table class="table" >  
													 <!--
													 <tr>  
														 <th width="10%">Sr.No</th>  
														 <th width="30%">Product Name</th>  
														 <th width="25%" style="text-align:right;">Unit Price  </th>
														 <th width="10%" style="text-align:center;">Qty (Kg)</th>  
														 <th width="15%" style="text-align:right;">Total</th>  
														 <th width="5%">Action</th>  
													</tr> --> 
<span style="color:#DD5A43!important;"> <?php if($OrderStatus=="cancelled") echo '<marquee behavior="alternate" direction="left"> Order Cancelled By Customers </marquee>'; ?>
												</span>															
													<?php 
													if(!empty($_SESSION['shopping_cart'])):  
														
														 $SubTotalAmt = 0; 
														 $totqty=0;  
														 $sr=1;
														 foreach($_SESSION['shopping_cart'] as $key => $product): 
													?>  
													
													<tr> <td colspan="6">
														<div class="profile-activity clearfix">
																<div>
																	<?php	
																		$filenameo="assets/stock/".$product['id'].".png";
																		if (!file_exists($filenameo)) {   
																			$filefoundo = 0;                         
																		} else 
																		{   $filefoundo=$product['id']; } 
																		?>
																	<img src="<?php echo base_url();?>assets/stock/<?php echo $filefoundo;?>.png" style="height:35px; width:35px;">
																	
																	<a class="user" href="#"> <?php echo $product['name']; ?>  </a>
																	
																	<!--  Garment Serices  --> 
																	<?php if($product['brand']!="") echo " - " . $product['brand']; ?>
																	
																	<?php if($product['pack']!="") echo " - " . $product['pack'] ; ?> 
																	<?php if($product['starch']!="") echo " - " . $product['starch'] ; ?> 
																	<?php if($product['defect']!="") echo " - " . $product['defect']; ?>
																	<?php if($product['color']!="") echo " - " . $product['color']; ?>
																	
																	
																	<!------------------------>
																	<span style="float:right;"> <?php echo $sys_curr; ?> <?php echo number_format($product['quantity'] * $product['price'], 3); ?> </span>
																														
																	<div class="time" style="margin-left:49px;margin-top:-10px;">
																		<?php echo lang('Unit'); ?>  - 
																		<?php 
																		echo $product['quantity']; 
																		echo "&nbsp;".$prodUnit=$product['unit']; 
																		echo " - "; 
																		echo $sys_curr ." ". $product['price']; 
																		?>
																		<?php if($product['unit']=="Kg") { ?>	
																		<table>
																		<td>
																			<table border="0">
																			<?php
																			$garmentkgitems=unserialize($product['kgitem']);  
																			foreach($garmentkgitems as $kgname)
																			{	echo "<tr> <td>" . $kgname . "</td></tr>"; 
																			}	
																			?>
																			</table>
																		</td>
																		<td>
																		<table border="0" style="width:20px;" >
																		<?php
																		$garmentkgqty=unserialize($product['kgqty']);  
																		$garmentkgqty=array_filter($garmentkgqty);  
																		foreach($garmentkgqty as $kgqty)
																		{	echo "<tr><td style='text-align:right;width:10px;'> x " . $kgqty . "</td></tr>";
																		}	
																		?>
																		</table>
																		</td>
																		</tr>
																		</table>
																		<?php } ?>
																		
																		
																	</div>
																	
																	
																</div>

																<div class="tools action-buttons">
																	
																	
																	<a href="#" class="green" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/garment/updation/<?php echo $product['id']; ?>');">
																	
																		<i class="ace-icon fa fa-pencil bigger-125"></i>
																	</a>
																	
																	<a href="<?php echo base_url();?>index.php/pos/remove/<?php echo $product['id']; ?>">
 																		<i class="ace-icon fa fa-trash-o bigger-130 red"></i>
																    </a>
																</div>
															</div>
															
													</td> </tr>
														<?php  

														$SubTotalAmt = $SubTotalAmt + ($product['quantity'] * $product['price']);
														
														$totqty= $totqty + $product['quantity']; $sr++;
														
														endforeach;  
														?>  
													<tr>  
														 <td colspan="3"> </td> <td align="right"> <?php echo lang('Sub Total'); ?>  :  </td> <td align="center" style="width:50px;"> ( <?php echo $totqty; ?> ) </td> 
														<input type="hidden" name="totalpc" id="totalpc" value="<?php echo $totqty; ?>">														 
														 <td align="right" style="width:100px;"> <?php echo $sys_curr; ?> <?php echo number_format($SubTotalAmt, 3); ?> &nbsp; </td>  
														  
													</tr>
<!-- start --> 
											<input type="hidden" name="dis_amt" id="dis_amt" value="<?php echo $CustDisc; ?>"> 
											
											<!-- Check Discount and Charges for Customers assigned -->
											<?php $TotalQty=0; $Sr=0; $GrandTotalAmt=0; $Minuscharges=0; $Pluscharges=0;
											if($CustDisc!=0) { $Minuscharges=-$CustDisc;  
											?>
											<tr> <td></td> <td></td><td></td> <td align="right"> <?php echo lang('Discount'); ?>  :  </td> 
											<td align="center"> <a href="<?php echo base_url();?>index.php/pos/cust_discount/updating/remove">  <i class="glyphicon glyphicon-remove red"></i> </a> </td> 
											
											<td colspan="1" align="right"><?php echo $sys_curr; ?> <?php echo number_format($Minuscharges, 3); ?> &nbsp; </td> 
											</tr>
											<?php
											}
											$this->db->order_by("transaction");
											$charge_list=$this->db->get('tax_charges');
											$discharge_temp=array();
											$i=0;
											foreach ($charge_list->result() as $chargerow):
											
												if(!empty($cust_charge)) 
												{	foreach ($cust_charge as $chargeId) :
													if($chargerow->charge_id==$chargeId) {
													?>
													
													<tr> 
													<td colspan="3"> </td> <td align="right">
													<?php echo$chargerow->charge_name; ?> 
													
													<!-- Percentage Section --> 
													
													<?php 
													
													if($chargerow->charge_type=="percentage") { echo "(".  $chargerow->charge_amt ."% )";
													?>
													 : </td> 												
													<?php 
													
													/* Minus Transaction Amount Calculation */
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.3f",($SubTotalAmt*$chargerow->charge_amt/100)); $Minuscharges=$Minuscharges+$DispCal;  
													
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name ."(". $chargerow->charge_amt ."%)"; ?>
													
													<td align="center"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_charges/selection');">  <i class="glyphicon glyphicon-pencil orange"></i> </a> </td> 
													<td align="right"> <?php echo $sys_curr; ?> <?php echo number_format($DispCal, 2); ?> &nbsp; </td> 
													
													<?php  $discharge_temp[$i]['charge_amt'] =  $DispCal; ?>
													<?php 
													}		// minus if end 
													?>
													
													<?php 
													/* Plus Transaction Amount Calculation */
													if($chargerow->transaction==1) {  $PlusDispCal=0; $PlusDispCal=sprintf("%0.2f",(($SubTotalAmt+$Minuscharges)*($chargerow->charge_amt/100))); 
													$Pluscharges=$Pluscharges+$PlusDispCal;
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name ."(". $chargerow->charge_amt ."%)"; ?>
												
													
													 <td align="center"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_charges/selection');">  <i class="glyphicon glyphicon-pencil orange"></i> </a> </td>
													 
													<td align="right"> <?php echo $sys_curr; ?> <?php echo number_format($PlusDispCal, 2); ?> &nbsp; </td>
													
													
													
													<?php  $discharge_temp[$i]['charge_amt'] =  $PlusDispCal; ?>
													<?php
													}		// plus if end 
													} 		// percentage if end
													?>		<!-- End Percentage Section -->
													
													
												<!-- Amount Section --> 
													<?php
													if($chargerow->charge_type=="amount") {  
													?>
													:  												
													</td> 
													
													<?php 
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.2f", $chargerow->charge_amt); $Minuscharges=$Minuscharges+$DispCal; 
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name; ?>
													
													 <td align="center"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_charges/selection');">  <i class="glyphicon glyphicon-pencil orange"></i> </a> </td>
													<td align="right"> <?php echo $sys_curr; ?> <?php echo number_format($DispCal, 2); ?> &nbsp; </td>
													
													
													
													<?php  $discharge_temp[$i]['charge_amt'] =  $DispCal; ?>
													<?php
													}
													?>

													<?php if($chargerow->transaction==1) {  $PlusDispCal=0; $PlusDispCal=sprintf("%0.2f", $chargerow->charge_amt); $Pluscharges=$Pluscharges+$PlusDispCal;
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name; ?>
													
													<td align="center"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/cust_charges/selection');">  <i class="glyphicon glyphicon-pencil orange"></i> </a> </td>
													<td align="right"> <?php echo $sys_curr; ?> <?php echo number_format($PlusDispCal, 2); ?> &nbsp; </td> 
													
													<?php  $discharge_temp[$i]['charge_amt'] =  $PlusDispCal; ?>
													<?php
													}		// plus if end 
													}
													?> 
													<!-- End Amount Section -->
													
													
													
													</div>
												
													<?php
													}
													//echo $chargerow->charge_name;
													endforeach;
													
												}
												$i++;	
											endforeach;	
												
											?>
											
											<input type="hidden" value='<?php echo serialize($discharge_temp); ?>' name="discharge_temp">
											
											<input type="hidden" value='<?php echo serialize($_SESSION['shopping_cart']); ?>' name="shopcart">
											
												
											<input type="hidden" name="granttotal" id="granttotal" class="form-control" value="<?php echo sprintf('%0.3f',($grandtotal=$SubTotalAmt+$Minuscharges+$Pluscharges)); ?>" readonly />
											<input type='hidden' name='cust_charges' value='<?php echo $CustCharge;?>'>
											
											<input type='hidden' name='grandtotal' id='grandtotal' value='<?php echo $grandtotal;?>'>
													
											<!-- VAT CALCULATION -->
											<?php
											
											$storeTaxable=$this->db->get_where('stores' , array('id' =>$laundrystorecust))->row()->store_taxable;
											if($storeTaxable=='yes')
											{	$vatAmt=$SubTotalAmt*5/100;
												echo '<tr>  
												<td colspan="3"> </td> 
												<td align="right"> VAT (5%)  : </td>
												<td> </td>
												<td align="right"> '.number_format($vatAmt, 3).' &nbsp;</td> 
												</tr>';
												$grandtotal=$SubTotalAmt+$vatAmt;
											}	
											?>
											

											<!-- END VAT CALC -->
											<tr>  
												<td colspan="3"> </td> 
												<td align="right"> <strong>  <?php echo lang('Grand Total'); ?>  : </strong> </td>
												<td> </td>
												<td align="right"> <strong> <?php echo $sys_curr; ?> <?php echo number_format($grandtotal, 3); ?> </strong> &nbsp; </td> 

												<input type='hidden' id="grand_total" value="<?php echo number_format($grandtotal, 3); ?>">	
												
											</tr>	
											
											<tr>
											
											<td colspan="3" > <?php echo lang('Order Status'); ?>  :
											
					<select class="form-control" name="order_status" id="order_status" style="width:230px;" >
													
					<?php if($ChkOrderStatus=="add_order") { ?>
					<option value="new_order" selected > <?php echo lang('New Order'); ?>  </option>
					<option value="pickup" > <?php echo lang('Pickup'); ?>  </option>
					<option value="processing" > Processing  </option>
					<option value="ready_for_delivery" > Ready for Delivery  </option>
					<option value="out_for_delivery" > Out for Delivery  </option>
					<option value="delivered"> Delivered  </option>
					<?php } ?>
					
					<?php if($ChkOrderStatus=="update_order") { 
					?>
					<option value="new_order"  > <?php echo lang('New Order'); ?>  </option>
					<option value="pickup" > <?php echo lang('Pickup'); ?>  </option>
					<option value="processing" selected > Processing  </option>
					<option value="ready_for_delivery" > Ready for Delivery  </option>
					<option value="out_for_delivery" > Out for Delivery  </option>
					<option value="delivered"> Delivered  </option>
					
					<option value="cancelled" <?php if($OrderStatus=="cancelled") echo "selected"; ?>  > <?php echo lang('Cancel_Cust'); ?> </option>
					<?php } ?>
					
										
					</select>
											</td>
											
											<td colspan="3"> <?php echo lang('Delivery Date'); ?>  :
											
											 <input type="text" name="due_date" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Delivery Date" value="<?php if($date!="01-01-1970") echo $date; ?>" />
											</td>
											</tr>
											
											<tr>
											
											
											<td colspan="3" > Payment Method  :
											
												<select class="form-control" name="payment_status" id="payment_status" style="width:230px;" >
																				
												<?php if($ChkOrderStatus=="add_order") { ?>
												<option value="notpaid" selected > <?php echo lang('Unpaid'); ?>  </option>
												<option value="bycash" > <?php echo lang('Cash Payment'); ?>  </option>
												<option value="bycard" > Card Payment </option>
												<option value="byonline" > Online Payment </option>
															
												<?php } ?>
												
												
												<?php if($ChkOrderStatus=="update_order") { 
												?>
												<!-- <option value="notpaid" <?php if($PaymentStatus=="notpaid") echo "selected"; ?> > <?php echo lang('Unpaid'); ?> </option>
												<option value="bycash" <?php if($PaymentStatus=="bycash") echo "selected"; ?> > <?php echo lang('Cash Payment'); ?>  </option>
												<option value="byonline" <?php if($PaymentStatus=="byonline") echo "selected"; ?> > Card Payment  </option> -->
												<option value="notpaid" selected > <?php echo lang('Unpaid'); ?>  </option>
												<option value="bycash" > <?php echo lang('Cash Payment'); ?>  </option>
												<option value="bycard" > Card Payment </option>
												<option value="byonline" > Online Payment </option>
												<?php } ?>
												
																	
												</select>
											</td>
											
											
											<td colspan="3" > <?php echo lang('Store Name'); ?>  : 
											
											<select class="input form-control" name="store_name" id="store_name" <?php if($laundrystorecust!=0) echo "style='color:#6FB3E0!important;width:300px;'"; ?> required >
												<!-- <option value="" > -- <?php echo lang('None'); ?> -- </option>							 -->
												<?php 
												$this->db->where("show_hide","show");
												$this->db->order_by("store_name");
												$StoreName=$this->db->get('stores');
												if($storeId!='')
												$StoreName = $this->db->get_where('stores' , array('id' =>$storeId )); 
												
												if($ChkOrderStatus=="add_order") { 
												
												foreach($StoreName->result() as $storerow) :
												if($laundrystorecust==$storerow->id) {							
												echo'<option value="'.$storerow->id.'" selected > '. $storerow->store_name.'</option>'; }
												else {
												echo '<option value="'.$storerow->id.'" > '. $storerow->store_name.'</option>';
												}
												 endforeach;
												}
												 ?>
												
												
												<?php if($ChkOrderStatus=="update_order") { 
												
												foreach($StoreName->result() as $storerow) :
												if($LaundryStore==$storerow->id) {
												echo'<option value="'.$storerow->id.'" selected > '. $storerow->store_name.'</option>';	
												}
												else {
												echo '<option value="'.$storerow->id.'" > '. $storerow->store_name.'</option>';	
												}
												endforeach;
												}
												?>
											</select>	
											</td>
											
											<input type="hidden" name="cloth_unit" value="<?=$prodUnit?>" readonly >
											<input type="hidden" name="payment_from" value="none" readonly >
											</tr>
											
											<tr style="display: none;" id='pay_amount'>
											<td> Payable Amount : <input type='text' class="form-control" name="amt_paid" id="amt_paid" value='' required> </td> 
											</tr>	

														<!-- Show checkout button only if the shopping cart is not empty -->
														<td colspan="6">
														 <?php 
															if (isset($_SESSION['shopping_cart'])):
															if (count($_SESSION['shopping_cart']) > 0):
														 ?>
														
														<center style='margin-top:20px;'> <input type="submit" class="btn btn-info" value="<?php echo lang(''.$action.''); ?>" /> 
														<input type="submit" class="btn btn-info" value="<?php echo lang(''.$action.''); ?> & Print"  onClick="save_prints();" /> </center>	
														 <?php endif; endif; ?>
														</td>
													</tr>
													<?php  
													endif;
													?>  
													</table>  
													</form>
											</div>								
										</div>
									</div><!-- /.row -->
									
									
									
									<!-- Second Container -->
									<div class="col-sm-6" >
										<div class="widget-box" >
											<div class="widget-header widget-header-flat" style="background:#4cae4c!important;" >
												<h4 class="widget-title white" > <?php echo lang('Service List'); ?> 
												</h4>
												
											</div>
											
											<div class="nav-search" id="nav-search" style="margin-top:-35px;">
							
											<span class="input-icon">
												<input type="text" placeholder="<?php echo lang('Search_Short'); ?>" class="nav-search-input" name="search_text"  id="search_item" autocomplete="off"  value="<?php echo $this->session->userdata('Search_Item'); ?>" style="width:175px;"/>
												<a href="#" class="btn btn-white btn-minier" style="margin-top:-5px;" id="search_item_href"> <i class="ace-icon fa fa-search nav-search-icon" ></i> </a> 
											</span>
											
											
										
											</div>
											
											

											<div class="widget-body" style="overflow:hidden; height:auto;" id="item_list">
												<div class="widget-main">
													<!-- SERVICE MENU -->
													<?php 
													$SerBack=$this->session->userdata('ServiceId');
													$Backround='white';
													if($SerBack==0) $Backround='#DAF7A6;'
													
													?>
													<div class="form-group" style="padding:10px;margin-top:0px;">
													<span style="border:1px solid green;padding:10px;margin:2px;background:<?php echo $Backround; ?>"> <a href="#" id="service_search_0" data-value="0"> <b> <?php echo lang('ALL'); ?> </b> </span></a>
													<?php
													$incr=1;
													foreach ($laundry_service->result() as $ServiceTab):
													$Background='white';
													if($SerBack==$ServiceTab->id) $Background='#DAF7A6';
										if($incr%4==0) echo "<br/> <br/><br/>";			
													echo '<span style="border:1px solid green;padding:10px;margin:2px;background:'.$Background.';font-weight:bold;"> <a href="#" id="service_search_'.$incr.'" data-value="'.$ServiceTab->id.'">'. $ServiceTab->service_name .'</span></a>';	
														
													$incr++;
													endforeach; 
													
													?>
													</div>				
											
													 <hr/> 
						
													<div class="row" style="padding-left:15px;">
		
													<?php
													$i=1;
													$query=$this->session->userdata('Search_Item');
													$ServiceID=$this->session->userdata('ServiceId');
													$this->db->like('cloth_name', $query);
													
													
													
													if($ServiceID!=0)
													{	
													$price_list= $this->db->get_where('price_list',array('service_id'=>$ServiceID));
													} else { $price_list= $this->db->get('price_list'); }
													
													//if($query!="")  { 
													//$price_list= $this->db->get('price_list'); }
		
													foreach ($price_list->result() as $row): 
													?>	
													<div class="col-sm-4 col-md-3" style='width:150px;height:200px; border:1px solid #82AF6F!important;border-radius: 5px;' >
														
														<form method="post" action="<?php echo base_url();?>index.php/pos/add/<?php echo $row->id;?>">
															<div>  
															<center>
															<h4 class="blue" style="font-size:13px;font-weight:bold;"> <?php echo $row->short_code; ?> </h4>
															
															<h5 style='font-size:10px;font-weight:bold;'  > 
															<?php
															$ser_eng="";$ser_lang="";
															foreach ($laundry_service->result() as $ServiceNm): 
															if($ServiceNm->id==$row->service_id) {
															$ser_eng=strtoupper($ServiceNm->service_name);	
															$ser_lang=$ServiceNm->service_name_lang;	
															} 
															endforeach; 
															?>
															
															<?php
															$cloth_eng=""; $cloth_lang="";
															foreach ($laundry_cloth->result() as $ClothType): 
															if($ClothType->id==$row->cloth_id) {
															$cloth_eng=strtoupper($ClothType->cloth_type);	
															$cloth_lang=$ClothType->cloth_type_lang;	
															} 
															endforeach; 
															 
														    echo $cloth_eng;
															echo "<br/>";
															echo $cloth_lang;
															?>
															</h5>
															<?php	
															$filename="assets/stock/".$row->id.".png";
															if (!file_exists($filename)) {   
																$filefound = 0;                         
															} else 
															{   $filefound=$row->id; } 
															?>
															<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/pos/garment/selection/<?php echo $row->id; ?>');"> <img src="<?php echo base_url();?>assets/stock/<?php echo $filefound;?>.png" style="height:60px; width:50px;">   </a>
															
															
															
															
															
															
															<h6> <?php echo $sys_curr; ?> <?php echo sprintf('%0.3f',$row->price);?>/<?php echo lang(''.$row->service_unit.''); ?> </h6>
															<!--
															<input type="text" name="quantity" class="form-control" value="1" id="<?php echo 'spinner'.$i; ?>" style="height:28px;" /> -->
															
															<input type="hidden" name="product_id" value="<?php echo $row->id; ?>" />
															<input type="hidden" name="name" value="<?php echo $row->short_code; ?>" />
															<input type="hidden" name="price" value="<?php echo $row->price;?>" />
															<input type="hidden" name="tot" id="tot_len" value="<?php echo count($price_list->result())+1; ?>" />
															
															<!-- <input type="submit" name="add_to_cart" style="width:125px;bottom:10px;position: absolute;margin-left:-60px;" class="btn btn-success" value="Add Item" /> -->
															</center> 
															
															</div>
														</form>
													</div>
													
													<?php
													$i++;
													endforeach;
													?>	
													</div> <!-- row --> 

											  </div>
											</div>
										</div>
									</div><!-- /.col -->
								
								

							
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			
			</div>

		<?php require_once("admin/footer.php"); ?>

		<!-- Order Model -->
		
		<script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:10px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax" >
        <div class="modal-dialog" style="height:auto; width:900px;"  >
            <div class="modal-content" >
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> <?php echo lang('Order Details'); ?> ( <?php echo date('d-m-Y'); ?> )</h4>
                </div>
                
                <div class="modal-body" style="height:auto; width:900px;">
                
                    
                    
                </div>
               
            </div>
        </div>
    </div>
	
	
		<!--[if !IE]> -->
		<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/spinbox.min.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>

		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
			
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
	
		<!-- inline scripts related to this page -->
		
		<script>
		function toggleFullScreen(elem) {
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
	
	document.addEventListener('keydown', function(e) {
  if (e.keyCode == 0 ) { // F11 key
    toggleFullScreen();
  }
}, false);

}

		</script>
		<script type="text/javascript">
			jQuery(function($) {
			
				var tot_length=$('#tot_len').val();
				for (var x = 0; x < tot_length; x++) {       						
				$('#spinner'+x+'').ace_spinner({value:0,min:1,max:500,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-white btn-success' , btn_down_class:'btn-white btn-danger' });
				} // for     
				
				$("#party_name").change(function() 
				{	$(this).after("<div class='loading'> <img src='<?php echo base_url(); ?>/assets/preloader.gif' alt='loading' /> </div>").fadeIn();	
					var cust_id = $("#party_name").val();
					var order_date = $("#order_date").val();
					//alert(cust_id);
					$.post("<?php echo base_url(); ?>index.php/admin/quick_pos/quickpos_partyname", {"party_name": cust_id, "order_date" : order_date });
					setTimeout(location.reload.bind(location), 1000);
					/*
					$.ajax({
						type : "POST",
						url  : "<?php echo base_url(); ?>index.php/customer_orders/quickpos_partyname",
						data : "group_id=" + group_id,
						success: function(data) 
						 }); */
				});
				
				$('#search_item').change(function(){
				$(this).after("<div class='loading'> <img src='<?php echo base_url(); ?>/assets/preloader.gif' alt='loading' /> </div>").fadeIn();	
				var search = $(this).val(); 
				
				//alert(search);
				$.post("<?php echo base_url(); ?>index.php/admin/quick_pos/pos_search", {"search_query": search});
				$('#search_item').focus();
				setTimeout(location.reload.bind(location), 1000);
				
				});
					
				for (let i = 0; i < 10; ++i) {
				$('#service_search_'+i).click(function(){
					//location.reload(2);
					var serviceval = $(this).data("value"); 
					//alert(serviceval);
					$.post("<?php echo base_url(); ?>index.php/admin/quick_pos/service_search", {"serviceId": serviceval});
					setTimeout(location.reload.bind(location), 1000);
				
				});
				}

				
					
	
		
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
				}
				
				$('#quickpos_form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
											
						party_name: {
							required: true,
							party_name: 'required'
						},
						
						store_name: {
							required: true,
							store_name: 'required'
						}
						
											
					},
			
					messages: {
						
						party_name: "Choose Customer Name",
						store_name : "Choose Store Name"		
						
						
					},
			
			
					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},
			
					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},
			
					submitHandler: function (form) {
					},
					invalidHandler: function (form) {
					}
				});
				
				
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})

				$("#payment_status").change(function(){
					var values = $(this).val();
					// alert(values);
					if(values!=='notpaid')
					{
						var gradTotal=$("#grand_total").val();
						$("#pay_amount").css({display: "block"});
						$("#amt_paid").val(gradTotal);
						$("#amt_paid").focus();
						
					}
					else
					{
						$("#pay_amount").css({display: "none"});
						$("#amt_paid").val(0);
					}	
				});
			})

			function save_prints() 
				{
					//alert('fun');
					// quickpos_form.setAttribute("target", "_blank");
					var customer = document.getElementById('party_name').value;
					// alert(customer);
					if(customer!='')
					{	
					document.quickpos_form.action = "<?php echo base_url();?>index.php/admin/quick_pos/<?php echo $formaction; ?>/print";
					document.quickpos_form.submit();
					}
					else
					{
						alert("Please Select Customer Name"); 
					}	

						
				}

		</script>
	</body>
</html>
