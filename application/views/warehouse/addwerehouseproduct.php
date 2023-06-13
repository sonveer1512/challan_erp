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
          <li><a href="<?php echo base_url('warehouse'); ?>">
                <!-- Warehouse -->
                  <?php echo $this->lang->line('warehouse_header'); ?>
                </a></li>
          <li class="active"><!-- Add Warehouse -->
           Add Product With Werehouse
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
              <h3 class="box-title"><!-- Add New Warehouse -->
             Product With Werehouse
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                <form role="form" id="form" method="post" action="<?php echo base_url('warehouse/addproduct');?>">
                  <div class="form-group">
                    <label for="branch"><!-- Select Branch --> 
                       Select Werehouse
                      <span class="validation-color">*</span></label>
                     
                    <select class="form-control select2"  name="werehouse" style="width: 100%;">
                      <option value=""><!-- Select -->
                        Select Werehouse
                      </option>
                      <?php
                        foreach ($data as $row) {
                          echo "<option value='$row->warehouse_id '>$row->warehouse_name</option>";
                        }
                      ?>
                    </select>

                    <span class="validation-color" id="err_branch_id"><?php echo form_error('branch'); ?></span>
                  </div>
                 
                  <!-- /.form-group -->
                  <div class="col-md-12">
                  <table style="width: 100%" id="tableID">
            <tr id="row0">
              <td>   
                <div class="row">
                  <div class="col-md-6">
                    <label class="form-label" for="val-username">Select Product
                   <span class="validation-color">*</span></label>
                    <select class="form-control select2" id="product" name="werehousep[]" style="width: 100%;" >
                      <option value=""><!-- Select -->
                        Select Product
                      </option>
                      <?php
                        foreach ($data_product as $row) {
                         echo "<option value='$row->product_id '>$row->name</option>";
                        }
                      ?>
                    </select>
                   
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="val-username">Enter Quantity
                      <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" name="quantity[]" placeholder="Enter Quantity">
                  </div>

                  

                 
                 

                </div> 
              </td>
              <td style="padding-top: 25px;">
                <label> </label>
                <button type="button" onclick="add_more()" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
              </td>
            </tr>
          </table>
                  </div>
                     
              
                  
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit"  class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add -->
                        <?php echo $this->lang->line('add_user_btn'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('warehouse')"><!-- Cancel -->
                      <?php echo $this->lang->line('add_user_btn_cancel'); ?></span>
                  </div>
                </div>
                
                </form>
            </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('layout/footer');
  ?>
<script>
  $(document).ready(function(){
    $("#submit").click(function(event){
      var name_regex = /^[-\sa-zA-Z0-9 ]+$/;
      var branch_id = $('#branch').val();
      var warehouse_name = $('#warehouse_name').val();


        if(branch_id==""){
          $("#err_branch_id").text("Please Select Branch.");
          return false;
        }
        else{
          $("#err_branch_id").text("");
        }
//branch id validation complite.

        if(warehouse_name==null || warehouse_name==""){
          $("#err_warehouse_name").text("Please Enter Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
        if (!warehouse_name.match(name_regex) ) {
          $('#err_warehouse_name').text(" Please Enter Valid Warehouse Name  ");   
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
//warehouse name validation complite.
        
    });

    $("#branch").change(function(event){
        var branch_id = $('#branch').val();
        if(branch_id==""){
          $("#err_branch_id").text(" Please Select Branch.");
          return false;
        }
        else{
          $("#err_branch_id").text("");
        }
    });

    $("#warehouse_name").on("blur keyup", function(){
        var name_regex = /^[-\sa-zA-Z0-9 ]+$/;
        var warehouse_name = $('#warehouse_name').val();
        if(warehouse_name==null || warehouse_name==""){
          $("#err_warehouse_name").text("Please Enter Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
        if (!warehouse_name.match(name_regex) ) {
          $('#err_warehouse_name').text(" Please Enter Valid Warehouse Name  ");   
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
    });
   
}); 
 
   

</script>
    <script>
    function add_more() {

  var table = document.getElementById("tableID");
  var table_len = (table.rows.length);
  var id = parseInt(table_len);
  var div = "<br><div class='row'><div class='col-md-6'><select class='form-control select2'  name='werehousep[]' style='width: 100%;'><option value=''>Select Product</option><?php foreach ($data_product as $row) {echo "<option value='$row->product_id '>$row->name</option>";
                        }
                      ?></select></div>  <div class='col-md-6'> <input type='text' class='form-control' name='quantity[]' placeholder='Enter Quanitity'></div></div>";

  var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td>" + div + "</td><td><button type='button' onclick='delete_row(" + id + ")' class='btn btn-danger btn-sm sss'><i class='fa fa-remove'></i></button></td></tr>";
  $('.select2').select2();
}

function delete_row(id) {
  var table = document.getElementById("tableID");
  var rowCount = table.rows.length;
  $("#row" + id).html("");
  //table.deleteRow(id);
}

</script>
    
    