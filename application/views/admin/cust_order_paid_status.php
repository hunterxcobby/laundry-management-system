
		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
			echo form_open('admin/customer_orders/modify_paid_status/'.$InvoiceId.'/'.$FromMenu.' ',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> Invoice No : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $InvoiceNo ;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Customer Name :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->last_name; ?>" disabled />
				</div>
			</div>

			<?php
			$storeTaxable=$this->db->get_where('stores' , array('id' =>$StoreId))->row()->store_taxable;
			if($storeTaxable=='yes')
			{
				$vatAmt=$grandtotal*5/100;
				$grandtotal=sprintf('%0.3f',$grandtotal+$vatAmt);
			}
			?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Order Amount :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?=$grandtotal?> [ <?=$pkgQty?> <?=$prodUnit?> ]" disabled />
				</div>
			</div>

			<?php
			if($OrderStatusBy!='delivered')
		  	{	
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Order Status : </label>

				<div class="col-sm-9">
					<select class="form-control" name="order_status" id="order_status" >
													
						<option value="new_order" <?php if($OrderStatusBy=="new_order") echo "selected"; ?> > <?php echo lang('New Order'); ?> </option>
						<option value="pickup" <?php if($OrderStatusBy=="pickup") echo "selected"; ?> > Pickup </option>
						<option value="processing" <?php if($OrderStatusBy=="processing") echo "selected"; ?> > Processing </option>
						<option value="ready_for_delivery" <?php if($OrderStatusBy=="ready_for_delivery") echo "selected"; ?> > Ready for Delivery </option>
						<option value="out_for_delivery" <?php if($OrderStatusBy=="out_for_delivery") echo "selected"; ?> > Out for Delivery </option>
					 <option value="delivered" <?php if($OrderStatusBy=="delivered") echo "selected"; ?> > Delivered </option>
					 <option value="cancelled" <?php if($OrderStatusBy=="cancelled") echo "selected"; ?> > Cancelled </option>
																	
					</select>
				</div>
			</div>
			<?php
			}
			else
			{
				echo '<div class="form-group"><label class="col-sm-3 control-label no-padding-right"> Order Status : </label> 
				<div class="col-sm-9"> <input type="text" name="order_status" class="form-control" readonly value="delivered"> </div> </div>';
			}	
			?>
			
			
			
			<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $CustId; ?>">
			<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $InvoiceNo; ?>">
			<input type="hidden" name="paidby" id="paidby" value="<?php echo $AmtPaidBy; ?>">
			<input type="hidden" name="grandtotal" id="grandtotal" value="<?php echo $grandtotal; ?>">
			
			<?php $MasterAdmin=$this->session->userdata('user_from'); 

		if ($MasterAdmin!="user") { 

			if($AmtPaidBy=='notpaid')
		  	{	
			?>
																
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Payment Status : </label>

				<div class="col-sm-9">
					<select class="form-control" name="paidby" id="payment_status" >
						<option value="notpaid" <?php if($AmtPaidBy=="notpaid") echo "selected"; ?> >Unpaid</option>
						<option value="bycash" <?php if($AmtPaidBy=="bycash") echo "selected"; ?> > <?php echo lang('Cash Payment'); ?> </option>
						<option value="bycard" <?php if($AmtPaidBy=="bycard") echo "selected"; ?> > Card Payment </option>
						<option value="byonline" <?php if($AmtPaidBy=="byonline") echo "selected"; ?> > Online Payment </option>
					
					</select>
				</div>
			</div>

			
			<div class="form-group" style="display: none;" id='pay_amount'>
				<label class="col-sm-3 control-label no-padding-right" for="amt_paid"> Payable Amount : </label>

				<div class="col-sm-9">
					<input type='text' class="form-control" name="amt_paid" id="amt_paid" value='' >
				</div>
			</div>

			<div class="form-group" style="display: none;" id='pay_date'>
				<label class="col-sm-3 control-label no-padding-right" for="paid_date"> Payment Date : </label>

				<div class="col-sm-9">
					<input type="text" name="paid_date" id="paid_date" class="form-control date-picker" value="" />
				</div>
			</div>


			<?php 
				}
			else
			{
				echo '<input type="hidden" name="paid_date" class="form-control" readonly value="'.$AmtPaidDate.'">';
			}	 // payment check
			}  // admin check
			?>
																
			
			
			
			<?php
			if($OrderStatusBy!='delivered' || $AmtPaidBy=='notpaid')
		  	{	
			?>
			<input type="hidden" name="order_from_menu" value="<?=$FromMenu?>"> 		
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Update &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			<?php
			}
			?>
			
			</form>
		</div>

		
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		
	<script type="text/javascript">
			jQuery(function($) {


				
				$("#payment_status").change(function(){
					var values = $(this).val();
					// alert(values);
					if(values!=='notpaid')
					{
						var gradTotal=$("#grandtotal").val();
						$("#pay_amount").css({display: "block"});
						$("#pay_date").css({display: "block"});
						$("#amt_paid").attr('required',true);
						$("#amt_paid").val(gradTotal);
						$("#paid_date").val('<?=date('d-m-Y')?>');
						$("#amt_paid").focus();
						
					}
					else
					{
						$("#pay_amount").css({display: "none"});
						$("#pay_date").css({display: "none"});
						$("#amt_paid").attr('required',false);
						$("#amt_paid").val(0);


					}	
				});

				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true,
					format: 'dd-mm-yyyy',
				})
			})
	</script>