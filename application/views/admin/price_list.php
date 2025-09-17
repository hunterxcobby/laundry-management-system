<?php require_once("header.php"); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"><?php echo lang('Services'); ?>  </a>
				</li>
				<li class="active"> <?php echo lang('Price List'); ?>  </li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Services'); ?> 
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Account Management'); ?>  
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
											<?php echo lang('Prices List'); ?>  
										</a>
									</li>

									<li>
										<a data-toggle="tab" href="#newentry">
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											<?php echo lang('New Entry'); ?>  
											
										</a>
									</li>
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
													<?php echo lang('Prices List'); ?> 
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
																<th class="hidden-480"> <?php echo lang('Sr.No.'); ?> </th>
																<th class="hidden-480"> <?php echo lang('Image'); ?>  </th> 
																<th class="hidden-480"> <?php echo lang('Short Code'); ?>  </th>
																<th > <?php echo lang('Service Name'); ?>  </th>
																<th> <?php echo lang('Garment Type'); ?>  </th>
																<th> <?php echo lang('Price'); ?>   </th>
																
																<th></th>
															</tr>
														</thead>

														<tbody>
															<?php $sr=$price_data->num_rows(); 
															foreach ($price_data->result() as $row): ?>
															<tr>
																<td class="center">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</td>

																<td class="hidden-480">
																	<?php echo $sr; ?>
																</td>
																
																<td>
																	<?php	
																		$filenameo="assets/stock/".$row->id.".png";
																		if (!file_exists($filenameo)) {   
																			$filefoundo = 0;                         
																		} else 
																		{   $filefoundo=$row->id; } 
																	?>
																	<img src="<?php echo base_url();?>assets/stock/<?php echo $filefoundo;?>.png" style="height:35px; width:35px;">										
																</td>
																
																<td>
																	<?php echo $row->short_code; ?>
																</td>
																
																	
																	<?php
																	echo "<td class='hidden-xs'>";
																	foreach ($laundry_service->result() as $ServiceNm): 
																	if($ServiceNm->id==$row->service_id) {
																	echo $ServiceNm->service_name."<br/> ". $ServiceNm->service_name_lang;
																	} 
																	endforeach; 

																	echo "<span style='font-size:11px;'> [ " .  $this->db->get_where('category' , array('cat_id' => ($row->category_id)) )->row()->category_name . " ] </span>";
																	echo "</td>"; 
																	
																	echo "</td>"; 
																	?>	
																	
																	<?php 
																	echo "<td>";
																	foreach ($laundry_cloth->result() as $ClothType): 
																	if($ClothType->id==$row->cloth_id) {
																	echo $ClothType->cloth_type ."<br/> ". $ClothType->cloth_type_lang; } 
																	endforeach; 
																	
																	?>
																	
																	
																<td class="">
																	<?php echo sprintf('%0.3F',$row->price); echo " / ";
																		echo ucwords($row->service_unit);
																	?>
																</td>
																
																<td>
																	<div class="hidden-sm hidden-xs action-buttons">
																		

																		<a class="green" href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/price_crud/do_update/<?php echo $row->id;?>');">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																		</a>

																		<a class="red" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/price_crud/delete/<?php echo $row->id;?>');">
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
																					<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/price_crud/do_update/<?php echo $row->id;?>');" class="tooltip-success" data-rel="tooltip" title="Edit">
																						<span class="green">
																							<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																						</span>
																					</a>
																				</li> 

																				<li>
																					<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/price_crud/delete/<?php echo $row->id;?>');" class="tooltip-error" data-rel="tooltip" title="Delete">
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

									
									<div id="newentry" class="fade">
									
									<div> 
										<form class="form-horizontal " id="service-form" method="post" action="<?php echo base_url();?>index.php/admin/price_crud/create" enctype="multipart/form-data">
										<div class="table-header" style="background:#69AA46!important;">
													<?php echo lang('New Record'); ?>  
												</div> <br/>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="user_id"> <?php echo lang('Price ID'); ?>  : </label>

											<div class="col-sm-9">
												<input type="text" name="service_id" id="service_id" class="form-control" readonly value="<?php echo $last_id+1; ?>" />
											</div>
										</div>
										
																	
										<!-- Choosen Services -->
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="service_name"> <?php echo lang('Service Name'); ?>  : </label>

											<div class="col-sm-9">
												<select class="chosen-select form-control" name="service_name" id="service_name" data-placeholder="Choose a Service..." required>
													<option value="">  </option>
													<?php foreach ($laundry_service->result() as $servicerow): ?>
														
													<?php echo "<option value='$servicerow->id'>". $servicerow->service_name ."</option>"; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<!-- Choosen CLoths -->


										<!-- Choosen Category -->
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="service_name"> <?php echo lang('Category Name'); ?>  : </label>

											<div class="col-sm-9">
												<select class="chosen-select form-control" name="category_name" id="category_name" data-placeholder="Choose a Category..." required>
													<!-- <option value="">  </option> -->
													<?php foreach ($category_data->result() as $categoryRow): ?>
														
													<?php echo "<option value='$categoryRow->cat_id'>". $categoryRow->category_name ."</option>"; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<!-- Choosen CLoths -->
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="cloth_name"> <?php echo lang('Garment Type'); ?>  : </label>

											<div class="col-sm-9" >
												<select class="chosen-select form-control" name="cloth_name" id="cloth_name" data-placeholder="Choose a Garment Type..." required >
													<option value="">  </option>
													<?php foreach ($laundry_cloth->result() as $clothrow): ?>
														
													<!--<?php echo "<option value='$clothrow->id'>". $clothrow->cloth_type ." - ". $clothrow->cloth_type_lang ."</option>"; ?>-->
													<?php echo "<option value='$clothrow->id'>". $clothrow->cloth_type ."</option>"; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="price"> <?php echo lang('Price'); ?>  (<?php echo $sys_curr; ?>) : </label>

											<div class="col-sm-9">
												<input type="text" name="price" id="price" class="form-control" required   />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="service_unit"> <?php echo lang('Price Unit'); ?>  : </label>

											<div class="col-sm-9">
												<select name="service_unit" id="service_unit" class="form-control"  required />
												<!-- <option value="flat"> Flat </option> -->
												<option value="qty" selected> <?php echo lang('Quantity'); ?> </option>
												<option value="kg"> <?php echo lang('Kilogram'); ?> </option>
										    	<option value="sqft"> Sq. Ft </option>
												
												</select>
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="short_code"> <?php echo lang('Short Code'); ?>  : </label>

											<div class="col-sm-9">
												<input type="text" name="short_code" id="short_code" class="form-control" required maxlength="15" />
											</div>
										</div>
										
										
										<div class="form-group">
																
											<label class="col-sm-3 control-label no-padding-right" for="service_img"> <?php echo lang('Image'); ?>   : </label>

											<div class="col-sm-9">
												<input type="file" name="service_img" id="service_img" class="form-control" />
											</div>
										
										</div>

										<div class="form-group">
																
											<label class="col-sm-3 control-label no-padding-right" for="service_img">  </label>
											<small class="col-sm-9" > only gif, png, jpg files allow with file size 150KB </small>

											
										</div>
										
										
										<div class="clearfix form-actions">
											<div class="col-md-offset-3 col-md-9">
												<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;&nbsp;">
													
													&nbsp; &nbsp; &nbsp;														
													&nbsp; &nbsp; &nbsp;
												<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
													
												
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
		

		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
		
		<!-- Date Picker -->
		<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
		
		

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
			
					//"iDisplayLength": 50
			
			
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
						"title" : "PriceList", 
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
				
				
				$('#user-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
						
						service_name: {
							required: true
						},
						
						cloth_name: {
							required: true
						},
						
						short_code: {
							required: true
							
						},
						
						price: {
							required: true,
						}
						
											
					},
			
					messages: {
						service_name: {
							required: "Please select service.",
							service_name: "Please select service."
						},
						price: "Please enter amount.",
						short_code: "Please assign short name."
						
						
					},
			
			
					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},
			
					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},
			
					submitHandler: function (form) {
					},
					invalidHandler: function (form) {
					}
				});
				
				
				
			
			})
		</script>
		
	</body>
</html>