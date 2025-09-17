<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *	@author 	: Ajit Dhanawade / 8108702999
 *	date		: 07 June, 2017
 *	Laundry Management Application
 *	ajitrajyash@gmail.com
 */
 
class Login_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function get_user($email, $pwd)
	{
		$this->db->where('username', $email);
		$this->db->where('password', sha1($pwd));
        $query = $this->db->get('admin');
		return $query->result();
	}
	
	function get_store($email, $pwd)
	{
		$this->db->where("store_email = '$email' OR store_phone = '$email'");
		$this->db->where('store_password', base64_decode($pwd));
		$store_result = $this->db->get('stores');
		return $store_result->result();
	}
	
}
?>