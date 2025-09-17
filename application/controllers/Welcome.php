<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 30 May, 2017
	 *	Laundry Management Application
	 *	ajitrajyash@gmail.com
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
	{	if ($this->session->userdata('admin_login') == 0) redirect('login');
	    $this->session->set_userdata('menu','dashboard');
		$this->session->set_userdata('submenu','');
		$this->db->from('customer_order');
		$this->db->order_by("total_paid", "desc");
		$desktop['order_data'] = $this->db->get();
		$desktop['userdata'] = $this->db->get('users');
		$desktop['today']=date('j-m-Y');
		//$this->load->view('admin/header');
		$this->load->view('admin/main',$desktop);
		$this->load->view('admin/footer');
	}


	function update_mobile()
	{
		
		$usersData=$this->db->get('users')->result();

		foreach($usersData as $urow)
		{
			echo "<br/>->";
			echo $custMobile= $urow->mobile;
			$custMobile=str_replace(' ', '', $custMobile);
			echo "=>";
			echo $custMobile=ltrim($custMobile, "0"); 

			$data['mobile']=$custMobile;
			$this->db->where('id',$urow->id);
			if($this->db->update('users',$data)==TRUE){ echo "mobile updates <br/>"; }	
		}	
	}
	
}
