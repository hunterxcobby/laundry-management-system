<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/admin/credit_limit/<?php echo $custId; ?>">
			
						
			<div class="form-group">										
													
			<label class="col-sm-3 control-label no-padding-right" for="remarks"> Credit Limit  : </label>
			<div class="col-sm-3">
				<input type="text" name="credit_limit" class="form-control" value="<?= $this->db->get_where('users',array('id' => $custId))->row()->credit_limit?>" required  />
			</div>

			<div class="col-md-3">
					<input class="btn btn-warning btn-sm" type="submit" value=" &nbsp;&nbsp; Update &nbsp;&nbsp;">
			</div>


			</div>

			</form>

			<?php

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

			?>

			<?php

			if($CreditUse!=0)
			{
			?>

			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/admin/credit_crud/add/<?php echo $custId; ?>">
			
			
			
			<div class="form-group">										
													
			<label class="col-sm-3 control-label no-padding-right" for="remarks"> Pay Credit Amount  : </label>
			<div class="col-sm-3">
				<input type="text" name="credit_amount" class="form-control" value="<?=$CreditUse?>" required  />
			</div>

			<div class="col-md-3">
					<input class="btn btn-success btn-sm" type="submit" value=" &nbsp;&nbsp; Pay Now &nbsp;&nbsp;">
			</div>


			</div>

			</form>

			<?php	
			}	
			?>



			<hr/>


			<table class="table">
			<tr>
					<th> # </th>
					<th> #Trans ID </th>
					<th> Trans Date </th>
					<th> Credit Use </th>
					<th> Payment </th>
					<th>  </th>
			</tr>
			<tbody>
				<?php
				$sr=1;
				$this->db->order_by('credit_id','desc');
				$CreditData=$this->db->get_where('credit_history', array('customer_id' =>$custId))->result();
			
				foreach($CreditData as $creditRow)
				{	echo "<tr>";
					echo "<td>".$sr."</td>";	
					echo "<td>".$creditRow->credit_trans_id."</td>";	
					echo "<td>".date('d-M-Y',strtotime($creditRow->credit_trans_date))."</td>";	
					if($creditRow->credit_debit=='debit') 
					{	
						
						echo "<td>".$creditRow->credit_trans_amt."</td>"; 
						echo "<td> - </td>";
						echo "<td> </td>"; 
					}

					if($creditRow->credit_debit=='credit') 
					{	echo "<td> - </td>";
						echo "<td>".$creditRow->credit_trans_amt."</td>"; 
						
					?>	
						<td> <a href='<?php echo base_url();?>index.php/admin/credit_crud/delete/<?php echo $creditRow->credit_id; ?>' onclick="return confirm('<?php echo lang('Delete_Info'); ?>');" > Delete </a> </td>
					<?php	
					}
					
					
					$sr++;
				}		
				?>
			
			</tbody>
			<tfoot>
				<tr> <th> </th> <th> </th>
					 <th> Payable Amount => </th>
					  <th> <?=$Debit?> </th>
					 <th> <?=$Credit?> </th>
					
					 <th> <?=$Debit-$Credit?> </th>
				</tr>	 
			</tfoot>
			</table>	
			
		</div>
		



	
		