<?php require("header.php"); $WebCustId=$this->session->userdata('cust_id'); ?>	 

<link href="<?php echo base_url();?>material/css//ship.css" type="text/css" rel="stylesheet">
<!-- /breadcrumb  -->
	<div class="page-content">
		
		<div class="two-columns">
			<div class="container"> 
				<div class="row"> 
					<div class="col-md-4 col-lg-3"> <br/>
					<?php include("myacc_leftmenu.php"); ?>
					<div class="divider-lg visible-xs"></div>
					<div class="col-md-8 col-lg-9">
						<div class="table-title"> <i class="glyphicon glyphicon-list"></i> &nbsp; ORDER LIST </div>
						
						<hr/>
						<div class="col-lg-12" style="margin-left:-10px;" >
						<?php
						$this->db->where("customer_id",$WebCustId);
						$this->db->order_by("auto_id","desc");
						$OrderListSql = $this->db->get('customer_order');
			
						//$this->db->query("SELECT * FROM customer_order WHERE customer_id='$WebCustId' AND order_status!='cancelled' order by auto_id desc"); $sr=1; 
						
						foreach($OrderListSql->result() as $orderlistrow ) :
						?>						
						<div class="table-row" style=";border-bottom:1px solid #337ab7;" >
							<div class="pull-left" style="margin-top:5px;margin-left:-35px;">
							<b> Order No :  <?php echo $orderlistrow->invoice_no; ?> </b> <br/>
							<b> <small> Order Date : <?php echo date('d-M-Y',strtotime($orderlistrow->order_date)); ?> </small> </b> <br/>
							<b> <small> Total Qty : <?php echo $orderlistrow->total_qty; ?> ( <?php echo $sys_curr; ?> <?php echo $orderlistrow->total_paid; ?> )  </small> </b>
							<!-- <small> Payment Mode : <?php echo $orderlistrow->amt_paidby; ?> </small> <br/>
							<small> Order Status : <?php echo $orderlistrow->order_status; ?> </small> <br/> -->
							
								<br/>	 </br>	
			
		
		<?php
		if($orderlistrow->order_status=="urgent") { $Order="Urgent"; $BackGround="purple;"; } else { $Order="New Order"; $BackGround="";  }   ?>
			<div class="confirm" >
                <div class="imgcircle" style="margin-left:-40px; background:<?php echo $BackGround; ?>" >
                    <img src="<?php echo base_url();?>material/images/confirm.png" alt="confirm order" style="height:20px;width:20px;">
            	</div>
				<span class="line" style="width:80px;margin-left:-10px;background:<?php echo $BackGround; ?>"></span>
				<p style="font-size:12px;margin-left:-70px;"> <?php echo $Order; ?>  </p>
			</div>
			
			<?php if($orderlistrow->order_status=="inprocess" || $orderlistrow->order_status=="delivered" || $orderlistrow->order_status=="done" ) { echo '<div class="process">'; } else { echo '<div class="dispatch">'; } ?> 
			
           	 	<div class="imgcircle" style="margin-left:0px;">
                	<img src="<?php echo base_url();?>material/images/process.png" alt="process order" style="height:20px;width:20px;">
            	</div>
				<span class="line" style="width:20px;"></span>
				<p style="font-size:12px;"> Process </p>
			</div>
			
			<?php if($orderlistrow->order_status=="delivered" || $orderlistrow->order_status=="done" ) { echo '<div class="process">'; } else { echo '<div class="dispatch">'; } ?> 
				<div class="imgcircle" style="margin-left:30px;">
                	<img src="<?php echo base_url();?>material/images/dispatch.png" alt="dispatch product" style="height:20px;width:20px;">
            	</div>
				<span class="line" style="width:50px;margin-left:-20px;"></span>
				<p style="font-size:12px;margin-left:30px;"> Delivered </p>
			</div>
			
			<?php if($orderlistrow->order_status=="done") { echo '<div class="process">'; } else { echo '<div class="dispatch">'; } ?> 
				<div class="imgcircle" style="margin-left:70px;">
                	<img src="<?php echo base_url();?>material/images/delivery.png" alt="delivery" style="height:20px;width:20px;"s>
				</div>
				<span class="line" style="width:80px;"></span>
				<p style="font-size:12px;margin-left:80px;"> Done </p>
			</div>
			
		
		
                     
    </div>	<!-- End Shipping Bar -->
	
							
						
							
							<div class="pull-right" style="margin-top:10px;">
							<?php
							if($orderlistrow->order_status!="neworder" && $orderlistrow->order_status!="pickup"  )
							{ ?>
								
								 <small> <a href="<?php echo base_url();?>index.php/admin/invoicepdf/<?php echo $orderlistrow->auto_id;?>" style="padding:8px; text-decoration:none; border:1px solid lightgray; letter-spacing:0px;">  <i class="glyphicon glyphicon-file"> </i> Invoice </a> </small> &nbsp;

							<?php
								if($orderlistrow->amt_paidby=="notpaid")
								{
								?>
								<small> <a href="#" data-toggle="modal" data-target="#paytm_qr" style="padding:8px; text-decoration:none; border:1px solid lightgray; letter-spacing:0px;">  <i class="glyphicon glyphicon-file"> </i> Payment </a> </small>
								
								<?php	
								}	
							}
								
								$date=$orderlistrow->pickup_date;
								$time=$orderlistrow->pickup_time;
								$OrderDateTime=date('Y-m-d H:i:s', strtotime("$date $time"));
								$CurrentDateTime = date('Y-m-d H:i:s');
								$seconds = strtotime($CurrentDateTime) - strtotime($OrderDateTime);
							if($seconds<120)
							{	
							
								
							?>
								
								<small > <a href="<?php echo $_SERVER['PHP_SELF']; ?>?invoice=<?php echo $orderlistrow->invoice_no; ?>&order=cancel" style="padding:8px; text-decoration:none; border:1px solid lightgray;letter-spacing:.5px;" class="text-danger" onclick="return confirm('Are you sure cancel this order?')">  <i class="glyphicon glyphicon-remove text-danger"> </i> Cancel </a> </small>
						
									
							
							<?php
							}	
							?>
							</div>
		
							
						</div>
						
		
	
						<?php endforeach; ?>
						</div>
						<hr/>
						
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Paytm QR CODE Start -->

<div class="modal fade" id="paytm_qr" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
			  <div class="col-lg-12">
					<div class="form-wrapper">
						<div class="wow fadeInRight" data-wow-duration="2s" data-wow-delay="0.2s">
						
							<div class="panel panel-skin">
								<div class="panel-heading">
									
								</div>
								<div class="panel-body">
									                                     
									<hr style=" border-top: 1px solid red; ">	  			
                  		
									<div> <img src="<?php echo base_url();?>web/paytm_qr.png" />
										
									<hr style=" border-top: 1px solid red; ">	  			
                  
								 </div>
							</div>				
						
							</div>
						</div>
					</div>		
				
			</div>
	</div>
</div>	
	<!-- Modal Paytm QR Code -->

	
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
	