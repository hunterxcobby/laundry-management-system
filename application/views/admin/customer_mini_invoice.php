<?php
include('system_currency.php'); ?>
<html>
<head>
        <title> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?>  </title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/minirec.css" />
		<style>@page { size: 58mm 150mm }</style>
    </head>
<center>	

<body onload="window.print();">
		 <?php foreach ($invoice_data as $row): $storeid=$row->laundry_store; ?>
        <div class="content" style="margin-top:-10px;">
            <div style="text-align:center;">
                <img style="display:inline-block; height:50px;width:180px;overflow:auto;" src="<?php echo base_url();?>/assets/images/logo.png">
            </div>
            <div class="title" style="margin-top:0px;">
                <!-- <strong style="font-size:18px;"> <?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?> </strong> <br/> -->
				<?php 
				$storeTaxable=$this->db->get_where('stores' , array('id' =>$storeid))->row()->store_taxable;
				if($row->laundry_store!=0) {

				?>
				<span style='font-weight:bold;'> <?php echo lang('Store Name'); ?>  :  <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_name; ?> </span> <br/>
                <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_add1; ?>
				<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_add2; ?> <br/>
				<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_city; ?> 
				<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_state; ?> -
				<?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_zip; ?> <br/>
				<?php echo lang('Contact'); ?>  : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_phone; ?> 
				<?php echo lang('Email'); ?>  : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_email; ?> <br/>
				<?php echo lang('Tax/Vat No'); ?> : <?php echo $this->db->get_where('stores' , array('id' =>$storeid))->row()->store_tax_no; ?> 
				<?php } ?>
				
            </div>

           <div class="separate-line"></div>
          
            <div class="transaction" >
                <table class="transaction-table" cellspacing="0" cellpadding="0" style="font-size:10px;border" >
				<td colspan="4">
                     <div class="separate-line"></div>
                </td>
				</tr>
				
				
				<tr> <td colspan='1'> <?php echo lang('Invoice'); ?>  : <?php echo $row->invoice_no; ?> </td> <td colspan='3' style="text-align:right;"> <?php echo lang('Date'); ?> :  <?php echo date('j-M-y', strtotime($row->order_date)); echo "<br/> Time : ". $row->order_time; ?>
				</tr> 
				<tr>
				<td colspan="4">
                     <div class="separate-line"></div>
                </td>
				</tr>
				<tr> 
				<?php 
				$CustId=$row->customer_id;  
				$FirstName=$this->db->get_where('users' , array('id' =>$CustId))->result();  
				if($FirstName==TRUE)
				{ $custType=$this->db->get_where('users' , array('id' =>$CustId))->row()->cust_type;
				  $OldOustand=$this->db->get_where('users' , array('id' =>$CustId))->row()->outstand_amt;
				?>
				
				<td colspan="4" style="text-align:center;font-size:13px;font-weight:bold;"> <?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->first_name; ?> <?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->last_name; ?> ( <?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->mobile; ?> ) 
				<br/> 
				Address : 
				<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->address1; ?> 
				<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->address2; ?> 
				<?php echo $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->city; ?> 
				</td> 
				<?php
				}
				?>
				
				</tr>
				
				<tr>
				<td colspan="4">
                     <div class="separate-line"></div>
                </td>
				</tr>
				
				
				<tr> <th style="text-align:left;"> <?php echo lang('Description'); ?>  </th> <th style="text-align:center;"> <?php echo lang('Rate'); ?>  </th>  <th style="text-align:right;"> <?php echo lang('Quantity'); ?>  </th>  <th style="text-align:right;"> <?php echo lang('Total'); ?>  </th>
				</tr>
				
				<tr>
				<td colspan="5">
                     <div class="separate-line"></div>
                </td>
				
					
				</tr>
				
					<?php $TotalQty=0; $TotalAmt=0; $Sr=0;
					$order_temp = $this->db->get_where('order_temp' , array('order_date' => $row->order_date,'customer_id' => $row->customer_id,'order_invoice' => $row->invoice_no) )->result();
					?>
					<?php foreach ($order_temp as $ordertemprow): ?>
					<tr>
						
						
						
						<?php $Short_Code=$ordertemprow->price_shortcode; ?>
						
						<?php foreach ($price_data->result() as $pricerow): 
							if($Short_Code==$pricerow->id)
							{
								$pricerow->short_code;
							}
							else
							{
								continue;
							}	
							?>
						
					
						<td style="width:180px;padding-bottom:4px;"> 
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
							
							<?php echo $cloth_eng ."<br/><span style='font-size:7px;'>". $ser_eng ."</span>"; ?> <br/>
							<!-- <?php echo $ser_lang ." ". $cloth_lang; ?> <br/> -->

							<!-- <?php echo $ser_eng ." ". $cloth_eng; ?> <br/>
							<?php echo $ser_lang ." ". $cloth_lang; ?> <br/> -->
							
							
							<?php 
							if($ordertemprow->garment_unit=="Kg") 
							{ ?>	
											<table style="margin-top:-5px;margin-left:-4px;">
											<tr>
											<td>
												<table border="0" style="font-size:8x;border-collapse: collapse;" >
												<?php
												
												$garmentkgitems=unserialize($ordertemprow->garment_kg_desc);  
												foreach($garmentkgitems as $kgname)
												{	echo "<tr> <td style='font-size:7px;padding:-1px;'>" . $kgname . "</td></tr>"; 
												}	
												?>
												</table>
											</td>
											<td>
												<table border="0" style="border-collapse: collapse;width:25px;font-size:7px;margin-left:-8px;" >
												<?php
												$garmentkgqty=unserialize($ordertemprow->garment_kg_qty);  
												$garmentkgqty=array_filter($garmentkgqty);  
												foreach($garmentkgqty as $kgqty)
												{	echo "<tr><td style='text-align:right;width:10px;font-size:7px;padding:-1px;'> x " . $kgqty . "</td></tr>";
												}	
												?>
												</table>
											</td>
											</tr>
											</table>
											
											
							<?php }  ?>			
						
											
							
											
							<span style="font-size:7px;">
							
							<?php if($ordertemprow->garment_brand!="") echo $ordertemprow->garment_brand ."/"; ?> 
							<?php if($ordertemprow->garment_pack!="") echo $ordertemprow->garment_pack ."/"; ?>  
							<?php if($ordertemprow->garment_starch!="") echo $ordertemprow->garment_starch ."/"; ?>  
							<?php if($ordertemprow->garment_defect!="") echo $ordertemprow->garment_defect ."/"; ?>  
							<?php if($ordertemprow->garment_color!="") echo $ordertemprow->garment_color;?>  
							 
							</span>
						</td> 
						
						<td align="right" > <?php echo sprintf('%0.3f',$ordertemprow->order_price); ?> </td> 
						
						<td class='sell-price' align="left"> <?php echo $Qty=$ordertemprow->order_qty; 
						
						 ?> &nbsp; </td>
						
						
						
						<td class='final-price'> 
							<?php 
							if($Short_Code==$pricerow->id)
							{
								$Price=$ordertemprow->order_price;					// new pos price
								echo sprintf('%0.3f',$DispPrice=($Price*$Qty));
								$TotalAmt=$TotalAmt+$DispPrice;
								
							}
						
						endforeach; ?>
						
						</td> 													
						
						
						</tr>
					<?php endforeach; ?>
												
                    <tr >
                        <td colspan="4">
                            <div class="separate-line"></div>
                        </td>
                    </tr>
					
					<tr>
                        <td colspan="2" class="final-price" >
                            Total   :                     </td>
						<td style="text-align:right;">(<?php echo $row->total_qty; ?>)</td>	
                        <td class="final-price">
                            <?php echo sprintf('%0.3f', $TotalAmt); ?>                 
						</td>
                    </tr>
                    

                    <?php
                   		$vatAmt=($storeTaxable=='yes')? $TotalAmt*5/100 : 0.00;
                   		$GrantTotal=$TotalAmt+$vatAmt;
                   		$PayAmount=$row->amt_paid;
                   		if($PayAmount=='') $PayAmount=0.000;
                   		$OutStandAmount=$GrantTotal-$PayAmount;
                   	
                   	if($storeTaxable=='yes')
                   	{	
                   	?>
                   	<tr >
                        <td colspan="4">
                            <div class="separate-line"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="final-price" >
                            VAT(5%)  :                     </td>
                        <td></td>    
						<td class="final-price">
                            <?php echo sprintf('%0.3f', $vatAmt); ?>                 
						</td>
                    </tr>
                <?php } ?>
                    
                    <!-- END VAT CALC -->

                	
					<?php if($row->disc_amt!=0) { ?> 
					<tr>
                        <td colspan="2" class="final-price" >
                            <?php echo lang('Discount'); ?>  :                     </td>
						<td style="text-align:right;"> </td>	
                        <td class="final-price">
                            -<?php echo sprintf('%0.3f', $row->disc_amt); ?>                 
						</td>
                    </tr>
					<?php } ?>
					<?php if($row->cust_extra_amt!=0) { ?> 
					<tr>
                        <td colspan="2" class="final-price" >
                            <?php echo 'Extra Charges'; ?>  :                     </td>
						<td style="text-align:right;"> </td>	
                        <td class="final-price">
                            <?php echo sprintf('%0.3f', $row->cust_extra_amt); ?>                 
						</td>
                    </tr>
					<?php } ?>
					
						</tr>						
						<tr >
							<td colspan="4">
								<div class="separate-line"></div>
							</td>
						</tr>
							
						<tr>
							<td colspan="2" class="final-price" style="font-size:12px;" >
							   Grand Total  :                     </td>
							<td class="final-price" style="font-size:12px;text-align:right;" colspan="2">
								 <?php  echo sprintf('%0.3f',$GrantTotal-$row->disc_amt); ?>                   
							</td>
						</tr>
						<tr >
							<td colspan="4">
								<div class="separate-line"></div>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="final-price" style="font-size:10px;" >
							   Paid Amount  :                     </td>
							<td class="final-price" style="font-size:10px;text-align:right;" colspan="2">
								 <?php  echo sprintf('%0.3f',$PayAmount); ?>                   
							</td>
						</tr>
												<tr >
							<td colspan="4">
								<div class="separate-line"></div>
							</td>
						</tr>
						
						<?php
						$custrowid=$row->customer_id;
						/* Outstanding AMount */
						$this->db->select();
						$this->db->select_sum('total_paid');
						$this->db->where("customer_id",$custrowid);
						$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

						$this->db->select();
						$this->db->select_sum('amt_paid');
						$this->db->where("customer_id",$custrowid);
						$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

						$OutStandAmount=$OldOustand+$TotalAmount-$PaidAmount;

						if($storeTaxable=='yes')
						{
							$vatAmt=$TotalAmount*5/100;
							$OutStandAmount=$OldOustand+$OutStandAmount+$vatAmt;
						}	
						/* End Outstand Amount */
						

						$this->db->select_sum('total_qty');
						$this->db->where('customer_id', $UserID)->where("(amt_paidby='notpaid' OR amt_paidby='')");
						
						$TotalOutStandQty=$this->db->get('customer_order')->row()->total_qty;
						?>	
						<tr>
							<td colspan="2" class="final-price" style="font-size:12px;" >
							    Outstanding :<br><small> (<?=date('j-m-y h:i:sa')?>)   : </small>                     </td>
							<td class="final-price" style="font-size:12px;text-align:right;" colspan="2">
								 <?php  echo sprintf('%0.3f',$OutStandAmount); ?>                   
							</td>
						</tr>
						<tr >
							<td colspan="4">
								<div class="separate-line"></div>
							</td>
						</tr>

						

						</div>
					</div>
					
					
					<!-- End Calc -->
                                        
                    
                    
                    <tr >
						<td colspan="4" style="text-align:center;"> <img src="<?php echo base_url(); ?>barcode/<?=$row->invoice_no?>.png"  style="height:40px;width:150px;"/> </td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="separate-line"></div>
						</td>
					</tr>
					<?php
					if($row->remarks!='')
					{ ?>	
					<tr> <td colspan="4"> Remarks : <?=$row->remarks?> </td>
					<tr>
						<td colspan="4">
							<div class="separate-line"></div>
						</td>
					</tr>
					<?php
					} ?>

					<tr> <td colspan='4'> Terms & Conditions : </td> </tr>
					<tr> <td colspan='4'> <pre style="white-space: pre-wrap; font-family:monospace;"><?php echo $this->db->get_where('settings' , array('id' =>'1'))->row()->terms; ?> </pre> </td> </tr>
					<tr>
						<td colspan="4">
							<div class="separate-line"></div>
						</td>
					</tr>
					
                    <tr>
						<td colspan="4" align="center">
							<h3> Scan and Download Andriod Mobile App </h3> 
							<img src='<?=base_url()?>assets/qr_app_link.png' style='height:100px;width:100px;'>
						</td>
					</tr>
					
					
                    <tr>
						<td colspan="4">
							<div class="separate-line"></div>
						</td>
					</tr>
					<tr style="text-align:center;">
                        <td colspan="4">
                           <span style="margin-top:10px;"> <?php echo lang('Thank'); ?> 
						   </span>
                        </td>
                    </tr>
					
					
                  
                </table>
            </div>
            <div>
 <?php endforeach; ?>               
</center>		
    </body>
</html>