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
                    <th>Products</th>
                    <th>Challan Reports </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $row) {

                      $pro = $this->challan_model->getQuotationshortItems($row->id);
                      if(!empty($pro)) {

                       $id= $row->id;
                      ?>

                      <tr>
                        <td></td>
                        <td><?php echo $row->serial_number; ?></td>
                        <td><?php echo strtoupper($row->type); ?></td>
                        <td><?php echo date("d-M-Y", strtotime($row->date)); ?></td>
                        <td><?php echo $row->biller_name ?></td>
                        <td><a href="<?=base_url()?>challan/site/<?=$row->customer_id?>"> <?php echo $row->customer_name ?> </a></td>

                        <td>
                          <table class="table table-striped table-bordered">
                            <tr>
                              <td>Products </td>
                              <td>Name </td>
                              <td>Quantity </td>
                              <td>Received Quantity </td>
                              <td>Short </td>
                            </tr>
                          <?php $j=0; foreach($pro as $proval) { $j++; ?>
                            <tr>
                              <td><?=$j?></td>
                              <td><?=$proval->name?></td>
                              <td><?=$proval->quantity?></td>
                              <td><?=$proval->received_quantity?></td>
                              <td><?php $short = $proval->quantity-$proval->received_quantity;
                                if($short < $proval->quantity){ ?>
                                <p style="color:red;"><?=$short;?></p>
                                <?php }else{ ?>
                              <p><?=$short;?> <?php } ?></p>
                              </td>
                            </tr>
                          <?php } ?>
                          </table>
                        </td>

                        <td>
                          <div class="dropdown">
                            <a href = "<?php echo base_url('challan/shortView/'.$row->id);?>" class="btn btn-default" > View  </a>

                          </div>
                        </td>
                      <?php

                      }
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
