<?php foreach ($charges_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'charge_form','enctype' => 'multipart/form-data');
			echo form_open('admin/charge_crud/modify/'.$row->charge_id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="charge_id"> <?php echo lang('Charge ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $row->charge_id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_name"> <?php echo lang('Charge Name'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="charge_name" class="form-control" value="<?php echo $row->charge_name;?>" required  autofocus />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_type"> <?php echo lang('Transaction Type'); ?>  : </label>

				<div class="col-sm-9">
				<select class="form-control" name="charge_type" id="charge_type" required >
						<option value="">-- Select --</option>
						<option value="percentage" <?php if($row->charge_type=="percentage") { echo "selected"; } ?>> <?php echo lang('Percentage (%)'); ?>  </option>
						<option value="amount" <?php if($row->charge_type=="amount") { echo "selected"; } ?>> <?php echo lang('Amount'); ?>  </option>
						
				</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="transaction"> <?php echo lang('In Transaction'); ?> : </label>

				<div class="col-sm-9">
					<select class="form-control" name="transaction" id="transaction" required >
						<option value="">-- Select --</option>
						<option value="1" <?php if($row->transaction==1) { echo "selected"; } ?>> <?php echo lang('Add Amount'); ?>  </option>
						<option value="0" <?php if($row->transaction==0) { echo "selected"; } ?>> <?php echo lang('Minus Amount'); ?>  </option>
						
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_value"> <?php echo lang('Transaction Value'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="charge_value" class="form-control" value="<?php echo $row->charge_amt ;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="transaction"> <?php echo lang('Default (Y/N)'); ?> : </label>

				<div class="col-sm-9">
					<select class="form-control" name="defaults" id="defaults"  >
						<option value="" <?php if($row->defaults=="") { echo "selected"; } ?>> <?php echo lang('No'); ?> </option>
						<option value="yes" <?php if($row->defaults=="yes") { echo "selected"; } ?>> <?php echo lang('Yes'); ?> </option>
						
					</select>
				</div>
			</div>
			<!--
			

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="expire_date"> Expire Date : </label>

				<div class="col-sm-9">
					<input type="text" name="expire_date" class="form-control" value="<?php if($row->expire_date!='0000-00-00') echo date('j-m-Y',strtotime($row->expire_date));?>" placeholder="dd-mm-yyyy" />
				</div>
			</div> -->
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_remarks"> <?php echo lang('Description'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="charge_remarks" class="form-control" value="<?php echo $row->charge_remarks ;?>" />
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
		
		<?php endforeach; ?>