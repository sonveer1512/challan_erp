<?php 
if(!empty($lead)) { $i = 0; foreach($lead as $result) { $i++; ?>
<tr>
  <td> <input type="checkbox" name="checkbox[]" value="<?php echo $result['lead_id'];?>"> </td>
    
  <td><?=$i?></td>
  
  <td>
    <?=$this->auth->persondetails($result['cname'], $result['cmobile'], $result['cmail']);?>
    <b>Enquiry Date</b> -<?php echo $result['create_on'];?>
  </td>

  <td><?=$this->auth->tripdetails($result['lead_id']);?></td>
  <td>
    
    <select class="form-control assignuser" name="user_id" data-id="<?=$result['lead_id']?>">
            <option value="">select user</option>
            <?php foreach($user as $value) { ?>      
              <option value=<?php echo $value['user_id'];?> <?php if(!empty($result['assign_user_id'])) { if($result['assign_user_id'] == $value['user_id']) { echo "selected"; } } ?> ><?php echo $value['user_name'];?></option>
            <?php } ?>
        </select>
        <span id="assignerr_<?=$result['lead_id']?>" style="display: none; color: green">User Assigned Successfully</span>

  </td>
  <td>
    
    <a data-toggle="modal" data-target="#addfollowup" onclick="showclientdetails(<?=$result['lead_id']?>)">Add Quick Followup</a> <br>
      <span id="followuperr_<?=$result['lead_id']?>"></span> 
      <span id="followuperrtime_<?=$result['lead_id']?>"></span>

      <span id="lastfollowup_<?=$result['lead_id']?>">
        <?php $followup = $this->admin_model->leadfollowup('followupstatusmaster','lead_id',$result['lead_id']); 
        if(!empty($followup)) {
          foreach($followup as $val) {
            echo $val['followup_text']." at ".$val['followup_date']."<br>"; 
          } }?>
      </span>

  </td>
  <td>
    <a class="btn-sm btn btn-success" href="<?=base_url()?>Lead/view/<?=$result['lead_id'];?>" target="_blank"><i class="fa fa-search-plus"></i></a>
      <a class="btn-sm btn btn-info" href="<?=base_url()?>Lead/edit/<?=$result['lead_id'];?>" target="_blank"><i class="fa fa-edit"></i></a>  
      <a class="btn-sm btn btn-danger" href="<?=base_url()?>Lead/delete/<?=$result['lead_id'];?>"onclick="return confirm('Are you sure to Delete!');"><i class="fa fa-trash-o"></i></a> 
  </td>
  <td>
    <div class="dropdown dropdown-action">
          <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-plus"></i></a>
          <div class="dropdown-menu dropdown-menu-right" style="padding: 5px;">
            <a class="btn btn-success" href="https://wa.me/?text=<?=$this->auth->regardsus($result['lead_id'])?>" target="_blank"><i class="fa fa-whatsapp"></i> To Agent</a>
            <br><br>
            <a class="btn btn-success" href="https://wa.me/+91<?=$result['cmobile']?>?text=<?=$this->auth->msgtoclient($result['lead_id'])?>" target="_blank"><i class="fa fa-whatsapp"></i> To Client</a>
          </div>
      </div>
  </td>
</tr>
<?php } } ?>