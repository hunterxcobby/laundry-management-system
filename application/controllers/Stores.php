<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stores extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers Team / 8767228990
	 *	date		: 08 December, 2018
	 *	Laundry Management Application (Stores)
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
	
	public function index()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','stores');
		$this->db->order_by("store_main",'desc');
		$store['storedata'] = $this->db->get('stores');
		$store['last_id']=0;	
		$result=$this->db->select('*')->from('stores')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$store['last_id'] = $result[0]->id;
		$this->load->view('stores/store',$store);
		
	}
	
	public function storenew()
	{  if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','stores');
		$this->db->order_by("id","desc");
		$store['storedata'] = $this->db->get('stores');
		$store['last_id']=0;	
		$result=$this->db->select('*')->from('stores')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$store['last_id'] = $result[0]->id;
		$this->load->view('stores/store_new',$store);
	}	
	
	function store_crud($param1='', $param2='')
	{	if($param1=='create')
		{	
			$create_date=$this->input->post('create_date');
			$store_name=htmlentities($this->input->post('store_name'));
			$short_name=htmlentities($this->input->post('short_name'));
			$store_add1=htmlentities($this->input->post('store_add1'));
			$store_add2=htmlentities($this->input->post('store_add2'));
			$store_city=htmlentities($this->input->post('store_city'));
			$store_state=htmlentities($this->input->post('store_state'));
			$store_zip=htmlentities($this->input->post('store_zip'));
			$store_phone=htmlentities($this->input->post('store_phone'));
			$store_email=htmlentities($this->input->post('store_email'));
			$store_password=base64_encode($this->input->post('store_password'));
			$store_tax_no=htmlentities($this->input->post('store_tax_no'));
			$show_hide=htmlentities($this->input->post('show_hide'));
			$remarks=htmlentities($this->input->post('remarks'));
			
			$data = array('create_date' =>$create_date,'store_name' => $store_name,'short_name' => $short_name, 'store_add1' => $store_add1,'store_add2' => $store_add2,'store_city' => $store_city,'store_state' => $store_state,'store_zip' => $store_zip,'store_phone' => $store_phone,'store_email' => $store_email,'store_password' => $store_password,'store_tax_no' => $store_tax_no,'show_hide' => $show_hide, 'remarks' => $remarks);
			
			if($this->db->insert('stores', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_save'); ?> "); </script>
			<?php
			redirect('stores/index','refresh');
			}	
		}
		
		
		if($param1=='do_update')
		{	$query['store_edit'] = $this->db->get_where('stores' , array('id' => $param2) )->result();
			$this->load->view('stores/store_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['create_date']= htmlentities($this->input->post('create_date'));
            $data['store_name'] = htmlentities($this->input->post('store_name'));
            $data['short_name'] = htmlentities($this->input->post('short_name'));
            $data['store_add1'] = htmlentities($this->input->post('store_add1'));
            $data['store_add2'] = htmlentities($this->input->post('store_add2'));
            $data['store_city'] = htmlentities($this->input->post('store_city'));
            $data['store_state'] = htmlentities($this->input->post('store_state'));
			
            $data['store_zip'] = htmlentities($this->input->post('store_zip'));
            $data['store_phone'] = htmlentities($this->input->post('store_phone'));
            $data['store_email'] = htmlentities($this->input->post('store_email'));
			$NewPass=$this->input->post('store_password');
			if($NewPass!="") $data['store_password'] = base64_encode($this->input->post('store_password'));
            $data['store_tax_no'] = htmlentities($this->input->post('store_tax_no'));
            
            $data['show_hide'] = htmlentities($this->input->post('show_hide'));
			$store_main=$this->input->post('store_main');
			if($store_main=="yes") 
					{	$this->db->set('store_main','');
						$this->db->update('stores');
						$data['store_main'] = htmlentities($store_main);
					}
           
            $data['store_taxable'] = htmlentities($this->input->post('store_taxable'));
			$data['remarks'] = htmlentities($this->input->post('remarks'));
			$this->db->where('id' , $param2);
			
			if($this->db->update('stores' , $data)===TRUE)		// using direct parameter
			{					
			?>
			<script> alert("<?php echo lang('record_update'); ?>"); </script>
			<?php
				redirect('stores/index','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('stores')===TRUE)		// using direct parameter
			{
			?>
			<script> alert("<?php echo lang('record_delete'); ?>"); </script>
			<?php
			redirect('stores/index','refresh');
			}	
		}
		
	}
	
	public function assign_store()
	{  if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','settings');
		$this->session->set_userdata('submenu','stores');
		$this->db->order_by("id","desc");
		$store['storedata'] = $this->db->get('stores');
		$this->load->view('stores/store_assign',$store);
	}	
	
	
	
	
}		//Class Stores Controller End	