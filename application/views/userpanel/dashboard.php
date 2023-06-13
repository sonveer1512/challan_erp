<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/all/style.css">

<div class="content-wrapper">
	<section class="content" id="dashboard">

    <div class="row">
      <div class="col-md-12">

      	<form action="<?=base_url()?>Lead/assigned" method="post">
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title titlefix">Lead List</h3>
	          </div><!-- /.box-header -->
	          <div class="box-body">
	            <div class="download_label">Lead List</div>
	            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	              <thead>
	                <tr>
                   	<th>S.No. </th>
                  	<th>Details </th>
                  	<th>Website</th>
                    <th>Contact Person 1 Details </th>
                    <th>Contact Person 2 Details </th>
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
        </form>   

      </div>                                                                                                                                          
    </div>

  </section>
</div>



<?php include 'leads/leadstructure.php'; ?>




<div class="modal fade" id="addfollowup" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" data-dismiss="modal">&times;</button>
                <h4 class="box-title">Quick Followup</h4> 
            </div>
            <form id="formedit" accept-charset="utf-8"  method="post" class="ptt10">   
                <div class="modal-body pt0 pb0" id="showquickfollowup_div">

                </div>  
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" id="formeditbtn" data-loading-text="Processing" class="btn btn-info pull-right"> Save</button>
                        <br>
                        <div><span id="followupsubmitnotify"></span></div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>


<script type="text/javascript">
$(document).ready(function(){      
    $(document).on('change','.assignuser',function(e){
      e.preventDefault(); 
       var id = $(this).data("id");
       var user = $(this).val();
       $.ajax({
           url:'<?=base_url()?>Lead/assignuser',
           type:"get",
           data:"id="+id+"&user="+user,
           processData:false,
           contentType:false,
           cache:false,
           async:false,
           success: function(response){
            if(response.status == true) {
              $("#assignerr_"+id).css('display','block');
            }
           }
       });
    });
});



$(document).ready(function(){      
    $(document).on('click','.refreshdata',function(e){
      e.preventDefault(); 
       $.ajax({
           url:'<?=base_url()?>Lead/showleads',
           processData:false,
           contentType:false,
           cache:false,
           async:false,
           success: function(response){
            if(response.status == true) {
              $("#changedata").html(response.output)
            }
           }
       });
    });
});



function showclientdetails(id, ipdid) {
    $.ajax({
        url: '<?=base_url()?>userpanel/dashboard/showquickfollowupdiv/' + id,
        success: function (res) {
            $("#showquickfollowup_div").html(res);
        },
        error: function () {
            alert("Fail")
        }
    });
}



$(document).ready(function (e) {
  $("#formedit").on('submit', (function (e) {
    e.preventDefault();
    $("#formeditbtn").button('loading');
    $.ajax({
        url: '<?php echo base_url(); ?>userpanel/dashboard/updatelead',
        type: "POST",
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data.status == "fail") {
                $("#followupsubmitnotify").html("<span class='err'>Error try again...</span>");
            } else {
                $("#followupsubmitnotify").html("<span class='err'>Submitted Successfully..</span>");
                $("#addfollowup").modal('hide');
                $("#lastfollowup_"+data.id).html("");
                $("#followuperr_"+data.id).html(data.followup+" at ");
                $("#followuperrtime_"+data.id).html(data.followup_date);
            }
            $("#formeditbtn").button('reset');
        },
        error: function () {
            //  alert("Fail")
        }

    });
  }));
});
</script>

<script type="text/javascript">
$(document).ready(function () {
  $(".fileupload").on('submit', (function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    $.ajax({
        url: "<?=base_url()?>Leads/addfileforservice",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $("#fileuploadsubmit").attr('disabled', true);
        },
        success: function (response) {
          if(response.status == true) {
            toastr.success(response.msg, response.type);
            reloadpage();
          }else{
            toastr.error(response.msg, response.type);
          }

          $("#fileuploadsubmit").removeAttr('disabled', false);
        },
        error: function () {
            alert("Fail")
        }
    });
  }));
});
</script>

<script type="text/javascript">
$(document).ready(function () {
  $("#submitdateform").on('submit', (function (e) {
    e.preventDefault();
    err = 0;
    var formData = new FormData(this);
    formData.append('action', "enqdet");

    $.ajax({
        url: "<?=base_url()?>userpanel/dashboard/changedatadatewise",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          $("#changedata").html(res);
        }
    });

  }));
});

</script>
