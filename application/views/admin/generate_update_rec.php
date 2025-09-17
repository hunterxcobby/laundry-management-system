<?php require_once("header.php"); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Multi Record'); ?>   
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Record Management'); ?> 
					</small>
				</h1>
			</div><!-- /.page-header -->

		 <div class="row">
		  <div class="col-xs-12"> <!-- PAGE CONTENT BEGINS -->
		  <div class="clearfix"> </div>
		  	 <div class="tabbable">
				<!-- Tab Contents Starts --> 
				<div class="tab-content">
					<div id="list" class="tab-pane fade in active">
						<div class="row">
							<div class="col-xs-12">
				
				<div class="table-header" style="background:#69AA46!important;">
				<?php echo lang('Record Updation'); ?>  (<?php echo strtoupper($model); ?> Driver Assign) 
				</div> <br/>
		 <div class="row">
		  <div class="col-xs-12"> <!-- PAGE CONTENT BEGINS -->
		  <div class="clearfix"> </div>
								
	
	
	<!-- Customer Multi Order View --> 
	<?php
	if($model=='edit_order')
	{
	?>
	<div class="form-group hidden-480">
	<label class="col-sm-2 control-label no-padding-right" > <?php echo lang('Order'); ?>#  </label>
	<label class="col-sm-2 control-label no-padding-right" > <?php echo lang('Customer Name'); ?> </label>
	<label class="col-sm-2 control-label no-padding-right " > <?php echo lang('Order'); ?> <?php echo lang('Status'); ?> </label>
	<label class="col-sm-2 control-label no-padding-right">  <?php echo lang('Pickup'); ?>  </label>
	<label class="col-sm-2 control-label no-padding-right " > <?php echo lang('Delivery'); ?>  </label>
	
	<label class="col-sm-2 control-label no-padding-right" > <?php echo lang('Payment'); ?>  </label>
	
	

	</div>	
	<br/>
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cust_form','enctype' => 'multipart/form-data');
			echo form_open('admin/cust_multi_order_crud/update_all',$attributes); ?>
			
			<?php
			$total = count($order_id);
			for($i=0; $i<$total; $i++)  :
			$id = $order_id[$i];	
			$order_edit=$this->db->get_where('customer_order' , array('auto_id' => $id) )->result();
			
			foreach ($order_edit as $orderrow) :
			?>
			<div class="form-group">
				<input type="hidden" name="no_of_rec" value="<?php echo $total; ?>">
				<input type="hidden" name="order_id[]" value="<?php echo $orderrow->auto_id; ?>">
				
							
				<div class="col-sm-2">
					<input type="text" name="invoice[]" class="form-control" required  placeholder="First" value="<?php echo $orderrow->invoice_no;?>"  readonly />
				</div>
				<?php $first_name = $this->db->get_where('users' , array('id' =>$orderrow->customer_id))->row()->first_name; ?>
				<?php $last_name = $this->db->get_where('users' , array('id' =>$orderrow->customer_id))->row()->last_name; ?>
				<div class="col-sm-2">
					<input type="text" name="first_name[]" class="form-control" required  placeholder="First" value="<?php echo $first_name ."".$last_name; ?>" readonly />
				</div>
				
				<!--
				<div class="col-sm-2">
					<input type="text" name="order_date[]" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Telephone"  value="<?php echo date('d-m-Y',strtotime($orderrow->order_date));?>"/>
				</div>
				
				<div class="col-sm-2">
					<input type="text" name="due_date[]" id="delivery_date" class="form-control date-picker" data-date-format="dd-mm-yyyy"  placeholder="Due Date" 
					<?php if($orderrow->delivery_date!=0) { ?>
					
					value="<?php echo date('d-m-Y',strtotime($orderrow->delivery_date)); }
					else
					{
						echo "value=''";
					}	

					?>" />
					
				</div> -->
				
				<div class="col-sm-2 hidden-480">
				<?php $OrderStatus=$orderrow->order_status; ?>
				
				<select class="form-control" name="order_status[]" id="order_status" disabled >
													
					<option value="urgent" <?php if($OrderStatus=="urgent") echo "selected"; ?> > <?php echo lang('Urgent'); ?>  </option>
					<option value="neworder" <?php if($OrderStatus=="neworder") echo "selected"; ?> > <?php echo lang('New Order'); ?>  </option>
					<option value="pickup" <?php if($OrderStatus=="pickup") echo "selected"; ?> > <?php echo lang('Pickup'); ?>  </option>
					<option value="delivered" <?php if($OrderStatus=="delivered") echo "selected"; ?> > <?php echo lang('Delivery'); ?>  </option>
					<option value="done" <?php if($OrderStatus=="done") echo "selected"; ?> > <?php echo lang('Done'); ?>  </option>
																
				</select>
				
				<!--
					<input type="text" name="delivery_date[]" id="delivery_date" class="form-control date-picker" data-date-format="dd-mm-yyyy"  placeholder="Delivery Date" 
					<?php if($orderrow->delivery_date!=0) { ?>
					
					value="<?php echo date('d-m-Y',strtotime($orderrow->delivery_date)); }
					else
					{
						echo "value=''";
					}	

					?>" />
				-->	
					
				</div>
				
				
				<div class="col-sm-2">
				<?php $PickupBy=$orderrow->pickup_by; ?>
				
				<select class="form-control" name="pickup[]" id="order_status" >
					<option value='' selected> -- <?php echo lang('Pickup'); ?>  -- </option>					
					<?php 
					
					$employeedata = $this->db->get_where('employee', array('emp_role'=>'enable'));
					foreach($employeedata->result() as $emprow) :
					
					echo "<option value='".$emprow->emp_id."' >" . $emprow->first_name ." " . $emprow->last_name ."</option>";
					
					endforeach; 
					?>
																
				</select>
				</div>
				
				<div class="col-sm-2">
				<?php $DeliveryBy=$orderrow->delivery_by; ?>
				
				<select class="form-control" name="delivery[]" id="order_status" >
					<option value='' selected> -- <?php echo lang('Delivery'); ?>  -- </option>								
					<?php 
					
					$employeedata = $this->db->get_where('employee', array('emp_role'=>'enable'));
					foreach($employeedata->result() as $emprow) :
					
					echo "<option value='".$emprow->emp_id."' >" . $emprow->first_name ." " . $emprow->last_name ."</option>";
					
					endforeach; 
					?>
																
				</select>
				
				</div>
				
				
				
				
				<div class="col-sm-2 hidden-480">
				<?php $AmtPaidBy=$orderrow->amt_paidby; ?>
					<select class="form-control" name="paidby[]" id="paidby" disabled >
						<option value="notpaid" <?php if($AmtPaidBy=="notpaid") echo "selected"; ?> > <?php echo lang('Not Paid'); ?>  </option>
						<option value="bycash" <?php if($AmtPaidBy=="bycash") echo "selected"; ?> > <?php echo lang('Cash Payment'); ?>  </option>
						<option value="byonline" <?php if($AmtPaidBy=="byonline") echo "selected"; ?> ><?php echo lang('Online Payment'); ?> </option>
						
					</select>
				</div>
				
				
				
				
			</div>
			
			<?php
				endforeach;
			endfor;
			?>
						
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Update'); ?>  <?php echo lang('ALL'); ?>   &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			</form>
	</div>
	<?php
	}
	?>	<!-- END Customer Multi Order View -->
	


			</div>	<!-- PAGE CONTENT ENDS -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
	</div> <!-- /.main-content-inner -->
</div><!-- /.main-content -->

<?php require_once("footer.php"); ?>	

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

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
			<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/spinbox.min.js"></script>
		
		
		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
			
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