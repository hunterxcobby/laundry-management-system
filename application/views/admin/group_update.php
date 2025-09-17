<?php foreach ($group_edit as $row): ?>

<div class="">
	<?php $attributes = array('class' => 'form-horizontal', 'id' => 'group_form','enctype' => 'multipart/form-data');
	echo form_open('admin/group_crud/modify/'.$row->id.'',$attributes); ?>
	
	<div class="form-group ">
	<label class="col-sm-3 control-label no-padding-right" for="group_id"> Group ID : </label>

	<div class="col-sm-9">
	<input type="text" id="group_id" class="form-control" required readonly value="<?php echo $row->id; ?>" disabled />
	</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="group_name"> Group Name : </label>

		<div class="col-sm-9">
		<input type="text" name="group_name" class="form-control" value="<?php echo $row->group_name; ?>" required  autofocus/>
		</div>
	</div>
	
	<!--
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="group_name"> Group Descr : </label>

		<div class="col-sm-9">
		<textarea name="group_descr" class="form-control"><?php echo $row->group_descr; ?></textarea>
		</div>
	</div> -->
	

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="status"> <span style="color:<?php if($row->group_status=="enable") { echo "#5cb85c!important;"; } else { echo "#D15B47!important;"; } ?>"> Group Status : </span> </label>
		<div class="col-sm-9">
			<select class="form-control" name="m_status" id="m_status" required >
				<option value="">-- Select --</option>
				<option value="enable" <?php if($row->group_status=="enable") { echo "selected"; } ?>> Enable </option>
				<option value="disable" <?php if($row->group_status=="disable") { echo "selected"; } ?>> Disable </option>
				
			</select>
		</div>
	</div>
	
	<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
	<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; Update &nbsp;&nbsp;&nbsp;">
		
		&nbsp; &nbsp; &nbsp;														
		&nbsp; &nbsp; &nbsp;
	<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
		

	</div>
	</div>

	</form>
</div>

<?php endforeach; ?>