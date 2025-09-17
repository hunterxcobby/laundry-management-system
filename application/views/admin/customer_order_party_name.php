<?php 
require_once("header.php"); 
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Job Order</a>
				</li>
				<li class="active">Select Customer Name </li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					Job Order
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						Customer Management
					</small>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								

								<!-- Tab Contents Starts --> 
								
								<div class="tab-content">
									
									<div id="list" class="tab-pane fade in active">
									<!-- NEW TABLE --> 
									
										<div class="row">
											<div class="col-xs-12">
												
												<div> 
										<form class="form-horizontal" id="session-form" method="post" action="<?php echo base_url();?>index.php/admin/customer_orders/session_partyname" >
										<div class="table-header alert-primary" >
													Customer Name ( New Order )
												</div> <br/>
										
										<div class="form-group">
										
											<label class="col-sm-3 control-label no-padding-right" for="order_date"> Order Date : </label>

											<div class="col-sm-8">
												<div class="input-group">
													<input class="form-control date-picker" name="order_date" id="order_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" />
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="party_name"> Customer Name : </label>

											<div class="col-sm-8">
												<select class="chosen-select form-control" name="party_name" id="party_name" data-placeholder="Choose a Customers..." >
													<option value="">  </option>
													<?php foreach ($partyname->result() as $partnamerow): 
													$PartyName=$partnamerow->first_name." ".$partnamerow->last_name;
													$Mobile=$partnamerow->mobile;
													?>
													
													<?php echo "<option value='$partnamerow->id'>". $PartyName ." - " .$Mobile."</option>"; ?>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-sm-1" style="width:0px;padding:0px;margin-top:0px;">
											 																					
											 <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/direct_cust');" style='text-decoration:none;' title="New Customer">  <span style="font-size:20px; border:1px solid gray;padding:1px;padding-left:5px;padding-right:5px;"> +  </span> </a> </label>
											</div>
										</div>
																				
																			
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<input class="btn btn-primary" type="submit" value=" &nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;">
														
														&nbsp; &nbsp; &nbsp;														
														&nbsp; &nbsp; &nbsp;
													
														
													
												</div>
											</div>
											<span style="color:orange; font-size:11px;"> Note: Click plus (+) to create new customer </span>
										</form>
										
										</div>
									
										</div>
									</div>

						
						
									</div>

									
									</div>	
								<!-- Tab Contents Ends --> 
										
							
						</div><!-- /.col -->

						
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						


<?php require_once("footer.php"); ?>

		<!-- Order Model -->
		
		<script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo "New Customer : "; ?></h4>
                </div>
                
                <div class="modal-body" style="height:450px; overflow:auto;">
                
                    
                    
                </div>
               
            </div>
        </div>
    </div>
	
	
		
		

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/spinbox.min.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>

		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
			
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			
			jQuery(function($) {
				//initiate dataTables plugin
				
				
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true,search_contains:true}); 
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
				
				
				$('#session-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
						
						
						party_name: {
							required: true,
							price: 'required'
						}
											
					},
			
					messages: {
						
						party_name: "Please Select Customer Name."
						
						
					},
			
			
					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},
			
					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},
			
					submitHandler: function (form) {
					},
					invalidHandler: function (form) {
					}
				});
				
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
		
	</body>
</html>