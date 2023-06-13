<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> 
                <!-- Dashboard -->
                <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('payment_method'); ?>">
              Payment Method
              <!-- <?php echo $this->lang->line('customer_header'); ?> --></a>
          </li>
          <li class="active">Edit Payment Method
              
          </li>
        </ol>
      </h5>    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
               Edit Payment Method
                <!-- <?php echo $this->lang->line('add_customer_header'); ?> -->
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('payment_method/edit');?>">
                <div class="col-md-6">
                <input type="hidden" placeholder="name" class="form-control" name="id" value="<?php echo $data->id;?>">
                    <div class="form-group">
                    <label class="control-label require" for="inputEmail3">
                       Name
                    </label>
                        
                        <input type="text" placeholder="" class="form-control" id="name" name="name" value="<?php echo $data->name?>">
                        <span id="name" style="color: red"><?php echo form_error('name');?></span>
                        <p style="color:#990000;"></p>
                      
                    </div>

                  <div class="form-group">
                    <label class="control-label require" for="inputEmail3">
                      Default 
                    </label>
                        
                          <select class="form-control valdation_select" name="default" value="<?php echo $data->default; ?>" tabindex="2" onblur='chkDrop("Form","default","Please Select");'>
                              <?php if($data->default == "Yes"){ ?>
                              
                                   <option checked>
                                    Yes 
                                      
                                    </option>
                                   <option value="No">
                                     No 
                                   
                                    </option>  
                                   <?php } ?> 
  

                                  <?php if($data->default == "No"){ ?>
                                  <option value="Yes">
                                    Yes
                                     
                                  </option>
                                  <option checked>
                                    No
                                    
                                  </option>
                                    <?php } ?>
                             </select>
                              <span  style="color: red"><?php echo form_error('default');?></span>
                              <span style="font-size:20px;"></span>
                              <p style="color:#990000;"></p>
                        
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;Update
                        </button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('payment_method')"><!-- Cancel -->
                      <?php echo $this->lang->line('add_user_btn_cancel'); ?></span>
                  </div>
                </div>
              </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('layout/footer');
  ?>
