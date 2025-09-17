<?php require_once("header.php"); ?>


<div class="page-content">
		<div class="container">
			<h1 class="title-underline">Forgot Password </h1>
			<div class="row">
				
				<div class="col-sm-7 col-md-8 col-lg-7 col-lg-offset-3">
					<!-- form-block -->
					<form id="forgotpass" class="boxed-form" name="forgotpass" method="post" action="<?php echo base_url();?>index.php/website/forgot_pass_sms">
						
						
						<div class="form-group ">
							<label class="control-label"> E-Mail or Mobile </label>
							<input class="form-control" type="text" value="" name="email_mob" required>
						</div>
						
						<button class="btn btn-default btn-top" type="submit" id="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<div class="container-fluid content">

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
	<script src="<?php echo base_url(); ?>web/js/main.js"></script>
</body>


</html>