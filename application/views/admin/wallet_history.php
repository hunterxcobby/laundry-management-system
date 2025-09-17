<div class="">
						
			<form class="form-horizontal " id="user_edit-form" method="post" action="<?php echo base_url();?>index.php/admin/wallte_crud/add/<?php echo $custId; ?>">
			
			<!-- <?php echo $custId; ?> -->
			
			<div class="form-group">										
													
			<label class="col-sm-3 control-label no-padding-right" for="remarks"> Add Amount  : </label>
			<div class="col-sm-3">
				<input type="text" name="wallet_amount" class="form-control" value="1000" required  />
			</div>

			<div class="col-md-3">
					<input class="btn btn-success btn-sm" type="submit" value=" &nbsp;&nbsp; Proceed &nbsp;&nbsp;">
			</div>


			</div>

			<hr/>


			<table class="table">
			<tr>
					<th> # </th>
					<th> #Trans ID </th>
					<th> Trans Date </th>
					<th> Credit </th>
					<th> Debit </th>
					<th> Action </th>
			</tr>
			<tbody>
				<?php
				$sr=1;
				$this->db->order_by('wallet_id','desc');
				$walletData=$this->db->get_where('wallet_history', array('customer_id' =>$custId))->result();
				$this->db->select_sum('payment_amt');
				$walletCredit=$this->db->get_where('wallet_history', array('customer_id' =>$custId,'credit_debit'=>'credit'))->row()->payment_amt;
				$this->db->select_sum('payment_amt');
				$walletDebit=$this->db->get_where('wallet_history', array('customer_id' =>$custId,'credit_debit'=>'debit'))->row()->payment_amt;

				foreach($walletData as $walletRow)
				{	echo "<tr>";
					echo "<td>".$sr."</td>";	
					echo "<td>".$walletRow->payment_trans_id."</td>";	
					echo "<td>".date('d-M-Y',strtotime($walletRow->payment_date))."</td>";	
					if($walletRow->credit_debit=='credit') 
					{	echo "<td>".$walletRow->payment_amt."</td>"; 
						echo "<td> - </td>";
					?>	
						<td> <a href='<?php echo base_url();?>index.php/admin/wallte_crud/delete/<?php echo $walletRow->wallet_id; ?>' onclick="return confirm('<?php echo lang('Delete_Info'); ?>');" > Delete </a> </td>
					<?php	
					}
					if($walletRow->credit_debit=='debit') 
					{	
						echo "<td> - </td>";
						echo "<td>".$walletRow->payment_amt."</td>"; 
						echo "<td> </td>"; 
					}
					
					$sr++;
				}		
				?>
			
			</tbody>
			<tfoot>
				<tr> <th> </th> <th> </th>
					 <th> Wallter Balance => </th>
					 <th> <?=$walletCredit?> </th>
					 <th> <?=$walletDebit?> </th>
					 <th> <?=$walletCredit - $walletDebit?> </th>
				</tr>	 
			</tfoot>
			</table>	
										
			<!-- <div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Save'); ?> &nbsp;&nbsp;">
						
						&nbsp; &nbsp; &nbsp;														
						&nbsp; &nbsp; &nbsp;
					<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
						
					
				</div>
			</div>
			 -->
			</form>
		</div>
		



	
		