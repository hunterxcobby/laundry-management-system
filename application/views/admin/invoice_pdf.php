<?php //require_once("header.php"); ?>

				<div class="page-content">
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="space-6"></div>
								<?php foreach ($order_data as $invoicerow): ?>
								<div class="row">
									<div class="col-sm-10 col-sm-offset-1">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-large">
												<h3 class="widget-title grey lighter">
													<i class="ace-icon fa fa-leaf green"></i>
													Customer Invoice
												</h3>

												<div class="widget-toolbar no-border invoice-info">
													<span class="invoice-info-label">Invoice:</span>
													<span class="red"><?php echo $invoicerow->invoice_no; ?> </span>

													<br />
													<span class="invoice-info-label">Date:</span>
													<span class="blue">
													<?php  $Order_Date=$invoicerow->order_date;
														   echo date('j-m-Y',strtotime($Order_Date));				
													?></span>
												</div>

												
											</div>

											<div class="widget-body">
												<div class="widget-main padding-24">
													<div class="row">
														<div class="col-sm-6">
															<div class="row">
																<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
																	<b>Company Info</b>
																</div>
															</div>

															<div>
																
																<ul class="list-unstyled spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>Red Planet computers
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>02265656565
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>Mumbai
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>
Phone:
																		<b class="red">022-65 65 65 66</b>
																	</li>

																	<li class="divider"></li>

																	<li>
																		<i class="ace-icon fa fa-caret-right blue"></i>
																		Paymant Info : <?php echo $invoicerow->amt_paidby; ?>
																	</li>
																</ul>
															</div>
														</div><!-- /.col -->

														<div class="col-sm-6">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>Customer Info</b>
																</div>
															</div>

															<?php
															
																foreach($customer_data->result() as $userrow): 
								
																if($userrow->id==$invoicerow->customer_id)
																{
																	$Disp_Party_Name=$userrow->first_name." ".$userrow->last_name;
																	
																?>
										
															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i> <strong class="blue"><?php echo $Disp_Party_Name; ?> </strong>
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>
																		<span class="blue"> <?php echo $userrow->email_id; ?> <span>
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>
																		<span class="blue"> <?php echo $userrow->mobile; ?> <span>
																	</li>

																	<li class="divider"></li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>
																		<span class="blue"> <?php echo $userrow->address; ?> <span>
																	</li>
																</ul>
															</div>
														</div><!-- /.col -->
													</div><!-- /.row -->
																<?php
																}
																endforeach;															
																?>
															
													<div class="space"></div>

													<div>
										
										<table id="price-table" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
												
												<th class="center"> ID </th>
												<th> Short Code </th>
												<th class="hidden-480"> Service </th>
												<th > Cloth Type </th>
												<th> Qty </th>
												<th> Price </th>
												<th> Total </th>

												
												
												</tr>
											</thead>

											<tbody>
												<?php $TotalQty=0; $TotalAmt=0; $Sr=0;
												$order_temp = $this->db->get_where('order_temp' , array('order_date' => $Order_Date,'customer_id' => $invoicerow->customer_id) )->result();
												?>
												<?php foreach ($order_temp as $ordertemprow): $Sr++; ?>
												<tr>
													
													<td class="center">
														<?php echo $Sr; ?>
													</td>
													
													<td>
													<?php $Short_Code=$ordertemprow->price_shortcode; ?>
													
													<?php foreach ($price_data->result() as $pricerow): 
														if($Short_Code==$pricerow->id)
														{
															echo $pricerow->short_code;
														}
														else
														{
															continue;
														}	
														?>
													
													</td>
													
													
													<td > 
														<?php
															 
															foreach ($laundry_cloth->result() as $clothrow):
							
															if($clothrow->id==$pricerow->cloth_id)
															{
																echo $clothrow->cloth_type;
															}
															endforeach;															
														?>
													</td> 

													<td class="hidden-480"> 
														<?php
															 
															foreach($laundry_service->result() as $servicerow): 
							
															if($servicerow->id==$pricerow->service_id)
															{
																echo "<span style='font-size:7px;'>" . $servicerow->service_name ."</span>";
																
															}
															endforeach;															
														?>
													</td> 
													
													
													<td class=""><?php echo $Qty=$ordertemprow->order_qty; 
													$TotalQty=$TotalQty+$Qty; ?> </td>
													
													<td> <?php echo $pricerow->price; ?> </td> 
													
													<td> 
														<?php 
														if($Short_Code==$pricerow->id)
														{
															$Price=$pricerow->price;
															echo $DispPrice=($Price*$Qty);
															$TotalAmt=$TotalAmt+$DispPrice;
															
														}
													
													endforeach; ?>
													
													</td> 													
													
													
													</tr>
												<?php endforeach; ?>
												<tr >																
													<td colspan='5'> </td>
													<td> Total : </td> <td> <?php echo $TotalAmt; ?> </td>
												</tr>
												
												<tr >																
													<td colspan='5'> </td>
													<td>  Discount (<?php echo $Discount=$invoicerow->discount; ?>%) : </td> <td> <?php echo $DisAmt=$TotalAmt*$Discount/100;; ?> </td>
												</tr>
												
												<tr >																
													<td colspan='5'> </td>
													<td> Ser Tax (<?php echo $ServiceTax=$invoicerow->service_tax; ?> %): </td> <td> <?php echo $SerAmt=($TotalAmt-$Discount)*$ServiceTax/100; ?> </td>
												</tr>
												
												
													
											</tbody>
										</table>
										</div>
													<div class="hr hr8 hr-double hr-dotted"></div>

													<div class="row">
														<div class="col-sm-5 pull-right">
															<h4 class="pull-right">
																Grand Amount :
																<span class="red"><?php echo $invoicerow->total_paid; ?> </span>
															</h4>
														</div>
														<div class="col-sm-7 pull-left"> Extra Information </div>
													</div>

													<div class="space-6"></div>
													<div class="well">
														Thank you for choosing Company products.
				We believe you will be satisfied by our services.
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			
	
		
	<?php endforeach; ?>					




		


		
	</body>
</html>