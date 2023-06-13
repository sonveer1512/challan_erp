<div id="brand_model" class="modal fade brand_model" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Add New Sub Sub Category</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
          		<div class="form-group">
              <label for="category_id">Category Name</label>
              <select name="category_id" id="category_id" class="select2 form-control" style="width: 100%;" onchange="cat_with_subcat(this.value)">
                <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                  <?php
                    foreach ($category as $row) {
                      echo "<option value='$row->category_id'>$row->category_name</option>";
                    }
                  ?>
              </select>
              <span class="validation-color" id="err_category_id_model"><?php echo form_error('category_id_model'); ?></span>
            </div>
          </div>
          <div class="col-sm-12">
          		<div class="form-group">
              <label for="sub_category_id">Sub-Category Name</label>
              <select name="sub_category_id" id="sub_category_id" class="select2 form-control sub_category_name" style="width: 100%;">
               
              </select>
              <span class="validation-color" id="err_category_id_model"><?php echo form_error('category_id_model'); ?></span>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label for="brand_name">Sub-Sub Category Name</label>
              <input type="text" name="brand_name" id="brand_name" class="form-control">
              <span class="validation-color" id="err_brand_name"><?php echo form_error('brand_name'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_brand" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    var brand_name_empty = "Please Enter the Brand Name.";
    var brand_name_invalid = "Please Enter Valid Brand Name";
    $("#add_brand").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var brand_name = $('#brand_name').val();
      var category_id = $('#category_id').val();
      var sub_category_id = $('#sub_category_id').val();
      if(brand_name==null || brand_name==""){
        $("#err_brand_name").text(brand_name_empty);
        return false;
      }
      else{
        $("#err_brand_name").text("");
      }
      if (!brand_name.match(name_regex)) {
        $('#err_brand_name').text(brand_name_invalid);  
        return false;
      }
      else{
        $("#err_brand_name").text("");
      }
      $.ajax({
        url:"<?php echo base_url('brand/add_brand_ajax') ?>",
        dataType: 'JSON',
        method:'POST',
        data:{
          'brand_name':$('#brand_name').val(),
          'category_id':$('#category_id').val(),
          'sub_category_id':$('#sub_category_id').val()
        },
        success:function(result){
          var data = result['data'];
          $('#brand').html('');
          $('#brand_name').val('');
          $('#brand').append('<option value="">Select</option>');
          for(i=0;i<data.length;i++){
              $('#brand').append('<option value="' + data[i].id + '">' + data[i].brand_name + '</option>');
          }
          $('#brand').val(result['id']).attr("selected","selected");
        }
      });
    });

    $("#brand_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var brand_name = $('#brand_name').val();
        if(brand_name==null || brand_name==""){
          $("#err_brand_name").text(brand_name_empty);
          return false;
        }
        else{
          $("#err_brand_name").text("");
        }
        if (!brand_name.match(name_regex)) {
          $('#err_brand_name').text(brand_name_invalid);  
          return false;
        }
        else{
          $("#err_brand_name").text("");
        }
    });
   
}); 
  
  
</script>

<script>
  function cat_with_subcat(category_id){
  	$.ajax({
       url: '<?=base_url()?>product/datawithcat/' + category_id,
         success: function (res) {
            $(".sub_category_name").html(res);
        },
          error: function () {
            alert("Fail")
        }
    })
  }
</script>