<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Web extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers / 8767228990
	 *	date		: 12 June, 2020
	 *	Laundry Management Application (New Web Model)
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
	{	$this->session->set_userdata('webmenu','home');
		$this->load->view('webnew/web_main','refresh');
	}	
	
		
	
	function pricing()
	{
		$this->session->set_userdata('webmenu','price');
		$this->load->view('webnew/web_pricing', 'refresh');
	}
}
