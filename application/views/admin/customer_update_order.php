<?php 
require_once("header.php"); 





?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Master</a>
				</li>
				<li class="active">Price List </li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					Master
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						Account Management 
					</small>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs" id="myTab">
									<li class="active">
										<a data-toggle="tab" href="#list">
											<i class="purple ace-icon fa fa-list bigger-120"></i>
											Update Order 
										</a>
									</li>

									<li class="hidden-480">
										<a data-toggle="" href="#" onclick="OrderModal('<?php echo base_url();?>index.php/admin/customer_orders/add_item/<?php echo $last_id+1; ?>');">
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											Add Item
											
										</a>
									</li>
								</ul>

								<!-- Tab Contents Starts --> 
								
								<div class="tab-content">
									
									<div id="list" class="tab-pane fade in active">
									<!-- NEW TABLE --> 
									
										<div class="row">
											<div class="col-xs-12">
												
												<div> 
										<form class="form-horizontal" id="order-form" method="post" action="<?php echo base_url();?>index.php/admin/customer_orders/update_order_final/<?php echo $last_id+1; ?>" >
										<div class="table-header" style="background:#6FB3E0!important;">
													Update Order Record
												</div> <br/>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="invoice_no"> Invoice No : </label>

											<div class="col-sm-4">
												<input type="text" name="invoice_no"  id="invoice_no" class="form-control" readonly value="<?php echo INVOICE_NAME . ($last_id+1); ?>" />
												<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $last_id+1; ?>" />
											</div>
											
											<label class="col-sm-2 control-label no-padding-right" for="join_date"> Order Date : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input class="form-control " name="order_date" id="order_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('j-m-Y',strtotime($Order_Date)); ?>" readonly />
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
										</div>
										
										<?php
															 
											foreach($userdata->result() as $userrow): 
			
											if($userrow->id==$Party_Name)
											{
												$Disp_Party_Name=$userrow->first_name." ".$userrow->last_name;
												$Address=$userrow->address1.", ".$userrow->city." - ". $userrow->zipcode;
												$CustCharge=$userrow->cust_charges; $cust_charge=unserialize($CustCharge); 
												 												
											}
											endforeach;															
										?>
														
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="party_name"> <a href="<?php echo base_url();?>/index.php/admin/customer_crud/do_update/<?php echo $Party_Name; ?>" target="_blank"> Customer Name (*) : </a> </label>

											<div class="col-sm-4">
												<input type="text" id="user_id" class="form-control" readonly value="<?php echo $Disp_Party_Name; ?>" />
											</div>
											
											<?php $color='red'; ?>
											
											<?php if($OrderStatus=='delivered') { $color='green'; } ?>
											
											<label class="col-sm-2 control-label no-padding-right" for="party_name"> Address : </label>

											<div class="col-sm-4">
												<input type="text" id="cust_add" class="form-control" readonly value="<?php echo $Address; ?>" />
											</div>
											
											
										</div>
																			
										<div>
										<table id="price-table" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
												
												<th class="center"> ID </th>
												<th> Short Code </th>
												<th class="hidden-480"> Service </th>
												<th > Cloth Type </th>
												<th> Qty </th>
												<th> Price </th>
												<th> Total </th>

												
												
												<th class="center" > 
													<a data-toggle="" href="#" onclick="OrderModal('<?php echo base_url();?>index.php/admin/customer_orders/add_item/<?php echo $last_id+1; ?>');">
														<i class="green ace-icon fa fa-plus bigger-120"></i>
														Add Item
														
													</a>
												
												</th>
												
												</tr>
											</thead>

											<tbody>
												<?php $TotalQty=0; $SubTotalAmt=0; $Sr=0; $GrandTotalAmt=0; $Minuscharges=0; $Pluscharges=0; 
												if($DiscAmt!=0) { $Minuscharges=-$DiscAmt; }
												?>
												<?php foreach ($order_temp as $ordertemprow): $Sr++; ?>
												<tr>
													
													<td class="center">
														<?php echo $Sr; ?>
													</td>
													
													<td>
													<?php $Short_Code=$ordertemprow->price_shortcode; ?>
													
													<?php foreach ($price_data->result() as $pricerow): 
														if($Short_Code==$pricerow->id)
														{
															echo $pricerow->short_code;
														}
														else
														{
															continue;
														}	
														?>
													
													</td>
													
													<td class="hidden-480"> 
														<?php
															 
															foreach($laundry_service->result() as $servicerow): 
							
															if($servicerow->id==$pricerow->service_id)
															{
																echo $servicerow->service_name;
																
															}
															endforeach;															
														?>
													</td> 
													
													<td > 
														<?php
															 
															foreach ($laundry_cloth->result() as $clothrow):
							
															if($clothrow->id==$pricerow->cloth_id)
															{
																echo $clothrow->cloth_type;
															}
															endforeach;															
														?>
													</td> 
													
													
													<td class="center"><?php echo $Qty=$ordertemprow->order_qty; 
													$TotalQty=$TotalQty+$Qty; ?> </td>
													
													<td> <?php echo $sys_curr ." ". sprintf('%0.2f',$pricerow->price); ?> </td> 
													
													<td class=""> 
														<?php 
														if($Short_Code==$pricerow->id)
														{
															$Price=$pricerow->price;
															echo $sys_curr ." ".$DispPrice=sprintf('%0.2f',$Price*$Qty);
															$SubTotalAmt=$SubTotalAmt+$DispPrice;
															
														}
													
													endforeach; ?>
													
													</td> 													
																													
													
													
													
													<td class="center" >
														<div class="hidden-sm hidden-xs action-buttons">
															
															<a class="red" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_item_order/<?php echo $ordertemprow->order_id; ?>/<?php echo $last_id+1; ?>');">
																<i class="ace-icon fa fa-trash-o bigger-130"></i>
															</a>
														</div>

														<div class="hidden-md hidden-lg">
															<div class="inline pos-rel">
																<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																	<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																</button>

																<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																	
																	
																	
																	<li>
																		<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_item_order/<?php echo $ordertemprow->order_id;?>/<?php echo $last_id+1; ?>');" class="tooltip-error" data-rel="tooltip" title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												
												<?php endforeach; ?>
												<tr style='background:#F0F0F0;'>
												<td> </td> <td> </td> <td class="hidden-480"> </td> 
												<td> <b> Total </b> </td> <td class="center"> <b> <?php echo $TotalQty; ?> </b> </td> <td > -  </td> <td> <b> <?php echo $sys_curr ." ".sprintf('%0.2f',$SubTotalAmt); ?> </b> </td> <td>  </td>
												<input type="hidden" name='totalpc' id='totalpc' value="<?php echo $TotalQty; ?>"><input type="hidden" name='totalamt' id='totalamt' value="<?php echo $SubTotalAmt; ?>">
												</tr>
											</tbody>
										</table>
										</div>
										
									
										<?php
											
											$action="Update";
										?>
										
										
										
										
										<div> <hr style='color: 1px solid blue;'> </div>										
											<div>	<!--
													<label class="col-sm-6 control-label no-padding-right" for="cheque_date">  </label>
													
													<div class="form-group">
													<label class="col-sm-2 control-label no-padding-right" for="dis_amt"> Discount (<?php echo $sys_curr; ?>) :
													</label>
													<div class="col-sm-4">
												
													<input type="text" name="dis_amt" id="dis_amt" class="form-control" value="<?php echo $DiscAmt; ?>" OnChange="TotalPayAmount();" />
												
													</div>		
											</div>	-->	
													<input type="hidden" name="dis_amt" id="dis_amt" value="0.00"> 
											<!-- Check Discount and Charges for Customers assigned -->
											
											<div class="form-group">
											
											<label class="col-sm-6 control-label no-padding-right" for="granttotal"> </label>

											
											<label class="col-sm-2 control-label no-padding-right" for="granttotal"> Discount (<?php echo $sys_curr; ?>) : </label>

											<div class="col-sm-4">
													
													<input type="text" name="disc_amt" id="disc_amt" class="form-control" value="<?php echo sprintf('%0.2f',($DiscAmt)); ?>" />
													
											
												
											</div>
										</div>
										
											<?php
											//var_dump($Discount);
											$this->db->order_by("transaction");
											$charge_list=$this->db->get('tax_charges');
											
											$discharge_temp=array();
											$i=0;
											foreach ($charge_list->result() as $chargerow):
												
												if(!empty($cust_charge)) 
												{	foreach ($cust_charge as $chargeId) :
													if($chargerow->charge_id==$chargeId) {
													?>
													<div>
													<label class="col-sm-6 control-label no-padding-right" for="cheque_date">  </label>
													
													<div class="form-group">
													<label class="col-sm-2 control-label no-padding-right" for="discount"> <?php echo$chargerow->charge_name; ?> 
													
													
													
													
													<!-- Percentage Section --> 
													
													<?php 
													
													if($chargerow->charge_type=="percentage") { echo "(".  $chargerow->charge_amt ."% )";
													?>
													
													 :  												
													</label>
													<div class="col-sm-4">
													<?php 
													
													/* Minus Transaction Amount Calculation */
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.2f",($SubTotalAmt*$chargerow->charge_amt/100)); $Minuscharges=$Minuscharges+$DispCal;  
													
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name ."(". $chargerow->charge_amt ."%)"; ?>
													
													<input type="text" name="disamt[]" id="disamt[]" class="form-control" value="<?php echo $DispCal; ?>" readonly />
													</div>
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
													
													<input type="text" name="disamt[]" id="disamt[]" class="form-control" value="<?php echo $PlusDispCal; ?>" readonly />
													</div>
													<?php  $discharge_temp[$i]['charge_amt'] =  $PlusDispCal; ?>
													
													<?php
													}		// plus if end 
													} 		// percentage if end
													?>		<!-- End Percentage Section -->
													
													
													
												<!-- Amount Section --> 
												
													<?php
													if($chargerow->charge_type=="amount") { echo "(". $sys_curr .")"; 
													?>
													
													:  												
													</label>
													<div class="col-sm-4">
													<?php 
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.2f", $chargerow->charge_amt); $Minuscharges=$Minuscharges+$DispCal; 
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name ."(". $chargerow->charge_amt ."%)"; ?>
													
													<input type="text" name="disamt[]" id="disamt[]" class="form-control" value="<?php echo $DispCal; ?>" readonly />
													</div>
													<?php  $discharge_temp[$i]['charge_amt'] =  $DispCal; ?>
													<?php
													}
													?>

													<?php if($chargerow->transaction==1) {  $PlusDispCal=0; $PlusDispCal=sprintf("%0.2f", $chargerow->charge_amt); $Pluscharges=$Pluscharges+$PlusDispCal;
													?>
													<?php  $discharge_temp[$i]['charge_name'] =  $chargerow->charge_name; ?>
														
													<input type="text" name="disamt[]" id="disamt[]" class="form-control" value="<?php echo $PlusDispCal; ?>" readonly />
													</div>
													<?php  $discharge_temp[$i]['charge_amt'] =  $PlusDispCal; ?>
													
													<?php
													}		// plus if end 
													}
													?> 
													<!-- End Amount Section -->
													
													
													
													</div>
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
												
											
										
									  <div class="form-group">
											
											<label class="col-sm-6 control-label no-padding-right" for="granttotal"> </label>

											
											<label class="col-sm-2 control-label no-padding-right" for="granttotal"> Grand Total (<?php echo $sys_curr; ?>)  : </label>

											<div class="col-sm-4">
													<?php 
													$grandtotal=$SubTotalAmt+$Minuscharges+$Pluscharges; 
													
													?>
													<input type="text" name="granttotal" id="granttotal" class="form-control" value="<?php echo sprintf('%0.2f',($grandtotal)); ?>" readonly />
													<input type='hidden' name='cust_charges' value='<?php echo $CustCharge;?>'>
													<input type='hidden' name='grandtotal' id='grandtotal' value='<?php echo $grandtotal;?>'>
													
											
												
											</div>
										</div>
										
									<div> <hr style='color: 1px solid blue;'> </div>										
										
										
										<div  class="form-group"  >
											<label class="col-sm-2 control-label no-padding-right" for="paidby"> Payment Status : </label>

											<div class="col-sm-4">
												
												<select class="form-control" name="paidby" id="paidby" >
													<option value="">-- Select --</option>
													<option value="notpaid" <?php if($AmtPaidBy=="notpaid") echo "selected"; ?> >Not Paid</option>
													<option value="paid" <?php if($AmtPaidBy=="paid") echo "selected"; ?> >Paid</option>
													<option value="error" <?php if($AmtPaidBy=="error") echo "selected"; ?> >Error</option>
													
												</select>
												
											</div>
											
											<label class="col-sm-2 control-label no-padding-right" for="cheque_date"> Payment Date : </label>

											<div class="col-sm-4">
												<div class="input-group">
												
												<input class="form-control date-picker" name="cheque_date" id="cheque_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $ChequeDate; ?>"  />
														<span class="input-group-addon">
															<i class="fa fa-calendar bigger-110"></i>
														</span>
												</div>
											</div>
											
										</div>
										
										<div  class="form-group"  >
											
											
											<label class="col-sm-2 control-label no-padding-right" for="order_status" style="color:<?php echo $color; ?>;" > Order Status : </label>

											<div class="col-sm-4">
												
												<select class="form-control" name="order_status" id="order_status" >
													
													<option value="urgent" <?php if($OrderStatus=="urgent") echo "selected"; ?> > Urgent </option>
													<option value="pending" <?php if($OrderStatus=="pending") echo "selected"; ?> > Pending </option>
													<option value="pickup" <?php if($OrderStatus=="pickup") echo "selected"; ?> > Pickup </option>
													<option value="delivered" <?php if($OrderStatus=="delivered") echo "selected"; ?> > Delivery </option>
													<option value="done" <?php if($OrderStatus=="done") echo "selected"; ?> > Done </option>
																								
												</select>
												
											</div>
											<label class="col-sm-2 control-label no-padding-right" for="remarks"> Remarks : </label>

											<div class="col-sm-4">
												
													<input type="text" name="remarks" id="remarks" class="form-control"   value="<?php echo $Remarks; ?>" required />
												
											</div>
											
											<?php
											if($RPC=="chkrec") {
											if(intval($TotalPaid)!=intval($grandtotal)) echo '<script> alert("something went wrong please click on update button!!!"); </script>';
											}
											?>
										
										</div>
										
										<div  class="form-group"  >
											
											
											<label class="col-sm-2 control-label no-padding-right" for="pickup_date"> Pickup Date : </label>

											<div class="col-sm-4">
												<div class="input-group">
												
												<input class="form-control date-picker" name="pickup_date" id="pickup_date" type="text" data-date-format="dd-mm-yyyy" value=""  />
														<span class="input-group-addon">
															<i class="fa fa-calendar bigger-110"></i>
														</span>
												</div>
											</div>
											
											<label class="col-sm-2 control-label no-padding-right" for="delivery_date"> Delivery Date : </label>

											<div class="col-sm-4">
												<div class="input-group">
												
												<input class="form-control date-picker" name="delivery_date" id="delivery_date" type="text" data-date-format="dd-mm-yyyy" value=""  />
														<span class="input-group-addon">
															<i class="fa fa-calendar bigger-110"></i>
														</span>
												</div>
											</div>
										
										</div>
										
										
										
										
																				
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php echo $action; ?> &nbsp;&nbsp;&nbsp;">
														
														&nbsp; &nbsp; &nbsp;														
														&nbsp; &nbsp; &nbsp;
													<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
														
													
												</div>
											</div>
											<span style="color:red; font-size:11px;"> Note: If you want changes discount & charge click on Customer Name(*) hyper link </span>
										
										</form>
										
										</div>
									
										</div>
									</div>

						
						
									</div>

									
									</div>	
								<!-- Tab Contents Ends --> 
										
							
						</div><!-- /.col -->

						
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				</div>
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						

