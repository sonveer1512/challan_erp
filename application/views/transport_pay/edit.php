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
          <li><a href="<?php echo base_url('transport_pay'); ?>">Transport</a></li>
          <li class="active">Edit Transport Pay</li>
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
              
                <form role="form" id="form" method="post" action="<?php echo base_url('transport_pay/editpay');?>" enctype="multipart/form-data">

                  <?php foreach($data as $row){ ?>

                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row->id; ?>">

                    <div class="col-sm-6">
                  <div class="form-group">
                    <label for="driver_name">Project Nmae <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo $row->p_name;?>">
                    <span class="validation-color" id="err_p_name"><?php echo form_error('p_name'); ?></span>
                  </div>
                </div>
                
				<div class="col-sm-6">
                  <div class="form-group">
                    <label for="vehicle_number">Transporter Name <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="t_name" name="t_name" value="<?php echo $row->t_name;?>">
                    <span class="validation-color" id="err_t_name"><?php echo form_error('t_name'); ?></span>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="vehicle_type">Vehicle No <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php echo $row->vehicle_no;?>">
                    <span class="validation-color" id="err_vehicle_no"><?php echo form_error('vehicle_no'); ?></span>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">From</label>
                    <input type="text" class="form-control" id="from" name="from" value="<?php echo $row->from;?>">
                    <span class="validation-color" id="err_from"><?php echo form_error('from'); ?></span>
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">To</label>
                    <input type="text" class="form-control" id="to" name="to" value="<?php echo $row->to;?>">
                    <span class="validation-color" id="err_to"><?php echo form_error('to'); ?></span>
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">Rate/Price</label>
                    <input type="number" class="form-control" id="rate" name="rate" value="<?php echo $row->rate;?>">
                    <span class="validation-color" id="err_rate"><?php echo form_error('rate'); ?></span>
                  </div>
                </div>
                
                
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">Bill/Date</label>
                    <input type="date" class="form-control" id="bill_date" name="bill_date" value="<?php echo $row->bill_date;?>">
                    <span class="validation-color" id="err_bill_date"><?php echo form_error('bill_date'); ?></span>
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">Bill No</label>
                    <input type="text" class="form-control" id="bill_no" name="bill_no" value="<?php echo $row->bill_no;?>">
                    <span class="validation-color" id="err_bill_no"><?php echo form_error('bill_no'); ?></span>
                  </div>
                </div>
				
                  <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">Image</label>
                    <input type="file" class="form-control" id="image" name="image" value="<?php echo set_value('image'); ?>">
                    <span class="validation-color" id="err_image"><?php echo form_error('image'); ?></span>
                  </div>
                </div>
                  
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="capacity">Remark</label>
                    <input type="text" class="form-control" id="remark" name="remark" value="<?php echo $row->remark;?>">
                    <span class="validation-color" id="err_remark"><?php echo form_error('remark'); ?></span>
                  </div>
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