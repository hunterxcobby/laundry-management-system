<?php 
include('system_currency.php');
require("header.php");

?>
	
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"><?php echo lang('Home'); ?> </a>
				</li>
				<li class="active"><?php echo lang('Dashboard'); ?> </li> <?php echo "(" . date('j-M-Y h:i A') .")"; ?>
			</ul><!-- /.breadcrumb -->
			
			<a href="<?php echo $helppath;?>" style="float:right;" title="<?php echo lang('Help'); ?>" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>
		<div class="page-content">
			<div class="page-header">
				<h1>
					<?php echo lang('Desktop'); ?>  
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Laundry Management'); ?>  
					</small>
				</h1>
			</div><!-- /.page-header -->

			<?php
			$today=date('Y-m-d'); 
			$TodayOrder=$this->db->query("SELECT * FROM customer_order WHERE order_date='".$today."'");
									
			$TotalPedingOrder=$this->db->query("SELECT * FROM customer_order WHERE order_status!='delivered'");
			
			$TotalDeliveryOrder=$this->db->query("SELECT * FROM customer_order WHERE order_status='delivered'");
			
			
			
			$TotalEmployee=$this->db->query("SELECT * FROM employee");
			
			$TotalCustomer=$this->db->query("SELECT * FROM users");

			if ($this->session->userdata('user_from')=="store")
			{
				$storeId=$this->session->userdata('store_id');
				$TodayOrder=$this->db->query("SELECT * FROM customer_order WHERE laundry_store=".$storeId." AND order_date='".$today."'");
									
				$TotalPedingOrder=$this->db->query("SELECT * FROM customer_order WHERE laundry_store=".$storeId." AND laundry_store=".$storeId." AND order_status!='delivered'");
			
				$TotalDeliveryOrder=$this->db->query("SELECT * FROM customer_order WHERE laundry_store=".$storeId." AND order_status='delivered'");
			
			
			
				$TotalEmployee=$this->db->query("SELECT * FROM employee");
			
				$TotalCustomer=$this->db->query("SELECT * FROM users WHERE laundry_store=".$storeId." ");
			}	
			
			
			//$penquery=$this->db->query("SELECT * FROM customer_order WHERE order_status='pending' AND customer_id=".$userrow->id );
			//$delquery=$this->db->query("SELECT * FROM customer_order WHERE order_status='delivered' AND customer_id=".$userrow->id );
			?>
							
			
			<div class="row">
				<div class="col-xs-6 col-sm-3 pricing-box">
					<div class="widget-box widget-color-blue">
						<div class="widget-header">
							<a href="#" class="btn btn-block btn-primary">
								<i class="ace-icon fa fa-truck bigger-110"></i>
								
								<span><?php echo lang('Today Order'); ?>   </span>
							</a>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								
								<div class="price">
									<span class='blue'> <?php printf("%02d",$TodayOrder->num_rows()); ?> </span>
								</div>
							</div>

							<div>
								
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-6 col-sm-3 pricing-box">
					<div class="widget-box widget-color-red">
						<div class="widget-header">
							<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list/pending" class="btn btn-block btn-danger">
								<i class="ace-icon fa fa-list bigger-110"></i>
								<span><?php echo lang('Total Pending'); ?>   </span>
							</a>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								
								<div class="price">
									<span class='red'> <?php printf("%02d",$TotalPedingOrder->num_rows()); ?> </span>
									
								</div>
							</div>

							<div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-3 pricing-box">
					<div class="widget-box widget-color-yellow">
						<div class="widget-header">
							<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list/delivered" class="btn btn-block btn-green">
									<i class="ace-icon fa fa-briefcase bigger-110"></i>
									<span><?php echo lang('Total Delivered'); ?>    </span>
								</a>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								
								<div class="price">
									<span class='orange'> <?php printf("%02d",$TotalDeliveryOrder->num_rows()); ?> </span>
									
								</div>
							</div>

							<div>
								
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="col-xs-6 col-sm-3 pricing-box">
					<div class="widget-box widget-color-green">
						<div class="widget-header">
							<a href="<?php echo base_url();?>index.php/admin/customers" class="btn btn-block btn-success">
									<i class="ace-icon fa fa-group bigger-110"></i>
									<span><?php echo lang('Total Customers'); ?>   </span>
								</a>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								
								<div class="price">
									<span class='green'> <?php printf("%02d",$TotalCustomer->num_rows()); ?> </span>
									
								</div>
							</div>

							<div>
								
							</div>
						</div>
					</div>

				</div><!-- /.col -->
			</div><!-- /.row -->
			
			<div class="hr hr-dotted"></div>   
			<div class="page-header"> <!-- search order -->
				 <input class="search" type="text" name="search_invoice" id="search_invoice" placeholder="Search Invoice, Orders etc." autofocus> 
				
			</div><!-- / end search order -->

			<?php
			$this->db->select('*');
			$this->db->from('barcode_data');
			$this->db->join('customer_order','barcode_data.invoice_no=customer_order.invoice_no');
			$this->db->order_by('bar_id','asc');
			$resultBarCode=$this->db->get()->result();
			// print_r($result);
			$TotalRec=count($resultBarCode);
			if(count($resultBarCode)>0)
			{	
			?>

			<div class="row">
			 <div class="col-sm-12">
				<div class="widget-box widget-color-red">
					<div class="widget-header">
						<h5 class="widget-title white"> <strong> Invoice Number Search Data </strong> </h5>
					</div>

					<div class="widget-body">
						
						<div class="widget-main no-padding">
							<form name="barcode_form" action="<?=base_url()?>index.php/admin/update_barcode_all" method="post">
							<table class="table table-striped table-bordered table-hover">
								<thead class="thin-border-bottom">
									<tr>
										<th> InvoiceNo# </th>
										<th> Customer Name </th>
										<th> Bill Amount </th>
										<th> Payment </th>
										<th> Order Status </th>
										<th> Driver/Rider </th>
										<th> Action </th>
									</tr>
								</thead>

								<tbody>
								<?php
								foreach($resultBarCode as $barRow) :
								{	$OrderStatusBy=$barRow->order_status;
									echo '<tr>';
									echo '<td>'.$barRow->invoice_no.'</td>';
									echo '<td>'.$barRow->customer_name.'</td>';
									echo '<td>'.$barRow->total_paid.'</td>';
									echo '<td>'.$barRow->amt_paidby.'</td>';
									// echo '<td>'.$barRow->order_status.'</td>';
								?>
									<td>	
										<select class="form-control" id="order_status" name="order_status[]" style="height:30px;font-size:12px;width:150px;" required>
													
										<option value="new_order" <?php if($OrderStatusBy=="new_order") echo "selected"; ?> > <?php echo lang('New Order'); ?> </option>
										<option value="pickup" <?php if($OrderStatusBy=="pickup") echo "selected"; ?> > Pickup </option>
										<option value="processing" <?php if($OrderStatusBy=="processing") echo "selected"; ?> > Processing </option>
										<option value="ready_for_delivery" <?php if($OrderStatusBy=="ready_for_delivery") echo "selected"; ?> > Ready for Delivery </option>
										<option value="out_for_delivery" <?php if($OrderStatusBy=="out_for_delivery") echo "selected"; ?> > Out for Delivery </option>
										 <option value="delivered" <?php if($OrderStatusBy=="delivered") echo "selected"; ?> > Delivered </option>
										 <option value="cancelled" <?php if($OrderStatusBy=="cancelled") echo "selected"; ?> > Cancelled </option>
																	
										</select>
									</td>
									<td>	
										<select class="form-control" style="height:30px;font-size:11px;" id="driver[]" name="driver[]" required >
											<?php 
											$employeedata = $this->db->get_where('employee', array('emp_role'=>'enable'));
											foreach($employeedata->result() as $emprow) :
											
											echo "<option value='".$emprow->emp_id."' >" . $emprow->first_name ." " . $emprow->last_name ."</option>";
											
											endforeach; 
											?>
										</select>
									</td>	
									
									<td><a href="#" onclick="confirm_modal('<?=base_url()?>index.php/admin/barcode_delete/<?php echo $barRow->bar_id;?>');" class="red"> <i class="ace-icon fa fa-minus-square red"></i> Delete </a> </td>
									</tr>
									<input type="hidden" name="invoice_no[]" value="<?php echo $barRow->invoice_no; ?>">
								<?php
									// echo '<tr>';
								}
								endforeach;	
								

								?>	
								</tbody>
							</table>
							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Update'); ?>  <?php echo lang('ALL'); ?>   &nbsp;&nbsp;">
										
										&nbsp; &nbsp; &nbsp;														
										&nbsp; &nbsp; &nbsp;
									<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
										
									
								</div>
							</div>
							<input type="hidden" name="no_of_rec" value="<?=$TotalRec?>" >
							
						 </form>

						</div> <!-- main widget -->
					</div>
				</div> <!-- widget box -->
			 </div> <!-- Col -->							
			</div> <!-- end row -->	

			<div class="space-6"></div>
			<?php
			}
			?>

			<div id="invoice_result"></div>

			<div class="hr hr-dotted"></div>   
			<div class="page-header"> <!-- search order -->
				 <input class="search" type="text" name="search_text" id="search_text" placeholder="Customer Name, Order, Barcode etc.."> 
				
			</div><!-- / end search order -->

			<div id="result"></div>	
			
			
			<div class="row">										
				<div class="col-sm-12">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5 class="widget-title">
								<i class="ace-icon fa fa-truck"></i>
								<?php echo lang('Today_Pickup'); ?>  ( <?php echo date('d-m-Y',strtotime($today)); ?> )
							</h5>

							</div>

						<div class="widget-body">
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="center hidden-480">
											<label class="pos-rel">
												<input type="checkbox" class="ace" />
												<span class="lbl"></span>
											</label>
										</th>
										<th> <?php echo lang('Invoice'); ?> </th>
										<th class="hidden-480" style="width:150px;"><?php echo lang('Laundry Store'); ?>  </th>
										<th><?php echo lang('Customer Name'); ?>  </th>
										<th class="hidden-480"> <?php echo lang('Pickup Date'); ?>   </th>
										<th class="hidden-480"><?php echo lang('Address'); ?>  </th>
										<th><?php echo lang('Order Status'); ?>  </th>
										<th> <?php echo lang('Qty/Kg'); ?>  </th>
										<!--
										<th style="text-align:right;">Amount </th>
										<th class="hidden-480">Payment </th> -->
										<th class="hidden-480"></th>
									</tr>
								</thead>

								<tbody>
									<?php 
									$this->db->order_by("auto_id","desc");
									$invoiceorder=$this->db->get('customer_order');
									$storeId=$this->session->userdata('store_id');
									if($storeId!=0) $invoiceorder = $this->db->query("SELECT * FROM `customer_order`  WHERE `laundry_store` =  $storeId OR `laundry_store`=0 ORDER BY auto_id desc");

									foreach ($invoiceorder->result() as $invoicerow):
									
									if($today==$invoicerow->pickup_date)
									{	
									
									?>
									<tr>
										<td class="center hidden-480">
											<label class="pos-rel">
												<input type="checkbox" class="ace" />
												<span class="lbl"></span>
											</label>
										</td>

										<td>
											<?php
											if($invoicerow->total_qty==0)
											{
											?>	
											<a href="<?php echo base_url();?>index.php/pos/update/<?php echo $invoicerow->auto_id;?>/chkrec"> <?php echo $invoiceNo=$invoicerow->invoice_no; ?> </a>
											<?php
											}
											else
											{
												echo $invoiceNo=$invoicerow->invoice_no;
											}	
											?>
										</td>
										<td class="hidden-480">
											<?php //echo $invoicerow->laundry_store; ?>
											<?php $StoreNm=$invoicerow->laundry_store;
											if($StoreNm!=0) echo $this->db->get_where('stores' , array('id' =>$StoreNm))->row()->store_name;  ?>
										</td>
										
										<?php $colr='red';
										if($invoicerow->order_status=='done') { $colr='green'; } 
										if($invoicerow->order_status=='express') { $colr='#8E44AD'; } 
										?>
										<td style='color:<?php echo $colr; ?>'>
										<?php 
											foreach($userdata->result() as $userrow): 

											if($userrow->id==$invoicerow->customer_id)
											{
												$Disp_Party_Name=$userrow->first_name." ".$userrow->last_name;
												$Address = $userrow->address1." ".$userrow->address2." ".$userrow->city." ".$userrow->state." - ".$userrow->zipcode ;
												$Contact = $userrow->mobile;
											}
											endforeach;	
											
										echo $Disp_Party_Name ."<br/>#" . $Contact; 
										?> 
										</td>
										
										<td class="">  
										<?php 
										
										if(date('d-m-Y',strtotime($invoicerow->pickup_date))!='01-01-1970')
										{	echo date('d-m-Y',strtotime($invoicerow->pickup_date)); if($invoicerow->pickup_time!="") { echo " [".$invoicerow->pickup_time."]"; } }
										else 
										{	echo "&nbsp;";  }
										?>  </td>
										
										<td style="width:275px;" class="hidden-480"> <?php echo $Address; ?>  </td>
										<td class="hidden-480" style='color:<?php echo $colr; ?>' ><?php 
										if($invoicerow->order_status=="neworder") echo "New Order";
										else echo ucfirst($invoicerow->order_status);
										
											$cust_sel_services=$invoicerow->services;
																
											// $cust_sel_services=unserialize($invoicerow->services);
											
											// if($cust_sel_services!="") {
											// echo "<br/> <span style='font-size:9px;'> [ "; $Service="";														
											// foreach($cust_sel_services as $servicerow):
											
											// $Service.=strtoupper($servicerow)." / "; 
											// endforeach;
											// echo substr($Service, 0, -2). "] </span>";
											if($cust_sel_services!="" && $cust_sel_services!='none') {
												echo '<br/> <small> [' . $cust_sel_services . ']</small>';
										}
										else
										{	
											echo '<br/> <span style="font-size:10px;"> [';
											echo $this->db->get_where('order_temp' , array('order_invoice' =>$invoiceNo))->row()->order_service;
											echo "]</span>";
										}
										
										?>   </td>
									
										<td class="" align="center">
										<?php 
										if($invoicerow->total_paid==0) echo 'aprx '.$invoicerow->appx_order_qty;
										else echo $invoicerow->total_qty. ' '. $invoicerow->cloth_unit; 
										?> </td>
										<!--
										<td style="text-align:right;"><?php echo $sys_curr; ?> <?php echo $invoicerow->total_paid; ?> </td>
										<td>
										<?php
										if($invoicerow->amt_paidby=="notpaid") echo '<span style="color:red;"> Not Paid </span>';
										if($invoicerow->amt_paidby=="paid") echo '<span style="color:green;"> Paid </span>';
										if($invoicerow->amt_paidby=="error") echo '<span style="color:orange;"> Error </span>';
										  echo "</a> </td>";
										?>
										-->
										
										<td class="hidden-480">
											<?php	
											if (!empty($modelpermission)) 
												{  if (in_array("joborder", $modelpermission))  
													{
											?>		
											<div class="hidden-sm hidden-xs hidden-lg action-buttons">
												
												<a  class="tooltip-info" href="<?php echo base_url();?>index.php/admin/customer_orders/order_tags/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Barcode ">
													<span class="blue">
													<i class="ace-icon fa fa-barcode bigger-110"></i>
													</span>
												</a>  

												
												
												<?php if ($MasterAdmin!="") { ?> 
												<a class="tooltip-success" href="<?php echo base_url();?>index.php/pos/update/<?php echo $invoicerow->auto_id;?>/chkrec"  data-rel="tooltip" title="Edit">
													<span class="green">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
													</span>
												</a>
													<?php
													}
													
													?>
												
												<a  class="tooltip-warning" href="<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Mini Invoice " target="_blank">
													<span class="orange">
													<i class="ace-icon fa fa-file-text-o bigger-110"></i>
													</span>
												</a> 
												<!--
												<a  class="tooltip-info" href="<?php echo base_url();?>index.php/admin/invoicepdf/<?php echo $invoicerow->auto_id;?>" data-rel="tooltip" title="Invoice" target="_blank"	>
													<span class="blue">
													<i class="ace-icon fa fa-file bigger-110"></i>
													</span>
												</a>  
												-->
												
												<?php if ($MasterAdmin!="") { ?> 
												<a class="tooltip-error" href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_list" title="Delete">
													<span class="red">
													<i class="ace-icon fa fa-trash-o bigger-130"></i>
													</span>
												</a>
												<?php } ?>			
											</div>

											<div class="hidden-md hidden-lg hidden-sm">
												<div class="inline pos-rel">
													<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
													</button>

													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														
														<li>
															<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_order/<?php echo $invoicerow->auto_id;?>" class="tooltip-info" data-rel="tooltip" title="Invoice">
																<span class="blue">
																	<i class="ace-icon fa fa-file bigger-110"></i>
																</span>
															</a>
														</li> 
														<?php if ($MasterAdmin!=""){ ?> 
														<li>
															<a href="<?php echo base_url();?>index.php/admin/customer_orders/update_order/<?php echo $invoicerow->auto_id;?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																<span class="green">
																	<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																</span>
															</a>
														</li> 
														<?php } ?>
														
													</ul>
												</div>
											</div>
										<?php
											}
										}
										?>		
										</td>
									
									</tr>
									<?php 
									}
									endforeach; 
									?>		
								</tbody>
							</table>
						</div><!-- /.widget-body -->
					</div><!-- /.widget-box -->
				</div><!-- /.col -->
			</div><!-- /.row -->

				

			<div class="space-6"></div>

			<div class="row">	
				<div class="col-sm-12">
					<div class="widget-box widget-color-orange">
						<div class="widget-header">
							<h5 class="widget-title" style="color:white;font-size:16px;">
								<i class="ace-icon fa fa-map-marker"></i>
								Driver Live Location
							</h5>
							<div class="widget-toolbar">
								<a href="#" onClick="window.location.reload();">
									<i class="ace-icon fa fa-refresh"></i>
								</a>

													<!-- 	<a href="#" data-action="collapse">
															<i class="ace-icon fa fa-chevron-up"></i>
														</a> -->
							</div>
						</div>
						<div class="widget-body">
							<div class="widget-main no-padding">
								<table class="table table-bordered table-striped">
									<thead class="thin-border-bottom">
										<tr>
											<th class="hidden-480"> # </th>
											<th> Driver Name </th>
											<th> Contact </th>
											<th class="hidden-480"> Current Location </th>
											<th> Google Map </th>
											<th style="text-align:left;" > Date / Time </th>
											
										</tr>
									</thead>

									<tbody>
										<?php 
										$DriverTrackData=$this->db->get('driver_track')->result();
										$sr=1;
										foreach($DriverTrackData as $trackRow) {
											
											$contact=$this->db->get_where('employee',array('emp_id' => $trackRow->emp_id))->row()->mobile;
											$lat=$trackRow->emp_lat;
											$lng=$trackRow->emp_lng;

											echo "<tr>";	
											echo '<td class="hidden-480">' .$sr. '</td>';
											echo '<td>' .$trackRow->emp_name. '</td>';
											echo '<td>' .$contact. '</td>';
											echo '<td>' .$trackRow->location_address. '</td>';
											?>
											<td style='text-align: center;'><a href="#" onclick="showAjaxMapViewModel('<?php echo base_url();?>index.php/admin/map_view/<?=$lat?>/<?=$lng?>');"> <img src="<?=base_url()?>assets/marker.png" style="height:35px;width:35px;"> </a> </td>
											
											<?php
											echo '<td class="hidden-480">' .date('d-M-Y  h:iA',strtotime($trackRow->location_date)). '</td>';
											echo "</tr>";
											$sr++;
											
										}
										?>
									</tbody>
								</table>
							</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->
					</div>		
				</div>	
			</div>		

			<div class="hr hr32 hr-dotted"></div>  <!-- top csut row add --> 	

			<div class="row">	

				<div class="col-sm-6">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5 class="widget-title">
								<i class="ace-icon fa fa-users"></i>
								Top Customers
							</h5>

							<!-- <div class="widget-toolbar no-border">
								<div class="inline dropdown-hover">
									<button class="btn btn-minier btn-primary">
										This Week
										<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
										<li class="active">
											<a href="#" class="blue">
												<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
												This Week
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												Last Week
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												This Month
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												Last Month
											</a>
										</li>
									</ul>
								</div>
							</div> -->
						</div>


						<?php
						$TopCustomers=$this->db->query("SELECT *, sum(total_paid) as top_total FROM customer_order GROUP BY customer_id ORDER BY top_total DESC LIMIT 10")->result();

						?>



						<div class="widget-body">
							<div class="widget-main no-padding">
								<table class="table table-bordered table-striped">
									<thead class="thin-border-bottom">
										<tr>
											<th class="hidden-480"> # </th>
											<th> Name </th>
											<th> Contact </th>
											<th class="hidden-480"> Email </th>
											<th style="text-align:right;" > Total Amount </th>
											
										</tr>
									</thead>

									<tbody>
										<?php 
										$sr=1;
										foreach($TopCustomers as $toprow) {
											$custId=$toprow->customer_id;
											$chkCustNameOrderTemp=$this->db->get_where('users' , array('id' =>$custId))->result();
											if(count($chkCustNameOrderTemp)>0)
											{	
											$custName=$this->db->get_where('users' , array('id' =>$custId))->row()->first_name;
											$custName.=" ";
											$custName.=$this->db->get_where('users' , array('id' =>$custId))->row()->last_name;
											$custContact=$this->db->get_where('users' , array('id' =>$custId))->row()->mobile;
											$custEmail=$this->db->get_where('users' , array('id' =>$custId))->row()->email_id;
											echo "<tr>";	
											echo '<td class="hidden-480">' .$sr. '</td>';
											echo '<td>' .$custName. '</td>';
											echo '<td>' .$custContact. '</td>';
											echo '<td class="hidden-480">' .$custEmail. '</td>';
											echo '<td style="text-align:right;">' .$sys_curr.' '.$toprow->top_total. '</td>';
											echo "</tr>";
											$sr++;
											}
										}
										?>
									</tbody>
								</table>
							</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->
						
					</div><!-- /.widget-box -->
				</div><!-- /.col -->

				<div class="col-sm-6">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5 class="widget-title text-success">
								<i class="ace-icon fa fa-signal	"></i>
								Top Orders
							</h5>

							<!-- <div class="widget-toolbar no-border">
								<div class="inline dropdown-hover">
									<button class="btn btn-minier btn-success">
										This Week
										<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
										<li class="active">
											<a href="#" class="blue">
												<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
												This Week
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												Last Week
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												This Month
											</a>
										</li>

										<li>
											<a href="#">
												<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
												Last Month
											</a>
										</li>
									</ul>
								</div>
							</div> -->
						</div>

						<?php
						$TopOrders=$this->db->query("SELECT *, count(invoice_no) as top_orders FROM customer_order GROUP BY customer_id ORDER BY top_orders DESC LIMIT 10")->result();

						$totalorders=$this->db->query("SELECT * FROM customer_order")->result();
						$totalOrders=count($totalorders);

						?>


						<div class="widget-body">
							<div class="widget-main ">
								<div class="row">
										<div class="col-xs-8" style="padding-top:5px;">
										
										<?php 
										foreach($TopOrders as $orderrow)
											{	
												$custId=$orderrow->customer_id;
												$chkCustNameOrderTemp=$this->db->get_where('users' , array('id' =>$custId))->result();
												if(count($chkCustNameOrderTemp)>0)
												{

												$custName=$this->db->get_where('users' , array('id' =>$custId))->row()->first_name;
												$custName.=" ";
												$custName.=$this->db->get_where('users' , array('id' =>$custId))->row()->last_name;
												$custContact=$this->db->get_where('users' , array('id' =>$custId))->row()->mobile;
												$custEmail=$this->db->get_where('users' , array('id' =>$custId))->row()->email_id;
												$width=($orderrow->top_orders/$totalOrders)*100;
												$width=intval($width);
												?>
												<tr> <td> <div class="progress pos-rel progress-striped padding-0" title="<?php echo $custName; ?> [ Orders - <?php echo $orderrow->top_orders; ?> / <?php echo $totalOrders; ?> ]" data-percent="<?php echo $width; ?>.0% " >
														<div class="progress-bar progress-bar-success padding-0" style="width:<?php echo $width; ?>%"> </div>
												</div> </td> </tr>
												<?php

												}	
											}
										?> 
										
										</div><!-- /.col xs-8-->

										<div class="col-xs-4 center">
										<table class="table table-borderless" >
											

											<tbody>
										<?php 
										foreach($TopOrders as $orderrow)
											{	
												$custId=$orderrow->customer_id;
												$chkCustNameOrderTemp=$this->db->get_where('users' , array('id' =>$custId))->result();
												if(count($chkCustNameOrderTemp)>0)
												{

												$custName=$this->db->get_where('users' , array('id' =>$custId))->row()->first_name;
												//$custName.=" ";
												//$custName.=$this->db->get_where('users' , array('id' =>$custId))->row()->last_name;
												$custContact=$this->db->get_where('users' , array('id' =>$custId))->row()->mobile;
												$custEmail=$this->db->get_where('users' , array('id' =>$custId))->row()->email_id;
												$width=($orderrow->top_orders/$totalOrders)*100;
												$width=intval($width);
												?>
												
												<tr> <td> <div class="easy-pie-chart percentage" data-color="#D15B47">
													<span class="percent"><?php echo $custName; ?> [<?php echo $orderrow->top_orders; ?>/<?php echo $totalOrders; ?>] </span>
												</div>
												</td> </tr>
												
												<?php

												}	
											}
										?></tbody>
										</table>		
										</div> <!-- /.col xs-4 -->

											
										</div><!-- /.row -->
									
							</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->
						
					</div><!-- /.widget-box -->
				</div><!-- /.col -->

				
						
			</div><!-- /.row -->


			<div class="hr hr32 hr-dotted"></div>  <!-- top csut row add --> 

			<!-- PAGE CONTENT ENDS -->
			
		</div><!-- /.page-content -->
	</div> <!-- /.main-content inner -->
