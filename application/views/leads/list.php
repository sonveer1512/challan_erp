<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title titlefix">Leads List</h3>
            <div class="box-tools pull-right">
              <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Leads</a> 
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="download_label">Leads List</div>
            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S.No. </th>
                    <th>Details </th>
                    <th>Website</th>
                    <th>Contact Person 1 Details </th>
                    <th>Contact Person 2 Details </th>
                    <th style="width: 10%">Assigned To </th>
                    <th style="width: 15%">Last Remark </th>
                  </tr> 
                </thead>
                <tbody>
                  <?php 
                  if(!empty($lead)) { $i = 0; foreach($lead as $result) { $i++; ?>
                  <tr>                      
                      <td><?=$i?></td>
                      <td><?=$this->auth->persondetails($result['name'], $result['address'], $result['city'], $result['state']);?></td>
                      
                      <td><a href="<?=$result['website']?>" target="_blank"><?=$result['website']?></a></td>

                      <td><?=$this->auth->contact_person($result['contact_person'], $result['designation'], $result['contact_number'], $result['mobile_number'], $result['email']);?></td>
                      <td><?=$this->auth->contact_person($result['contact_person2'], $result['designation2'], $result['contact_number2'], $result['mobile_number2'], $result['email2']);?></td>
                      <td>
                        
                        <select class="form-control assignuser" name="user_id" data-id="<?=$result['lead_id']?>">
                          <option value="">select user</option>
                          <?php foreach($user as $value) { ?>      
                            <option value=<?php echo $value['user_id'];?> <?php if(!empty($result['assign_user_id'])) { if($result['assign_user_id'] == $value['user_id']) { echo "selected"; } } ?> ><?php echo $value['user_name'];?></option>
                          <?php } ?>
                        </select>
                        <span id="assignerr_<?=$result['lead_id']?>" style="display: none; color: green">User Assigned Successfully</span>

                      </td>
                      <td class="content">
                        
                        <a data-toggle="modal" data-target="#addfollowup" onclick="showclientdetails(<?=$result['lead_id']?>)">Add Quick Followup</a> <br>
                        <span id="followuperr_<?=$result['lead_id']?>"></span> 
                        <span id="followuperrtime_<?=$result['lead_id']?>"></span>

                        <span id="lastfollowup_<?=$result['lead_id']?>" data-id="<?=$result['lead_id']?>">
                          <?php $followup = $this->admin_model->leadfollowup('followupstatusmaster','lead_id',$result['lead_id']); 
                          if(!empty($followup)) {
                            foreach($followup as $val) {
                              echo $val['followup_text']." at ".$val['followup_date']."<br>"; 
                            } }?>
                        </span>
                      </td>
                  </tr>
                  <?php } } ?>
                </tbody>

              </table>
          </div>
        </div>                                                    
      </div>                                                                                                                                          
    </div>  
  </section>
</div>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Add Followup</h4> 
      </div>
      <form id="adddetails" accept-charset="utf-8"  method="post" class="ptt10">   
        <div class="modal-body pt0 pb0">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Followup <span class="text-red">*</span></label> 
                <input type="text" name="followup_name" id="followup_name" placeholder="Followup" class="form-control" />
              </div>
            </div> 
          </div>  

          <div class="box-footer">
            <div class="pull-right">
              <button type="submit" id="adddetailsbtn" data-loading-text="Processing" class="btn btn-info pull-right">Save </button>
            </div>
          </div>
        </div>  
      </form>
    </div>
  </div>    
</div>


<div class="modal fade" id="myEditModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Edit Followup</h4> 
      </div>
      <form id="editdetails" accept-charset="utf-8"  method="post" class="ptt10">   
        <div class="modal-body pt0 pb0" id="showclient_details_div">
          
        </div>  
        <div class="box-footer">
          <div class="pull-right">
            <button type="submit" id="editdetailsbtn" data-loading-text="Processing" class="btn btn-info pull-right">Save </button>
          </div>
        </div>
      </form>
    </div>
  </div>    
</div>


<script>
/*save details */
$(document).ready(function () {
  $("#adddetails").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

      $.ajax({
          url: "<?=base_url()?>followup/add",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $("#adddetailsbtn").attr('disabled', true);
          },
          success: function (response) {
            if(response.status == true) {
              toastr.success(response.msg, response.type);
              reloadpage();
            }else{
              toastr.error(response.msg, response.type);
            }
            $("#adddetailsbtn").removeAttr('disabled', false);
          }
      });
  }));
});


$(document).ready(function () {
  $("#editdetails").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

      $.ajax({
          url: "<?=base_url()?>followup/edit",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $("#editdetailsbtn").attr('disabled', true);
          },
          success: function (response) {
            if(response.status == true) {
              toastr.success(response.msg, response.type);
                reloadpage();
            }else{
              toastr.error(response.msg, response.type);
            }
            $("#editdetailsbtn").removeAttr('disabled', false);
          }
      });
  }));
});


/*delete code*/
$(document).ready(function(){      
  $(document).on('click','.deactivate_detail',function(e){
    e.preventDefault(); 
     var id = $(this).data("id");
     $.ajax({
         url:'<?=base_url()?>followup/showban',
         type:"get",
         data:"id="+id,
         processData:false,
         contentType:false,
         cache:false,
         async:false,
         success: function(response){
          if(response.status == true) {
              $('body').append(response.modal);
              $(".delete_modal").modal('show');
              $(".delete_modal").on('hidden.bs.modal', function (e) {
                  $(".delete_modal").remove();
              });
          }
         }
     });
  });
});


$(document).ready(function(){      
  $(document).on('click','.activate_detail',function(e){
    e.preventDefault(); 
     var id = $(this).data("id");
     $.ajax({
         url:'<?=base_url()?>followup/showapproved',
         type:"get",
         data:"id="+id,
         processData:false,
         contentType:false,
         cache:false,
         async:false,
         success: function(response){
          if(response.status == true) {
              $('body').append(response.modal);
              $(".approved_modal").modal('show');
              $(".approved_modal").on('hidden.bs.modal', function (e) {
                  $(".approved_modal").remove();
              });
          }
         }
     });
  });
});



function showclientdetails(id, ipdid) {
//console.log(id);
    $.ajax({
        url: '<?=base_url()?>followup/showfollowupdetails/' + id,
        success: function (res) {
            $("#showclient_details_div").html(res);
        },
        error: function () {
            alert("Fail")
        }
    });
}



$( document ).ready(function() {
    $.ajax({
        url: '<?=base_url()?>leads/ajaxlist',
        success: function (res) {
            $("#textdata").html(res);
        },
        error: function () {
            alert("Fail")
        }
    });
}

</script>