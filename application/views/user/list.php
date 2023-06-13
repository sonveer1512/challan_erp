<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title titlefix">Users List</h3>
            <div class="box-tools pull-right">
              <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Users</a> 
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="download_label">Users List</div>
            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr> 
              </thead>
              <tbody>
                <?php $i = 0; foreach($user as $value) { $i++; ?>
                <tr>
                  <td><?=$i?></td>
                  <td><a href="<?=base_url()?>users/mysurvey/<?=$value['id']?>"><?=$value['name']?></a></td>
                  <td><?=$value['phone']?></td>
                  <td><?=$value['email_id']?></td>
                  <td>
                    <a data-toggle="modal" data-target="#myEditModal" class="btn btn-icon text-white btn-primary btn-sm" onclick="showclientdetails(<?=$value['id']?>, 'yes')"><i class="fa fa-edit"></i></a>

                    <a data-toggle="modal" data-target="#changepasswordmodal" class="btn btn-icon text-white btn-info btn-sm" title="Change Password" onclick="showchangepassworddetails(<?=$value['id']?>, 'yes')"><i class="fa fa-key"></i></a>

                    <?php if($value['is_active'] == 0) { ?>
                      <a class="deactivate_detail btn-icon text-white btn btn-sm btn-danger" data-id="<?=$value['id']?>"><i class="fa fa-ban"></i></a>
                    <?php }else{ ?>
                      <a class="activate_detail btn-icon text-white btn btn-sm btn-success" data-id="<?=$value['id']?>"><i class="fa fa-check"></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>
        </div>                                                    
      </div>                                                                                                                                          
    </div>  
  </section>
</div>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Add User</h4> 
      </div>
      <form id="adddetails" accept-charset="utf-8"  method="post" class="ptt10">   
        <div class="modal-body pt0 pb0">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Name <span class="text-red">*</span></label> 
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control" />
                  </div>
                </div> 

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Mobile Number</label> 
                    <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10" />
                  </div>
                </div>   
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Email Address<span class="text-red">*</span></label> 
                    <input type="email" name="email" id="email" placeholder="Email Address" class="form-control" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">User Name<span class="text-red">*</span></label> 
                    <input type="text" name="username" id="username" placeholder="Email Address" class="form-control" />
                  </div>
                </div> 

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Password <span class="text-red">*</span></label> 
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control" />
                  </div>
                </div>   
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
  <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Edit User</h4> 
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


<div class="modal fade" id="changepasswordmodal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Change Password</h4> 
      </div>
      <form id="changepassword" accept-charset="utf-8"  method="post" class="ptt10">   
        <div class="modal-body pt0 pb0" id="showchangepassword_div">
          
        </div>  
        <div class="box-footer">
          <div class="pull-right">
            <button type="submit" id="changepasswordbtn" data-loading-text="Processing" class="btn btn-info pull-right">Save </button>
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

    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();

    if (name == '' || email == '' || password == '') {
      err = 1;
      toastr.warning("Enter mandatory fields", "Warning")
    }

    if (err == 0) {
      $.ajax({
          url: "<?=base_url()?>users/add",
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
              $("#adddetailsbtn").removeAttr('disabled', false);
            }
          }
      });
    }
  }));
});


$(document).ready(function () {
  $("#editdetails").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    var name = $("#ename").val();
    var email = $("#eemail").val();
    var initial_number = $("#einitial_number").val();

    if (name == '' || email == '' || initial_number == '') {
      err = 1;
      toastr.warning("Enter mandatory fields", "Warning")
    }

    if (err == 0) {
      $.ajax({
          url: "<?=base_url()?>users/edit",
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
              $("#editdetailsbtn").removeAttr('disabled', false);
            }
          }
      });
    }
  }));
});



$(document).ready(function () {
  $("#changepassword").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    var current_password = $("#current_password").val();
    var confirm_password = $("#confirm_password").val();

    if (current_password == '' || confirm_password == '') {
      err = 1;
      toastr.warning("Enter mandatory fields", "Warning")
    }

    if(current_password != confirm_password) {
      err = 1;
      toastr.warning("Password & Confirm Password should be same", "Warning") 
    }

    if (err == 0) {
      $.ajax({
          url: "<?=base_url()?>users/changepassword",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $("#changepasswordbtn").attr('disabled', true);
          },
          success: function (response) {
            if(response.status == true) {
              toastr.success(response.msg, response.type);
                reloadpage();
            }else{
              toastr.error(response.msg, response.type);
            }
            $("#changepasswordbtn").removeAttr('disabled', false);
          }
      });
    }
  }));
});


/*delete code*/
$(document).ready(function(){      
  $(document).on('click','.deactivate_detail',function(e){
    e.preventDefault(); 
     var id = $(this).data("id");
     $.ajax({
         url:'<?=base_url()?>users/showban',
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
         url:'<?=base_url()?>users/showapproved',
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
        url: '<?=base_url()?>users/showuserdetails/' + id,
        success: function (res) {
            $("#showclient_details_div").html(res);
        },
        error: function () {
            alert("Fail")
        }
    });
}


function showchangepassworddetails(id, ipdid) {
//console.log(id);
    $.ajax({
        url: '<?=base_url()?>users/showchangepassword/' + id,
        success: function (res) {
            $("#showchangepassword_div").html(res);
        },
        error: function () {
            alert("Fail")
        }
    });
}


</script>