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
            Transport
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
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('transport_pay/add');?>" title="Add New Category" onclick=""> Add Transport Pay

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
                  <th>Transporter Name</th>
                  <th>Vehicle No</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Rate/Price</th>
                  <th>Bill Date</th>
                  <th>Bill No</th>
                  <th>remark</th>
                  <th><?php echo $this->lang->line('category_lable_actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($data as $row) {
                    $id= $row->id;
                    ?>
                    <tr>
                      <td><?= $id ?></td>
                       <?php if(!empty($row->image)) {?>
                            <td><img class="img-fluid rounded-circle" alt="" src="<?= base_url() ?>/<?= $row->image?>" width="100" height="100"></td>
                            <?php } else {?>
                            	<td><img class="img-fluid rounded-circle" alt="" src="https://us.123rf.com/450wm/pandavector/pandavector1901/pandavector190105281/126044187-isolated-object-of-avatar-and-dummy-symbol-collection-of-avatar-and-image-stock-symbol-for-web.jpg?ver=6" width="100" height="100"></td>
                            <?php }?>
                     
                      <td><?php echo $row->p_name; ?></td>
                      <td><?php echo $row->t_name; ?></td>
                      <td><?php echo $row->vehicle_no; ?></td>
                      <td><?php echo $row->from; ?></td>
                      <td><?php echo $row->to; ?></td>
                      <td><?php echo $row->rate; ?></td>
                      <td><?php echo $row->bill_date; ?></td>
                      <td><?php echo $row->bill_no; ?></td>
                      <td><?php echo $row->remark; ?></td>
                     
                      <td>
                          <a href="<?php echo base_url('transport_pay/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="<?php echo base_url('transport_pay/delete/'); ?><?php echo $id; ?>" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
             <!--   <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('category_lable_no'); ?></th>
                  <th>Driver Name</th>
                  <th>Vehicle Number</th>
                  <th>Vehicle Type</th>
                  <th>Vehicle Capacity</th>
                  <th><?php echo $this->lang->line('category_lable_actions'); ?></th>
                </tr>
                </tfoot> -->
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
