<?php require_once("header.php"); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"> <?php echo lang('Master'); ?> </a>
				</li>
				<li class="active"><?php echo lang('Order Details'); ?>  </li>
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
							<div class="tabbable#">
								

								<!-- Tab Contents Starts --> 
								
								<div class="tab-content">
									
									<div id="list" class="tab-pane fade in active">
									<!-- NEW TABLE --> 
									
										<div class="row">
											<div class="col-xs-12">
												
												<div class="clearfix">
													
												</div>
												<div class="table-header" style="background:#3A87AD!important;">
													<?php echo lang('Order Details'); ?> 
												</div>
												
											<?php
											$custId=$user_id;

											/**** Wallet ****/
											$this->db->select_sum('payment_amt');
											$walletCredit=$this->db->get_where('wallet_history', array('customer_id' =>$custId,'credit_debit'=>'credit'))->row()->payment_amt;

											$this->db->select_sum('payment_amt');
											$walletDebit=$this->db->get_where('wallet_history', array('customer_id' =>$custId,'credit_debit'=>'debit'))->row()->payment_amt;

											$walletBalance=$walletCredit-$walletDebit;
											if($walletBalance<0) $walletBalance=0;

											/********** End Wallet *********/

											/********* Credit Section ***********/
											$this->db->select_sum('credit_trans_amt');
											$Credit=$this->db->get_where('credit_history', array('customer_id' =>$custId,'credit_debit'=>'credit'))->row()->credit_trans_amt;


											$this->db->select_sum('credit_trans_amt');
											$Debit=$this->db->get_where('credit_history', array('customer_id' =>$custId,'credit_debit'=>'debit'))->row()->credit_trans_amt;

											$CreditLimit=$this->db->get_where('users', array('id' =>$custId ))->row()->credit_limit;

											$TotalCredit=$CreditLimit;
											
											$CreditUse=$Debit-$Credit;

											$BalCredit=$TotalCredit-$CreditUse;

											/********** End Credit Section *********/

											/********* Package Section ***********/

											$packageList=$this->db->query("SELECT *, SUM(`usage_limit`) AS total FROM `cust_packages` WHERE `cust_id`=$custId AND `pkg_active`='active' GROUP BY `pref_pkg` ")->result();


											/********* End Package Section ***********/
											?>

												
												
												<div class="form-group" style="margin-top:10px;">
												
												 <label class="col-sm-3 control-label no-padding-right" for="invoice_no"> <?php echo lang('Customer Name'); ?> :  <strong style="font-size:15px;">  <?php echo $Disp_Party_Name ; ?> </strong> </label>
												 
												<label class="col-sm-3 control-label no-padding-right" for="invoice_no"> <?php echo lang('Mobile'); ?>  : <?php echo $Mobile ; ?>  </label>

												<label class="col-sm-4 control-label no-padding-right" for="invoice_no"> <?php echo lang('Email ID'); ?>  : <?php echo $Email ; ?>  </label>

												 <label class="col-sm- control-label no-padding-right" for="invoice_no" style="float:right;margin-right:11px;"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/wallet_history/<?php echo $user_id; ?>');" title="Wallet History" > Wallet (Bal) : <?php echo $sys_curr; ?> <?php echo $walletBalance; ?>.00   </a> &nbsp;&nbsp;&nbsp; </label>
												
												</div>
												
												<div class="form-group">

												 <label class="col-sm-3 control-label no-padding-right" for="invoice_no"> <?php echo lang('Total Pending'); ?>  : <strong style="font-size:14px;"> <?php echo $PendingOrder; ?> </strong>  </label>
												 <?php
												 $laundrystorecust=$invoicerow->laundry_store;
												 $OutStandAmount=$TotalAmt-$ReceivedAmt;
												 $OutStandAmtDisp=($storeTaxable=='yes')?$OutStandAmount+($OutStandAmount*5/100):$OutStandAmount;
												 ?>
												 <!-- <label class="col-sm-3 control-label no-padding-right" for="invoice_no"> Outstand Amount  : <strong style="font-size:14px;"> 
												 <?php if($TotalAmt!=0) echo sprintf('%0.3f',$OutStandAmtDisp); else echo "0.000"; ?> 
												 </strong>  </label>

												 <label class="col-sm- control-label no-padding-right" for="invoice_no" style="float:right;margin-right:11px;"> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/credit_history/<?php echo $user_id; ?>');" title="Credit History"> Credit Used : <?php echo $sys_curr; ?> <?php echo $CreditUse; ?> / <?php echo $TotalCredit; ?>.00    </a> &nbsp;&nbsp;&nbsp; </label>
 -->
												</div>

												<?php
												$pkgCount=0; $pkgUse=0;
												foreach($packageList as $pkgRow)
												{	
													$pkgName=$pkgRow->pref_pkg;	
													$pkgCount=$pkgRow->total;	

													$pkgUse=$this->db->query("SELECT *, SUM(`total_qty`) AS pkg_qty FROM `customer_order` WHERE `customer_id`=$custId AND `pref_pkg`='$pkgName' GROUP BY `pref_pkg` ")->row()->pkg_qty;

													if($pkgUse=='') $pkgUse=0;

												?>

    											<div class="col-lg-12 col-xs-6">
    											 <label class="col-lg- control-label no-padding-right pull-right" for="invoice_no" > <a href="<?php echo base_url();?>index.php/package/package_list" title="Package History"> Packages <small> [<?=$pkgName?>] </small> : <?php echo $pkgUse; ?> / <?=$pkgCount?> <?=$pkgRow->pkg_unit?>     </a> &nbsp;&nbsp;&nbsp; </label>
												</div>

												<?php
												}
												?>

												<!-- <div class="col-lg-12 col-xs-6">

												
												 <label class="col-lg- control-label no-padding-right pull-right" for="invoice_no" > <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/credit_history/<?php echo $user_id; ?>');" title="Credit History"> Packages <small> [wash and iron] </small> : <?php echo $CreditUse; ?> / <?php echo $TotalCredit; ?>    </a> &nbsp;&nbsp;&nbsp; </label>

												</div>
 -->
											<div>
												<!-- div.table-responsive -->

												<!-- div.dataTables_borderWrap -->
										<div class="col-xs-12" style="margin-top:10px;">
											    	
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
															<tr>
																<!-- <th class="center hidden-480">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</th> -->
																<th> <?php echo lang('Order'); ?>#  </th>
																<th class="hidden-480"> Bill Date   </th>
																
																<th class="hidden-480"> <?php echo lang('Order Status'); ?>  </th>
																<th><?php echo lang('Qty/Kg'); ?>  </th>
																<th style="text-align:right;"> Total Amount  </th>
																<th style="text-align:right;"> Receive Amount  </th>
																<th class="hidden-480">Balance Amount  </th>
																<!-- <th class="hidden-480"><?php echo lang('Remarks'); ?>  </th>
																 -->

																<!-- <th></th> -->
															</tr>
														</thead>
														<!--
														 <tfoot>
            <tr>
                <th></th><th></th><th></th><th></th><th></th><th></th><th style="text-align:right">Net Amt :</th>
                <th style="text-align:right;"></th> <th> </th>
            </tr>
        </tfoot> -->

														<tbody>
															<?php foreach ($invoiceorder->result() as $invoicerow): ?>
															<tr>
																<!-- <td class="center hidden-480">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</td>
 -->
																<td>
																	<?php echo $invoicerow->invoice_no; ?>
																</td>
																<td class="hidden-480">  <?php echo date('d-m-Y',strtotime($invoicerow->order_date)); ?>  </td>
																	
																<?php $colr='red';
																if($invoicerow->order_status=='urgent') { $colr='#8E44AD'; } 
																if($invoicerow->order_status=='done') { $colr='green'; } 
																?>
																
																<td class="hidden-480" >
																<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/customer_orders/order_status/<?php echo $invoicerow->auto_id;?>/cust_menu');" style='text-decoration:none; color:<?php echo $colr; ?>' title="Order Status">
																<?php echo strtoupper($invoicerow->order_status); ?> 
																</a>
																</td>
																<?php
																$pkgUnit=$this->db->get_where('cust_packages', array('pref_pkg' => $invoicerow->pref_pkg ))->row()->pkg_unit;
																?>
																<td class=""><?php echo $invoicerow->total_qty; ?> <?=$pkgUnit?> </td>
															
																<!-- VAT Calc -->
																<?php
																$laundrystorecust=$invoicerow->laundry_store;
																$storeTaxable=$this->db->get_where('stores' , array('id' =>$laundrystorecust))->row()->store_taxable;
																$totalAmountDisp=$invoicerow->total_paid;
																if($storeTaxable=='yes')

																{	$vatAmt=$totalAmountDisp*5/100;
																	$grandtotal=$totalAmountDisp+$vatAmt;
																}
																else
																{
																	$grandtotal=$totalAmountDisp;
																}	
																?>
																<!-- End VAT Calc -->
																
																<td style="text-align:right;" class="hidden-480" ><?php echo sprintf('%0.3f',$grandtotal); ?> </td>


																<td style="text-align:right;"> <?php echo sprintf('%0.3f',$ReceiveAmt=$invoicerow->amt_paid); ?> </td>
																
																<td style="text-align:right;"> <?php echo sprintf('%0.3f',$outStand=$grandtotal-$ReceiveAmt); ?> </td>
																
																<!-- <?php 
																
																if ($MasterAdmin!="")
																{ 
																?>
																<td> <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/customer_orders/order_status/<?php echo $invoicerow->auto_id;?>');" style='text-decoration:none;' title="Payment Status">  
																<?php
																if($invoicerow->amt_paidby=="notpaid") echo '<span style="color:red;"> Unpaid </span>';
																if($invoicerow->amt_paidby=="bycash") echo '<span style="color:green;"> Paid(Cash) </span>';
																if($invoicerow->amt_paidby=="byonline") echo '<span style="color:green;"> Paid(Online) </span>';
																if($invoicerow->amt_paidby=="bywallet") echo '<span style="color:green;"> Paid(Wallet) </span>';
																if($invoicerow->amt_paidby=="bycredit") echo '<span style="color:green;"> Paid(Credit) </span>';
																if($invoicerow->amt_paidby=="bypackage") echo '<span style="color:green;"> Paid(Package) </span>';
																if($invoicerow->amt_paidby=="cashdelivery") echo '<span style="color:red;"> Cash on Delivery </span>';
																if($invoicerow->amt_paidby=="error") echo '<span style="color:orange;"> Error </span>';
																  echo "</a> </td>";
																}
																else
																{
																if($invoicerow->amt_paidby=="notpaid") echo '<td style="color:red;"> Pending Paid</td>';
																if($invoicerow->amt_paidby!="notpaid") echo '<td style="color:green;"> Collected </td>';
																if($invoicerow->amt_paidby=="error") echo '<td style="color:orange;"> Error </td>';
																}	
																?>
																
																 -->
																<!-- <td> <?php echo ucfirst($invoicerow->amt_paidby); ?> </td> -->
																
																<!-- <td> <?php echo $invoicerow->remarks; ?>  </td> -->
																<!-- <td>
																	<div class="hidden-sm hidden-xs action-buttons">
																		
																		<a  class="tooltip-info" href="<?php echo base_url();?>index.php/admin/customer_orders/order_tags/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Barcode ">
																			<span class="blue">
																			<i class="ace-icon fa fa-barcode bigger-110"></i>
																			</span>
																		</a>  
																		
																		
																		

																		<?php 
																		if($invoicerow->order_status!='neworder' && $invoicerow->order_status!='pickup'  )
																		{
																		?>	
																			
																		<a  class="tooltip-info" href="<?php echo base_url();?>index.php/admin/invoicepdf/<?php echo $invoicerow->auto_id;?>" data-rel="tooltip" title="Invoice" target="_blank"	>
																			<span class="blue">
																			<i class="ace-icon fa fa-file bigger-110"></i>
																			</span>
																		</a>  
																		<?php
																		} else
																		{	
																		?>
																		
																		<?php if ($MasterAdmin!="") { ?>
																		
																		<a class="tooltip-success" href="<?php echo base_url();?>index.php/pos/update/<?php echo $invoicerow->auto_id;?>/chkrec"  data-rel="tooltip" title="Edit">
																			<span class="green">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																			</span>
																		</a>
																		<?php
																		}
																		}
																		?>
																		
																		<a  class="tooltip-warning" href="<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="<?php echo lang('Mini Invoice'); ?> " target="_blank">
																			<span class="orange">
																			<i class="ace-icon fa fa-file-text-o bigger-110"></i>
																			</span>
																		</a>  
																		
																		<?php if ($MasterAdmin!="")	{ ?> 
																		<a class="tooltip-error" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_order/<?php echo $invoicerow->auto_id;?>');" data-rel="tooltip" title="<?php echo lang('Delete'); ?>">
																			<span class="red">
																			<i class="ace-icon fa fa-trash-o bigger-130"></i>
																			</span>
																		</a>
																	<?php } ?>											
																		
																		
																	</div>

																	<div class="hidden-md hidden-lg">
																		<div class="inline pos-rel">
																			<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																				<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																			</button>

																			<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																				
																				<li>
																					<a href="<?php echo base_url();?>index.php/admin/customer_orders/invoice_order/<?php echo $invoicerow->auto_id;?>" class="tooltip-info" data-rel="tooltip" title="<?php echo lang('Barcode'); ?>">
																						<span class="blue">
																							<i class="ace-icon fa fa-barcode bigger-110"></i>
																						</span>
																					</a>
																				</li> 
																<?php if ($MasterAdmin!="") { ?>
																				<li>
																					<a href="<?php echo base_url();?>index.php/admin/customer_orders/update_order/<?php echo $invoicerow->auto_id;?>/chkrec" class="tooltip-success" data-rel="tooltip" title="<?php echo lang('Edit'); ?>">
																						<span class="green">
																							<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																						</span>
																					</a>
																				</li> 
																				
																				<li>
																					<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_order/<?php echo $invoicerow->auto_id;?>');" class="tooltip-error" data-rel="tooltip" title="<?php echo lang('Delete'); ?>">
																						<span class="red">
																							<i class="ace-icon fa fa-trash-o bigger-120"></i>
																						</span>
																					</a>
																				</li>
							<?php } ?>
																			</ul>
																		</div>
																	</div>
																</td> -->
															</tr>

															<?php 
															$outStandDisp=$outStandDisp+$outStand; 
															endforeach; 
															?>
															<tr> <td></td><td></td><td></td><td></td><td></td>
																<td>OutStand Amount : </td>
																<td style='text-align:right;fonts-size:14px;color:red;font-weight:bold;'><?=sprintf('%0.3f',$outStandDisp)?></td></tr>
														</tbody>
													</table>
												</div>
											</div>
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
					
					 
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null, null, null, 
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
			
					"iDisplayLength": 10,
			
			
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
		
	</body>
</html>