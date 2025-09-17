<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *	@author 	: Red Planet Computers / 8767228990
 *	date		: 19 Dec, 2018
 *	Laundry Management Application
 *	rpcits2013@gmail.com
 */
 
class Bulk_message extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

    function  bulk_sms($mobile,$sms) { }

    function bulk_email($email,$subject,$message) { }
	
	function bulk_sms_stop($mobile,$sms)
	{
		/******************* Mobile Script *****************************/ 
			$xml_data ='<?xml version="1.0"?>
			<parent>
			<child>
			<user>RPCOMP</user>
			<key>efa5e1cec7</key>
			<mobile>'.$mobile.'</mobile>
			<message>'.$sms.'</message>
			<accusage>1</accusage>
			<senderid>LNDRYM</senderid>
			</child>
			</parent>';

			$URL = "http://sms.bulkssms.com/submitsms.jsp?"; 

				$ch = curl_init($URL);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
				curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				echo $output = curl_exec($ch);

				$currentDate=date("d/m/Y h:i:sA");

				$smsData = array('user_id' => 'FIRIMP','mobile_no' => $mobile, 'message' => $sms, 'status'=> $output, 'sent_time' => $currentDate );
				if($this->db->insert('sms_logs', $smsData)===TRUE) { echo "sms log generation"; }

				curl_close($ch);
				
				//return true;
									
			/****************** End Mobile *******************/
	}
	
	function bulk_email_stop($email,$subject,$message)
	{
				//Email Script
			
				$smtpUser='info@redplanetcomputers.com';				//your  gmail/email account with less security 
				$smtpPassword='oseyrybiihbilqim';							// your gmail/email sender password
				$smtpName='Al Hayat Laundry';				// your sender name 
				
				$this->load->library('email');
				$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => $smtpUser,			    
				'smtp_pass' => $smtpPassword,							
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
				);
				
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");
						
				$this->email->to($email);
				$this->email->from($smtpUser,$smtpName);
				$this->email->subject($subject);
				$this->email->message($message);
				//Send email
				$this->email->send();

				echo $output = $this->email->print_debugger();

				// $currentDate=date("d/m/Y h:i:sA");

				// $emailData = array('user_id' => 'FIRIMP','email_add' => $email, 'email_msg' => $message, 'status'=> $output, 'sent_time' => $currentDate );
				// if($this->db->insert('email_logs', $emailData)===TRUE) { echo "email log generation"; }

			
				return true;
				
				//End Email Script	
	}


	function bulk_whatsapp($mobile, $message)
	{

		$authKey="REDPLANET66VD";

// 		$code="+971";							// country telephone code
// 		$mobile=(int)($mobile);							
// 		echo $mobileNumber="{$code}{$mobile}"; //FOR MULTIPLE NUMBER USE Comma Separated , WITHOUT SPACEBAR
		$mobileNumber=$mobile; //FOR MULTIPLE NUMBER USE Comma Separated , WITHOUT SPACEBAR

		// Ex. $mobileNumber="91XXXXXXXXXX,91XXXXXXXXXX,91XXXXXXXXXX";

		$url="https://wapi.co.in/sendMessage.php";

		$postData = array(
		'AUTH_KEY' => $authKey,
		'phone' => $mobileNumber,
		'message' => $message
		);

		$ch = curl_init();

		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
		));

		//Ignore SSL certificate verification

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//get response

		$output = curl_exec($ch);

		//Print error if any

		if(curl_errno($ch))
		{
		echo 'error:' . curl_error($ch);
		}
		curl_close($ch);

		// echo $output;

		return true;

	}	

	function message_cust_data($invoice_no,$custid)
	{
		
		$customer_name=$this->db->get_where('users',array('id' => $custid))->row()->first_name;
		$customer_name.=" ".$this->db->get_where('users',array('id' => $custid))->row()->last_name;
		$customer_mobile=$this->db->get_where('users',array('id' => $custid))->row()->mobile;
		$customer_email=$this->db->get_where('users',array('id' => $custid))->row()->email_id;
		$customer_store=$this->db->get_where('users',array('id' => $custid))->row()->laundry_store;

		$storeTaxable=$this->db->get_where('stores' , array('id' =>$custid))->row()->store_taxable;


		/* Outstanding AMount */
			$this->db->select('*');
			$this->db->select_sum('total_paid');
			$this->db->where("customer_id",$custid);
			$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

			$this->db->select();
			$this->db->select_sum('amt_paid');
			$this->db->where("customer_id",$custid);
			$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

			$OutStandAmount=$TotalAmount-$PaidAmount;

			if($storeTaxable=='yes')
			{
				$vatAmt=$TotalAmount*5/100;
				$OutStandAmount=$OutStandAmount+$vatAmt;
			}
			$OutStandAmount=sprintf('%0.3f',$OutStandAmount);	
		/* End Outstand Amount */

		$cust_outstand_data= array(

		'customer_name' => $customer_name,
		'customer_mobile' => $customer_mobile,
		'customer_email' => $customer_email,
		'customer_outstand_amount' => $OutStandAmount,
		'customer_invoice' => $invoice_no,

		);

		return $cust_outstand_data;
		
	}


	function send_message($message_for,$invoice_no,$cust_id)
	{
		/**** Getting All Customer Details *********/

		$customer_name=$this->db->get_where('users',array('id' => $cust_id))->row()->first_name;
		$customer_mobile=$this->db->get_where('users',array('id' => $cust_id))->row()->mobile;
		$customer_email=$this->db->get_where('users',array('id' => $cust_id))->row()->email_id;
		$customer_store=$this->db->get_where('users',array('id' => $cust_id))->row()->laundry_store;

		$storeTaxable=$this->db->get_where('stores' , array('id' =>$cust_id))->row()->store_taxable;

		$customer_invoice=$invoice_no;
		$customer_invoice_amt=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->total_paid;
		$customer_paid_amt=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->amt_paid;
		
		$customer_order_pickup_date=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->pickup_date;
		$customer_order_delivery_date=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->delivery_date;

		$customer_order_pickup_date=date('d-M-y',strtotime($customer_order_pickup_date));
		$customer_order_delivery_date=date('d-M-y',strtotime($customer_order_delivery_date));

		
		$emp_pickup_id=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->pickup_by;
		$emp_delivery_id=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->delivery_by;

		$customer_order_pick_by=$this->db->get_where('employee',array('emp_id'=>$emp_pickup_id))->row()->first_name;
		$customer_order_delivery_by=$this->db->get_where('employee',array('emp_id'=>$emp_delivery_id))->row()->first_name;
		
		$customer_order_payment_status=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->amt_paidby;
		$customer_order_payment_mode=$this->db->get_where('customer_order',array('invoice_no'=>$invoice_no))->row()->amt_paidby;



			/* Outstanding AMount */
			$this->db->select('*');
			$this->db->select_sum('total_paid');
			$this->db->where("customer_id",$cust_id);
			$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

			$this->db->select();
			$this->db->select_sum('amt_paid');
			$this->db->where("customer_id",$cust_id);
			$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

			$OldOustandingAmt=$this->db->get_where('users',array('id' => $cust_id))->row()->outstand_amt;

			$OutStandAmount=($OldOustandingAmt+$TotalAmount)-$PaidAmount;

			if($storeTaxable=='yes')
			{
				$vatAmt=$TotalAmount*5/100;
				$OutStandAmount=$OutStandAmount+$vatAmt;
			}
			$OutStandAmount=sprintf('%0.3f',$OutStandAmount);

			$customer_invoice_amt=sprintf('%0.3f',$customer_invoice_amt);	
			$customer_outstand_amount=$OutStandAmount;	
			/* End Outstand Amount */

		/********* Ending Customers Details ***************/
		
		 	$android_mob_app = "https://www.shorturl.at/prSV5";
		 	$payment_link = base_url()."index.php/login/payment_token/".$customer_mobile."/".$OutStandAmount;

		$message=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_body;
		$subject=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_title;
		$msg_active=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->active;

		$message=preg_replace(
			array(	"/{CUSTOMER_NAME}/",
					"/{CUSTOMER_MOBILE}/",
					"/{INVOICE}/",
					"/{INVOICE_AMT}/",
					"/{PAID_AMT}/",
					"/{PICKUP_DATE}/",
					"/{DELIVERY_DATE}/",
					"/{PICKUP_BY}/",
					"/{DELIVERY_BY}/",
					"/{PAYMENT_STATUS}/",
					"/{PAYMENT_MODE}/",
					"/{OUTSTAND_AMT}/",
					"/{ANDROID_LINK}/",
					"/{ONLINE_PAYMENT}/"

				),

			array(	$customer_name, 
					$customer_mobile, 
					$customer_invoice, 
					$customer_invoice_amt, 
					$customer_paid_amt, 
					$customer_order_pickup_date,
					$customer_order_delivery_date,
					$customer_order_pick_by,
					$customer_order_delivery_by,
					$customer_order_payment_status,
					$customer_order_payment_mode,
					$customer_outstand_amount,
					$android_mob_app,
					$payment_link
				 ), 
			$message);

		echo $subject ."<br>" . $message;
				
		if($message!='' && $msg_active=='yes')
		{	
			echo "<br/> ==> <span style='color:green;'> Success : email / whatsapp sending message </span> ";
			$this->bulk_message->bulk_whatsapp($customer_mobile,$message);
			// $this->bulk_message->bulk_email($customer_email,$subject,$message);

			return true;
		}
		else
		{
			echo "<br/> ==> <span style='color:red;'> Error : email / whatsapp Sending message or template is not activated </span>";

			echo "<br/> <br/> <a href='".base_url()."index.php/welcome'> Dashboard </a>";

			return false;
		}	
			
	}
		
	
}
?>
