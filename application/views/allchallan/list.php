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
          <li class="active">All Challan</li>
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
              <h3 class="box-title">All Challan List</h3>
              <!--<a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('challan/add');?>">Add New Challan</a>-->
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
                    <th>Consignee</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Transport Details</th>
                    <th>Project Name</th>
                    <th>Transporter Name</th>
                    <th>E-Bay Bill No</th>
                    <th><?php echo $this->lang->line('product_action'); ?></th>
                   
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $key=>$row) {
                       $id= $row->id;
                  ?>
                  <tr>
                    <td><?=++$key;?></td>
                    <td><?php echo $row->serial_number; ?></td>
                    <td><?php echo strtoupper($row->type); ?></td>
                    <td><?php echo date("d-M-Y", strtotime($row->date)); ?></td>
                    <td> <?php echo $row->customer_name ?> </td>
                    <td><?php echo $row->dispatch_from ;?></td>
                    <td><?php echo $row->dispatch_to ;?></td>

                    <td>
                       <?php echo $row->vehicle_number ?> (<?php echo $row->driver_name ?>) 
                    </td>
                   	<?php if(!empty($row->project_id)){ ?>
                   <?php $query = $this->db->query("SELECT * FROM project where id = $row->project_id");
						$result = $query->result_array(); ?>
                    <?php if(!empty($result)){ ?>
                    <td><?= $result[0]['p_name']; ?></td>
                <?php } }else {?>
                    <td></td>
                    <?php } ?>
                    
                    
                    	<?php if(!empty($row->transport_id)){ ?>
                   <?php $query = $this->db->query("SELECT * FROM transport_pay where id = $row->transport_id");
						$result = $query->result_array(); ?>
                    <?php if(!empty($result)){ ?>
                    <td><?= $result[0]['t_name']; ?></td>
                <?php } }else {?>
                    <td></td>
                    <?php } ?>
                    <td><?=$row->e_pay ?></td>
                    <td>
                       
                          
                            

                           

                            <button type="button" class="btn btn-info">
                              <a href="<?php echo base_url('challan/pdf/');?><?php echo $id; ?>" target="_blank  " style="color:white;"><i class="fa fa-file-pdf-o"></i>&nbsp;<?php echo $this->lang->line('purchase_download_as_pdf'); ?></a>
                            </button>

                            
                         
                       
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
