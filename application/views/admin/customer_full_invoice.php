 <?php include('system_currency.php'); 
 foreach ($order_data as $row): $storeid=$row->laundry_store;
 ?>
<html>

<head>
 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
</head>

 <body onload="window.print();">
 
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2><?php echo lang('Invoice'); ?> </h2><h3 class="pull-right"><?php echo lang('Order'); ?>  # <?php echo $row->invoice_no; ?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    			    <address>
    				<strong><?php echo lang('Billed To'); ?> :</strong><br>
    			    <?php 
				$FirstName=$this->db->get_where('users' , array('id' =>$row->customer_id))->result();  
				if($FirstName==TRUE)
				{
				?>
				
    				
    					<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->first_name; ?> <br>
    					<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->mobile; ?> <br>
    					
    					<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->address1; ?> <br/>
						<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->address2; ?> <br>
						<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->city; ?>, 
						<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->state; ?> -  
						<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->zipcode; ?>,  <br>
    					
    				</address>
    			<?php
				}
				?>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>
    					<?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?> </strong><br>
    					<div style="width:300px;float:right;font-size:11px;"> 
							<span style='font-weight:bold;'> <?php echo lang('Store Name'); ?>  :  <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_name; ?> </span> <br/>
							<span styl='font-size:11px;'>
							<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_add1; ?> 
							<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_add2; ?> <br/>
							<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_city; ?> 
							<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_state; ?> -
							<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_zip; ?> <br/>
							<?php echo lang('Contact'); ?>  : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_phone; ?> 
							<?php echo lang('Email'); ?>  : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_email; ?> <br/>
							<?php echo lang('Tax/Vat No'); ?> : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_tax_no; ?> </span> 
				
						</div>
    					
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong><?php echo lang('Payment'); ?> :</strong><br>
    					<?php echo $row->amt_paidby; ?><br>
    					 <?php //echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->email_id; ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong><?php echo lang('Order'); ?> <?php echo lang('Date'); ?> :</strong>
    					<?php echo date('d-M-Y', strtotime($row->order_date)); ?> <br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong><?php echo lang('Order'); ?> <?php echo lang('Summary'); ?> </strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong><?php echo lang('Sr.No.'); ?> </strong></td>
        							<!-- <td><strong> <?php echo lang('Short Code'); ?>  </strong></td> -->
									<td style='width:200px;'><strong><?php echo lang('Description'); ?> </strong></td>
        							
        							<td class="text-center"><strong><?php echo lang('Quantity'); ?></strong></td>
									<td class="text-center"><strong><?php echo lang('Rate'); ?></strong></td>
        							<td class="text-right"><strong><?php echo lang('Total'); ?></strong></td>
                                </tr>
    						</thead>
    						<tbody>
							<td colspan="6"></td>
    					<?php $TotalQty=0; $TotalAmt=0; $Sr=0;
												$order_temp = $this->db->get_where('order_temp' , array('order_date' => $row->order_date,'customer_id' => $row->customer_id,'order_invoice' => $row->invoice_no) )->result();
												?>
												<?php foreach ($order_temp as $ordertemprow):$Sr++; ?>
												<tr>
													<td class="no-line"> <?php echo $Sr; ?> </td> 
													
													<!-- <td class="no-line">
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
													
													</td> -->
													<td class="no-line" style='width:250px;' > 
														<?php
															$ser_eng=""; $ser_lang="";  
															foreach($laundry_service->result() as $servicerow): 
							
															if($servicerow->id==$pricerow->service_id)
															{
																$ser_eng=strtoupper($servicerow->service_name);
																$ser_lang=$servicerow->service_name_lang;
																
															}
															endforeach;															
														?>
													
														<?php
															$cloth_eng=""; $cloth_lang=""; 
															foreach ($laundry_cloth->result() as $clothrow):
							
															if($clothrow->id==$pricerow->cloth_id)
															{
																$cloth_eng=strtoupper($clothrow->cloth_type);
																$cloth_lang=$clothrow->cloth_type_lang;
															}
															endforeach;
														
														?> 
														
														<?php echo $cloth_eng ."<br/><span style='font-size:10px;'>". $ser_eng ."</span>"; ?> <br/>
														<!-- <?php echo $ser_lang ." ". $cloth_lang; ?> <br/> -->
														
														
														<span style="font-size:10px;">
														
														<?php if($ordertemprow->garment_brand!="") echo $ordertemprow->garment_brand ."/"; ?> 
														<?php if($ordertemprow->garment_pack!="") echo $ordertemprow->garment_pack ."/"; ?>  
														<?php if($ordertemprow->garment_starch!="") echo $ordertemprow->garment_starch ."/"; ?>  
														<?php if($ordertemprow->garment_defect!="") echo $ordertemprow->garment_defect ."/"; ?>  
														<?php if($ordertemprow->garment_color!="") echo $ordertemprow->garment_color;?>  
														 
														</span>
														
													</td> 
													
													<td class="no-line text-center" >  <?php echo $Qty=$ordertemprow->order_qty; 
													
													 ?> </td>
													 
													<td class=" no-line text-center" >  <?php echo $sys_curr ." " . sprintf('%0.3f',$pricerow->price); ?> </td> 
													
													
													
													
													
													<td class=" no-line text-right" > 
														<?php 
														if($Short_Code==$pricerow->id)
														{
															$Price=$pricerow->price;
															echo $sys_curr." " . sprintf('%0.3f',$DispPrice=($Price*$Qty));
															$TotalAmt=$TotalAmt+$DispPrice;
															
														}
													
													endforeach; ?>
													
													
														
													
													</td> 													
													
													
													</tr>
												<?php endforeach; ?>
								<tr>
    								<td colspan="2"></td>
    								
    								
    								<td class=" text-center"><?php echo $row->total_qty; ?> </td>
									<td class=" text-center"><?php echo lang('Sub Total'); ?> : </td>
    								
    								<td class=" text-right"><?php echo $sys_curr ." " . sprintf('%0.3f', $TotalAmt); ?>  </td>
    							</tr>
								
								<?php if($row->disc_amt!=0) { ?> 
								<tr>
    								<td colspan="3"></td>
    								
    								
    								<td class=" text-center"> </td>
									<td class=" text-center"><?php echo lang('Discount'); ?>  : </td>
    								
    								<td class=" text-right"> <?php echo $sys_curr ." -" . sprintf('%0.3f', $row->disc_amt); ?>  </td>
    							</tr>
								<?php } ?>
								
								
								<tr>
					<?php
					$TotalQty=0; $SubTotalAmt=$TotalAmt; $Sr=0; $GrandTotalAmt=0; $Minuscharges=0; $Pluscharges=0;
											$dis_charge=unserialize($row->discount);
											
											$cust_charge=$row->cust_charges;
											$cust_charge=unserialize($cust_charge);
											$this->db->order_by("transaction");
											$charge_list=$this->db->get('tax_charges');
											
											foreach ($charge_list->result() as $chargerow):
											
												if(!empty($cust_charge)) 
												{	foreach ($cust_charge as $chargeId) :
													if($chargerow->charge_id==$chargeId) {
													?>
													
													
													
													
														 <?php //echo $chargerow->charge_name; ?> 
													
													
													<!-- Percentage Section --> 
													
													<?php 
													
													if($chargerow->charge_type=="percentage") { //echo "(".  $chargerow->charge_amt ."% )";
													?>
													   												
													
													
													<?php 
													
													/* Minus Transaction Amount Calculation */
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.3f",($SubTotalAmt*$chargerow->charge_amt/100)); $Minuscharges=$Minuscharges+$DispCal;  
													
													?>
												
												
													<?php 
													}		// minus if end 
													?>
													
													<?php 
													/* Plus Transaction Amount Calculation */
													if($chargerow->transaction==1) {  $PlusDispCal=0; $PlusDispCal=sprintf("%0.3f",(($SubTotalAmt+$Minuscharges)*($chargerow->charge_amt/100))); 
													$Pluscharges=$Pluscharges+$PlusDispCal;
													?>
													
													<?php
													}		// plus if end 
													} 		// percentage if end
													?>		<!-- End Percentage Section -->
													
													
												<!-- Amount Section --> 
													<?php
													if($chargerow->charge_type=="amount") { 
													?>
													:  												
													
													<?php 
													
													if($chargerow->transaction==0) { $DispCal=0; $DispCal="-".sprintf("%0.3f", $chargerow->charge_amt); $Minuscharges=$Minuscharges+$DispCal; 
													?>
													
													<?php
													}
													?>

													<?php if($chargerow->transaction==1) {  $PlusDispCal=0; $PlusDispCal=sprintf("%0.3f", $chargerow->charge_amt); $Pluscharges=$Pluscharges+$PlusDispCal;
													?>
													
													<?php
													}		// plus if end 
													}
													?> 
													<!-- End Amount Section -->
													
													
													
													
													<?php
													}
												
													endforeach;
													
												}
											endforeach;	
											foreach($dis_charge as $disp) {
											echo "<tr> <td  colspan='3'></td> <td style='text-align:center;'>". $disp['charge_name'] . " : </td>";
											echo "<td style='text-align:right;'>". $sys_curr ." " . $disp['charge_amt']. "</td></tr>"; }
											?>	
											
												
											
    							<tr>
    								
    								<td class="thick-line" colspan="3"></td>
    							
    								<td class="thick-line text-center"><strong><?php echo lang('Net Amount'); ?> </strong></td>
    								<td class="thick-line text-right">  <?php  echo $sys_curr ." " . sprintf('%0.3f',$row->total_paid); ?> </td>
									
								</tr>
								<tr> <td class="thick-line" colspan="6"></td></tr>
								
    						</tbody>
    					</table>
    				</div>
    			</div>
				<center> <?php echo lang('Thankfull'); ?> </center> <br/>

    			 
    	</div>
    </div>
</div>
<?php endforeach; ?>         
</body>
<html>

