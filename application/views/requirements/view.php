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
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('requirements'); ?>">Requirements</a></li>
          <li class="active">Requirements Details</li>
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
		              <h3 class="box-title">Requirements Details</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		            	<div class="col-sm-12 well well-sm">
			            	<div class="col-sm-12">
			            		<div class="col-sm-2">
									<i class="fa fa-3x fa-building-o padding010 text-muted"></i>
								</div>
								<div class="col-sm-10">
									<b><h4><?php echo $company[0]->name; ?><br/><span style="font-size: 12px;">(Head Office)</span></h4></b>
				            		<?php echo $company[0]->street; ?>
				            		<br>
				            		<?php echo $company[0]->city_name; ?>
				            		<br>
				            		<?php echo $company[0]->state_name; ?>
				            		<br>
				            		<?php echo $company[0]->country_name; ?>
				            		<br><br>
				            		<?php echo $this->lang->line('purchase_mobile')." : ".$company[0]->phone; ?>
				            		<br>
				            		<?php echo $this->lang->line('company_setting_email')." : ".$company[0]->email; ?>
			            		</div>
			            	</div>
			            </div>
			            <div class="col-sd-12">
			            	<div class="col-sm-4">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-file-text-o padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $data[0]->reference_no; ?></h4></b>
				            		
				            		<b><?php echo $this->lang->line('purchase_date')." : ".$data[0]->date; ?></b>
				            		<br>
				            		<br>
			            		</div>
			            	</div>
			            	
			            </div>
			            <div class="col-sm-12" style="overflow-y: auto;">
			            	<table class="table table-hover table-bordered">
			            		<thead>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
			            			<th width="20%"><?php echo $this->lang->line('product_description'); ?></th>			            			
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
			            		</thead>
			            		<tbody>
			            			<?php $i = 1;  $tot = 0; $igst=0; $cgst=0; $sgst=0;
			            				foreach ($items as $value) { ?>
			            			<tr>
			            				<td align="center"><?php echo $i;?></td>
			            				<td><?php echo "HSN:".$value->hsn_sac_code.'<br/>'.$value->name.'('.$value->code.')'; ?></td>
			            				<td align="center"><?php echo $value->quantity; ?></td>
			            			</tr>
			            			<?php $i++;// $tot += $value->gross_total;

			            					//$tot += $value->gross_total; 
			            					/*$igst += $value->igst_tax; 
			            					$cgst += $value->cgst_tax;
			            					$sgst += $value->sgst_tax;

			            					if($value->tax_type == "Inclusive"){
			            						$tot += $value->gross_total - $value->discount - $cgst - $sgst - $igst; 	
			            					}else{
			            						$tot += $value->gross_total - $value->discount ; 	
			            					}*/

			            			 	} 

			            			 ?>
			            		</tbody>
			            	</table>
			            </div>
			            <!-- <div class="col-sm-6" style="padding-bottom:10px;">
			            	<button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">
								<i class="fa fa-money"></i>
								Pay by Paypal
							</button>
			            </div> -->
			            <div class="col-sm-12">
			            	<div class="buttons">
								<div class="btn-group btn-group-justified">
									
									<?php if($this->session->userdata('type') == 'admin'){ ?>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('requirements/pdf/');?><?php echo $data[0]->quotation_id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('product_alert_pdf'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('requirements/print1/');?><?php echo $data[0]->quotation_id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs">Print<!-- <?php echo $this->lang->line('product_alert_pdf'); ?> --></span>
										</a>
									</div>
									<?php } ?>
								</div>
							</div>
			            </div>
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