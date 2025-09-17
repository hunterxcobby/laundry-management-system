 <!-- http://snehakinkar.blogspot.in/2013/05/cascading-list-of-country-state-city.html -->
 
 
	<?php foreach ($empdata->result() as $emprow): ?>
							
							
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'admin_form','enctype' => 'multipart/form-data');
		echo form_open('employee/update_profile/'.$emprow->emp_id.'',$attributes); ?>
			
			
						
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="user_id">Employee ID: </label>

						<div class="col-sm-9">
							<input type="text" id="adm_id" name="user_id" class="form-control" readonly value="<?php echo $this->session->userdata('emp_id'); ?>" />
						</div>
					</div>
										
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="full_name"> Full Name : </label>

						<div class="col-sm-9">
							<input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $emprow->first_name ." ".$emprow->last_name; ?>"  required/>
						</div>
					</div>
										
			
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="mobile"> Mobile : </label>

						<div class="col-sm-9">
							<input type="text" id="mobile" name="mobile" class="form-control"  value="<?php echo $emprow->mobile; ?>" required />
						</div>
					</div>
										
			
			
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="email"> Email : </label>

						<div class="col-sm-9">
							<input type="email" id="email" name="email" class="form-control"  value="<?php echo $emprow->email_id; ?>" required />
						</div>
					</div>
										
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="address1">Address1: </label>

						<div class="col-sm-9">
							<input type="text" id="address1" name="address1" class="form-control"  value="<?php echo $emprow->emp_add1; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="address2">Address2: </label>

						<div class="col-sm-9">
							<input type="text" id="address2" name="address2" class="form-control"  value="<?php echo $emprow->emp_add2; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="city">City: </label>

						<div class="col-sm-9">
							<input type="text" id="city" name="city" class="form-control"  value="<?php echo $emprow->emp_city; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="state">State: </label>

						<div class="col-sm-9">
							<input type="text" id="state" name="state" class="form-control"  value="<?php echo $emprow->emp_state; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="zipcode">ZipCode: </label>

						<div class="col-sm-9">
							<input type="text" id="zipcode" name="zipcode" class="form-control"  value="<?php echo $emprow->emp_zip; ?>" required />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="username"> username : </label>

						<div class="col-sm-9">
							<input type="text" id="username" name="username" class="form-control"  value="<?php echo $emprow->mobile; ?>" required readonly />
						</div>
					</div>
										
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="new_passwd"> New Password : </label>

						<div class="col-sm-9">
							<input type="password" id="new_passwd" name="new_passwd" class="form-control"  placeholder="if blank no password change" autofill="off" />
						</div>
					</div>
					


			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Update &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			<?php endforeach; ?>	
			
			
		</form>
	</div>
		
		