
<?php require_once("header.php"); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Transaction</a>
				</li>
				<li class="active">Package List</li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					Transaction
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						Order Management 
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
											Package List 
										</a>
									</li>
								
									<li>
										<a data-toggle="tab" href="#newentry">
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											Assign Package
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
													Customer Package List 
												</div>

												<!-- div.table-responsive -->

												<!-- div.dataTables_borderWrap -->
												<div>
												<form method="post" name="frm">
											    	
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
															<tr style="font-size:12px;">
																
																<th> Order#</th>
																<th> Name </th>
																<!-- <th> Order Date  </th> -->
																<th> Package </th>
																<th> Period </th>
																<th> Pickup </th>
																<th class="hidden-480"> Pick Date </th>
																<th> Expire  </th>
																<th> Capacity </th>
																<th> Amount </th>
																<th> Pay Mode </th>
																<th> Pay Date </th>
																<th class="hidden-480"> Pkg Status </th>
															
															</tr>
														</thead>
														
														<tbody>
															<?php 
															$prvpkglimit=0;

															foreach ($custpkgdata->result() as $pkgrow):  ?>
															<tr>
																

																<td>
																	<?php echo $pkgrow->pkg_id; ?>
																</td>
																
																<td>
																	<?php 
																	$CustId=$pkgrow->cust_id;
																	echo $this->db->get_where('users' , array('id' => $CustId))->row()->first_name; ?> 
																	<?php echo $this->db->get_where('users' , array('id' => $CustId))->row()->last_name; ?> <br/>
																	#<?php echo $this->db->get_where('users' , array('id' => $CustId))->row()->mobile; ?> <br/>
																	
																</td>
																
																<td>
																	<?php echo $pkgrow->pref_pkg; ?>
																</td>
																
																<td>
																	<?php echo $pkgrow->pref_period; ?>
																</td>
																
																<td>
																	<?php echo $pkgrow->pref_pickup; ?>
																</td>
																
																<td>
																	<?php echo date('d-M-Y',strtotime($pkgrow->pref_pickup_date)); ?>
																</td>

																<td>
																	<?php echo date('d-M-Y',strtotime($pkgrow->pkg_expire_date)); ?>
																</td>
															
																<td>
																	<!--
																	<?php
																
																	 $first_date=date('Y-m-d',strtotime($pkgrow->pref_pickup_date));

																	$second_date=date('Y-m-d',strtotime($pkgrow->pkg_expire_date));

																	$this->db->select_sum('total_qty');
																	$this->db->where('customer_id',$CustId);
																	$this->db->where('amt_paidby','bypackage');
																	$this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($first_date)). '" and "'. date('Y-m-d', strtotime($second_date)).'"');
																	
																	$result = $this->db->get('customer_order')->row(); 

																	$pkgstatus=$pkgrow->pkg_active;

																	$pkgusagelimit=$pkgrow->usage_limit;
																	
																	echo $result->total_qty;

																	if($result->total_qty>$pkgusagelimit)
																	{
																		echo $pkgusagelimit;
																		$prvpkglimit=$prvpkglimit+$pkgusagelimit;
																		
																	}	

																	elseif($pkgstatus=='active' || $pkgstatus=='expired' )
																	{ 	echo $result->total_qty-$prvpkglimit; } else echo '0';

																	?> 

																	/ --> 

																	<?php echo $pkgrow->usage_limit; ?> <?php echo $pkgrow->pkg_unit; ?>
																</td>
																
																<td style="text-align:right;" ><?php echo $sys_curr; ?> <?php echo $pkgrow->amount; ?>.00 </td>
																
																
																<td>
																	 <?php echo $pkgrow->payment_mode; ?> 
																</td>
																
																<td>
																	<?php echo date('d-M-Y',strtotime($pkgrow->payment_date)); ?>

																</td>
																
																
																
																<td>
																	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/package/pkg_crud/package_status/<?php echo $pkgrow->pkg_id;?>');" style='text-decoration:none;' title="Payment Status">
																	
																	<?php
																	$color='';
																	if($pkgrow->pkg_active=='active') $color='green';
																	if($pkgrow->pkg_active=='inactive') $color='orange';
																	if($pkgrow->pkg_active=='expired') $color='#FF3390';
																	if($pkgrow->pkg_active=='cancelled') $color='red';
																	echo '<span style="padding:3px;background:'.$color.';color:white;border-radius:8px;font-size:9px;">'.  strtoupper($pkgrow->pkg_active).'</span>';
																	?>
																	</a>
																	<!--
																	<br/>
																	<span style='font-size:10px;'> <?php if($pkgrow->active_expire_date!='0000-00-00') echo date('d-m-Y',strtotime($pkgrow->active_expire_date)); ?>  </span> -->
																</td>
																
																
																
																
																
																<!-- <td> <?php echo ucfirst($pkgrow->amt_paidby); ?> </td> --> 


																
																<?php //echo $prvpkglimit;
																 endforeach;  ?>
														</tbody>
													</table>
													
													
													</form>

												</div>
											</div>
										</div>
									</div> <!-- First tab conents -->


									<div id="newentry" class="tab-pane fade">
									
								
										<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
										echo form_open('package/pkg_insert',$attributes); ?>

										<div class="table-header" style="background:#69AA46!important;">
													Assign Package to Customer 
												</div> <br/>
										<div class="form-group ">
											<label class="col-sm-3 control-label no-padding-right" for="cloth_id"> Order ID : </label>

											<div class="col-sm-9">
												<input type="text" id="pkg_id" class="form-control" required readonly value="<?php echo $last_id+1; ?>" />
											</div>
										</div>
										
										<div class="space-4"></div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="cust_id"> Select Customer : </label>

											<div class="col-sm-9">
												<select class="form-control" name="cust_id" id="cust_id" required >
													<option value=""> --Select Customer-- </option>
													<?php
													
													$CustomerList=$this->db->get('users')->result();
													foreach($CustomerList as $custrow) :
													echo "<option value='".$custrow->id."'>".$custrow->first_name." ".$custrow->last_name." [ ".$custrow->mobile." ] </option>";
													endforeach;
													?>
												</select>
											</div>
											
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="pref_pkg"> Package Name : </label>

											<div class="col-sm-9">
												<select class="form-control" name="pref_pkg" id="pref_pkg" required >
													<option value=""> -- Select Package -- </option>
													<?php
													$this->db->order_by('category,usage_limit');
													//$this->db->order_by('usage_limit');
													$PackageList=$this->db->get('packages')->result();
													foreach($PackageList as $prow) :
													// echo "<option value='".$prow->pkg_id."'>".$prow->pkg_name." Rs. ".$prow->amount." [ ".$prow->usage_limit." Clothes ] </option>";

													echo "<option value='".$prow->pkg_id."'>".$prow->pkg_name." Rs. ".$prow->amount." [ ".$prow->usage_limit."/".$prow->pkg_unit."] </option>";

													endforeach;
													?>
												</select>
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="pref_pickup_date"> Pickup Date : </label>

											<div class="col-sm-9">
												<input type="date" name="pref_pickup_date" class="form-control" required  />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="payment_mode"> Payment Mode : </label>

											<div class="col-sm-9">
												<select class="form-control" name="payment_mode" id="payment_mode" required >
													<option value=""> --Select-- </option>
													<option value="bycash" > Cash Payment </option>
													<option value="byonline"> Online Payment </option>
												</select>
											</div>
										</div>

										
										<div class="clearfix form-actions">
											<div class="col-md-offset-3 col-md-9">
												<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp;&nbsp; Save &nbsp;&nbsp;&nbsp;">
													
													&nbsp; &nbsp; &nbsp;														
													&nbsp; &nbsp; &nbsp;
												<input class="btn" type="reset" value="&nbsp;&nbsp; Reset &nbsp;&nbsp; ">
													
												
											</div>
										</div>
										
										</form>
										
									 </div>

								</div>	
								<!-- Tab Contents Ends --> 
								
							
						</div><!-- /.col  tabbled -->

						
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						

