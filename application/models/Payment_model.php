<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *	@author 	: Ajit Dhanawade / 8108702999
 *	date		: 07 June, 2017
 *	Laundry Management Application
 *	ajitrajyash@gmail.com
 */
 
class Payment_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function payment_token($mobile,$sms)
	{
		/******************* Mobile Script *****************************/ 
			$xml_data ='<?xml version="1.0" encoding="utf-8"?>
			<API3G>
			<CompanyToken>50EC6AD4-1257-452E-8F35-B27EDA0CB14C</CompanyToken>
			<Request>createToken</Request>
			<Transaction>
			<PaymentAmount>0.50</PaymentAmount>
			<PaymentCurrency>USD</PaymentCurrency>
			<CompanyRef>KDIEOM</CompanyRef>
			<RedirectURL>https://www.google.com</RedirectURL>
			<BackURL>https://www.google.com</BackURL>
			<CompanyRefUnique>0</CompanyRefUnique>
			<PTL>5</PTL>
			</Transaction>
			<Services>
			  <Service>
			    <ServiceType>48565</ServiceType>
			    <ServiceDescription>Flight from Nairobi to Diani</ServiceDescription>
			    <ServiceDate>2022/12/20 19:00</ServiceDate>
			  </Service>
			</Services>
			</API3G>';

			$URL = "https://secure.3gdirectpay.com/API/v6/"; 

				$ch = curl_init($URL);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
				curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				echo $output = curl_exec($ch);

				curl_close($ch);
				
				//return true;
									
			/****************** End Mobile *******************/
	}
	
}
?>