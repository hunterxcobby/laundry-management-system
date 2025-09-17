<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers Team / 8767228990
	 *	date		: 08 February, 2019
	 *	Laundry Management Application (Customer Packages)
	 *	rpcits2013@gmail.com
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
		
    }
	
	function package_list()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','job_order');
		$this->session->set_userdata('submenu','packagelist');
		//$this->db->order_by("pkg_id",'desc');
		$pkg['custpkgdata'] = $this->db->get('cust_packages');
		$this->load->view('admin/customer_package_list',$pkg);
	}
	
	
	function pkg_crud($param1='', $param2='')
	{	
		if($param1=='create')
		{	$category=$this->input->post('category');
			$pkg_name=strtoupper($this->input->post('pkg_name'));
			$usage_limit=$this->input->post('usage_limit');
			$pickup=$this->input->post('pickup');
			$duration=$this->input->post('duration');
			$amount=$this->input->post('amount');
			$description=$this->input->post('description');
			
			$data = array('category' => $category, 'pkg_name' => $pkg_name, 'usage_limit' => $usage_limit, 'pickup' => $pickup, 'duration' => $duration, 'amount' => $amount, 'description' => $description );
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
		
		if($param1=='package_status')
		{	//echo $param2;
			
			$PackageStatus= $this->db->get_where('cust_packages' , array('pkg_id' => $param2) )->result();
			foreach($PackageStatus as $pkg_row)
			{	$OrderData['pkg_id']=$param2;
				$OrderData['CustId']=$pkg_row->cust_id;
				$OrderData['pref_pkg']=$pkg_row->pref_pkg;
				$OrderData['payment_mode']=$pkg_row->payment_mode;
				$OrderData['pkg_active']=$pkg_row->pkg_active;
			}
			
           	$this->load->view('admin/cust_pkg_status',$OrderData);
			
		}
		
		if($param1=='modify_pkg_status')
		{	
			$pkg_status=$this->input->post('pkg_active');
			//if($pkg_status=='active' || $pkg_status=='expired' )
			//{ $data['active_expire_date']=date('Y-m-d'); } else $data['active_expire_date']='';
			$data['pkg_active'] = $this->input->post('pkg_active');
			$data['payment_date'] = date('Y-m-d',strtotime($this->input->post('payment_date')));
			//$data['amt_paidby'] = $this->input->post('paidby');
			
			//if($this->input->post('order_status')=='done') { $data['amt_paidby']="paid"; }
			//else { $data['amt_paidby']="notpaid"; }
			
			$this->db->where('pkg_id' , $param2);
				
				
				if($this->db->update('cust_packages', $data)===TRUE)		// using direct parameter
				{
				redirect('package/package_list','refresh');
				}	
			
		}
		
		
		if($param1=='delete')
		{	$this->db->where('pkg_id' , $param2);
            if($this->db->delete('packages')===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Deleted Successfully"); </script>
			<?php
			redirect('admin/packages','refresh');
			}	
		}
	}



	// Package Insert

	function pkg_insert()
		{	
			$WebCustId=$this->input->post('cust_id');
			$pref_pkg=$this->input->post('pref_pkg');
			$pref_pkg_name=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->pkg_name;
			$pref_period=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->duration."M";
			$pref_pickup='Weekly';
			$pref_pickup_date=date('Y-m-d',strtotime($this->input->post('pref_pickup_date')));
			$dur=str_replace("M"," months",$pref_period);
			$pkg_expire_date=date('Y-m-d',strtotime('+'.$dur.'',strtotime($pref_pickup_date)));
			$payment_mode=$this->input->post('payment_mode');
			$payment_date=date('Y-m-d');
			$amount=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->amount;
			$usage_limit=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->usage_limit;

			$pkg_unit=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->pkg_unit;

			// $WebCustId=$this->session->userdata('cust_id');
			// $pref_pkg=$this->input->post('pref_pkg');
			// $pref_pkg_name=$this->db->get_where('packages' , array('pkg_id' =>$pref_pkg))->row()->pkg_name;
			// $pref_period=$this->input->post('pref_period');
			// $pref_pickup=$this->input->post('pref_pickup');
			// $pref_pickup_date=$this->input->post('pref_pickup_date');
			// $dur=str_replace("M"," months",$pref_period);
			// $pkg_expire_date=date('d-m-Y',strtotime('+'.$dur.'',strtotime($pref_pickup_date)));
			// $payment_mode=$this->input->post('payment_mode');
			// $payment_date=date('Y-m-d');
			// $amount=$this->input->post('amount');
			// $usage_limit=$this->input->post('usage_limit');
			
						
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
			
			if($this->db->insert('cust_packages', $packageQuery)===TRUE)		// using direct parameter
			{ 	
					// $address['address1']=$this->input->post('address1');
					// if($this->input->post('address1')!='')
					// {
					// $this->db->where('id' , $WebCustId);
				
					// if($this->db->update('users' , $address)===TRUE) { }
					// }
				
			redirect('package/package_list','refresh');				
			}	
		
		}
	
	
}		//Class Stores Controller End	