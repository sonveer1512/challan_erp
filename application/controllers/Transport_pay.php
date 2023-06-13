<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport_setting extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('transport_model');
		$this->load->model('log_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		//get All Category  to display list
		
		$this->load->view('transport_pay/list');
		
	} 
  public function add(){
		$this->load->view('transport_pay/add');
	}
 public function addCategory(){
        $this->form_validation->set_rules('vehicle_number', 'Vehicle Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('driver_name', 'Driver Name', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
			$data = array(
						"driver_name"=>$this->input->post('driver_name'),
						"vehicle_number"=>$this->input->post('vehicle_number'),
						"vehicle_type"	=>$this->input->post('vehicle_type'),
						"capacity"		=>$this->input->post('capacity')
					);

			if($id = $this->transport_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Vehicle Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('transport_setting','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Vehicle can not be Inserted.');
				redirect("transport_setting",'refresh');
			}
        }	
		
	}
	
	
}
?>