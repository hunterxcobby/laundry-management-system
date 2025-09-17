
<?php require_once("header.php"); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Job Order</a>
				</li>
				<li class="active">Invoice List</li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="Help" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					Job Order
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
											Invoice List 
										</a>
									</li>

									<!-- <li>
										<a data-toggle="" href="<?php echo base_url();?>index.php/pos" >
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											New Order 
											
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
													Order/Invoice List 
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
																		<input type="checkbox" class="ace" />
																		<span class="lbl"></span>
																	</label>
																</th>
																<th>Invoice#</th>
																<!-- <th style='width:100px;' class="hidden-480">Store</th> -->
																<th>Customer Name </th>
																<th> Pickup </th>
																<th class="hidden-480"> Delivery </th>
																<th class="hidden-480" style='width:130px;'>Order Status </th>
																<th class="hidden-480"> Order Place </th>
																<!-- <?php 
																if($MasterAdmin!="") echo ''; 
																?> -->
																
																<th class="hidden-480">Qty / Kg  </th>
																<th style="text-align:right;width:70px;" class="hidden-480"> Invoice Amount &nbsp; </th>
																<th class="hidden-480">Payment </th>
																<!-- <th class="hidden-480">Payemnt </th> -->

																<th class="hidden-480"></th>
															</tr>
														</thead>
														<tfoot>
            <tr>
                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th style="text-align:right"></th>
                <th style="text-align:right;"></th> 
            </tr>
        </tfoot>

														<tbody>
															<?php 
															
															foreach ($invoiceorder->result() as $invoicerow): 
															$background='';
															if($invoicerow->order_status=='cancelled') $background='#FCD8D8'; 
															?>
															<tr style="background:<?php echo $background;?>;" >
																<td class="center">
																	<label class="pos-rel">
																		<input type="checkbox" class="ace" name="chk[]" value="<?php echo $invoicerow->auto_id; ?>" />
																		<span class="lbl"></span>
																	</label>
																</td>

																<td>
																	<?php 
																	if($invoicerow->order_pickup_photo!='')
																	{	echo $invoiceNo=$invoicerow->invoice_no;
																		$cloth_photo=$invoicerow->order_pickup_photo;
																		echo "<br/>";
																		?>
																		<a href='<?=base_url()?>/pickup_photo/<?=$cloth_photo?>' target="_blank"> <small style="font-size:9px;"> PICKUP PHOTO </small> </a>
																	<?php	
																	}
																	else
																	{	echo $invoiceNo=$invoicerow->invoice_no; 
																	}	
																	?>

																	<?php 
																	if($invoicerow->order_delivery_photo!='')
																	{	$cloth_photo=$invoicerow->order_delivery_photo;
																		echo "<br/>";
																		?>
																		<a href='<?=base_url()?>/delivery_photo/<?=$cloth_photo?>' target="_blank"> <small style="font-size:9px;"> DELIVERY PHOTO </small> </a>
																	<?php	
																	}
																	?>

																	
																</td>

																<!-- <td style='font-size:12px;' class="hidden-480">
																	<?php 
																	$lmst=$invoicerow->laundry_store;
																	if($lmst!="") {
																	$StoreNmChk=$this->db->query("SELECT * FROM stores WHERE id='".$lmst."'");
																	if($StoreNmChk->num_rows()!='')
																	echo "<span style='font-size:10px;'> ".strtoupper($this->db->get_where('stores' , array('id' =>$lmst))->row()->store_name)."</span>";
																	}
																				
																	?>
																</td> -->
																<?php $colr='red';
																if($invoicerow->order_type=='Express') { $colr='#8E44AD'; } 
																if($invoicerow->order_status=='delivered') { $colr='green'; } 
																?>
																<td style='color:<?php echo $colr; ?>;width:160px;'>
																<?php
																$Disp_Party_Name="";
																	foreach($userdata->result() as $userrow): 
						                
																	if($userrow->id==$invoicerow->customer_id)
																	{
																		$Disp_Party_Name=$userrow->first_name." ".$userrow->last_name;
																		$Mobile = $userrow->mobile;
																		$Address1 = $userrow->address1;
																	}
																	
										//else { $Disp_Party_Name="sadsd"; }							
																	endforeach;	
																	
										echo $Disp_Party_Name . "<br/># ". $Mobile;	?> <br/> <?=$Address1?> <br/>
										<?php if($invoicerow->order_type!='') echo $invoicerow->order_type; ?>
												
																</td>
																
																<td style='font-size:12px;' >  <?php echo date('d-m-Y',strtotime($invoicerow->pickup_date)); ?> <br/> 
																	<!-- <?php  if($invoicerow->pickup_time!='') echo "[ ". $invoicerow->pickup_time ." ]"; ?> <br/> -->
																<?php 
																$pickby=$invoicerow->pickup_by;
																if($pickby!='') echo "<span style='font-size:10px;'> [". $this->db->get_where('employee' , array('emp_id' =>$pickby))->row()->first_name." ".$this->db->get_where('employee' , array('emp_id' =>$pickby))->row()->last_name."]</span>"; ?>
																<br/> 
																<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/customer_orders/change_date/<?php echo $invoicerow->auto_id;?>');" > Change Date
																</a>
																</td>
																<td class="hidden-480" style='font-size:12px;'>  
																<?php 
																
																if(date('d-m-Y',strtotime($invoicerow->delivery_date))!='01-01-1970')
																{	echo date('d-m-Y',strtotime($invoicerow->delivery_date)); echo "<br/>"; 
																	// if($invoicerow->delivery_time!='') echo "[ ". $invoicerow->delivery_time ." ]"; 
																}
																else 
																{	echo "&nbsp;";  }
																?> 
																<?php 
																$deliveryby=$invoicerow->delivery_by;
																if($deliveryby!='') echo "<span style='font-size:10px;'> [". $this->db->get_where('employee' , array('emp_id' =>$deliveryby))->row()->first_name." ".$this->db->get_where('employee' , array('emp_id' =>$deliveryby))->row()->last_name."]</span>"; ?>	
																</td>
																
																<td class="hidden-480" style='font-size:11px;' >
																<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/customer_orders/order_status/<?php echo $invoicerow->auto_id;?>');" style='text-decoration:none; color:<?php echo $colr; ?>' title="Order Status">
																<?php 
																//if($invoicerow->order_status=="neworder") echo "New Order";
																//else e
																echo strtoupper($invoicerow->order_status);
																if($invoicerow->order_status=='unprocess') echo "<br/><span style='font-size:9px;'> ".$invoicerow->remarks."</span>";
																if($invoicerow->promocode!='') { echo " <span style='font-size:9px;color:orange;'>  { ". strtoupper($invoicerow->promocode)." } </span>"; }  
																?> 
																</a>
																<?php 
																$cust_sel_services=$invoicerow->services;
																
																// $cust_sel_services=unserialize($invoicerow->services);
																
																// if($cust_sel_services!="") {
																// echo "<br/> <span style='font-size:9px;'> [ "; $Service="";														
																// foreach($cust_sel_services as $servicerow):
																
																// $Service.=strtoupper($servicerow)." / "; 
																// endforeach;
																// echo substr($Service, 0, -2). "] </span>";
																if($cust_sel_services!="" && $cust_sel_services!='none') {
																	echo '<br/> <small> [' . $cust_sel_services . '] </small>';
																}
																else
																{	
																	echo '<br/> <span style="font-size:10px;"> [';
																	echo $this->db->get_where('order_temp' , array('order_invoice' =>$invoiceNo))->row()->order_service;
																	echo "]</span>";
																}	
																?>
																<br/>
																<?php 
																	if($invoicerow->remarks!='') 
																		{ echo '<small style="color:#ff8b00;"> [Remarks :- '.$invoicerow->remarks.'] </small>'; }
																?>
																<div>
																</div>
																</td>
																<?php if($MasterAdmin!="") { echo '<td class="hidden-480">'.$invoicerow->order_place_from.'</td>'; }  else { echo "<td> </td>"; }
																?>
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

																<td class="hidden-480">
																<?php 
																if($invoicerow->total_paid==0) echo 'aprx '.$invoicerow->appx_order_qty;
																else echo $invoicerow->total_qty; 
																?> <?=$invoicerow->cloth_unit?> 
																<?php
																if($invoicerow->amt_paidby=="notpaid" && $invoicerow->total_paid!=0 )
																{
																?>	
																<br/>
																<a href="<?=base_url()?>index.php/login/payment_token/<?=$invoiceNo?>/<?=$grandtotal?>" target="_blank"> <small> Online_Pay </small> </a>
																<?php
																}
																?>
																</td>
																
																
																
																<td style="text-align:right;" class="hidden-480" > <?php echo sprintf('%0.3f',$grandtotal); ?> 
																
																</td>
																<td class="hidden-480">
																<?php 
																
																if ($MasterAdmin!="user")
																{ 
																?>
																<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php/admin/customer_orders/order_status/<?php echo $invoicerow->auto_id;?>');" style='text-decoration:none;' title="Payment Status">  
																<?php
																if($invoicerow->amt_paidby=="notpaid") echo '<span style="color:red;"> Unpaid </span>';
																if($invoicerow->amt_paidby=="bycash") echo '<span style="color:green;"> Paid(Cash) </span>';
																if($invoicerow->amt_paidby=="bycard") echo '<span style="color:green;"> Paid(Card) </span>';
																if($invoicerow->amt_paidby=="byonline") echo '<span style="color:green;"> Paid(Online) </span>';
																if($invoicerow->amt_paidby=="bywallet") echo '<span style="color:green;"> Paid(Wallet) </span>';
																if($invoicerow->amt_paidby=="bycredit") echo '<span style="color:green;"> Paid(Credit) </span>';
																if($invoicerow->amt_paidby=="bypackage") echo '<span style="color:green;"> Paid(Package) </span>';
																if($invoicerow->amt_paidby=="cashdelivery") echo '<span style="color:red;"> Cash on Delivery </span>';
																if($invoicerow->amt_paidby=="error") echo '<span style="color:orange;"> Error </span>';
																  echo "</a> ";
																}
																else
																{
																if($invoicerow->amt_paidby=="notpaid") echo '<span style="color:red;" class="hidden-480"> Unpaid </span>';
																if($invoicerow->amt_paidby=="bycash") echo '<span style="color:green;" class="hidden-480"> Paid(Cash) </span> ';
																if($invoicerow->amt_paidby=="byonline") echo '<span style="color:green;"> Paid(Online) </span>';
																if($invoicerow->amt_paidby=="bywallet") echo '<span style="color:green;"> Paid(Wallet) </span>';
																if($invoicerow->amt_paidby=="bycredit") echo '<span style="color:green;"> Paid(Credit) </span>';
																if($invoicerow->amt_paidby=="bypackage") echo '<span style="color:green;"> Paid(Package) </span>';
																if($invoicerow->amt_paidby=="cashdelivery") echo '<span style="color:red;"> Cash on Delivery </span>';
																if($invoicerow->amt_paidby=="error") echo '<span style="color:orange;"> Error </span>';
																  echo "</a> ";
																}
																 echo "<br/><span style='font-size:9px;'>";
																 if($invoicerow->paid_date!='0000-00-00' && $invoicerow->amt_paidby!='notpaid' )
																  { echo date('d-M-y',strtotime($invoicerow->paid_date)); 
																  }
																echo "</span> </td>"; 	
																?>
																</td>
																
																<!-- <td> <?php echo ucfirst($invoicerow->amt_paidby); ?> </td> --> 
																
																<td class="hidden-480">
																	<div class="hidden-sm hidden-xs action-buttons">
																		
																		<a  class="tooltip-info" href="<?php echo base_url();?>index.php/admin/customer_orders/order_tags/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Barcode" target="_blank">
																			<span class="blue">
																			<i class="ace-icon fa fa-barcode bigger-110"></i>
																			</span>
																		</a>  
																		
																		
																		

																		<?php 
																		if($invoicerow->order_status!='neworder' && $invoicerow->order_status!='processing' || $invoicerow->total_paid!=0  && $invoicerow->order_place_from=="From Mobilee"  )
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
																		
																		<?php if ($MasterAdmin!="user" ) { ?>
																		
																		<a class="tooltip-success" href="<?php echo base_url();?>index.php/pos/update/<?php echo $invoicerow->auto_id;?>/chkrec"  data-rel="tooltip" title="Edit">
																			<span class="green">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																			</span>
																		</a>
																		<?php
																		}
																		}
																		?>
																		
																		<a  class="tooltip-warning" href="<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Mini Invoice " target="_blank">
																			<span class="orange">
																			<i class="ace-icon fa fa-file-text-o bigger-110"></i>
																			</span>
																		</a>  
																		
																		<?php if ($MasterAdmin!="")	{ ?> 
																		<a class="tooltip-error" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_order/<?php echo $invoicerow->auto_id;?>');" data-rel="tooltip" title="Delete">
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
																					<a href="<?php echo base_url();?>index.php/admin/customer_orders/order_tags/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Barcode" target="_blank">
																						<span class="blue">
																							<i class="ace-icon fa fa-barcode bigger-110"></i>
																						</span>
																					</a>
																				</li>
																				
																				<li>
																					<a href="<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $invoicerow->auto_id; ?>" data-rel="tooltip" title="Mini Invoice " target="_blank">
																						<span class="orange">
																			<i class="ace-icon fa fa-file-text-o bigger-110"></i>
																					</a>
																				</li>
																				
																				
																<?php if ($MasterAdmin!="") { ?>
																				<li>
																					<a href="<?php echo base_url();?>index.php/pos/add/<?php echo $invoicerow->auto_id;?>/chkrec" class="tooltip-success" data-rel="tooltip" title="Edit">
																						<span class="green">
																							<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																						</span>
																					</a>
																				</li> 
																				
																				<li>
																					<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php/admin/customer_orders/delete_order/<?php echo $invoicerow->auto_id;?>');" class="tooltip-error" data-rel="tooltip" title="Delete">
																						<span class="red">
																							<i class="ace-icon fa fa-trash-o bigger-120"></i>
																						</span>
																					</a>
																				</li>
							<?php } ?>
																			</ul>
																		</div>
																	</div>
																</td>
															</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
													
													<div class="left action-buttons" style="float:left; padding:5px; font-size:15px;">
													
													<i> <b> Driver Selection : </b> </i>
													<a class="green" href="#" onClick="edit_records();" alt="edit"  alt="edit" id="edit">
													<i class="ace-icon fa fa-pencil bigger-130"></i> Edit
													</a>  


													<a class="red" href="#" id="delete" >
													<i class="ace-icon fa fa-trash-o bigger-130"></i> Delete
													</a> 
													
													</div>
													</form>

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
					  null, null, null, null, null, null, null, null, null, 
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
			
					"iDisplayLength": 50,
			
			
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
		            invoice_total = api
		                .column(8, { page: 'current'})
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // // Total over this page
		            // pageTotal = api
		            //     .column( 7, { page: 'current'} )
		            //     .data()
		            //     .reduce( function (a, b) {
		            //         return intVal(a) + intVal(b);
		            //     }, 0 );
					
		            // // Update footer
		            // $( api.column( 7).footer() ).html(
		            //    // '$'+pageTotal +' ( $'+ total +' total)'
		            //     '<?php echo $sys_curr; ?> '+ parseFloat(pageTotal).toFixed(2)
		            // );
		            $( api.column(7).footer() ).html('TOTAL : ');
		            $( api.column(8).footer() ).html( parseFloat(invoice_total).toFixed(3) );
           
			
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