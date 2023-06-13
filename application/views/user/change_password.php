<input type="hidden" name="user_id" value="<?php if(!empty($user_details[0]['id'])) { echo $user_details[0]['id']; } ?>">

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">New Password <span class="text-red">*</span></label> 
      <input type="password" name="current_password" id="current_password" placeholder="XXXXXX" class="form-control" />
    </div>
  </div> 

  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">Confirm Password <span class="text-red">*</span></label> 
      <input type="password" name="confirm_password" id="confirm_password" placeholder="XXXXXX" class="form-control" />
    </div>
  </div>   
</div>