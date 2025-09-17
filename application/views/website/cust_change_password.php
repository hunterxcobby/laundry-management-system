<?php require("header.php"); $WebCustId=$this->session->userdata('cust_id'); ?>	 

<!-- /breadcrumb  -->
	<div class="page-content">
		
		<div class="two-columns">
			<div class="container"> 
				<div class="row"> 
					<div class="col-md-4 col-lg-3"> <br/> <br/>
					<?php include("myacc_leftmenu.php"); ?>
					<div class="divider-lg visible-xs"></div>
					<div class="col-md-8 col-lg-9">
						<div class="table-title"> <i class="glyphicon glyphicon-edit"></i> &nbsp; CHANGE PASSWORD   </div>
						
			
			<form  name="passwordForm" id="passwordForm" method="post" novalidate="novalidate"  action="<?php echo base_url();?>index.php/website/password_change/<?php echo $WebCustId; ?>" > 
			
			
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Old Password : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="password" name="oldpass" id="oldpass" class="form-control" placeholder="Old Password" value="" required >
					</div>
					
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> New Password : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="password" name="newpass" id="newpass" class="form-control" placeholder="New Password" value="" required >
					</div>
					
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Confirm Password : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="password" name="repass" id="repass" class="form-control" placeholder="Confirm Password" value="" required >
					</div>
					
				</div>
			</div>
			
						
			
			
			
			 <hr/> 
			 
			<div class="text-center">
				<input class="btn btn-success btn-top" type="submit" name="submit" style="padding:15px;" value="UPDATE DETAILS"> 
			</div>
			<hr/>
		</form>
	
				
		</div>
				</div>
			</div>
		</div>
	</div>
	
	</div>
	
<?php require("footer.php");	 ?>

<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>web/external/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/slick/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/waypoints/jquery.waypoints.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/countto/jquery.countTo.js"></script>
	<script src="<?php echo base_url(); ?>web/external/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap-datetimepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/form/jquery.form.js"></script>
	<script src="<?php echo base_url(); ?>web/external/form/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesw263ius7OmFcr2A9w4FO7uK5xhQbgY"></script>
	<script src="<?php echo base_url(); ?>web/js/main.js"></script>
<script type="text/javascript">
		// validate contact form
		$(function () {
			$('#passwordForm').validate({
				rules: {
					oldpass: {
						required: true
					},
					newpass: {
						required: true
					},
					repass: {
						required: true,
						equalTo : "#newpass"
					}
					
					
				},
				messages: {
					oldpass: {
						required: "Please Enter sOld Password"
					},
					newpass: {
						required: "Please Enter New Password"
					},
					repass: {
						required: "Please Enter Confirm Password"
					}
					
				}
			});
		});
</script>		