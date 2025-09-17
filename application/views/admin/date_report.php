	
	<div class="">
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
		echo form_open('admin/reports/date_report',$attributes); ?>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="from_date"> From Date : </label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control date-picker" name="from_date" id="from_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('j-m-Y') ?>" required />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="to_date"> To Date : </label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control date-picker" name="to_date" id="to_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('j-m-Y') ?>" required />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>
			

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Submit &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			
		</form>
	</div>
	
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
								
							
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				
			
			})
		</script>
		
		