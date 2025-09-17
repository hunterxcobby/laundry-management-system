<?php require_once("header.php"); ?>


<div class="page-content">
		<div class="container">
			<h1 class="title-underline">Login / Register </h1>
			<div class="row">
				
						<div class="col-sm-5 col-md-5 col-lg-5">
									                                     
							<hr style=" border-top: 1px solid red; ">	  			
				
							<form id="loginform" class="boxed-form" name="loginform" method="post" action="<?php echo base_url();?>index.php/website/chklogin" >
			  
									  <div class="form-group">
										 <label class="control-label">Mobile or Email </label>
										 <input class="form-control" type="text" value="" name="email_mobile" style="color: #5cb85c;" required autofocus >
									  </div>
								
									<!--  <div class="form-group">
										 <label class="control-label">Password</label>
										 <input class="form-control" type="password" value="" name="password" style="color: #5cb85c;" required >
									  </div>
								   -->
								  
								  <input class="btn btn-default btn-green" type="submit" name="login" value="Login" >
								
								</form> <br/>
								<a href="<?php echo base_url();?>index.php/website/forgotpass"> Forgot Password </a> 
								
							<hr style=" border-top: 1px solid red; ">	  			
                  		</div>
						
						<div class="col-sm-1 col-md-1 col-lg-1">
						<center style="margin-top:170px;font-size:25px;font-weight:bold;"> OR </center>
						</div>
						<div class="col-sm-5 col-md-5 col-lg-5">
									                                     
							<hr style=" border-top: 1px solid red; ">	  			
				
							<form id="registerform" class="boxed-form" name="contactform" method="post" action="<?php echo base_url();?>index.php/website/register" >
                      <div class="row">
                          <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                  <label class="control-label">First Name</label>
                                  <input class="form-control" type="text" value="" name="first_name" style="color: #428bca;" required >
                              </div>
                          </div>
                          <div class="col-md-12 col-lg-12">
                               <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input class="form-control" type="text" value="" name="last_name" style="color: #428bca;">
                                </div>
                          </div>
                      </div>
					  
					  <div class="row">
                          <div class="col-md-12 col-lg-12">
                              <div class="form-group">
									<label class="control-label">Mobile</label>
									<input class="form-control" type="text" value="" name="mobile" style="color: #428bca;" required >
                              </div>
                          </div>
                          <div class="col-md-12 col-lg-12">
                               <div class="form-group">
                                   <label class="control-label">E-mail</label>
									<input class="form-control" type="email" value="" name="email" style="color: #428bca;" required>
                                </div>
                          </div>
                      </div>
					  
                                           
                       <input class="btn btn-default btn-blue"  type="submit" name="register" value="Register">
                  </form> 
						
								
							<hr style=" border-top: 1px solid red; ">	  			
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