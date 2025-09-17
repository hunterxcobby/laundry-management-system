<?php foreach ($color_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('garment/color_crud/modify/'.$row->id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id"> <?php echo lang('Color ID'); ?> : </label>

				<div class="col-sm-9">
					<input type="text" id="color_id" class="form-control" required readonly value="<?php echo $row->id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="color_name"> <?php echo lang('Color Name'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="color_name" class="form-control" value="<?php echo $row->color_name ;?>" required  autofocus />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="color_image"> <?php echo lang('Image'); ?>  ( <img src='<?php echo base_url(); ?>assets/gcolors/<?php echo $row->id; ?>.png' style="height:30px; width:30px;"> ) : </label>

				<div class="col-sm-9">
					<input type="file" name="color_image" id="color_image" class="form-control" />
				</div>
			</div>
										

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="remarks"> <?php echo lang('Remarks'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="remarks" class="form-control" value="<?php echo $row->color_remark ;?>" />
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