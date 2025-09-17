	<footer class="offset-top0">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<a class="logo-footer" href="index-2.html"><img src="<?php echo base_url(); ?>web/images/logo_footer.png" alt=""></a>
				</div>
				<div class="col-md-9">
					<div class="row footer-separator">
						<div class="col-md-8 col-lg-9">
							<!-- promo  -->
							<div class="promo-footer">
								<span class="text-1">Get Started Today!</span>
								<span class="text-2"><?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_phone; ?></span>
							</div>
							<!-- /promo -->
						</div>
						<div class="col-md-4 col-lg-3">
							<!-- social-icon -->
							<ul class="social-icon-footer">
								<li>
									<a href="#" class="icon-facebook-logo"></a>
								</li>
								<li>
									<a href="#" class="icon-twitter-logo-silhouette"></a>
								</li>
								<li>
									<a href="#" class="icon-instagram-social-network-logo-of-photo-camera"></a>
								</li>
							</ul>
							<!-- /social-icon -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-2 hidden-sm hidden-xs  pull-right">
					<!-- footer-link -->
					<ul class="footer-link">
						<li><a href="#">Terms and Conditions</a></li>
						<li><a href="<?=base_url()?>index.php/website/privacy">Privacy Policy</a></li>
					</ul>
					<!-- /footer-link -->
				</div>
				<div class="col-xs-12 col-md-4 col-lg-4 pull-right">
					<!-- time-table -->
					<div class="time-table">
						Daily : 8:00am-01:00pm
						<br> Daily : 4.00pm-10.00pm.
					</div>
					<!-- /time-table -->
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3 pull-right">
					<!-- box-location -->
					<div class="box-location">
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add1; ?> <br> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add2; ?> <br/> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_city; ?>, <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_state; ?> - <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_zip; ?>
					</div>
					<!-- /box-location -->
				</div>
				<div class="col-xs-12 col-md-3 col-lg-3">
					<!-- copyright-box -->
					<div class="copyright-box">
						&copy; 2017 <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?>
					</div>
					<!-- /copyright-box -->
				</div>
				<div class="col-xs-12 col-md-3 col-lg-2 visible-sm visible-xs pull-right">
					<!-- footer-link -->
					<ul class="footer-link">
						<li><a href="<?=base_url()?>/index.php/website/privacy">Terms and Conditions</a></li>
						<li><a href="<?=base_url()?>/index.php/website/privacy">Privacy Policy</a></li>
					</ul>
					<!-- /footer-link -->
				</div>
			</div>
		</div>
		<div class="bubbleContainer"></div>
	</footer>
	
	<div class="modal fade" id="login" role="dialog">
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
                  		
									<form id="loginform" class="boxed-form" name="loginform" method="post" action="<?php echo base_url();?>index.php/website/chklogin" >
                      
											  <div class="form-group">
												 <label class="control-label">Mobile or Email </label>
												 <input class="form-control" type="text" value="" name="email_mobile" style="color: #5cb85c;" required autofocus >
											  </div>
										
											 <!-- <div class="form-group">
												 <label class="control-label">Password</label>
												 <input class="form-control" type="password" value="" name="password" style="color: #5cb85c;" required >
											  </div>
										   -->
										  
										  <input class="btn btn-default btn-green" type="submit" name="login" value="Login" >
										
										</form> <br/>
										<a href="<?php echo base_url();?>index.php/website/forgotpass"> Forgot Password </a> 
										
									<hr style=" border-top: 1px solid red; ">	  			
                  
				  
									</div>
							</div>				
						
						</div>
						</div>
			</div>		
				
				
			</div>
		</div>
	
	<div class="modal fade" id="Register" role="dialog">
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
									<input class="form-control" type="email" value="" name="email" style="color: #428bca;" >
                                </div>
                          </div>
                      </div>
					  
                                           
                       <input class="btn btn-default btn-red"  type="submit" name="register" value="Register">
                  </form> 
						
				  <hr style=" border-top: 1px solid red; ">	  			
                  
				  
				 </div>
				</div>				
						
			  </div>
			</div>
		</div>		
				
	 </div>
