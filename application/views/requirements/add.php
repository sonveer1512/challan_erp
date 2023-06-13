<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$p = array('admin','sales_person','manager', 'purchaser');
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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('quotation'); ?>">Requirements</a></li>
          <li class="active">Add Requirements</li>
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
              <h3 class="box-title">Add New Requirements</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('requirements/addQuotation');?>">
                <div class="box-header with-border general">
                  <h3 class="box-title"><!-- <?php echo $this->lang->line('sales_add_new_sales'); ?> -->
                    <?php
                      if($reference_no==null){
                          $no = sprintf('%06d',intval(1));
                      }
                      else{
                        foreach ($reference_no as $value) {
                          $no = sprintf('%06d',intval($value->sales_id)+1); 
                        }
                      }
                      echo "Reference No : SO-".$no;
                    ?>
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
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo date("Y-m-d");  ?>">
                          <input type="hidden" class="form-control" id="reference_no" name="reference_no" value="SO-<?php echo $no;?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="warehouse"><?php echo $this->lang->line('purchase_select_warehouse'); ?> <span class="validation-color">*</span></label>
                          <?php                          
                          $user_type= $user_group[0]->name;
                          if ($user_type=='sales_person') { ?>
                            <input type="text" value="<?php if(isset($warehouse[0]->warehouse_name)){ echo $warehouse[0]->warehouse_name; }?>" class="form-control datepicker" disabled>
                            <input type="hidden" name="warehouse" id="warehouse" value="<?php if(isset($biller[0]->warehouse_id)){ echo $biller[0]->warehouse_id; } ?>" >

                            <input type="hidden" name="biller" id="biller" value="<?php if(isset($biller[0]->biller_id)){ echo $biller[0]->biller_id; } ?>" >
                            <input type="hidden" name="biller_state_id" id="biller_state_id" value="<?php if(isset($biller[0]->biller_state_id)){ echo $biller[0]->biller_state_id; } ?>" >
                            <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($biller[0]->user_id)){echo $biller[0]->user_id ;} ?>" >
                          <?php  }
                          else if($user_type=="admin"){ ?>
                               
                            <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php
                              foreach ($warehouse as $value) {
                            ?>
                              <option value="<?php echo $value->warehouse_id ?>"><?php echo $value->warehouse_name." (".$value->biller_name.")"; ?><?php if($value->primary_warehouse == 1){ echo " (Primary)";} ?></option>
                            <?php
                              }
                            ?>
                          </select>
                          <input type="hidden" name="biller" id="biller" value="" >  
                          <input type="hidden" name="biller_state_id" id="biller_state_id" value="">
                          <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                         <?php } ?>                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
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

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label><?php echo $this->lang->line('purchase_inventory_items'); ?></label>
                      
                      <table class="table items table-striped table-bordered table-condensed table-hover product_table" name="product_data" id="product_data">
                        <thead>
                          <tr>
                            <th style="width: 20px;"><img src="<?php  echo base_url(); ?>assets/images/bin1.png" /></th>
                            <th class="span2" width="15%"><?php echo $this->lang->line('purchase_product_description'); ?></th>
                            <th class="span2" width="10%"><?php echo $this->lang->line('product_unit'); ?></th>
                            <th class="span2" width="10%">Qty</th>
                          </tr>
                        </thead>
                        <tbody id="product_table_body">
                          
                        </tbody>
                      </table>
                      <input type="hidden" name="total_value" id="total_value">
                      <input type="hidden" name="total_discount" id="total_discount">
                      <input type="hidden" name="total_tax" id="total_tax">
                      <input type="hidden" name="grand_total" id="grand_total">
                      <input type="hidden" name="table_data" id="table_data">
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
                      <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('product_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                      <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('sales')"><?php echo $this->lang->line('product_cancel'); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
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
  $this->load->view('layout/product_footer');
?>
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script>
 $(document).ready(function(){
    var i = 0;
    var product_data = new Array();
    var counter = 1;
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
              //alert(data[0].code);
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
                    +"</td>";
              cols += "</tr>";
              counter++;

              newRow.append(cols);
              $("table.product_table").append(newRow);
              var table_data = JSON.stringify(product_data);
              $('#table_data').val(table_data);
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

    function deleteRow(row){
      var id = +row.find('input[name^="id"]').val();
      var array_id = product_data[id].product_id;
      //product_data.splice(id, 1);
      product_data[id] = null;
      //alert(product_data);
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
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
    function discount_shipping_change(){
      var discount = +$('#discount').val();
      var shipping_charge = +$('#shipping_charge').val();
      if(shipping_charge==""){
        shipping_charge = 0;  
      }
      if(discount==""){
        discount = 0;
      }
      var grandTotal = +$('#grand_total').val();
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
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>