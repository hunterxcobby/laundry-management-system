<?php require_once("header.php"); ?>
<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Settings</a>
							</li>

							<li>
								<a href="#">Bulk Email </a> <?php echo "( " . date('j-M-Y h:i A') ." )"; ?>
							</li>
							
						</ul><!-- /.breadcrumb -->

						<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
					</div>

					
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								Gmail Settings 
								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="clearfix">
									

									
								</div>

								<?php foreach($bulkmsg->result() as $bulkrow):    ?>
								
								<div class="">
										<form class="form-horizontal " id="user-form" method="post" action="<?php echo base_url();?>index.php/admin/bulk_sms_email_update" enctype="multipart/form-data" >
										
																				
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="smtp_protocol"> Email Protocol : </label>

											<div class="col-sm-9">
												<input type="text" name="smtp_protocol" id="smtp_protocol" class="form-control"  value="<?php echo $bulkrow->protocol; ?>" autofocus/>
											</div>
										</div>
										
																				
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="smtp_host"> Email Host : </label>

											<div class="col-sm-9">
												<input type="text" name="smtp_host" id="smtp_host" class="form-control"  value="<?php echo $bulkrow->smtp_host; ?>" autofocus/>
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="smtp_port"> Email Port : </label>

											<div class="col-sm-9">
												<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php echo $bulkrow->smtp_port; ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="smtp_user"> Email ID : </label>

											<div class="col-sm-9">
												<input type="email" name="smtp_user" id="smtp_user" class="form-control"  value="<?php echo $bulkrow->smtp_user; ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="smtp_pass"> Email Password : </label>

											<div class="col-sm-9">
												<input type="password" name="smtp_pass" id="smtp_pass" class="form-control"  value="<?php echo $bulkrow->smtp_pass; ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="mailtype"> Email Type : </label>

											<div class="col-sm-9">
												<input type="text" name="mailtype" id="mailtype" class="form-control"  value="<?php echo $bulkrow->mailtype; ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="charset"> Email Charset : </label>

											<div class="col-sm-9">
												<input type="text" name="charset" id="charset" class="form-control"  value="<?php echo $bulkrow->charset; ?>" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="limit"> Email Limit : </label>

											<div class="col-sm-9">
												<input type="text" name="limit" id="limit" class="form-control"  value="<?php echo $bulkrow->limit; ?>" />
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
										<?php endforeach; ?> 
									</div>	
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			
			

<?php require_once("footer.php"); ?>
	
		



		

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
		<script src="<?php echo base_url();?>assets/js/buttons.pdf.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf_font.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>
		
		
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/spinbox.min.js"></script>
		
		
		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
			
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					
				}
				
				
				
			})
		</script>
		
	</body>
</html>