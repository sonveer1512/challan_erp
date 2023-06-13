<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Allchallan extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('challan_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('sales_model');
		$this->load->model('log_model');
		$this->load->model('product_model');
		$this->load->model('ion_auth_model');
		$this->load->model('purchase_return_model');
     	 $this->load->model('transfer_model');
		if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}
	public function index(){
      	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		$data['data'] = $this->challan_model->getQuotation();
      	//echo $this->db->last_query();exit;
    	$this->load->view('allchallan/list',$data);
	}
  
  
  
} 
  ?>