<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Driver extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers Team / 8767228990
	 *	date		: 09 August 2020
	 *	Laundry Management Application (Mobile Driver UI Kit )
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

	/* Driver Module */

	public function index()
	{	
		 
		$drvLogin=date('d-m-Y');
		$this->load->view('mobile/mobile_driver_login',$drvLogin);
		
	}

	function driverchklogin()
	{
		$drvmobile=$this->input->post('emp_mobile');
		
		if($drvmobile=='') $mobile=$this->session->userdata('flutterLoggedUser');

		$chkDriverMobileExist=$this->db->get_where('employee' , array('mobile' =>$drvmobile,'emp_role' =>'enable'));

		$chkDriverMobileExist->num_rows();

		if($chkDriverMobileExist->num_rows()=='')
		{	
			$this->session->set_flashdata('error_login',1);
			redirect("driver","refresh");  
		}
		else
		{	$loggingEmpId = $this->db->get_where('employee' , array('mobile' =>$drvmobile))->row()->emp_id;
			
			$this->session->set_userdata('emp_login', 1);
			$this->session->set_userdata('emp_id', $loggingEmpId);
			redirect("driver/drivermain","refresh");

		}	
	}

	function drivermain()
	{
		if($this->session->userdata('emp_login')==0) redirect('driver/driverlogout','refresh');

		$EmpId=$this->session->userdata('emp_id');
	
		$main['empFirstName']=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->first_name;
		$main['empLastName']=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->last_name;
		$main['empMobile']=$this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->mobile;
		$ShopName = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_name;

		$this->session->set_userdata('shopname', $ShopName);
		$this->load->view('mobile/mobile_driver_main',$main); 
	}

	function driverpickuporder()
	{
		if($this->session->userdata('emp_login')==0) redirect('driver/driverlogout','refresh');
		$pickup['today']=date('Y-m-d');
		$this->load->view('mobile/mobile_driver_pickup_order',$pickup); 
	}

	function driverpickuporderdetails($id='')
	{
		if($this->session->userdata('emp_login')==0) redirect('driver/driverlogout','refresh');
		$pickuporder['today']=date('Y-m-d');
		$pickuporder['orderId']=$id;
		$invoice=$this->db->get_where('customer_order' , array('auto_id' =>$id))->row()->invoice_no;
		$pickuporder['orderTempData']=$this->db->get_where('order_temp' , array('order_invoice' =>$invoice))->result();
		$orderAddress=unserialize($this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->order_address);
		$pickuporder['orderAddress']=$orderAddress;
		$pickuporder['couponData']=unserialize($this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->discount);
		$pickuporder['amtPaidBy']=$this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->amt_paidby;

		// Google map direction
		$EmpId=$this->session->userdata('emp_id');
		$emp_map_pos = $this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->emp_map_pos;
		$cust_map_pos = $orderAddress['addlatlng'];
						
		$config['center'] = $cust_map_pos;
		$config['zoom'] = '18';
		$config['directions'] = TRUE;
		$config['directionsStart'] = $emp_map_pos ;
		$config['directionsEnd'] = $cust_map_pos;
		$config['directionsDivID'] = 'directionsDiv';
		$this->googlemaps->initialize($config);
		$pickuporder['dirmap'] = $this->googlemaps->create_map();
		
		// End Google map direction

		$this->load->view('mobile/mobile_driver_pickup_order_details',$pickuporder); 
	}


	function driverdeliveryorder()
	{
		if($this->session->userdata('emp_login')==0) redirect('driver/driverlogout','refresh');
		$delivery['today']=date('Y-m-d');
		$this->load->view('mobile/mobile_driver_delivery_order',$delivery); 
	}

	function driverdeliveryorderdetails($id='')
	{
		if($this->session->userdata('emp_login')==0) redirect('driver/driverlogout','refresh');
		$deliveryorder['today']=date('Y-m-d');
		$deliveryorder['orderId']=$id;
		$invoice=$this->db->get_where('customer_order' , array('auto_id' =>$id))->row()->invoice_no;
		$deliveryorder['orderTempData']=$this->db->get_where('order_temp' , array('order_invoice' =>$invoice))->result();
		$orderAddress=unserialize($this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->order_address);
		$deliveryorder['orderAddress']=$orderAddress;
		$deliveryorder['couponData']=unserialize($this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->discount);
		$deliveryorder['amtPaidBy']=$this->db->get_where('customer_order' , array('invoice_no' =>$invoice))->row()->amt_paidby;

		// Google map direction
		$EmpId=$this->session->userdata('emp_id');
		$emp_map_pos = $this->db->get_where('employee' , array('emp_id' =>$EmpId))->row()->emp_map_pos;
		$cust_map_pos = $orderAddress['addlatlng'];
						
		$config['center'] = $cust_map_pos;
		$config['zoom'] = '18';
		$config['directions'] = TRUE;
		$config['directionsStart'] = $emp_map_pos ;
		$config['directionsEnd'] = $cust_map_pos;
		$config['directionsDivID'] = 'directionsDiv';
		$this->googlemaps->initialize($config);
		$deliveryorder['dirmap'] = $this->googlemaps->create_map();
		
		// End Google map direction

		$this->load->view('mobile/mobile_driver_delivery_order_details',$deliveryorder); 
	}


	function driverordermodify()
	{
		$auto_id=$this->input->post('order_id');
		$order_status=$this->input->post('selector');
		$orderSection=$this->input->post('order_section');
		$remarks=$this->input->post('remarks');
		if($orderSection=="pickup")
		{
		   $pickup['order_status'] = $order_status;
		   $pickup['remarks'] = $remarks;
		   $pickup['pickup_date'] = date('Y-m-d');
		   $pickup['pickup_time'] = date("g:i A");
			
			$this->db->where('auto_id' , $auto_id);
			if($this->db->update('customer_order', $pickup)===TRUE)
			{
				redirect("driver/driverpickuporder","refresh");
			}		
		}

		if($orderSection=="delivery")
		{
		   $delivery['order_status'] = $order_status;
		   // $delivery['remarks'] = $remarks;
		   $delivery['delivery_date'] = date('Y-m-d');
		   $delivery['delivery_time'] = date("g:i A");
			
			$this->db->where('auto_id' , $auto_id);
			if($this->db->update('customer_order', $delivery)===TRUE)
			{
				redirect("driver/driverdeliveryorder","refresh");
			}		
		}

		
	}

	
	function driverlogout()
	{
		$this->session->sess_destroy();
		redirect('mobile/mobile_logout','refresh');
	}

	
	


	
}		//Class Mobile Driver Controller End	