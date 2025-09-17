<?php require_once("header.php"); ?>

<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"><?php echo lang('Reports'); ?> </a>
				</li>
				<li class="active"><?php echo lang('Profit Loss Reports'); ?>  </li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="<?php echo lang('Help'); ?>" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Reports'); ?> 
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Report Management'); ?>  
					</small>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								

								<!-- Tab Contents Starts --> 
								
								
								<div class="tab-content">
									
									<div id="list" class="tab-pane fade in active">
									<!-- NEW TABLE --> 
									
										<div class="row">
											<div class="">
												<?php $attributes = array('class' => 'form-horizontal', 'id' => 'pricelist_form','enctype' => 'multipart/form-data');
												echo form_open('admin/profitloss_report/visible',$attributes); ?>
													
												<div class="form-group">
														<label class="col-sm-1 control-label no-padding-right" for="from_date"> <?php echo lang('From'); ?> : </label>
														<div class="col-sm-2">
															<div class="input-group">
																<input class="form-control date-picker" name="from_date" id="from_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $fromdate; ?>" required />
																<span class="input-group-addon">
																	<i class="fa fa-calendar bigger-110"></i>
																</span>
															</div>
														</div>
														
														<label class="col-sm-1 control-label no-padding-right" for="to_date"> <?php echo lang('To'); ?>  : </label>
														<div class="col-sm-2">
															<div class="input-group">
																<input class="form-control date-picker" name="to_date" id="to_date" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $todate; ?>" required />
																<span class="input-group-addon">
																	<i class="fa fa-calendar bigger-110"></i>
																</span>
															</div>
														</div>
														<input type='hidden' value='visible' name='visible'>
														<div class="col-sm-2">
															<div class="input-group">
															<input class="btn btn-success" type="submit" value="<?php echo lang('Submit'); ?>">
															</div>
															
														</div>
													</form>
												</div>
											</div> 
									
											<div> <hr style='color: 1px solid blue;'> </div>	
									
											
											
											<div class="row">
											<div class="col-xs-12">
												
												<div class="clearfix">
													<div class="pull-right tableTools-container"></div>
												</div> 
												<div class="table-header" style="background:#87B87F!important">
													<?php echo lang('Profit Loss Reports'); ?>  
												</div>

												<!-- div.table-responsive -->

												<!-- div.dataTables_borderWrap -->
												<div>
													<form method="post" name="frm">
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
															<tr>
																<th class="center">
																	<label class="pos-rel">
																		<?php echo lang('Sr.No.'); ?>  
																		<span class="lbl"></span>
																	</label>
																</th>
																																					<th> <?php echo lang('Transaction Date'); ?>  </th>
																																				
																<th title="paid amout"><?php echo lang('Income Amount'); ?>  </th>
																
																<th><?php echo lang('Expenses Amount'); ?>  </th>
															
																<th style="text-align:right;"><?php echo lang('Amount'); ?>  </th>
															
															</tr>
														</thead>

														<tbody>
														
	<?php
		$fromdate=date('Y-m-d',strtotime($fromdate));
		$todate=date('Y-m-d', strtotime($todate. ' +1 day'));
		$begin = new DateTime($fromdate);
		$end = new DateTime($todate);

		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		$sr=1;$NetProfitLoss=0;$TotalExpenseAmt=0;$TotalTransAmt=0;
		foreach($daterange as $date){
		
		$currDate=$date->format("Y-m-d");
		
		
		//Transaction 
		$query=$this->db->query("SELECT *,sum(total_paid) As TransAmt FROM customer_order WHERE order_status='done' AND order_date='".$currDate."'");
		$TransAmt=$query->row()->TransAmt;	
		if($TransAmt=='') $TransAmt=0.00;
		//Expenditure 
		$query=$this->db->query("SELECT *,sum(exp_amt) As ExpenseAmt FROM expenses WHERE exps_date='".$currDate."'");
		$ExpenseAmt=$query->row()->ExpenseAmt;
		
		if($ExpenseAmt=='') $ExpenseAmt=0.00;
		$TotalExpenseAmt=$TotalExpenseAmt+$ExpenseAmt;
		$TotalTransAmt=$TotalTransAmt+$TransAmt;
		$TotalProfitLoss=$TransAmt-$ExpenseAmt;
		$NetProfitLoss=$NetProfitLoss+$TotalProfitLoss;
		
		
			if($TotalProfitLoss!=0)
			{	
				echo "<tr>";	
				echo "<td class='center'>" . $sr . "</td>";
				echo "<td class=''>" . $date->format("d-m-Y") . "</td>";
				echo "<td style='text-align:right;'>" . $sys_curr . " ". sprintf("%0.2f",$TransAmt) . "</td>";
				
				echo "<td style='text-align:right;'>" . $sys_curr . " ". sprintf("%0.2f",$ExpenseAmt) . "</td>";
				
				echo "<td style='text-align:right;'>". $sys_curr . " ";
				printf("%0.2f",$TotalProfitLoss); 
				echo "</td>";
				echo "</tr>";
				$sr++;
			}
		}		//endforeach		
		?>
		<tr style='font-weight:bold;'> 
		<td></td ><td style='text-align:right;'> <?php echo lang('Total Amount'); ?>  : </td> <td style='text-align:right;'> <?php echo $sys_curr . " ". sprintf("%0.2f", $TotalTransAmt); ?>  </td><td style='text-align:right;'> <?php echo $sys_curr . " ". sprintf("%0.2f", $TotalExpenseAmt); ?>  </td><td style='text-align:right;'> <?php echo $sys_curr . " ". sprintf("%0.2f", $NetProfitLoss); ?>  </td> </tr> 	
	
	
													
														</tbody>
													</table>
				
			</form>

			
												</div>
											</div>
										</div>

						 </div>
									</div>
								
							</div><!-- /.col -->
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
					  null, null, null, 
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
						"title" : "ProfitLossReport", 
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"title" : "Profit Loss Report ",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"title" : "Profit Loss Report",
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
				
				
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});				
				
							
			})
		</script>
		
	</body>
</html>