</div><!-- /.main-content -->
<?php require_once("modal.php"); ?>
<?php require_once("map_modal.php"); ?>
<?php require_once('footer.php'); ?>

<!-- <meta http-equiv="refresh" content="15"> -->
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
	
		<!-- basic scripts -->

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

	<!-- page specific plugin scripts -->
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf_font.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>

		<!--[if lte IE 8]>
		  <script src="<?php echo base_url();?>assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.easypiechart.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.sparkline.index.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.pie.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		

<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null, null, null, null, null, 
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"title" : "InvoiceList", 
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: ''
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})

			$(document).ready(function(){
				// load_data();
				// function load_data(query)
				// {	$.ajax({
				// 		url:"<?php echo base_url();?>index.php/admin/fetch",
				// 		method:"post",
				// 		data:{query:query},
				// 		success:function(data)
				// 		{	if(data) { $('#result').html(data); }
				// 			else { $('#result').html(''); }
				// 		}

				// 	});
				// }

				// search invoice data for drivers
				
				function load_barcode_data(query)
				{
					$.ajax({
						url:"<?php echo base_url();?>index.php/admin/fetch_barcode_data",
						method:"post",
						data:{query:query},
						success:function(data)
						{	// alert(data);
							if(data=='success') { window.location.reload(); }
							else { alert('Invalid Invoice!!! Try Again'); window.location.reload(); ('#search_invoice').focus(); }
						}

					});
				}
				
				$('#search_invoice').keypress(function(){
					if ( event.which == 13 ) {
     				event.preventDefault();
  					var search = $(this).val();
					// alert(search);
					if(search != '')
					{
						load_barcode_data(search);
					}
					else
					{	$('#invoice_result').html('');
						load_data();			
					}
				}	
				});

				// Search Customer Order Mobile etc.

				function load_data(query)
				{	$.ajax({
						url:"<?php echo base_url();?>index.php/admin/fetch",
						method:"post",
						data:{query:query},
						success:function(data)
						{	if(data) { $('#result').html(data); }
							else { $('#result').html(''); }
						}

					});
				}
				
				$('#search_text').keyup(function(){
					var search = $(this).val();
					//alert(search);
					if(search != '')
					{
						load_data(search);
					}
					else
					{	$('#result').html('');
						load_data();			
					}
				});


			});

		</script>
		
	</body>
</html>


			
			