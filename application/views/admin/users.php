<?php 
require_once("header.php"); 
if (!empty($modelpermission)) 
	{ if (!in_array("master", $modelpermission))  
		{ echo "<script> alert('You do not have permission to access this model'); </script>";
		  redirect('admin/index','refresh');
		}
		
		
	}	
	
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"><?php echo lang('Master'); ?></a>
				</li>
				<li class="active"><?php echo lang('Customers'); ?></li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="<?php echo lang('Help'); ?>" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Master'); ?>
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Customer Management'); ?> 
					</small>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs" id="myTab">
									<li class="active">
										<a data-toggle="tab" href="#list">
											<i class="purple ace-icon fa fa-list bigger-120"></i>
											<?php echo lang('Customers List'); ?> 
										</a>
									</li>
<!--
									<li>
										<a data-toggle="tab" href="#newentry">
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											<?php echo lang('New Entry'); ?> 
											
										</a>
									</li> -->
								</ul>

								<!-- Tab Contents Starts --> 
								
								<div class="tab-content">
									
									<div id="list" class="tab-pane fade in active">
									<!-- NEW TABLE --> 
									
										<div class="row">
											<div class="col-xs-12">
												
												<div class="clearfix">
													<div class="pull-right tableTools-container"></div>
												</div>
												<div class="table-header" style="background:#A069C3!important;">
													<?php echo lang('Customers List'); ?> 
												</div>

												<!-- div.table-responsive -->

												<!-- div.dataTables_borderWrap -->
												<div>
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
															<tr>
																<th class="center">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</th>
																<th><?php echo lang('Sr.No.'); ?></th>
																<th><?php echo lang('Store Name'); ?></th>
																<th class="hidden-480"><?php echo lang('Join Date'); ?></th>
																<th> <?php echo lang('Name'); ?> </th>
																<th><?php echo lang('Username'); ?>  [<?php echo lang('Password'); ?>]  </th>
																<th> <?php echo lang('Email'); ?> </th>
																<!-- <th > Credit Used</th> -->

																<th></th>
															</tr>
														</thead>

														<tbody>
															<?php $sr=$userdata->num_rows(); 
															foreach ($userdata->result() as $row): ?>
															<tr>
																<td class="center">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</td>

																<td>
																	<?php echo $row->id; ?>
																</td>
																<td>
																	<?php $StoreNm=$row->laundry_store;
																	if($StoreNm!=0) echo $this->db->get_where('stores' , array('id' =>$StoreNm))->row()->store_name;  ?>
																</td>
																<td class="hidden-480">
																	<?php echo date('j-m-Y',strtotime($row->join_date)); ?>
																</td>
																<td title="<?php echo $row->password; ?>">
																<?php 
																	if($row->status=="enable")
																	{
																		echo "<span style='color:green;'>" . $row->first_name." " . $row->last_name . "</span>";
																	}
																	else
																	{
																		echo "<span style='color:red;'>" . $row->first_name." " . $row->last_name . "</span>";
																	}
																			
																	?>
																	
																
																</td>
																<td class=""><?php echo $row->mobile; ?> [ <?php echo $row->password; ?> ] </td>
																
																<td class=""><?php echo $row->email_id; ?> </td>
																
																<!-- <td class="hidden-480">
																<?php $custcharge=$row->cust_charges; $cust_charge=unserialize($custcharge);  ?>
												
												
												<?php 
												$charge_list=$this->db->get('tax_charges'); 
												foreach ($charge_list->result() as $chargerow): 
												if(!empty($cust_charge)) 
												{	
												foreach ($cust_charge as $chargeId):
												 if($chargerow->charge_id==$chargeId)
												 {	
												echo $chargerow->charge_name; 
												if($chargerow->charge_type=="percentage") { echo " (" . $chargerow->charge_amt ."% )"; } if($chargerow->charge_type=="amount") { echo " (" . sprintf("%0.2f", $chargerow->charge_amt) .")"; }
												echo "<br/>";
												 }			
												endforeach;
												}
												endforeach;
												 
												?> 
												
												
											
																
																</td> -->

<!-- Credit Used -->

