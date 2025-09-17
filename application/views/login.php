<?php
$language = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_lang;	
$this->session->set_userdata('site_lang', $language);
?>
<?php $title=$this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page - Laundry Management System</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url();?>assets/js/html5shiv.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<!--
    <center>	
	<select onchange="javascript:window.location.href='<?php echo base_url(); ?>index.php/LanguageSwitcher/switchLang/'+this.value;">
    <option value="english" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>English</option>
	<option value="french" <?php if($this->session->userdata('site_lang') == 'french') echo 'selected="selected"'; ?>>French</option>
	  <option value="arebic" <?php if($this->session->userdata('site_lang') == 'arebic') echo 'selected="selected"'; ?>>Arebic</option>  
    <option value="hindi" <?php if($this->session->userdata('site_lang') == 'hindi') echo 'selected="selected"'; ?>>Hindi</option>   
</select>
	</center> -->

	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
								
										<span class="red"><img src="<?php echo base_url();?>assets/images/logo.png" style="height:100px;width:375px;overflow:auto;"></span>
									</h1>
							</div>

							
							<div class="position-relative" style="margin-top:-8px;">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												<?php echo $this->lang->line('adminl'); ?>
											</h4>
											<?php echo $this->session->flashdata('msg'); ?>
											<div class="space-6"></div>

											<form name="login-form" method="post" action="<?php echo base_url();?>index.php/login/redirect">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="username" id="username" placeholder="<?php echo $this->lang->line('username'); ?>" value="" autocomplete="off"  required autofocus/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $this->lang->line('password'); ?>" value="" required />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> <?php echo $this->lang->line('remberme'); ?></span>
														</label>

														<input type="submit" class="width-35 pull-right btn btn-sm btn-primary" value="<?php echo $this->lang->line('login'); ?>" name="login" >
															
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
											
										<!-- 	<div class="social-or-login center">
												<span class="bigger-110">Login Details </span>
											</div>

											<div class="space-6"></div>

											<div class="social-login center">
												admin :  admin &  password : 1234 </br> <br/>
										 -->	
											</div> 
											

											
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="/" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													<?php echo $this->lang->line('backhome'); ?>
												</a>
											</div>

											<div>
												<a href="#" data-target="#forgot-box" class="user-signup-link">
													<?php echo $this->lang->line('forgotpass'); ?>
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												<?php echo $this->lang->line('retrive'); ?>
											</h4>

											<div class="space-6"></div>
											<p>
												<?php echo $this->lang->line('email'); ?>
											</p>

											<form name="login-form" method="post" action="<?php echo base_url();?>index.php/login/forgotpasswd">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="<?php echo $this->lang->line('emailid'); ?>" name="email" required />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<input type="submit" class="width-35 pull-right btn btn-sm btn-danger" value="<?php echo $this->lang->line('sendme'); ?>" name="Sendme" >
														
														
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												<?php echo $this->lang->line('backhome'); ?>
												
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								</div><!-- /.position-relative -->
							
							<span class="">
								<div class="space-6"></div>
								<center>
								<span class="blue bolder"> <?php echo 'Laundry Management System &copy 2017 - '.date('Y'); ?> <a href="#" target="_blank"> <br/> <span style='color:red;'> Corporate Laundry Solutions. </span> </a>
							</center> 
							</span>
							

							

							
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
		window.onload = function () {
			if (! localStorage.justOnce) {
				localStorage.setItem("justOnce", "true");
				window.location.reload();
			}
		}

			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
		</script>	
	</body>
</html>
