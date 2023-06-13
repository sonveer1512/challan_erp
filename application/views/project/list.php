<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='<?php  echo base_url('transport_setting/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><!-- Category --> 
            Project
          </li> 
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><!-- List Category -->
                  Vehicle List
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('project/add');?>" title="Add New Category" onclick=""> Add New Project

              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('category_lable_no'); ?></th>
                  <th>Image</th>
                  <th>Project Name</th>
                  <th>Location</th>
                  <th>Site manager</th>
                  <th>contact</th>
                  <th><?php echo $this->lang->line('category_lable_actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($data as $row) {
                    $id= $row->id;
                    ?>
                    <tr>
                      <td></td>
                      <?php if(!empty($row->image)) {?>
                            <td><img class="img-fluid rounded-circle" alt="" src="<?= base_url() ?>/<?= $row->image?>" width="100" height="100"></td>
                            <?php } else {?>
                            	<td><img class="img-fluid rounded-circle" alt="" src="https://us.123rf.com/450wm/pandavector/pandavector1901/pandavector190105281/126044187-isolated-object-of-avatar-and-dummy-symbol-collection-of-avatar-and-image-stock-symbol-for-web.jpg?ver=6" width="100" height="100"></td>
                            <?php }?>
                      <td><?php echo $row->p_name; ?></td>
                      <td><?php echo $row->	location; ?></td>
                      <td><?php echo $row->site_encharge; ?></td>
                      <td><?php echo $row->contact; ?></td>
                      <td>
                          <a href="<?php echo base_url('project/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="<?php echo base_url('project/projectdelete/'); ?><?php echo $id; ?>" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
