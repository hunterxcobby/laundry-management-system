<?php foreach ($pricelist_edit as $row): ?>

		<div class="">
			<?php require_once("system_currency.php"); ?>
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
			echo form_open('admin/price_crud/modify/'.$row->id.'',$attributes); ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> <?php echo lang('Price ID'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $row->id ;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_name"> <?php echo lang('Service Name'); ?>  : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="service_name" id="service_name" data-placeholder="Choose a Services..." required >
					<option value="">  </option>	
						<?php 
						foreach ($laundry_service->result() as $servicerow): 
							
							if($servicerow->id==$row->service_id)
								{ echo "<option value='$servicerow->id' selected>". $servicerow->service_name ."</option>"; }
							else
								{ echo "<option value='$servicerow->id'>". $servicerow->service_name ."</option>"; }	
						 
						endforeach; 
						?>
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cateory_name"> <?php echo lang('Category Name'); ?>  : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="category_name" id="category_name" data-placeholder="Choose a Category..." required >
					<option value="">  </option>	
						<?php 
						foreach ($laundry_category->result() as $categoryRow): 
							
							if($categoryRow->cat_id==$row->category_id)
								{ echo "<option value='$categoryRow->cat_id' selected>". $categoryRow->category_name ."</option>"; }
							else
								{ echo "<option value='$categoryRow->cat_id'>". $categoryRow->category_name ."</option>"; }	
						 
						endforeach; 
						?>
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> <?php echo lang('Garment Type'); ?>  : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="cloth_name" id="cloth_name" data-placeholder="Choose a Services..." required>
					<option value="">  </option>	
						
						<?php 
						foreach ($laundry_cloth->result() as $clothrow):
							
							if($clothrow->id==$row->cloth_id)
								{ echo "<option value='$clothrow->id' selected>". $clothrow->cloth_type ."</option>"; }
							else
								{ echo "<option value='$clothrow->id'>". $clothrow->cloth_type ."</option>"; }	
						 
						endforeach; 
						?>
						
					</select>
				</div>
			</div>
			
			
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> <?php echo lang('Short Code'); ?>  : </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $row->short_code ;?>" maxlength="15" required/>
				</div>
			</div>
										
			
			
			
												
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="price"> <?php echo lang('Price'); ?>  (<?php echo $sys_curr; ?>) : </label>

				<div class="col-sm-9">
					<input type="text" name="price" id="price" class="form-control" value="<?php echo $row->price;?>" required  />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_unit"> <?php echo lang('Price Unit'); ?>  : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="service_unit" id="service_unit" required >
					
					<!--<option value="qty" <?php if($row->service_unit=="flat") echo "selected"; ?> > Flat </option> -->
					<option value="qty" <?php if($row->service_unit=="qty") echo "selected"; ?> > <?php echo lang('Quantity'); ?> </option>
					<option value="kg" <?php if($row->service_unit=="kg") echo "selected"; ?> > <?php echo lang('Kilogram'); ?> </option>
					<option value="sqft" <?php if($row->service_unit=="sqft") echo "selected"; ?> > Sq. Ft </option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
							
				<label class="col-sm-3 control-label no-padding-right" for="service_img"> <?php echo lang('Image'); ?>  ( <img src='<?php echo base_url(); ?>assets/stock/<?php echo $row->id; ?>.png' style="height:30px; width:30px;"> )  : </label>

				<div class="col-sm-9">
					<input type="file" name="service_img" id="service_img" class="form-control" />
				</div>
			</div>
			<div class="form-group">
																
				<label class="col-sm-3 control-label no-padding-right" for="service_img">  </label>
				<small class="col-sm-9" > only gif, png, jpg files allow with file size 150KB </small>

				
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