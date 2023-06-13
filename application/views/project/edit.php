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
          <li><a href="<?php echo base_url('project'); ?>">Project</a></li>
          <li class="active">Edit Project</li>
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
              
                <form role="form" id="form" method="post" action="<?php echo base_url('project/projectedit');?>" enctype="multipart/form-data">

                  <?php foreach($data as $row){ ?>

                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row->id; ?>">

                    <div class="col-sm-6">
                  <div class="form-group">
                    <label for="driver_name">Project name <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo $row->p_name; ?>">
                    <span class="validation-color" id="err_p_name"><?php echo form_error('p_name'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="vehicle_number">Location/Site <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $row->location; ?>">
                    <span class="validation-color" id="err_vehicle_number"><?php echo form_error('location'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="vehicle_type">Site Encharge <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="site_encharge" name="site_encharge" value="<?php echo $row->site_encharge; ?>">
                    <span class="validation-color" id="err_site_encharge"><?php echo form_error('site_encharge'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="capacity">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $row->contact; ?>">
                    <span class="validation-color" id="err_contact"><?php echo form_error('contact'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="capacity">Image</label>
                    <input type="file" class="form-control" id="image" name="image" value="<?php echo $row->image; ?>">
                    <span class="validation-color" id="err_image"><?php echo form_error('image'); ?></span>
                  </div>
                      <?php if(!empty($row->image)) {?>
                            <img class="img-fluid rounded-circle" alt="" src="<?= base_url() ?>/<?= $row->image?>" width="100" height="100">
                            <?php } else {?>
                            	<img class="img-fluid rounded-circle" alt="" src="https://us.123rf.com/450wm/pandavector/pandavector1901/pandavector190105281/126044187-isolated-object-of-avatar-and-dummy-symbol-collection-of-avatar-and-image-stock-symbol-for-web.jpg?ver=6" width="100" height="100">
                            <?php }?>

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
