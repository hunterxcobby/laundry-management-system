<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Orders Bar Code </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
  <link rel="stylesheet" href="../paper.css">
  <style>
    @page { size: 1.5in auto } /* output size */
    body.receipt .sheet { width: 1.5in; height: auto } /* sheet size */
    @media print { body.receipt { width: 1.5in } } /* fix for Chrome */
  </style>
</head>

<body class="receipt" onload="window.print();">
<center>
  <section class="sheet padding-10mm" >
   
  
			 <?php foreach ($invoice_data as $row): 
				   $laundryStoreId=$row->laundry_store;?>
		
		
				
				<?php //$Count=$row->total_qty;
				
				for($i=1;$i<=$Count; $i++)
				{	
				?>
				<?php //echo $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name; ?>  </span>
						
							<div style="padding-top:10px;">
							 <!-- <span style='font-size:20px;'> <strong> Laundry </strong> </span> <br/>  -->
							 
							 <?php  
							 if($laundryStoreId!='') { echo $this->db->get_where('stores' , array('id' =>$laundryStoreId))->row()->store_name;
							 //echo "<br/>";
							 } 
							 ?> 					
							<!-- Service Name -->
							<?php
								$order_temp = $this->db->get_where('order_temp' , array('order_date' => $row->order_date,'customer_id' => $row->customer_id,'order_invoice' => $row->invoice_no) )->result();
								
								foreach ($order_temp as $ordertemprow): 
									$Short_Code=$ordertemprow->price_shortcode;
									foreach ($price_data->result() as $pricerow): 
										if($Short_Code==$pricerow->id)
										{	$pricerow->short_code; 	}
										else
										{ 	continue; }
									
									$ser_eng=""; $ser_lang=""; 
										foreach($laundry_service->result() as $servicerow): 

										if($servicerow->id==$pricerow->service_id)
										{
											$ser_eng=strtoupper($servicerow->service_name);
											$ser_lang=$servicerow->service_name_lang;
									
										}
										endforeach;
										
									endforeach;
									//echo $ser_eng;
								endforeach;
								
							?>
							<br/>
							
							<!------ End Service Name ----------->
							
							<?php echo $FirstName = $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->first_name; ?> <?php echo $LastName = $this->db->get_where('users' , array('id' =>$row->customer_id))->row()->last_name; ?>  <br/>
							<img src="<?php echo base_url(); ?>barcode/<?php echo $row->invoice_no;?>.png" /> <br/>
							
							<span style="font-size:14px;font-family:serif;">  <?php echo date('j-M-Y', strtotime($row->order_date)); ?> <?php echo date('D', strtotime($row->order_date)); ?> </span> <br/>
							<span style="font-size:18px;font-family:serif;font-weight:bold;"> <?php echo $row->invoice_no; ?> - (<?php echo $i."/".$Count; ?>) </span> <br/> - - - - - - - - 	
							<hr style="border:0px dotted lightgray; width:150px;">
							</div>
							
				<?php
				}
				?>
		
				<?php endforeach; ?>
		
		
		</section>
</center>		
</body>
</html>
    