<?php require_once("modal.php"); ?>
<?php require_once("footer.php"); ?>

		<!-- Order Model -->
		
	 <script type="text/javascript">
		 
		 function TotalPayAmount()
		 {	//alert('hi');
			var item_granttotal=parseFloat(document.getElementById("grandtotal").value);
			var item_discount=parseFloat(document.getElementById("dis_amt").value);
			//alert(item_discount);
			if (isNaN(item_discount)) {
			item_discount="0.00"; 
			document.getElementById("dis_amt").value="0.00"; 
			document.getElementById("granttotal").value=item_granttotal.toFixed(2);
			document.getElementById("remarks").focus(); 
			}
			//Grand Total Value
			  
			var item_grand_amt=(item_granttotal-item_discount);
			document.getElementById("dis_amt").value=item_discount.toFixed(2);
			document.getElementById("granttotal").value=item_grand_amt.toFixed(2);
			document.getElementById("remarks").focus();
		
		 }	 
		 
				  
	function OrderModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_order .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_order').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_order .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_order">
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

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
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
		<script src="<?php echo base_url();?>assets/js/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/daterangepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			
			jQuery(function($) {
				//initiate dataTables plugin
				
				$("#disc_amt").change(function() 
				{	location.reload();
					var invoiceid = $("#invoice_id").val();
					var disamt = $("#disc_amt").val();
					//alert(cust_id);
					//alert(invoiceid);
					$.post("<?php echo base_url(); ?>index.php/admin/customer_orders/update_disc", {"invoice_id": invoiceid, "discount_amt" : disamt });
					
					
				});
				
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
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
				
				
				
				$('#user-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
						
						service_name: {
							required: true
						},
						
						cloth_name: {
							required: true
						},
						
						short_code: {
							required: true
							
						},
						
						price: {
							required: true,
							price: 'required'
						}
											
					},
			
					messages: {
						first_name: {
							required: "Please select service.",
							service_name: "Please select service."
						},
						price: "Please enter amount."
						
						
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
				
				//datepicker plugin
				//link
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				
			
				
				if(!ace.vars['old_ie']) $('#pickup_date_demo').datetimepicker({
				 format: 'DD-MM-YYYY h:mm A',//use this option to display seconds
				 icons: {
					time: 'fa fa-clock-o',
					date: 'fa fa-calendar',
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down',
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right',
					today: 'fa fa-arrows ',
					clear: 'fa fa-trash',
					close: 'fa fa-times'
				 }
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				if(!ace.vars['old_ie']) $('#delivery_date_demo').datetimepicker({
				 format: 'DD-MM-YYYY h:mm A',//use this option to display seconds
				 icons: {
					time: 'fa fa-clock-o',
					date: 'fa fa-calendar',
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down',
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right',
					today: 'fa fa-arrows ',
					clear: 'fa fa-trash',
					close: 'fa fa-times'
				 }
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				
				
				
			
			})
		</script>
		
	</body>
</html>