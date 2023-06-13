<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id) {
     if(confirm('<?php echo $this->lang->line('product_delete_conform'); ?>')) {
        window.location.href='<?php  echo base_url('challan/delete/'); ?>'+id;
     }
  }

  $(function() {
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
          <li class="active">Challan</li>
        </ol>
      </h5>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">

      <?php if($message = $this->session->flashdata('message')){ ?>
        <div class="col-sm-12 message">
          <div class="alert alert-success">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $message; ?>
            <div class="alerts-con"></div>
          </div>
        </div>
      <?php } ?>

      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Challan List</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped" data-page-length='100'>
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('product_no'); ?></th>
                    <th>Transport Details</th>
                    <th>Transporter Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Type</th>
                    <th>Total Challen </th>
                    <th>Summmary</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $key=>$row) {
                       $id= $row->id;
                  ?>
                  <tr>
                    <td><?=++$key;?></td>
                    <td><a href="<?=base_url()?>challan/transport/<?=$row->vehicle_id?>"> <?php echo $row->vehicle_number ?> </a></td>
                    <td><a href="<?=base_url()?>challan/transport/<?=$row->vehicle_id?>">  <?php echo $row->transporter ?> </a></td>
                    <td><?php echo $row->dispatch_from ;?></td>
                    <td><?php echo $row->dispatch_to ;?></td>
                    <td><?= strtoupper($row->type);?></td>
                    <td><?php echo $row->count; ?></td>
                    <td><a href="<?=base_url()?>challan/summary/<?=$row->customer_id?>"  class="btn btn-default">
                            Summary</span> </a>


                  <?php
                    }
                  ?>
                </tbody>

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
