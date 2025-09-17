<?php echo $sysmap['js']; ?>

<?php include('system_currency.php'); ?>
<?php require_once("header.php"); ?>	
	
<div class="main-content">
				<div class="main-content-inner">
					
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								Order Management 
								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="clearfix">
									

									
								</div>
						

	
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
		echo form_open('employee/update_order',$attributes); 
		
		?>
			
			<?php foreach ($custdata->result() as $row): ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Customer Name : </label>

				<div class="col-sm-6">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $row->first_name . $row->last_name;?>" />
				</div>
			</div>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Customer Mobile : </label>

				<div class="col-sm-6">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo $row->mobile; ?>" />
				</div>
			</div>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Customer Address : </label>

				<div class="col-sm-6">
					<?php $address = $row->address1 . PHP_EOL . $row->address2 . PHP_EOL . $row->city ."-" . $row->zipcode ; ?>
					<textarea class="form-control" name="shop_add" id="shop_add" placeholder="Customer Address" disabled><?php echo $address; ?></textarea>
											
					
				</div>
			</div>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Address Map : </label>

				<div class="col-sm-6">
					<?php echo $sysmap['html']; ?>
					<!-- <div id="directionsDiv"></div> -->
				</div>
			</div>
			
			<div class="form-group ">
			<label class="col-sm-3 control-label no-padding-right" for="cloth_id"> </label>
			<div class="col-sm-6">
			
			<table class="table table-striped table-bordered table-hover">
			<tr> <th> Sr. No. </th> <th> Service </th> <th> Type </th> <th> Qty </th> </tr>
			<?php $sr=1; 
				  foreach ($emporderdata->result() as $orderrow): ?>
			<tr> 
				<td> <?php echo $sr; ?> </td> 
				<td> <?php echo $orderrow->order_service; ?> </td>
				<td> <?php echo $orderrow->order_cloth; ?> </td>
				<td> <?php echo $orderrow->order_qty; ?> </td>
				
								
			</tr>	
			<?php $sr++; 
				  endforeach; ?>
			</table>
</div> </div>			
			<?php
			if($totamt!=0)
			{ ?>
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Total Amt : </label>

				<div class="col-sm-6">
					<input type="text" id="cloth_id" class="form-control" required readonly value="<?php echo$sys_curr . $totamt; ?>" />
				</div>
			</div>
			<?php } ?>
			
			<div class="form-group ">
				<label class="col-sm-3 control-label no-padding-right" for="cloth_id">Order Status : </label>

				<div class="col-sm-6">
					<select class="form-control" name="order_status" id="order_status"> 
					<option value="">-- Select --</option>
					<?php 
					if($totamt==0)
					{ echo "<option value='accept'> Picked Up </option>"; 
					}
					else
					{ echo "<option value='delivered'> Delivered </option>";
					}
					?>
				</select>
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
			</div>
			</div>
		</div>	
			
		</form>
	</div>
	<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			
			


	
<?php endforeach; ?>	
	
<?php require_once("footer.php"); ?>	
<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		