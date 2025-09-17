
		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
			echo form_open("admin/customer_orders/modify_order_date/".$OrderId."",$attributes); ?>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="service_id"> Invoice No : </label>

				<div class="col-sm-9">
					<input type="text" id="service_id" class="form-control" required readonly value="<?php echo $InvoiceNo ;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Customer Name :  </label>

				<div class="col-sm-9">
					<input type="text" name="short_code" id="short_code" class="form-control" value="<?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$CustId))->row()->last_name; ?>" disabled />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="short_code"> Order Status :  </label>

				<div class="col-sm-9">
					<input type="text" name="order_status" id="order_status" class="form-control" value="<?=$OrderStatus?>" readonly />
				</div>
			</div>


			<?php if($OrderStatus=='new_order') { ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Order Date : </label>
			<div class="col-sm-9">
					<input type="date" name="order_date" id="order_date" class="form-control" value="<?php echo $OrderDate; ?>" />
				</div>
			</div>

			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Pickup Date : </label>

				<div class="col-sm-9">
					<input type="date" name="pickup_date" id="pickup_date" class="form-control" value="<?php echo $PickupDate; ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Pickup Time  : </label>

				<div class="col-sm-9">
					<select class="form-control" name="pickup_time" id="pickup_time">
					<option value="10am to 11am" <?php if($PickupTime=='10am to 11am') echo 'selected'; ?> > 10.00am - 11.00am </option>
					<option value="11am to 12pm" <?php if($PickupTime=='11am to 12pm') echo 'selected'; ?>> 11.00am - 12.00pm </option>
					<option value="12pm to 1pm" <?php if($PickupTime=='12pm to 1pm') echo 'selected'; ?>> 12.00pm - 01.00pm </option>
					<option value="3pm to 5pm" <?php if($PickupTime=='3pm to 5pm') echo 'selected'; ?>> 03.00pm - 05.00pm </option>
					<option value="5pm to 7pm" <?php if($PickupTime=='5pm to 7pm') echo 'selected'; ?> > 05.00pm - 07.00pm </option>
				</select>
				</div>
			</div>

			<?php } else { ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Order Date : </label>
			<div class="col-sm-9">
					<input type="date" name="order_date" id="order_date" class="form-control" value="<?php echo $OrderDate; ?>" readonly />
				</div>
			</div>

			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Pickup Date : </label>

				<div class="col-sm-9">
					<input type="date" name="pickup_date" id="pickup_date" class="form-control" value="<?php echo $PickupDate; ?>" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Pickup Time  : </label>

				<div class="col-sm-9">
					<select class="form-control" name="pickup_time" id="pickup_time" disabled>
					<option value="10am to 11am" <?php if($PickupTime=='10am to 11am') echo 'selected'; ?> > 10.00am - 11.00am </option>
					<option value="11am to 12pm" <?php if($PickupTime=='11am to 12pm') echo 'selected'; ?>> 11.00am - 12.00pm </option>
					<option value="12pm to 1pm" <?php if($PickupTime=='12pm to 1pm') echo 'selected'; ?>> 12.00pm - 01.00pm </option>
					<option value="3pm to 5pm" <?php if($PickupTime=='3pm to 5pm') echo 'selected'; ?>> 03.00pm - 05.00pm </option>
					<option value="5pm to 7pm" <?php if($PickupTime=='5pm to 7pm') echo 'selected'; ?> > 05.00pm - 07.00pm </option>
				</select>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Delivery Date : </label>

				<div class="col-sm-9">
					<input type="date" name="delivery_date" id="delivery_date" class="form-control" value="<?php echo $DeliveryDate; ?>" />
				</div>
			</div>

		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="paidby"> Delivery Time  : </label>

				<div class="col-sm-9">
					<select class="form-control" name="delivery_time" id="delivery_time">
					<option value="10am to 11am" <?php if($DeliveryTime=='10am to 11am') echo 'selected'; ?>> 10.00am - 11.00am </option>
					<option value="11am to 12pm" <?php if($DeliveryTime=='11am to 12pm') echo 'selected'; ?>> 11.00am - 12.00pm </option>
					<option value="12pm to 1pm" <?php if($DeliveryTime=='12pm to 1pm') echo 'selected'; ?>> 12.00pm - 01.00pm </option>
					<option value="3pm to 5pm" <?php if($DeliveryTime=='3pm to 5pm') echo 'selected'; ?>> 03.00pm - 05.00pm </option>
					<option value="5pm to 7pm" <?php if($DeliveryTime=='5pm to 7pm') echo 'selected'; ?>> 05.00pm - 07.00pm </option>
				</select>
				</div>
			</div>

		<?php } ?>

			<!-- <input type="hidden" name="auto_id" -->

					
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
		
	