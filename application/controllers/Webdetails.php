<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webdetails extends CI_Controller {
    public function __construct()
    {
        parent::__construct();  
        if(empty($this->session->userdata('session_id'))) { redirect('index'); }  
    }

	public function index()
    {       
        $data['webdetails'] = $this->admin_model->list_common('webdetails');   
        $this->load->view('includes/header.php',$data); 
        $this->load->view('webdetails.php',$data); 
        $this->load->view('includes/footer.php'); 
    } 


    public function adddetails() { 
        $olddata = $this->admin_model->list_common('webdetails');

        $rand = rand(1000,9999);
        if(!empty($_FILES['image']['name'])) {
            $file = $rand.$_FILES['image']['name']; 
            $data['logo'] = "assets/upload/logo/".basename($file);
            move_uploaded_file($_FILES['image']['tmp_name'], "assets/upload/logo/".$file); 
        }

        $data['title']              = $this->input->post('title');
        $data['email']              = $this->input->post('email');
        $data['mobile']             = $this->input->post('mobile');
        $data['address']            = $this->input->post('address');

        if(empty($olddata)) {
            $saved = $this->admin_model->insert_common('webdetails',$data);   
            $this->session->set_flashdata('message', 'Details Saved Successfully');
        }else{
            $saved = $this->admin_model->update_common2('webdetails',$data);      
            $this->session->set_flashdata('message', 'Details Updated Successfully');
        }

        redirect('webdetails');
    }




}



?>