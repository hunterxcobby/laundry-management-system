<div class="">
	<?php $attributes = array('class' => 'form-horizontal', 'id' => 'group_form','enctype' => 'multipart/form-data');
	echo form_open('admin/group_crud/create',$attributes); ?>
	
	<div class="form-group ">
	<label class="col-sm-3 control-label no-padding-right" for="group_id"> <?php echo lang('Group ID'); ?>  : </label>

	<div class="col-sm-9">
	<input type="text" id="group_id" class="form-control" required readonly value="<?php echo $last_id+1; ?>" />
	</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="group_name"> <?php echo lang('Group Name'); ?>  : </label>

	<div class="col-sm-9">
	<input type="text" name="group_name" class="form-control"required  autofocus/>
	</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="status"> <?php echo lang('Group'); ?> <?php echo lang('Status'); ?>  : </label>

		<div class="col-sm-9">
			<select class="form-control" name="status" id="status">
				<option value="">-- <?php echo lang('Select'); ?>  --</option>
				<option value="enable" selected> <?php echo lang('Enable'); ?> </option>
				<option value="disable"><?php echo lang('Disable'); ?> </option>
				
			</select>
		
		</div>
	</div>
	<table id="dynamic-table" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				
				
				<th style="width:200px;"><?php echo lang('Model Name'); ?> </th>
				<th> <?php echo lang('Permission'); ?>  </th>

				
			</tr>
		</thead>
		<tbody>
		<tr>
		<td style='color:red;'> <i class="menu-icon fa fa-user-times"></i> <?php echo lang('Null (No Permission )'); ?>  </td>  
		<td> <input type="checkbox" name="grp_perm[]" value="null" style="height:16px; width:16px;" checked>  </td> 
		
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-tachometer"></i> <?php echo lang('Dashboard'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="desktop"  style="height:16px; width:16px;" >  </td> </td>   
		
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-desktop"></i> <?php echo lang('Master'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="master" style="height:16px; width:16px;">  </td>  </td>   
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon glyphicon glyphicon-tint"></i> <?php echo lang('Garments'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="garment" style="height:16px; width:16px;">  </td>   </td> 
		</tr>
		<tr>
		
		<td> <i class="menu-icon fa fa-truck"></i> <?php echo lang('Services'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="services" style="height:16px; width:16px;">  </td>   </td> 
		</tr>
		
		
		<tr>
		<td> <i class="menu-icon fa fa-list"></i> <?php echo lang('Job Order'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="joborder" style="height:16px; width:16px;">  </td>   </td> 
		</tr>
		
		
		
		<tr>
		<td> <i class="menu-icon fa fa-pencil-square-o"></i> <?php echo lang('Reports'); ?> </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="reports" style="height:16px; width:16px;">  </td>  </td>  
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-cog"></i> <?php echo lang('Settings'); ?> </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="settings" style="height:16px; width:16px;">  </td>  </td>  
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-users"></i> <?php echo lang('Groups_Role'); ?> </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="groupanduser" style="height:16px; width:16px;">  </td>   </td> 
		</tr>
		
		</tbody>
		</table>	
									
	<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
	<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;&nbsp;">
		
		&nbsp; &nbsp; &nbsp;														
		&nbsp; &nbsp; &nbsp;
	<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
		

	</div>
	</div>

	</form>
</div>