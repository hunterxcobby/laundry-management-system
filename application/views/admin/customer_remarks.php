<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/pos/cust_remarks/save">
			
						
			<!--
			
			<div class="form-group">
			
			<label class="col-sm-3 control-label no-padding-right" for="remarks"> Urgent : </label>
			<div class="col-sm-9">
				<select class="form-control" name="party_name" id="party_name" data-placeholder="Urgent Delivery..." >
													<option value="" > </option>
													<option value="Yes" > Yes </option>
													<option value="No" > No </option>
				</select>									
			</div>
			
			-->
			
			<div class="form-group">										
													
			<label class="col-sm-3 control-label no-padding-right" for="remarks"> <?php echo lang('Remarks'); ?>  : </label>
			<div class="col-sm-9">
				<input type="text" name="remarks" class="form-control" value="<?php echo $this->session->userdata('order_remark');?>" required  />
			</div>

			</div>
										
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		



	
		