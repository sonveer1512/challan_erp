<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('transport_model');
      	$this->load->model('transfer_model');
		$this->load->model('log_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
  public function index(){
  		
          $getdata['data'] = $this->transfer_model->get_project();
    $this->load->view('project/list',$getdata);
  }
  public function add(){
		//get All Category  to display list
		
		$this->load->view('project/add');
		
	} 
  public function addproject(){
  		$data = array(
          "p_name"     	=>$this->input->post('p_name'),
          "location"		=>$this->input->post('location'),
          "site_encharge"	=>$this->input->post('site_encharge'),
          "contact"			=>$this->input->post('contact'),
        );
    
          $rand = rand(1000, 9999);
        if ($_FILES['image']['name']) {
            $file = $rand . $_FILES['image']['name'];
            $data['image'] = "assets/project/" . basename($file);
            move_uploaded_file($_FILES['image']['tmp_name'], "assets/project/" . $file);
        }
    
    	$add = $this->transfer_model->projectadd($data);
    	
			if($add){ 
				
				$this->session->set_flashdata('Project Added Successfully.');
				redirect('project','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'something went wrong');
				redirect("project",'refresh');
			}
        	
  }
  public function edit($id){
  	 $getdata['data'] = $this->transfer_model->get_edit_project($id);
    $this->load->view('project/edit',$getdata);
  
  }
  public function projectedit(){
  	$id = $this->input->post('id');
    $data = array(
          "p_name"     	=>$this->input->post('p_name'),
          "location"		=>$this->input->post('location'),
          "site_encharge"	=>$this->input->post('site_encharge'),
          "contact"			=>$this->input->post('contact'),
        );
    
          $rand = rand(1000, 9999);
        if ($_FILES['image']['name']) {
            $file = $rand . $_FILES['image']['name'];
            $data['image'] = "assets/project/" . basename($file);
            move_uploaded_file($_FILES['image']['tmp_name'], "assets/project/" . $file);
        }
    
    	$add = $this->transfer_model->update_project($data,$id);
    	
			if($add){ 
				
				$this->session->set_flashdata('Project Updated Successfully.');
				redirect('project','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'something went wrong');
				redirect("project",'refresh');
			}
  
  }
  public function projectdelete($id){
    	 $delete = $this->transfer_model->project_delete($id);
       
      
      if($delete){ 
				
				$this->session->set_flashdata('delete Successfully.');
				redirect('project','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'something went wrong.');
				redirect("project",'refresh');
			}
    }
  
  
  }
?>