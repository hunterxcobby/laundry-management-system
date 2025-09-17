<?php require_once("header.php"); ?>


<div class="page-content">
		<div class="container">
			<h1 class="title-underline">Contact Us</h1>
			<div class="row">
				<div class="col-sm-5 col-md-4 col-lg-4">
					<div class="contact-box-01">
						<h6 class="title">Our address:</h6>
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add1; ?> <br/>
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add2; ?><br/>
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_city; ?>, 	
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_state; ?> -
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_zip; ?>
					</div>
					<div class="contact-box-02">
						<h6 class="title">Call us:</h6> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_phone; ?> / <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_mobile; ?>
					</div>
					<div class="contact-box-03">
						<h6 class="title">Have any questions?</h6>
						<a href="#">noreply@<?php echo strtolower(str_replace(' ', '', $TITLE));?>.com</a>
						<br>
						<a href="#">www.<?php echo strtolower(str_replace(' ', '', $TITLE));?>.ae</a>
					</div>
					<ul class="social-icon-content">
						<li>
							<a href="#" class="icon-facebook-logo"></a>
						</li>
						<li>
							<a href="#" class="icon-twitter-logo-silhouette"></a>
						</li>
						<li>
							<a href="#" class="icon-instagram-social-network-logo-of-photo-camera"></a>
						</li>
						<li>
							<a href="#" class="icon-linkedin-logo"></a>
						</li>
					</ul>
				</div>
				<div class="col-sm-7 col-md-8 col-lg-7 col-lg-offset-1">
					<!-- form-block -->
					<form id="contactform" class="boxed-form" name="contactform" method="post" novalidate="novalidate">
						<div id="success">
							<p>Your message was sent successfully!</p>
						</div>
						<div id="error">
							<p>Something went wrong, try refreshing and submitting the form again.</p>
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label class="control-label">Name</label>
									<input class="form-control" type="text" value="" name="name">
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label class="control-label">Phone</label>
									<input class="form-control" type="text" value="" name="phone">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">E-mail</label>
							<input class="form-control" type="text" value="" name="email">
						</div>
						<div class="form-group">
							<label class="control-label">Message</label>
							<textarea class="form-control" rows="10" name="message"></textarea>
						</div>
						<button class="btn btn-default btn-top" type="submit" id="submit">SEND MESSAGE</button>
					</form>
				</div>
			</div>
		</div>
		<div class="container-fluid content">
		
			<div id="map"> </div>
		</div>
	</div>
			
<?php require_once("footer.php");	 ?>

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
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEFYIO_1AEeQUVrSktxbMWSh4VCwBBhdw"></script>
	<script src="<?php echo base_url(); ?>web/js/main.js"></script>
	<script type="text/javascript">
		// validate contact form
		$(function () {
			$('#contactform').validate({
				rules: {
					name: {
						required: true,
						minlength: 2
					},
					email: {
						required: true,
						email: true
					},
				},
				messages: {
					name: {
						required: "Please enter your name",
						minlength: "Your name must consist of at least 2 characters"
					},
					email: {
						required: "Please enter your email"
					}
				},
				submitHandler: function (form) {
					$(form).ajaxSubmit({
						type: "POST",
						data: $(form).serialize(),
						url: "contact-form.php",
						success: function () {
							$('#success').fadeIn();
							$('#contactform').each(function () {
								this.reset();
							});
						},
						error: function () {
							$('#contactform').fadeTo("slow", 0, function () {
								$('#error').fadeIn();
							});
						}
					});
				}
			});
		});
	</script>