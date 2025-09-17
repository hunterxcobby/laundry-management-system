<?php foreach ($promocode_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'charge_form','enctype' => 'multipart/form-data');
			echo form_open('admin/promo_crud/modify/'.$row->charge_id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="charge_id"> <?php echo lang('Coupon ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $row->charge_id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_name"> <?php echo lang('Coupon Name'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="charge_name" class="form-control" value="<?php echo $row->charge_name;?>" required  autofocus />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_type"> <?php echo lang('Transaction Type'); ?>  : </label>

				<div class="col-sm-9">
				<select class="form-control" name="charge_type" id="charge_type" required >
						<option value="">-- Select --</option>
						<option value="percentage" <?php if($row->charge_type=="percentage") { echo "selected"; } ?>> <?php echo lang('Percentage'); ?>  </option>
						<option value="amount" <?php if($row->charge_type=="amount") { echo "selected"; } ?>> <?php echo lang('Amount'); ?>  </option>
						
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
				<label class="col-sm-3 control-label no-padding-right" for="expire_date"> <?php echo lang('Expire Date'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="expire_date" class="form-control" value="<?php if($row->expire_date!='0000-00-00') echo date('j-m-Y',strtotime($row->expire_date));?>" placeholder="dd-mm-yyyy" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="charge_remarks"> <?php echo lang('Description'); ?>  : </label>

				<div class="col-sm-9">
					<textarea name="charge_remarks" class="form-control"><?php echo $row->charge_remarks;?></textarea>
				</div>
			</div>
			
			
			<div class="form-group">
							
				<label class="col-sm-3 control-label no-padding-right" for="offer_img"> <?php echo lang('Image'); ?>  : </label>

				<div class="col-sm-9">
					<input type="file" name="offer_img" id="offer_img" class="form-control" />
				</div>
			</div> 
			<input type="hidden" name="transaction" value="0"  />
			<input type="hidden" name="coupon" value="yes"  />
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="offer_img"> &nbsp; &nbsp;</label>
				<div class="col-sm-9">
				<img src='<?php echo base_url(); ?>assets/stock/offer_<?php echo $row->charge_id; ?>.png' style="height:150px; width:200px;">
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