<input type="hidden" name="user_id" value="<?php if(!empty($user_details[0]['id'])) { echo $user_details[0]['id']; } ?>">

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">Name <span class="text-red">*</span></label> 
      <input type="text" name="name" id="ename" placeholder="Name" class="form-control" value="<?php if(!empty($user_details[0]['name'])) { echo $user_details[0]['name']; } ?>" />
    </div>
  </div> 

  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">Mobile Number</label> 
      <input type="text" name="mobile" id="emobile" placeholder="Mobile" class="form-control" value="<?php if(!empty($user_details[0]['phone'])) { echo $user_details[0]['phone']; } ?>" />
    </div>
  </div>   
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">Email Address<span class="text-red">*</span></label> 
      <input type="text" name="email" id="eemail" placeholder="Email Address" class="form-control" value="<?php if(!empty($user_details[0]['email_id'])) { echo $user_details[0]['email_id']; } ?>" />
    </div>
  </div> 

  <div class="col-md-6">
    <div class="form-group">
      <label class="form-label">User Name<span class="text-red">*</span></label> 
      <input type="text" name="username" id="username" placeholder="Email Address" class="form-control" value="<?php if(!empty($user_details[0]['username'])) { echo $user_details[0]['username']; } ?>" />
    </div>
  </div> 
</div>