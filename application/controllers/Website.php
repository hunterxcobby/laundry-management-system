<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Website extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers / 8108702999
	 *	date		: 03 July, 2018
	 *	Laundry Management Application (Website Model)
	 *	rpcits2013@gmail.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->load->helper(array('form','url','html','cookie'));
        $this->load->library(array('session', 'form_validation','googlemaps'));
        $this->load->database();
		date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
		$this->load->model('bulk_message');
      	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
    }
	
	public function index()
	{	redirect("website/mainpage",'refresh');
	}	
	
	function mainpage()
	{
	    $this->session->set_userdata('webmenu','home');
		$this->load->view('website/webindex');
	}	
	
	
	function pricing()
	{
		$this->session->set_userdata('webmenu','price');
		$this->load->view('website/pricing');
	}
		
	function chklogin()
	{			
		$mobile=$this->input->post('email_mobile');
		// $pwd=($this->input->post('password'));
		
		// $this->db->where("email_id",$mobile);
		//$this->db->where("password", $pwd);
		
		$this->db->where("(email_id='".$mobile."' OR mobile='".$mobile."')");
		
		$custresult = $this->db->get('users');
		
		//echo count($custresult->result());
		
		if (count($custresult->result()) > 0)
			{	foreach($custresult->result() as $getcustrow): 
					$CustId=$getcustrow->id;
					$this->session->set_userdata('cust_id',$CustId);
				endforeach;	
				
				$this->session->set_userdata('loginuser', $mobile);
				$this->session->set_userdata('cust_login', 1);
				$ShopName = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name;
				$this->session->set_userdata('shopname', $ShopName);
				echo "<script> alert('your login is success'); </script>";
				redirect('website/webcust_orderlist','refresh');
			}
		else
		{ ?>
		  <script> alert('You enterted wrong login details'); </script>
		 <?php   redirect('website','refresh');
		}
			
		
	}
	
	function register()
	{		$join_date=date('Y-m-d');
			$first_name=ucwords($this->input->post('first_name'));
			$last_name=ucwords($this->input->post('last_name'));
			
			$email_id=$this->input->post('email');
			$mobile=$this->input->post('mobile');
			//$password=$this->input->post('password');
			//$password='1234';
			$sys_map_pos = $this->db->get_where('settings' , array('id' =>1))->row()->shop_gmap;
			
			$this->db->where("(email_id='".$email_id."' OR mobile='".$mobile."')");
			$checkuserexist = $this->db->get('users');
								
		if (count($checkuserexist->result()) > 0)
		{ ?>
			<script> alert("You have already Registered Users Please Click on Forgot Password!!!"); </script>
		  <?php
		  redirect('website','refresh');
		}
		else
		{	$otp = rand(1000,9999);
			$customer_data = array('join_date' => $join_date,'first_name' => $first_name, 'mobile' => $mobile, 'email_id' => $email_id , 'password' => $otp, 'status' =>"enable", 'cust_map_pos' => $sys_map_pos);
			
			if($this->db->insert('users', $customer_data)===TRUE)		// using direct parameter
			{ //$this->session->set_userdata('message','register');
			
			 
				//Email SMS
				$subject='Login Details';
				$message = "Dear ".$first_name.", <br/>Thanking you for registration to ".STORENAME.", <br/>Your Login Details :<br/><br/> username :".$email_id."<br/><br/> Password : " . $otp;
				$message.="<br/> <br/>".base_url()."";
				
				$this->bulk_message->bulk_email($email_id,$subject,$message);
				
			 	//Mobile SMS  
				$sms="Hi ".$first_name.", Thanks for registration ".STORENAME.", your login password: ".$otp;
				$sms.=" Download app http://bit.ly/thefirstimp";
			 
				$this->bulk_message->bulk_sms($mobile,$sms);
				
				 //// Owner Information  ////
			 	 $ownemail=$this->db->get_where('admin' , array('id' =>1))->row()->email_id;
			 	 $ownmobile=$this->db->get_where('admin' , array('id' =>1))->row()->mobile;
			 	    
				//Owner Email 
		 	    $ownsubject='New Registration';
				$ownmessage = "Hi ".$first_name.", has registered through website in your ".STORENAME.", please contact to on : ".$mobile;
			    $ownmessage.=" Thanks";
				$this->bulk_message->bulk_email($ownemail,$ownsubject,$ownmessage);

		 	    //Owner Mobile SMS 
				$ownsms =$ownmessage;
				$this->bulk_message->bulk_sms($ownmobile,$ownsms);
			
			 echo '<script> alert("Registration Successfully!!! \n Please check email or mobile for login details"); </script>';
			
			
			redirect('website','refresh');
			}
		}	
	}	
	
	
	function forgotpass()
	{	$this->session->set_userdata('webmenu','home');
		$this->load->view('website/forgotpass','refresh');
		
	}
	
	function offers()
	{	$this->session->set_userdata('webmenu','home');
		$this->load->view('website/offers','refresh');
		
	}
	
	
	function forgot_pass_sms()
	{	$mobile=$this->input->post('email_mob');
		$this->db->where("email_id = '$mobile' OR mobile = '$mobile'");
		$forgotresult = $this->db->get('users');
		
		//echo count($forgotresult->result());
		
		if (count($forgotresult->result()) > 0)
			{	
					foreach($forgotresult->result() as $forgotrow)
					{	$CustId=$forgotrow->id;
						$first_name=$this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
						$email_id=$this->db->get_where('users' , array('id' =>$CustId))->row()->email_id;
						$mobile=$this->db->get_where('users' , array('id' =>$CustId))->row()->mobile;
						$otp=$this->db->get_where('users' , array('id' =>$CustId))->row()->password;
					}	
					
						//Email SMS
						$subject='Login Details';
						$message = "Dear ".$first_name.", <br/> Your Login Details :<br/><br/> username :".$email_id."<br/><br/> Password : " . $otp;
						$message.=". Thanks <br/> <br/>".base_url()."";
						
						$this->bulk_message->bulk_email($email_id,$subject,$message);
						
						//Mobile SMS 
						$sms="Hello ".$first_name.", Your login details are (Username : mobile or email ) and Password : ".$otp;
						$sms.=". Thanks";
					 
						$this->bulk_message->bulk_sms($mobile,$sms);	
			 
			 
						echo "<script> alert('Login Details send in your email and mobile !!!'); </script>";
						redirect('website/auth','refresh');
					
			}
		else
		{  echo "<script> alert('something wend wrong'); </script>";
		   redirect('website/forgotpass','refresh');
		}	
		
	}
	
	function logout()
	{	$this->session->sess_destroy();
		redirect('website','refresh');
	}
	
	function about() 	{	$this->session->set_userdata('webmenu','about'); $this->load->view('website/about'); }
	
	function contact() 	{	$this->session->set_userdata('webmenu','contacts'); $this->load->view('website/contact'); }
	
	function faq() 	{	$this->session->set_userdata('webmenu','faq'); $this->load->view('website/faq'); }

	function privacy() 	{	$this->session->set_userdata('webmenu','home'); $this->load->view('website/privacy'); }
	
	
	
	function pricelist()
	{	$this->session->set_userdata('webmenu','prices'); 
		$data['servicelist'] = $this->db->get('services');
		$data['clothlist'] = $this->db->get('cloths');
		$data['pricelist'] = $this->db->get('price_list');
		$this->load->view('website/pricelist',$data);
	
	}
	
	function webcust_orderlist()
	{	if ($this->session->userdata('cust_id') == 0) redirect('website');
		$this->session->set_userdata('webmenu','home');
		$this->load->view('website/cust_order_list','refresh');
		
	}
	
	function orderOnlineConfirm()
	{	if ($this->session->userdata('cust_id') == 0) redirect('website');
		
		
		$orderdate=date('Y-m-d');
		$ordertime=date('H:i');
		$CustId=$this->session->userdata('cust_id');
		$FirstName=$this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
		$LastName=$this->db->get_where('users' , array('id' =>$CustId))->row()->last_name;
		$CustName=$FirstName." ".$LastName;
		$Pickup_Date = $this->input->post('pickup_date');
		$pickupdate= date('Y-m-d',strtotime($Pickup_Date));
		$pickuptime=$this->input->post('picktime');
		$chkpromo=$this->input->post('chkpromo');
		$promocode='';
		if($chkpromo==1) $promocode=strtoupper($this->input->post('promocode'));
		
		$delivery_date=date('Y-m-d',strtotime($pickupdate.'+3 days'));
		
		///$Delivery_Date = $this->input->post('delivery_date');
		//$deliverydate= date('Y-m-d',strtotime($Delivery_Date));
		//$deliverytime=$this->input->post('deliverytime');
		
		$approx_qty_kg=$this->input->post('appx_qty');
		$selservice=serialize($this->input->post('selservice'));
		$order_type=$this->input->post('order_type');
		$OrderFrom=$this->input->post('order_from');
		
		$laundry_store=$this->db->get_where('users' , array('id' =>$CustId))->row()->laundry_store;
		
		$orderfinal = array('order_date' => $orderdate, 'order_time' => $ordertime, 'customer_id' => $CustId,'customer_name' => $CustName, 'pickup_date' => $pickupdate, 'pickup_time' => $pickuptime, 'delivery_date' => $delivery_date, 'appx_order_qty' => $approx_qty_kg, 'discount'=>'a:0:{}', 'service_tax'=>'a:0:{}', 'amt_paidby' => "notpaid", 'services' =>$selservice, 'order_status' =>'neworder','order_type' =>$order_type,'laundry_store'=>$laundry_store,'order_place_from' =>$OrderFrom,'promocode'=>$promocode);
			
			if($this->db->insert('customer_order', $orderfinal)===TRUE)		// using direct parameter
			{   
				$OrderInvoice=$this->db->insert_id();
			
				$OrderInvoice=INVOICE_NAME.$OrderInvoice;
				
				$data['invoice_no']=$OrderInvoice;

				$this->db->where('auto_id' , $this->db->insert_id());
			
				if($this->db->update('customer_order' , $data)===TRUE)
				{ 	
					/* Message and Email sending to Customer and Owners */

					// Update Custoer Address
						$WebCustId=$this->session->userdata('cust_id');
						$updateCustAdd['address1'] = $this->input->post('address1');
						$updateCustAdd['address2'] = $this->input->post('address2');
						$updateCustAdd['city'] = $this->input->post('city');
						$updateCustAdd['zipcode'] = $this->input->post('zipcode');

						$this->db->where('id' , $WebCustId);
					
						if($this->db->update('users' , $updateCustAdd)===TRUE) { }

					// End Update Customer Address
							

					//// Customer Information ////
					$first_name=$this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
					$email_id=$this->db->get_where('users' , array('id' =>$CustId))->row()->email_id;
					$mobile=$this->db->get_where('users' , array('id' =>$CustId))->row()->mobile;
					
					//Customer Email 
					$subject='Order Confirmation';
					$message = "Dear ".$first_name.", <br/> Your laundry order generated and pick on ".date('d-M-Y',strtotime($pickupdate))." between ".$pickuptime." is received by ".STORENAME.", <br/> Your Order No :  " . $OrderInvoice;
					$message.=". <br/> Thanks";
					$this->bulk_message->bulk_email($email_id,$subject,$message);	
					
					//Custoer Mobile SMS 
					$sms = "Dear ".$first_name.", Your laundry order generated and pick on ".date('d-M-Y',strtotime($pickupdate))." between ".$pickuptime." is received by ".STORENAME.", Your Order No :  " . $OrderInvoice;
					$sms.=". Thanks";
					$platform="website";
					$this->bulk_message->bulk_sms($mobile,$sms,$platform);

			 	    
			 	    //// Owner Information  ////
			 	    $ownemail=$this->db->get_where('admin' , array('id' =>1))->row()->email_id;
			 	    $ownmobile=$this->db->get_where('admin' , array('id' =>1))->row()->mobile;

			 	    //Owner Email 
			 	    $ownsubject='Order Confirmation';
					$ownmessage = "The ".$first_name."( ".$mobile." ), has placed laundry order and pick on ".date('d-M-Y',strtotime($pickupdate))." between ".$pickuptime." Order No :  " . $OrderInvoice;
					$ownmessage.=". <br/> Thanks";
					$this->bulk_message->bulk_email($ownemail,$ownsubject,$ownmessage);

			 	    //Owner Mobile SMS 
					$ownsms =$ownmessage;
					$this->bulk_message->bulk_sms($ownmobile,$ownsms,$platform);


				/************** End Message and Email **************/

					
				?>
				<script> alert("Order Generation Successfully!!!!"); </script>
				<?php
				
				redirect('website/webcust_orderlist','refresh');
				}
			}
			
		}
		
		function online_payment($Payid='')
		{		//echo $payment;
				$product_name = 'Laundry Bill';
				$price = $this->db->get_where('customer_order' , array('auto_id' =>$Payid))->row()->total_paid;
				$CustId= $this->db->get_where('customer_order' , array('auto_id' =>$Payid))->row()->customer_id;
				$name = $this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
				$phone = $this->db->get_where('users' , array('id' =>$CustId))->row()->mobile;
				$email = $this->db->get_where('users' , array('id' =>$CustId))->row()->email_id;
				
				include 'Instamojo.php';       //Download from website
				$api = new Instamojo\Instamojo('test_5f12f99744497024941be699cec', 'test_4d442e2156396951028b66f46c1','https://test.instamojo.com/api/1.1/');
				try {
					$response = $api->paymentRequestCreate(array(
						"purpose" => $product_name,
						"amount" => $price,
						"buyer_name" => $name,
						"phone" => $phone,
						"send_email" => true,
						"send_sms" => true,
						"email" => $email,
						'allow_repeated_payments' => false,
						"redirect_url" => "http://bjlabs.xyz/instomojo/thankyou",
						"webhook" => "http://bjlabs.xyz/instomojo/webhook.php"
						));
					//print_r($response);
					$pay_url = $response['longurl'];
					
					header("Location: $pay_url");
					exit();
				}
				catch (Exception $e) {
					print('Error: ' . $e->getMessage());
				}     
				
		}

		function thankyou()
		{		
				/*
				include 'instamojo.php';
				$api = new Instamojo\Instamojo('test_5f12f99744497024941be699cec', 'test_4d442e2156396951028b66f46c1','https://test.instamojo.com/api/1.1/');
				$payid = $_GET["payment_request_id"];
				try {
				$response = $api->paymentRequestStatus($payid);
				echo "<h4>Payment ID: " . $response['payments'][0]['payment_id'] . "</h4>" ;
				echo "<h4>Payment Name: " . $response['payments'][0]['buyer_name'] . "</h4>" ;
				echo "<h4>Payment Email: " . $response['payments'][0]['buyer_email'] . "</h4>" ;
				echo "<pre>";
				print_r($response);
				}
				catch (Exception $e) {
				print('Error: ' . $e->getMessage());
				}
				*/
				$data['amt_paidby'] = 'byonline';
				if($this->db->update('customer_order' , $data)===TRUE) 
				{
					redirect('website/webcust_orderlist','refresh');
				}
						
		}	
		
		
		function myaddress()
		{	if ($this->session->userdata('cust_id') == 0) redirect('website');
			$this->session->set_userdata('webmenu','home');
			
			$WebCustId=$this->session->userdata('cust_id');
			
			$sys_map_pos = $this->db->get_where('users' , array('id' =>$WebCustId))->row()->cust_map_pos;
			
			$config['center'] = $sys_map_pos;
			$config['zoom'] = '20';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $sys_map_pos;
			$marker['draggable'] = true;
			$marker['ondragend'] = 'document.getElementById(\'custmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
			$this->googlemaps->add_marker($marker);
			$query['mapcust'] = $this->googlemaps->create_map();
			
			$this->load->view('website/cust_address',$query);
			
		}
		
		function address_update()
		{  
            $WebCustId=$this->session->userdata('cust_id');
            $data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['zipcode'] = $this->input->post('zipcode');
			
			$cust_map_pos = $this->input->post('custmap');
			$data['cust_map_pos'] = $this->input->post('custmap');
			
			
			if($cust_map_pos=="") { $sys_map_pos = $this->db->get_where('settings' , array('id' =>1))->row()->shop_gmap; $data['cust_map_pos']=$sys_map_pos;  }
			
          
			$this->db->where('id' , $WebCustId);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
			redirect('website/myaddress','refresh');
			}
		}
		
		
		function myprofile()
		{	if ($this->session->userdata('cust_id') == 0) redirect('website');
			$this->session->set_userdata('webmenu','home');
			$this->load->view('website/cust_profile','refresh');
		}
		
		function profile_update()
		{  
            $WebCustId=$this->session->userdata('cust_id');
            $data['first_name'] = $this->input->post('firstname');
			$data['last_name'] = $this->input->post('lastname');
			$data['mobile'] = $this->input->post('mobile');
			$data['email_id'] = $this->input->post('email');
			
          
			$this->db->where('id' , $WebCustId);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("Profile Updated Successfully"); </script>
			<?php
			redirect('website/myprofile','refresh');
			}
		}
		
		function mypassword()
		{	if ($this->session->userdata('cust_id') == 0) redirect('website');
			$this->session->set_userdata('webmenu','home');
			$this->load->view('website/cust_change_password','refresh');
		}
		
		function password_change()
		{  
            $WebCustId=$this->session->userdata('cust_id');
            $data['password'] = $this->input->post('repass');
			          
			$this->db->where('id' , $WebCustId);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("Password Changed Successfully !!!! Login Again "); </script>
			<?php
			redirect('website/logout','refresh');
			}
		}
		
		function auth()
		{	$this->session->set_userdata('webmenu','home');
			$this->load->view('website/cust_auth','refresh');
		}
	
		function promoCode()
		{	$WebCustId=$this->session->userdata('cust_id');
			$promocode=strtoupper($this->input->post('promocode'));
			$promo_result = $this->db->get_where('tax_charges' , array('charge_name' =>$promocode,'coupon' =>'yes'));
			
			if (count($promo_result->result()) > 0)
			{   	
				$promo_order_result = $this->db->get_where('customer_order' , array('promocode' =>$promocode,'customer_id' =>$WebCustId));
				if (count($promo_order_result->result()) > 0)
				{	echo 'USED'; }
				else { echo "SUCCESS"; }				
				
			}
			else 
			{
				echo 'FALSE';
			}			
		}
		
}
