	
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
		echo form_open('admin/sms_email_send',$attributes); 
		?>
			
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cust_name"> Select Customer  : </label>
				
				<div class="col-sm-9">
					<select class="chosen-select form-control" name="cust_name" id="cust_name" data-placeholder="Choose a Services...">
						<option value=""> -- Select Customers -- </option>
						<?php foreach ($userdata->result() as $userrow): ?>
							
						<?php echo "<option value='$userrow->id'>". $userrow->first_name ."".$userrow->last_name. "</option>"; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="email">Email ID:</label>

					<div class="col-sm-9 col-xs-12">
						<div class="input-icon block col-xs-12 no-padding">
							<input maxlength="100" type="email" class="col-xs-12" name="email" id="email"  required />
							
						</div>
					</div>
			</div>
			
			
			<div class="hr hr-18 dotted"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="sms_send"> Send SMS  : </label>
				
				<div class="col-sm-9">
					<select class="chosen-select form-control" name="sms_send" id="sms_send" data-placeholder="Choose a Services...">
						<option value="">  </option>
						<option value="mobile"> By Mobile </option>
						<option value="email" selected> By Email  </option>
						<option value="email_mobile" > Mobile + Email </option>
					</select>
				</div>
			</div>
			
			<div class="hr hr-18 dotted"></div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="subject">Subject:</label>

					<div class="col-sm-9 col-xs-12">
						<div class="input-icon block col-xs-12 no-padding">
							<input maxlength="100" type="text" class="col-xs-12" name="subject" id="subject" placeholder="Subject" value="Send Mail" />
							<i class="ace-icon fa fa-comment-o"></i>
						</div>
					</div>
				</div>

			<div class="hr hr-18 dotted"></div>

				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="send_message"> Message : </label>

				<div class="col-sm-9">
					<textarea class="form-control" name="send_message" id="send_message"> Dear Cust, Your Order .........</textarea>
				</div>
				</div>
				<input type="hidden" name="enquiry" value="" >

			<div class="hr hr-18 dotted"></div>

				
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Send Message &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			</div>
			</div>
		</div>	
			
		</form>
	</div>
		
		