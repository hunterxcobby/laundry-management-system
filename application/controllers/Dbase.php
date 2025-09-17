<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbase extends CI_Controller {

	/*
	 *	@author 	: Ajit Dhanawade / 8108702999
	 *	date		: 04 Jan, 2017
	 *	Laundry Management Application (Database Bacakup Model)
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
	{			
		$this->load->dbutil();

        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'ashishlogs.sql'
              );


        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'backup-'. date("Y-m-d-H-i-s") .'-ashishlogs.zip';
        $save = ''.base_url().'/dbase/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup); 
	}
	
	
}
