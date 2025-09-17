<?php foreach ($service_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/service_crud/modify/'.$row->id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> <?php echo lang('Service ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $row->id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_name"> <?php echo lang('Service Name'); ?> [English]  : </label>

				<div class="col-sm-9">
					<input type="text" name="service_name" class="form-control" value="<?php echo $row->service_name ; ?>" required  autofocus />
				</div>
			</div>
			<!--
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_name"> <?php echo lang('Service Name'); ?>  [ <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_lang; ?> ] : </label>

				<div class="col-sm-9">
					<input type="text" name="service_name_lang" class="form-control" value="<?php echo $row->service_name_lang ;?>"   />
				</div>
			</div> -->
			
			<input type="hidden" name="service_name_lang" value="">
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="active"> <?php echo lang('Show/Hide'); ?>  :  </label>

				<div class="col-sm-9">
					<select class="form-control" name="active" id="active" >
						<option value="show" <?php if($row->show_hide=="show") { echo "selected"; } ?> > <?php echo lang('Show'); ?> </option>
						<option value="hide" <?php if($row->show_hide=="hide") { echo "selected"; } ?> > <?php echo lang('Hide'); ?> </option>
				
					</select>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_code"> <?php echo lang('Description'); ?> : </label>

				<div class="col-sm-9">
					<input type="text" name="service_code" class="form-control" value="<?php echo $row->service_code; ?>" />
				</div>
			</div>
			
			<div class="form-group">
							
				<label class="col-sm-3 control-label no-padding-right" for="service_img"> <?php echo lang('Image'); ?>  ( <img src='<?php echo base_url(); ?>assets/stock/ser_<?php echo $row->id; ?>.png' style="height:30px; width:30px;"> )  : </label>

				<div class="col-sm-9">
					<input type="file" name="service_img" id="service_img" class="form-control" />
				</div>
			</div> 
			
            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="priority"> <?php echo 'Priority'; ?> : </label>

				<div class="col-sm-9">
					<input type="number" name="priority" class="form-control" value="<?php echo $row->priority; ?>" />
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
			Note : <a href="https://translate.google.co.in/" target="_blank"> Google Translate </a> 
		</div>
		
		<?php endforeach; ?>