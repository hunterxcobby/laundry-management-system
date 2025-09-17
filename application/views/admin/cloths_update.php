<?php foreach ($cloths_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/cloth_crud/modify/'.$row->id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id"> <?php echo lang('Garment ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $row->id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> <span style="font-size:12px;"> <?php echo lang('Garment Name'); ?> (English) : </span> </label>

				<div class="col-sm-9">
					<input type="text" name="cloth_name" class="form-control" value="<?php echo $row->cloth_type ;?>" required  autofocus />
				</div>
			</div>
			
		
			<!--
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> <span style="font-size:12px;"> <?php echo lang('Garment Name'); ?> (<?php echo ucwords($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_lang); ?>) : </span> </label>

				<div class="col-sm-9">
					<input type="text" name="cloth_name_lang" class="form-control" value="<?php echo $row->cloth_type_lang ;?>"  />
				</div>
			</div>
			-->			
				<input type="hidden" name="cloth_name_lang" value="">

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="no_of_qty"> <?php echo "No. of Piece(s)"; ?>  : </label>

				<div class="col-sm-9">
					<select name="no_of_qty" id="no_of_qty" class="form-control"  required >
					<!-- <option value="flat"> Flat </option> -->
					<option value="1" <?php if($row->no_of_qty=="1") echo "selected"; ?> > 1 </option>
					<option value="2" <?php if($row->no_of_qty=="2") echo "selected"; ?>> 2  </option>
			    	<option value="3" <?php if($row->no_of_qty=="3") echo "selected"; ?>> 3 </option>
			    	<option value="4" <?php if($row->no_of_qty=="4") echo "selected"; ?>> 4 </option>
			    	<option value="5" <?php if($row->no_of_qty=="5") echo "selected"; ?>> 5 </option>
					
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_code"> <?php echo lang('Remarks'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="cloth_code" class="form-control" value="<?php echo $row->cloth_code ;?>" />
				</div>
			</div>
			<!--
			<div class="form-group">
							
			<label class="col-sm-3 control-label no-padding-right" for="garment_image"> Image ( <img src='<?php echo base_url(); ?>assets/stock/<?php echo $row->id; ?>.png' style="height:30px; width:30px;"> )  : </label>

			<div class="col-sm-9">
				<input type="file" name="garment_image" id="garment_image" class="form-control" />
			</div>
			
			</div> -->

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