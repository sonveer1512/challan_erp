<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>

<style>
  .switch {
  position: relative;
  display: inline-block;
  width: 54px;
  height: 28px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('challan'); ?>">Challan</a></li>
          <li class="active">Edit Challan</li>
        </ol>
      </h5>    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <div class="col-sm-12">
          <form role="form" id="form" method="post" action="<?php echo base_url('challan/editQuotation');?>">
            <div class="box">
              <div class="box-header with-border general">
                <h3 class="box-title"><?php echo "Reference No : ".$data[0]->serial_number; ?>
                  <input type="hidden" name="reference_no" value="<?php echo $data[0]->serial_number; ?>">
                </h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
              </div>
              <div class="box-body general-data">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                        <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo $data[0]->date;  ?>" readonly>
                        <input type="hidden" name="challan_id" value="<?php echo $data[0]->id;?>">
                        <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      		<div class="form-group">
                              <label for="project_id">Project Name <span class="validation-color">*</span></label>
                              <select class="form-control" id="project_id" name="project_id"readonly >
                                 <option selected>Select</option>
                                 <?php foreach ($project as $value) {  ?>
                                <option value='<?=$value->id?>' <?php if($value->id == $data[0]->project_id){echo "selected";} ?> ><?=$value->p_name?></option>
                                <?php } ?>
                              </select>
                            </div>
                      </div>
                      <div class="col-sm-3">
                      		<div class="form-group">
                              <label for="project_id">Transporter Name <span class="validation-color">*</span></label>
                              <select class="form-control" id="transport_id" name="transport_id" >
                                <option selected>Select</option>
                                 <?php foreach ($transport as $value) {  ?>
                                <option value='<?php echo $value->id; ?>' <?php if($value->id == $data[0]->transport_id){echo "selected";} ?>><?=$value->t_name?></option>
                                <?php } ?>
                              </select>
                            </div>
                      </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="warehouse">Warehouse / Site<span class="validation-color">*</span></label>
                        <select class="form-control select2" id="user_id" name="warehouse_id" style="width: 100%;" readonly>
                          <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                          <?php
                            foreach ($warehouselist as  $key) {
                          ?>
                        <option value='<?php echo $key->warehouse_id; ?>' <?php if($key->warehouse_id == $data[0]->warehouse_id){echo "selected";} ?>><?php echo $key->warehouse_name ?></option>
                          <?php
                            }
                          ?>  
                           <?php  
                              foreach ($customer as $row) {
                                echo "<option value='$row->customer_id'>$row->customer_name (customer) </option>";
                                
                              }
                            ?> 
                        </select>
                        <input type="hidden" name="biller_state_id" id="biller_state_id" value="<?php echo $biller_state_id;?>">
                        <input type="hidden" name="biller" id="biller" value="<?php echo $biller_id;?>">
                        <input type="hidden" name="warehouse" id="warehouse" value="<?php echo $data[0]->warehouse_id;?>">
                        <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="customer">Site Name<span class="validation-color">*</span></label>
                        <select class="form-control select2" id="customer" name="customer" style="width: 100%;" readonly>
                          <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                          <?php foreach ($customer as  $key) { ?>
                            <option value='<?php echo $key->customer_id ?>' <?php if($key->customer_id == $data[0]->customer_id){echo "selected";} ?>><?php echo $key->customer_name ?></option>
                          <?php } ?>
                           <?php
                              foreach ($warehouse as $value) {
                            ?>
                              <option  value="<?php echo $value->user_id; ?>"><?php echo $value->warehouse_name." (".$value->biller_name.")"; ?><?php if($value->primary_warehouse == 1){ echo " (Primary)";} ?><span>(Warehouse)</span></option>
                            <?php
                              }
                            ?>
                        </select>
                        <input type="hidden" name="shipping_state_id" id="shipping_state_id" value="<?php echo $shipping_state_id; ?>">
                        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $data[0]->customer_id; ?>">
                        <span class="validation-color" id="err_customer"><?php echo form_error('customer');?></span>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="site_contact_no">Site Contact No.</label>
                        <input type="text" class="form-control" id="site_contact_no" name="site_contact_no" value="<?=$data[0]->site_contact_no?>" readonly>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="box-header with-border billing">
                <h3 class="box-title">Billing & Shipping Address</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
              </div>  
              <div class="box-body billing-data">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-6">
                      <h5><b>Billing Address</b></h5>
                          <span id="billing_address"><?php echo $data[0]->billing_address; ?></span>
                      <br><span id="billing_city"><?php echo $data[0]->billing_city; ?></span>
                      <br><span id="billing_state"><?php echo $data[0]->billing_state; ?></span>
                      <br><span id="billing_country"><?php echo $data[0]->billing_country; ?></span>
                    </div>
                    <div class="col-sm-6">
                      <h5><b>Shipping Address</b> <a href="" data-toggle="modal" data-target="#change_shipping_address">Change</a></h5>
                          <span id="shipping-address"><?php echo $data[0]->shipping_address; ?></span>
                      <br><span id="shipping-city"><?php echo $data[0]->shipping_city; ?></span>
                      <br><span id="shipping-state"><?php echo $data[0]->shipping_state; ?></span>
                      <br><span id="shipping-country"><?php echo $data[0]->shipping_country; ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-header with-border supplier">
                <h3 class="box-title">Supplier & Transportation Details</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
              </div>
              <div class="box-body supplier-data">
                <div class="col-sm-12">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="transporter">Transporter</label>
                          <input type="text" class="form-control" id="transporter" name="transporter" value="<?=$data[0]->transporter?>" readonly>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="order_by">Order By</label>
                          <input type="text" class="form-control" id="order_by" name="order_by" value="<?=$data[0]->order_by?>" readonly>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="dispatch_by">Dispatch By</label>
                          <input type="text" class="form-control" id="dispatch_by" name="dispatch_by" value="<?=$data[0]->dispatch_by?>" readonly>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="supplier_ref">Vehicle </label>

                          <select class="form-control select2" name="vehicle_id" style="width: 100%" readonly>
                            <option>Select</option>
                            <?php if(!empty($vehicle)) { foreach($vehicle as $values) { ?>
                              <option value="<?=$values->id?>"  <?php if($values->id == $data[0]->vehicle_id){echo "selected";} ?> ><?=$values->driver_name?> (<?=$values->vehicle_number?>)</option>
                            <?php  } } ?>
                          </select>
                          <span class="validation-color" id="err_supplier_ref"><?php echo form_error('supplier_ref'); ?></span>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="dispatch_from">Dispatch From</label>
                          <input type="text" class="form-control" id="dispatch_from" name="dispatch_from" value="<?=$data[0]->dispatch_from?>" readonly>
                          <span class="validation-color" id="err_dispatch_from"><?php echo form_error('dispatch_from'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="dispatch_to">Dispatch To</label>
                          <input type="text" class="form-control" id="dispatch_to" name="dispatch_to" value="<?=$data[0]->dispatch_to?>" readonly>
                          <span class="validation-color" id="err_dispatch_to"><?php echo form_error('dispatch_to'); ?></span>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="loaded_by"> Loading By </label>
                          <input type="text" class="form-control" id="loaded_by" name="loaded_by" value="<?=$data[0]->loaded_by?>" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="unloaded_by"> Unloaded By</label>
                          <input type="text" class="form-control" id="unloaded_by" name="unloaded_by" value="<?=$data[0]->unloaded_by?>">
                          <span class="validation-color" id="err_unloaded_by"><?php echo form_error('unloaded_by'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="material_received">Material Received By</label>
                          <input type="text" class="form-control" id="material_received" name="material_received" value="<?=$data[0]->material_received?>">
                          <span class="validation-color" id="err_material_received"><?php echo form_error('material_received'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="material_received">E-bay bill no</label>
                          <input type="text" class="form-control" id="e_pay" name="e_pay" value="<?=$data[0]->e_pay?>" >
                          <span class="validation-color" id="err_e_pay"><?php echo form_error('e_pay'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="material_received">Vendor Name</label>
                          <input type="text" class="form-control" id="vendor" name="vendor" value="<?=$data[0]->vendor?>" >
                          <span class="validation-color" id="err_vendor"><?php echo form_error('vendor'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="material_received">Transport/price</label>
                          <input type="text" class="form-control" id="rate_price" name="rate_price" value="<?=$data[0]->transport_price?>" >
                          <span class="validation-color" id="err_rate_price"><?php echo form_error('rate_price'); ?></span>
                        </div>
                      </div>
                      
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="checkbox">
                              <label class="switch">
                                <input type="checkbox" id="flexSwitchCheckChecked" onchange="changeval('<?=$items[0]->product_source?>')" disabled="disabled" <?php if( $items[0]->product_source == 'rent') { echo 'unchecked';} else { echo 'checked';}?>>
                                  <span class="slider round"></span>
                                <span style="margin-left: 47px;"><b><span id="enaledisabletext">Store</span></b></span>
                                <input type="hidden" name="enabledisablevalue" id="enabledisablevalue" value="0">
                              </label>
                          </div>
                        </div>
                      </div>
                    </div><hr>
                    
                    
                    
                    <style>
                    .rent_product{
                    	display:none;
                    }
                  </style>
                    <div class="rent_product" >
                        <div class="row mb-3">
                            <div class="col-md-12">
                              	<h3 style="margin-top:0px!important;">Rent</h3>
                                <table class="table table-striped table-bordered table-prescription">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Product Description</th>
                                            <th>Product Unit</th>
                                            <th>Qty</th>
                                            <th>Weight</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i=0; foreach ($items as  $key) {  ?>
                                        <tr class="prescription-row" id="presc_0">
                                          	<input type="hidden" class='form-control' placeholder="Product Name" name="challanmainid[]" value="<?php echo $key->id ?>" required>
                                            <td>
                                                <input type="text" class='form-control' placeholder="Product Name" name="product[]" value="<?php echo $key->rent_product ?>" required>
                                            </td>
                                            <td>
                                              <input type="text" class='form-control' placeholder="Product Description" name="productdescription[]" value="<?php echo $key->rent_product_description ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="productunit[]" placeholder="Product Unit" value="<?php echo $key->rent_product_unit ?>">
                                            </td>
                                            <td>
                                              <input type="text" class="form-control" id="qty" name="qty[]" placeholder="Qty" value="<?php echo $key->quantity ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="weight" name="weight[]" placeholder="Weight" value="<?php echo $key->weight ?>" required>
                                            </td>
                                            <td>
                                              <input type="text" class="form-control" id="price" name="price[]" placeholder="Price" value="<?php echo $key->price ?>">
                                            </td>
                                            <td>
                                              <input type="number" class="form-control" id="total" name="total[]" placeholder="Total" value="<?php echo $key->total ?>">
                                            </td>
                                            <td><a class="delete-row btn-sm btn-danger" style="cursor: pointer;">Delete</a></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>

                                    <tfoot>
                                      <tr>
                                        <td><a class="add-new btn-sm btn-success" style="cursor: pointer;">Add More</a></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right">Total Amount(<?php echo $this->session->userdata('symbol'); ?>)</td>
                                        <td align='right'><span id="grandTotals">&nbsp;0.00</span></td>
                                      </tr>
                                    </tfoot>
                                </table>
                            </div>
                         </div>
                    </div>
                    
                    

                  </div>
                </div>
              </div>

            <!-- box-header -->
              <div class="box-body">
                <div class="row">
                  
                  <div class="col-sm-12 our_store">
                    <div class="well">
                      <div class="row">
                        <div class="col-sm-12 search_product_code">
                          <input id="input_product_code" class="form-control" autofocus="off" type="text" name="input_product_code" placeholder="Enter Product Code/Name" >
                        </div>
                        <div class="col-sm-8">
                          <span class="validation-color" id="err_product"></span>
                        </div>
                      </div>
                    </div>
                  </div> <!--/col-md-12 -->

                  <div class="col-sm-12 our_store">
                    <div class="form-group">
                      <label><?php echo $this->lang->line('purchase_inventory_items'); ?></label>
                      
                      <table class="table items table-striped table-bordered table-condensed table-hover product_table" name="product_data" id="product_data">
                        <thead>
                          <tr>
                            <th style="width: 20px;"><img src="<?php  echo base_url(); ?>assets/images/bin1.png" /></th>
                            <th class="span2" width="30%"><?php echo $this->lang->line('purchase_product_description'); ?></th>
                            <th class="span2" width="10%"><?php echo $this->lang->line('product_unit'); ?></th>
                            <th class="span2" width="20%">Sent Qty</th>
                            <th class="span2" width="20%">Received Qty</th>
                          </tr>
                        </thead>
                        <tbody id="product_table_body">
                          <?php $i=0; foreach ($items as  $key) {  ?>
                            <tr>
                              <td>
                                <input type="hidden" name ="challan_items_id[]" value="<?php echo $key->id ?>">
                                <a class='deleteRow1'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a>
                                <input type='hidden' name='item_id[]' value="<?php echo $key->id ?>">
                                <input type='hidden' name='product_id[]' value="<?php echo $key->product_id ?>"></td>
                              <td><?php echo $key->name; ?><br>HSN: <?php echo $key->hsn_sac_code; ?></td>
                              <td><?php echo $key->unit ?></td>
                              <td><input type="number" class="form-control text-center" value="<?php echo $key->quantity ?>" data-rule="quantity" name='qty[]' id='qty' min="1" readonly>
                              </td>
                              <td><input type="number" class="form-control text-center" name="received_qty[]" value="<?php if($key->received_quantity != 0) { echo $key->received_quantity; }else{ echo $key->quantity; } ?>" data-rule="quantity"  id="received_qty">
                              </td>
                            </tr>
                          <?php $i++; } ?>
                        </tbody>
                     
                      
                      <input type="hidden" name="table_data" id="table_data" value='<?php echo json_encode($items) ?>'>
                      <input type="hidden" name="table_data1" id="table_data1">
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="control-group">                     
                      <div class="controls">
                        <div class="tabbable">
                          <ul class="nav nav-tabs">
                            <li>
                              <a href="#note" data-toggle="tab"><?php echo $this->lang->line('purchase_note'); ?></a>
                            </li>
                            <li class="active"><a href="#internal_note" data-toggle="tab"><?php echo $this->lang->line('sales_internal_note'); ?></a></li>
                          </ul>                           
                          <br>
                            <div class="tab-content">
                              <div class="tab-pane" id="note">
                                <textarea class="col-sm-12 form-control" id="note" name="note" value=""></textarea>
                                <span style="color:red;" id="err_note"></span>
                              </div>
                              <div class="tab-pane active" id="internal_note">
                                <textarea class="col-sm-12 form-control" id="note" name="internal_note" value=""></textarea>
                                <span style="color:red;" id="err_note"></span>
                              </div>
                            </div>
                          </div>
                        </div> <!-- /controls -->       
                    </div> <!-- /control-group -->  
                  </div>
                  
                  
                  <div class="col-sm-12">
                    <div class="box-footer">
                      <button type="submit" id="submit" class="btn btn-info"><?php echo $this->lang->line('product_update'); ?></button>
                      <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('sales')"><?php echo $this->lang->line('product_cancel'); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <div id="change_shipping_address" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>New Shipping Address</h4>
                  </div>
                  <div class="modal-body">
                    <div class="control-group">                     
                      <div class="controls">
                        <div class="tabbable">
                          <div class="box-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="country"><!-- Country --> 
                                      <?php echo $this->lang->line('biller_lable_country'); ?> <span class="validation-color">*</span>
                                    </label>
                                  <select class="form-control select2" id="country" name="country" style="width: 100%;">
                                    <option value="">
                                      <!-- Select -->
                                      <?php echo $this->lang->line('add_biller_select'); ?>    
                                    </option>
                                    <?php
                                      foreach ($country as  $key) {
                                    ?>
                                    <option 
                                      value='<?php echo $key->id ?>' 
                                      <?php 
                                        if(isset($data[0]->shipping_country_id)){
                                          if($key->id == $data[0]->shipping_country_id){
                                            echo "selected";
                                          }
                                        } 
                                      ?>
                                    >
                                    <?php echo $key->name; ?>
                                    </option>
                                    <?php
                                      }
                                    ?>
                                  </select>
                                  <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
                                </div>
                                <div class="form-group">
                                  <label for="state"><!-- State --> 
                                      <?php echo $this->lang->line('add_biller_state'); ?> 
                                      <span class="validation-color">*</span>
                                  </label>
                                  <select class="form-control select2" id="state" name="state" style="width: 100%;">
                                    <option value=""><!-- Select -->
                                        <?php echo $this->lang->line('add_biller_select'); ?>
                                        
                                    </option>
                                    <?php
                                      foreach ($state as  $key) {
                                    ?>
                                    <option 
                                      value='<?php echo $key->id ?>' 
                                      <?php 
                                        if(isset($data[0]->shipping_state_id)){
                                          if($key->id == $data[0]->shipping_state_id){
                                            echo "selected";
                                          }
                                        } 
                                      ?>
                                    >
                                    <?php echo $key->name; ?>
                                    </option>
                                  <?php
                                    }
                                  ?>
                                  </select>
                                  <span class="validation-color" id="err_state"><?php echo form_error('state'); ?></span>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="city"><!-- City --> 
                                      <?php echo $this->lang->line('biller_lable_city'); ?> 
                                      <span class="validation-color">*</span>
                                  </label>
                                  <select class="form-control select2" id="city" name="city" style="width: 100%;">
                                    <option value=""><!-- Select -->
                                        <?php echo $this->lang->line('add_biller_select'); ?>
                                        
                                        </option>
                                      <?php
                                        foreach ($city as  $key) {
                                      ?>
                                      <option 
                                        value='<?php echo $key->id ?>' 
                                        <?php 
                                          if(isset($data[0]->shipping_city_id)){
                                            if($key->id == $data[0]->shipping_city_id){
                                              echo "selected";
                                            }
                                          } 
                                        ?>
                                      >
                                      <?php echo $key->name; ?>
                                      </option>
                                      <?php
                                        }
                                      ?>
                                  </select>
                                  <span class="validation-color" id="err_city"><?php echo form_error('city'); ?></span>
                                </div>
                                <div class="form-group">
                                  <label for="address"><!-- Address --> 
                                      <?php echo $this->lang->line('add_biller_address'); ?> 
                                      <span class="validation-color">*</span>
                                  </label>
                                  <textarea class="form-control" id="address" rows="4" name="address"><?php echo $data[0]->shipping_address; ?></textarea>
                                  <span class="validation-color" id="err_address"><?php echo form_error('address'); ?></span>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="box-footer">
                                  <button id="btn_shipping_change" class="btn btn-info" class="close"  data-dismiss="modal">&nbsp;&nbsp;&nbsp;Change&nbsp;&nbsp;&nbsp;</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </form>
            </div>
          
          <!--/.col (right) -->
        </div>
      </section>
      </div>

      <!-- /.row -->
    
    <!-- /.content -->

  <!-- /.content-wrapper -->
<script>
  $('.billing-data').hide();
  $('.others-data').hide();
</script>
  <?php
    $this->load->view('layout/product_footer');
  ?>
<?php 
  // include('customer.php');
  //include('assign_warehouse.php');
?>
<script>
  $(document).ready(function(){
    $('#customer').change(function(){
      var customer_id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('sales/getCustomerData') ?>/"+customer_id,
          type: "GET",
          dataType: "JSON",
          data:{
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          success: function(data){
            $('#country').text('');
            $('#state').text('');
            $('#city').text('');
            $('#err_country').text('');
            $('#err_state').text('');
            $('#err_city').text('');
            for(a=0;a<data['country'].length;a++){
              $('#country').append('<option value="' + data['country'][a].id + '">' + data['country'][a].name+'</option>');
            }
            for(a=0;a<data['state'].length;a++){
              $('#state').append('<option value="' + data['state'][a].id + '">' + data['state'][a].name+'</option>');
            }
            for(a=0;a<data['city'].length;a++){
              $('#city').append('<option value="' + data['city'][a].id + '">' + data['city'][a].name+'</option>');
            }
            $('#country').val(data['data'].country_id).attr("selected","selected");
            $('#state').val(data['data'].state_id).attr("selected","selected");
            $('#city').val(data['data'].city_id).attr("selected","selected");
            $('#address').val(data['data'].address);

            $('#shipping_state_id').val(data['data'].state_id);

          }
        });
    });
  });
</script>
<script>
    $('#country').change(function(){
      var id = $(this).val();
      $('#state').html('<option value="">Select</option>');
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
    $('#state').change(function(){
      var id = $(this).val();
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
$(document).ready(function(){
    var i = <?php echo $i++; ?>;
    var product_data = new Array();
    var counter = <?php echo count($items); ?>;

    var existing_product_id = new Array();
    existing_product_id = JSON.parse($("#table_data").val());

    var mapping = { };
    $(function(){
            $('#input_product_code').autoComplete({
                minChars: 1,
                cache: false,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var warehouse_id = $('#warehouse').val();
                    $.ajax({
                      url: "<?php echo base_url('purchase_return/getBarcodeProducts') ?>/"+term+'/'+warehouse_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data){
                        var suggestions = [];
                        for(var i = 0; i < data.length; ++i) {
                            suggestions.push(data[i].code+' - '+data[i].name);
                            mapping[data[i].code] = data[i].product_id;
                        }
                        suggest(suggestions);
                        }
                    });
                },
                onSelect: function(event, ui) {
                  var str = ui.split(' ');
                  var warehouse_id = $('#warehouse').val();
                  $.ajax({
                    url:"<?php echo base_url('purchase_return/getProductUseCode') ?>/"+mapping[str[0]]+'/'+warehouse_id,
                    type:"GET",
                    dataType:"JSON",
                    success: function(data){
                      add_row(data);
                      $('#input_product_code').val('');
                    }
                  });
                } 
            });
            
    });
    function add_row(data){
      var flag = 0;
      $("table.product_table").find('input[name^="product_id"]').each(function () {
                if(data[0].product_id  == +$(this).val()){
                  flag = 1;
                }
            });
            if(flag == 0){
              var id = data[0].product_id;
              var code = data[0].code;
              var name = data[0].name;
              var hsn_sac_code = data[0].hsn_sac_code;
              var price = data[0].price;
              // var tax_id = data[0].tax_id;
              // var tax_value = data[0].tax_value;
              var igst = data[0].igst;
              var cgst = data[0].cgst;
              var sgst = data[0].sgst;
              // if(tax_value==null){
              //   tax_value = 0;
              // }
              var product = { "product_id" : id,
                              "price" : price
                            };
              product_data[i] = product;

              length = product_data.length - 1 ;
            
              var select_discount = "";
              select_discount += '<div class="form-group">';
              select_discount += '<select class="form-control select2" id="item_discount" name="item_discount" style="width: 100%;">';
              select_discount += '<option value="">Select</option>';
                for(a=0;a<data['discount'].length;a++){
                  select_discount += '<option value="' + data['discount'][a].discount_id + '">' + data['discount'][a].discount_name+'('+data['discount'][a].discount_value +'%)'+ '</option>';
                }
              select_discount += '</select></div>';
              var biller_state_id = $('#biller_state_id').val();
              var shipping_state_id = $('#shipping_state_id').val();

              if(biller_state_id==shipping_state_id){
                var igst_input ='<input name="igst" id="igst" class="form-control" value="0" readonly><input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="0">';
                var cgst_input ='<input type="number" step="0.01" name="cgst" id="cgst" class="form-control" max="100" min="0" value="'+cgst+'"><input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="'+cgst+'">';
                var sgst_input ='<input type="number" step="0.01" name="sgst" id="sgst" class="form-control" max="100" min="0" value="'+sgst+'"><input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="'+sgst+'">';
              }
              else{
                var igst_input ='<input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="'+igst+'"><input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="'+igst+'">';
                var cgst_input ='<input name="cgst" id="cgst" class="form-control" value="0" readonly><input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="0">';
                var sgst_input ='<input name="sgst" id="sgst" class="form-control" value="0" readonly><input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="0">';
              }

              var color;
              data[0].quantity>10?color="green":color="red";
              var newRow = $("<tr>");
              var cols = "";
              cols += "<td><a class='deleteRow'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a><input type='hidden' name='id' name='id' value="+i+"><input type='hidden' name='product_id' name='product_id' value="+id+"></td>";
              cols += "<td>"+name+"<br>HSN:"+hsn_sac_code+"</td>";
              cols += "<td>"+data[0].unit+"</td>";
              cols += "<td>"
                        +"<input type='number' class='form-control text-center' value='0' data-rule='quantity' name='qty"+ counter +"' id='qty"+ counter +"' min='1'>" 
                        +"<span style='color:"+color+";'>Avai Qty: "+data[0].quantity+"</span>"
                      +"</td>";
              cols += "<td>"
                        +"<input type='number' class='form-control text-center' value='0' data-rule='quantity' name='qty"+ counter +"' id='qty"+ counter +"' min='1'>" 
                        +"<span style='color:"+color+";'>Avai Qty: "+data[0].quantity+"</span>"
                      +"</td>";        
              cols += "</tr>";
              counter++;

              newRow.append(cols);
              $("table.product_table").append(newRow);
              var table_data = JSON.stringify(product_data);
              $('#table_data1').val(table_data);
              i++;
            }
            else{
              $('#err_product').text('Product Already Added').animate({opacity: '0.0'}, 2000).animate({opacity: '0.0'}, 1000).animate({opacity: '1.0'}, 2000);
            }
    }
    
    $("table.product_table").on("click", "a.deleteRow", function (event) {
        deleteRow($(this).closest("tr"));
        $(this).closest("tr").remove();
        calculateGrandTotal();
    });

    $("table.product_table").on("click", "a.deleteRow1", function (event) {
        deleteRow1($(this).closest("tr"));
        $(this).closest("tr").remove();
        calculateGrandTotal();
    });

    function deleteRow(row){
      var id = +row.find('input[name^="id"]').val();
      //var array_id = product_data[id].product_id;
      product_data.splice(id, 1);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }

    function deleteRow1(row){
      var id = +row.find('input[name^="id"]').val();
      product_data[id] = 'delete';
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }

    $("table.product_table").on("change", 'input[name^="price"], input[name^="qty"],input[name^="igst"],input[name^="cgst"],input[name^="sgst"],input[name^="tax_type"]', function (event) {

        calculateRow($(this).closest("tr"));
        calculateDiscountTax($(this).closest("tr"));
        calculateGrandTotal();

    });
    $('table.total_data').on('keyup change','input[name^="discount"],input[name^="shipping_charge"]',function(event){
        discount_shipping_change();
    });

    $("table.product_table").on("change",'#item_discount',function (event) {
      var row = $(this).closest("tr");
      var discount = +row.find('#item_discount').val();
      if(discount != ""){
        $.ajax({
          url: '<?php echo base_url('purchase/getDiscountValue/') ?>'+discount,
          type: "GET",
          data:{
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          datatype: JSON,
          success: function(value){
            data = JSON.parse(value);
            row.find('#discount_value').val(data[0].discount_value);
            calculateDiscountTax(row,data[0].discount_value);
            calculateGrandTotal();
          }
        });
      }
      else{
        row.find('#discount_value').val('0');
        calculateDiscountTax(row,0);
        calculateGrandTotal();
      }
    });

    function calculateRow(row) {
      var key = +row.find('input[name^="id"]').val();
      var price = +row.find('input[name^="price"]').val();
      var qty = +row.find('input[name^="qty"]').val();
      var product_id = +row.find('input[name^="product_id"]').val();
      row.find('input[name^="linetotal"]').val((price * qty).toFixed(2));
      row.find('#sub_total').text((price * qty).toFixed(2));
      if(product_data[key]==null){
        var temp = {
          "product_id" : product_id,
          "price" : price,
          "quantity" : qty,
          "total" : (price * qty).toFixed(2)
        };
        product_data[key] = temp;
      }
      product_data[key].quantity = qty;
      product_data[key].price = price;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }

    function calculateDiscountTax(row,data = 0,data1 = 0){
      var discount;
      if(data == 0 ){
        discount = +row.find('#discount_value').val();
      }
      else{
        discount = data;
      }
      
      var sales_total = +row.find('input[name^="linetotal"]').val();
      var total_discount = sales_total*discount/100;

      var igst = +row.find("#igst").val();
      var cgst = +row.find("#cgst").val();
      var sgst = +row.find("#sgst").val();

      var tax_type = row.find("input[name^='tax_type']:checked").val();  
      
      if(tax_type =="Inclusive")
      {
      
        var taxable_value = (sales_total - total_discount)*100/(100 + igst + cgst + sgst);
        var igst_tax = taxable_value*igst/100;
        var cgst_tax = taxable_value*cgst/100;
        var sgst_tax = taxable_value*sgst/100;     
        var tax = igst_tax+cgst_tax+sgst_tax;

        row.find('#taxable_value').text((taxable_value).toFixed(2));
        row.find('#product_total').val((taxable_value + tax).toFixed(2));

      }
      else
      {     
        var taxable_value = sales_total - total_discount;
        var igst_tax = taxable_value*igst/100;
        var cgst_tax = taxable_value*cgst/100;
        var sgst_tax = taxable_value*sgst/100;
        var tax = igst_tax+cgst_tax+sgst_tax;
        
        row.find('#product_total').val((taxable_value+tax).toFixed(2));
        row.find('#taxable_value').text(taxable_value.toFixed(2));
      } 

      

      row.find('#igst_tax').val(igst_tax);
      row.find('#igst_tax_lbl').text(igst_tax.toFixed(2));
      row.find('#cgst_tax').val(cgst_tax);
      row.find('#cgst_tax_lbl').text(cgst_tax.toFixed(2));
      row.find('#sgst_tax').val(sgst_tax);
      row.find('#sgst_tax_lbl').text(sgst_tax.toFixed(2));

      row.find('#hidden_discount').val(total_discount);

      var key = +row.find('input[name^="id"]').val();
      product_data[key].discount = +total_discount.toFixed(2);
      product_data[key].discount_value = +row.find('#discount_value').val();
      product_data[key].discount_id = +row.find('#item_discount').val();
      product_data[key].tax_type = tax_type;
      product_data[key].igst = igst;
      product_data[key].igst_tax = +igst_tax.toFixed(2);
      product_data[key].cgst = cgst;
      product_data[key].cgst_tax = +cgst_tax.toFixed(2);
      product_data[key].sgst = sgst;
      product_data[key].sgst_tax = +sgst_tax.toFixed(2);
      
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }
    
    
    function discount_shipping_change(){
      var discount = +$('#discount').val().toFixed(2);
      var shipping_charge = +$('#shipping_charge').val().toFixed(2);
      if(shipping_charge==""){
        shipping_charge = 0;  
      }
      if(discount==""){
        discount = 0;
      }
      var grandTotal = +$('#grand_total').val().toFixed(2);
      var grandTotal = (+grandTotal + +shipping_charge) - +discount;
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#round_off').text((Math.round(grandTotal)-grandTotal).toFixed(2));
    }
    function calculateGrandTotal() {
      var totalValue = 0;
      var totalDiscount = 0;
      var grandTax = 0;
      var grandTotal = 0;

      $("table.product_table").find('span[id^="taxable_value"]').each(function () {
        totalValue += +$(this).text();                                
      });      
      $("table.product_table").find('input[name^="hidden_discount"]').each(function () {
        totalDiscount += +$(this).val();
      });
      $("table.product_table").find('input[name^="igst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="cgst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="sgst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="product_total"]').each(function () {
        grandTotal += +$(this).val();
      });
      $('#totalValue').text(totalValue.toFixed(2));
      $('#total_value').val(totalValue.toFixed(2));
      $('#totalDiscount').text(totalDiscount.toFixed(2));
      $('#total_discount').val(totalDiscount.toFixed(2));
      $('#totalTax').text(grandTax.toFixed(2));
      $('#total_tax').val(grandTax.toFixed(2));
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#grand_total').val(grandTotal.toFixed(2));
      discount_shipping_change();
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
});

</script>
<script type="text/javascript">
   $('#btn_shipping_change').click(function(){
    $.ajax({
      url : '<?php echo base_url('customer/customer_sort_data') ?>',
      dataType : 'JSON',
      method : 'POST',
      data:{
          'country':$("#country").val(),
          'state':$("#state").val(),
          'city':$("#city").val()
      },
      success : function(data){
        $('#shipping-address').text($("#address").val());
        $('#shipping-city').text(data.city);
        $('#shipping-state').text(data.state);
        $('#shipping-country').text(data.country);
        $('#shipping-postal_code').text('');
        $('#shipping_state_id').val($("#state").val());

      }
    }); 
  });


</script>
<!-- datepicker  -->
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});
</script>
<!-- close datepicker  -->


<script>
  $(document).ready(function(){
    $("#customer").change(function(event){
      var customer = $('#customer').val();
      if(customer==""){
        $("#err_customer").text("Please Enter Customer");
        $('#customer').focus();
        return false;
      }
      else{
        $("#err_customer").text("");
      }
    });
    $("#discount").change(function(event){
      var discount = $('#discount').val();
      if(discount==""){
        $("#err_discount").text("Please Enter Discount");
        $('#discount').focus();
        return false;
      }
      else{
        $("#err_discount").text("");
      }
      if(discount!=""){
        $.ajax({
          url: "<?php echo base_url('sales/getDiscountAjax') ?>/"+discount,
          type: "get",
          dataType: "json",
          success: function(data){
            //alert(data[0].discount_id);
            var type = data[0].discount_type;
            var value = data[0].discount_value;
            var amount = parseInt(data[0].amount);
            var grand_total = $('#grand_total').val();
            $('#discount_type').val(type);
            $('#total_discount').val(value);
            $('#discount_amount').val(amount);
            if(grand_total > 0 && grand_total!=null){
              if(type == "Fixed"){
                var t = grand_total - value;
                if(grand_total < amount){
                  var t = grand_total;
                }  
                $('#lasttotal').text(t);
                $('#last_total').val(t);
                $('#totaldiscount').text(value);
                $('#total_discount').val(value);
                $('#discount_type').val(type);
                $('#discount_amount').val(amount);
                $('#showdiscount').text(" (Rs "+value+")");
              }
              else{
                var total = (grand_total*value)/100;
                var t = grand_total - total;
                $('#totaldiscount').text(total);
                $('#total_discount').val(value);
                $('#discount_type').val('');
                $('#discount_amount').val('');
                $('#lasttotal').text(t);
                $('#last_total').val(t);
                $('#showdiscount').text(" ("+value+"%)");
              }
            }
          }
        });
      }
    });
    $("#product").blur(function(event){
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var product = $('#product').val();
      if(product==null || product==""){
        $("#err_product").text("Please Enter Product Code/Name");
        $('#product').focus();
        return false;
      }
      else{
        $("#err_product").text("");
      }
      if (!date.match(sname_regex) ) {
        $('#err_product').text(" Please Enter Valid Product Code/Name ");  
        $('#product').focus(); 
        return false;
      }
      else{
        $("#err_product").text("");
      }
    });

  }); 
  $('#sales_invoice').change(function(){
      var id = $('#sales_invoice').val();
      if(id==1){
        $('.invoice_type_hide').hide();
        $('#port_code').val('');
        $('#shipping_bill_no').val('');
        $('#shipping_bill_date').val('');
      }
      else{
        $('.invoice_type_hide').show();
      }
    }); 
</script>
<script>
  $('.general').click(function(){
    $('.general-data').toggle('slow');
  });
  $('.billing').click(function(){
    $('.billing-data').toggle('slow');
  });
  $('.supplier').click(function(){
    $('.supplier-data').toggle('slow');
  });
  $('.others').click(function(){
    $('.others-data').toggle('slow');
  });
</script>
<script>
  var i = 0;

  $('.add-new').click(function() {
    i++;
    var formTemplate = $('.prescription-row').first().html();
    var newForm = "<tr class='prescription-row' id='presc_" + i + "'>" + formTemplate + "</tr>";
    $('table.table-prescription > tbody').append(newForm);
  });

  $('body').on('click', '.delete-row', function() {
    if ($('table').find('.prescription-row').length > 1) {
      $(this).parents('.prescription-row').remove();
    } else {
      var formTemplate = $('.prescription-row').first().html();
      var newForm = "<tr class='prescription-row'>" + formTemplate + "</tr>";
      $(this).parents('.prescription-row').remove();
      $('table.table-prescription > tbody').append(newForm);
    }
  });
</script>

<script>
  changeval('<?=$items[0]->product_source?>');
  function changeval(val) {
    var check = $('#flexSwitchCheckChecked').is(":checked");
    if (check == true && val=='') {
      $("#enaledisabletext").text("Store");
      $("#enabledisablevalue").val("0");
      $(".our_store").css("display", "block");
      $(".rent_product").css("display", "none");
    } else {
      $("#enaledisabletext").text(val);
      $("#enabledisablevalue").val("1");
      $(".our_store").css("display", "none");
      $(".rent_product").css("display", "block");
    }
  }
</script>
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>