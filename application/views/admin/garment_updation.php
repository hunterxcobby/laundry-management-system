<?php 
include('system_currency.php');

foreach ($garment_data as $row): ?>


		<div class="">
			
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/pos/add/<?php echo $row->id;?>">
			
			<?php $ShortCode=$row->short_code; ?>
			<?php $ServiceName=strtoupper($this->db->get_where('services' , array('id' => $row->service_id))->row()->service_name); 
				 //$ServiceUnit=ucwords($this->db->get_where('services' , array('id' => $row->service_id))->row()->service_unit);
				 $ServiceUnit=ucwords($row->service_unit);
			?>
			<?php $ClothName=strtoupper($this->db->get_where('cloths' , array('id' => $row->cloth_id))->row()->cloth_type); ?>
			
			<?php $GarmentsInfo=$ServiceName ." ".$ClothName; ?>
			
			<?php	
			$filename="assets/stock/".$row->id.".png";
			if (!file_exists($filename)) {   
				$filefound = 0;                         
			} else 
			{   $filefound=$row->id; } 
			?>
															
			<?php
			foreach($_SESSION['shopping_cart'] as $key => $product): 
			if($product['id']==$row->id)
			{	$pack=$product['pack'];
				$starch=$product['starch'];	
				$defect=$product['defect'];	
				$color=$product['color'];	
				$brand=$product['brand'];	
			?>	
		
			<div class="well well-sm" style="background:#F5FFFA;margin-top:-9px;">
			
				<h4 class="gray" style="border:1px solid lightgray; padding:5px; margin:-10px;background:#E8F8F5; "> <span > <?php echo $ServiceName; ?> <?php echo $ClothName; ?> ( <img src="<?php echo base_url();?>assets/stock/<?php echo $filefound;?>.png" style="height:25px; width:25px;"> ) - <b> <?php echo $sys_curr; ?>  <?php echo $row->price; ?>   </span> </b>  </h4> 
				
				<h5 style="margin-left:10px;margin-top:20px;"> <?php echo lang('Unit'); ?>  : <input class="form-control"  id="spinner3" name="quantity"  value="<?php echo $product['quantity']; ?>" autofocus/> 
				<?php 
					  if($ServiceUnit=="Kg" || $ServiceUnit=="Mtr") { echo $ServiceUnit; $step="0.1";}
					  else {  echo lang(''.strtolower($ServiceUnit).'') ; $step="1"; } 
				?> 
				</h5> 
				<h5 style="margin-left:10px;margin-top:20px;"> Price  : <input class="form-control"  id="newprice" name="newprice"  value="<?=sprintf('%0.3f',$row->price)?>" > </h5>
				
			</div>
			
			<?php if($ServiceUnit!="Kg") { ?>	
			
			<div class="well well-sm" style="background:#F5FFFA;margin-top:-12px;">
				<h4 class="gray" style="border:1px solid lightgray; padding:5px; margin:-10px;background:#E8F8F5; "> <?php echo lang('Garment Brand'); ?>  : </h4>
				
				
				<table style="margin-top:10px;">
				<tr> 
					<td style="padding:10px;"> <input name="gar_brands" value="" type="radio" class="ace" checked />
				<span class="lbl"> <?php echo lang('None'); ?>  </span>
					</td>
					
					<?php
					$GarmentBrands=$this->db->get('garment_brand');
					$i=1;
					foreach($GarmentBrands->result() as $brandrow) :
					if($i%8==0) echo "</tr> <tr> <td> &nbsp; </td>"; 
					if($brand==$brandrow->brand_name)
					{	
					echo '<td style="padding:10px;"> <input name="gar_brands" value="'.$brandrow->brand_name.'" type="radio" checked class="ace" />';
					echo '<span class="lbl"> '.$brandrow->brand_name.' </span></td>';
					}
					else
					{	
					echo '<td style="padding:10px;"> <input name="gar_brands" value="'.$brandrow->brand_name.'" type="radio" class="ace" />';
					echo '<span class="lbl"> '.$brandrow->brand_name.' </span></td>';
					}	
					$i++;
					endforeach;
					?>
					
				</tr>
				</table>
			
		   </div>		
			
			
						
			
			<div class="well well-sm" style="background:#F5FFFA;margin-top:-12px;">
				<h4 class="gray" style="border:1px solid lightgray; padding:5px; margin:-10px;background:#E8F8F5; "> <?php echo lang('Garment Defects'); ?>  : </h4>
				
				
				<table style="margin-top:10px;">
				<tr> 
					<td style="padding:10px;"> <input name="gar_defects" value="" type="radio" class="ace" checked />
				<span class="lbl"> <?php echo lang('None'); ?>  </span>
					</td>
					<?php
					$GarmentDefects=$this->db->get('garment_defect');
					$i=1;
					foreach($GarmentDefects->result() as $defectrow) :
					if($i%6==0) echo "</tr> <tr> <td> &nbsp; </td>"; 
					if($defect==$defectrow->defect_name)
					{	
					echo '<td style="padding:10px;"> <input name="gar_defects" value="'.$defectrow->defect_name.'" type="radio" checked class="ace" />';
					echo '<span class="lbl"> '.$defectrow->defect_name.' </span></td>';
					}
					else
					{	
					echo '<td style="padding:10px;"> <input name="gar_defects" value="'.$defectrow->defect_name.'" type="radio" class="ace" />';
					echo '<span class="lbl"> '.$defectrow->defect_name.' </span></td>';
					}	
					$i++;
					endforeach;
					?>
				</tr>
				</table>
				
				
		   </div>		
				
			
			
			
			<div class="well well-sm" style="background:#F5FFFA;margin-top:-12px;">
				<h4 class="gray" style="border:1px solid lightgray; padding:5px; margin:-10px;background:#E8F8F5; "> <?php echo lang('Garment Color'); ?>  : </h4>
				
				<table style="margin-top:10px;">

				<tr> 
					<td style="padding:10px;"> <input name="gar_color" value="" type="radio" class="ace" checked />
				<span class="lbl"> <?php echo lang('None'); ?>  </span>
					</td>
					<?php
					$GarmentColors=$this->db->get('garment_color');
					$i=1;
					foreach($GarmentColors->result() as $colorrow) :
					if($i%6==0) echo "</tr> <tr> <td> &nbsp; </td>"; 
					if($color==$colorrow->color_name)
					{	
					echo '<td style="padding:10px;"> <input name="gar_color" value="'.$colorrow->color_name.'" type="radio" checked class="ace" />';
					echo '<span class="lbl"> <img src="'.base_url().'assets/gcolors/'.$colorrow->id.'.png" style="height:25px; width:25px;border:1px solid #D3D3D3;"> '.$colorrow->color_name.' </span></td>';
					}
					else
					{
					echo '<td style="padding:10px;"> <input name="gar_color" value="'.$colorrow->color_name.'" type="radio" class="ace" />';
					echo '<span class="lbl"> <img src="'.base_url().'assets/gcolors/'.$colorrow->id.'.png" style="height:25px; width:25px;border:1px solid #D3D3D3;"> '.$colorrow->color_name.' </span></td>';
					}						
					$i++;
					endforeach;
					?>
				</tr>
				</table>
				
				
			</div>
			
		
			<!-- Garment Selection -->
			<input type="hidden" name="gar_pack" value="" />
			<input type="hidden" name="gar_starch" value="" />
			
			<!------------------------------>
		
		<?php } ?>
		
		<?php if($ServiceUnit=="Kg") { ?>	
	
		<div class="well well-sm" style="background:#F5FFFA;margin-top:-12px;">
				<h4 class="gray" style="border:1px solid lightgray; padding:5px; margin:-10px;background:#E8F8F5; "> <?php echo lang('Garment Details'); ?>  : </h4>
				
				<div class="form-group" style="margin-top:15px;">
				
						<table  class="table table-hover small-text" id="tb">
							<tr class="tr-header">

							<th> <?php echo lang('Garment Name'); ?> </th>
							<th><?php echo lang('Quantity'); ?> </th>
							<!-- <th>Color</th> -->
							<th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
							<tr>
							<td>
							<select name="gar_desc_kg[]" class="form-control">
							   <option value="" selected> <?php echo lang('Select'); ?> <?php echo lang('Garment'); ?>  </option>
							   <?php $this->db->order_by("cloth_type"); $Cloths=$this->db->get('cloths'); 
							foreach($Cloths->result() as $clothrow) :
							echo '<option value="'.$clothrow->cloth_type.'">'.$clothrow->cloth_type.'</option>';
							endforeach;	
							?>
							</td>
							<td><input type="text" name="gar_desc_qty[]" class="form-control"></td>
							<!--
							<td>
							<select name="gar_desc_color[]" class="form-control">
							   <option value="" selected>Select Color </option>
							   <?php $this->db->order_by("color_name"); $Colors=$this->db->get('garment_color'); 
							foreach($Colors->result() as $colorow) :
							echo '<option value="'.$colorow->color_name.'">'.$colorow->color_name.'</option>';
							endforeach;	
							?>
							</td> -->
							
							<td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
							</tr>
						</table>
					
				</div>
		   </div>	
		
		<?php } ?>
		
			
			<input type="hidden" name="product_id" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="name" value="<?php echo $row->short_code; ?>" />
			<input type="hidden" name="price" value="<?php echo $row->price;?>" />
			<input type="hidden" name="gar_unit" value="<?php echo $ServiceUnit;?>" />
			<input type="hidden" name="tot" id="tot_len" value="<?php echo count($garment_data)+1; ?>" />
															
			<div class="clearfix form-actions" style="margin-top:-10px;">
				<div class="col-md-offset-3 col-md-12">
					<input class="btn btn-success" name="add_to_cart"  type="submit" value=" &nbsp;&nbsp; <?php echo lang('Proceed'); ?> &nbsp;&nbsp;" style="margin-left:120px;">
			
				</div>
			</div>
			
			</form>
		</div>
			<?php 
			}
			endforeach; ?>
			
		
<?php endforeach; ?>



	<script type="text/javascript">
			jQuery(function($) {
			
					$('#spinner3').ace_spinner({value:1,min:1,max:100,step:<?php echo $step;?>, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				
				$('#addMore').on('click', function() {
							  var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
							  data.find("input").val('');
					 });
					 $(document).on('click', '.remove', function() {
						 var trIndex = $(this).closest("tr").index();
							if(trIndex>1) {
							 $(this).closest("tr").remove();
						   } else {
							 alert("Sorry!! Can't remove first row!");
						   }
					  });
						
				
			
			})
		</script>


	
		