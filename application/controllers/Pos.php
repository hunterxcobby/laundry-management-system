<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CI_Controller {

	/*
	 *	@author 	: Red Planet Computers Team / 8108702999
	 *	date		: 27 Feb, 2018
	 *	Laundry Management Application (Quick PoS)
	 *	rpcits2013@gmail.com
	*/
 
	public function __construct()
    {   parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
		date_default_timezone_set($this->db->get_where('settings' , array('id' =>'1'))->row()->sys_timezone);
      	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 11 Jun 1983 05:00:00 GMT");
		
    }
	
	public function index($param1='', $param2='')
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');

		$this->session->set_userdata('submenu','pricelist');

	if($param1=="employee") {
		$this->session->set_userdata('party_name','');
		
		$this->session->set_userdata('UpdateOrder','add_order');
		
		$this->session->set_userdata('order_auto_id','');
		
		$this->session->set_userdata('orderfrom',$param1);

		}
		
		// update  cloth and service name with id
		$priceList=$this->db->get('price_list')->result();
		foreach($priceList as $priceRow)
		{
			$priceClothId=$priceRow->cloth_id;
			$clothName=$this->db->get_where('cloths',array('id'=>$priceClothId))->row()->cloth_type;
			$priceClothUpdate['cloth_name']=$clothName;
			$this->db->where('id' , $priceRow->id);
			if($this->db->update('price_list' , $priceClothUpdate)===TRUE) {}		// using direct parameter

		}	
		//End update
		

		$this->db->order_by("priority");
		$this->db->where('show_hide', 'show');
		$data['laundry_service'] = $this->db->get('services');
		$data['laundry_cloth'] = $this->db->get('cloths');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('users')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;

		if($param1=="employee") redirect('pos/employee','refresh');
		
		$this->load->view('cart_pos',$data);
	}
	
	function employee()
	{	if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		$this->session->set_userdata('menu','services');
		$this->session->set_userdata('submenu','pricelist');
		$this->db->order_by("priority");
		$data['laundry_service'] = $this->db->get('services');
		$data['laundry_cloth'] = $this->db->get('cloths');
		$data['last_id']=0;	
		$result=$this->db->select('*')->from('users')->order_by('id',"desc")->limit(1)->get()->result();
		if (count($result) > 0)	$data['last_id'] = $result[0]->id;
		$this->load->view('mobile/cart_pos_emp',$data);
	}
	
	
	function add($param1='', $param2='')
	{	$GarmentKgName=serialize($this->input->post('gar_desc_kg'));
		$GarmentKgQty=serialize($this->input->post('gar_desc_qty'));
		$param2=$this->session->userdata('orderfrom');
		$product_ids = array();
		//check if Add to Cart button has been submitted
		if(filter_input(INPUT_POST, 'add_to_cart')){
			if(isset($_SESSION['shopping_cart'])){
				$_SESSION['partyname'] = filter_input(INPUT_POST, 'party_name');
				//keep track of how mnay products are in the shopping cart
				$count = count($_SESSION['shopping_cart']);
				
				//create sequantial array for matching array keys to products id's
				$product_ids = array_column($_SESSION['shopping_cart'], 'id');
				
				if (!in_array($param1, $product_ids)){
				$_SESSION['shopping_cart'][$count] = array
					(	
						'id' => $param1,
						'product_id' => filter_input(INPUT_POST, 'product_id'),
						'name' => filter_input(INPUT_POST, 'name'),					// product short code
						'price' => filter_input(INPUT_POST, 'newprice'),
						'quantity' => filter_input(INPUT_POST, 'quantity'),
						'pack' => filter_input(INPUT_POST, 'gar_pack'),			// product pack
						'starch' => filter_input(INPUT_POST, 'gar_starch'),			// product starch
						'defect' => filter_input(INPUT_POST, 'gar_defects'),			// product defect
						'color' => filter_input(INPUT_POST, 'gar_color'),			// product color
						'brand' => filter_input(INPUT_POST, 'gar_brands'),			// product brand
						'unit' => filter_input(INPUT_POST, 'gar_unit'),			// product unit
						'kgitem' => $GarmentKgName,			// product Garment Names
						'kgqty' => $GarmentKgQty		// product Gament Qty
						
						
					);   
				}
				else { //product already exists, increase quantity
					//match array key to id of the product being added to the cart
					for ($i = 0; $i < count($product_ids); $i++){
						if ($product_ids[$i] == $param1){
							//add item quantity to the existing product in the array
							$_SESSION['shopping_cart'][$i]['quantity'] = filter_input(INPUT_POST, 'quantity');
							$_SESSION['shopping_cart'][$i]['price'] = filter_input(INPUT_POST, 'newprice');
							$_SESSION['shopping_cart'][$i]['pack'] = filter_input(INPUT_POST, 'gar_pack');
							$_SESSION['shopping_cart'][$i]['starch'] = filter_input(INPUT_POST, 'gar_starch');
							$_SESSION['shopping_cart'][$i]['defect'] = filter_input(INPUT_POST, 'gar_defects');
							$_SESSION['shopping_cart'][$i]['color'] = filter_input(INPUT_POST, 'gar_color');
							$_SESSION['shopping_cart'][$i]['brand'] = filter_input(INPUT_POST, 'gar_brands');
							$_SESSION['shopping_cart'][$i]['unit'] = filter_input(INPUT_POST, 'gar_unit');
							$_SESSION['shopping_cart'][$i]['kgitem'] = $GarmentKgName;
							$_SESSION['shopping_cart'][$i]['kgqty'] = $GarmentKgQty;
						}
					}
				}
				
			}
			else { //if shopping cart doesn't exist, create first product with array key 0
				//create array using submitted form data, start from key 0 and fill it with values
				$_SESSION['shopping_cart'][0] = array
				(
					'id' => $param1,
					'product_id' => filter_input(INPUT_POST, 'product_id'),
					'name' => filter_input(INPUT_POST, 'name'),					// product short code
					'price' => filter_input(INPUT_POST, 'newprice'),
					'quantity' => filter_input(INPUT_POST, 'quantity'),
					'pack' => filter_input(INPUT_POST, 'gar_pack'),			// product pack
					'starch' => filter_input(INPUT_POST, 'gar_starch'),			// product starch
					'defect' => filter_input(INPUT_POST, 'gar_defects'),			// product defect
					'color' => filter_input(INPUT_POST, 'gar_color'),			// product color
					'brand' => filter_input(INPUT_POST, 'gar_brands'),			// product brand
					'unit' => filter_input(INPUT_POST, 'gar_unit'),			// product unit
					'kgitem' => $GarmentKgName,			// product unit
					'kgqty' => $GarmentKgQty		// product unit
				);
			}
		}
		
		
		if($param2=="employee") redirect('pos/employee','refresh');
		redirect('pos','refresh');
		/*
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		*/
		

	}
	
	
	function update($param1='',$param2='')
	{	
		$Party_Name = $this->db->get_where('customer_order' , array('auto_id' => $param1) )->row()->customer_id;
		
		$this->session->set_userdata('party_name',$Party_Name);
		
		$this->session->set_userdata('UpdateOrder','update_order');
		
		$this->session->set_userdata('order_auto_id',$param1);
		
		$this->session->set_userdata('orderfrom',$param2);
		
		$_SESSION['shopping_cart'] = unserialize($this->db->get_where('customer_order' , array('auto_id' => $param1) )->row()->service_tax);
		
		if($param2=="employee") redirect('pos/employee','refresh');
				
		redirect('pos','refresh');
		
	}
	
	function remove($param1='', $param2='')
	{	//echo $param1;
		$param2=$this->session->userdata('orderfrom');
		//loop through all products in the shopping cart until it matches with GET id variable
		foreach($_SESSION['shopping_cart'] as $key => $product){
				if ($product['id'] == $param1){
				//remove product from the shopping cart when it matches with the GET id
				unset($_SESSION['shopping_cart'][$key]);
				}
			}
			//reset session array keys so they match with $product_ids numeric array
			$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
		
		if($param2=="employee") redirect('pos/employee','refresh');
		
		redirect('pos','refresh');
		/*
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		*/
		

	}
	
	
	// Customer Charges 
	
	function cust_charges($charge1='', $charge2='')
	{	
		
		if($charge1=="selection")
		{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$this->db->order_by("transaction");
		
		$data['charges_list'] = $this->db->get_where('tax_charges' , array('coupon' =>'') );
		
		$data['coupon_list'] = $this->db->get_where('tax_charges' , array('coupon' =>'yes') );
		
		$data['party_name'] = $this->input->post('custname');
		
		$data['promocode']= $charge2;
		
		$this->load->view('admin/customer_charges',$data);
		}
		
		if($charge1=="updating")
		{	
			$cust_charge=$this->input->post('cust_charges');
			$custcharges=serialize($cust_charge);
			$data['cust_charges'] = $custcharges;
			
			$this->db->where('id' , $charge2);
			
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{	
				$param2=$this->session->userdata('orderfrom');
				if($param2=="employee") redirect('pos/employee','refresh');
				redirect('pos','refresh');
			}
		}
		
	}

	
	function cust_discount($disc1='', $disc2='')
	{	
		
		if($disc1=="create")
		{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		
		$data['party_name'] = $this->input->post('custname');
		
		$this->load->view('admin/customer_discount',$data);
		}
		
		if($disc1=="updating")
		{	
			$id=$this->session->userdata('party_name');
	
			$data['cust_discount'] = $this->input->post('charge_value');
			
			if($disc2=="remove") $data['cust_discount']="0.00";
			
			$this->db->where('id' , $id);

						
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{	$param2=$this->session->userdata('orderfrom');
				if($param2=="employee") redirect('pos/employee','refresh');
				redirect('pos','refresh');
			}
		}
		
	}	
	
	function cust_extra_charge($excharge1='', $excharge2='')
	{	
		
		if($excharge1=="create")
		{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		
		$data['party_name'] = $this->input->post('custname');
		
		$this->load->view('admin/customer_discount',$data);
		}
		
		if($excharge1=="updating")
		{	
			$id=$this->session->userdata('party_name');
	
			$data['cust_extra_charge'] = $this->input->post('extra_charge_value');
			
			if($excharge2=="remove") $data['cust_extra_charge']="0.00";
			
			$this->db->where('id' , $id);

						
			if($this->db->update('users' , $data)===TRUE)		// using direct parameter
			{	$param2=$this->session->userdata('orderfrom');
				if($param2=="employee") redirect('pos/employee','refresh');
				redirect('pos','refresh');
			}
		}
		
	}	
	
	function cust_remarks($param1='', $param2='')
	{	
		
		if($param1=="create")
		{	
		if ($this->session->userdata('admin_login') == 0) redirect('login/logout');
		
		$data['party_name'] = $this->input->post('custname');
		
		$this->load->view('admin/customer_remarks',$data);
		}
		
		if($param1=="save")
		{	
			$TempOrderRemarks= $this->input->post('remarks');
			$this->session->set_userdata('order_remark',$TempOrderRemarks);
			$param2=$this->session->userdata('orderfrom');
			if($param2=="employee") redirect('pos/employee','refresh');
			redirect('pos','refresh');
		}
	
	}
	
	
	// Customer Garment Details & Selection 
	
	function garment($param1='', $param2='')
	{	$key="";
		if(isset($_SESSION['shopping_cart'])){
		
		$chkcart=$_SESSION['shopping_cart'];
		$key = array_search($param2, array_column($chkcart, 'id'));
		
		}
		
		if($param1=="selection")
		{	$garment['garment_data'] = $this->db->get_where('price_list' , array('id' => $param2) )->result();
	
			if($key===0 or $key>0 ) { $this->load->view('admin/garment_updation',$garment); }
			
			else { $this->load->view('admin/garment_selection',$garment); }
			
		}
		
		if($param1=="updation")
		{
		$garment['garment_data'] = $this->db->get_where('price_list' , array('id' => $param2) )->result();
		$this->load->view('admin/garment_updation',$garment);
		}
		
	}	
	
	
	
	
	
}		//Class Pos Controller End	