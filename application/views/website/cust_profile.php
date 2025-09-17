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
						<div class="table-title"> <i class="glyphicon glyphicon-user"></i> &nbsp; PROFILE   </div>
						
			
			<form  name="profileForm" id="profileForm" method="post" novalidate="novalidate"  action="<?php echo base_url();?>index.php/website/profile_update/<?php echo $WebCustId; ?>" > 
			
			<?php
						$this->db->where("id",$WebCustId);
						$this->db->order_by("id","desc");
						$CurrentUsrSql = $this->db->get('users');
			
						//$this->db->query("SELECT * FROM customer_order WHERE customer_id='$WebCustId' AND order_status!='cancelled' order by auto_id desc"); $sr=1; 
						
			foreach($CurrentUsrSql->result() as $userrow ) :
			?>						
						
			
			<div class="form-row">
				<hr/>
				<div class="form-row-label"> <strong> User ID: </strong><span class="required">*</span></div>
				
				 <div class="form-row-group">
					<div class="form-control--100">
						<input type="text" name="custid" class="form-control" placeholder="Customer ID" value="<?php echo $userrow->id; ?>" disabled >
					</div>
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Joining Date : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="text" name="joindate" class="form-control" placeholder="Join Date" value="<?php echo date('d-M-Y',strtotime($userrow->join_date)); ?>" disabled >
					</div>
					
				</div>
			</div>
			
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> First Name : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $userrow->first_name; ?>" required >
					</div>
					
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Last Name : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $userrow->last_name; ?>" required >
					</div>
					
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Mobile : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="text" name="mobile" class="form-control" placeholder="Mobile" value="<?php echo $userrow->mobile; ?>" required >
					</div>
					
				</div>
			</div>
			
			<div class="form-row">	
				<div class="form-row-label"> <strong> Email ID : </strong><span class="required">*</span></div>
					
				<div class="form-row-group">
					<div class="form-control--100">
						<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $userrow->email_id; ?>" required >
					</div>
					
				</div>
			</div>
			
			
			
			
			 
			<?php endforeach; ?>
			
			
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
			$('#profileForm').validate({
				rules: {
					firstname: {
						required: true
					},
					lastname: {
						required: true
					},
					mobile: {
						required: true
					},
					email: {
						required: true
					},
					
					
				},
				messages: {
					firstname: {
						required: "Please Enter First Name"
					},
					lastname: {
						required: "Please Enter Last Name"
					},
					mobile: {
						required: "Please Enter Mobile"
					},
					email: {
						required: "Please Enter Email"
					}
					
				}
			});
		});
</script>		