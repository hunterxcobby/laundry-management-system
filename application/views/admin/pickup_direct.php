	
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" /> -->
	<div class="form-group">
	 <div class="span7 col-sm-12">
		<div class="row-fluid">
			<form class="form-inline" id="new_cust_form" method="POST" action="<?=base_url()?>index.php/admin/pickup_new_cust">
				<label class="col-sm-3 control-label" for="cust_id" style="text-align:right;"> New Customer <span class='red'> * </span>  :  </label>
				<input type="text" class="input-small" name="first_name" placeholder="First Name" required />
				<input type="text" class="input-small" name="last_name" placeholder="Last Name" required />
				<input type="text" class="input-small" name="mobile" placeholder="Mobile" required />
				<input type="text" class="input" name="address1" placeholder="Address1" required />
				
				<button type="submit" id="new_cust" class="btn btn-info btn-small">
					Add
				</button>
			</form>
	 	</div>
	  </div>
	 </div> 
	<br/>
	<div class="hr dotted"></div>

	 

	<div class="">
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/admin/direct_pickup_order">
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cust_id"> Customer Name <span class='red'> * </span>  :  </label>

				<div class="col-sm-9">
					<select class="chosen-select" name="cust_id" id="cust_id" data-placeholder="<?php echo lang('Choose Customer'); ?>" required >
					<option value="" selected> </option>
					<?php
					foreach ($customerData->result() as $custrow)
					{
					$mobile=str_replace(' ', '', $custrow->mobile);

					$PartyName=$custrow->first_name." ".$custrow->last_name ."- ".$mobile;
					echo "<option value='$custrow->id'>". $PartyName ."</option>";
					}
					?>
					</select>	

				</div>
			</div>

			<div class="hr dotted"></div>
			

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="pickup_date"> Pickup Date  : </label>

				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control date-picker" name="pickup_date" id="pickup_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>

			
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="picktime"> Pickup Time : </label>

				<div class="col-sm-9">
					<select class="form-control" name="picktime" id="picktime" required>
						<option value="10am to 11am"> 10.00am - 11.00am </option>
						<option value="11am to 12pm"> 11.00am - 12.00pm </option>
						<option value="12pm to 1pm"> 12.00pm - 01.00pm </option>
						<option value="3pm to 5pm"> 03.00pm - 05.00pm </option>
						<option value="5pm to 7pm"> 05.00pm - 07.00pm </option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="picktime"> Pickup Driver : </label>

				<div class="col-sm-9">
					<select class="form-control" id="driver" name="driver" required >
						<?php 
						$employeedata = $this->db->get_where('employee', array('emp_role'=>'enable'));
						foreach($employeedata->result() as $emprow) :
						
						echo "<option value='".$emprow->emp_id."' >" . $emprow->first_name ." " . $emprow->last_name ."</option>";
						
						endforeach; 
						?>
					</select>
				</div>
			</div>
			
			
			
													
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="remarks"> Driver Instruction : </label>

				<div class="col-sm-9">
					<input type="text" id="remarks" name="remarks" class="form-control"   />
				</div>
			</div>
			
			<div class="hr dotted"></div>
			
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Create &nbsp;&nbsp;" id='btn' >
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		

		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
		<script type="text/javascript">
			jQuery(function($) {

				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': 650});
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

				// $('#new_cust').click ( function(e){
				//    alert('hi');  
		  //          e.preventDefault();  
		  //          $.ajax({  
		  //               url :"<?=base_url()?>index.php/admin/pickup_new_cust",  
		  //               type:"POST",  
		  //               data:$('form#new_cust_form').serialize(),  
		  //               dataType: 'json',  
		  //               success:function(data){  
		  //               	alert(data);
		  //                window.location.reload();
		  //               }  
		  //          })  
		  //     });

				

			})

			

		</script>
		