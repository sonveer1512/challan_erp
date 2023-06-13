<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$p = array('admin','sales_person','manager', 'purchaser');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('<?php echo $this->lang->line('product_delete_conform'); ?>'))
     {
        window.location.href='<?php  echo base_url('requirements/delete/'); ?>'+id;
     }
  }
  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $(".message").hide('blind', {}, 500)
    }, 5000);
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Requirements</li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <?php
        if($message = $this->session->flashdata('message')){
      ?>
        <div class="col-sm-12 message">
          <div class="alert alert-success">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $message; ?>
            <div class="alerts-con"></div>
          </div>
        </div>
      <?php
        }
      ?>
      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Requirements List</h3>
              <a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('requirements/add');?>">Add New Requirements</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <th><?php echo $this->lang->line('purchase_reference_no'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($data as $row) {
                         $id= $row->quotation_id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->date; ?></td>
                      <td><?php echo $row->reference_no; ?></td>
                      </td>
                      <td>
                          <div class="dropdown">
                            <button type="button" class="btn btn-default gropdown-toggle" data-toggle="dropdown">
                              <?php echo $this->lang->line('product_action'); ?>
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                              <?php if($this->session->userdata('type') == 'admin' && $row->completed == '0'){ ?>
                              <li>
                                <a href="<?php echo base_url('requirements/completed/');?><?php echo $id; ?>"><i class="fa fa-check"></i>Completed</a>
                              </li>
                              <?php } ?>
                              <li>
                                <a href="<?php echo base_url('requirements/view/');?><?php echo $id; ?>"><i class="fa fa-file-text-o"></i>Requirements Details</a>
                              </li>
                              <li>
                                <a href="<?php echo base_url('requirements/edit/'); ?><?php echo $id; ?>"><i class="fa fa-edit"></i>Edit Requirements</a>
                              </li>
                            </ul>
                          </div>
                      </td>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <th><?php echo $this->lang->line('purchase_reference_no'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </tfoot>
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
