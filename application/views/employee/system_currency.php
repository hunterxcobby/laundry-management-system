<?php
$syscurrrow = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_currency;
$syscurrshow = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_currency_show;
$world_curr = $this->db->get('currencies');

foreach($world_curr->result() as $currencyrow) :
 
if($syscurrrow==$currencyrow->country_name)
{
		$sys_curr_symbol=$currencyrow->currency_symbol; 
		$sys_curr_code=$currencyrow->code; 	
		
		if($syscurrshow=="symbol") $sys_curr=$sys_curr_symbol;
		if($syscurrshow=="code") $sys_curr=$sys_curr_code;
} 
endforeach;																			
?>