<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('usersession_id'))) { redirect('index'); }  
    }

	public function index()
    {           
        $sess = $this->session->userdata('usersession_id');
        $data['lead'] = $this->admin_model->list_common_where4('leadmaster','assign_user_id',$sess, 'lead_id');  
        $data['user'] = $this->admin_model->list_common_where3('user','user_type','employee');

        $this->load->view('userpanel/includes/header'); 
        $this->load->view('userpanel/dashboard', $data); 
        $this->load->view('userpanel/includes/footer');    
    } 


    public function changepass()    {           
        if(empty($this->session->userdata('usersession_id'))) { redirect('dashboard'); }  

        $this->load->view('userpanel/includes/header.php');   
        $this->load->view('userpanel/changepass.php');   
        $this->load->view('userpanel/includes/footer.php');   
    }  



    public function changepassword() {  
        $this->form_validation->set_rules('current_pass', 'Current Password', 'trim|required');        
        $this->form_validation->set_rules('new_pass', 'Password', 'required');                
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required');                
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');                
        if($this->form_validation->run() == false){            
            $response = array('status' => false, 'type' => 'warning', 'msg' => "<b> Warning: </b> Please Enter Mandatory Fields");          
        }else {            
            $current_pass = $this->security->xss_clean($this->input->post('current_pass'));             
            $new_pass = $this->security->xss_clean($this->input->post('new_pass'));                        
            $confirm_pass = $this->security->xss_clean($this->input->post('confirm_pass'));                     

            $email = $this->session->userdata('email');

            $user = $this->admin_model->login2($email, md5($password));   
            if(!empty($user)) {     
                if($new_pass == $confirm_pass) {

                    $data['pass'] = md5($new_pass);
                    $this->admin_model->update_common('user',$data,'email',$email);

                    $response = array('status' => true, 'type' => 'success', 'msg' => "<b> Success: </b> Password Updated");

                }else{
                    $response = array('status' => false, 'type' => 'error', 'msg' => "<b> Error:</b> Password & Confirm Password is not same");
                }
            }else {                                
                $response = array('status' => false, 'type' => 'error', 'msg' => "<b> Error: </b> Current Password is not Correct");   
            }        
        }    

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    public function showquickfollowupdiv($id)
    {      
        $data['id'] = $id;    
        $data['leadfollowup'] = $this->admin_model->list_common_where3('followupstatusmaster','lead_id',$id);
        $this->load->view('userpanel/leads/quickfollowup.php',$data);         
    } 




    public function updatelead() {
        $this->form_validation->set_rules('lead_id', "Lead Id", 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'lead_id' => form_error('lead_id')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            date_default_timezone_set('Asia/Kolkata');
            $create_date = date('Y-m-d H:i:s'); 

            if($this->session->userdata('usersession_id')) {
                $session_id = $this->session->userdata('usersession_id');
            }

            $savedata = array(
                'lead_id' => $this->input->post('lead_id'),
                'followup_date' => $this->input->post('date'),
                'followup_text' => $this->input->post('followup'),
                'client_msg' => $this->input->post('followup'),
                'created_by' => $session_id, 
                'create_date' => $create_date
            );
            $saved = $this->admin_model->insert_common('followupstatusmaster',$savedata);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'followup' => $this->input->post('followup'), 'id' => $this->input->post('lead_id'), 'followup_date' => $this->input->post('date'));
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($array));   
    }

}

?>