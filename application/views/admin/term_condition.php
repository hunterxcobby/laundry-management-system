<?php require_once("header.php"); ?>
<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#"><?php echo lang('Settings'); ?> </a>
							</li>

							<li>
								<a href="#">Term and Conditions </a> ?>
							</li>
							
						</ul><!-- /.breadcrumb -->

						<a href="<?php echo $helppath;?>" style="float:right;" title="<?php echo lang('Help'); ?>" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
					</div>

					
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								<?php echo lang('System Settings'); ?> 
								
							</h1>
							<a href="<?php echo base_url(); ?>index.php/stores/index" class="btn btn-purple btn-xs bigger-110 no-border" style="float:right;margin-top:-25px;"> <i class="ace-icon fa fa-list default"> </i>  <?php echo lang('Store List'); ?>   </a>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="clearfix">
									

									
								</div>

								<?php foreach($sysdata->result() as $sysrow):    ?>
								
								<div class="">
										<form class="form-horizontal " id="user-form" method="post" action="<?php echo base_url();?>index.php/admin/systemset_update" enctype="multipart/form-data" >
										<center>
										<span style='color:orange;'> <?php echo lang('Note'); ?>  </span> </center> <br/>										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="shop_name"> <?php echo lang('Shop Name'); ?>  : </label>

											<div class="col-sm-9">
												<input type="text" name="shop_name" id="shop_name" class="form-control"  value="<?php echo $sysrow->shop_name; ?>" autofocus  maxlength="20" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="store_name"> <?php echo lang('Store Name'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="store_name" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_name; ?>" readonly  />
											</div>
									
											<label class="col-sm-1 control-label no-padding-right" for="store_short"> <?php echo lang('Short_Name'); ?>  </label>

											<div class="col-sm-4">
												<input type="text" name="short_name" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->short_name; ?>" readonly  maxlength="10"  />
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="address1"> <?php echo lang('Address 1'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="address1" id="address1" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_add1; ?>" readonly />
											</div>
										
											<label class="col-sm-1 control-label no-padding-right" for="address2"> <?php echo lang('Address 2'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="address2" id="address2" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_add2; ?>" readonly />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="city"> <?php echo lang('City'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="city" id="city" class="form-control"  value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_city; ?>" readonly />
											</div>
										
											<label class="col-sm-1 control-label no-padding-right" for="state"> <?php echo lang('State'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="state" id="state" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_state; ?>" readonly />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="zipcode"> <?php echo lang('Zip Code'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="zipcode" id="zipcode" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_zip; ?>" readonly  />
											</div>
											
											<label class="col-sm-1 control-label no-padding-right" for="state"> <?php echo lang('Country'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="country" id="country" class="form-control" value="<?php echo $sysrow->sys_currency;?>" disabled  />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="shop_gmap"> <?php echo lang('Address Map'); ?>  : </label>

											<div class="col-sm-9">
												<?php echo $sysmap['html']; ?>
												<input type="hidden" name="shop_gmap" id="shop_gmap" class="form-control" value="<?php echo $sysrow->shop_gmap; ?>"  />
											</div>
											
											
										</div>
										
										
										
										<div class="hr dotted"></div>										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="shop_mobile"> <?php echo lang('Mobile'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="shop_mobile" id="shop_mobile" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_phone; ?>" readonly />
											</div>
											
											<label class="col-sm-1 control-label no-padding-right" for="shop_phone"> <?php echo lang('Phone'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="shop_phone" id="shop_phone" class="form-control" value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_phone; ?>" readonly />
											</div>
										
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="shop_email"> <?php echo lang('Email ID'); ?>  : </label>

											<div class="col-sm-9">
												<input type="email" name="shop_email" id="shop_email" class="form-control"  value="<?php echo $this->db->get_where('stores' , array('store_main' =>'yes'))->row()->store_email; ?>" readonly />
											</div>
										</div>
										
										
										<div class="form-group">
											
							
											<label class="col-sm-3 control-label no-padding-right" for="shop_logo"> <?php echo lang('Shop Logo'); ?> ( <img src='<?php echo base_url(); ?>assets/images/logo.png' style="height:30px; width:30px;"> )  : </label>

											<div class="col-sm-9">
												<input type="file" name="shop_logo" id="shop_logo" class="form-control" />
											</div>
										</div>
										
										
										
										<div class="hr dotted"></div>
										
										
										<div class="form-group">
											
											<label class="col-sm-3 control-label no-padding-right" for="sys_lang"> <b> <span style="fontssize:12px;"> <?php echo lang('Choose'); ?> <?php echo lang('Language'); ?>  : </span> </b>  </label>

											<div class="col-sm-4" id="language">
												<select class="form-control" name="sys_lang" id="sys_lang" >
													<option value="">-- <?php echo lang('Choose'); ?> <?php echo lang('Language'); ?> --</option>
													<option value="english" <?php if($sysrow->sys_lang=="english") echo "selected"; ?> >English - US  </option>
													
													<option <?php if($sysrow->sys_lang=="hindi") echo "selected"; ?> value="hindi"> हिंदी - India </option>

													<option <?php if($sysrow->sys_lang=="arabic") echo "selected"; ?> value="arabic"> عربى  - Arabic </option>
													

													<!-- <option value="chinese" <?php if($sysrow->sys_lang=="chinese") echo "selected"; ?> >中文 - China </option>
													
													<option value="russian" <?php if($sysrow->sys_lang=="russian") echo "selected"; ?> > русский - Russia </option> -->
													<option value="bengali" <?php if($sysrow->sys_lang=="bengali") echo "selected"; ?> >বাঙালি - Bengali </option>
													
													<option value="spanish" <?php if($sysrow->sys_lang=="spanish") echo "selected"; ?> >Español - Spanish </option>

													<option value="french" <?php if($sysrow->sys_lang=="french") echo "selected"; ?> >français - French </option>
													
													
													<option value="portuguese" <?php if($sysrow->sys_lang=="portuguese") echo "selected"; ?> >Português - Portuguese  </option>
													
													<option value="indonesia" <?php if($sysrow->sys_lang=="indonesia") echo "selected"; ?> >Bhasa Indonesian - Indonesia </option>

													<option value="philippines" <?php if($sysrow->sys_lang=="philippines") echo "selected"; ?> > Pilipinas - Philippines  </option>
												
													
												</select>
												<span style="font-size:11px;"> missing language or wrong words <a href="http://laundry.rpcits.co.in/message_lang/" target="_blank"> Click Here </a> </span>
											</div>
											
											<label class="col-sm-1 control-label no-padding-right" for="timezone"> <span> <?php echo lang('TimeZone'); ?>  : </span>  </label>

											<div class="col-sm-4">
												<select class="chosen-select form-control" name="timezone" id="timezone">
												<?php
												$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

												foreach ($timezones as $timezone) {
													if($sysrow->sys_timezone==$timezone){ $sel="selected"; } else { $sel=""; }
														//echo "<option value='".$timezone."'".$sel." >". $timezone . "</option>";
														echo "<option value='".$timezone."'".$sel." >". str_replace('/', ' / ', $timezone) . "</option>";
												}																	
												?>								
												</select>	
											</div>
											
											
											
											<!--
											
											<label class="col-sm-1 control-label no-padding-right" for="sys_lang"> <span style="font-size:12px;"> Garment Lang: </span>  </label>

											<div class="col-sm-4">
												<select class="chosen-select form-control" name="sys_lang" id="sys_lang">
												<?php
												
												foreach ($world_lang->result() as $langrow) {
													if($sysrow->sys_lang==$langrow->language_name){ $sel_lang="selected"; } else { $sel_lang=""; }
														echo "<option value='".$langrow->language_name."'".$sel_lang." >". $langrow->language_name . "</option>";
														
												 }																	
												?>								
												</select>	
											</div> -->
											
										</div>
										
										<div class="form-group">
											
										</div>
										
										<!--
										<div class="form-group">
											<label class="col-sm-1 control-label no-padding-right" for="sys_lang"> <span> System Language : </span>  </label>

											<div class="col-sm-4">
												<select class="form-control" name="sys_lang" id="sys_lang">
													<option value="">-- Select --</option>
													<option value="english" <?php if($sysrow->sys_lang=="english") echo "selected"; ?> >English</option>
													<option <?php if($sysrow->sys_lang=="arabic") echo "selected"; ?> value="arabic">Arabic</option>
													<option <?php if($sysrow->sys_lang=="hindi") echo "selected"; ?> value="hindi">Hindi</option>
													
												</select>
											
											</div>
										</div>
										-->
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="sys_cur"> <?php echo lang('Currency'); ?>  (<?php echo $sys_curr; ?>) : </label>

											<div class="col-sm-4">
												
												<select class="chosen-select form-control" name="sys_cur" id="sys_cur">
												<?php
												
												foreach ($world_curr->result() as $currencyrow) {
													if($sysrow->sys_currency==$currencyrow->country_name){ $selc="selected"; } else { $selc=""; }
														echo "<option value='".$currencyrow->country_name."'".$selc." >". $currencyrow->country_name . " ( " . $currencyrow->currency_symbol ." / ". $currencyrow->code . " )</option>";
												}																	
												 ?>								
												</select>	
												
											</div>
											
											<div class="form-group">
											<label class="col-sm-1 control-label no-padding-right" for="sys_curr_show"> <span style="font-size:12px;"> <?php echo lang('Show System'); ?> : </span>  </label>

											<div class="col-sm-4">
												<select class="form-control" name="sys_curr_show" id="sys_curr_show">
													<option value="symbol" <?php if($sysrow->sys_currency_show=="symbol") echo "selected"; ?> > <?php echo lang('Currency Symbol'); ?>  (<?php echo $sys_curr_symbol; ?>) </option>
													<option <?php if($sysrow->sys_currency_show=="code") echo "selected"; ?> value="code"><?php echo lang('Currency Code'); ?>  (<?php echo $sys_curr_code; ?>) </option>
													
												</select>
											
											</div>
										</div>
										</div>
										
										
										
										
										
										<div class="clearfix form-actions">
											<div class="col-md-offset-3 col-md-9">
												<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php //echo lang('Update'); ?> Update  &nbsp;&nbsp;&nbsp;">
													
													&nbsp; &nbsp; &nbsp;														
													&nbsp; &nbsp; &nbsp;
												<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?>  &nbsp;&nbsp; ">
													
												
											</div>
										</div>
										
										</form>
										<?php endforeach; ?> 
									</div>	
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			
			

<?php require_once("footer.php"); ?>
	
		
<script type="text/javascript">						

function Profile(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#admin_profile .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#admin_profile').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#admin_profile .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="admin_profile">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo "Edit Admin Profile "; ?></h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                
                    
                    
                </div>
               <!-- 
                <div class="modal-footer" style="background:#fbeed5;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
				-->
            </div>
        </div>
    </div>
	
		<!------------------>



		

<?php require_once("footer.php"); ?>

		

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf_font.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.select.min.js"></script>
		
		
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/spinbox.min.js"></script>
		
		
		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
			
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/autosize.min.js"></script>
		
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					
				}
				
				
				
			})
		</script>
		<script type="text/javascript">
		function updateDatabase(newLat, newLng)
		{	alert("hi");
			// make an ajax request to a PHP file
			// on our site that will update the database
			// pass in our lat/lng as parameters
			$.post(
				"/admin/customer_crud/googlemapdb", 
				{ 'newLat': newLat, 'newLng': newLng, 'var1': 'value1' }
			)
			.done(function(data) {
				alert("Database updated");
			});
		}
	</script>
	<?php echo $sysmap['js']; ?>	
		
	</body>
</html>