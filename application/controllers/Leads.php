<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('session_id'))) { redirect('index'); }  
    }

    public function list(){
        $tasklist = $this->admin_model->list_common('leadmaster','lead_id');
        $data["lead"] = $tasklist;

        $this->load->view('includes/header.php'); 
        $this->load->view('leads/list.php',$data); 
        $this->load->view('includes/footer.php'); 
    }


    public function add() {
        $this->form_validation->set_rules('cname', "Name", 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'msg' => "Enter Mandatory Fields", 'type' => 'Warning');
        } else {
            
            $data['cname'] = $this->security->xss_clean($this->input->post('cname'));
            $data['cgoingTo'] = $this->security->xss_clean($this->input->post('cgoingTo'));
            $data['cmobile'] = $this->security->xss_clean($this->input->post('cmobile'));
            $data['cmail'] = $this->security->xss_clean($this->input->post('cmail'));
            $data['creservationDate'] = $this->security->xss_clean($this->input->post('creservationDate'));
            $data['cnoDays'] = $this->security->xss_clean($this->input->post('cnoDays'));
            $data['cfrom'] = $this->security->xss_clean($this->input->post('cfrom'));   

            $saved = $this->admin_model->insert_common('leadmaster',$data);  

            $followup = $this->security->xss_clean($this->input->post('followup'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $followup_dis = $this->security->xss_clean($this->input->post('followup_dis'));

            if(!empty($this->input->post('followup_dis'))) {
                $client_msg = $this->security->xss_clean($this->input->post('followup_dis'));
            }else {
                $client_msg = '';
            }

            date_default_timezone_set('Asia/Kolkata');
            $create_date = date('Y-m-d H:i:s');

            if(!empty($followup)) {
                $session_id = $this->session->userdata('session_id');

                $datas = array('lead_id' => $saved, 'followup_id' => $followup, 'followup_text' => $followup_dis, 'followup_date' => $date, 'created_by' => $session_id, 'create_date' => $create_date);
                $saved = $this->admin_model->insert_common('followupstatusmaster',$datas);
            }     

            if(!empty($saved)) {
                $response = array('status' => true, 'type' => 'Success', 'msg' => "Lead Added Successfully");
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    public function showfollowupdetails($id)
    {      
        $data['followup_details'] = $this->admin_model->list_common_where3('followup','followup_id',$id);  
        $this->load->view('followup/edit.php',$data);         
    } 


    public function edit() {
        $this->form_validation->set_rules('followup_name', "Followup", 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'msg' => "Enter Mandatory Fields", 'type' => 'Warning');
        } else {
            
            $id = $this->input->post('followup_id');
            $data['followup_name'] = $this->input->post('followup_name');
            $saved = $this->admin_model->update_common('followup',$data,'followup_id',$id);  

            if(!empty($saved)) {
                $response = array('status' => true, 'type' => 'Success', 'msg' => "Followup Details Updated Successfully");
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function deactivate($id){       
        $data = array('flag' => '1');
        $this->admin_model->update_common('followup',$data,'followup_id',$id);

        $this->session->set_flashdata('deactivate_message', 'Deactivated Successfully');
        redirect('followup/list');
    }

    public function activate($id){       
        $data = array('flag' => '0');
        $this->admin_model->update_common('followup',$data,'followup_id',$id);

        $this->session->set_flashdata('activate_message', 'Activated Successfully');
        redirect('followup/list');
    }


    public function showban() {
        $id = $this->input->get('id');
        $dept = $this->admin_model->list_common_where3('followup','followup_id',$id);

        $output = '<div id="delete_department" class="modal fade delete_modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content modal-md">
                                <div class="modal-header">
                                    <h6 class="modal-title"> Deactivate Followup</h6>
                                </div>
                                <div class="modal-body card-box">
                                    <p>Are you sure to deactivate <b>'.$dept[0]['followup_name'].'</b></p>
                                    <div class="m-t-20 text-left">
                                        <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                        <a role="button" class="btn btn-danger" href="'.base_url().'followup/deactivate/'.$id.'">Deactivate</a>
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
        $dept = $this->admin_model->list_common_where3('followup','followup_id',$id);

        $output = '<div id="delete_department" class="modal fade approved_modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content modal-md">
                                <div class="modal-header">
                                    <h6 class="modal-title"> Activate Followup </h6>
                                </div>
                                <div class="modal-body card-box">
                                    <p>Are you sure to activate <b>'.$dept[0]['followup_name'].'</b> ? </p>
                                    <div class="m-t-20 text-left">
                                        <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                        <a role="button" class="btn btn-success" href="'.base_url().'followup/activate/'.$id.'">Activate</a>
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








    public function addfileforservice()
    {        
        require_once APPPATH . "./third_party/PHPExcel.php";
        $path = './uploads/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|xls';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);      

        if (!$this->upload->do_upload('uploadFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
        }

        if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }

        $inputFileName = $path . $import_xls_file;
    
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $flag = true;
            $i=0;

            foreach ($allDataInSheet as $value) {

                if($flag){
                    $flag =false;
                    continue;
                }

                if(!empty($value['B'])) { $inserdata['name']             = $value['B']; } 
                if(!empty($value['C'])) { $inserdata['address']          = $value['C']; }
                if(!empty($value['D'])) { $inserdata['city']             = $value['D']; }
                if(!empty($value['E'])) { $inserdata['state']            = $value['E']; }
                if(!empty($value['F'])) { $inserdata['website']          = $value['F']; }
                if(!empty($value['G'])) { $inserdata['contact_person']   = $value['G']; }
                if(!empty($value['H'])) { $inserdata['designation']      = $value['H']; }
                if(!empty($value['I'])) { $inserdata['contact_number']   = $value['I']; }
                if(!empty($value['J'])) { $inserdata['mobile_number']    = $value['J']; }
                if(!empty($value['K'])) { $inserdata['email']            = $value['K']; }
                if(!empty($value['L'])) { $inserdata['contact_person']   = $value['L']; }
                if(!empty($value['M'])) { $inserdata['designation']      = $value['M']; }
                if(!empty($value['N'])) { $inserdata['contact_number']   = $value['N']; }
                if(!empty($value['O'])) { $inserdata['mobile_number']    = $value['O']; }
                if(!empty($value['P'])) { $inserdata['email']            = $value['P']; }

                $inserdata['assign_user_id'] = $this->input->post('employee');

                $result = $this->admin_model->insert_common('leadmaster', $inserdata);   

                $i++;
            }          

            if(!empty($result)) {
                $response = array('status' => true, 'type' => 'Success', 'msg' => "Lead Added Successfully");
            }else{
                $response = array('status' => false, 'type' => 'Error', 'msg' => "Something Went Wrong! Try Again Later");
            }        

        } catch (Exception $e) {
           die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' .$e->getMessage());
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }





    


}

?>