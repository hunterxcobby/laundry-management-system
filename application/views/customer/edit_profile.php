 <!-- http://snehakinkar.blogspot.in/2013/05/cascading-list-of-country-state-city.html -->
 
 
	<?php foreach ($userdata->result() as $userrow): ?>
							
							
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'admin_form','enctype' => 'multipart/form-data');
		echo form_open('customer/update_profile/'.$userrow->id.'',$attributes); ?>
			
			
						
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="user_id">User ID: </label>

						<div class="col-sm-9">
							<input type="text" id="adm_id" name="user_id" class="form-control" readonly value="<?php echo $this->session->userdata('user_id'); ?>" />
						</div>
					</div>
										
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="full_name"> Full Name : </label>

						<div class="col-sm-9">
							<input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $userrow->first_name ." ".$userrow->last_name; ?>"  readonly/>
						</div>
					</div>
										
			
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="mobile"> Mobile : </label>

						<div class="col-sm-9">
							<input type="text" id="mobile" name="mobile" class="form-control"  value="<?php echo $userrow->mobile; ?>" required autofous />
						</div>
					</div>
										
			
			
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="email"> Email : </label>

						<div class="col-sm-9">
							<input type="email" id="email" name="email" class="form-control"  value="<?php echo $userrow->email_id; ?>" required />
						</div>
					</div>
										
					<!--
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="address">Address: </label>

						<div class="col-sm-9">
							<input type="text" id="address" name="address" class="form-control"  value="<?php echo $userrow->address; ?>" required />
						</div>
					</div>
					-->
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="username"> username : </label>

						<div class="col-sm-9">
							<input type="text" id="username" name="username" class="form-control"  value="<?php echo $userrow->mobile; ?>" required readonly />
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
		
		