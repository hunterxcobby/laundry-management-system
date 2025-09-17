
		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
			echo form_open('package/pkg_crud/modify_pkg_status/'.$pkg_id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> Order No : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $pkg_id ;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Customer Name :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->last_name; ?>" disabled />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Package Name :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $pref_pkg; ?>" disabled />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Payment Mode :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $payment_mode; ?>" disabled />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Payment Date :  </label>

				<div class="col-sm-9">
					<input type="text" name="payment_date" id="payment_date" class="form-control" value="<?php echo date('d-M-Y'); ?>" />
				</div>
			</div>
			
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Package Status : </label>

				<div class="col-sm-9">
					<select class="form-control" name="pkg_active" id="pkg_active" >
													
						<option value="inactive" <?php if($pkg_active=="inactive") echo "selected"; ?> > Inactive </option>
						<option value="active" <?php if($pkg_active=="active") echo "selected"; ?> > Active </option>
						<option value="expired" <?php if($pkg_active=="expired") echo "selected"; ?> > Expire </option>
						<option value="cancelled" <?php if($pkg_active=="cancelled") echo "selected"; ?> > Cancel </option>
																						
					</select>
				</div>
			</div>
			
			<!--
			<input type="hidden" name="paidby" id="paidby" value="<?php echo $AmtPaidBy; ?>">
			
			<?php $MasterAdmin=$this->session->userdata('user_from'); if ($MasterAdmin!="") { ?>
																
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Payment Status : </label>

				<div class="col-sm-9">
					<select class="form-control" name="paidby" id="paidby" >
						<option value="notpaid" <?php if($AmtPaidBy=="notpaid") echo "selected"; ?> >Unpaid</option>
						<option value="bycash" <?php if($AmtPaidBy=="bycash") echo "selected"; ?> >Cash Payment </option>
						<option value="byonline" <?php if($AmtPaidBy=="byonline") echo "selected"; ?> >Online Payment</option>
					</select>
				</div>
			</div>
			<?php } ?>
																
			-->
			
			
					
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Update &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		
	