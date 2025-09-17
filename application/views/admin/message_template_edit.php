<?php foreach ($message_temp_edit as $msgrow): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'charge_form','enctype' => 'multipart/form-data');
			echo form_open('admin/message_crud/modify/'.$msgrow->msg_id.'',$attributes); ?>
			
			<!-- <div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="temp_id"> Template ID#  : </label>

				<div class="col-sm-9">
					<input type="text" id="msg_id" class="form-control" required readonly value="<?php echo $msgrow->msg_id ;?>" />
				</div>
			</div> -->
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="message_for"> Message For : </label>

				<div class="col-sm-9">
					<input type="text" id="message_for" class="form-control" required readonly value="<?php echo $msgrow->message_for ;?>" />

					<!-- <select name="message_for" id="message_for" class="form-control"  required disabled >
						<option value="new_order" <?php if($msgrow->message_for=='new_order') echo "selected"; ?> > New Order  </option>
						<option value="pickup" > Pickup  </option>
						<option value="processing" > Processing  </option>
						<option value="ready_for_delivery" > Ready for Delivery  </option>
						<option value="out_for_delivery" > Out for Delivery  </option>
						<option value="delivered"> Delivered  </option>
						<option value="outstanding" <?php if($msgrow->message_for=='outstanding') echo "selected"; ?> > Outstanding  </option>
					</select> -->
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="msg_title"> Template Name : </label>

				<div class="col-sm-9">
					<input type="text" name="msg_title" class="form-control" value="<?=$msgrow->msg_title?>" placeholder="pickup, newcustomer,delivery etc" required  autofocus/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="msg_body"> Message : </label>

				<div class="col-sm-9">
					<textarea id="msg_body" name="msg_body" class="form-control" rows="6" ><?=$msgrow->msg_body?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="active">  Keywords  : </label>

				<div class="col-sm-9">
					<small>
						{CUSTOMER_NAME}		=> customer Name <br/>
						{CUSTOMER_MOBILE}	=> customer Mobile <br/>
						{INVOICE} 			=> customer Invoice / Order No <br/>
						{INVOICE_AMT} 		=> customer Invoice / Order Amount <br/>
						{PAID_AMT} 			=> customer Paid Amount <br/>
						{PICKUP_DATE} 		=> customer order pickup date <br/>
						{PICKUP_PHOTO} 		=> customer order pickup photo link <br/>
						{DELIVERY_DATE} 	=> customer order delivery date <br/>
						{DELIVERY_PHOTO} 	=> customer order delivery photo link <br/>
						{PICKUP_BY} 		=> customer order pickup driver <br/>
						{DELIVERY_BY} 		=> customer order delivery driver <br/>
						{PAYMENT_STATUS} 	=> customer order status e.g. paid/notpaid etc <br/>
						{PAYMENT_MODE} 		=> customer payment status e.g. bycash, bycard etc <br/>
						{OUTSTAND_AMT} 		=> customer Outstading Amount <br/>
						{ANDROID_LINK}		=> andriod Mobile app link  </br/>
						{ONLINE_PAYMENT}	=> onlline Payment Link
					</small>
				</div>
			</div>
													
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="active">  Active  : </label>

				<div class="col-sm-9">
					<select class="form-control" name="active" id="active" required>
						<option value="yes" <?php if($msgrow->active=='yes') echo "selected"; ?> > Yes  </option>
						<option value="no" <?php if($msgrow->active=='no') echo "selected"; ?>> No </option>
						
					</select>
				</div>
			</div>	

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Update'); ?> &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		<!-- Note : Image Size max 150KB with 480px width x 360px height. -->
		<?php endforeach; ?>