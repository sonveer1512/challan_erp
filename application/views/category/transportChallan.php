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
        window.location.href='<?php  echo base_url('category/delete/'); ?>'+id;
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
            <?php echo $this->lang->line('header_category'); ?>
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
                  <?php echo $this->lang->line('category_lable_lcategory'); ?>
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('category/add');?>" title="Add New Category" onclick=""><!-- Add New Category --> <?php echo $this->lang->line('category_lable_newcategory'); ?>
              <a class="btn btn-sm btn-info pull-right bg-yellow" style="margin: 10px" href="<?php echo base_url('subcategory/add');?>" title="Add New Subcategory" onclick="">Add New Subcategory<?php //echo $this->lang->line('category_lable_newcategory'); ?> 
              <a class="btn btn-sm btn-info pull-right bg-green" style="margin: 10px" href="<?php echo base_url('product/index');?>" title="Go to Category" onclick="">Go to Product <?php //echo $this->lang->line('category_lable_newcategory'); ?>

              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><!-- No --><?php echo $this->lang->line('category_lable_no'); ?></th>
                  <th><!-- Category Code --><?php echo $this->lang->line('category_lable_code'); ?></th>
                  <th><!-- Category Name --><?php echo $this->lang->line('category_lable_cname'); ?></th>
                  <th><!-- Actions --><?php echo $this->lang->line('category_lable_actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($data as $row) {
                        $id= $row->category_id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->category_code; ?></td>
                      <td><?php echo $row->category_name ?></td>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo base_url('category/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><!-- No --><?php echo $this->lang->line('category_lable_no'); ?></th>
                  <th><!-- Category Code --><?php echo $this->lang->line('category_lable_code'); ?></th>
                  <th><!-- Category Name --><?php echo $this->lang->line('category_lable_cname'); ?></th>
                  <th><!-- Actions --><?php echo $this->lang->line('category_lable_actions'); ?></th>
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
