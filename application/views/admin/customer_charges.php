<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/pos/cust_charges/updating/<?php echo $this->session->userdata('party_name'); ?>">
			
						
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="first_name"> <?php echo lang('Customer Name'); ?>  : </label>

				<div class="col-sm-9">
					
					<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->last_name; ?>" disabled />
				</div>
			</div>
			
			<?php 
			//echo $promocode;
			if($promocode=='Coupons') 
			{
			?>	
			
			<div class="hr dotted"></div>
			
			<!-- Coupon Selection -->
			
			
			<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="memberof"> <?php echo lang('Select'); ?> <?php echo lang('Coupons'); ?>   : </label>
			<div class="col-sm-9">
		
				<select class="form-control" name="cust_charges[]" id="cust_charges[]" multiple="multiple" title="Ctrl Click to Select a multiple" rows="7">
												
					<?php 
					$custcharge=$this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->cust_charges; 
					
					$cust_charge=unserialize($custcharge);  ?>
					
					<option> -- <?php echo lang('None'); ?>  --  </option>
					<?php foreach ($coupon_list->result() as $chargerow): ?>
					
					
					<option 
											
					<?php
					if(!empty($cust_charge)) 
					{	
					foreach ($cust_charge as $chargeId):
					 if($chargerow->charge_id==$chargeId)
						 echo "value='$chargerow->charge_id' selected";
					
					endforeach;
					}
					
					?> 
					value="<?php echo $chargerow->charge_id; ?>" > 
					
					<?php echo $chargerow->charge_name; 
					if($chargerow->charge_type=="percentage") { echo " (" . $chargerow->charge_amt ."% )"; } if($chargerow->charge_type=="amount") { echo " (" . sprintf("%0.2f", $chargerow->charge_amt) .")"; } 
					?> 
					
					
					</option>	
					
					<?php endforeach; ?>
					
				</select>
		   
			</div>

			</div>
			
			<?php 
			} 
			?>
			<div class="hr dotted"></div>
			
				
			
			<!-- Charges Selection --> 
			
			
			<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="memberof"> <?php echo lang('Select'); ?>  <?php echo lang('Charges'); ?>  : </label>
			<div class="col-sm-9">
		
				<select class="form-control" name="cust_charges[]" id="cust_charges[]" multiple="multiple" title="Ctrl Click to Select a multiple" rows="7">
												
					<?php 
					$custcharge=$this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->cust_charges; 
					
					$cust_charge=unserialize($custcharge);  ?>
					
					<option  value=''> ---- </option>
					<?php foreach ($charges_list->result() as $chargerow): ?>
					
					
					<option 
											
					<?php
					if(!empty($cust_charge)) 
					{	
					foreach ($cust_charge as $chargeId):
					 if($chargerow->charge_id==$chargeId)
						 echo "value='$chargerow->charge_id' selected";
					
					endforeach;
					}
					
					?> 
					value="<?php echo $chargerow->charge_id; ?>" > 
					
					<?php echo $chargerow->charge_name; 
					if($chargerow->charge_type=="percentage") { echo " (" . $chargerow->charge_amt ."% )"; } if($chargerow->charge_type=="amount") { echo " (" . sprintf("%0.2f", $chargerow->charge_amt) .")"; } 
					?> 
					
					
					</option>	
					
					<?php endforeach; ?>
					
				</select>
		   
			</div>

			</div>
			
			
			
			
			
			
										
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?>  &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		
		<!-- Extra Charges 		
		
		<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/pos/cust_extra_charge/updating">
			
						
			
			<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="extra_charge_value"> <?php echo 'Extra Charges'; ?> : </label>
			<div class="col-sm-9">
				<input type="text" name="extra_charge_value" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$this->session->userdata('party_name')))->row()->cust_extra_charge; ?>" required  /> <span style="font-size:10px;color:blue"> Instant Extra Charges Amount for Customers </span>
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
		
		-->



	
		