<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title titlefix">Web Details </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            
            <form action="<?=base_url()?>webdetails/adddetails" enctype="multipart/form-data" method="post" class="ptt10">  

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Title <span class="text-red">*</span></label>                                                
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter a Title.." value="<?php if(!empty($webdetails[0]['title'])) { echo $webdetails[0]['title']; } ?>">
                  </div>  
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="val-username">Logo</label>                                                
                    <input type="file" class="form-control" id="val-email" name="image">
                    <?php if(!empty($webdetails[0]['logo'])) { ?>
                      <img src="<?=base_url().$webdetails[0]['logo']?>" style="width: 100px;">
                    <?php } ?>  
                  </div>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label" for="val-username">Address</label>
                    <textarea class="form-control" name="address" placeholder="Enter Address"><?php if(!empty($webdetails[0]['address'])) { echo $webdetails[0]['address']; } ?></textarea>                
                  </div>  
                </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label" for="val-username">GST Number</label>
                    <input type="text" class="form-control" id="val-username" name="gst_number" placeholder="Enter GST number" value="<?php if(!empty($webdetails[0]['gst_number'])) { echo $webdetails[0]['gst_number']; } ?>">              
                  </div>  
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="val-username">Mobile</label>                                        
                    <input type="text" class="form-control" id="val-username" name="mobile" placeholder="Enter Mobile Number" value="<?php if(!empty($webdetails[0]['mobile'])) { echo $webdetails[0]['mobile']; } ?>">
                  </div>  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="val-username">Email Address</label>
                    <input type="email" class="form-control" id="val-username" name="email" placeholder="Enter Email Address" value="<?php if(!empty($webdetails[0]['email'])) { echo $webdetails[0]['email']; } ?>">
                  </div>  
                </div>
              </div>

              <div class="box-footer">
                <div class="pull-right">
                  <button type="submit" id="adddetailsbtn" data-loading-text="Processing" class="btn btn-info pull-right">Save </button>
                </div>
              </div>
            </form>

          </div>
        </div>                                                    
      </div>                                                                                                                                          
    </div>  
  </section>
</div>
    