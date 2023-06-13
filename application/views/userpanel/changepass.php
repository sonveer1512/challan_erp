<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/all/style.css">


<div class="content-wrapper">
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <br/>
                    <form id="changepassword" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                              
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Password<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  name="current_pass" required="required" class="form-control col-md-7 col-xs-12" type="password"  value="">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input   required="required" class="form-control col-md-7 col-xs-12" name="new_pass" placeholder="" type="password"  value="">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Confirm Password<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="confirm_pass" name="confirm_pass" placeholder="" type="password"  value="" class="form-control col-md-7 col-xs-12" >
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="changepasswordbtn" class="btn btn-info">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
$(document).ready(function () {
  $("#changepassword").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    $.ajax({
        url: "<?=base_url()?>Dashboard/changepassword",
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
            $("#changepasswordbtn").removeAttr('disabled', false);
        }
    });

  }));
});

</script>