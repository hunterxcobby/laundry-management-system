<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 24 July, 2017
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
	{	if ($this->session->userdata('employee_login') == 0) redirect('employee/logout');
		$this->session->set_userdata('menu','dashboard');
		$desktop['employeeinfo'] = $this->db->get('employee');
		$Today=date('d-m-Y'); $desktop['today']=$Today;
		$EmpID=$this->session->userdata('emp_id');
		//$desktop['emporderpickup'] = $this->db->get_where('customer_order' , array('pickup_by' => $EmpID,'pickup_date' => $Today) )->result();
		
		//$desktop['emporderdeliver'] = $this->db->get_where('customer_order' , array('delivery_by' => $EmpID,'delivery_date' => $Today) )->result();
		
		$this->db->where("pickup_by = '$EmpID' AND pickup_date = '$Today'");
		$desktop['emporderpickup'] = $this->db->get('customer_order')->result();
		
		$this->db->where("delivery_by = '$EmpID' AND delivery_date = '$Today'");
		$desktop['emporderdeliver'] = $this->db->get('customer_order')->result();
			
		$this->load->view('employee/dashboard',$desktop);
		
	}
	
	function pickupdelivery()
	{	if ($this->session->userdata('employee_login') == 0) redirect('employee/logout');
		$this->session->set_userdata('menu','dashboard');
		$this->session->set_userdata('submenu','pickorders');
		
		$pickup['employeeinfo'] = $this->db->get('employee');
		$EmpID=$this->session->userdata('emp_id');
		$pickup['emporderpickup'] = $this->db->get_where('customer_order' , array('pickup_by' => $EmpID) )->result();
		$pickup['emporderdeliver'] = $this->db->get_where('customer_order' , array('delivery_by' => $EmpID) )->result();
		$this->load->view('employee/pickupdel',$pickup);
		
	}
	
	
		
	// Employee Dashboard Order Info Controller -->
	
	function order_info($param1='', $param2='' , $param3='')
	{
		$CustId=$param1;
		$OrderDate=$param2;
		
		$order['custdata'] = $this->db->get_where('users' , array('id' => $CustId));
		$order['emporderdata'] = $this->db->get_where('order_temp' , array('order_date' => $OrderDate, 'customer_id'=> $CustId));
				
		$order['totamt']=0;
		if($param3!='')
		{ $order['totamt']=$this->db->get_where('customer_order' , array('invoice_no' =>$param3))->row()->total_paid;
		}
		
		// Google Map Location
		
		$sys_map_pos = $this->db->get_where('settings' , array('id' =>'1'))->row()->shop_gmap;
		$cust_map_pos = $this->db->get_where('users' , array('id' =>$CustId))->row()->cust_map_pos;
						
		$config['center'] = $sys_map_pos;
		$config['zoom'] = 'auto';
		$config['directions'] = TRUE;
		$config['directionsStart'] = $sys_map_pos ;
		$config['directionsEnd'] = $cust_map_pos;
		$config['directionsDivID'] = 'directionsDiv';
		$this->googlemaps->initialize($config);
		$order['sysmap'] = $this->googlemaps->create_map();

		
		$this->load->view('employee/order_form',$order);
	
	}
	
	
	// Employee Order Status (Pickup, Delivery) --->
	
	function update_order()
	{	if ($this->session->userdata('employee_login') == 0) redirect('employee/logout');
		$this->session->set_userdata('menu','profile');
		$this->session->set_userdata('submenu','adminprofile');
		$EmpID=$this->session->userdata('emp_id');
		$data['empdata'] = $this->db->get_where('employee' , array('emp_id' => $EmpID) );
		
		//$data['userdata'] = $this->db->get('users');
		//$this->load->view('employee/dashboard',$data);
		redirect('employee/index', 'refresh');
		
	}
	
	
	// Employee Profile Controller --->
	
	function profile()
	{	if ($this->session->userdata('employee_login') == 0) redirect('employee/logout');
		$this->session->set_userdata('menu','profile');
		$this->session->set_userdata('submenu','adminprofile');
		$EmpID=$this->session->userdata('emp_id');
		$data['empdata'] = $this->db->get_where('employee' , array('emp_id' => $EmpID) );
		
		//$data['userdata'] = $this->db->get('users');
		$this->load->view('employee/employee_profile',$data);
		
	}
	
	function edit_profile($id="")
	{	
		$EmpID=$this->session->userdata('emp_id');
		$data['empdata'] = $this->db->get_where('employee' , array('emp_id' => $EmpID) );
		$this->load->view('employee/employee_update_profile',$data);
		
	}
	
	function update_profile($id="")
	{	
			$employee['mobile'] = $this->input->post('mobile');
            $employee['email_id'] = $this->input->post('email');
            $employee['emp_add1'] = $this->input->post('address1');
            $employee['emp_add2'] = $this->input->post('address2');
            $employee['emp_city'] = $this->input->post('city');
            $employee['emp_state'] = $this->input->post('state');
            $employee['emp_zip'] = $this->input->post('zipcode');
            
            $NewPass=$this->input->post('new_passwd');
			
			if($NewPass!="")
			{
			    $employee['password'] = $this->input->post('new_passwd');
			}	
           
            $this->db->where('emp_id' , $id);
			
			if($this->db->update('employee' , $employee)===TRUE)		// using direct parameter
			{
				if($NewPass!="")
					{
					?>
						<script> confirm("Password Changed Successfully!!!"); </script>
					<?php
					
					
						redirect('employee/logout','refresh');
					}
					else
					{
					?>
						<script> confirm("Information Updated"); </script>
				<?php
				redirect('employee/profile','refresh');
				}
			}
	}
	
	// Employee Logout Controller 
	
	function logout() {
        $this->session->set_userdata('employee_login', 0);
		$this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
		?>
			<script> alert("Your are Logging Out"); </script>
		<?php
		redirect('login','refresh');
    }
	
	
	
}	