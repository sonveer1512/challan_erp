<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {        
	public function __construct()    {  
		parent::__construct();    
	}	 


	public function index()    {           
        if(!empty($this->session->userdata('usersession_id'))) { redirect('dashboard'); }  
        $this->load->view('userpanel/index.php');   
    }           


    public function login() {  
        $this->form_validation->set_rules('email', 'Email', 'trim|required');        
        $this->form_validation->set_rules('password', 'Password', 'required');                
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');                
        if($this->form_validation->run() == false){            
            $response = array('status' => false, 'type' => 'warning', 'msg' => "<b> Warning: </b> Please Enter Mandatory Fields");          
        }else {            
            $email = $this->security->xss_clean($this->input->post('email'));             
            $password = $this->security->xss_clean($this->input->post('password'));                        
            $user = $this->admin_model->login2($email, md5($password));   
            if(!empty($user)) {                
                $userdata = array('usersession_id' => $user->id,                    
                                  'email' => $user->email_id,                    
                                  'user_type' => $user->user_type,                    
                                  'authenticated' => TRUE                
                                );                                
                $this->session->set_userdata($userdata);                
                
                $response = array('status' => true);          

            }else {                                
                $response = array('status' => false, 'type' => 'error', 'msg' => "<b> Error: </b> Wrong Credentials");   
            }        
        }    

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('./userpanel');
    }


    public function error404() {
        $this->load->view('errors/404.php'); 
    }


}

?>