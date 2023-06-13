<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('enc_lib');   
        if(empty($this->session->userdata('session_id'))) { redirect('index'); }  
    }

    public function list(){
        $data['user'] = $this->admin_model->list_common('user');

        $this->load->view('includes/header.php',$data); 
        $this->load->view('user/list.php',$data); 
        $this->load->view('includes/footer.php'); 
    } 


    public function add() {
        $this->form_validation->set_rules('name', "Name", 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'msg' => "Enter Mandatory Fields", 'type' => 'Warning');
        } else {
            
            $data['username']           = $this->input->post('username');
            $data['name']           = $this->input->post('name');
            $data['phone']          = $this->input->post('mobile');
            $data['email_id']       = $this->input->post('email');
            $data['user_type']      = 'employee';
            $data['password']       = md5($this->input->post('password'));

            $saved = $this->admin_model->insert_common('user',$data);  

            if(!empty($saved)) {
                $response = array('status' => true, 'type' => 'Success', 'msg' => "User Added Successfully");
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    public function showuserdetails($id) {      
        $data['user_details'] = $this->admin_model->list_common_where3('user','id',$id);  
        $this->load->view('user/edit.php',$data);         
    } 

    public function showchangepassword($id) {      
        $data['user_details'] = $this->admin_model->list_common_where3('user','id',$id);  
        $this->load->view('user/change_password.php',$data);         
    } 


    public function edit() {
        $this->form_validation->set_rules('name', "Name", 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'msg' => "Enter Mandatory Fields", 'type' => 'Warning');
        } else {
            
            $id = $this->input->post('user_id');

            $data['username']       = $this->input->post('username');
            $data['name']           = $this->input->post('name');
            $data['phone']          = $this->input->post('mobile');
            $data['email_id']       = $this->input->post('email');

            $saved = $this->admin_model->update_common('user',$data,'id',$id);  

            if(!empty($saved)) {
                $response = array('status' => true, 'type' => 'Success', 'msg' => "Users Updated Successfully");
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    public function changepassword() {
        $this->form_validation->set_rules('current_password', "Current Password", 'required|trim');
        $this->form_validation->set_rules('confirm_password', "Confirm Password", 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'msg' => "Enter Mandatory Fields", 'type' => 'Warning');
        } else {
            
            if($this->input->post('current_password') == $this->input->post('confirm_password')) {
                $id = $this->input->post('user_id');

                $data['password']    = md5($this->input->post('current_password'));

                $saved = $this->admin_model->update_common('user',$data,'id',$id);  

                if(!empty($saved)) {
                    $response = array('status' => true, 'type' => 'Success', 'msg' => "User's Password Updated Successfully");
                }else{
                    $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
                }
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Password & Confirm Password must be same");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function deactivate($id){       
        $data = array('is_active' => '1');
        $this->admin_model->update_common('user',$data,'id',$id);

        $this->session->set_flashdata('deactivate_message', 'Deactivated Successfully');
        redirect('users/list');
    }

    public function activate($id){       
        $data = array('is_active' => '0');
        $this->admin_model->update_common('user',$data,'id',$id);

        $this->session->set_flashdata('activate_message', 'Activated Successfully');
        redirect('users/list');
    }


    public function showban() {
        $id = $this->input->get('id');
        $dept = $this->admin_model->list_common_where3('user','id',$id);

        $output = '<div id="delete_department" class="modal fade delete_modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content modal-md">
                                <div class="modal-header">
                                    <h6 class="modal-title"> Deactivate Client</h6>
                                </div>
                                <div class="modal-body card-box">
                                    <p>Are you sure to deactivate <b>'.$dept[0]['name'].'</b></p>
                                    <div class="m-t-20 text-left">
                                        <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                        <a role="button" class="btn btn-danger" href="'.base_url().'users/deactivate/'.$id.'">Deactivate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

        $response = array('status' => true, 'modal' => $output);                    

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function showapproved() {
        $id = $this->input->get('id');
        $dept = $this->admin_model->list_common_where3('user','id',$id);

        $output = '<div id="delete_department" class="modal fade approved_modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content modal-md">
                                <div class="modal-header">
                                    <h6 class="modal-title"> Activate Client </h6>
                                </div>
                                <div class="modal-body card-box">
                                    <p>Are you sure to activate <b>'.$dept[0]['name'].'</b> ? </p>
                                    <div class="m-t-20 text-left">
                                        <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                        <a role="button" class="btn btn-success" href="'.base_url().'users/activate/'.$id.'">Activate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

        $response = array('status' => true, 'modal' => $output);                    

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }




}

?>