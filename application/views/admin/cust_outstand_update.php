<?php foreach ($outstand_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/outstand_crud/modify/'.$row->id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cust_id"> Cust ID  : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $row->id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cust_name"> First Name  : </label>

				<div class="col-sm-9">
					<input type="text" name="service_name" class="form-control" value="<?=$row->first_name?>" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="address1"> Address  : </label>

				<div class="col-sm-9">
					<input type="text" name="address1" class="form-control" value="<?=$row->address1?>" required />
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="mobile"> Whatsapp Number : </label>

				<div class="col-sm-9">
					<input type="text" name="mobile" class="form-control" value="<?= str_replace(' ', '', $row->mobile);?>" required />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="phone"> Phone : </label>

				<div class="col-sm-9">
					<input type="text" name="phone" class="form-control" value="<?php echo $row->phone; ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="outstand_amt"> Outstand Amount : </label>

				<div class="col-sm-9">
					<input type="text" name="outstand_amt" class="form-control" value="<?php echo $row->outstand_amt; ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="outstand_remarks"> Remarks : </label>

				<div class="col-sm-9">
					<textarea id="outstand_remarks" name="outstand_remarks" class="form-control" rows="3" ><?=$row->outstand_remarks?></textarea>
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