<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/admin/customer_crud/direct_create">
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="user_id"> <?php echo lang('Customer ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="user_id" class="form-control" readonly value="<?php echo $last_id+1; ?>" />
				</div>
			
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="join_date"> <?php echo lang('Join Date'); ?>  : </label>

				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control date-picker" name="join_date" id="join_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" readonly/>
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="first_name"> <?php echo lang('First Name'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="first_name" id="first_name" class="form-control" required />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="last_name"> <?php echo lang('Last Name'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="last_name" id="last_name" class="form-control"   />
				</div>
			</div>
			
			<div class="hr dotted"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="address1"> <?php echo lang('Address 1'); ?> : </label>

				<div class="col-sm-9">
					<input type="text" id="address1" name="address1" class="form-control"   />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="city"><?php echo lang('City'); ?> : </label>

				<div class="col-sm-9">
					<input type="text" id="city" name="city" class="form-control"   />
				</div>
			</div>
				
			
													
			<div class="hr dotted"></div>
				
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="email"> <?php echo lang('Email ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="email" name="email" id="email" class="form-control"   />
				</div>
			</div>
					
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="phone"> <?php echo lang('Phone'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="phone" id="phone" class="form-control" required />
				</div>
			</div>
			
			
			
			<div class="hr dotted"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="memberof"> <?php echo lang('Select Charges'); ?>  : </label>
				<div class="col-sm-9">
			
					<select class="form-control" name="cust_charges[]" id="cust_charges[]" multiple="multiple" title="Ctrl Click to Select a multiple">
					<option value='' selected> -- <?php echo lang('None'); ?>  -- </option>
					<?php foreach ($charges_list->result() as $chargerow): ?>
						
					<?php echo "<option value='$chargerow->charge_id'>". $chargerow->charge_name; 
						  if($chargerow->charge_type=="percentage") { echo " (" . $chargerow->charge_amt ."% )"; } if($chargerow->charge_type=="amount") { echo " (" . sprintf("%0.2f", $chargerow->charge_amt) .")"; } 	
						  echo "</option>"; 
					?>
					<?php endforeach; ?>
						
					</select>
			   
				</div>
			</div>
				
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="memberof"> <?php echo lang('Store Name'); ?>  : </label>
				<div class="col-sm-9">
			
					<select class="form-control" name="laundry_store" id="laundry_store"  required>
						<option value="" selected> -- <?php echo lang('None'); ?>  -- </option>
						<?php foreach ($store_list->result() as $storerow): 
						echo "<option value='".$storerow->id."'>". $storerow->store_name ."</option>"; 
						?>
						<?php endforeach; ?>
						
					</select>
			   
				</div>
			</div>

			<?php 
				$pkgList=$this->db->get('packages');
				if($pkgList->num_rows()!=0)
				{	
			?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="memberof"> <?php echo "Choose Package"; ?>  : </label>
				<div class="col-sm-9">
			
					<select class="form-control" name="pref_pkg" id="pref_pkg" >
						<option value="" selected> -- <?php echo lang('None'); ?>  -- </option>

						<?php 
						foreach ($pkgList->result() as $pkgRow) : 
							$pkgName=$pkgRow->pkg_name." [ ".$pkgRow->usage_limit."/".$pkgRow->pkg_unit." Rs.".$pkgRow->amount." ]";
						echo "<option value='".$pkgRow->pkg_id."'>". $pkgName ."</option>"; 
						endforeach;
						?>
						
					</select>
			   
				</div>
			</div>
			<?php
				}
			?>
				
		
										
			

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;" id='btn' disabled>
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		
	<script type="text/javascript">
		jQuery(function($) {
		// Customer Mobile Check

					$('#phone').change(function() {
					var phone = $(this).val();
					//alert(phone);
					$.ajax({
						url: "<?php echo base_url();?>index.php/admin/check_phone",
						cache:'false',
						type: 'POST',
						data: {phone: phone},
						success: function(data) {
							if(data!="") { alert(data); $('#phone').focus(); $('#btn').prop("disabled", true);  }
							else { $('#btn').prop("disabled", false); }
							
						}				
					 });
						return false;
					});	

			})
		</script>
		