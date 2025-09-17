<?php foreach ($category_edit as $row): ?>

		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/category_crud/modify/'.$row->cat_id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> Category ID : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $row->cat_id ;?>" />
				</div>
			</div>
			
			<div class="space-4"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="category_name"> Category Name : </label>

				<div class="col-sm-9">
					<input type="text" name="category_name" class="form-control" value="<?php echo $row->category_name ;?>" required  autofocus />
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="active">   Show/Hide :  </label>

				<div class="col-sm-9">
					<select class="form-control" name="active" id="active" >
						<option value="show" <?php if($row->show_hide=="show") { echo "selected"; } ?> >Show</option>
						<option value="hide" <?php if($row->show_hide=="hide") { echo "selected"; } ?> >Hide</option>
				
					</select>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="category_descr"> Description: </label>

				<div class="col-sm-9">
					<input type="text" name="category_descr" class="form-control" value="<?php echo $row->category_descr; ?>" />
				</div>
			</div>
			
						


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
		
		<?php endforeach; ?>