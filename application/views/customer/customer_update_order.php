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

			<div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
						<i class="ace-icon fa fa-search nav-search-icon"></i>
					</span>
				</form>
			</div><!-- /.nav-search -->
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
										<a data-toggle="" href="#" onclick="OrderModal('<?php echo base_url();?>index.php/customer/customer_orders/add_item/<?php echo $last_id+1; ?>');">
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
										<form class="form-horizontal" id="order-form" method="post" action="<?php echo base_url();?>index.php/customer/customer_orders/update_order_final/<?php echo $last_id+1; ?>" >
										<div class="table-header" style="background:#6FB3E0!important;">
													Update Order Record
												</div> <br/>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="invoice_no"> Invoice No : </label>

											<div class="col-sm-4">
												<input type="text" name="invoice_no"  id="invoice_no" class="form-control" readonly value="<?php echo "SC0" . ($last_id+1); ?>" />
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
											}
											endforeach;															
										?>
														
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="party_name"> Party Name : </label>

											<div class="col-sm-4">
												<input type="text" id="user_id" class="form-control" readonly value="<?php echo $Disp_Party_Name; ?>" />
											</div>
											
											<!-- 
											<label class="col-sm-2 control-label no-padding-right" for="delivery_date"> Delivery Date : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input class="form-control date-picker" name="delivery_date" id="delivery_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" />
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div> -->
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
													<a data-toggle="" href="#" onclick="OrderModal('<?php echo base_url();?>index.php/customer/customer_orders/add_item/<?php echo $last_id+1; ?>');">
														<i class="green ace-icon fa fa-plus bigger-120"></i>
														Add Item
														
													</a>
												
												</th>
												
												</tr>
											</thead>

											<tbody>
												<?php $TotalQty=0; $TotalAmt=0; $Sr=0; ?>
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
													
													
													<td class=""><?php echo $Qty=$ordertemprow->order_qty; 
													$TotalQty=$TotalQty+$Qty; ?> </td>
													
													<td> <?php echo $sys_curr ." ". sprintf('%0.2f',$pricerow->price); ?> </td> 
													
													<td class=""> 
														<?php 
														if($Short_Code==$pricerow->id)
														{
															$Price=$pricerow->price;
															echo $sys_curr ." ".$DispPrice=sprintf('%0.2f',$Price*$Qty);
															$TotalAmt=$TotalAmt+$DispPrice;
															
														}
													
													endforeach; ?>
													
													</td> 													
																													
																										
													
													<td class="center" >
														<div class="hidden-sm hidden-xs action-buttons">
															
															<a class="red" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/customer/customer_orders/delete_item_order/<?php echo $ordertemprow->order_id; ?>/<?php echo $last_id+1; ?>');">
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
																		<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/customer/customer_orders/delete_item_order/<?php echo $ordertemprow->order_id;?>/<?php echo $last_id+1; ?>');" class="tooltip-error" data-rel="tooltip" title="Delete">
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

											</tbody>
										</table>
										</div>
										
										<!-- Update Process Here -->
										<?php
											//if($TotalAmt==0) { $action="Save"; } else {  $action="Update"; }
											$action="Update";
										?>
										
										<!---------------->
										
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="totalpc"> Total PCs : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="totalpc" id="totalpc" class="form-control" value="<?php echo $TotalQty; ?>" readonly  />
												</div>
											</div>
											
											<label class="col-sm-2 control-label no-padding-right" for="totalamt"> Total Amt : </label>

											<div class="col-sm-4">
												<div class="input-group">
												<input type="text" name="totalamt" id="totalamt" class="form-control" value="<?php echo $TotalAmt; ?>.00" readonly  />
												</div>
											</div>
											
											
										
											
										</div>
										
										<div class="form-group">
											
											<label class="col-sm-2 control-label no-padding-right" for="discount">Discount(<?php echo $Discount;?>% ) :  </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="disamt" id="disamt" class="form-control" value="<?php echo $DisAmt=$TotalAmt*$Discount/100; ?>" readonly />
												</div>
											</div>
											
											
											<label class="col-sm-2 control-label no-padding-right" for="servicetax"> Service Tax(<?php echo $ServiceTax;?>%) : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="servamt" id="servamt" class="form-control" value="<?php echo $SerAmt=($TotalAmt-$Discount)*$ServiceTax/100; ?>" readonly />
												</div>
											</div>
										</div> 
										
																			
										<div> <hr style='color: 1px solid blue;'> </div>	
										
										<div class="form-group">
											
											
											<label class="col-sm-2 control-label no-padding-right" for="paidby"> Amt Paid By : </label>

											<div class="col-sm-4">
												
												<select class="form-control" name="paidby" id="paidby">
													<option value="">-- Select --</option>
													<!--<option value="bycash" <?php if($AmtPaidBy=='bycash') { echo "selected"; } ?> >By Cash</option>
													<option value="bycheque" <?php if($AmtPaidBy=='bycheque') { echo "selected"; } ?>>By Cheque</option> -->
													<option value="online" <?php if($AmtPaidBy=='online') { echo "selected"; } ?>>By Online</option>
													
												</select>
												
											</div>
											
											
											<label class="col-sm-2 control-label no-padding-right" for="granttotal"> Grand Total  : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="granttotal" id="granttotal" class="form-control" value="<?php echo ($TotalAmt-$DisAmt)+$SerAmt; ?>" readonly />
												</div>
											</div>
										</div>
										
										
										<!-- <div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="cheque_no"> Cheque No : </label>

											<div class="col-sm-4">
												
													<input type="text" name="cheque_no" id="cheque_no" class="form-control"   value="<?php echo $ChequeNo;?>" />
												
											</div>
											
											<label class="col-sm-2 control-label no-padding-right" for="cheque_date"> Cheque Date : </label>

											<div class="col-sm-3">
												<div class="input-group">
												<input class="form-control date-picker" name="cheque_date" id="cheque_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $ChequeDate;?>" />
														<span class="input-group-addon">
															<i class="fa fa-calendar bigger-110"></i>
														</span>
												</div>
											</div> 
										
										</div> -->
										
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="remarks"> Remarks : </label>

											<div class="col-sm-4">
												<input type="text" name="remarks" id="remarks" class="form-control" value="<?php echo $Remarks; ?>" required />
											</div>
											
											<?php if($OrderStatus=='pending') { $color='red'; } ?>
											
											<?php if($OrderStatus=='delivered') { $color='green'; } ?>
											
											<label class="col-sm-2 control-label no-padding-right <?php echo $color; ?> " for="order_staus"><b> Order Status : </b></label>

											<div class="col-sm-3">
												
												<select class="form-control" name="order_status" id="order_status" disabled>
													
													<option value="pending" <?php if($OrderStatus=='pending') { echo "selected"; } ?> >Pending </option>
													<option value="delivered" <?php if($OrderStatus=='delivered') { echo "selected"; } ?>>Delivered </option>
																								
												</select>
												
											</div>
											
										</div>
										
										
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<input class="btn btn-info" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php echo $action; ?> &nbsp;&nbsp;&nbsp;">
														
														&nbsp; &nbsp; &nbsp;														
														&nbsp; &nbsp; &nbsp;
													<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
														
													
												</div>
											</div>
											<!-- <span style="color:#C70039; font-size:11px;"> Note: Click on % and Add Values (Discount/Ser Tax) </span> -->
										
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
		 {	
			var item_totalamt=parseFloat(document.getElementById("totalamt").value);
			var item_discount=parseFloat(document.getElementById("discount").value);
			var item_servtax=parseFloat(document.getElementById("servicetax").value);
			
			  // Discount Value
			  var item_dis_amt=(item_totalamt*item_discount/100);
			  document.getElementById("disamt").value=item_dis_amt.toFixed(2);
			  
				//Service Tax Value
			  var item_sertax_amt=((item_totalamt-item_discount)*item_servtax/100);
			  document.getElementById("servamt").value=item_sertax_amt.toFixed(2);
			  
			  //Grand Total Value
			  
			   var item_grand_amt=((item_totalamt-item_dis_amt)+ item_sertax_amt);
			   document.getElementById("granttotal").value=item_grand_amt.toFixed(2);
			  
				
			
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
			
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			
			jQuery(function($) {
				//initiate dataTables plugin
				
				
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
				
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				
				
			
			})
		</script>
		
	</body>
</html>