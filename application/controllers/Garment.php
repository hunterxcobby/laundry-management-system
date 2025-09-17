<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Garment extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers Team / 8767228990
	 *	date		: 15 April, 2018
	 *	Laundry Management Application (Garments)
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
		$this->session->set_userdata('menu','garment');
		$this->session->set_userdata('submenu','gar_type');
		
	}
	
	// Garment Brand Controller ==>
	
	function gar_brand()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','garment');
		$this->session->set_userdata('submenu','gar_brand');
		$this->db->order_by("id","desc");
		$data['brand'] = $this->db->get('garment_brand');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('garment_brand')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;

		$this->load->view('garment/garment_brand',$data);
	}
	
	function brand_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$brand_name=ucwords($this->input->post('brand_name'));
			$brand_remark=$this->input->post('remarks');
			$data = array('brand_name' => $brand_name, 'brand_remark' => $brand_remark );
			if($this->db->insert('garment_brand', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Added Successfully"); </script>
			<?php
			redirect('garment/gar_brand','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['brand_edit'] = $this->db->get_where('garment_brand' , array('id' => $param2) )->result();
			$this->load->view('garment/garment_brand_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['brand_name']= ucwords($this->input->post('brand_name'));
            $data['brand_remark'] = $this->input->post('remarks');
			$this->db->where('id' , $param2);
			
			if($this->db->update('garment_brand' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
				redirect('garment/gar_brand','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('garment_brand')===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Deleted Successfully"); </script>
			<?php
			redirect('garment/gar_brand','refresh');
			}	
		}
	}
	
	
	// Garment Defects Controller ==>
	
	function gar_defect()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','garment');
		$this->session->set_userdata('submenu','gar_defects');
		$this->db->order_by("id","desc");
		$data['defect'] = $this->db->get('garment_defect');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('garment_defect')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;

		$this->load->view('garment/garment_defect',$data);
	}
	
	function defect_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$defect_name=ucwords($this->input->post('defect_name'));
			$defect_remark=$this->input->post('remarks');
			$data = array('defect_name' => $defect_name, 'defect_remark' => $defect_remark );
			if($this->db->insert('garment_defect', $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Added Successfully"); </script>
			<?php
			redirect('garment/gar_defect','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['defect_edit'] = $this->db->get_where('garment_defect' , array('id' => $param2) )->result();
			$this->load->view('garment/garment_defect_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['defect_name']= ucwords($this->input->post('defect_name'));
            $data['defect_remark'] = $this->input->post('remarks');
			$this->db->where('id' , $param2);
			
			if($this->db->update('garment_defect' , $data)===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
				redirect('garment/gar_defect','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('garment_defect')===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Deleted Successfully"); </script>
			<?php
			redirect('garment/gar_defect','refresh');
			}	
		}
	}
	
	// Garment Colors Controller ==>
	
	function gar_color()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','garment');
		$this->session->set_userdata('submenu','gar_colors');
		$this->db->order_by("id","desc");
		$data['color'] = $this->db->get('garment_color');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('garment_color')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;

		$this->load->view('garment/garment_color',$data);
	}
	
	function color_crud($param1='', $param2='')
	{	if($param1=='create')
		{	$color_name=ucwords($this->input->post('color_name'));
			$color_remark=$this->input->post('remarks');
			$data = array('color_name' => $color_name, 'color_remark' => $color_remark );
			if($this->db->insert('garment_color', $data)===TRUE)		// using direct parameter
			{   $UpImage=$this->db->insert_id();
				move_uploaded_file($_FILES['color_image']['tmp_name'], 'assets/gcolors/' . $UpImage . '.png');
			?>
			<script> alert(" Record Added Successfully"); </script>
			<?php
			redirect('garment/gar_color','refresh');
			}	
		}
		
		if($param1=='do_update')
		{	$query['color_edit'] = $this->db->get_where('garment_color' , array('id' => $param2) )->result();
			$this->load->view('garment/garment_color_update',$query);
		}
		
		if ($param1 == 'modify') 
		{   $data['color_name']= ucwords($this->input->post('color_name'));
            $data['color_remark'] = $this->input->post('remarks');
			$this->db->where('id' , $param2);
			
			if($this->db->update('garment_color' , $data)===TRUE)		// using direct parameter
			{	move_uploaded_file($_FILES['color_image']['tmp_name'], 'assets/gcolors/' . $param2 . '.png');
			?>
			<script> alert(" Record Updated Successfully"); </script>
			<?php
				redirect('garment/gar_color','refresh');
			}
		}
		
		if($param1=='delete')
		{	$this->db->where('id' , $param2);
            if($this->db->delete('garment_color')===TRUE)		// using direct parameter
			{
			?>
			<script> alert(" Record Deleted Successfully"); </script>
			<?php
			redirect('garment/gar_color','refresh');
			}	
		}
	}
	
	
	
	
	
}		//Class Garment Controller End	