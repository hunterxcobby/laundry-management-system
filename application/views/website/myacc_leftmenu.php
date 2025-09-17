<ul class="category-list-aside">
							<li class="active" style="font-size:10px;"><a href="#"> Welcome, <?php echo $this->db->get_where('users' , array('id' =>$WebCustId))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$WebCustId))->row()->last_name; ?> </a></li>
							
							
							<li ><a href="#modalOrder" class="popup-link"> <i class="glyphicon glyphicon-plus"></i> New Order </a></li>
							
							<!--
							
							<li ><a href="<?php echo base_url();?>index.php/website/offers"><i class="glyphicon glyphicon-tags text-success"></i> offers </a></li> -->
							
							<li ><a href="<?php echo base_url();?>index.php/website/webcust_orderlist"><i class="glyphicon glyphicon-list text-success"></i> Order List </a></li>
							
							<li><a href="<?php echo base_url();?>index.php/website/myaddress"> <i class="glyphicon glyphicon-map-marker text-success"></i> Address </a></li>
							<li><a href="<?php echo base_url();?>index.php/website/myprofile"> <i class="glyphicon glyphicon-user text-success"></i> Profile </a></li>
							<li><a href="<?php echo base_url();?>index.php/website/mypassword"> <i class="glyphicon glyphicon-edit text-success"></i> Change Password </a></li>
							<li><a href="<?php echo base_url();?>index.php/website/logout" onclick="return confirm('Are you sure you want to logging out?');" > <i class="glyphicon glyphicon-log-out text-success"></i> Logout </a></li>
							
						</ul>
						<div class="contact-box">
							<div class="contact-box-row">
								<i class="icon-map-pointer"></i>
								<div class="contact-box-row-title"><b>Our address:</b></div>
							
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add1; ?> <br/>
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_add2; ?><br/>
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_city; ?>, 	
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_state; ?> -
						<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_zip; ?>
							</div>
							<div class="contact-box-row">
								<i class="icon-telephone"></i>
								<div class="contact-box-row-title"><b>Call us:</b></div>
								<div> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_phone; ?> / <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_mobile; ?></div>
							</div>
							<div class="contact-box-row">
								<i class="icon-clock"></i>
								<div class="contact-box-row-title"><b>Work Time:</b></div>
								<div>Mon-Fri: 8:30am – 1:30pm
									<br>Mon-Fri: 3:30pm – 8:30pm</div>
							</div>
						</div>
					</div>
					