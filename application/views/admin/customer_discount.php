	<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/pos/cust_discount/updating">
			
						
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="first_name"> <?php echo lang('Customer Name'); ?>  : </label>

				<div class="col-sm-9">
					
					<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->last_name; ?>" disabled />
				</div>
			</div>
			
			<div class="hr dotted"></div>
			
			<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="charge_value"> <?php echo lang('Discount'); ?> : </label>
			<div class="col-sm-9">
				<input type="text" name="charge_value" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->cust_discount; ?>" required  /> <span style="font-size:10px;color:blue"> Instant Discount for Special Customers </span>
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
		
		

	
				



	
		