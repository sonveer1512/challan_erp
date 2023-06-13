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
		$data['data'] = $this->transport_model->getCategory();
		$this->load->view('transport/list',$data);
		
	} 
	
	/* 
		call Add view to add category  
	*/
	public function add(){
		$this->load->view('transport/add');
	}

	/* 
		this function is used to count the number of category 
	*/
	public function getCategoryCount(){
		return sizeof($this->transport_model->getCategoryCount());
	}

	/*
		add category using ajax
	*/
	public function add_category_ajax(){
		$data = array(
					"driver_name"=>$this->input->post('driver_name'),
					"vehicle_number"=>$this->input->post('vehicle_number'),
					"vehicle_type"	=>$this->input->post('vehicle_type'),
					"capacity"		=>$this->input->post('capacity')
				);
		$id = $this->transport_model->addModel($data);
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Vehicle Inserted'
			);
		$this->log_model->insert_log($log_data);

		$data['data'] = $this->transport_model->getCategory();
		$data['id'] = $id;
		echo json_encode($data);
		
	} 
	/* 
		This function used to store category record in database  
	*/
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
	/* 
		call edit view to edit Category Record 
	*/
	public function edit($id){
		$data['data'] = $this->transport_model->getRecord($id);
		$this->load->view('transport/edit',$data);
	}
	/* 
		This function is used to edit category record in database 
	*/
	public function editCategory(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('vehicle_number', 'Vehicle Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('driver_name', 'Driver Name', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
			$data = array("driver_name"=>$this->input->post('driver_name'),
						  "vehicle_number"  =>$this->input->post('vehicle_number'),
						  "vehicle_type"	=>$this->input->post('vehicle_type'),
						  "capacity"		=>$this->input->post('capacity')
						  );
			if($this->transport_model->editModel($data,$id)){

				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Vehicle Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('transport_setting','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Vehicle can not be Updated.');
				redirect("transport_setting",'refresh');
			}
		}
	}
	/* 
		Delete selected  Category Record 
	*/
	public function delete($id){
		if($this->transport_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Vehicle Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('transport_setting');
		}
		else{
			$this->session->set_flashdata('fail', 'Vehicle can not be Deleted.');
			redirect("transport_setting",'refresh');
		}
	}

	function alpha_dash_space($str) {
		if (! preg_match("/^([-a-zA-Z ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha, spaces and dashes.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>