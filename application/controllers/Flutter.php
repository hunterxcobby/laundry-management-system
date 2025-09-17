<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flutter extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers / 8767228990
	 *	date		: 29 Mar, 2022
	 *	Laundry Management Application / Al Hayat Laundry UAE
	 *	info@redplanetcomputers.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
      	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
        header('Content-Type: application/json');
        date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
        $this->load->model('bulk_message');
		
    }
	
	public function index()
	{	echo "welcome to flutter";
		$data['mobile_login_status']='enable';
		$this->db->update('users', $data, array('mobile' => '918767228990'));
				
		// echo rand(1000,9999);
	}


	//// START CUSTOMER CONTROLLER >>>>>>>>>>>>>>> ////

	// Customer FLutter Controller  // Dt.23062022

	function chkCustomerMobile()
	{
		
		// $custMobile='918108702999';
		
		// if($custMobile!=8888) {
		// $custMobile=$this->input->post('customer_mobile');
		// $custMobile=str_replace(' ', '', $custMobile);
		// $custMobile=str_replace(' ', '', $custMobile);
		// $chk_mobile=$this->db->query("SELECT * FROM users WHERE REPLACE(`mobile`,' ','')=$custMobile LIMIT 1");
		
		$custMobile=$this->input->post('customer_mobile');	
		
		$chk_mobile=$this->db->get_where('users',array('mobile'=>$custMobile));
		
		$count=$chk_mobile->num_rows();
		
		if($count==1)
		{					
				$data['mobile_login_status']='enable';
				$this->db->update('users', $data, array('mobile' => $custMobile));
				
				$loginCustomerId=$chk_mobile->row()->id;
				$loginCustomerFirstName=$chk_mobile->row()->first_name;
				$loginCustomerLastName=$chk_mobile->row()->last_name;
				$loginCustomerAddress=$chk_mobile->row()->address1;
				
				
				
				$output['login_cust_id']=$loginCustomerId;
				$output['login_cust_firstname']=$loginCustomerFirstName;
				$output['login_cust_lastname']=$loginCustomerLastName;
				$output['login_cust_address']=$loginCustomerAddress;
				$output['login_cust_mobile']=$custMobile;
				$output['msg']="exist_cust";
		}
		else
		{	
			$genOTP=rand(1000,9999);	// send OTP whatapp sms for mobile
			
			// $sms="One Time Password for ".STORENAME." is : ".$genOTP;
			// $this->bulk_message->bulk_whatsapp($mobile,$sms);
			// $output['login_message']='OTP send success to your mobile';
			
			$output['login_message']='In Demo Version OTP Feature Disabled. Use Demo User !!';
			
			$output['login_cust_mobile_otp']=(string) $genOTP;
			$output['msg']="otp_cust";
		}	

		
		echo json_encode($output,true);				// send data back to mobile flutter app


	}

	function customerDetails()
	{
		$CustId=$this->input->post('cust_id');
		// $CustId=4;
		$custFirstName=$this->db->get_where('users',array('id' => $CustId))->row()->first_name;
		$custLastName=$this->db->get_where('users',array('id' => $CustId))->row()->last_name;
		$custAddress=$this->db->get_where('users',array('id' => $CustId))->row()->address1;
		
		$output[0]['custId']=$CustId;
		$output[0]['custFullName']=$custFirstName." ".$custLastName;
		$output[0]['custFirstName']=$custFirstName;
		$output[0]['custLastName']=$custLastName;
		$output[0]['custAddress']=$custAddress;
		
		echo json_encode($output);
	}

	function chkLoggedUser($mobile='')
	{
		/* Register New User */

		$chkMobileExist=$this->db->get_where('users' , array('mobile' =>$mobile));
		$password = substr($mobile, -4);
		
		if($chkMobileExist->num_rows()==0)
		{	
			$newMobileUser = array('join_date' => date('Y-m-d'),'mobile' => $mobile, 'password' => $password, 'status' => 'enable','mobile_login_status' => 'enable');
			$this->db->insert('users', $newMobileUser);
			
		}			
		
		/* End Registration New User */
		
		$this->session->set_userdata('flutterLoggedUser',$mobile);
		
		$this->session->set_userdata('muser_login',1);
		$this->session->set_userdata('mobile_exist',$mobile);
		
		$custId=$this->db->get_where('users' , array('mobile' =>$mobile))->row()->id;
		
		$this->session->userdata('muser_login');

		$this->session->set_userdata('cust_id',$custId);

		redirect('mobile/mobile_main','refresh');
	}
	
	
	function chkMobileLoginStatus()
	{	
		$custMobile=$this->input->post('customer_mobile');
		// $custMobile='918108702999';
		$chk_mobile_login_status=$this->db->get_where('users',array('mobile'=>$custMobile))->row()->mobile_login_status;
		$output['login_status']=$chk_mobile_login_status;
		echo json_encode($output);
		
	}	


	//// END CUSTOMER CONTROLLER <<<<<<<<<<<<<<<< ////



	////////////////////////////////////////////
	/// Start Driver Controller ///
	/////////////////////////////////////////////

	

	// Driver Application Contronller // Dt - 29032022

	function chkDriverLoginDetails()
	{
		$drv_mobile=$this->input->post('driver_mobile');
		$drv_password=base64_encode($this->input->post('driver_password'));

		// $drv_mobile='1234123455';
		// $drv_password=base64_encode('demo');

		
		$login_query=$this->db->get_where('employee', array('mobile' => $drv_mobile, 'password' => $drv_password,'emp_role' =>'enable'));
		
		$count=$login_query->num_rows();

		if($count==1)
		{					
				$loginDriverId=$login_query->row()->emp_id;
				
				$output[0]['login_driver_id']=$loginDriverId;
				$output[0]['msg']="valid";
		}
		else
		{
			$output[0]['msg']="invalid";
		}	

		
		echo json_encode($output);				// send data back to mobile flutter app
			
	
	}

	function loginDriverOrders()
	{
		$EmpId=$this->input->post('emp_id');
		$today=date('Y-m-d');

   		
	    $output[0]['today_pickup']=$this->db->get_where("customer_order", array("pickup_by" => $EmpId,"order_status" => 'neworder',"pickup_date" => $today ))->num_rows();

	    $output[0]['total_pickup']=$this->db->get_where("customer_order", array("pickup_by" => $EmpId,"order_status" => 'neworder'))->num_rows();

	   $output[0]['today_delivery']=$this->db->get_where("customer_order", array("delivery_by" => $EmpId,"order_status" => 'wash_ready',"delivery_date" => $today ))->num_rows();

	   $output[0]['total_delivery']=$this->db->get_where("customer_order", array("delivery_by" => $EmpId,"order_status" => 'wash_ready'))->num_rows();

	   echo json_encode($output);

	}

	function loginDriverDetails()
	{
		$EmpId=$this->input->post('emp_id');
		$empFirstName=$this->db->get_where('employee',array('emp_id' => $EmpId))->row()->first_name;
		$empLastName=$this->db->get_where('employee',array('emp_id' => $EmpId))->row()->last_name;
		$empMobile=$this->db->get_where('employee',array('emp_id' => $EmpId))->row()->mobile ;
		$empEmail=$this->db->get_where('employee',array('emp_id' => $EmpId))->row()->email_id;

		$output[0]['empId']=$EmpId;
		$output[0]['empFullName']=$empFirstName." ".$empLastName;
		$output[0]['empFirstName']=$empFirstName;
		$output[0]['empLastName']=$empLastName;
		$output[0]['empPhone']=$empMobile;
		$output[0]['empEmail']=$empEmail;

		echo json_encode($output);
	}

	// Driver Pickup Delivery Orders List

	function loginDriverPickupLists()
	{
		$EmpId=$this->input->post('emp_id');
		$Today=date('Y-m-d');
	
		$this->db->order_by("pickup_date");
		$pickupLists=$this->db->select('*')
		->from('customer_order as t1' )
		->where('pickup_by',$EmpId)
		->where('order_status=','pickup')
		->join('users as t2','t1.customer_id = t2.id','left')
		->get()->result();

		if(count($pickupLists)==0) { $pickOrderList[] = (object) [ 'no_of_rec' => 0, 'message' => 'notfound']; }
		
		foreach($pickupLists as $pickRow)
		{
			$shipAddress=unserialize($pickRow->order_address);
			$cust_map_pos = $shipAddress['addlatlng'];
			$cust_map = explode(',', $cust_map_pos);

			$todaypickup="no";
			if($Today==$pickRow->pickup_date)
			{
				$todaypickup="yes";
			}	

			$custId=$pickRow->customer_id;
			$custFirstName=$this->db->get_where('users',array(id=>$custId))->row()->first_name;
			$custLastName=$this->db->get_where('users',array(id=>$custId))->row()->last_name;
			$custName="{$custFirstName} {$custLastName}";

			$pickOrderList[]= (object)
			[	
				'no_of_rec' => count($pickupLists),
				'auto_id' => $pickRow->auto_id,
				'invoice_no' => $pickRow->invoice_no,
				'customer_id' => $custId,
				'customer_name' => $custName,
				'mobile' => $pickRow->mobile,
				'pickup_date' => date('d-M-Y',strtotime($pickRow->pickup_date)),
				'pickup_time' => $pickRow->pickup_time,
				'order_status' => $pickRow->order_status,
				// 'order_address' => $shipAddress['street'].",".$shipAddress['landmark']."-".$shipAddress['pincode'],
				'cust_address' => $pickRow->address1,
				'cust_latitute' => $cust_map[0],
				'cust_longitude' => $cust_map[1],
				'order_cloth_photo' => $pickRow->order_cloth_photo,
				'today_pickup' => $todaypickup,
			];

		}	// foreach()

		echo json_encode($pickOrderList, JSON_PRETTY_PRINT);	
	
	}

	function loginDriverDeliveryLists()
	{
		$EmpId=$this->input->post('emp_id');
		$Today=date('Y-m-d');
		if($EmpId==null) $EmpId=0;

		$this->db->order_by("delivery_date");
		$deliveryLists=$this->db->select('*')
		->from('customer_order as t1' )
		->where('delivery_by',$EmpId)
		->where('order_status','out_for_delivery')
		->join('users as t2','t1.customer_id = t2.id','left')
		->get()->result();

		
		if(count($deliveryLists)==0) { $deliveryOrderList[] = (object) [ 'no_of_rec' => 0, 'message' => 'notfound']; } 
		
		foreach($deliveryLists as $deliveryRow)
		{
			$shipAddress=unserialize($pickRow->order_address);
			$cust_map_pos = $shipAddress['addlatlng'];
			$cust_map = explode(',', $cust_map_pos);

			$todaydelivery="no";
			if($Today==$deliveryRow->delivery_date)
			{
				$todaydelivery="yes";
			}

			$custId=$deliveryRow->customer_id;
			$custFirstName=$this->db->get_where('users',array(id=>$custId))->row()->first_name;
			$custLastName=$this->db->get_where('users',array(id=>$custId))->row()->last_name;
			$custName="{$custFirstName} {$custLastName}";

			$deliveryOrderList[]= (object)
			[	
				'no_of_rec' => count($deliveryLists),
				'auto_id' => $deliveryRow->auto_id,
				'invoice_no' => $deliveryRow->invoice_no,
				'customer_id' => $custId,
				'customer_name' => $custName,
				'mobile' => $deliveryRow->mobile,
				'delivery_date' => date('d-M-Y',strtotime($deliveryRow->delivery_date)),
				'delivery_time' => $deliveryRow->delivery_time,
				'order_status' =>  $deliveryRow->order_status,
				// 'order_address' => $shipAddress['street'].",".$shipAddress['landmark']."-".$shipAddress['pincode'],
				'cust_address' => $deliveryRow->address1,
				'cust_latitute' => $cust_map[0],
				'cust_longitude' => $cust_map[1],
				'order_cloth_photo' => $deliveryRow->order_cloth_photo,
				'total_paid' => sprintf('%0.3f',$deliveryRow->total_paid),
				'amt_paidby' => $deliveryRow->amt_paidby,
				'today_delivery' => $todaydelivery,
			];

		}	// foreach()

		echo json_encode($deliveryOrderList, JSON_PRETTY_PRINT);	
	
	}


	
	function services()
	{
		$services=$this->db->get_where('services',array('show_hide'=>'show'))->result();
		foreach($services as $sRow)
		{
			$serviceData['services'][]= [
					'service_id' => $sRow->id,	
					'service_name' => $sRow->service_name,	
				];
		}	

		echo json_encode($serviceData,JSON_PRETTY_PRINT);
	}

	function driverPickupOrderDetails()
	{
		$InvoiceNo=$this->input->post('invoice_no');
	
		$EmpId=$this->db->get_where('customer_order' , array('invoice_no' =>$InvoiceNo))->row()->pickup_by;
		$emp_map_pos = $this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->emp_map_pos;

		$emp_map = explode(',', $emp_map_pos);
		
		$setOrderStatus=$this->db->get_where('customer_order' , array('invoice_no' =>$InvoiceNo))->row()->order_status;

		$pickupOrderDetails=$this->db->select('*')
		->from('customer_order as t1' )
		->where('invoice_no', $InvoiceNo)
		->where('order_status', $setOrderStatus)
		->join('users as t2','t1.customer_id = t2.id','left')
		->get()->result();

		
		foreach($pickupOrderDetails as $pickRow)
		{
			$shipAddress=unserialize($pickRow->order_address);

			$cust_map_pos = $shipAddress['addlatlng'];
			$cust_map = explode(',', $cust_map_pos);

			$remarks=unserialize($pickRow->remarks);

			$WashInstruction=($remarks[0]=='')?"-" : $remarks[0];
			$driverInstruction=($remarks[1]=='')?"-" : $remarks[1];

			$invoice=$pickRow->invoice_no;
			$orderTempData=$this->db->get_where('order_temp' , array('order_invoice' =>$invoice))->result();
			foreach($orderTempData as $tempRow)
              {	 
              		$order_qty = $tempRow->order_qty;
					$order_cloth = $tempRow->order_cloth;
					$order_service = $tempRow->order_service;
					$order_price = $tempRow->order_price;
					$Amt=$tempRow->order_qty*$tempRow->order_price;	

              }	

			$couponData=unserialize($this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->discount);
			$charge_name=''; $charge_amount='0'; $Charges='0'; 
			foreach($couponData as $disp)
			{
				$charge_name=$disp['charge_name'];
				$charge_amount=$disp['charge_amt'];
				$Charges=$Charges-$disp['charge_amt'];


			}


			$SubAmt=$SubAmt+$Amt;
			

			$pickOrderNew[]= (object)
			[	
				'auto_id' => $pickRow->auto_id,
				'invoice_no' => $pickRow->invoice_no,
				'customer_name' => $pickRow->customer_name,
				'mobile' => $pickRow->mobile,
				'pickup_date' => $pickRow->pickup_date,
				'order_status' => $pickRow->order_status,
				'order_address' => $shipAddress['street'].",".$shipAddress['landmark']."-".$shipAddress['pincode'],
				'order_qty' => $order_qty,
				'order_cloth' => $order_cloth,
				'order_service' => $order_service,
				'order_price' => $order_price,
				'charge_name' => $charge_name,
				'charge_amount' => $charge_amount,
				'sub_total' => sprintf('%0.2f',$SubAmt),
				'total_amount' => sprintf('%0.2f',$SubAmt-$Charges),
				'wash_instruction' => $WashInstruction,
				'driver_instruction' => $driverInstruction,
				// 'driver_map_location' => $emp_map_pos,
				// 'customer_map_location' => $cust_map_pos,
				'cust_latitute' => $cust_map[0],
				'cust_longitude' => $cust_map[1],
				'driver_latitute' => $emp_map[0],
				'driver_longitude' => $emp_map[1],
				'order_cloth_photo' => $pickRow->order_cloth_photo,

			];
			
		}

		// $finalOrder= array_merge($pickOrderNew, $pickOrderTemp);

		// $obj_merged = (object) array_merge((array) $pickOrderNew, (array) $pickOrderTemp);
		// header('Content-Type: application/json');

		echo json_encode($pickOrderNew, JSON_PRETTY_PRINT);	

		// echo json_encode($finalOrder);

	}

	function driverShowCustomerDetails()
	{
		$cust_id=$this->input->post('cust_id');
		$customerData=$this->db->get_where('users',array('id'=>$cust_id))->result();
		echo json_encode($customerData);	
		
	}

	function driverUpdateCustomerDetails()
	{
		$cust_id=$this->input->post('cust_id');
		
		$data['first_name']=$this->input->post('first_name');
		$data['last_name']=$this->input->post('last_name');
		$data['mobile']=$this->input->post('mobile');
		$data['address1']=$this->input->post('address1');

		$this->db->where('id' , $cust_id);
			
		$output[0]='error';

		if($this->input->post('cust_id')!=0) $output[0]=($this->db->update('users' , $data)) ? "success" : 'error';		
		
		echo json_encode($output);

		// $decode=json_decode($encode);

		// echo $decode[0];
		
		

	}


	function driverDeliveryOrderDetails()
	{
		$InvoiceNo=$this->input->post('invoice_no');
		// $InvoiceNo=AHL18;

		$deliveryOrderData=$this->db->get_where('customer_order',array('invoice_no' => $InvoiceNo))->result();

		foreach($deliveryOrderData as $delRow)
		{
			$invoiceAmt=$delRow->total_paid;

			// store taxable
			$StoreId=$this->db->get_where('customer_order',array('invoice_no' => $InvoiceNo))->row()->laundry_store;
			$storeTaxable=$this->db->get_where('stores' , array('id' =>$StoreId))->row()->store_taxable;
			if($storeTaxable=='yes')
			{
				$vatAmt=$invoiceAmt*5/100;
				$invoiceAmt=sprintf('%0.3f',$invoiceAmt+$vatAmt);
			}
			//end store txable

			//Outstanding Amount
			$custrowid=$delRow->customer_id;

				$this->db->select();
				$this->db->select_sum('total_paid');
				$this->db->where("customer_id",$custrowid);
				$TotalAmount=$this->db->get('customer_order')->row()->total_paid;

				$this->db->select();
				$this->db->select_sum('amt_paid');
				$this->db->where("customer_id",$custrowid);
				$PaidAmount=$this->db->get('customer_order')->row()->amt_paid;

				$OldOustandingAmt=$this->db->get_where('users',array('id' => $custrowid))->row()->outstand_amt;

				$OutStandAmount=($OldOustandingAmt+$TotalAmount)-$PaidAmount;


				if($storeTaxable=='yes')
				{
					$vatAmt=$TotalAmount*5/100;
					$OutStandAmount=$OutStandAmount+$vatAmt;
				}	

			// End Outstanding Amount

			$paymentTaken=($OutStandAmount>0)? "yes" : "no"; 	

			$deliveryOrderDetails[] = (object) 
			[
				'invoice_no' => $delRow->invoice_no,
				'customer_name' => $delRow->customer_name,
				'total_paid' => sprintf('%0.3f',$invoiceAmt),
				'outstand_amt' => sprintf('%0.3f',$OutStandAmount),
				'payment_taken' => $paymentTaken,
			];

			
		}	

		echo json_encode($deliveryOrderDetails);
	}



	function driverPickupOrderUpdate()
	{
		$image=$this->input->post('image');
		$name=$this->input->post('name');
		$invoice_no=$this->input->post('invoice_no');

		$update_order['order_pickup_photo'] = $this->input->post('name');
		$update_order['order_status'] = 'processing';				// new order status change to pickup
		$update_order['services'] = $this->input->post('order_service');				
		$update_order['remarks'] = $this->input->post('order_remarks');				

		$this->db->where('invoice_no' , $invoice_no);

		if($this->db->update('customer_order', $update_order)===TRUE) 
		{
			// cloth photo upload
			$image=$this->input->post('image');
			$name=$this->input->post('name');
			$path="pickup_photo/";
			$realImage = base64_decode($image);
			file_put_contents($path.$name, $realImage);

			// end profile upload

			$output[0]['msg']="success";
		}
		else
		{
			$output[0]['msg']="error";
		}

		echo json_encode($output);

	}

	function driverDeliveryOrderUpdate()
	{
		$image=$this->input->post('image');
		$name=$this->input->post('name');
		$invoice_no=$this->input->post('invoice_no');
		$login_driver=$this->input->post('login_driver');
		$payment_Mode=$this->input->post('payment_Mode');
		$amount_paid=$this->input->post('amount_paid');
		// $login_driver=1;
		// echo $this->db->get_where('employee', array('emp_id'=>$login_driver))->row()->first_name;

		$update_order['order_delivery_photo'] = $this->input->post('name');
		
		if($payment_Mode!='' && $amount_paid!=0)
		{ 
			$update_order['amt_paidby'] = $payment_Mode; 
			$update_order['amt_paid'] = $amount_paid;
			$update_order['paid_date'] = date('Y-m-d');
			$update_order['payment_collect'] = $this->db->get_where('employee', array('emp_id'=>$login_driver))->row()->first_name;
		}

		$update_order['delivery_date'] = date('Y-m-d');
			
		$update_order['order_status'] = 'delivered';				// out of delivery status change to delivered

		$this->db->where('invoice_no' , $invoice_no);

		if($this->db->update('customer_order', $update_order)===TRUE) 
		{
			// cloth photo upload
			$image=$this->input->post('image');
			$name=$this->input->post('name');
			$path="delivery_photo/";
			$realImage = base64_decode($image);
			file_put_contents($path.$name, $realImage);

			// end profile upload

			$output[0]['msg']="success";
		}
		else
		{
			$output[0]['msg']="error";
		}

		echo json_encode($output);
	}


	function driverLiveLocation()
	{
		$lat= $this->input->post('lat'); 
  		$lng= $this->input->post('lng');
  		$EmpId=$this->input->post('emp_id');
  		
  		// $lat= 18.9801521; //latitude
	  	// $lng= 73.1355177; //longitude
		// $EmpId=5;

  		$checkDriverExist=$this->db->get_where('driver_track',array('emp_id'=>$EmpId))->result();
  		$driverName=$this->db->get_where('employee',array('emp_id'=>$EmpId))->row()->first_name;
  		$date = date('Y-m-d H:i:s');

  		// Get Address from Lat Lng
		/**** From OpenStree Map Free ********/
		$url = "https://nominatim.openstreetmap.org/search.php?q=".$lat.",".$lng."&polygon_geojson=1&format=json";
		
		$httpOptions = [
			"http" => [
				"method" => "GET",
				"header" => "User-Agent: Nominatim-Test"
			]
		];
		
		$streamContext = stream_context_create($httpOptions);
		$json = file_get_contents($url, false, $streamContext);
		
		$data=json_decode($json,true);
     	$status = $data[0]['osm_type'];
     	$driverLiveAddress=($status=="node")? $data[0]['display_name'] : $data[0]['display_name'];
		
		/**** From Google Map Paid ********/
		
		// echo $url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng='18.9801521,73.1355177'&sensor=false";
		
		// $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false&key='.GMAPKEY.'';

		// $json = @file_get_contents($url);
     	// $data=json_decode($json);
     	// $status = $data->status;
     	// $driverLiveAddress=($status=="OK")? $data->results[0]->formatted_address : $data->error_message;
		
		// End Get Address

     	$output[0] ['msg'] = "error";

  		if(count($checkDriverExist)>0)
  		{
  			// echo "driver found";

  			$update['emp_lat'] = $lat;
  			$update['emp_lng'] = $lng;
  			$update['location_address'] = $driverLiveAddress;
  			$update['location_date'] = $date;
  			$this->db->where('emp_id' , $EmpId);

  			if($this->db->update('driver_track' , $update)===TRUE) { $output[0] ['msg'] = "update"; } else { $output[0] ['msg'] = "updateerror"; }
  		}	
  		else
  		{
  			// echo "driver not found";

  			$data=array('emp_id' => $EmpId,'emp_name' => $driverName,'emp_lat' => $lat,'emp_lng' => $lng, 'location_address' => $driverLiveAddress,'location_date'=>$date);
  			if($this->db->insert('driver_track', $data)===TRUE) { $output[0] ['msg'] = "insert"; } else { $output[0] ['msg'] = "inserterror"; }
  			
  		}	

		
  		echo json_encode($output);
     	
     }
	

	function barcodeOrderStatus()
	{
		$InvoiceNo=$this->input->post('invoice');
		
		$orderStatus=$this->db->get_where('customer_order', array('invoice_no' =>$InvoiceNo))->row()->order_status;

		echo json_encode($orderStatus);
	}
	
	/// End Driver Application Controller //



	
}
