 <!-- http://snehakinkar.blogspot.in/2013/05/cascading-list-of-country-state-city.html -->
 
 <script type="text/javascript">
	$(document).ready(function() { 
	$('#short_code').change(function() {
			var productcode = $(this).val();
			//alert(productcode);
			$.ajax({
                url: "<?php echo base_url();?>index.php/customer/check_item",
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
					//alert("success");
                    $('#service_name').val(result.service);
                    $('#cloth_name').val(result.cloth);
                    $('#qty').focus();
				}
				
				
            });
			
			 return false;
			});	
	});	
 </script>

	
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
		echo form_open('customer/customer_orders/add_item_order/'.$UpdateOrder.'',$attributes); ?>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Short Code : </label>
				
				<div class="col-sm-9">
					<select class="chosen-select form-control" name="short_code" id="short_code" data-placeholder="Choose a Services...">
						<option value="">  </option>
						<?php foreach ($price_data->result() as $pricerow): ?>
							
						<?php echo "<option value='$pricerow->id'>". $pricerow->short_code ."</option>"; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_name"> Service Name : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="service_name" id="service_name" data-placeholder="Choose a Services...">
						<option value="">  </option>
						<?php foreach ($laundry_service->result() as $servicerow): ?>
							
						<?php echo "<option value='$servicerow->id'>". $servicerow->service_name ."</option>"; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<!-- Choosen CLoths -->
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> Cloth Type : </label>

				<div class="col-sm-9">
					<select class="chosen-select form-control" name="cloth_name" id="cloth_name" data-placeholder="Choose a Services...">
						<option value="">  </option>
						<?php foreach ($laundry_cloth->result() as $clothrow): ?>
							
						<?php echo "<option value='$clothrow->id'>". $clothrow->cloth_type ."</option>"; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
											
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="qty"> Quantity : </label>

				<div class="col-sm-9">
					<input type="number" name="qty" id="qty" class="form-control"  />
				</div>
			</div>


			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Add Item &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
		</form>
	</div>
		
		