<?php require_once("msg_modal.php"); ?>
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

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					
					 
					bAutoWidth: true,
					"aoColumns": [
					  { "aSortable": false },
					  null, null, null, null, null, null, null, null, null, null,
					  { "aSortable": false }
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
			
					"iDisplayLength": 12,
			
			
					select: {
						style: 'multi'
					},
					
					"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\<?php echo $sys_curr; ?>,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			
            // Update footer
            $( api.column( 7).footer() ).html(
               // '$'+pageTotal +' ( $'+ total +' total)'
                '<?php echo $sys_curr; ?> '+ parseFloat(pageTotal).toFixed(2)
            );
			
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
						"title" : "InvoiceList", 
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						//"footer": "true",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						//"footer": "true",
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

<script>

function edit_records() 
{
	//alert('fun');
	document.frm.action = "<?php echo base_url();?>index.php/admin/cust_multi_order_crud/do_update";
	document.frm.submit();	
}


$(document).ready(function(){
 
 $('#delete').click(function(){
  
  if(confirm("Are you sure you want to delete this?"))
  {
   var id = [];
   
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   
   if(id.length === 0) //tell you if the array is empty
   {
    alert("Please Select atleast one checkbox");
   }
   else
   {
    $.ajax({
     url:'<?php echo base_url();?>index.php/admin/cust_multi_order_crud/delete',
     method:'POST',
     data:{id:id},
     success:function()
     {	//alert(id);
      for(var i=0; i<id.length; i++)
      {
       $('tr#'+id[i]+'').css('background-color', '#ccc');
       $('tr#'+id[i]+'').fadeOut('slow');
      }
	  window.location.reload();
     }
     
    });
   }
   
  }
  else
  {
   return false;
  }
 });
 
});
</script>
		
	</body>
</html>