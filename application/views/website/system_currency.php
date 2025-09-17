<?php
$syscurrrow = $this->db->get_where('settings' , array('id' =>'1'))->row()->sys_currency;
$world_curr = $this->db->get('currencies');

foreach($world_curr->result() as $currencyrow) :
 
if($syscurrrow==$currencyrow->country_name)
{ $sys_curr=$currencyrow->code; } 
endforeach;																			
?>