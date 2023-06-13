
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class=" modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" >
        <div class="modal-body ">
          <div class="container">
            
                <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="driver_name">Project Nmae <span class="validation-color">*</span></label>
                        <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo set_value('p_name'); ?>">
                        <span class="validation-color" id="err_p_name"><?php echo form_error('p_name'); ?></span>
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="vehicle_number">Transporter Name <span class="validation-color">*</span></label>
                        <input type="text" class="form-control" id="t_name" name="t_name" value="<?php echo set_value('t_name'); ?>">
                        <span class="validation-color" id="err_t_name"><?php echo form_error('t_name'); ?></span>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="vehicle_type">Vehicle No <span class="validation-color">*</span></label>
                        <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php echo set_value('vehicle_no'); ?>">
                        <span class="validation-color" id="err_vehicle_no"><?php echo form_error('vehicle_no'); ?></span>
                      </div>
                    </div>
                  </div>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="capacity">From</label>
                      <input type="text" class="form-control" id="from" name="from" value="<?php echo set_value('from'); ?>">
                      <span class="validation-color" id="err_from"><?php echo form_error('from'); ?></span>
                    </div>
                  </div>
                  
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="capacity">To</label>
                      <input type="text" class="form-control" id="to" name="to" value="<?php echo set_value('to'); ?>">
                      <span class="validation-color" id="err_to"><?php echo form_error('to'); ?></span>
                    </div>
                  </div>
                  
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="capacity">Rate/Price</label>
                      <input type="number" class="form-control" id="rate" name="rate" value="<?php echo set_value('rate'); ?>">
                      <span class="validation-color" id="err_rate"><?php echo form_error('rate'); ?></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="capacity">Image</label>
                        <input type="file" class="form-control" id="image" name="image" value="<?php echo set_value('image'); ?>">
                        <span class="validation-color" id="err_image"><?php echo form_error('image'); ?></span>
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="capacity">Bill/Date</label>
                        <input type="date" class="form-control" id="bill_date" name="bill_date" value="<?php echo set_value('bill_date'); ?>">
                        <span class="validation-color" id="err_bill_date"><?php echo form_error('bill_date'); ?></span>
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="capacity">Bill No</label>
                        <input type="text" class="form-control" id="bill_no" name="bill_no" value="<?php echo set_value('bill_no'); ?>">
                        <span class="validation-color" id="err_bill_no"><?php echo form_error('bill_no'); ?></span>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="capacity">Remark</label>
                      <input type="text" class="form-control" id="remark" name="remark" value="<?php echo set_value('remark'); ?>">
                      <span class="validation-color" id="err_remark"><?php echo form_error('remark'); ?></span>
                    </div>
                  </div>
                </div>
              
              
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn_submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      
      
    </div>
  </div>
</div>



<script>
  $(document).ready(function(){
    $("#btn_submit").click(function(event){
      var formData = new FormData(this);

      $.ajax({
        url : '<?php echo base_url('transport_pay/addCategory') ?>',
        dataType : 'JSON',
        method : 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success : function(result){
          if (result.code == 200) {
            swal(result.message, ' ', 'success');
            reloadpage();
          } else {
            swal(result.message, ' ', 'error');
          }
        }
      });
    });  
}); 
</script>