</div>

	
<div id="modalOrder" class="zoom-anim-dialog white-popup">
		<div class="text-center">
			<h2>Order Form</h2></div>
		<form id="orderOnline" class="boxed-form" name="orderOnline" method="post" action="<?php echo base_url();?>index.php/website/orderOnlineConfirm" >
			<div id="success">
				<p>Your message was sent successfully!</p>
			</div>
			<div id="error">
				<p>Something went wrong, try refreshing and submitting the form again.</p>
			</div>
			
			<?php
			if($this->session->userdata('cust_id')=="")
				{	date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
			?>	
			<div class="form-row">
				<div class="form-row-label">Name <span class="required">*</span></div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="firstname" class="form-control" placeholder="First Name">
					</div>

					<div class="form-control--50">
						<input type="text" name="lastname" class="form-control" placeholder="Last Name">
					</div>
				</div>
			</div>
			<!--
			<div class="form-row">
				<div class="form-row-label">Address <span class="required">*</span></div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="street1" class="form-control" placeholder="Street Address 1">
					</div>
					<div class="form-control--50">
						<input type="text" name="street2" class="form-control" placeholder="Street Address Line 2">
					</div>
				</div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="city" class="form-control" placeholder="City">
					</div>
					
					<div class="form-control--50">
						<input type="text" name="postal" class="form-control" placeholder="Postal / Zip Code">
					</div>
				</div>
			</div>
			-->
			<div class="form-row">
				<div class="form-row-label">Contact <span class="required">*</span></div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number">
					</div>
				
				<div class="form-control--50">
					<input type="text" name="email" id="email" class="form-control " placeholder="Email">
				</div>
				
			</div>
			
			
			<?php
			}
			?>
			
			<div class="form-row">
				<div class="form-row-group--date">
					<div class="form-row-label">Pick-Up Date</div>
					<div class="form-row-group">
						<div class="datetimepicker-wrap">
							<input type="text" name="pickup_date" id="pickup_date" class="form-control datetimepicker" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-row-group--time">
					<div class="form-row-label">Pickup Time </div>
					<div class="form-row-group">
					<select class="form-control" name="picktime" id="picktime">
						<option value="8am to 1pm"> 8.00am - 1.00am </option>
						<option value="4pm to 10pm"> 4.00pm - 10.00pm </option>
						
					</select>
					</div>
				</div>
			</div>
			<!--
			<div class="form-row">
				<div class="form-row-group--date">
					<div class="form-row-label">Delivery Date </div>
					<div class="form-row-group">
						<div class="datetimepicker-wrap">
							<input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-row-group--time">
					<div class="form-row-label">Delivery Time</div>
					
					<div class="form-row-group">
					<select class="form-control" name="deliverytime" id="deliverytime">
						<option value="9-11"> 09.00am - 11.00am </option>
						<option value="11-1"> 11.00am - 01.00pm </option>
						<option value="1-3"> 01.00pm - 03.00pm </option>
						<option value="3-5"> 03.00pm - 05.00pm </option>
						<option value="5-7"> 05.00pm - 07.00pm </option>
					</select>
					</div>
				</div>
			</div>
			-->
			<div class="form-row">
				 <div class="form-row-label"> Select Service </div>
				 <div class="form-row-group">
					<div class="form-control--50">
					<select name="selservice[]" class="form-control" multiple="multiple" title="ctrl+click select multiple" style="height:100px;" required>
					<?php 
					$this->db->order_by("priority");
					$Service=$this->db->get('services'); 
					foreach($Service->result() as $srow) : ?>
						<option value="<?php echo $srow->service_name; ?>"> <?php echo $srow->service_name;?> </option>
					<?php endforeach; ?>	
					</select>
				    </div>
					<div class="form-control--50">
						<input type="number" name="appx_qty" id="appx_qty" class="form-control" placeholder="Quanity or KG" step="0.1" min="1">
					</div>
				</div>	
			</div>
			
			<div class="form-row">
				<div class="form-row-label"> Order Type </div>
				<div class="form-row-group">
					<div class="form-control--50">
					<select name="order_type" class="form-control" >
						<option value="Regular"> Regular [2-3 days] </option>
						<option value="Express"> Express(10% extra) [24-48 hrs] </option>
					</select>
					</div>
					
					<div class="form-control--30">
					<input type="text" name="promocode" id="promocode" class="form-control" placeholder="Coupon Code" > 
					</div>
					<div class="form-control--10" style="margin-top:10px;"> 
					<a href="#" style="margin-left:15px; color:white; padding:12px; background:#428bca;" id="chk_promo" >   &nbsp; &nbsp; Apply &nbsp; &nbsp; </a>
					<br/><br/> 
							<span id="wrong_code" style='color:red;'></span>
                            <span id="right_code" style='color:green;'></span>
					
					</div>
				</div>
			</div>
			<?php 
			$WebCustId=$this->session->userdata('cust_id'); 
			$Add1=$this->db->get_where('users' , array('id' => $WebCustId))->row()->address1;
			$Add2=$this->db->get_where('users' , array('id' => $WebCustId))->row()->address2;
			$City=$this->db->get_where('users' , array('id' => $WebCustId))->row()->city;
			$ZipCode=$this->db->get_where('users' , array('id' => $WebCustId))->row()->zipcode;
			
			if($Add1=="") $Action="Add Address"; else $Action="Edit Address";
			?>
			<div class="form-row">
				<div class="form-row-label">Address <span class="required">*</span> 
				<!--<a href='<?php echo base_url();?>index.php/website/myaddress' style="color:purple;font-size:12px;"> [ <?php  echo $Action; ?> ] </a> -->
				</div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="address1" class="form-control" placeholder="Address 1" value="<?php echo $Add1; ?>" required >
					</div>
					<div class="form-control--50">
						<input type="text" name="address2" class="form-control" placeholder="Address 2" required  value="<?php echo $Add2; ?>" >
					</div>
				</div>
				<div class="form-row-group">
					<div class="form-control--50">
						<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $City; ?>" required  >
					</div>
					
					<div class="form-control--50">
						<input type="text" name="zipcode" class="form-control" placeholder="Postal / Zip Code" value="<?php echo $ZipCode; ?>" required >
					</div>
				</div>
			</div>
			
			
			
			<div class="form-row">
				<div class="form-row-label"> Special Instructions </div>
				<div class="form-row-group">
									
					<div class="form-control--100">
					<input type="text" name="special" class="form-control" placeholder="Remarks: Wash whites with hot water">
					</div>
				</div>
			</div>	
			
            <div class="text-center" style="color:#C62502;"> Note : If order place & pickup time before 12 pm then you will get cloths on the same day </div>
			<div class="text-center">
				 <input type="hidden" value="From Website" name="order_from"> 
				 <input type="hidden" value="" name="chkpromo" id="chkpromo" > 
				 <input class="btn btn-default btn-green"  type="submit" name="order" value="Submit Order">
			</div>
		</form>
	</div>
	
	<script src="<?php echo base_url(); ?>web/external/jquery/jquery.min.js"></script>
		
	<script language="javascript" type="text/javascript">
	$(document).ready(function() {

		$('#chk_promo').on( "click", function() {
				if($.trim($('#promocode').val()) == ''){
					alert('Please enter a valid Coupon Code');
					$("span#wrong_code").html('');
					$("span#right_code").html('');
					return false;
				}
				else
				{	
					$.ajax({ 
					url: "<?php echo base_url();?>index.php/website/promoCode",
					type: "POST",
					data: {promocode: $("input#promocode").val()},
					success: function(data) { 
						if (data == 'FALSE') {
							$("span#wrong_code").html('Please enter a valid Coupon Code');
							$("span#right_code").html('');
							$('#chkpromo').val('0');
							
						}
						else if (data == 'USED') {
							$("span#wrong_code").html('Sorry!!! Coupon already used');
							$("span#right_code").html('');
							$('#chkpromo').val('0');
						}
						else
						{	$("span#right_code").html('Coupon Code applied successfully');
							$("span#wrong_code").html('');
							$('#chkpromo').val('1');
						}
					},
					 error: function() {
						alert('Error occurs!');
					}
					
					});	
				}	
		});

	   
		 });
    </script>

	
	