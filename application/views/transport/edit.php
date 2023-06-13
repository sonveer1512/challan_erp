<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('transport_setting'); ?>">Transport</a></li>
          <li class="active">Edit Transport</li>
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
              <h3 class="box-title"><!--Edit Category--> <?php echo $this->lang->line('category_lable_editcategory'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-sm-6">
                <form role="form" id="form" method="post" action="<?php echo base_url('transport_setting/editCategory');?>">

                  <?php foreach($data as $row){ ?>

                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row->id; ?>">

                    <div class="form-group">
                      <label for="driver_name">Driver name <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="driver_name" name="driver_name" value="<?php echo $row->driver_name; ?>">
                      <span class="validation-color" id="err_driver_name"><?php echo form_error('driver_name'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="vehicle_number">Vehicle Number <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="<?php echo $row->vehicle_number; ?>">
                      <span class="validation-color" id="err_vehicle_number"><?php echo form_error('vehicle_number'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="vehicle_type">Vehicle Type <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" value="<?php echo $row->vehicle_type; ?>">
                      <span class="validation-color" id="err_vehicle_type"><?php echo form_error('vehicle_type'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="capacity">Capacity</label>
                      <input type="text" class="form-control" id="capacity" name="capacity" value="<?php echo $row->capacity; ?>">
                      <span class="validation-color" id="err_capacity"><?php echo form_error('capacity'); ?></span>
                    </div>
                  <?php } ?>

                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info"><!-- Update --> <?php echo $this->lang->line('subcategory_update'); ?></button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('category')"><!-- Cancel --> <?php echo $this->lang->line('category_cancel'); ?></span>
                  </div>
                </div>
              </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
<script>
  $(document).ready(function(){
    var vehicle_number_empty = "Please Enter the Category Name.";
    var vehicle_number_invalid = "Please Enter Valid Category Name";
    var vehicle_number_length = "Please Enter Category Name Minimun 3 Character";
    $("#submit").click(function(event){
      var vehicle_number = $('#vehicle_number').val().trim();
      $('#vehicle_number').val(vehicle_number);
      if(vehicle_number==null || vehicle_number==""){
        $("#err_vehicle_number").text(vehicle_number_empty);
        return false;
      }
      else{
        $("#err_vehicle_number").text("");
      }

      if (vehicle_number.length < 3) {
        $('#err_vehicle_number').text(vehicle_number_length);  
        return false;
      }
      else{
        $("#err_vehicle_number").text("");
      }
    });

    $("#vehicle_number").on("blur keyup",  function (event){
      var vehicle_number = $('#vehicle_number').val();
        if(vehicle_number==null || vehicle_number==""){
          $("#err_vehicle_number").text(vehicle_number_empty);
          return false;
        }
        else{
          $("#err_vehicle_number").text("");
        }

        if (vehicle_number.length < 3) {
          $('#err_vehicle_number').text(vehicle_number_length);  
          return false;
        }
        else{
          $("#err_vehicle_number").text("");
        }
    });
   
}); 
</script>