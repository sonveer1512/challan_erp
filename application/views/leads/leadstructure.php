<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-media-content">
      <div class="modal-header modal-media-header">
        <button type="button" class="close pt4" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>
        <h4 class="box-title">Add Leads</h4> 
      </div>
      <form id="addleaddetails" accept-charset="utf-8"  method="post" class="ptt10">   
        <div class="modal-body pt0 pb0">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Name <span class="text-red">*</span></label> 
                <input type="text" name="cname" id="cname" placeholder="Name" class="form-control" />
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Going To</label> 
                <input type="text" name="cgoingTo" id="cgoingTo" placeholder="Contact Person" class="form-control" />
              </div>
            </div> 
          </div>


          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Contact No. <span class="text-red">*</span></label> 
                <input type="text" name="cmobile" id="cmobile" placeholder="Mobile" class="form-control" />
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Email Address <span class="text-red">*</span></label> 
                <input type="text" name="cmail" id="cmail" placeholder="Email Address" class="form-control" />
              </div>
            </div> 
          </div> 


          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Leaving From<span class="text-red">*</span></label> 
                <input type="text" name="cfrom" id="cfrom" placeholder="Origin" class="form-control" />
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Departure Date<span class="text-red">*</span></label> 
                <input type="text" name="creservationDate" id="creservationDate" placeholder="Email Address" class="form-control" />
              </div>
            </div> 
          </div>    

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Duration</label> 
                <select class="form-control" id="cnoDays" name="cnoDays">
                  <option value="">Duration</option>
                  <option value="1">1N/2D</option>
                  <option value="2">2N/3D</option>
                  <option value="3">3N/4D</option>
                  <option value="4">4N/5D</option>
                  <option value="5">5N/6D</option>
                  <option value="5+">6N +</option>
                </select>
              </div>
            </div> 
          </div>

          <div class="row">
            <div class="col-md-12" style="text-align: -webkit-center;">
              <h5><u>Followup Details</u></h5>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Followup Status<span class="text-red">*</span></label> 
                <select class="form-control select2" id="followup" name="followup">
                  <option value="">Select Followup Status</option>
                </select>
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Next Followup Date<span class="text-red">*</span></label> 
                <input type="date" name="date" id="date" placeholder="Date" class="form-control" />
              </div>
            </div> 
          </div> 

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Followup Comment<span class="text-red">*</span></label> 
                <textarea class="form-control" rows="5" name="followup_dis" id="comment"></textarea>
              </div>
            </div> 
          </div> 


          <div class="box-footer">
            <div class="pull-right">
              <button type="submit" id="addleaddetailsbtn" data-loading-text="Processing" class="btn btn-info pull-right">Save </button>
            </div>
          </div>

        </div>  
      </form>
    </div>
  </div>    
</div>



<script type="text/javascript">
$(document).ready(function () {
  $("#addleaddetails").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    $.ajax({
      url: "<?=base_url()?>leads/add",
      type: "POST",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $("#addleaddetailsbtn").attr('disabled', true);
      },
      success: function (response) {
        if(response.status == true) {
          toastr.success(response.msg, response.type);
          reloadpage();
        }else{
          toastr.error(response.msg, response.type);
        }
        $("#addleaddetailsbtn").removeAttr('disabled', false);
      }
    });
  }));
});  
</script>