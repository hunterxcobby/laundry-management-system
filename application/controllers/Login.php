<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 07 June, 2017
	 *	Laundry Management Application (Login Model)
	 *	ajitrajyash@gmail.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->load->helper(array('form','url','html','cookie'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database(); $this->load->helper('language');
		date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
		$this->load->model('login_model');
      	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
        $this->load->model('bulk_message');
		
    }
	
	public function index()
	{   $this->session->sess_destroy();	
		$this->load->view('login', 'refresh');
	}
	
	public function redirect($param1='', $param2='')
	{	// get form input
		$UserName=trim($this->input->post_get('username'));
		$Password=trim($this->input->post_get('password'));
		
		if($param1=="login_from_admin") 
		{	$UserName=$this->db->get_where('stores' , array('id' =>$param2))->row()->store_email;
			$Password=$this->db->get_where('stores' , array('id' =>$param2))->row()->store_password;	
		}	
		
		$uresult = $this->login_model->get_user($UserName, $Password);	// admin login model
		$store_result = $this->login_model->get_store($UserName, $Password);	// laundry store login model
		
		
        if (count($uresult) > 0)
        {   
            $this->session->set_userdata('admin_login', 1);
            $this->session->set_userdata('user_from', $UserName);
            $this->session->set_userdata('login_user', $UserName);
        
            if ($this->session->userdata('admin_login') == 1)
            { 
                // Check login attempts through IP address
                date_default_timezone_set('Asia/Kolkata');
                $client_ip = $this->input->ip_address();
                $datetime  = date('Y-m-d h:i:s a', time());
                
                $client_data = array('ip_add' => $client_ip, 'date_time' => $datetime);
                $this->db->insert('login_attempt', $client_data);
        
                $ipData = $this->db->query("SELECT * FROM login_attempt WHERE ip_add='".$client_ip."'");
        
                if ($ipData->num_rows() > 500000)
                {
                    $this->session->set_flashdata('error', 'You have Maximum Attempt, Please Contact the Laundry Administrator');
                    redirect('login', 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('success', lang('admin').' '.lang('logingmsg'));
                    redirect('admin/index', 'refresh');
                }
            }
        }
		elseif(count($store_result) > 0)		// Check Store Login	
		{		//echo "welcome to laundry store";
				
				
					// Login Status Laundry Store Enable or Disable 
					
					$this->db->where("show_hide='hide' AND (store_email = '$UserName' OR store_phone = '$UserName')");
					
					$check = $this->db->get('stores');
				 
					if(count($check->result()) > 0)		// using direct parameter
					{
					?>
					<script> alert("<?php echo lang('logingstoredeactive'); ?>"); </script>
					<?php
					redirect('login','refresh');
					}
					else
					{	
					foreach($store_result as $store_row) :
						
						$StoreId=$store_row->id;
						$StoreName=$store_row->store_name;
						
						$this->session->set_userdata('admin_login', 1);
						$this->session->set_userdata('user_from','store');
						$this->session->set_userdata('login_user', $StoreName);
						$this->session->set_userdata('store_id', $StoreId);
						
						
					endforeach;
					
					?> <script> alert("<?php echo $StoreName; ?>, <?php echo lang('logingmsg'); ?>"); </script> <?php	
					redirect('admin/index','refresh');
					}
						
					
		}
		else									//Check Employee Login
		{	
			$mobile=trim($this->input->post('username'));
			$pwd=trim($this->input->post('password'));
			
			$this->db->where('mobile', $mobile);
			$this->db->where('password', base64_encode($pwd));
			$empresult = $this->db->get('employee');
		
			//echo count($empresult->result()); 		
			if (count($empresult->result()) > 0)
			{	
					// Login Status Enable or Disable 
					
					$this->db->where("status='disable' AND (mobile = '$mobile')");
					
					$check = $this->db->get('employee');
				 
					if(count($check->result()) > 0)		// using direct parameter
					{
					?>
					<script> alert("<?php echo lang('logingdeactive'); ?>"); </script>
					<?php
					redirect('login','refresh');
					}

					// Employee Role (Driver or Delivery Boy ) 
					
					$this->db->where("emp_role='enable' AND (mobile = '$mobile')");
					
					$emppage = $this->db->get('employee');
				 
					if(count($emppage->result()) > 0)		// using direct parameter
					{	$this->session->set_userdata('employee_login', 1);
						if ($this->session->userdata('employee_login') == 1)
						{	
							foreach($empresult->result() as $getemprow): 
							$EmpId=$getemprow->emp_id; 
							$EmpNm=$getemprow->first_name; 
							$this->session->set_userdata('emp_id',$EmpId);
							$this->session->set_userdata('login_user',$getemprow->first_name);
							endforeach; 
					
						?> <script> alert("<?php echo $EmpNm; ?> <?php echo lang('logingmsg'); ?>"); </script> <?php	
						redirect('employee/index','refresh');
						}
					}
					else
					{
				
        				$this->session->set_userdata('employee_login', 1);
        				$this->session->set_userdata('admin_login', 1);
        				if ($this->session->userdata('admin_login') == 1)
        				{	
        					foreach($empresult->result() as $getemprow): 
        					$EmpId=$getemprow->emp_id;
        					$EmpNm=$getemprow->first_name; 
        					$GroupId=$getemprow->group_id;
        					$this->session->set_userdata('emp_id',$EmpId);
        					$this->session->set_userdata('login_user',$getemprow->first_name);
        					$this->session->set_userdata('group_id',$GroupId);
        					endforeach; 
        			
        				?> <script> alert("<?php echo $EmpNm; ?> <?php echo lang('logingmsg'); ?>"); </script> <?php	
        				redirect('admin/index','refresh');
        				}
					}
			}
			else
			{	$this->session->set_userdata('employee_login', 0);
				?> <script> alert('<?php echo lang('Invaid'); ?>'); </script> 	
				<?php redirect('login','refresh');
				
			}
		}


	}
	
	// Admin Forogot Password Scrip //

	function forgotpasswd() {
       	
		
		$email=$this->input->post('email');

		$mobile=$this->db->get_where('admin' , array('id' =>1))->row()->mobile;
		
		$this->db->where("email_id = '$email' OR mobile = '$email'");
		$admresult = $this->db->get('admin');	
		
			// Password Generation 
			$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 5; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
			}
			$newpass=implode($pass); //turn the array into a string
			
			$pwd=sha1($newpass);
			
			//End Passwd 
		
		if (count($admresult->result()) > 0)
		{	 
			 $passdata['password'] = $pwd;	
			 if($this->db->update('admin' , $passdata)===TRUE)
			 {	

			 	//Email SMS
				$subject='Login Details';
				$message = "Dear Admin, your login password reset successfully and New Password is : " . $newpass;
				$this->bulk_message->bulk_email($email,$subject,$message);
				
				//Mobile SMS 
				$platform="login panel";
				$sms="Dear Admin, your login password reset successfully and New Password is : " . $newpass;
				$this->bulk_message->bulk_sms($mobile,$sms,$platform);	
	 			echo "<script> alert('Login Details send in your email and mobile !!!'); </script>";

			 }	 
				
		}
		else
		{	$this->db->where("email_id = '$email' OR mobile = '$email'");
			$empresult = $this->db->get('employee');
			if (count($empresult->result()) > 0)
			{	
				 $emppassdata['password'] = $pwd;	
				 if($this->db->update('employee' , $emppassdata)===TRUE)
				 {	?>
						<script> alert("<?php echo lang('passchange'); ?> \n (temp password : <?php echo $newpass; ?>)"); </script>
					<?php
				 }	 
					
			}
			else
			{	?>
						<script> alert("<?php echo lang('mobnotfound'); ?>"); </script>
					<?php
					
				  
			}
			
		}		

		redirect('login/index','refresh');
			
		
		
    }
	

	function loginatm()
	{	$this->db->order_by("auto","desc");
		$clientdata['ip_list']=$this->db->get('login_attempt');
		$this->load->view('admin/login_attempt',$clientdata);
	}
	
	function ip_delete($param1='')
	{	$this->db->where('auto', $param1);
            if($this->db->delete('login_attempt')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("IP Address Record Deleted Successfully ,<?php echo $param2; ?>"); </script>
			<?php
			redirect('login/loginatm','refresh');
			}	
	}
	
	function ip_delete_multi()
		{	if(isset($_POST["id"]))
			{
			 foreach($_POST["id"] as $id)
			 {
				$this->db->where('auto' , $id);
				$this->db->delete('login_attempt');
			 }
			}
    	}
	
	
	
	function logout() {
       	$this->session->set_userdata('admin_login', 0);
		$this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
		
		?>
			<script> alert("<?php echo lang('loggedoutmsg'); ?>"); </script>
		<?php
		redirect('login/index','refresh');
    }

	function payment_token()
	{	
		echo "In Demo version Disabled this feature";
	}
    function payment_token_stop($invoice='AHL24',$amount='4.500',$from='')
	{
		
		$CustID=$this->db->get_where('customer_order',array('invoice_no'=> $invoice))->row()->customer_id;
		$FirstName=$this->db->get_where('users',array('id' => $CustID))->row()->first_name;
		$LastName=$this->db->get_where('users',array('id' => $CustID))->row()->last_name;
		$Mobile=$this->db->get_where('users',array('id' => $CustID))->row()->mobile;
		$Mobile=str_replace(' ', '', $Mobile);

		$Amount=sprintf('%0.3f',$amount);
		
		/******************* Online Payment Token Generation Script *****************************/ 
			echo "<center><table>";
			echo "<tr> <td>Customer Name  : </td> <td> {$FirstName} {$LastName} </td></tr>";
			echo "<tr> <td>Customer Mobile  : </td> <td> {$Mobile} </td></tr>";
			echo "<tr> <td>Invoice : </td> <td> {$invoice} </td></tr>";
			echo "<tr> <td> Amount : </td> <td> {$Amount} </td> </tr>";
			
			$description="{$invoice} payment details";
			
			$date=date('Y/m/d H:m');
			
			
			
			$xml_data ='<?xml version="1.0" encoding="utf-8"?>
			<API3G>
			<CompanyToken>9382D678-31F9-41DB-8592-7871CE97E44B</CompanyToken>
			<Request>createToken</Request>
			<Transaction>
	      <customerPhone>'.$Mobile.'</customerPhone>
        <customerZip>000000</customerZip>
        <customerCountry>AE</customerCountry>
        <PaymentAmount>'.$Amount.'</PaymentAmount>
			<PaymentCurrency>AED</PaymentCurrency>
			<CompanyRef>'.$invoice.'</CompanyRef>
			<RedirectURL>https://www.alhayatlaundry.ae/index.php/login/payment_backurl</RedirectURL>
			<BackURL>https://www.alhayatlaundry.ae/index.php/login/payment_backurl</BackURL>
			<CompanyRefUnique>0</CompanyRefUnique>
			<PTL>5</PTL>
			</Transaction>
			<Services>
			  <Service>
			    <ServiceType>49049</ServiceType>
			    <ServiceDescription>'.$description.'</ServiceDescription>
			    <ServiceDate>'.$date.'</ServiceDate>
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
				$response = curl_exec($ch);

				curl_close($ch);

				// $xml = simplexml_load_string($output);

				$xml = new SimpleXMLElement($response);
        		// echo "<pre>";print_r($xml);

				// print_r($xml);

				$Token=$xml->TransToken; 
				
				echo "<tr> <td> Token : </td> <td> ".$Token."</td> </tr>";
				
				echo "<table>";
				echo "<br><br> <a href='https://secure.3gdirectpay.com/pay.asp?ID=".$Token."'> <button> Online Payment </button> </a>";

				if($from=='mobile') {
					echo "<script> window.setTimeout(function(){ window.location = 'https://secure.3gdirectpay.com/pay.asp?ID=".$Token."'; },500); </script>";
				}
				return true;
									
			/****************** End Token *******************/
	}


	function payment_backurl()
	{
		
		// echo "<a href='".base_url()."index.php/admin/customer_orders/invoice_list'> Invoice List </a>";
		$Token=$this->input->get('TransID', TRUE);
		$InvoiceNo=$this->input->get('CompanyRef', TRUE);
		
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
            <API3G>
              <CompanyToken>9382D678-31F9-41DB-8592-7871CE97E44B</CompanyToken>
              <Request>verifyToken</Request>
              <TransactionToken>'.$Token.'</TransactionToken>
            </API3G>';
        
       $URL = "https://secure.3gdirectpay.com/API/v6/"; 

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION,6);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

        $response = curl_exec($ch);
            
        curl_close($ch);
        
        parse_str( $response, $responseFields);
        $xml = new SimpleXMLElement($response);

       
        $AmtPaid=sprintf('%0.3f',$xml->TransactionAmount);

         echo "<script> alert('".$xml->ResultExplanation."'); </script>";

        // echo "<pre>";print_r($xml); exit();

        // $PaymentResult=$xml->Result;

        
     		$paymentData=array('trans_id' => $Token, 'invoice_no' => $InvoiceNo, 'payment_result' => $response );

        	if($this->db->insert('online_payment_details', $paymentData)===TRUE) 
        	{
		        	if($xml->Result=='000')
		        	{
		        		$update['amt_paidby']='byonline';
		        		$update['amt_paid']=$AmtPaid;
		        		$update['paid_date']=date('Y-m-d');
		        		$this->db->where('invoice_no' , $InvoiceNo);
		        		if($this->db->update('customer_order' , $update)===TRUE) { }
       				}	
          }

        if($this->session->userdata('muser_login')==1)				// for mobile user payment
        {
        	redirect('mobile/mobile_main','refresh');
        }
        else
        {	
        	redirect('admin/customer_orders/invoice_list','refresh');
      	}
	}


	function payment_list()
	{
		$paymentList=$this->db->get('online_payment_details')->result();
		echo "<table>
			<tr> 
					<td> Sl No. </td>
					<td> Trans Id</td>
					<td> Invoice </td>
					<td> Payment Status </td>
				</tr>";
		foreach($paymentList as $payRow)
		{
			$response=$payRow->payment_result;
			parse_str( $response, $responseFields);
      $xml = new SimpleXMLElement($response);
			
			echo "<tr>";
			echo "<td>".$payRow->pay_id."</td>";
			echo "<td>".$payRow->trans_id."</td>";
			echo "<td>".$payRow->invoice_no."</td>";
			echo "<td>".$xml->ResultExplanation."</td>";
			echo "</tr>";
		}
		echo "</table>";	
	}
	
}
