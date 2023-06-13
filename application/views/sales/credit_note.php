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
          <li><a href="<?php echo base_url('sales'); ?>">Sales</a></li>
          <li class="active">Add Credit Note</li>
        </ol>
      </h5>    
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Credit Note</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" id="form" method="post" action="<?php echo base_url('sales/addCreditNote');?>">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="r_v_no">Credit Note Number <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="r_v_no" name="r_v_no" value="<?php echo set_value('r_v_no'); ?>">
                    <input type="hidden" id="invoice" name="invoice" value="<?php echo $data->id; ?>">
                    <input type="hidden" id="sales" name="sales" value="<?php echo $data->sales_id; ?>">
                    <span class="validation-color" id="err_r_v_no"><?php echo form_error('r_v_no'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="r_v_date">Credit Note Date <span class="validation-color">*</span></label>
                    <input type="text" class="form-control datepicker" id="r_v_date" name="r_v_date" value="<?php echo set_value('r_v_date'); ?>" autocomplete="off">
                    <span class="validation-color" id="err_r_v_date"><?php echo form_error('r_v_date'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="r_v_value">Credit Note Value <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="r_v_value" name="r_v_value" value="<?php echo $data->paid_amount; ?>" readonly>
                    <span class="validation-color" id="err_r_v_value"><?php echo form_error('r_v_value'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="reason">Reason for Issue Document<span class="validation-color">*</span></label>
                    <select id="reason" name="reason" class="form-control select2">
                      <option value="1">Sales Retun/Purchase Return</option>
                      <option value="2">Post Sale Discount</option>
                      <option value="3">Dificiency in Service</option>
                      <option value="4">Correction of Invoice</option>
                      <option value="5">Change in POS(Place of Supply)</option>
                      <option value="6">Finalization of Provisional assessment</option>
                      <option value="7">Others</option>
                    </select>
                    <span class="validation-color" id="err_reason"><?php echo form_error('reason'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="pre_gst">Pre GST</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="pre_gst" id="pre_gst" value="Y">
                    <span class="validation-color" id="errpre_gst"><?php echo form_error('pre_gst'); ?></span>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('credit_debit_note')"><!-- Cancel --><?php echo $this->lang->line('category_cancel'); ?></span>
                  </div>
                </div>
              </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
