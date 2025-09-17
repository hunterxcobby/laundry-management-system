<?php require("header.php"); $WebCustId=$this->session->userdata('cust_id'); ?>	 

<link href="<?php echo base_url();?>material/css//ship.css" type="text/css" rel="stylesheet">
<!-- /breadcrumb  -->
	<div class="page-content">
		
		<div class="two-columns">
			<div class="container"> 
				<div class="row"> 
					<div class="col-md-4 col-lg-3"> <br/> <br/>
					<?php include("myacc_leftmenu.php"); ?>
					<div class="divider-lg visible-xs"></div>
					<div class="col-md-8 col-lg-9">
						<div class="table-title"> <i class="glyphicon glyphicon-map-marker"></i> &nbsp; ADDRESS   </div>
						
			
			<form  name="addressForm" id="addressForm" method="post" novalidate="novalidate"  action="<?php echo base_url();?>index.php/website/address_update/<?php echo $WebCustId; ?>" > 
			
			<?php
						$this->db->where("id",$WebCustId);
						$this->db->order_by("id","desc");
						$CurrentUsrSql = $this->db->get('users');
			
						//$this->db->query("SELECT * FROM customer_order WHERE customer_id='$WebCustId' AND order_status!='cancelled' order by auto_id desc"); $sr=1; 
						
						foreach($CurrentUsrSql->result() as $userrow ) :
			?>						
						
			
			<div class="form-row">
				<hr/>
				<div class="form-row-label"> <strong> Address : </strong><span class="required">*</span></div>
				
				 <div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="address1" class="form-control" placeholder="Address1" value="<?php echo $userrow->address1; ?>" required autofocus >
					</div>
					
					<div class="form-control--50">
						<input type="text" name="address2" class="form-control" placeholder="Address2" value="<?php echo $userrow->address2; ?>" required >
					</div>
					
				</div>
			
			 <div class="form-row">
				<div class="form-row-label"> </div>
				 <div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $userrow->city; ?>" required >
					</div>
					
					<div class="form-control--50">
						<input type="text" name="state" class="form-control" placeholder="State" value="<?php echo $userrow->state; ?>" required >
					</div>
					
				</div>
			 </div>	
			 
			 <div class="form-row">
				<div class="form-row-label"> </div>
				 <div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $userrow->zipcode; ?>" maxlength='6' >
					</div>
					
					<div class="form-control--50">
						<input type="text" name="state" class="form-control" placeholder="State" value="<?php echo $sys_map_pos = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_currency; ?>" required disabled >
					</div>
					
				</div>
			 </div>	
			 <hr/> 
			 
			 <div class="form-row-label"> <strong> Map Location : </strong><span class="required">*</span></div>
				<div class="form-row-group">
					<div class="form-control--100">
						<?php echo $mapcust['html']; ?>
						<input type="hidden" name="custmap" id="custmap" class="form-control"  value="<?php echo $userrow->cust_map_pos;?>" />
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
			$('#addressForm').validate({
				rules: {
					address1: {
						required: true,
						minlength: 5
					},
					address2: {
						required: true,
						minlength: 5
					},
					city: {
						required: true
					},
					state: {
						required: true
					},
					
					zipcode: {
						required: true,
						minlength: 6
					},
				},
				messages: {
					address1: {
						required: "Please Enter Addres Line 1"
					},
					address2: {
						required: "Please Enter Addres Line 2"
					},
					city: {
						required: "Please Enter City Name"
					},
					state: {
						required: "Please Enter State"
					},
					zipcode: {
						required: "Please Enter Zipcode",
						minlength: "Your zipcode must consist of at least 6 numbers"
					}
					
				}
			});
		});
</script>	

<?php echo $mapcust['js']; ?>	

	