<!-- 																<td>																	<?php
																/********* Credit Section ***********/
																$custId=$row->id;
																$this->db->select_sum('credit_trans_amt');
																$Credit=$this->db->get_where('credit_history', array('customer_id' =>$custId,'credit_debit'=>'credit'))->row()->credit_trans_amt;


																$this->db->select_sum('credit_trans_amt');
																$Debit=$this->db->get_where('credit_history', array('customer_id' =>$custId,'credit_debit'=>'debit'))->row()->credit_trans_amt;

																$CreditLimit=$this->db->get_where('users', array('id' =>$custId ))->row()->credit_limit;

																$TotalCredit=$CreditLimit;
																
																$CreditUse=$Debit-$Credit;

																$BalCredit=$TotalCredit-$CreditUse;

																/********** End Credit Section *********/


																echo sprintf('%0.3f',$CreditUse); ?> / <?php echo sprintf('%0.3f',$TotalCredit);
																?>

																</td>	
 -->															
																<td>
																	<div class="hidden-sm hidden-xs action-buttons">
																		
																		<a class="blue tooltip-info" data-rel="tooltip"  href="<?php echo base_url();?>index.php/admin/customer_order_details/<?php echo $row->id;?>" title="<?php echo lang('Details'); ?>">
																			<i class="ace-icon fa fa-search-plus bigger-130"></i>
																		</a> 

																		<a class="green tooltip-success" data-rel="tooltip" href="<?php echo base_url();?>index.php/admin/customer_crud/do_update/<?php echo $row->id;?>" title="<?php echo lang('Edit'); ?>">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																		</a>

																		<a class="red tooltip-error" data-rel="tooltip" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_crud/delete/<?php echo $row->id;?>');" title="<?php echo lang('Delete'); ?>" >
																			<i class="ace-icon fa fa-trash-o bigger-130"></i>
																		</a>
																	</div>

																	<div class="hidden-md hidden-lg">
																		<div class="inline pos-rel">
																			<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																				<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																			</button>

																			<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																				
																				<li>
																					<a href="#" class="tooltip-info" data-rel="tooltip" title="<?php echo lang('Details'); ?>">
																						<span class="blue">
																							<i class="ace-icon fa fa-search-plus bigger-120"></i>
																						</span>
																					</a>
																				</li> 

																				<li>
																					<a href="<?php echo base_url();?>index.php/admin/customer_crud/do_update/<?php echo $row->id;?>"  data-rel="tooltip" title="<?php echo lang('Edit'); ?>">
																						<span class="green">
																							<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																						</span>
																					</a>
																				</li> 

																				<li>
																					<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_crud/delete/<?php echo $row->id;?>');" class="tooltip-error" data-rel="tooltip" title="<?php echo lang('Delete'); ?>">
																						<span class="red">
																							<i class="ace-icon fa fa-trash-o bigger-120"></i>
																						</span>
																					</a>
																				</li>
																			</ul>
																		</div>
																	</div>
																</td>
															</tr>
															<?php $sr--; endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>

						
						
									</div>

									
									<div id="newentry" class="tab-pane fade">
									
									<div class="">
										<form class="form-horizontal " id="user-form" method="post" action="<?php echo base_url();?>index.php/admin/customer_crud/create">
										<div class="table-header" style="background:#69AA46!important;">
													<?php echo lang('New Record'); ?>  
												</div> <br/>
																			
										<div class="form-group ">
											<label class="col-sm-2 control-label no-padding-right" for="user_id"> <?php echo lang('Customer ID'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" id="user_id" class="form-control" readonly value="<?php echo $last_id+1; ?>" />
											</div>
										
											<label class="col-sm-2 control-label no-padding-right" for="join_date"> <?php echo lang('Join Date'); ?>  : </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input class="form-control date-picker" name="join_date" id="join_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" />
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="first_name"> <?php echo lang('First Name'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="first_name" id="first_name" class="form-control"  autofocus required />
											</div>
										
											<label class="col-sm-2 control-label no-padding-right" for="last_name"> <?php echo lang('Last Name'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="last_name" id="last_name" class="form-control"  />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="email"> <?php echo lang('Email ID'); ?>  : </label>

											<div class="col-sm-4">
												<input type="email" name="email" id="email" class="form-control" />
											</div>
										
											<label class="col-sm-2 control-label no-padding-right" for="phone"> <?php echo lang('Mobile'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="phone" id="phone" class="form-control" required  />
											</div>
										</div>
										
										<div> <hr style='color: 1px solid blue;'> </div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="address1"> <?php echo lang('Address 1'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="address1" id="address1" class="form-control"  />
											</div>
										
											<label class="col-sm-2 control-label no-padding-right" for="address2"> <?php echo lang('Address 2'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="address2" id="address2" class="form-control"  />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="city"> <?php echo lang('City'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="city" id="city" class="form-control"   />
											</div>
										
											<label class="col-sm-2 control-label no-padding-right" for="state"> <?php echo lang('State'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="state" id="state" class="form-control"   />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="zipcode"> <?php echo lang('Zip Code'); ?>  : </label>

											<div class="col-sm-4">
												<input type="text" name="zipcode" id="zipcode" class="form-control"  />
											</div>
											
											
											<label class="col-sm-2 control-label no-padding-right" for="country"> <?php echo lang('Store Name'); ?>  : </label>

											<div class="col-sm-4">
												<select class="form-control" name="laundry_store" id="laundry_store"  required>
												<option value="" selected> -- <?php echo lang('None'); ?> -- </option>
												<?php foreach ($store_list->result() as $storerow): 
												echo "<option value='".$storerow->id."'>". $storerow->store_name ."</option>"; 
												?>
												<?php endforeach; ?>
													
												</select>
											</div>
										</div>
										<?php $country_name = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_currency;
										?>										
										<input type="hidden" name="country" id="country" class="form-control" value="<?php echo $country_name; ?>" readonly  />
										
										<div class="form-group">
										
										<label class="col-sm-2 control-label no-padding-right" for="status"> <a href="<?php echo base_url();?>/index.php/admin/tax_charges" target="_blank"> <?php echo lang('Select Charges'); ?>  : </a>  </label>

											<div class="col-sm-4">
												<select class="form-control" name="cust_charges[]" id="cust_charges[]" multiple="multiple" title="Ctrl Click to Select a multiple">
												<option value="" selected> -- <?php echo lang('None'); ?> -- </option>
												<?php foreach ($charges_list->result() as $chargerow): ?>
													
												<?php echo "<option value='$chargerow->charge_id'>". $chargerow->charge_name; 
													  if($chargerow->charge_type=="percentage") { echo " (" . $chargerow->charge_amt ."% )"; } if($chargerow->charge_type=="amount") { echo " (" . sprintf("%0.2f", $chargerow->charge_amt) .")"; } 	
													  echo "</option>"; 
												?>
												<?php endforeach; ?>
													
												</select>
											   
											</div>
											
										<label class="col-sm-2 control-label no-padding-right" for="gmap"><?php echo lang('Google Map'); ?> : </label>

											<div class="col-sm-4">
												<?php echo $map['html']; ?>
												<input type="hidden" name="custmap" id="custmap" class="form-control"  value="<?php echo $sys_map_pos; ?>" />
											</div>
											
																					
											
											
											
											
														
											
										</div>
										
										
										<div class="clearfix form-actions">
											<div class="col-md-offset-3 col-md-9">
												<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php echo lang('Save'); ?>  &nbsp;&nbsp;&nbsp;" id='btn' disabled>
													
													&nbsp; &nbsp; &nbsp;														
													&nbsp; &nbsp; &nbsp;
												<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?>  &nbsp;&nbsp; ">
													
												
											</div>
										</div>
										
										</form>
										
									</div>
									
													
													
																					
								</div>
							</div>	
								<!-- Tab Contents Ends --> 
										
							
						</div><!-- /.col -->

						
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						

<?php require_once("modal.php"); ?>
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
		
		
		<!--<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> -->
		

		<!-- Form Validation -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>	
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null, null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					"iDisplayLength": 100,
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"title" : "Laundry", 
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: ''
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
				
				
				
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				// Customer Mobile Check

				$('#phone').change(function() {
				var phone = $(this).val();
				//alert(phone);
				$.ajax({
					url: "<?php echo base_url();?>index.php/admin/check_phone",
					cache:'false',
					type: 'POST',
					data: {phone: phone},
					success: function(data) {
						if(data!="") { alert(data); $('#phone').focus(); $('#btn').prop("disabled", true);  }
						else { $('#btn').prop("disabled", false); }
						
					}				
				 });
					return false;
				});	
				
				
			
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
	<?php echo $map['js']; ?>	
		
	</body>
</html>