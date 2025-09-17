<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 30 May, 2017
	 *	Laundry Management Application
	 *	ajitrajyash@gmail.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
		$this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation','googlemaps'));
        $this->load->database(); $this->load->helper('language');
		date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
		$this->load->model('bulk_message');
      	
		
    }
	
	public function index()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		
		$this->session->set_userdata('menu','dashboard');
		
		$this->db->from('customer_order');
		$this->db->order_by("total_paid", "desc");
		$desktop['order_data'] = $this->db->get();
		$desktop['invoiceorder'] = $this->db->get('customer_order');
		
		$desktop['userdata'] = $this->db->get('users');
		$desktop['today']=date('d-m-Y');
		//$this->load->view('admin/header');
		$this->load->view('admin/main',$desktop);
		//$this->load->view('admin/footer');
		//redirect('admin/customer_orders/neworder','refresh');
	}
	
	
	function check_item()
	{			
		$prodid=$this->input->post('prodid');
		$prodqty=$this->input->post('prodid');
		$data=$this->db->get_where('price_list' , array('id' => $short_code) )->result();
		foreach($data as $datarow)
		{
			 //echo $datarow->service_id;			 
			 $return_data['service']=$datarow->service_id;			 
			 $return_data['cloth']=$datarow->cloth_id;			 
		}
		echo json_encode($return_data);exit;
		
		//echo json_encode(array('vendor_contact' => $row['vendor_contact'], 'vendor_vat' => $row['vendor_vat']));
		
	}
	
	function check_phone()		// Customer Record ( Check Telephone Exist )
	{	$output='';		
		$phone=$this->input->post('phone');
		$result=$this->db->get_where('users' , array('mobile' => $phone) );
		if($result->num_rows() > 0)  
           {  
               echo $output="Error : Customer Mobile Already Exist!!!";
           }  
		
	}
	
	function check_phone_emp()		// Employee Record ( Check Telephone Exist )
	{	$output='';		
		$phone=$this->input->post('phone');
		$result=$this->db->get_where('employee' , array('mobile' => $phone) );
		if($result->num_rows() > 0)  
           {  
              echo $output="Error : Telephone Already Exist!!!";
           }  
		
	}
	
	function fetch()		// searching fetch data
	{	$output='';		
		$search=$this->input->post('query');
		if($search=='') $result=''; else  $result=$this->db->query("SELECT * FROM users WHERE first_name LIKE '%".$search."%' OR mobile LIKE '%".$search."%'");
		if($result->num_rows() > 0)  
           { 
           		//Customer Data Search

           		$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th class="hidden-480">Store Name </th>
							<th>Name#</th>
							<th>Mobile</th>
						    <th style="color:red;">Due Amt</th>
							<th class="hidden-480"> </th>
						</tr>';

           		foreach($result->result() as $row ) :
           		    $this->db->select_sum('total_paid');
					$this->db->where('customer_id', $row->id);
					$this->db->where('amt_paidby','notpaid');
					$TotalDueAmt = $this->db->get('customer_order')->row()->total_paid;
					if($TotalDueAmt==0) $TotalDueAmt='0.00';
					
           			$storeid=$row->laundry_store;	
           			$storename='';	
           			if($storeid!=0) $storename=$this->db->get_where('stores' , array('id' =>$storeid))->row()->store_name;
           		$output .= '
						<tr>
							<td class="hidden-480">'. $storename  .'</td>
							<td>'. $row->first_name." " . $row->last_name .'</td>
							<td>'.$row->mobile.'</td>
							<td style="color:red;"><b>'.$TotalDueAmt.'</b></td>
							<td><a href="'.base_url().'index.php/admin/customer_order_details/'.$row->id.'"> View Details </a></td>
							
						</tr>';
				endforeach;	

				// End Customer Data Search

				echo $output;	
				 	
           }
           else
			{	
				$invoiceresult=$this->db->query("SELECT * FROM customer_order WHERE invoice_no LIKE '%".$search."%'");
				if($invoiceresult->num_rows() > 0)  
           		{ 
           			//Orde Invoice Data Search
           			
           			$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>'.lang('Invoice') .' </th>
							<th class="hidden-480">'.lang('Pickup Date') .'  </th>
							<th class="hidden-480">'.lang('Delivery Date') .'  </th>
							<th>'.lang('Qty/Kg') .' </th>
							
							<th style="text-align:left;">'.lang('Total') .' </th>
							<th class="hidden-480">'.lang('Amount Due') .' </th>
							<th> '.lang('Order Status') .' </th>
							<th>'.lang('Payment') .'</th>
						</tr>';

	           		foreach($invoiceresult->result() as $invoicerow ) :
	           			$invoiceno=$invoicerow->invoice_no;	
	           			$ordercolr='';
	           		
						if($invoicerow->order_status=='done') { $colr='green'; } else { $colr="red"; }
						if($invoicerow->order_type=='Express') { $ordercolr='#cc99ff'; $colr="white"; $orderstatus="express";  } else { $orderstatus=$invoicerow->order_status; } 
	           			
	           		$output .= '
							<tr style="background-color:'.$ordercolr.'">
								<td><a href="'.base_url().'index.php/pos/update/'.$invoicerow->auto_id.'/chkrec">'. $invoiceno  .'</a></td>
								<td class="hidden-480">'. date('d-M-Y',strtotime($invoicerow->order_date)) .'</td>
								<td class="hidden-480">'.date('d-M-Y',strtotime($invoicerow->delivery_date)).'</td>
								<td>'.$invoicerow->total_qty.'</td>
								
								<td>'.$invoicerow->total_paid.'</td>
								<td class="hidden-480">'.$invoicerow->total_paid.'</td>
								<td style="font-size:11px;color:'.$colr.'">'.strtoupper($orderstatus).'</td>
								<td style="font-size:11px;color:'.$colr.'">'.strtoupper($invoicerow->amt_paidby).'</td>
								
								
							</tr>';
					endforeach;	

					echo $output;

           		}
           		else
           		{	
				echo 'Data Not Found';
				}
			} 
			
		
	}	// End Fetch Data


	
	
	// Customer Controller = = >
	
	function customers()
	{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','customers');
		
		$data['charges_list'] = $this->db->get('tax_charges');
		$this->db->where("show_hide","show");
		$data['store_list'] = $this->db->get('stores');
		$this->db->order_by("id","desc");
		$data['userdata'] = $this->db->get('users');
		$storeId=$this->session->userdata('store_id');
		if($storeId!=0) 
		{ $data['userdata'] = $this->db->get_where('users' , array('laundry_store' =>$storeId ));
		  $data['store_list'] = $this->db->get_where('stores' , array('id' =>$storeId ));
		}
		
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('users')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;
		
		// Google Map Location
		
		$sys_map_pos = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_gmap;
		
		$config['center'] = $sys_map_pos;
		$config['zoom'] = '17';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $sys_map_pos;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'document.getElementById(\'custmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		
		
		$data['sys_map_pos'] = $sys_map_pos;


		$this->load->view('admin/users',$data);
	}
	
	function direct_cust()
	{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		
		$data['charges_list'] = $this->db->get('tax_charges');
		$this->db->where("show_hide","show");
		$data['store_list'] = $this->db->get('stores');
		$data['userdata'] = $this->db->get('users');
		$storeId=$this->session->userdata('store_id');
		if($storeId!=0) 
		{ $data['userdata'] = $this->db->get_where('users' , array('laundry_store' =>$storeId ));
		  $data['store_list'] = $this->db->get_where('stores' , array('id' =>$storeId ));
		}
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('users')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;

		$this->load->view('admin/customer_direct',$data);
		
	}

	function new_pickup_direct()
	{
		$data['laundry_service'] = $this->db->get('services');
		$data['customerData'] = $this->db->get('users');
		$this->load->view('admin/pickup_direct',$data);
	}

	function pickup_new_cust()
	{
		$PickupNewCustData=array(
								'join_date' => date('Y-m-d'),
								'first_name' => $this->input->post('first_name'),
								'last_name' => $this->input->post('last_name'),
								'mobile' => $this->input->post('mobile'),
								'address1' => $this->input->post('address1'),
							);
		if($this->db->insert('users', $PickupNewCustData)===TRUE)		// using direct parameter
			{
				echo '<script> alert("New Customer Added Successfully!!!!"); </script>';
				redirect('welcome','refresh');
			}
	}
	
	function direct_pickup_order()
	{
		$orderdate=date('Y-m-d');
		$ordertime=date('h:i A');
		$CustId=$this->input->post('cust_id');
		$FirstName=$this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
		$LastName=$this->db->get_where('users' , array('id' =>$CustId))->row()->last_name;
		$CustName=$FirstName." ".$LastName;
		$Pickup_Date = $this->input->post('pickup_date');
		$pickupdate= date('Y-m-d',strtotime($Pickup_Date));
		$pickuptime=$this->input->post('picktime');
		$delivery_date=date('Y-m-d',strtotime($pickupdate.'+3 days'));
		$approx_qty_kg=0;
		$selservice='none';
		$laundry_store=$this->db->get_where('users' , array('id' =>$CustId))->row()->laundry_store;
		$OrderFrom='admin';
		$remarks=$this->input->post('remarks');
		$driver=$this->input->post('driver');
		

		$orderfinal = array('order_date' => $orderdate, 'order_time' => $ordertime, 'customer_id' => $CustId,'customer_name' => $CustName, 'pickup_date' => $pickupdate, 'pickup_time' => $pickuptime, 'delivery_date' => $delivery_date, 'appx_order_qty' => $approx_qty_kg, 'discount'=>'a:0:{}', 'service_tax'=>'a:0:{}', 'amt_paidby' => "notpaid", 'services' =>$selservice, 'order_status' =>'new_order','laundry_store'=>$laundry_store,'order_place_from' =>$OrderFrom,'remarks'=>$remarks,'pickup_by' => $driver);
			
			if($this->db->insert('customer_order', $orderfinal)===TRUE)		// using direct parameter
			{   
				$OrderInvoice=$this->db->insert_id();
			
				$OrderInvoice=INVOICE_NAME.$OrderInvoice;
				
				$data['invoice_no']=$OrderInvoice;

				$this->db->where('auto_id' , $this->db->insert_id());
			
				if($this->db->update('customer_order' , $data)===TRUE)
				{
				echo '<script> alert("Order Generation Successfully!!!!"); </script>';
				redirect('welcome','refresh');
				}
			}
		
	}
		
	
	// customer Profile Controller --->
	
	function customer_profile($CustID='')
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','customers');
		
		$UserID=$CustID;
		$data['userdata'] = $this->db->get_where('users' , array('id' => $UserID) );
		
		//$data['userdata'] = $this->db->get('users');
		$this->load->view('admin/customer_profile',$data);
		
	}
	
	// customer Order Details --->
	
	function customer_order_details($CustID='')
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','customers');
		
		$UserID=$CustID;
		$data['user_id'] = $UserID;
		
		$data['userdata'] = $this->db->get_where('users' , array('id' => $UserID) );
		$this->db->order_by('auto_id','desc');
		$data['invoiceorder'] = $this->db->get_where('customer_order' , array('customer_id' => $UserID) );
		
		$Pending_Order = $this->db->get_where('customer_order' , array('customer_id' => $UserID, 'order_status!=' => 'delivered') )->result();
		$data['PendingOrder'] = count($Pending_Order);
		
		$this->db->select_sum('total_paid');
		$this->db->where('customer_id', $UserID);
		$data['TotalAmt'] = $this->db->get('customer_order')->row()->total_paid;
		
		$this->db->select_sum('amt_paid');
		$this->db->where('customer_id', $UserID);
		$data['ReceivedAmt'] = $this->db->get('customer_order')->row()->amt_paid;
		
		$FirstName = $this->db->get_where('users' , array('id' => $UserID))->row()->first_name;
		$LastName = $this->db->get_where('users' , array('id' => $UserID))->row()->last_name;
		$data['Disp_Party_Name'] = $FirstName." ".$LastName;
		$data['Mobile'] = $this->db->get_where('users' , array('id' => $UserID))->row()->mobile;
		$data['Email'] = $this->db->get_where('users' , array('id' => $UserID))->row()->email_id;
		$laundrystorecust = $this->db->get_where('users' , array('id' => $UserID))->row()->laundry_store;
		$data['storeTaxable']=$this->db->get_where('stores' , array('id' =>$laundrystorecust))->row()->store_taxable;
		
		
		$this->load->view('admin/customer_order_details',$data);
		
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
					redirect('admin/customer_orders/invoice_list','refresh');
				}
						
		}	
		
		
	
	
	
	function customer_crud($param1='', $param2='')
	{	
		if($param1=='direct_create')
		{	$join_date=$this->input->post('join_date');
			$first_name=$this->input->post('first_name');
			$last_name=$this->input->post('last_name');
						
			$cust_charge=$this->input->post('cust_charges');
			$custcharges=serialize($cust_charge);
			
		
			$email_id=$this->input->post('email');
			$phone=$this->input->post('phone');
			$address1=$this->input->post('address1');
			$city=$this->input->post('city');
			$mobile=$this->input->post('phone');
			$password=$this->input->post('password');
			$otp = rand(1000,9999);
			$sys_map_pos = $this->db->get_where('settings' , array('id' =>1))->row()->shop_gmap;
			$laundry_store=$this->input->post('laundry_store');
			
			$customer_data = array('join_date' => $join_date, 'first_name' => $first_name, 'last_name' => $last_name, 'mobile' => $phone, 'email_id' => $email_id , 'password'=>$otp, 'status' =>"enable", 'cust_charges'=>$custcharges, 'cust_map_pos' => $sys_map_pos,'address1'=>$address1,'city'=>$city,'laundry_store'=>$laundry_store);
			
			if($this->db->insert('users', $customer_data)===TRUE)		// using direct parameter
			{	

				/*  Package Add to Customer Automatically */

				if($this->input->post('pref_pkg')!='')
				{
					$WebCustId=$this->db->insert_id();
					$pref_pkg=$this->input->post('pref_pkg');
					$pref_pkg_name=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->pkg_name;
					$pref_period=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->duration."M";
					$pref_pickup='Weekly';
					$pref_pickup_date=date('Y-m-d');
					$dur=str_replace("M"," months",$pref_period);
					$pkg_expire_date=date('Y-m-d',strtotime('+'.$dur.'',strtotime($pref_pickup_date)));
					$payment_mode='bycash';
					$payment_date=date('Y-m-d');
					$amount=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->amount;
					$usage_limit=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->usage_limit;

					$pkg_unit=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->pkg_unit;

					$packageQuery = array (	'cust_id' => $WebCustId, 
									'pref_pkg' => $pref_pkg_name, 
									'pref_period' => $pref_period, 
									'pref_pickup' => $pref_pickup, 
									'pref_pickup_date' => $pref_pickup_date,
									'pkg_expire_date' => $pkg_expire_date,
									'payment_mode' => $payment_mode,
									'payment_date' => $payment_date,
									'amount' =>$amount, 
									'usage_limit'=> $usage_limit,
									'pkg_unit'=> $pkg_unit,
									'pkg_active'=> 'active'
									);
			
				if($this->db->insert('cust_packages', $packageQuery)===TRUE) {}		// using direct parameter

				}
			

				/******** End Package **********/


				//Email SMS
				$subject='Login Details';
				$message = "Dear ".$first_name.", <br/>Thanks for registration to ".STORENAME.", <br/>Your Login Details :<br/><br/> username :".$email_id."<br/><br/> Password : " . $otp;
				$message.="<br/> <br/>".base_url()."";
				
				$this->bulk_message->bulk_email($email_id,$subject,$message);
				
			 	//Mobile SMS  
				$sms="Hello ".$first_name.", Thanks for registration to ".STORENAME.", your login password is : ".$otp;
				$sms.=" Download app ".MOBAPPLINK;
			 
				$this->bulk_message->bulk_sms($mobile,$sms);

			?>
            <?php
            // Set flash message for alert
            $this->session->set_flashdata('alert_message', lang('record_save'));
            
            $mobemp = $this->session->userdata('orderfrom');
            if ($mobemp == "employee") {
                redirect('pos/index/employee', 'refresh');
            }
            redirect('pos', 'refresh');
			}	
		}
		
		if($param1=='create')
		{	$join_date=$this->input->post('join_date');
			$first_name=$this->input->post('first_name');
			$last_name=$this->input->post('last_name');
			$addr1=$this->input->post('address1');
			$addr2=$this->input->post('address2');
			$city=$this->input->post('city');
			$state=$this->input->post('state');
			$zipcode=$this->input->post('zipcode');
			$country=$this->input->post('country');
			$cust_map_pos=$this->input->post('custmap');
			
			$cust_charge=$this->input->post('cust_charges');
			$custcharges=serialize($cust_charge);
			
		
			$email_id=$this->input->post('email');
			$phone=$this->input->post('phone');
			$daddress=$this->input->post('address');
			$password=$this->input->post('password');
			$status=$this->input->post('status');
			$laundry_store=$this->input->post('laundry_store');
			
			$customer_data = array('join_date' => $join_date, 'first_name' => $first_name, 'last_name' => $last_name, 'address1' => $addr1, 'address2' => $addr2,'city' => $city,'state' => $state,'zipcode' => $zipcode,'country' => $country, 'cust_map_pos' => $cust_map_pos, 'email_id' => $email_id, 'mobile' => $phone, 'password'=>"demo",  'status' =>"enable", 'cust_charges'=>$custcharges,'laundry_store'=>$laundry_store);
			if($this->db->insert('users', $customer_data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/customers','refresh');
			}	
		}
		
		
				
		if($param1=='do_update')
		{	
			// Google Map Location
			
			$sys_map_pos = $this->db->get_where('users' , array('id' =>$param2))->row()->cust_map_pos;
			
			$config['center'] = $sys_map_pos;
			$config['zoom'] = '17';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $sys_map_pos;
			$marker['draggable'] = true;
			$marker['ondragend'] = 'document.getElementById(\'custmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
			$this->googlemaps->add_marker($marker);
			$query['mapcust'] = $this->googlemaps->create_map();

			////////// End Google Map Location	
			
			$query['charge_list'] = $this->db->get('tax_charges');
			$this->db->where("show_hide","show");
			$query['store_list'] = $this->db->get('stores');
			
			$query['custmoer_edit'] = $this->db->get_where('users' , array('id' => $param2) )->result();
			
			$this->load->view('admin/customer_update',$query);
		}
		
		
		if ($param1 == 'modify') 
		{  
            $data['first_name'] = $this->input->post('first_name');
            $data['last_name'] = $this->input->post('last_name');
            $data['email_id'] = $this->input->post('email');
            $data['mobile'] = $this->input->post('phone');
            $data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['zipcode'] = $this->input->post('zipcode');
			$data['country'] = $this->input->post('country');
			$data['laundry_store'] = $this->input->post('laundry_store');
			
			$cust_map_pos = $this->input->post('custmap');
			$data['cust_map_pos'] = $this->input->post('custmap');
			
			
			if($cust_map_pos=="") { $sys_map_pos = $this->db->get_where('settings' , array('id' =>1))->row()->shop_gmap; $data['cust_map_pos']=$sys_map_pos;  }
			
            $data['status'] = 'enable';
			
			$cust_charge=$this->input->post('cust_charges');
			$custcharges=serialize($cust_charge);
			$data['cust_charges'] = $custcharges;
			
			$this->db->where('id' , $param2);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/customers/','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('users')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/customers','refresh');
			}	
		}
	
	}
	
	// Customer Invoice Multi Order Controller -->
	
	function cust_multi_order_crud($param1='', $param2='')
	{
		
		if($param1=='do_update')
		{	
			if(isset($_POST['chk']) || $_POST['chk']!='')
			{	
			$data['order_id'] = $_POST['chk'];
			$data['model']='edit_order';

			$this->load->view('admin/generate_update_rec',$data);
			}
			else
			{ echo '<script>  alert("'.lang('chkboxone').'"); </script>' ;
			  redirect('admin/customer_orders/invoice_list','refresh');
			}	
		}
		
		if($param1=='update_all')
		{
			$order_id=$this->input->post('order_id');
			//$order_date=$this->input->post('order_date');
			//$due_date=$this->input->post('due_date');					//delivery_date
			
			$pickup=$this->input->post('pickup');
			$delivery=$this->input->post('delivery');
			
			$order_status=$this->input->post('order_status');
			$paidby=$this->input->post('paidby');
			
			$total=$this->input->post('no_of_rec');
								
			for($i=0; $i < $total; $i++) 
			{	
				//$data['order_date']= date('Y-m-d',strtotime($order_date[$i]));
				//$data['delivery_date']= date('Y-m-d',strtotime($due_date[$i]));
				
				$data['pickup_by'] = $pickup[$i];
				$data['delivery_by'] = $delivery[$i];
				
				//$data['amt_paidby']=$paidby[$i];
				
				//$data['order_status'] = $order_status[$i];	
				
				//$data['delivery_date'] = "";	
				//if ($due_date[$i]!="") { $data['delivery_date']= date('Y-m-d',strtotime($due_date[$i])); }
				
				$this->db->where('auto_id' , $order_id[$i]);
				$this->db->update('customer_order' , $data);
			}	
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/customer_orders/invoice_list','refresh');
		}
		

		if($param1=='delete')
		{	if(isset($_POST["id"]))
			{
			 foreach($_POST["id"] as $id)
			 {
				$this->db->where('id' , $id);
				$this->db->delete('block');
			 }
			}

		}
	}
	
	
	// Quick Pos Controllers
	
	function quick_pos($pos1='',$pos2='')
	{
		//Quick Pos Select Customer Name 
		
		if($pos1=='quickpos_partyname')
		{
			$Order_Date = $this->input->post('order_date');
			$Order_Date = date('Y-m-d',strtotime($Order_Date));
			$Party_Name = $this->input->post('party_name');
			$this->session->unset_userdata('party_name');
			$this->session->set_userdata('order_date',$Order_Date);
			$this->session->set_userdata('party_name',$Party_Name);
			echo "<script> window.location.reload(); </script>;";
		}
		
		if($pos1=='pos_search')
		{	$this->session->unset_userdata('search_query');
			$SearchItem = $this->input->post('search_query');
			$this->session->set_userdata('Search_Item',$SearchItem);
		}
		
		if($pos1=='service_search')
		{	$this->session->unset_userdata('ServiceId');
			$ServiceId = $this->input->post('serviceId');
			$this->session->set_userdata('ServiceId',$ServiceId);
		}
		

		///////////////////////////////////////////
		
		
		if($pos1=='quick_insert_order')
		{	//print_r($_SESSION);
			$PartyNameTemp=$this->session->userdata('party_name');			//customer_id
			$OrderDateTemp=$this->input->post('order_date');				//customer_order_date
			$param2=$this->session->userdata('orderfrom');
			//$last_id=0;	
			//$result=$this->db->select('*')->from('customer_order')->order_by('auto_id',"desc")->limit(1)->get()->result();
			//if (count($result) > 0)	$last_id = $result[0]->auto_id;
			//$OrderInvoice=$last_id+1; 
			
			
			
			/* Insert Record in Customer Order */
			
			$OrderDateIns=$OrderDateTemp;
			$OrderTime=date('h:i A');
			$OrderMonth=date('M',strtotime($OrderDateIns));
			
			$OrderFrom=$this->session->userdata('user_from');
			if($OrderFrom=="") 
			{	$EmpId=$this->session->userdata('emp_id');
				$FirstName=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->first_name;
				$LastName=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->last_name;
				$OrderFrom=$FirstName." ".$LastName;
			}
			
			$PartyNameIns=$this->session->userdata('party_name');
			$FirstName=$this->db->get_where('users' , array('id' =>$PartyNameIns))->row()->first_name;
			$LastName=$this->db->get_where('users' , array('id' =>$PartyNameIns))->row()->last_name;
			$PartyName=$FirstName." ".$LastName;
			$TempOrderRemarks="";
			$TempOrderRemarks=$this->session->userdata('order_remark');
			
			
			$TotalQty = $this->input->post('totalpc');
			$ClothUnit = $this->input->post('cloth_unit');
			
		
			$ServiceTax = $this->input->post('servicetax');
			
			$CustCharges=$this->input->post('cust_charges');
			$DiscountCharges =$this->input->post('discharge_temp');
			$ShoppingCart =$this->input->post('shopcart');
			$DiscountAmount =$this->input->post('dis_amt');
			$ExtraChargeAmount =$this->input->post('extra_amt');
			$GrandTotal = $this->input->post('grandtotal');
			$AmtPaid=$this->input->post('amt_paid');
			$OrderStatus = $this->input->post('order_status');
			$PaymentStatus = $this->input->post('payment_status');
			$LaundryStore = $this->input->post('store_name');
			$DueDate = $this->input->post('due_date');
			$DueDate = date('Y-m-d',strtotime($DueDate));

			$payment_from=$this->input->post('payment_from');

			$login_user=$this->session->userdata('login_user');
			

			if(is_numeric($payment_from))				//check packages 
			{
				$pref_pkg=$this->db->get_where('cust_packages', array('pkg_id' => $payment_from ))->row()->pref_pkg;
				$payment_from="package";
				$PaymentStatus='bypackage';
			}
			else
			{
				$pref_pkg='';
				if($payment_from=='wallet') $PaymentStatus='bywallet';
				if($payment_from=='credit') $PaymentStatus='bycredit';
			}	
			
			$pickupBy='';
			if($param2=='employee') $pickupBy=$this->session->userdata('emp_id');
			
			$orderfinal = array('order_date' => $OrderDateIns, 'order_month' => $OrderMonth, 'order_place_from' => $OrderFrom,'customer_id' => $PartyNameIns, 'customer_name' => $PartyName, 'total_qty' => $TotalQty, 'cloth_unit' => $ClothUnit,'cust_charges' => $CustCharges,'service_tax'=>$ShoppingCart,'discount'=>$DiscountCharges, 'disc_amt' =>$DiscountAmount,'cust_extra_amt' =>$ExtraChargeAmount, 'total_paid'=>$GrandTotal, 'amt_paid'=>$AmtPaid, 'remarks' => $TempOrderRemarks,'order_status '=> $OrderStatus, 'amt_paidby '=> $PaymentStatus,'laundry_store'=> $LaundryStore,'pickup_date'=>$OrderDateIns,'order_time'=>$OrderTime,'delivery_date'=>$DueDate,'pickup_by'=>$pickupBy,'payment_from'=>$payment_from,'pref_pkg' =>$pref_pkg,'payment_collect'=>$login_user);
				
			if($GrandTotal>=0)
			{				
				if($this->db->insert('customer_order', $orderfinal)===TRUE)		// using direct parameter
				{	
				
				//////////////////////// ORDER TEMP START ////////////////////////
								
				$OrderInvoice=$this->db->insert_id();
				$CustOrderNo=$OrderInvoice;
				$OrderInvoice=INVOICE_NAME.$OrderInvoice;
				
				$data['invoice_no']=$OrderInvoice;
				$this->db->where('auto_id' , $this->db->insert_id());
				if($this->db->update('customer_order' , $data)===TRUE)


				// Amount Payable from Wallet 
					if($payment_from=='wallet')
					{
						$wallet_data=array(
											'customer_id' => $PartyNameIns,
											'payment_trans_id' => $OrderInvoice,
											'payment_date' => date('Y-m-d'),
											'payment_amt' => $GrandTotal,
											'credit_debit' => 'debit',
										);
						if($this->db->insert('wallet_history', $wallet_data)===TRUE) {}		// using direct parameter
					}
					// End Wallet

					// Amount Payable from Credit 
					if($payment_from=='credit')
					{
						$credit_data=array(
											'customer_id' => $PartyNameIns,
											'credit_trans_id' => $OrderInvoice,
											'credit_trans_date' => date('Y-m-d'),
											'credit_trans_amt' => $GrandTotal,
											'credit_debit' => 'debit',
										);
						if($this->db->insert('credit_history', $credit_data)===TRUE) {}		// using direct parameter
					}
					// End Credit



					
				////// Update Landru Store //////
				$storedata['laundry_store'] = $this->input->post('store_name');
				$this->db->where('id' , $PartyNameIns);
				if($this->db->update('users' , $storedata)===TRUE) 	
				
							
				foreach($_SESSION['shopping_cart'] as $key => $product) :
				{
				$Short_ID=$product['product_id'];
				if($product['brand']!="") { $GarBrand=$product['brand']; } else { $GarBrand=""; }
				if($product['pack']!="") { $GarPack=$product['pack']; } else { $GarPack=""; }
				if($product['starch']!="") { $GarStarch=$product['starch']; } else { $GarStarch=""; }
				if($product['defect']!="") { $GarDefect=$product['defect']; } else { $GarDefect=""; }
				if($product['color']!="") { $GarColor=$product['color']; } else { $GarColor=""; }
				if($product['unit']!="") { $GarUnit=$product['unit']; } else { $GarUnit=""; }
				if($product['kgitem']!="") { $GarKgItem=$product['kgitem']; } else { $GarKgItem=""; }
				if($product['kgqty']!="") { $GarKgQty=$product['kgqty']; } else { $GarKgQty=""; }
								
				
				// Add Service and Cloth Id 
				$ItemData = $this->db->get_where('price_list' , array('id' => $Short_ID) )->result();
				
				foreach($ItemData as $ItemRow) :
				{
					//Service Name
					$ServiceID=$ItemRow->service_id;
					$ServiceData = $this->db->get_where('services' , array('id' => $ServiceID) )->result();
					foreach($ServiceData as $ServiceRow) :
					{
						$ItemServiceName=$ServiceRow->service_name;
					}
					endforeach;
					
					//Cloth Name
					$ClothID=$ItemRow->cloth_id;
					$ClothData = $this->db->get_where('cloths' , array('id' => $ClothID) )->result();
					foreach($ClothData as $ClothRow) :
					{
						$ItemClothType=$ClothRow->cloth_type;
					}
					endforeach;
					
					//Cloth Price
					$ItemPrice=$ItemRow->price;
					
				}
				endforeach;
				/////////////
				
				$ItemPrice=$product['price']; 
				
				$Qty=$product['quantity']; 
				
				// Order Temp Database 
				
				$order = array('order_invoice' => $OrderInvoice,'cust_order_no'=>$CustOrderNo, 'order_date' => $OrderDateTemp, 'customer_id' => $PartyNameTemp, 'price_shortcode' => $Short_ID, 'order_service' => $ItemServiceName, 'order_cloth' => $ItemClothType, 'order_qty' => $Qty, 'order_price' => $ItemPrice,'garment_brand'=>$GarBrand,'garment_pack'=>$GarPack,'garment_starch'=>$GarStarch,'garment_defect'=>$GarDefect,'garment_color'=>$GarColor,'garment_unit'=>$GarUnit,'garment_kg_desc'=>$GarKgItem,'garment_kg_qty'=>$GarKgQty);
					if($this->db->insert('order_temp', $order)) { }		
						
				// END Order Temp Database Addded Records 
				
				}
				endforeach;
				
				///////////////////////////////// ORDER TEMP /////////////////////////////////////

				/* Message and Email sending to Customer and Owners */

					//// Customer Information ////
					$CustId=$PartyNameTemp;
					$pickupdate=$OrderDateIns;
					$pickuptime=$OrderTime;
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
					$platform="admin panel";
					$this->bulk_message->bulk_sms($mobile,$sms,$platform);


					// New Order Generation Invoice message from Admin Panel

							$InvoiceQty=$TotalQty;
							$InvoiceTotalAmt=$GrandTotal;
												
					 	    //Customer Email 
					 	    $subject='Challan Generation';
							$message = "Hi, ".$first_name." your Invoice ".$OrderInvoice." challen has generated successfully";
							$message.= "<br/> Total Qty : ". $InvoiceQty ." & Payable Amount is Rs.". $InvoiceTotalAmt;

							$email_message=$message;
							$email_message.="<br/> Check it on ".base_url()."";
							$this->bulk_message->bulk_email($email_id,$subject,$email_message);

					 	    //CUstomer Mobile SMS 
							$sms =$message;
							$sms.=" Check it on ".MOBAPPLINK;
							$this->bulk_message->bulk_sms($mobile,$sms);

					// End Order from Admin Panel


			 	    
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
					$this->bulk_message->bulk_sms($ownmobile,$ownsms);


				/************** End Message and Email **************/

				$this->session->set_userdata('party_name','');

				?>
				<script> alert("<?php echo lang('record_save'); ?>"); </script>
				<?php
				unset($_SESSION['shopping_cart']); unset($_SESSION['party_name']); 
				unset($_SESSION['order_remark']); unset($_SESSION['UpdateOrder']);
				if($this->input->post('payment_status')=="byonline") 
						{	$onlinepayment['payment_status']=$CustOrderNo;
							redirect('admin/online_payment/'.$CustOrderNo, "refresh");
						}	
					else {	if($param2=="employee") 
							{ redirect(''.base_url().'index.php/mobile/empPickUp','refresh'); 
							}
							else
							{	
								if($pos2=='print') 
								{ 	
								?>
									<script> 
										alert('redirect to print');
										window.open('<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $CustOrderNo ?>','_blank');
									</script>
								<?php	
								}
							}

							redirect('admin/customer_orders/invoice_list','refresh'); 
						 }
				}	
			}
			else
			{	
			?>
				<script> alert("<?php echo lang('NotAllow'); ?>"); </script>
				
			<?php
				redirect('pos','refresh');
			}	
			
			/*****************/
						
		}
		
		// Quick Pos Update Orders 
		
		if($pos1=='quick_update_order')
		{	//echo "Under Construction";
			/*
			$OrderFrom=$this->session->userdata('user_from');
			if($OrderFrom=="") 
			{	$EmpId=$this->session->userdata('emp_id');
				$FirstName=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->first_name;
				$LastName=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->last_name;
				$OrderFrom=$FirstName." ".$LastName;
			}
			
			$upquick['order_place_from']=$OrderFrom; */
			
			$upquick['remarks']=$this->session->userdata('order_remark');
			
			
			$upquick['total_qty'] = $this->input->post('totalpc');
			$upquick['cloth_unit'] = $this->input->post('cloth_unit');
			
		
			$upquick['service_tax'] = $this->input->post('servicetax');
			
			$upquick['cust_charges']=$this->input->post('cust_charges');
			$upquick['discount']=$this->input->post('discharge_temp');
			$upquick['service_tax'] =$this->input->post('shopcart');
			$upquick['disc_amt'] =$this->input->post('dis_amt');
			$upquick['total_paid'] = $this->input->post('grandtotal');
			$upquick['amt_paid'] = $this->input->post('amt_paid');
			if($this->input->post('amt_paid')!=0) { $upquick['paid_date']=date('Y-m-d'); }
			$upquick['amt_paidby'] = $this->input->post('payment_status');
			if($this->input->post('amt_paidby')=='notpaid') { $upquick['amt_paid']=0.000; }
			$upquick['order_status'] = $this->input->post('order_status');
			$upquick['laundry_store'] = $this->input->post('store_name');
			$DueDate = $this->input->post('due_date');
			$upquick['delivery_date'] = date('Y-m-d',strtotime($DueDate));

			$payment_from=$this->input->post('payment_from');
			$upquick['payment_collect']=$this->session->userdata('login_user');

			if(is_numeric($payment_from))				//check packages 
			{	$upquick['amt_paidby']='bypackage';
				$upquick['payment_from']="package";
				$upquick['pref_pkg']=$this->db->get_where('cust_packages', array('pkg_id' => $payment_from ))->row()->pref_pkg;
			}
			else
			{	
				$upquick['payment_from'] = $this->input->post('payment_from');
				$upquick['pref_pkg']='';
				if($payment_from=='wallet') $upquick['amt_paidby']='bywallet';
				if($payment_from=='credit') $upquick['amt_paidby']='bycredit';
			}	
			
			$this->db->where('auto_id' , $this->session->userdata('order_auto_id'));
			
			
					
			
			if($this->input->post('grandtotal')>0)
			{				
				if($this->db->update('customer_order' , $upquick)===TRUE)		// using direct parameter
				{		
						////// Update Landru Store //////
						$PartyNameIns=$this->session->userdata('party_name');
						$data['laundry_store'] = $this->input->post('store_name');
						$this->db->where('id' , $PartyNameIns);
						if($this->db->update('users' , $data)===TRUE)
				
				//////////////////////// ORDER TEMP START 
				
				$OrderInvoice=$this->session->userdata('order_auto_id');
				$CustOrderNo=$OrderInvoice;
				$OrderDateTemp=$this->db->get_where('customer_order' , array('auto_id' => $OrderInvoice) )->row()->order_date;
				$PartyNameTemp=$this->db->get_where('customer_order' , array('auto_id' => $OrderInvoice) )->row()->customer_id;
				$OrderInvoice=$this->db->get_where('customer_order' , array('auto_id' => $OrderInvoice) )->row()->invoice_no;
				
			
								
				
				////////////////////// ORDER TEMP DELETE ///////////////////////
				
				$this->db->where('order_invoice' , $OrderInvoice);
				if($this->db->delete('order_temp')===TRUE)		// using direct parameter
				// if($payment_from=='wallet' || $payment_from=='credit' )
				// {
					$this->db->where('credit_trans_id' , $OrderInvoice);
					if($this->db->delete('credit_history')===TRUE) {}		// using direct parameter

					$this->db->where('payment_trans_id' , $OrderInvoice);
					if($this->db->delete('wallet_history')===TRUE) {}		// using direct parameter

					// Amount Payable from Wallet 
					if($payment_from=='wallet')
					{
						$wallet_data=array(
											'customer_id' => $PartyNameIns,
											'payment_trans_id' => $OrderInvoice,
											'payment_date' => date('Y-m-d'),
											'payment_amt' => $this->input->post('grandtotal'),
											'credit_debit' => 'debit',
										);
						if($this->db->insert('wallet_history', $wallet_data)===TRUE) {}		// using direct parameter
					}
					// End Wallet

					// Amount Payable from Credit 
					if($payment_from=='credit')
					{
						$credit_data=array(
											'customer_id' => $PartyNameIns,
											'credit_trans_id' => $OrderInvoice,
											'credit_trans_date' => date('Y-m-d'),
											'credit_trans_amt' => $this->input->post('grandtotal'),
											'credit_debit' => 'debit',
										);
						if($this->db->insert('credit_history', $credit_data)===TRUE) {}		// using direct parameter
					}
					// End Wallet



				// }
			
				///////////////////////////////////////////////////////////////

				
				
								
				foreach($_SESSION['shopping_cart'] as $key => $product) :
				{
				$Short_ID=$product['product_id'];
				if($product['brand']!="") { $GarBrand=$product['brand']; } else { $GarBrand=""; }
				if($product['pack']!="") { $GarPack=$product['pack']; } else { $GarPack=""; }
				if($product['starch']!="") { $GarStarch=$product['starch']; } else { $GarStarch=""; }
				if($product['defect']!="") { $GarDefect=$product['defect']; } else { $GarDefect=""; }
				if($product['color']!="") { $GarColor=$product['color']; } else { $GarColor=""; }
				if($product['unit']!="") { $GarUnit=$product['unit']; } else { $GarUnit=""; }
				if($product['kgitem']!="") { $GarKgItem=$product['kgitem']; } else { $GarKgItem=""; }
				if($product['kgqty']!="") { $GarKgQty=$product['kgqty']; } else { $GarKgQty=""; }
				
				// Add Service and Cloth Id 
				$ItemData = $this->db->get_where('price_list' , array('id' => $Short_ID) )->result();
				
				foreach($ItemData as $ItemRow) :
				{
					//Service Name
					$ServiceID=$ItemRow->service_id;
					$ServiceData = $this->db->get_where('services' , array('id' => $ServiceID) )->result();
					foreach($ServiceData as $ServiceRow) :
					{
						$ItemServiceName=$ServiceRow->service_name;
					}
					endforeach;
					
					//Cloth Name
					$ClothID=$ItemRow->cloth_id;
					$ClothData = $this->db->get_where('cloths' , array('id' => $ClothID) )->result();
					foreach($ClothData as $ClothRow) :
					{
						$ItemClothType=$ClothRow->cloth_type;
					}
					endforeach;
					
					//Cloth Price
					$ItemPrice=$ItemRow->price;
					
				}
				endforeach;
				/////////////
				
				$ItemPrice=$product['price']; 
				
				$Qty=$product['quantity']; 
				
				// Order Temp Database 
				
				
				$order = array('order_invoice' => $OrderInvoice,'cust_order_no'=>$CustOrderNo, 'order_date' => $OrderDateTemp, 'customer_id' => $PartyNameTemp, 'price_shortcode' => $Short_ID, 'order_service' => $ItemServiceName, 'order_cloth' => $ItemClothType, 'order_qty' => $Qty, 'order_price' => $ItemPrice,'garment_brand'=>$GarBrand,'garment_pack'=>$GarPack,'garment_starch'=>$GarStarch,'garment_defect'=>$GarDefect,'garment_color'=>$GarColor,'garment_unit'=>$GarUnit,'garment_kg_desc'=>$GarKgItem,'garment_kg_qty'=>$GarKgQty);
					if($this->db->insert('order_temp', $order)) { }			
						
				// END Order Temp Database Addded Records 
				
				}
				endforeach;
				
				///////////////////////////////// ORDER TEMP
				
				$param2=$this->session->userdata('orderfrom');
				$this->session->set_userdata('party_name','');

					/************** Customer Challan Generatinon [ Order Update ] *************/

						$InviceOrderStatus=$this->input->post('order_status');

						if($InviceOrderStatus=="inprocess") {
					
							$CustId=$PartyNameIns;
							$InvoiceQty=$this->input->post('totalpc');
							$InvoiceTotalAmt=$this->input->post('grandtotal');

							$first_name=$this->db->get_where('users' , array('id' =>$CustId))->row()->first_name;
							$email_id=$this->db->get_where('users' , array('id' =>$CustId))->row()->email_id;
							$mobile=$this->db->get_where('users' , array('id' =>$CustId))->row()->mobile;

							// Update Order Generation Invoice message from Admin Panel
												
					 	     //Customer Email 
					 	    $subject='Challan Generation';
							$message = "Hi, ".$first_name." your Invoice ".$OrderInvoice." challen has generated successfully";
							$message.= "<br/> Total Qty : ". $InvoiceQty ." & Payable Amount is Rs.". $InvoiceTotalAmt;

							$email_message=$message;
							$email_message.="<br/> Check it on ".base_url()."";
							$this->bulk_message->bulk_email($email_id,$subject,$email_message);

					 	    //CUstomer Mobile SMS 
							$sms =$message;
							$sms.=" Check Invoice on ".MOBAPPLINK;
							$this->bulk_message->bulk_whatsapp($mobile,$sms);

							// echo $sms;

							// End Order from Admin Panel
					}
								
					/***************** End Customer Challan Generation ****************/
					

				
				
				
				// if($param2!="employee")  echo '<script> alert("Order Update Successfully"); </script>';
				
				?>
				<script> alert("<?php echo lang('record_update'); ?>"); </script>
				<?php
				unset($_SESSION['shopping_cart']); unset($_SESSION['party_name']); 
				unset($_SESSION['order_remark']); unset($_SESSION['UpdateOrder']);
					if($this->input->post('payment_status')=="byonline") 
						{	
							$onlinepayment['payment_status']=$CustOrderNo;
							redirect('admin/customer_orders/online_payment',$onlinepayment);
						}	
					else {	if($param2=="employee") 
							{ redirect(''.base_url().'index.php/mobile/empcustadd/'.$PartyNameTemp.'/pickup/'.$CustOrderNo.'','refresh'); 
							}
							else
							{
								if($pos2=='print') 
								{ 	
								?>
									<script> 
										alert('redirect to print');
										window.open('<?php echo base_url();?>index.php/admin/customer_orders/mini_invoice/<?php echo $CustOrderNo ?>','_blank');
									</script>
								<?php	
								}
							}	
							redirect('admin/customer_orders/invoice_list','refresh'); 
						}
				}	
			}
			else
			{	
			?>
				<script> alert("<?php echo lang('NotAllow'); ?>"); </script>
				
			<?php
				redirect('pos','refresh');
			}	
			
			/*****************/
			
			
			
				
		}	
			
		////////////////////// Quick Pos Update Orders
	}
	
	/////////////////////////////////////////

	
	function customer_orders($order1='',$order2='', $order3='')
	{	
		//if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->session->set_userdata('menu','job_order');
		$this->session->set_userdata('submenu','neworder');
		
		if($order1=='neworder')
		{	$this->db->order_by("id","desc");
			$data['partyname'] = $this->db->get('users');
			$data['charge_list'] = $this->db->get('tax_charges');
			$this->load->view('admin/customer_order_party_name',$data);
			
			
			
		}

		if($order1=="change_date")
		{
			// echo "pickup";
			$data['CustId']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->customer_id;
			$data['InvoiceNo']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->invoice_no;
			$data['OrderDate']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->order_date;
			$data['PickupDate']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->pickup_date;
			$data['PickupTime']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->pickup_time;
			$data['DeliveryDate']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->delivery_date;
			$data['DeliveryTime']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->delivery_time;
			$data['OrderStatus']=$this->db->get_where('customer_order',array('auto_id=' => $order2))->row()->order_status;
			$data['OrderId']=$order2;
			$data['change_date'] = $this->db->get_where('customer_order',array('auto_id=' => $order2))->result();
			$this->load->view('admin/cust_change_order_date',$data);
		}

		if($order1=='modify_order_date')
		{
			echo $order2;

			$OrderStatus=$this->input->post('order_status');

			if($OrderStatus=='new_order')
			{	
			$dateUpdate['order_date']=date('Y-m-d',strtotime($this->input->post('order_date')));
			$dateUpdate['pickup_date']=date('Y-m-d',strtotime($this->input->post('pickup_date')));
			$dateUpdate['pickup_time']=$this->input->post('pickup_time');
			$dateUpdate['delivery_date']=date('Y-m-d',strtotime($this->input->post('pickup_date').'+3 days'));
			}
			else
			{ 
				$dateUpdate['delivery_date']=date('Y-m-d',strtotime($this->input->post('delivery_date')));
				$dateUpdate['delivery_time']=$this->input->post('delivery_time');
			}
			
			$this->db->where('auto_id' , $order2);
				
				
				if($this->db->update('customer_order', $dateUpdate)===TRUE)		// using direct parameter
				{
					echo "<script> alert('Dates Updated Successfully'); <script>";
					redirect('admin/customer_orders/invoice_list','refresh');
				}	
			
		}
		
				
		if($order1=='invoice_list')
		{
			$this->session->set_userdata('order_date','');
			$this->session->set_userdata('party_name','');
			
			$this->session->set_userdata('menu','job_order');
			$this->session->set_userdata('submenu','invoicelist');
            
			$data['userdata'] = $this->db->get('users');
			/*
			$storeId=$this->session->userdata('store_id');
			if($storeId!=0) 
			{ $data['userdata'] = $this->db->get_where('users' , array('laundry_store' =>$storeId ));
			  $data['store_list'] = $this->db->get_where('stores' , array('id' =>$storeId ));
			}
			*/
		
            $this->db->order_by("auto_id","desc");
			// $data['invoiceorder'] = $this->db->get('customer_order');

			// if($order2=='pending') $data['invoiceorder'] = $this->db->get_where('customer_order',array('order_status!='=>'delivered'));
			// if($order2=='delivered') $data['invoiceorder'] = $this->db->get_where('customer_order',array('order_status'=>'delivered'));
			// $this->db->limit(300);
            $data['invoiceorder'] = ($order2=='pending') ? $this->db->get_where('customer_order',array('order_status!='=>'delivered')) : ( ($order2=='delivered') ? $this->db->get_where('customer_order',array('order_status'=>'delivered')) : $this->db->limit(1300)->get('customer_order'));
					
			$storeId=$this->session->userdata('store_id');
			if($storeId!=0) {
			//$data['invoiceorder'] = $this->db->get_where('customer_order' , array('laundry_store' =>$storeId, 'laundry_store' =>0));
		
			$data['invoiceorder'] = $this->db->query("SELECT * FROM `customer_order`  WHERE `laundry_store` =  $storeId OR `laundry_store`=0 ORDER BY auto_id desc");
			}

         	$this->load->view('admin/customer_invoice_list',$data);
			
		}
		
		//Order Status (Paid or Not Paid ) Invoice List 
		
		if($order1=='order_status')
		{	//echo $order2;
			
			$OrderStatus= $this->db->get_where('customer_order' , array('auto_id' => $order2) )->result();
			foreach($OrderStatus as $order_row)
			{	$OrderData['InvoiceId']=$order2;
				$OrderData['InvoiceNo']=$order_row->invoice_no;
				$OrderData['CustId']=$order_row->customer_id;
				$OrderData['AmtPaidBy']=$order_row->amt_paidby;
				$OrderData['AmtPaidDate']=$order_row->paid_date;
				$OrderData['pkgQty']=$order_row->total_qty;
				$OrderData['prodUnit']=$order_row->cloth_unit;
				$OrderData['grandtotal']=$order_row->total_paid;
				$OrderData['OrderStatusBy']=$order_row->order_status;
				$OrderData['StoreId']=$order_row->laundry_store;
				
				$OrderData['PaidDate']=date('d-m-Y',strtotime($order_row->paid_date)); 

				$OrderData['FromMenu']=$order3;

			}
			
           	$this->load->view('admin/cust_order_paid_status',$OrderData);
			
		}
		
		if($order1=='modify_paid_status')
		{	
			
			$paidBy=$this->input->post('paidby');				// check package id or string 
			
			if(is_numeric($paidBy))
			{
				$data['amt_paidby']="bypackage";
				$data['pref_pkg'] = $this->db->get_where('cust_packages', array('pkg_id' => $paidBy ))->row()->pref_pkg;
				$data['payment_from'] = 'package';
			}
			else
			{
				$data['amt_paidby'] = $this->input->post('paidby');
				$data['pref_pkg'] = '';
				$data['payment_from'] = '';

			}

			// end package selection


			if($this->input->post('amt_paid')!=0 )
			{	
			$paidDate=$this->input->post('paid_date');
			$paidDate=date('Y-m-d',strtotime($paidDate));
			$data['paid_date']=$paidDate;
			$data['amt_paid']=$this->input->post('amt_paid'); 
			}
			
			$data['order_status'] = $this->input->post('order_status');
			if($this->input->post('order_status')=='delivered') { $data['delivery_date']=date('Y-m-d'); }
			$login_user=$this->session->userdata('login_user');
			$data['payment_collect'] = $login_user;
			
			$this->db->where('auto_id' , $order2);
				
				
				if($this->db->update('customer_order', $data)===TRUE)		// using direct parameter
				{
					$OrderInvoice=$this->input->post('invoice_no');
					$payment_from=$this->input->post('paidby');
					$CustId=$this->input->post('cust_id');
					// if($payment_from=='wallet' || $payment_from=='credit' )
					// {
						$this->db->where('credit_trans_id' , $OrderInvoice);
						if($this->db->delete('credit_history')===TRUE) {}		// using direct parameter

						$this->db->where('payment_trans_id' , $OrderInvoice);
						if($this->db->delete('wallet_history')===TRUE) {}		// using direct parameter

						// Amount Payable from Wallet 
						if($payment_from=='bywallet')
						{
							$wallet_data=array(
												'customer_id' => $this->input->post('cust_id'),
												'payment_trans_id' => $this->input->post('invoice_no'),
												'payment_date' => date('Y-m-d'),
												'payment_amt' => $this->input->post('grandtotal'),
												'credit_debit' => 'debit',
											);
							if($this->db->insert('wallet_history', $wallet_data)===TRUE) {}		// using direct parameter
						}
						// End Wallet

						// Amount Payable from Credit 
						if($payment_from=='bycredit')
						{
							$credit_data=array(
												'customer_id' => $this->input->post('cust_id'),
												'credit_trans_id' => $OrderInvoice,
												'credit_trans_date' => date('Y-m-d'),
												'credit_trans_amt' => $this->input->post('grandtotal'),
												'credit_debit' => 'debit',
											);
							if($this->db->insert('credit_history', $credit_data)===TRUE) {}		// using direct parameter
						}
						// End Credit

					// }

					// Email Sending

					$order_status=$this->input->post('order_status');
					$invoice_no=$this->input->post('invoice_no');	
					$cust_id=$this->input->post('cust_id');

					$this->bulk_message->send_message($order_status,$invoice_no,$cust_id);

					// End Email Sending	

					if($order3=='cust_menu')
					{	
						redirect('admin/customer_order_details/'.$CustId.'','refresh');
					}
					else
					{
						redirect('admin/customer_orders/invoice_list','refresh');	
					}	
				}	
			
		}
		
		
        
        if($order1=='order_tags')
    	{
			$tags['invoice_data'] = $this->db->get_where('customer_order' , array('auto_id' => $order2) )->result();
			$barcodedata = $this->db->get_where('order_temp' , array('cust_order_no' => $order2) )->result();
			$Count=0;$KgQty=0; $GarQty=0;
			foreach ($barcodedata as $row):
			
			if($row->garment_unit=="Kg")
				{ $GarKgQty=unserialize($row->garment_kg_qty);
				  foreach($GarKgQty as $kgqtyrow){
				  $KgQty=$KgQty+$kgqtyrow;
				}
				  
			}
			if($row->garment_unit=="Qty")
			{	
				// $GarQty=$GarQty+$row->order_qty;
				$total_qty=$row->order_qty;
				for($totq=1;$totq<=$total_qty;$totq++)
				{
					$clothType=$row->order_cloth;  
					$Cloth_pieces=$this->db->get_where('cloths' , array('cloth_type' => $clothType) )->row()->no_of_qty;
					$GarQty=$GarQty+$Cloth_pieces;
					
				}  // total qty for loop

				
				// if($Cloth_pieces==1)
				// for($clp=1;$clp<=$Cloth_pieces;$clp++)
				// {
				// 	echo $GarQty=$GarQty+$Cloth_pieces;
				// }
				// else
				// {
				// 	$GarQty=$GarQty+$row->order_qty;
				// }	
				
				
			}
			
			endforeach;		

			$Count=$KgQty+$GarQty;
			
			for($i=1;$i<=$Count; $i++)
				{	$code=$row->order_invoice."-".$i;
					$this->load->library('zend');
					$this->zend->load('Zend/Barcode');
					$file = Zend_Barcode::draw('code128', 'image', array('text' => $code,'drawText' => false), array());
					//$code = time().$code;
					//$store_image = imagepng($file,"".base_url()."barcode/{$code}.png");
					$store_image = imagepng($file,"barcode/{$code}.png");
				}
			$tags['Count']=$Count;
			$tags['price_data'] = $this->db->get('price_list');
			$tags['laundry_service'] = $this->db->get('services');
			$this->load->view('admin/cust_order_tags',$tags);
		}
		
		if($order1=='mini_invoice')
    	{
					// create invoice barcode image 
					$code=$this->db->get_where('customer_order' , array('auto_id' => $order2))->row()->invoice_no;
					// $code = chunk_split($code, 1, ' ');
					$this->load->library('zend');
					$this->zend->load('Zend/Barcode');
					$file = Zend_Barcode::draw('code128', 'image', array('text' => $code,'drawText' => false), array());
					$store_image = imagepng($file,"barcode/{$code}.png");
					
			$mini['invoice_data'] = $this->db->get_where('customer_order' , array('auto_id' => $order2) )->result();
			$mini['customer_data'] = $this->db->get('users');
			$mini['price_data'] = $this->db->get('price_list');
			$mini['laundry_service'] = $this->db->get('services');
			$mini['laundry_cloth'] = $this->db->get('cloths');			
			$this->load->view('admin/customer_mini_invoice.php',$mini);
			
						
		}
		
		
		
		if($order1=='session_partyname')
		{
			$Order_Date = $this->input->post('order_date');
			$Order_Date = date('Y-m-d',strtotime($Order_Date));
			$Party_Name = $this->input->post('party_name');
			$this->session->set_userdata('order_date',$Order_Date);
			$this->session->set_userdata('party_name',$Party_Name);
						
			$uresult = $this->db->get_where('customer_order' , array('order_date' => $Order_Date, 'customer_id' => $Party_Name) )->result();
			
			redirect('pos','refresh');
			
			if (count($uresult) > 0)
			{
				foreach($uresult as $getcustrow): 
				$CustId=$getcustrow->auto_id;
				endforeach;
				redirect('admin/customer_orders/update_order/'.$CustId.'','refresh');
				
			}
			else
			{
				//redirect('admin/customer_orders/add_order','refresh');
				redirect('pos','refresh');
			}		
			
		}
		
		// update discount
		
		if($order1=="update_disc")
		{	
			$id=$this->input->post('invoice_id');
	
			$data['disc_amt'] = $this->input->post('discount_amt');
			
						
			$this->db->where('auto_id' , $id);
			
			if($this->db->update('customer_order' , $data)===TRUE)		// using direct parameter
			{
			redirect('admin/customer_orders/update_order/'.$id.'','refresh');
			}
		}
		
		

		if($order1=='add_order')
		{	
			$session['price_data'] = $this->db->get('price_list');
			$session['laundry_service'] = $this->db->get('services');
			$session['laundry_cloth'] = $this->db->get('cloths');
			$session['Order_Date']=$this->session->userdata('order_date');
			$session['Party_Name']=$this->session->userdata('party_name');
			
			$Order_Date=$this->session->userdata('order_date');
			$Party_Name=$this->session->userdata('party_name');
			
			
			$session['userdata'] = $this->db->get('users');
			$session['order_temp'] = $this->db->get_where('order_temp' , array('order_date' => $Order_Date,'customer_id' => $Party_Name) )->result();
			
			$session['last_id']=0;	
			$result=$this->db->select('*')->from('customer_order')->order_by('auto_id',"desc")->limit(1)->get()->result();
			if (count($result) > 0)	$session['last_id'] = $result[0]->auto_id;
		
			
			$this->load->view('admin/customer_order',$session);
			
		}
		
		if($order1=='update_order')
		{	
			$session['RPC'] = $order3;			
			$session['price_data'] = $this->db->get('price_list');
			$session['laundry_service'] = $this->db->get('services');
			$session['laundry_cloth'] = $this->db->get('cloths');
			//$session['employeedata'] = $this->db->get_where('employee', array('emp_role'=>'enable'));
						
			
			$updatedata = $this->db->get_where('customer_order' , array('auto_id' => $order2) );
			
			foreach($updatedata->result() as $updaterow): 
				$Order_Date_Session = $updaterow->order_date ;
				$Party_Name_Session = $updaterow->customer_id ;
				$Invoice_No = $updaterow->invoice_no;
				//$session['Discount']=unserialize($updaterow->discount);	
				//$session['ServiceTax']=$updaterow->service_tax ;
				$session['DiscAmt']=$updaterow->disc_amt;
				$session['TotalPaid']=$updaterow->total_paid ;
				$session['AmtPaidBy']=$updaterow->amt_paidby ;
				$session['ChequeDate']=$updaterow->cheque_date ;
				$session['Remarks']=$updaterow->remarks ;
				$session['pickup_by']=$updaterow->pickup_by ;
				$session['PickupDate']=$updaterow->pickup_date;
				$session['delivery_by']=$updaterow->delivery_by ;
				$session['DeliveryDate']=$updaterow->delivery_date;
				$session['OrderStatus']=$updaterow->order_status;
				$session['InvoiceNo']=$updaterow->invoice_no;
				
				
				$this->session->set_userdata('order_date',$Order_Date_Session);
				$this->session->set_userdata('party_name',$Party_Name_Session);
				$this->session->set_userdata('invoice_no',$Invoice_No);
			endforeach;

						
			$session['Order_Date']=$this->session->userdata('order_date');
			$session['Party_Name']=$this->session->userdata('party_name');
			
			
			$session['userdata'] = $this->db->get('users');
			
			$Order_Date=$this->session->userdata('order_date');
			$Party_Name=$this->session->userdata('party_name');
			
			$session['order_temp'] = $this->db->get_where('order_temp' , array('order_date' => $Order_Date,'customer_id' => $Party_Name,'order_invoice' => $Invoice_No) )->result();
			
				
			$session['last_id']=$order2-1;			
			
			$this->load->view('admin/customer_update_order',$session);
			
		}
		
		
		if($order1=='insert_order_final')
		{
			$OrderDate=$this->session->userdata('order_date');
			$OrderDateIns=date('Y-m-d',strtotime($OrderDate));
			$OrderMonth=date('M',strtotime($OrderDateIns));
			$OrderFrom=$this->session->userdata('user_from');
			
			$PartyNameIns=$this->session->userdata('party_name');
			
			
			$Invoice = $this->input->post('invoice_no');
			$TotalQty = $this->input->post('totalpc');
			
			//$Discount = $this->input->post('discount');
			//$ServiceTax = $this->input->post('servicetax');
			
			$CustCharges=$this->input->post('cust_charges');
			$DiscountCharges =$this->input->post('discharge_temp');
			$DiscountAmount =$this->input->post('dis_amt');
			$SubTotal = $this->input->post('totalamt');
			$GrandTotal = $this->input->post('grandtotal');
			$PaidBy = $this->input->post('paidby');
			$PaidDate = $this->input->post('cheque_date');
			$Remarks = $this->input->post('remarks');
			$OrderStatus = 'pending';
			
			if($SubTotal>0) 
			{
				$orderfinal = array('invoice_no' => $Invoice, 'order_date' => $OrderDateIns, 'order_month' => $OrderMonth,'customer_id' => $PartyNameIns,'customer_name' => $PartyName, 'total_qty' => $TotalQty, 'total_paid' => $GrandTotal, 'cust_charges' => $CustCharges,'discount'=>$DiscountCharges, 'disc_amt' =>$DiscountAmount, 'amt_paidby' => $PaidBy, 'cheque_date' => $PaidDate, 'remarks' => $Remarks,'order_status '=> $OrderStatus, 'pickup_date'=>$OrderDate, );
				if($this->db->insert('customer_order', $orderfinal)===TRUE)		// using direct parameter
				{
				?>
				<script> alert("<?php echo lang('record_save'); ?>"); </script>
				<?php
				//redirect('admin/customer_orders/invoice_list','refresh');
				}	
			}
			else	
			{	echo "<script> alert('<?php echo lang('Orderempty'); ?>'); </script>";
				redirect('admin/customer_orders/add_order','refresh');
			}
		}
		
		if($order1=='update_order_final')
		{
			
			//$data['pickup_by'] = $this->input->post('pickup');
			$data['pickup_date'] = $this->input->post('pickup_date');
			//$data['delivery_by'] = $this->input->post('delivery');
			if($this->input->post('pickup_date')=='') 
			$data['delivery_by']=''; 
			$data['delivery_date'] = $this->input->post('delivery_date');
			$data['total_qty'] = $this->input->post('totalpc');
			
			//$data['discount'] = $this->input->post('discount');
			//$data['service_tax'] = $this->input->post('servicetax');
			
			$data['cust_charges'] = $this->input->post('cust_charges');
			
			 
			//$discount=serialize($this->input->post('discharge_temp'));
			$data['disc_amt'] =$this->input->post('disc_amt');
			$data['discount'] =$this->input->post('discharge_temp');
			$data['total_paid'] = $this->input->post('granttotal');
			$data['amt_paidby'] = $this->input->post('paidby');
			$data['cheque_date'] = $this->input->post('cheque_date');
			$data['remarks'] = $this->input->post('remarks');
			$data['order_status'] = $this->input->post('order_status');
			
			$GrandTotal = $this->input->post('granttotal');
			if($GrandTotal>0) 
			{
				
				$this->db->where('auto_id' , $order2);
				
				
				if($this->db->update('customer_order', $data)===TRUE)		// using direct parameter
				{
				?>
				<script> alert("<?php echo lang('record_update'); ?>"); </script>
				<?php
				redirect('admin/customer_orders/update_order/'.$order2.'','refresh');
				//redirect('admin/customer_orders/invoice_list','refresh');
				
				}	
			}
			else	
			{	echo $GrandTotal;
				echo "<script> alert('<?php echo lang('Orderempty'); ?>'); </script>";
				redirect('admin/customer_orders/update_order/'.$order2.'','refresh');
			}
		}
		
		
		
		
		if($order1=='add_item')
		{
			$data['price_data'] = $this->db->get('price_list');
			$data['laundry_service'] = $this->db->get('services');
			$data['laundry_cloth'] = $this->db->get('cloths');
			$data['UpdateOrder'] = $order2;
			$this->load->view('admin/add_item',$data);
		}
		
		if($order1=='add_item_order')
		{
			
			$OrderDateTemp=$this->session->userdata('order_date');
			$PartyNameTemp=$this->session->userdata('party_name');
			$InvoiceNo=$this->session->userdata('invoice_no');
			
			$Short_ID = $this->input->post('short_code');
						
			$ItemData = $this->db->get_where('price_list' , array('id' => $Short_ID) )->result();
			
			foreach($ItemData as $ItemRow) :
			{
				//Service Name
				$ServiceID=$ItemRow->service_id;
				$ServiceData = $this->db->get_where('services' , array('id' => $ServiceID) )->result();
				foreach($ServiceData as $ServiceRow) :
				{
					$ItemServiceName=$ServiceRow->service_name;
				}
				endforeach;
				
				//Cloth Name
				$ClothID=$ItemRow->cloth_id;
				$ClothData = $this->db->get_where('cloths' , array('id' => $ClothID) )->result();
				foreach($ClothData as $ClothRow) :
				{
					$ItemClothType=$ClothRow->cloth_type;
				}
				endforeach;
				
				//Cloth Price
				$ItemPrice=$ItemRow->price;
				
			}
			endforeach;
			
			$Qty = $this->input->post('qty');
			
			// Check Product  Item Already Exist or Not 
    		
			$this->db->where('order_date', $OrderDateTemp);
			$this->db->where('customer_id', $PartyNameTemp);
			$this->db->where('order_invoice', $InvoiceNo);
			$this->db->where('price_shortcode', $Short_ID);
			$itemresult = $this->db->get('order_temp');
		
						
			if (count($itemresult->result()) > 0)
			{	echo "<script> alert('Product or Item Already Exist !!!'); </script>"; 
		
				if($order2!='')
					{
						redirect('admin/customer_orders/update_order/'.$order2.'','refresh');
					}
					else
					{
						redirect('admin/customer_orders/add_order','refresh');
					}	
			}
			else
			{	
				$order = array('order_date' => $OrderDateTemp, 'customer_id' => $PartyNameTemp, 'order_invoice' => $InvoiceNo, 'price_shortcode' => $Short_ID, 'order_service' => $ItemServiceName, 'order_cloth' => $ItemClothType, 'order_qty' => $Qty, 'order_price' => $ItemPrice);
				if($this->db->insert('order_temp', $order)===TRUE)		// using direct parameter
				{
					if($order2!='')
					{
						redirect('admin/customer_orders/update_order/'.$order2.'','refresh');
					}
					else
					{
						redirect('admin/customer_orders/add_order','refresh');
					}		
				}
			}
		
		}
		
		if($order1=='delete_item_order')
		{	
			?> <!--<script> alert('<?php echo $order2; ?>'); </script> -->
			<?php
			
			$this->db->where('order_id' , $order2);
            if($this->db->delete('order_temp')===TRUE)		// using direct parameter
			{
				if($order3!='')
				{
					redirect('admin/customer_orders/update_order/'.$order3.'','refresh');
				}
				else
				{
					redirect('admin/customer_orders/add_order','refresh');
				}		
			}	
		}
		
		if($order1=='delete_order')
		{	$this->db->where('auto_id' , $order2);
            if($this->db->delete('customer_order')===TRUE)		// using direct parameter
			{
			redirect('admin/customer_orders/invoice_list','refresh');
			}	
		}
		
		if($order1=='invoice_order')
		{				
			$Invoice['customer_data'] = $this->db->get('users');
			$Invoice['price_data'] = $this->db->get('price_list');
			$Invoice['laundry_service'] = $this->db->get('services');
			$Invoice['laundry_cloth'] = $this->db->get('cloths');
			
			$Invoice['order_data'] = $this->db->get_where('customer_order' , array('auto_id' => $order2) )->result();
			$this->load->view('admin/customer_invoice',$Invoice);
		}
			
		
		
	}
	
	// Invoice Pdf Controller --->
	
	function invoicepdf($invoiceid='')
	{
		//$this->load->library('pdf');
		$Invoice['customer_data'] = $this->db->get('users');
		$Invoice['price_data'] = $this->db->get('price_list');
		$Invoice['laundry_service'] = $this->db->get('services');
		$Invoice['laundry_cloth'] = $this->db->get('cloths');
		$Invoice['order_data'] = $this->db->get_where('customer_order' , array('auto_id' => $invoiceid) )->result();
		$this->load->view('admin/customer_full_invoice',$Invoice);
		//$this->pdf->load_view('admin/invoice_pdf',$Invoice);
		//$this->pdf->render();
		//$this->pdf->stream("invoice.pdf");
	}
	

	// Employee Controller = = >
	
	function emp_password()
	{
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->load->view('admin/emp_password','refresh');
	}
	
	
	function employee()
	{
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','employee');
		$data['empdata'] = $this->db->get('employee');
		$data['group_list'] = $this->db->get('mem_group');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('employee')->order_by('emp_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->emp_id;
		
		// Google Map Location
		
		$sys_map_pos = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_gmap;
		
		$config['center'] = $sys_map_pos;
		$config['zoom'] = '17';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $sys_map_pos;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'document.getElementById(\'custmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		
		///
		
		$data['sys_map_pos'] = $sys_map_pos;

		
		$this->load->view('admin/employee',$data);
	}
	
	function employee_crud($param1='', $param2='')
	{	if($param1=='new')
		{	$join_date=$this->input->post('join_date');
			$first_name=$this->input->post('first_name');
			$last_name=$this->input->post('last_name');
			$email_id=$this->input->post('email');
			$gender=$this->input->post('gender');
			$birth_date=$this->input->post('birth_date');
			$phone=$this->input->post('phone');
			$address=$this->input->post('address1');
			$zip=$this->input->post('zipcode');
			$password=base64_encode($this->input->post('password'));
			$status=$this->input->post('status');
			$design=$this->input->post('design');
			$group_id=$this->input->post('memberof');
			$emprole=$this->input->post('emp_role');
			$emp_map_pos=$this->input->post('empmap');
			
			$database_data = array('join_date' => $join_date, 'first_name' => $first_name, 'last_name' => $last_name, 'mobile' => $phone, 'email_id' => $email_id, 'emp_add1' => $address, 'emp_zip'=>$zip, 'password' => $password, 'status' => 'enable', 'designation' => $design,  'group_id'=> $group_id,'emp_role'=> $emprole,'emp_map_pos'=>$emp_map_pos );
			if($this->db->insert('employee', $database_data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/employee','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['employee_edit'] = $this->db->get_where('employee' , array('emp_id' => $param2) )->result();
			$query['group_list'] = $this->db->get('mem_group');
			
			
			// Google Map Location
			
			
			$emp_map_pos = $this->db->get_where('employee' , array('emp_id' =>$param2))->row()->emp_map_pos;
			
			if($emp_map_pos=="") { $emp_map_pos = $this->db->get_where('settings' , array('id' =>1))->row()->shop_gmap; $data['cust_map_pos']=$emp_map_pos;  }
			
			
			$config['center'] = $emp_map_pos;
			$config['zoom'] = '17';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $emp_map_pos;
			$marker['draggable'] = true;
			$marker['ondragend'] = 'document.getElementById(\'empmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
			$this->googlemaps->add_marker($marker);
			$query['mapemp'] = $this->googlemaps->create_map();
			
			$query['emp_map_pos'] = $emp_map_pos;
			
			

			////////// End Google Map Location	
			
			$this->load->view('admin/employee_update',$query);
		}
		
		
		if ($param1 == 'modify') 
		{  
            $data['join_date'] = $this->input->post('join_date');
            $data['first_name'] = $this->input->post('first_name');
            $data['last_name'] = $this->input->post('last_name');
            $data['email_id'] = $this->input->post('email');
            $data['mobile'] = $this->input->post('phone');
            $data['emp_add1'] = $this->input->post('address1');
            $data['emp_add2'] = $this->input->post('address2');
            $data['emp_city'] = $this->input->post('city');
            $data['emp_state'] = $this->input->post('state');
            $data['emp_zip'] = $this->input->post('zipcode');
			$NewPass=$this->input->post('password');
			if($NewPass!="") $data['password']= base64_encode($this->input->post('password'));
			$data['status'] = $this->input->post('status');
            $data['designation'] = $this->input->post('design');
            $data['group_id'] = $this->input->post('memberof');
            $data['emp_role'] = $this->input->post('emp_role');
            $data['emp_map_pos'] = $this->input->post('empmap');
			$this->db->where('emp_id' , $param2);
			
			if($this->db->update('employee' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/employee','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('emp_id' , $param2);
            if($this->db->delete('employee')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/employee','refresh');
			}	
		}
		
		if($param1=='password')
		{	$data['password'] = sha1($this->input->post('emp_password'));
			$this->db->where('emp_id' , $param2);
			
			if($this->db->update('employee' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('login/logout','refresh');
			}	
		}
		
	}
	
	// Cloth Controller ==>
	function cloth_type()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','garment');
		$this->session->set_userdata('submenu','gar_type');
		$this->db->order_by("id","desc");
		$data['cloth'] = $this->db->get('cloths');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('cloths')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;
		$this->load->view('admin/cloth',$data);
	}
	
	function cloth_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$cloth_type=$this->input->post('cloth_name');
			$cloth_type_lang=$this->input->post('cloth_name_lang');
			$no_of_qty=$this->input->post('no_of_qty');
			$cloth_code=$this->input->post('cloth_code');
			$data = array('cloth_type' => $cloth_type,'cloth_type_lang' => $cloth_type_lang,'no_of_qty' => $no_of_qty, 'cloth_code' => $cloth_code );
			if($this->db->insert('cloths', $data)===TRUE)		// using direct parameter
			{	$insertId=$this->db->insert_id();
				//move_uploaded_file($_FILES['garment_image']['tmp_name'], 'assets/stock/' . $insertId . '.png');
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/cloth_type','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['cloths_edit'] = $this->db->get_where('cloths' , array('id' => $param2) )->result();
			$this->load->view('admin/cloths_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['cloth_type']= $this->input->post('cloth_name');
		   $data['cloth_type_lang']= $this->input->post('cloth_name_lang');
		   $data['no_of_qty']= $this->input->post('no_of_qty');
            $data['cloth_code'] = $this->input->post('cloth_code');
			$this->db->where('id' , $param2);
			
			if($this->db->update('cloths' , $data)===TRUE)		// using direct parameter
			{	//move_uploaded_file($_FILES['garment_image']['tmp_name'], 'assets/stock/' . $param2 . '.png');
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/cloth_type','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('cloths')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('laundry_delete'); ?>"); </script>
			<?php
			redirect('admin/cloth_type','refresh');
			}	
		}
	}

	
	// Expeses Type Controller ==>
	
	function expenses_type()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','expensestype');
		$this->db->order_by("exps_id","desc");
		$data['expenstype'] = $this->db->get('expense_type');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('expense_type')->order_by('exps_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->exps_id;
		$this->load->view('admin/expenses_type',$data);
	}
	
	function expenses_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$expse_type=$this->input->post('expse_type');
			$expse_code=$this->input->post('expse_code');
			$data = array('exps_type' => $expse_type, 'exps_code' => $expse_code );
			if($this->db->insert('expense_type', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/expenses_type','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['exps_edit'] = $this->db->get_where('expense_type' , array('exps_id' => $param2) )->result();
			$this->load->view('admin/exps_type_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['exps_type']= $this->input->post('expse_type');
            $data['exps_code'] = $this->input->post('expse_code');
			$this->db->where('exps_id' , $param2);
			
			if($this->db->update('expense_type' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/expenses_type','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('exps_id' , $param2);
            if($this->db->delete('expense_type')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/expenses_type','refresh');
			}	
		}
	}

	// Services Controller ==>
	function laundry_services()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','services');
		$this->db->order_by("priority");
		$data['service'] = $this->db->get('services');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('services')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;
		$this->load->view('admin/services',$data);
	}
	
	function service_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$service_name=$this->input->post('service_name');
			$service_name_lang=$this->input->post('service_name_lang');
			//$service_unit=$this->input->post('service_unit');
			$show_hide=$this->input->post('active');
			$service_code=$this->input->post('service_code');
			$serviceid=$this->input->post('service_id');
			$data = array('service_name' => $service_name,'service_name_lang' => $service_name_lang,'service_code' => $service_code,'show_hide' => $show_hide );
			if($this->db->insert('services', $data)===TRUE)		// using direct parameter
			{	move_uploaded_file($_FILES['service_img']['tmp_name'], 'assets/stock/ser_' . $serviceid . '.png');
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/laundry_services','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$Serviice['service_edit'] = $this->db->get_where('services' , array('id' => $param2) )->result();
			$this->load->view('admin/service_update',$Serviice);
		}
		
		if ($param1 == 'modify') 
		{   $data['service_name']= $this->input->post('service_name');
		    $data['service_name_lang']= $this->input->post('service_name_lang');
		   //$data['service_unit']= $this->input->post('service_unit');
            $data['service_code'] = $this->input->post('service_code');
            $data['show_hide'] = $this->input->post('active');
            $data['priority'] = $this->input->post('priority');
			$this->db->where('id' , $param2);
			
			if($this->db->update('services' , $data)===TRUE)		// using direct parameter
			{	move_uploaded_file($_FILES['service_img']['tmp_name'], 'assets/stock/ser_' . $param2 . '.png');
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/laundry_services','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('services')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/laundry_services','refresh');
			}	
		}
	}
	
	// Category Controller ==>
	function laundry_category()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','category');
		$this->db->order_by("cat_id","desc");
		$data['category'] = $this->db->get('category');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('category')->order_by('cat_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->cat_id;
		$this->load->view('admin/category',$data);
	}
	
	function category_crud($param1='', $param2='')
	{	
		if($param1=='create')
		{	$category_name=$this->input->post('category_name');
			
			$show_hide=$this->input->post('active');
			$category_descr=$this->input->post('category_descr');
			
			$data = array('category_name' => $category_name,'category_descr' => $category_descr,'show_hide' => $show_hide );
			if($this->db->insert('category', $data)===TRUE)		// using direct parameter
			{	
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/laundry_category','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$Serviice['category_edit'] = $this->db->get_where('category' , array('cat_id' => $param2) )->result();
			$this->load->view('admin/category_update',$Serviice);
		}
		
		if ($param1 == 'modify') 
		{   $data['category_name']= $this->input->post('category_name');
		  	$data['show_hide'] = $this->input->post('active');
		  	$data['category_descr'] = $this->input->post('category_descr');
			$this->db->where('cat_id' , $param2);
			
			if($this->db->update('category' , $data)===TRUE)		// using direct parameter
			{	
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/laundry_category','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('cat_id' , $param2);
            if($this->db->delete('category')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/laundry_category','refresh');
			}	
		}
	}
	
	// Assing Cloth Service Prices --->
	
	function cloth_prices()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','pricelist');
		$this->db->order_by("id","desc");
		$data['price_data'] = $this->db->get('price_list');
		$this->db->order_by("priority","asc");
		$data['laundry_service'] = $this->db->get('services');
		$this->db->order_by("cloth_type","asc");
		$data['laundry_cloth'] = $this->db->get('cloths');
		$data['category_data'] = $this->db->get('category');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('price_list')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;
		$this->load->view('admin/price_list',$data);
	}
	
	function price_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$service_name=$this->input->post('service_name');
			$category_name=$this->input->post('category_name');
			$cloth_name=$this->input->post('cloth_name');
			$amount=$this->input->post('price');
			$service_unit=$this->input->post('service_unit');
			$shortcode=strtoupper($this->input->post('short_code'));
			$serviceid=$this->input->post('service_id');
			$data = array('service_id' => $service_name, 'category_id' => $category_name, 'cloth_id' => $cloth_name, 'price' => $amount, 'service_unit' => $service_unit, 'short_code' => $shortcode );
			if($this->db->insert('price_list', $data)===TRUE)		// using direct parameter
			{	
				$config['upload_path']   = 'assets/stock/'; 
		     	$config['allowed_types'] = 'jpg|jpeg|gif|png'; 
		     	$config['overwrite'] 	 = TRUE;
		     	$config['max_size']      = 150;
		     	$config['file_name']     = $serviceid.".png";
		     	
		     	$this->load->library('upload', $config);

		     	if ( !$this->upload->do_upload('service_img') && $_FILES['service_img']['tmp_name']!='' )
                {
                        $error = array('error' => $this->upload->display_errors());

                        ?>
						<!-- <script> alert('<?=$this->upload->display_errors()?>'); </script> -->
						<script> alert("only gif | jpg | png file allowed with maximum file size 150KB"); </script>
						<?php

						

						redirect('admin/cloth_prices','refresh');
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        ?>
						<script> alert("<?php echo lang('record_update'); ?>"); </script>
						<?php
						redirect('admin/cloth_prices','refresh');
                        
                }

			}
		}
		
		if($param1=='do_update')
		{	$query['laundry_service'] = $this->db->get('services');
			$query['laundry_category'] = $this->db->get('category');
			$query['laundry_cloth'] = $this->db->get('cloths');
			$query['pricelist_edit'] = $this->db->get_where('price_list' , array('id' => $param2) )->result();
			$this->load->view('admin/pricelist_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['service_id']= $this->input->post('service_name');
            $data['category_id'] = $this->input->post('category_name');
            $data['cloth_id'] = $this->input->post('cloth_name');
            $data['price'] = $this->input->post('price');
            $data['service_unit'] = $this->input->post('service_unit');
            $data['short_code'] = strtoupper($this->input->post('short_code'));
            $this->db->where('id' , $param2);
			
			if($this->db->update('price_list' , $data)===TRUE)		// using direct parameter
			{	
				$config['upload_path']   = 'assets/stock/'; 
		     	$config['allowed_types'] = 'jpg|jpeg|gif|png'; 
		     	$config['overwrite'] 	 = TRUE;
		     	$config['max_size']      = 150;
		     	$config['file_name']     = $param2.".png";
		     	
		     	$this->load->library('upload', $config);

		     	if ( !$this->upload->do_upload('service_img') && $_FILES['service_img']['tmp_name']!='' )
                {
                        $error = array('error' => $this->upload->display_errors());

                        ?>
						<!-- <script> alert('<?=$this->upload->display_errors()?>'); </script> -->
						<script> alert("only gif | jpg | png file allow with maximum file size 150KB"); </script>
						<?php

						

						redirect('admin/cloth_prices','refresh');
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        ?>
						<script> alert("<?php echo lang('record_update'); ?>"); </script>
						<?php
						redirect('admin/cloth_prices','refresh');
                        
                }

			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('price_list')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/cloth_prices','refresh');
			}	
		}
	}


	// Package Controller ==>

	function packages()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','packages');
		$this->db->order_by("pkg_id","desc");
		$data['package'] = $this->db->get('packages');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('packages')->order_by('pkg_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->pkg_id;
		$this->load->view('admin/packages',$data);
	}
	
	function pkg_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$category=$this->input->post('category');
			$pkg_name=strtoupper($this->input->post('pkg_name'));
			$usage_limit=$this->input->post('usage_limit');
			$pkg_unit=$this->input->post('pkg_unit');
			$pickup=$this->input->post('pickup');
			$duration=$this->input->post('duration');
			$amount=$this->input->post('amount');
			$description=$this->input->post('description');
			
			$data = array('category' => $category, 'pkg_name' => $pkg_name, 'usage_limit' => $usage_limit, 'pkg_unit' => $pkg_unit, 'pickup' => $pickup, 'duration' => $duration, 'amount' => $amount, 'description' => $description );
			if($this->db->insert('packages', $data)===TRUE)		// using direct parameter
			{	$insertId=$this->db->insert_id();
				//move_uploaded_file($_FILES['garment_image']['tmp_name'], 'assets/stock/' . $insertId . '.png');
			?>
			<script> alert(" Record Added Successfully"); </script>
			<?php
			redirect('admin/packages','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['packages_edit'] = $this->db->get_where('packages' , array('pkg_id' => $param2) )->result();
			$this->load->view('admin/package_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['category']= $this->input->post('category');
		   $data['pkg_name']= $this->input->post('pkg_name');
            $data['usage_limit'] = $this->input->post('usage_limit');
            $data['pkg_unit'] = $this->input->post('pkg_unit');
            $data['pickup'] = $this->input->post('pickup');
            $data['duration'] = $this->input->post('duration');
            $data['amount'] = $this->input->post('amount');
            $data['description'] = $this->input->post('description');
			$this->db->where('pkg_id' , $param2);
			
			if($this->db->update('packages' , $data)===TRUE)		// using direct parameter
			{	//move_uploaded_file($_FILES['garment_image']['tmp_name'], 'assets/stock/' . $param2 . '.png');
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
			redirect('admin/packages','refresh');
			}
		}
	}
	
	// Exepnsese List ----------->
	
	function expenses()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','job_order');
		$this->session->set_userdata('submenu','expenses');
		$data['expensetype'] = $this->db->get('expense_type');
		$data['store_list'] = $this->db->get('stores');
		$data['expenses'] = $this->db->get('expenses');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('expenses')->order_by('exp_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->exp_id;
		$this->load->view('admin/expenses_list',$data);
	}
	
	function expense_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$ExpDate=date('Y-m-d',strtotime($this->input->post('exp_date')));
			$PayeeName=$this->input->post('payee_name');
			$ExpType=$this->input->post('exp_type');
			$ExpStore=$this->input->post('laundry_store');
			$ExpAmt=$this->input->post('exp_amt');
			$ExpTaxable=$this->input->post('exp_amt_taxable');
			if($ExpTaxable=='yes')
			{
				$ExpAmt=($ExpAmt*10/100)+$ExpAmt;
			}	
			$ExpAmtPaidBy=$this->input->post('exp_amt_paid_by');
			$ExpChequeNo=$this->input->post('exp_cheque_no');
			$ExpChequeDate=$this->input->post('exp_cheque_date');
			$ExpRemark=$this->input->post('exp_remark');
			
			$data = array('exps_date' => $ExpDate, 'exp_payee_name' => $PayeeName, 'laundry_store' => $ExpStore,'exp_type' => $ExpType, 'exp_amt' => $ExpAmt, 'exp_taxable' => $ExpTaxable, 'exp_paidby' => $ExpAmtPaidBy, 'exp_chequeno' => $ExpChequeNo, 'exp_cheque_date' => $ExpChequeDate, 'exp_remarks' => $ExpRemark );
			if($this->db->insert('expenses', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/expenses','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	
			$query['expensetype'] = $this->db->get('expense_type');
			$query['store_list'] = $this->db->get('stores');
			$query['expenses_edit'] = $this->db->get_where('expenses' , array('exp_id' => $param2) )->result();
			$this->load->view('admin/expenses_edit',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['exps_date']= date('Y-m-d',strtotime($this->input->post('exp_date')));
            $data['exp_payee_name'] = $this->input->post('payee_name');
            $data['laundry_store'] = $this->input->post('laundry_store');
            $data['exp_type'] = $this->input->post('exp_type');
            $data['exp_amt'] = $this->input->post('exp_amt');
            $data['exp_paidby'] = $this->input->post('exp_amt_paid_by');
            $data['exp_chequeno'] = $this->input->post('exp_cheque_no');
            $data['exp_cheque_date'] = $this->input->post('exp_cheque_date');
            $data['exp_remarks'] = $this->input->post('exp_remark');
			$this->db->where('exp_id' , $param2);
			
			if($this->db->update('expenses' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/expenses','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('exp_id' , $param2);
            if($this->db->delete('expenses')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/expenses','refresh');
			}	
		}
	}
	
	// Taxes and Charges ==>
	function tax_charges()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','charges');
		$this->db->order_by("charge_id","desc");
		$data['tax_charges'] = $this->db->get_where('tax_charges' , array('coupon' =>'') );
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('tax_charges')->order_by('charge_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->charge_id;
		$this->load->view('admin/charges',$data);
	}
	
	function charge_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$charge_name=$this->input->post('charge_name');
			$charge_type=$this->input->post('charge_type');
			$charge_amt=$this->input->post('charge_value');
			$transaction=$this->input->post('transaction');
			$defaults=$this->input->post('defaults');
			//$coupon=$this->input->post('coupon');
			//$expire_date=date('Y-m-d',strtotime($this->input->post('expire_date')));
			$remarks=$this->input->post('charge_remarks');
			$data = array(	'charge_name' => $charge_name, 
							'charge_type' => $charge_type,
							'charge_amt' => $charge_amt,
							'transaction' => $transaction,
							//'coupon' => $coupon,
							//'expire_date' => $expire_date,
							'charge_remarks' => $remarks
							);
			if($this->db->insert('tax_charges', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/tax_charges','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['charges_edit'] = $this->db->get_where('tax_charges' , array('charge_id' => $param2) )->result();
			$this->load->view('admin/charges_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['charge_name']= $this->input->post('charge_name');
            $data['charge_type'] = $this->input->post('charge_type');
            $data['charge_amt'] = $this->input->post('charge_value');
            $data['transaction'] = $this->input->post('transaction');
            $data['defaults'] = $this->input->post('defaults');
            //$data['coupon'] = $this->input->post('coupon');
            //$data['expire_date'] = date('Y-m-d',strtotime($this->input->post('expire_date')));
            $data['charge_remarks'] = $this->input->post('charge_remarks');
			$this->db->where('charge_id' , $param2);
			
			if($this->db->update('tax_charges' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/tax_charges','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('charge_id' , $param2);
            if($this->db->delete('tax_charges')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/tax_charges','refresh');
			}	
		}
	}
	
		
	// PromoCode and Coupons ==>
	
	function promo_code()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','coupons');
		$this->db->order_by("charge_id","desc");
		$data['promo_code'] = $this->db->get_where('tax_charges' , array('coupon' =>'yes') );
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('tax_charges')->order_by('charge_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->charge_id;
		$this->load->view('admin/coupons',$data);
	}
	
	function promo_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$charge_name=$this->input->post('charge_name');
			$charge_type=$this->input->post('charge_type');
			$charge_amt=$this->input->post('charge_value');
			$transaction=$this->input->post('transaction');
			$coupon_id=$this->input->post('coupon_id');
			$coupon=$this->input->post('coupon');
			$expire_date=date('Y-m-d',strtotime($this->input->post('expire_date')));
			$remarks=$this->input->post('charge_remarks');
			$data = array(	'charge_name' => $charge_name, 
							'charge_type' => $charge_type,
							'charge_amt' => $charge_amt,
							'transaction' => '0',
							'coupon' => 'yes',
							'expire_date' => $expire_date,
							'charge_remarks' => $remarks
							);
			if($this->db->insert('tax_charges', $data)===TRUE)		// using direct parameter
			{	move_uploaded_file($_FILES['offer_img']['tmp_name'], 'assets/stock/offer_' . $param2.'.png');
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/promo_code','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['promocode_edit'] = $this->db->get_where('tax_charges' , array('charge_id' => $param2) )->result();
			$this->load->view('admin/coupons_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['charge_name']= $this->input->post('charge_name');
            $data['charge_type'] = $this->input->post('charge_type');
            $data['charge_amt'] = $this->input->post('charge_value');
            $data['transaction'] = '0';
            $data['coupon'] = 'yes';
            $data['expire_date'] = date('Y-m-d',strtotime($this->input->post('expire_date')));
            $data['charge_remarks'] = $this->input->post('charge_remarks');
			$this->db->where('charge_id' , $param2);
			
			if($this->db->update('tax_charges' , $data)===TRUE)		// using direct parameter
			{	move_uploaded_file($_FILES['offer_img']['tmp_name'], 'assets/stock/offer_' . $param2 . '.png');
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/promo_code','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('charge_id' , $param2);
            if($this->db->delete('tax_charges')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/promo_code','refresh');
			}	
		}
	}	
	
	
	
	// Order Report Controller --->
	
	function orderreport($report='',$report2='')
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','reports');
		
		if($report=='date_view')
		{	
			$this->session->set_userdata('submenu','daterep');
			
			  $Today=date('j-m-Y');
			  $FromDate =$Today;
			  $ToDate =$Today;
			  $data['fromdate']=$Today;
			  $data['todate']=$Today;
			
			$this->session->set_userdata('order_date','');
			$this->session->set_userdata('party_name','');
			
			$data['userdata'] = $this->db->get('users');
			
 			if($report2=='visible')
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				 }
			
			
			$this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
			
			$data['invoiceorder'] = $this->db->get('customer_order');
			
			$this->load->view('admin/reports_invoice_list',$data);
		}
		
		if($report=='month_view')
		{	
			$this->session->set_userdata('submenu','monthrep');
			
			  $Monthsel=date('m');
			  $data['mont']=$Monthsel;
			
			
			$this->session->set_userdata('order_date','');
			$this->session->set_userdata('party_name','');
			
			$data['userdata'] = $this->db->get('users');
			
			if(isset($_POST['month']))
			{	
			$Monthsel = $this->input->post('month');	
			$data['mont']=$Monthsel;
			}  
			
			
			$data['invoiceorder'] = $this->db->get_where('customer_order' , array('MONTH(pickup_date)' => $Monthsel) );

			$storeId=$this->session->userdata('store_id');
			if($storeId!=0) 
			{	$data['invoiceorder'] = $this->db->get_where('customer_order' , array('MONTH(pickup_date)' => $Monthsel, 'laundry_store'=>$storeId ));	
			}

			
			$this->load->view('admin/reports_invoice_month_list',$data);
		}
		
	}
	
	function income_report($report='',$report2='')
		{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','income');
			
						
				$Today=date('j-m-Y');
				$FromDate =$Today;
				$ToDate =$Today;
				$data['fromdate']=$Today;
				$data['todate']=$Today;
				
				
				 //$data['inward'] = $this->db->get('inward_stock');
				
				 if(isset($_POST['visible']))
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				 }
				
				$this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				
				//$this->db->where("amt_paidby != 'notpaid' OR order_status != 'done'");
				$this->db->where("amt_paidby != 'notpaid' ");
				$data['income'] = $this->db->get('customer_order');
				
				$this->load->view('admin/income_reports',$data);
			
		}
		
		function expenses_report($report='',$report2='')
		{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','expenses');
			
						
				$Today=date('j-m-Y');
				$FromDate =$Today;
				$ToDate =$Today;
				$data['fromdate']=$Today;
				$data['todate']=$Today;
				
				
				 //$data['inward'] = $this->db->get('inward_stock');
				
				 if(isset($_POST['visible']))
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				 }
				
				$this->db->where('exps_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				
				$data['expenses'] = $this->db->get('expenses');
				
				$this->load->view('admin/expenses_reports',$data);
			
		}
		
		
		function profitloss_report($report='',$report2='')
		{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','profitloss');
			
						
				$Today=date('j-m-Y');
				$FromDate =$Today;
				$ToDate =$Today;
				$data['fromdate']=$Today;
				$data['todate']=$Today;
				
				
				 //$data['inward'] = $this->db->get('inward_stock');
				
				 if(isset($_POST['visible']))
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				 }
			$this->load->view('admin/profit_loss_reports',$data);
		}

		function outstand_report()
		{
			if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','outstand');
			
						
				$Today=date('j-m-Y');
				$FromDate =$Today;
				$ToDate =$Today;
				$data['fromdate']=$Today;
				$data['todate']=$Today;
				
				
				 //$data['inward'] = $this->db->get('inward_stock');
				
				 if(isset($_POST['visible']))
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				 }
				// $this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				
				//$this->db->where("amt_paidby != 'notpaid' OR order_status != 'done'");
				$this->db->select();
				$this->db->select_sum('total_paid');
				$this->db->select_sum('amt_paid');
				// $this->db->where("amt_paidby = 'notpaid' ");
				$this->db->group_by('customer_name');
				$data['income'] = $this->db->get('customer_order');
				
				$data['custData'] = $this->db->get('users');



				$storeId=$this->session->userdata('store_id');
					if($storeId!=0) 
					{	
						// $this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				
						//$this->db->where("amt_paidby != 'notpaid' OR order_status != 'done'");
						$this->db->where("amt_paidby != 'notpaid' ");
						$this->db->group_by('customer_name');
						$data['income'] = $this->db->get_where('customer_order',array('laundry_store'=>$storeId));	
					}
						
				$this->load->view('admin/reports_outstanding',$data);	
		} 

		function daily_collection_report()
		{
			if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','dailycollect');
			
						
				$Today=date('j-m-Y');
				$FromDate =$Today;
				$ToDate =$Today;
				$data['fromdate']=$Today;
				$data['todate']=$Today;
				$SelectDriver=$this->input->post('driver');
				$data['driver']=$SelectDriver;
				
				$data['driver_list']=$this->db->get_where('employee', array('emp_role'=>'enable'))->result();		
				
				 if(isset($_POST['visible']))
				 {	
				  $FromDate = $this->input->post('from_date');	
				  $ToDate = $this->input->post('to_date');	
				  $data['fromdate']=$FromDate;
				  $data['todate']=$ToDate;
				  }
				
				$this->db->where('paid_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				$this->db->or_where('order_status','delivered')->where('amt_paidby','notpaid')->where('delivery_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
				
				if($SelectDriver!='all') { $this->db->where('payment_collect',$SelectDriver); }
				// $this->db->select();
				// $this->db->select_sum('total_paid');
				// $this->db->select_sum('amt_paid');
				// // $this->db->group_by('customer_name');
				$this->db->order_by('payment_collect desc');
				// $this->db->where('amt_paid!=',0);
				$data['collection'] = $this->db->get('customer_order');

				$storeId=$this->session->userdata('store_id');
					if($storeId!=0) 
					{	
						$data['collection'] = $this->db->get_where('customer_order',array('laundry_store'=>$storeId));	
					}
						
				$this->load->view('admin/reports_daily_collection',$data);	
		}

		function daily_credit_report()
		{
			if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','dailycredit');
			
			  $Today=date('j-m-Y');
			  $FromDate =$Today;
			  $ToDate =$Today;
			  $data['fromdate']=$Today;
			  $data['todate']=$Today;
			
			$this->session->set_userdata('order_date','');
			$this->session->set_userdata('party_name','');
			
			$data['userdata'] = $this->db->get('users');
			
			if(isset($_POST['visible']))
			 {
			  $FromDate = $this->input->post('from_date');	
			  $ToDate = $this->input->post('to_date');	
			  $data['fromdate']=$FromDate;
			  $data['todate']=$ToDate;
			 }
			
			$this->db->select();
			$this->db->select_sum('total_paid');
			$this->db->group_by('order_date');
			$this->db->where('order_date BETWEEN "'. date('Y-m-d', strtotime($FromDate)). '" and "'. date('Y-m-d', strtotime($ToDate)).'"');
			
			$data['invoiceorder'] = $this->db->get('customer_order');
			
			$this->load->view('admin/reports_daily_credit',$data);
		}

		function monthly_credit_report()
		{
			if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
			$this->session->set_userdata('menu','reports');
			$this->session->set_userdata('submenu','monthlycredit');
			
			
			$this->db->select();
			$this->db->select_sum('total_paid');
			$this->db->group_by('MONTH(order_date)');
			
			$data['invoiceorder'] = $this->db->get('customer_order');
			
			$this->load->view('admin/reports_monthly_credit',$data);
		}
		
	
	
	// System Settings Controller --->
	
	function systemset()
	{	//if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','sysset');
		$sdata['sysdata'] = $this->db->get('settings');
		$sdata['world_curr'] = $this->db->get('currencies');
		$sdata['world_lang'] = $this->db->get('world_language');
		//$sdata['store_list'] = $this->db->get_where('stores' , array('store_main' =>'yes'))->result();
				
		// Google Map Location
		
		$sys_map_pos = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_gmap;
		
		$config['center'] = $sys_map_pos;
		$config['zoom'] = '17';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $sys_map_pos;
		$marker['draggable'] = true;
		//$marker['ondragend'] = 'alert(\'Please Copy and Paste into Position Box : \' + event.latLng.lat() + \', \' + event.latLng.lng()); ';
		$marker['ondragend'] = 'document.getElementById(\'shop_gmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
		$this->googlemaps->add_marker($marker);
		$sdata['sysmap'] = $this->googlemaps->create_map();
				
		$this->load->view('admin/system_settings',$sdata);
		
	}
	
	
	function systemset_update()
	{	$id=1;
		$syst['shop_name']= htmlentities($this->input->post('shop_name'));
		
		$syst['shop_add1'] = htmlentities($this->input->post('address1'));
		$syst['shop_add2'] = htmlentities($this->input->post('address2'));
		$syst['shop_city'] = htmlentities($this->input->post('city'));
		$syst['shop_state'] = htmlentities($this->input->post('state'));
		$syst['shop_zip'] = htmlentities($this->input->post('zipcode'));
		
		$syst['shop_phone'] = htmlentities($this->input->post('shop_phone'));
		$syst['shop_mobile'] = htmlentities($this->input->post('shop_mobile'));
		$syst['shop_email'] = htmlentities($this->input->post('shop_email'));
		
		$syst['shop_gmap'] = $this->input->post('shop_gmap');
		$syst['sys_timezone'] = $this->input->post('timezone');
		$syst['sys_lang'] = $this->input->post('sys_lang');
		$syst['sys_currency'] = $this->input->post('sys_cur');
		$syst['sys_currency_show'] = $this->input->post('sys_curr_show');

		$terms=$this->input->post('term_condition');
		$syst['terms']=htmlentities($terms, ENT_QUOTES, 'UTF-8');

		
		if($this->input->post('shop_gmap')!="")
		{
		$this->db->where('id' , $id);
			
			if($this->db->update('settings' , $syst)===TRUE)		// using direct parameter
			{	 move_uploaded_file($_FILES['shop_logo']['tmp_name'], 'assets/images/' . 'logo' . '.png');
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			$this->session->set_userdata('site_lang', $this->input->post('sys_lang'));
			redirect('admin/systemset','refresh');
			}
		}	
		else
		{
		    
		?>
			<script> alert("<?php echo lang('wentwrong'); ?>"); </script>
			<?php
			redirect('admin/systemset','refresh');
		}
	}
	
	// Bulk (SMS, Email) Settings Controller --->
	
	function bulk_sms_email()
	{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','bulksms');
		$bulk['bulkmsg'] = $this->db->get('bulk_messge');
		$this->load->view('admin/bulk_sms_email',$bulk);
		
	}
	
	function bulk_sms_email_update()
	{	
		$id=1;
		$bulkset['protocol']= $this->input->post('smtp_protocol');
		$bulkset['smtp_host'] = $this->input->post('smtp_host');
		$bulkset['smtp_port'] = $this->input->post('smtp_port');
		$bulkset['smtp_user'] = $this->input->post('smtp_user');
		$bulkset['smtp_pass'] = $this->input->post('smtp_pass');
		$bulkset['mailtype'] = $this->input->post('mailtype');
		$bulkset['charset'] = $this->input->post('charset');
		$bulkset['limit'] = $this->input->post('limit');
				
		$this->db->where('id' , $id);
			
			if($this->db->update('bulk_messge' , $bulkset)===TRUE)		// using direct parameter
			{	 
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/bulk_sms_email','refresh');
			}
		
		
	}
	
		
	// Message (SMS, Email) Controller --->
	
	function sms_email()
	{	
		//$sdata['sysdata'] = $this->db->get('settings');
		$smsdata['userdata'] = $this->db->get('users');
		$this->load->view('admin/sms_email_form',$smsdata);
		
	}
	
	function sms_email_send()
	{	
		//Load email library
		$this->load->library('email');
		//$this->load->library('encrypt');

		//SMTP & mail configuration
		/*
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'redplanetbulk@gmail.com',			//your gmail account with on less security
			'smtp_pass' => 'demo',						// your gmail password
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		); */
		
		$bulkemail = $this->db->get_where('bulk_messge' , array('id' => 1) );
		foreach($bulkemail->result() as $bulkrow)
		{	$fromuser=$bulkrow->smtp_user;
			$config = array(
			'protocol'  => $bulkrow->protocol,
			'smtp_host' => $bulkrow->smtp_host,
			'smtp_port' => $bulkrow->smtp_port,
			'smtp_user' => $bulkrow->smtp_user,			//your gmail account with on less security
			'smtp_pass' => $bulkrow->smtp_pass,						// your gmail password
			'mailtype'  => $bulkrow->mailtype,
			'charset'   => $bulkrow->charset
			);
		}
		
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		//Email content
		 $CustName=$this->input->post('cust_name');
		 $From=$this->input->post('email');
		 $Subject=$this->input->post('subject');
		 $Message=$this->input->post('send_message');
		
		 
	
		$this->email->to($From);
		$this->email->from($fromuser,'Red Planet Computers');
		$this->email->subject($Subject);
		$this->email->message($Message);
		//Send email
		$this->email->send();
		
		?>
			<script> alert("Email Send Successfully"); </script>
			<?php
			if($this->input->post('enquiry')=='enquiry')
			{ redirect('http://localhost','refresh');
			}
			else
			{	
			redirect('admin/customer_orders/invoice_list','refresh');
			}
		
	}
	
	// Admin Profile Controller --->
	
	function profile()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','adminprofile');
		$data['admindata'] = $this->db->get('admin');
		$this->load->view('admin/admin_profile',$data);
		
	}
	
	function edit_profile($id="")
	{	
		$data['admindata'] = $this->db->get('admin');
		$this->load->view('admin/edit_profile',$data);
		
	}
	
	function update_profile($id="")
	{	
			$admin['admin_name']= $this->input->post('full_name');
            $admin['mobile'] = $this->input->post('mobile');
            $admin['email_id'] = $this->input->post('email');
            //$admin['username'] = $this->input->post('username');
            $NewPass=$this->input->post('new_passwd');			//chk password is blank or not
			
			if($NewPass!="")
			{
			  $admin['password'] = sha1($this->input->post('new_passwd'));
			}	
           
            $this->db->where('id' , $id);
			
			if($this->db->update('admin' , $admin)===TRUE)		// using direct parameter
			{
			?>
			<script> confirm("<?php echo lang('Update_Info'); ?>"); </script>
			<?php
			redirect('login/logout','refresh');
			}

	}
	
	// Group Controller ==>
	
	function groups()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','groupusers');
		$this->session->set_userdata('submenu','groups');
		
		$this->session->unset_userdata('GroupId');
		$this->session->unset_userdata('GroupPerm');
		
		$group['groups'] = $this->db->get('mem_group');
		$this->load->view('admin/group',$group);
	}
	
	
	function group_add()
	{	
		$group['last_id']=0;	
		$result=$this->db->select('*')->from('mem_group')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$group['last_id'] = $result[0]->id;
		
		$this->load->view('admin/group_add',$group);
	}
	
	function group_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$group_name=$this->input->post('group_name');
			$group_status=$this->input->post('status');
			$group_permission=serialize($this->input->post('grp_perm'));
			
			$data = array('group_name' => $group_name , 'group_status' => $group_status, 'group_permission' => $group_permission);
			if($this->db->insert('mem_group', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/groups','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['group_edit'] = $this->db->get_where('mem_group' , array('id' => $param2) )->result();
			$this->load->view('admin/group_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['group_name']= $this->input->post('group_name');
		    $data['group_descr']= $this->input->post('group_descr');
            $data['group_status'] = $this->input->post('m_status');
			$this->db->where('id' , $param2);
			
			if($this->db->update('mem_group' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/groups','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('mem_group')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/groups','refresh');
			}	
		}
	}
	
	// Group Permission 
	function group_permission()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','groupusers');
		$this->session->set_userdata('submenu','permission');
		
		
		$group['groups'] = $this->db->get('mem_group');
		$group['group_perms'] =""; $group['group_id'] =""; 
		$this->load->view('admin/group_permission',$group);
	}
	
	function group_permission_crud($param1="", $param2="")
	{	
		if($param1=='view')
		{ //$group['groups'] = $this->db->get('mem_group');
		  
		  $Group_ID=$this->input->post('grp_id');
		  
		  $this->session->set_userdata('GroupId',$Group_ID);
		  $this->session->set_userdata('GroupPerm',$param1);
		  // $group['group_perms'] =$param1;
		  //$this->load->view('admin/group_permission',$group);
		}	

		if($param1=='update')
		{   $data['group_permission']=serialize($this->input->post('grp_perm'));
            $this->db->where('id' , $param2);
			
			if($this->db->update('mem_group' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/groups','refresh');
			}
		}	
	}
	
	function sms_logs()
	{	//if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->db->order_by("sms_id","desc");
		$msg_data['smslogsdata'] = $this->db->get('sms_logs');

		$this->db->order_by("email_id","desc");
		$msg_data['emaillogsdata'] = $this->db->get('email_logs');

		$this->load->view('admin/sms_logs',$msg_data);

	}
	

	// Wallet Secton Start

	function wallet_history($custId='')
	{	
		$wallet['custId']=$custId;
		$this->load->view('admin/wallet_history',$wallet);
	}

	function wallte_crud($param1='', $param2='')
	{
		if($param1=='add')
		{
			$data = array(
					'customer_id' => $param2,
					'payment_amt' => $this->input->post('wallet_amount'),
					'payment_date' => date('Y-m-d'), 
					'credit_debit' => 'credit'
					);
			if($this->db->insert('wallet_history', $data)===TRUE)		// using direct parameter
			{	
				$InsertId=$this->db->insert_id();
				$WalletInvoice='WAL00'.$InsertId;
				
				$wdata['payment_trans_id']=$WalletInvoice;
				$this->db->where('wallet_id' , $this->db->insert_id());
				if($this->db->update('wallet_history' , $wdata)===TRUE) {}

			?>
			<script> alert("Amount In Wallet Added Successfully"); </script>
			<?php
			redirect('pos','refresh');
			}	

		}

		if($param1=='delete')
		{	$this->db->where('wallet_id' , $param2);
            if($this->db->delete('wallet_history')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('pos','refresh');
			}	
		}
	}	// Wallet Section END

	// Credit Section START
	function credit_history($custId='')
	{
		$credit['custId']=$custId;
		$this->load->view('admin/credit_history',$credit);	
	}

	function credit_limit($custId='')
	{
	 	$credit_data['credit_limit']=$this->input->post('credit_limit');
        $this->db->where('id' , $custId);
		
		if($this->db->update('users' , $credit_data)===TRUE)		// using direct parameter
		{
		?>
		<script> alert("<?php echo lang('record_update'); ?>"); </script>
		<?php
		redirect('pos','refresh');
		}
	}

	function credit_crud($param1='', $param2='')
	{
		if($param1=='add')
		{
			$data = array(
						'customer_id' => $param2,
						'credit_trans_amt' => $this->input->post('credit_amount'),
						'credit_trans_date' => date('Y-m-d'), 
						'credit_debit' => 'credit'
						);
			if($this->db->insert('credit_history', $data)===TRUE)		// using direct parameter
			{	
				$InsertId=$this->db->insert_id();
				$CreditInvoice='CRE0'.$InsertId;
				
				$cdata['credit_trans_id']=$CreditInvoice;
				$this->db->where('credit_id' , $this->db->insert_id());
				if($this->db->update('credit_history' , $cdata)===TRUE) {}

			?>
			<script> alert("Payment Successfully"); </script>
			<?php
			redirect('pos','refresh');
			}
		}

		if($param1=='delete')
		{	$this->db->where('credit_id' , $param2);
            if($this->db->delete('credit_history')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('pos','refresh');
			}	
		}


	}			// Credit Section END
	
	
    function banner()
	{   if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
	
		$this->session->set_userdata('menu','banners');
		$this->session->set_userdata('submenu','banner_list');
		$banner['date']=date('Y-m-d');
		$this->db->order_by('id', 'desc');if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$banner['bannerList']=$this->db->get('banners');
		$this->load->view('admin/banners',$banner);
	}

	function banner_crud($param1='', $param2='')
	{
		if($param1=='create')
		{
			
			$banner_data = array(
						  'banner_name'  => $this->input->post('banner_name'),
						  'banner_descr' =>$this->input->post('banner_descr'),
						);

			if($this->db->insert('banners', $banner_data)===TRUE)		// using direct parameter
			{	
				$bannerid=$this->db->insert_id();
				$config['upload_path']   = 'assets/banner/'; 
		     	$config['allowed_types'] = 'jpg|jpeg|gif|png'; 
		     	$config['overwrite'] 	 = TRUE;
		     	$config['file_name']     = $bannerid.".png";
		  		// $config['max_width'] = '1024';
				// $config['max_height'] = '768';
				// $config['min_width'] = '1024';
				// $config['min_height'] = '768';
		     	
		     	$this->load->library('upload', $config);

		     	if ( !$this->upload->do_upload('banner_img') && $_FILES['banner_img']['tmp_name']!='' )
                {
                        $this->db->where('id' , $bannerid);
            			if($this->db->delete('banners')===TRUE)	 {} // if fail upload image

                        $error = array('error' => $this->upload->display_errors());

                        ?>
						<!-- <script> alert('<?=$this->upload->display_errors()?>'); </script> -->
						<script> alert("only gif | jpg | png file allowed"); </script>
						<?php

						

						redirect('admin/banner','refresh');
                }
                else
                {
                        // $data = array('upload_data' => $this->upload->data());
                        ?>
						<script> alert("<?php echo lang('record_save'); ?>"); </script>
						<?php
						redirect('admin/banner','refresh');
                        
                }

			}

		}

		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('banners')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/banner','refresh');
			}	
		}	
	}

	// barcode scanning invoice 

	function fetch_barcode_data()		// searching fetch barcode scan data
	{	$output='error';		
		$search=strtoupper($this->input->post('query'));
		$ChkInvoiceNo=$this->db->get_where('customer_order',array('invoice_no'=>$search))->result();
		$CountRow=count($ChkInvoiceNo);
		if($CountRow>0)
		{	$TransDate=date('Y-m-d');
			$scan_barcode_data=array('trans_date' => $TransDate,'invoice_no' => $search );
			if($this->db->insert('barcode_data', $scan_barcode_data)===TRUE) { echo "success"; }
		}
		else
		{
			echo 'error';
		}	

	}


	function barcode_delete($param1='')
	{
		$this->db->where('bar_id' , $param1);
        if($this->db->delete('barcode_data')===TRUE)		// using direct parameter
		{
		redirect('welcome','refresh');
		}

	}


	function update_barcode_all()
	{
		$invoice_no=$this->input->post('invoice_no');
		$order_status=$this->input->post('order_status');
		$driver=$this->input->post('driver');
		
		// print_r($order_status);	
			
		$total=$this->input->post('no_of_rec');
								
			for($i=0; $i < $total; $i++) 
			{	
				//$data['order_date']= date('Y-m-d',strtotime($order_date[$i]));
				//$data['delivery_date']= date('Y-m-d',strtotime($due_date[$i]));
				
				$data['order_status'] = $order_status[$i];
				if($order_status[$i]=='pickup') { $data['pickup_by'] = $driver[$i]; $data['delivery_by'] =''; } 
				if($order_status[$i]=='out_for_delivery') $data['delivery_by'] = $driver[$i];
				
				//$data['amt_paidby']=$paidby[$i];
				// $data['pickup_by'] = $pickup[$i];
				
				
				//$data['delivery_date'] = "";	
				//if ($due_date[$i]!="") { $data['delivery_date']= date('Y-m-d',strtotime($due_date[$i])); }
				
				$this->db->where('invoice_no' , $invoice_no[$i]);
				$this->db->update('customer_order' , $data);
			}	
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			$this->db->empty_table('barcode_data');
			$this->db->query('ALTER TABLE barcode_data AUTO_INCREMENT 1');
			redirect('admin/customer_orders/invoice_list','refresh');
	}
	
	
	// End Barcode Scanning Data


	function map_view($lat='', $lng='')
	{
		echo '<center> <iframe width="550" 
			  height="400" 
			  frameborder="0" 
			  scrolling="no" 
			  marginheight="0" 
			  marginwidth="0"  
			  src = "https://maps.google.com/maps?q='.$lat.','.$lng.'&hl=es;z=10&amp;output=embed">
			  </iframe> </center>';

	}

	// function send_whatsapp()
	// {
	// 	// print_r($_POST['chk']);

	// 	$custList=$_POST['chk'];
		
	// 	$length=sizeof($_POST['chk']);

	// 	for($i=0;$i<$length;$i++)
	// 	{	
		 
	// 		$custrowid=$custList[$i];
	// 		$customer_name=$this->db->get_where('users',array('id' => $custrowid))->row()->first_name;
	// 		$customer_mobile=$this->db->get_where('users',array('id' => $custrowid))->row()->mobile;
	// 		$customer_email=$this->db->get_where('users',array('id' => $custrowid))->row()->email_id;
	// 		$customer_store=$this->db->get_where('users',array('id' => $custrowid))->row()->laundry_store;

	// 		$storeTaxable=$this->db->get_where('stores' , array('id' =>$customer_store))->row()->store_taxable;


	// 		/* Outstanding AMount */
	// 			$this->db->select('*');
	// 			$this->db->select_sum('total_paid');
	// 			$this->db->where("customer_id",$custrowid);
	// 			$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

	// 			$this->db->select();
	// 			$this->db->select_sum('amt_paid');
	// 			$this->db->where("customer_id",$custrowid);
	// 			$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

	// 			$OutStandAmount=$TotalAmount-$PaidAmount;

	// 			if($storeTaxable=='yes')
	// 			{
	// 				$vatAmt=$TotalAmount*5/100;
	// 				$OutStandAmount=$OutStandAmount+$vatAmt;
	// 			}
	// 			$OutStandAmount=sprintf('%0.3f',$OutStandAmount);	
	// 		/* End Outstand Amount */

	// 		$message=nl2br("Hi {$customer_name}, Please pay the outstanding balance {$OutStandAmount} online or visit branch, \r\n Please download our app to schedule pick up, Track your order, View your order history, Make payments online. \r\n Thank you for choosing Al hayat laundry.\r\n");

			
	// 		$this->bulk_message->bulk_whatsapp($customer_mobile,$message);
	// 		redirect('admin/outstand_report','refresh');
		

	// 	}
	// }

	// function send_email()
	// {
		
	// 	$message_for=$this->uri->segment(3);

	// 	if($message_for=="outstanding")
	// 	{	
	// 		$custList=$_POST['chk'];
	// 		$length=sizeof($_POST['chk']);

	// 		for($i=0;$i<$length;$i++)
	// 		{	
	// 			$custrowid=$custList[$i];
				
	// 			$result=$this->bulk_message->message_cust_data('',$custrowid);			// get customer details 

	// 			$customer_name=$result['customer_name'];
	// 			$customer_mobile=$result['customer_mobile'];
	// 			$customer_email=$result['customer_email'];
	// 			$customer_outstand_amount=$result['customer_outstand_amount'];
				
	// 			$message=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_body;
	// 			$subject=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_title;

	// 			$message=str_replace(
	// 			array("CUSTOMER_NAME","OUTSTAND_AMT"),
	// 			array($customer_name, $customer_outstand_amount), $message);

	// 			echo $message;

	// 			// $this->bulk_message->bulk_email($customer_email,$subject,$message);
	// 			// redirect('admin/outstand_report','refresh');
	// 		}

	// 	}
	// 	else
	// 	{
	// 			$invoice_no=$this->uri->segment(4);
	// 			$custrowid=$this->db->get_where('customer_order', array('invoice_no'=>$invoice_no))->row()->customer_id;

	// 			$result=$this->bulk_message->message_cust_data($invoice_no,$custrowid);			// get customers order details 

	// 			$customer_name=$result['customer_name'];
	// 			$customer_mobile=$result['customer_mobile'];
	// 			$customer_email=$result['customer_email'];
	// 			$customer_outstand_amount=$result['customer_outstand_amount'];
				
	// 			$message=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_body;
	// 			$subject=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_title;

	// 			$message=str_replace(
	// 			array("CUSTOMER_NAME","INVOICE","INV_AMT","OUTSTAND_AMT"),
	// 			array($customer_name, $customer_invoice, $customer_invoice_amt, $customer_outstand_amount), $message);

	// 			echo $message;
				
	// 			// $this->bulk_message->bulk_email($customer_email,$subject,$message);
	// 			// redirect('admin/outstand_report','refresh');
	// 	}	
	  		
		
	// }


	// Message Template Controller ==>
	function message_template()
	{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','master');
		$this->session->set_userdata('submenu','messagetemplate');
		$this->db->order_by("msg_id");
		$data['message_template'] = $this->db->get('message_template');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('message_template')->order_by('msg_id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->msg_id;
		$this->load->view('admin/message_template',$data);
	}

	function message_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$message_for=$this->input->post('message_for');
			$msg_title=$this->input->post('msg_title');
			$text=$this->input->post('msg_body');
			$msg_body=nl2br(htmlentities($text, ENT_QUOTES, 'UTF-8')); 
			$active=$this->input->post('active');
			$data = array('message_for' => $message_for,'msg_title' => $msg_title,'msg_body' => $msg_body,'active' => $active );
			if($this->db->insert('message_template', $data)===TRUE)		// using direct parameter
			{	
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/message_template','refresh');
			}	
		}

		if($param1=='do_update')
		{	$data['message_temp_edit'] = $this->db->get_where('message_template' , array('msg_id' => $param2) )->result();
			$this->load->view('admin/message_template_edit',$data);
		}
		
		if ($param1 == 'modify') 
		{   $data['msg_title']= $this->input->post('msg_title');
		    $data['msg_body']= $this->input->post('msg_body');
		    $data['active'] = $this->input->post('active');
        	$this->db->where('msg_id' , $param2);
			
			if($this->db->update('message_template' , $data)===TRUE)		// using direct parameter
			{	
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
			redirect('admin/message_template','refresh');
			}
		}

		
		if($param1=='delete')
		{	$this->db->where('msg_id' , $param2);
            if($this->db->delete('message_template')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/message_template','refresh');
			}	
		}
	}

	function outstanding_list()					/// old customers outstanding data
	{
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','job_order');
		$this->session->set_userdata('submenu','outstanding');
		$data['usersData'] = $this->db->get('users');
		$data['outstandData'] = $this->db->get('outstand_history');
		$this->load->view('admin/outstanding_list',$data);
	}

	function outstand_crud($param1='', $param2='')
	{
		if($param1=='create')
		{	$trans_date=date('Y-m-d',strtotime($this->input->post('trans_date')));
			$customer_id=$this->input->post('cust_id');
			$outstand_amt=$this->input->post('outstand_amt');
			$outstand_remarks=$this->input->post('out_remark');

			$data = array('trans_date' => $trans_date,'customer_id' => $customer_id,'outstand_amt' => $outstand_amt,'outstand_remarks' => $outstand_remarks );

			if($this->db->insert('outstand_history', $data)===TRUE)		// using direct parameter
			{	
			?>
			<script> alert("<?php echo lang('record_save'); ?>"); </script>
			<?php
			redirect('admin/outstanding_list','refresh');
			}	
		}

		if($param1=='do_update')
		{	$data['outstand_edit'] = $this->db->get_where('users' , array('id' => $param2) )->result();
			$this->load->view('admin/cust_outstand_update',$data);
		}
		
		if ($param1 == 'modify') 
		{   $data['address1']= $this->input->post('address1');
		    $data['mobile']= $this->input->post('mobile');
		    $data['phone'] = $this->input->post('phone');
            $data['outstand_amt'] = $this->input->post('outstand_amt');
            $data['outstand_remarks'] = $this->input->post('outstand_remarks');
			$this->db->where('id' , $param2);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{	
				redirect('admin/outstanding_list','refresh');
			}
		}

		
		if($param1=='delete')
		{	$this->db->where('outstand_id' , $param2);
            if($this->db->delete('outstand_history')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('admin/outstanding_list','refresh');
			}	
		}
	}

	function online_payment_list()
	{
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','reports');
		$this->session->set_userdata('submenu','online_payment');
		$data['onlinePaymentData'] = $this->db->group_by('invoice_no')->order_by('pay_id','desc')->get('online_payment_details');
		$this->load->view('admin/online_payment_list',$data);
	}

	function outstand_message()
	{
		$custList=$_POST['chk'];
		$length=sizeof($_POST['chk']);

		for($i=0;$i<$length;$i++)
		{	
			$custrowid=$custList[$i];
			
			$this->bulk_message->send_message('outstanding','na',$custrowid);
	 		
	 		// redirect('admin/outstand_report','refresh');
		}	
	}

	function test_it()
	{
		$customer_name = "ajitraj";
		$invoice = "AHL34";
		$outstand="45.000";

		$message_for='new_order';
		
		$message=$this->db->get_where('message_template',array('message_for'=>$message_for))->row()->msg_body;

		$message=str_replace(
			array("CUSTOMER_NAME", "INVOICE","OUTSTANDING"),
			array($customer_name, $invoice, $outstand), $message);

		echo $message;


	}

		
}				// main admin 