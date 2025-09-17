<?php $this->load->view('admin/header'); 

if (!empty($modelpermission)) 
	{ if (!in_array("groupanduser", $modelpermission))  
		{ ?> <script> alert('<?php echo lang('nopermission'); ?>'); </script>";
		  <?php redirect('login/logout','refresh');	
		}
		
		
	}	
?>

<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"> <?php echo lang('Settings'); ?> </a>
				</li>
				<li class="active"><?php echo lang('Laundry Store'); ?> </li>
			</ul><!-- /.breadcrumb -->

			<a href="#" style="float:right;" title="Help"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Settings'); ?>
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Store Management'); ?>  
					</small>
				
				</h1>
				<a href="<?php echo base_url(); ?>index.php/stores/storenew" class="btn btn-primary btn-xs bigger-110 no-border" style="float:right;margin-top:-25px;"> <i class="ace-icon fa fa-plus default"> </i>  <?php echo lang('Add Store'); ?>   </a>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								
								<!-- NEW TABLE --> 
									<div class="row">
									<?php foreach($storedata->result() as $row) : 
									$color='#A069C3!important;'; $eye='eye'; 
									if($row->show_hide=="hide") { $color='red'; $eye='eye-slash'; }
									elseif($row->store_main=="yes") { $color='blue'; $eye='eye'; }
									
									?>
											
										
										<div class="col-sm-4">
										<div class="widget-box" style="color:<?php echo $color; ?>">
											
											<a href="<?php echo base_url();?>index.php/stores/store_crud/do_update/<?php echo $row->id;?>" >
											<div class="widget-header" style="color:<?php echo $color; ?>">
												<?php
												if($row->store_main=="yes") { ?>
													
												<a href="<?php echo base_url();?>index.php/admin/systemset" class="btn btn-primary  btn-xs bigger-110 no-border" style="margin-left:-10px;"> <i class="ace-icon fa fa-home default"> </i> <?php echo lang('Main Store'); ?>  </a>
												
												<?php } ?>
												<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-<?php echo $eye; ?>" style="color:<?php echo $color; ?>"></i>
													<strong title='<?php echo ucwords($row->show_hide); ?> in the view'> <?php echo $row->store_name; ?> </strong>
												</h4>
												
												
											</div>
											</a>
											<div class="widget-body no-padding">
												<div class="widget-main no-padding">
												<div class="space-1"></div>
												<div class="profile-user-info-striped" >
												
												<div class="profile-info-row" >
													<div class="profile-info-name "> <?php echo lang('Address'); ?>  : </div>

													<div class="profile-info-value">
														<i class="fa fa-map-marker light-orange bigger-110"></i>
														<span class="editable" id="add1"><?php echo $row->store_add1; ?></span> <br/>
														<span class="editable" id="add2"> <?php echo $row->store_add2; ?></span>
														
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> <?php echo lang('City/State'); ?>  : </div>

													<div class="profile-info-value">
														<span class="editable" id="city"><?php echo $row->store_city; ?></span> <br/>
														<span class="editable" id="state"><?php echo $row->store_state; ?> - 
														<?php echo $row->store_zip; ?></span>  
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> <?php echo lang('Email'); ?>  :  </div>

													<div class="profile-info-value">
														<span class="editable" id="signup"><?php echo $row->store_email; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> <?php echo lang('Phone'); ?>  : </div>

													<div class="profile-info-value">
														<span class="editable" id="login"><?php echo $row->store_phone; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Taxable  : </div>

													<div class="profile-info-value">
														<span class="editable" id="about"><?php echo strtoupper($row->store_taxable); ?> </span>
													</div>
												</div>
											</div>

											<div class="space-6"></div>
											<center>
												<?php $storelogout=lang('Logoutmsg').'\n'.$row->store_name. ' '.lang('login');										
												?>		
												<a href="<?php echo base_url();?>index.php/login/redirect/login_from_admin/<?php echo $row->id;?> " class="btn btn-success btn-xs bigger-110 no-border" onclick="return confirm('<?php echo $storelogout; ?>');"> <i class="ace-icon fa fa-external-link default"> </i> <?php echo lang('login'); ?>  </a>
												
												<a href="<?php echo base_url();?>index.php/stores/store_crud/do_update/<?php echo $row->id;?>" class="btn btn-warning  btn-xs bigger-110 no-border"> <i class="ace-icon fa fa-pencil default"> </i> <?php echo lang('Edit'); ?>  </a>
												
												<?php
												if($row->store_main!="yes") { ?>
													
												<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/stores/store_crud/delete/<?php echo $row->id;?>');" class="btn btn-danger  btn-xs bigger-110 no-border"> <i class="ace-icon fa fa-trash default"> </i> <?php echo lang('Delete'); ?>  </a>
												<?php }  ?>
																						
											
												
												
											</center>	
											<div class="space-6"></div>
																						
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
									<?php endforeach; ?>
								</div>

						
						
									</div>

									
																	
							
								<!-- Tab Contents Ends --> 
								
							
						</div><!-- /.col -->

						
			</div>
			</form>
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						

<?php $this->load->view('admin/modal'); ?>
<?php $this->load->view('admin/footer'); ?>

<script>
function GroupModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_order .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_order').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_order .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_order">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo "Add Group "; ?></h4>
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
		

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf_font.min.js"></script>
		
		

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
					  null, null,null,
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
						"title" : "ClothType", 
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
			
			
			})
		</script>
		
	</body>
</html>