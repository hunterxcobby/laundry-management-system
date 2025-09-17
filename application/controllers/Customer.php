<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 09 June, 2017
	 *	Laundry Management Application
	 *	ajitrajyash@gmail.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation','googlemaps'));
        $this->load->database();
      	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
		
    }
	
	public function index()
	{	if ($this->session->userdata('user_login') == 0) redirect('customer/logout');
		$this->session->set_userdata('menu','dashboard');
		$user['userinfo'] = $this->db->get('users');
		$UserID=$this->session->userdata('user_id');
		$user['orderinfo'] = $this->db->get_where('customer_order' , array('customer_id' => $UserID) )->result();
		$this->load->view('customer/dashboard',$user);
		
	}
	
	// Customer Controller = = >
	
	function login()
	{	
			$mobile=$this->input->post('email');
			$pwd=$this->input->post('password');
			
			$this->db->where("email_id = '$mobile' OR mobile = '$mobile'");
			$this->db->where('password', $pwd);
			$custresult = $this->db->get('users');
		
						
			if (count($custresult->result()) > 0)
			{	
					$this->db->where("status='disable' AND (email_id = '$mobile' OR mobile = '$mobile')");
					//$this->db->where('status', 'disable');
					$check = $this->db->get('users');
				 
					if(count($check->result()) > 0)		// using direct parameter
					{
					?>
					<script> alert("Your account is Deactived \nPlease Contact Administrator "); </script>
					<?php
					redirect('../../','refresh');
					}	
			
				
				//echo "Login Successfully ==> Redirecting";
				$this->session->set_userdata('user_login', 1);
				if ($this->session->userdata('user_login') == 1)
				{	
					foreach($custresult->result() as $getcustrow): 
					$CustId=$getcustrow->id;
					$this->session->set_userdata('user_id',$CustId);
					setcookie("LoginUser", $mobile, time()+3600, "/", "localhost");
					endforeach; 
			
				?> <script> alert("Hi, <?php echo $mobile; ?> Your Login Successfully \nRedirecting Dashboard ..."); </script> <?php	
				redirect('customer/index','refresh');
				}
			}
			else
			{	$this->session->set_userdata('user_login', 0);
				echo "<script> alert('Username and Password Invalid...'); </script>"; 	
				redirect('../../','refresh');
				//echo "Error :";
			}
			
	}
		
	
	function register()
	{	
			$join_date=date('d-m-Y');
			$first_name=ucwords($this->input->post('first_name'));
			$last_name=ucwords($this->input->post('last_name'));
			$email_id=$this->input->post('email');
			$phone=$this->input->post('phone');
			$password='demo'; 
			$status='enable';
			
			$reg_users = array('join_date' => $join_date, 'first_name' => $first_name, 'last_name' => $last_name, 'email_id' => $email_id, 'mobile' => $phone, 'password' => $password, 'status' => $status);
			if($this->db->insert('users', $reg_users)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("Your Registration Successfully\n Your Temp Password : demo "); </script>
			<?php
			redirect('../../','refresh');
			}
			
	}
	
	function logout() {
        $this->load->helper(array('form','url','html','cookie'));
		$UserName='';
		setcookie("LoginUser",$UserName, time()+3600, "/", "localhost");
		$this->session->set_userdata('user_login', 0);
		$this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
		?>
			<script> alert("Your are Logging Out"); </script>
		<?php
		redirect('../../','refresh');
    }
	
	function check_item()
	{			
		$short_code=$this->input->post('productcode');
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
	
	// Customer Order COntroller 
	
	function customer_orders($order1='',$order2='', $order3='')
	{	
		if ($this->session->userdata('user_login') == 0) redirect('customer/logout');
		
		$this->session->set_userdata('menu','job_order');
		$this->session->set_userdata('submenu','orders');
		
				
		if($order1=='session_partyname')
		{
			$Order_Date = date('Y-m-d');
			$Party_Name = $this->session->userdata('user_id');
			
			$this->session->set_userdata('order_date',$Order_Date);
			$this->session->set_userdata('party_name',$Party_Name);
						
			$uresult = $this->db->get_where('customer_order' , array('order_date' => $Order_Date, 'customer_id' => $Party_Name) )->result();
			
			if (count($uresult) > 0)
			{
				foreach($uresult as $getcustrow): 
				$CustId=$getcustrow->auto_id;
				endforeach;
				redirect('customer/customer_orders/update_order/'.$CustId.'','refresh');
			}
			else
			{
				redirect('customer/customer_orders/add_order','refresh');
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
		
			
			$this->load->view('customer/customer_order',$session);
			
		}
		
		if($order1=='update_order')
		{	
						
			$session['price_data'] = $this->db->get('price_list');
			$session['laundry_service'] = $this->db->get('services');
			$session['laundry_cloth'] = $this->db->get('cloths');
						
			
			$updatedata = $this->db->get_where('customer_order' , array('auto_id' => $order2) );
			
			foreach($updatedata->result() as $updaterow): 
				$Order_Date_Session = $updaterow->order_date ;
				$Party_Name_Session = $updaterow->customer_id ;
				$session['Discount']=$updaterow->discount ;	
				$session['ServiceTax']=$updaterow->service_tax ;
				$session['AmtPaidBy']=$updaterow->amt_paidby ;
				$session['ChequeNo']=$updaterow->cheque_no ;
				$session['ChequeDate']=$updaterow->cheque_date ;
				$session['Remarks']=$updaterow->remarks ;
				$session['OrderStatus']=$updaterow->order_status;
				
				
				$this->session->set_userdata('order_date',$Order_Date_Session);
				$this->session->set_userdata('party_name',$Party_Name_Session);
			endforeach;

						
			$session['Order_Date']=$this->session->userdata('order_date');
			$session['Party_Name']=$this->session->userdata('party_name');
			
			
			$session['userdata'] = $this->db->get('users');
			
			$Order_Date=$this->session->userdata('order_date');
			$Party_Name=$this->session->userdata('party_name');
			
			$session['order_temp'] = $this->db->get_where('order_temp' , array('order_date' => $Order_Date,'customer_id' => $Party_Name) )->result();
			
				
			$session['last_id']=$order2-1;			
			
			$this->load->view('customer/customer_update_order',$session);
			
		}
		
		
		if($order1=='insert_order_final')
		{
			$OrderDateIns=$this->session->userdata('order_date');
			$OrderDateIns=date('Y-m-d',strtotime($OrderDateIns));
			$OrderMonth=date('M',strtotime($OrderDateIns));
			
			$PartyNameIns=$this->session->userdata('party_name');
			
			$Invoice = $this->input->post('invoice_no');
			$DeliveryDate = $this->input->post('delivery_date');
			$TotalQty = $this->input->post('totalpc');
			
			$Discount = $this->input->post('discount');
			$ServiceTax = $this->input->post('servicetax');
			$GrandTotal = $this->input->post('granttotal');
			$PaidBy = $this->input->post('paidby');
			$ChequeNo = $this->input->post('cheque_no');
			$ChequeDate = $this->input->post('cheque_date');
			$Remarks = $this->input->post('remarks');
			//$OrderStatus = $this->input->post('order_status');
			$OrderStatus = "pending";
			
			$orderfinal = array('invoice_no' => $Invoice, 'order_date' => $OrderDateIns, 'order_month' => $OrderMonth, 'customer_id' => $PartyNameIns, 'total_qty' => $TotalQty,  'discount' => $Discount,  'service_tax' => $ServiceTax, 'total_paid' => $GrandTotal, 'delivery_date' => $DeliveryDate, 'amt_paidby' => $PaidBy, 'cheque_no' => $ChequeNo, 'cheque_date' => $ChequeDate, 'remarks' => $Remarks, 'order_status '=> $OrderStatus );
			if($this->db->insert('customer_order', $orderfinal)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("Order Generatation Successfully"); </script>
			<?php
			redirect('customer/index','refresh');
			}	
		
		}
		
		if($order1=='update_order_final')
		{
			
			$data['delivery_date'] = $this->input->post('delivery_date');
			$data['total_qty'] = $this->input->post('totalpc');
			
			$data['discount'] = $this->input->post('discount');
			$data['service_tax'] = $this->input->post('servicetax');
			$data['total_paid'] = $this->input->post('granttotal');
			$data['amt_paidby'] = $this->input->post('paidby');
			$data['cheque_no'] = $this->input->post('cheque_no');
			$data['cheque_date'] = $this->input->post('cheque_date');
			$data['remarks'] = $this->input->post('remarks');
			//$data['order_status'] = $this->input->post('order_status');
			
			$this->db->where('auto_id' , $order2);
			
			
			if($this->db->update('customer_order', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("Order Updated Successfully"); </script>
			<?php
			//redirect('customer/customer_orders/update_order/'.$order2.'','refresh');
			redirect('customer/index','refresh');
			}	
		
		}
		
		
		
		if($order1=='add_item')
		{
			$data['price_data'] = $this->db->get('price_list');
			$data['laundry_service'] = $this->db->get('services');
			$data['laundry_cloth'] = $this->db->get('cloths');
			$data['UpdateOrder'] = $order2;
			$this->load->view('customer/add_item',$data);
		}
		
		if($order1=='add_item_order')
		{
			
			$OrderDateTemp=$this->session->userdata('order_date');
			$PartyNameTemp=$this->session->userdata('party_name');
			
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
			
			$order = array('order_date' => $OrderDateTemp, 'customer_id' => $PartyNameTemp, 'price_shortcode' => $Short_ID, 'order_service' => $ItemServiceName, 'order_cloth' => $ItemClothType, 'order_qty' => $Qty, 'order_price' => $ItemPrice);
			if($this->db->insert('order_temp', $order)===TRUE)		// using direct parameter
			{
				if($order2!='')
				{
					redirect('customer/customer_orders/update_order/'.$order2.'','refresh');
				}
				else
				{
					redirect('customer/customer_orders/add_order','refresh');
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
					redirect('customer/customer_orders/update_order/'.$order3.'','refresh');
				}
				else
				{
					redirect('customer/customer_orders/add_order','refresh');
				}		
			}	
		}
		
		if($order1=='delete_order')
		{	$this->db->where('auto_id' , $order2);
            if($this->db->delete('customer_order')===TRUE)		// using direct parameter
			{
			redirect('customer/customer_orders/invoice_list','refresh');
			}	
		}
		
		if($order1=='invoice_order')
		{				
			$Invoice['customer_data'] = $this->db->get('users');
			$Invoice['price_data'] = $this->db->get('price_list');
			$Invoice['laundry_service'] = $this->db->get('services');
			$Invoice['laundry_cloth'] = $this->db->get('cloths');
			
			$Invoice['order_data'] = $this->db->get_where('customer_order' , array('auto_id' => $order2) )->result();
			$this->load->view('customer/customer_invoice',$Invoice);
		}
			
		
		
	}
	
	// Invoice Pdf Controller --->
	
	function invoicepdf($invoiceid='')
	{
		$this->load->library('pdf');
		$Invoice['customer_data'] = $this->db->get('users');
		$Invoice['price_data'] = $this->db->get('price_list');
		$Invoice['laundry_service'] = $this->db->get('services');
		$Invoice['laundry_cloth'] = $this->db->get('cloths');
		$Invoice['order_data'] = $this->db->get_where('customer_order' , array('auto_id' => $invoiceid) )->result();
		$this->pdf->load_view('customer/invoice_pdf',$Invoice);
		$this->pdf->render();
		$this->pdf->stream("invoice.pdf");
	}
	
	
	// Customer Google Map Address Controller --->
	
	function address_crud($add1='')
	{		
		if($add1 == 'show')
		{
			// Google Map Location 
			
			$UserID=$this->session->userdata('user_id');
			
			$cust_map_pos = $this->db->get_where('users' , array('id' =>$UserID))->row()->cust_map_pos;
			
			$config['center'] = $cust_map_pos;
			$config['zoom'] = '18';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $cust_map_pos;
			$marker['draggable'] = true;
			$marker['ondragend'] = 'document.getElementById(\'custmap\').value= event.latLng.lat() + \', \' + event.latLng.lng()';
			$this->googlemaps->add_marker($marker);
			$data['mapcust'] = $this->googlemaps->create_map();
		
			$data['userdata'] = $this->db->get_where('users' , array('id' => $UserID) );			
			$this->load->view('customer/customer_address',$data);
		}
		
		if ($add1 == 'modify') 
		{   $UserID=$this->session->userdata('user_id');
            $data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['zipcode'] = $this->input->post('zipcode');
			$data['country'] = $this->input->post('country');
			$data['cust_map_pos'] = $this->input->post('custmap');
			
			
			$this->db->where('id' , $UserID);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
			redirect('customer/address_crud/show','refresh');
			}
		}
		
		
	}	

	
			
	// customer Profile Controller --->
	
	function profile()
	{	if ($this->session->userdata('user_login') == 0) redirect('customer/logout');
		$this->session->set_userdata('menu','profile');
		$this->session->set_userdata('submenu','adminprofile');
		$UserID=$this->session->userdata('user_id');
		$data['userdata'] = $this->db->get_where('users' , array('id' => $UserID) );
		
		//$data['userdata'] = $this->db->get('users');
		$this->load->view('customer/customer_profile',$data);
		
	}
	
	function edit_profile($id="")
	{	
		$UserID=$this->session->userdata('user_id');
		$data['userdata'] = $this->db->get_where('users' , array('id' => $UserID) );
		$this->load->view('customer/edit_profile',$data);
		
	}
	
	function update_profile($id="")
	{	
			$customer['mobile'] = $this->input->post('mobile');
            $customer['email_id'] = $this->input->post('email');
            //$customer['address'] = $this->input->post('address');
            $NewPass=$this->input->post('new_passwd');
			
			if($NewPass!="")
			{
			    $customer['password'] = $this->input->post('new_passwd');
			}	
           
            $this->db->where('id' , $id);
			
			if($this->db->update('users' , $customer)===TRUE)		// using direct parameter
			{
				if($NewPass!="")
				{
				?>
					<script> confirm("Password Changed Successfully!!!"); </script>
				<?php
				
				
					redirect('customer/logout','refresh');
				}
				else
				{
				?>
					<script> confirm("Information Updated"); </script>
				<?php	
					redirect('customer/profile','refresh');
				}	
			
			}
			
	}
	
}	