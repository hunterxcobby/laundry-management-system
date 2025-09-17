<?php foreach ($exps_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/expenses_crud/modify/'.$row->exps_id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="expse_id"> <?php echo lang('Expense ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="expse_id" class="form-control" required readonly value="<?php echo $row->exps_id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="expse_type"> <?php echo lang('Expenses Type'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="expse_type" class="form-control" value="<?php echo $row->exps_type ;?>" required  autofocus />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="expse_code"><?php echo lang('Description'); ?>   : </label>

				<div class="col-sm-9">
					<input type="text" name="expse_code" class="form-control" value="<?php echo $row->exps_code ;?>" />
				</div>
			</div>


			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Update'); ?>  &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?>  &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
			</form>
		</div>
		
		<?php endforeach; ?>