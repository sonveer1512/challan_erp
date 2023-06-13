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
              <a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('challan/add');?>">Add New Challan</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped" data-page-length='100'>
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('product_no'); ?></th>
                    <th><?php echo $this->lang->line('purchase_reference_no'); ?></th>
                    <th>Type</th>
                    <th><?php echo $this->lang->line('purchase_date'); ?></th>
                    <th><?php echo $this->lang->line('sales_biller'); ?></th>
                    <th>Consignee</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Transport Details</th>
                    <th><?php echo $this->lang->line('product_action'); ?></th>
                    <th>Challan Reports </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($inward as $key=>$row) {
                       $id= $row->id;
                  ?>
                  <tr>
                    <td><?=++$key;?></td>
                    <td><?php echo $row->serial_number; ?></td>
                    <td><?php echo strtoupper($row->type); ?></td>
                    <td><?php echo date("d-M-Y", strtotime($row->date)); ?></td>
                    <td><?php echo $row->biller_name ?></td>
                    <td><a href="<?=base_url()?>challan/site/<?=$row->customer_id?>"> <?php echo $row->customer_name ?> </a></td>
                    <td><?php echo $row->dispatch_from ;?></td>
                    <td><?php echo $row->dispatch_to ;?></td>

                    <td>
                      <a href="<?=base_url()?>challan/transport/<?=$row->vehicle_id?>"> <?php echo $row->vehicle_number ?> (<?php echo $row->driver_name ?>) </a>
                    </td>
                    <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-default gropdown-toggle" data-toggle="dropdown">
                            <?php echo $this->lang->line('product_action'); ?>
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                              <a href="<?php echo base_url('challan/edit/'); ?><?php echo $id; ?>"><i class="fa fa-edit"></i>Edit Challan</a>
                            </li>

                            <?php if($row->type != 'inward') { ?>
                              <li>
                                <a href="<?php echo base_url('challan/addinward/');?><?php echo $row->id; ?>"><i class="fa fa-file-text-o"></i>Create Inward Challan</a>
                              </li>
                              <li>
                                <a href="<?php echo base_url('challan/edit/'); ?><?php echo $row->inward_id; ?>"><i class="fa fa-edit"></i>Edit Inward Challan</a>
                              </li>
                            <?php } ?>

                            <li>
                              <a href="<?php echo base_url('challan/pdf/');?><?php echo $id; ?>" target="_blank  "><i class="fa fa-file-pdf-o"></i><?php echo $this->lang->line('purchase_download_as_pdf'); ?></a>
                            </li>

                            <!-- <li>
                              <a href="<?php echo base_url('challan/email/'); ?><?php echo $id; ?>"><i class="fa fa-envelope"></i><?php echo "Email Challan"; ?></a>
                            </li> -->
                            <li>
                              <a href="javascript:delete_id(<?php echo $id;?>)"><i class="fa fa-trash-o"></i>Delete Challan</a>
                            </li>
                          </ul>
                        </div>
                    </td>

                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn btn-default gropdown-toggle" data-toggle="dropdown"> Reports <span class="caret"></span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">

                          <?php if($row->type != 'inward') { ?>
                            <li> <a href="<?php echo base_url('challan/view/');?><?php echo $id; ?>"><i class="fa fa-file-text-o"></i>Outward Challan</a> </li>
                            <li> <a href="<?php echo base_url('challan/orview/');?><?php echo $id; ?>"><i class="fa fa-file-text-o"></i>Outward Received Challan</a> </li>
                          <?php } ?>

                          <?php if($row->type == 'inward') { ?>
                            <li> <a href="<?php echo base_url('challan/view/');?><?php echo $row->id; ?>"><i class="fa fa-file-text-o"></i>Inward Challan</a> </li>
                            <li> <a href="<?php echo base_url('challan/orview/');?><?php echo $row->id; ?>"><i class="fa fa-file-text-o"></i>Inward Received Challan</a> </li>
                          <?php }else if($row->type !='inward' && $row->inward_id != '0'){ ?>
                          	<li> <a href="<?php echo base_url('challan/view/');?><?php echo $row->inward_id; ?>"><i class="fa fa-file-text-o"></i>Inward Challan</a> </li>
                            <li> <a href="<?php echo base_url('challan/orview/');?><?php echo $row->inward_id; ?>"><i class="fa fa-file-text-o"></i>Inward Received Challan</a> </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </td>
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
