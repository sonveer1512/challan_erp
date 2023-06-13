<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
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
        window.location.href='<?php  echo base_url('challan/delete/'); ?>'+id;
     }
  }
</script>

<style type="text/css">
	table, td, th,tr {
        border: 1px solid black;
    }

    #table2 {
        border-collapse: collapse;
    }
    .rowcol{
        width: 100%;
    }
    .coldiv1{
        width: 50%;
        float: left;
    }
    .coldiv1:nth-child(2){
        text-align: right;
    }
    .coldiv2{
        width: 100%;
        font-size: 12px;
        font-weight: 700;
    }	
</style>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('challan'); ?>">Challan</a></li>
          <li class="active">Challan Details</li>
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
		              <h3 class="box-title">Challan Details</h3>		              
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">

		            	<table style="width:100%" id="table2">
					        <tr>
					            <th colspan="7" style="text-align: center;">DELIVERY CALLEN OUTWARDS/INWARD</th>
					        </tr>
					        <tr>
					            <th colspan="2">
					                <div class="col1">
					                    <?php if(isset($company[0]->logo)){?>
    								<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" width="120px">	
    							<?php }else{?>
    								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="100%">
    							<?php } ?>
					                </div>
					            </th>
					            <th colspan="5">    
					                <div class="col1">
					                    content
					                </div>
					            </th>
					        </tr>
					        <tr>
					            <td colspan="3" >CONSIGNOR</td>
					            <td colspan="2">Callan No.</td>
					            <td colspan="2">0001</td> 
					        </tr>
					        <tr>
					            <td colspan="3" >Name:- DEEPALI DESIGNS & EXHIBITS PVT. LTD</td>
					            <td colspan="2">Callen Date</td>
					            <td colspan="2">25.01.2022</td> 
					        </tr>
					        <tr>
					            <td colspan="3" >Address:- KHUNMOH,SRI NAGAR</td>
					            <td colspan="2">Place of Supply</td>
					            <td colspan="2">25.01.2022</td> 
					        </tr>
					        <tr>
					            <td colspan="3" ></td>
					            <td colspan="2">Place of Supply</td>
					            <td colspan="2">25.01.2022</td> 
					        </tr>
					        <tr>
					            <td colspan="3" ></td>
					            <td colspan="1">Place of Supply</td>
					            <td colspan="1">25.01.2022</td> 
					        </tr>
					        <tr>
					            <td colspan="4" ></td>
					            <td colspan="2">Place of Supply</td>
					            <td colspan="2">25.01.2022</td> 
					        </tr>
					        <tr>
					            <td colspan="3" style="border:0px">FROM:</td>
					            <td colspan="2" style="border:0px">BAKOLI, DELHI</td>
					            <td colspan="2" style="border:0px">Destination: SRINAGAR</td>
					        </tr>
					        <tr>
					            <td>SN</td>
					            <td>Description of Product</td>
					            <td>HSN</td>
					            <td>UoM</td>
					            <td>Qty</td>
					            <td>Rate</td>
					            <td>Total</td>
					        </tr>
					        <tr>
					        <td colspan="3">
					            Terms & Conditions:
					        </td> 
					        <td colspan="2">Approximate Value</td> 
					        <td colspan="2">&#8377; 14,91600,00</td> 
					        </tr>
					        <tr>
					            <td colspan="3">
					                <div class="rowcol" >
					                    <div class="coldiv1" style="text-align:center;">
					                        ORDER BY
					                    </div>
					                    <div class="coldiv1" style="text-align:center;">
					                        RECEVED BY
					                    </div>
					                </div>            
					            </td> 
					            <td colspan="4">
					                <div class="rowcol" >
					                    <div class="coldiv2" style="text-align:center;">
					                        FOR DEEPALI DESIGNS & EXHIBITS PVT. LTD
					                    </div>
					                    <div class="coldiv2" style="text-align:right;">
					                    AUTH.SIGN.
					                    </div>
					                </div>       
					               </td> 
					        </tr>
					    </table>




































	            		<div class="row">
	            			<div class="col-md-1"></div>
		            		<div class="col-md-2 col-sm-2" style="text-align: right;">
			            		<?php if(isset($company[0]->logo)){?>
    								<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" width="120px">	
    							<?php }else{?>
    								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="100%">
    							<?php } ?>
    						</div>
    						<div class="col-md-6 col-sm-6" style="text-align: center;">
		            			<b><h4 style="font-size: 30px;"><?php echo $company[0]->name; ?><br/></h4></b>
			            		<?php echo $company[0]->street; ?>
			            		<br>
			            		<?php echo $company[0]->city_name; ?>,
			            		<?php echo $company[0]->state_name; ?>,
			            		<?php echo $company[0]->country_name; ?>,
			            		<?php echo $company[0]->zip_code; ?>
			            		<br>
			            		<?php echo $this->lang->line('purchase_mobile')." : ".$company[0]->phone; ?>,			            		
			            		<?php echo $this->lang->line('company_setting_email')." : ".$company[0]->email; ?>
			            	</div>
			            </div>	

			            <div class="row" style="margin-top: 10px;">
			            	<div class="col-sm-6">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-file-text-o padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $data[0]->serial_number; ?></h4></b>
			            		</div>
			            	</div>
			            	<div class="col-sm-6">
			            		<div class="col-sm-12" style="text-align: right;">
			            			<?php $date=date_create($data[0]->date); ?>
				            		<b><?php echo $this->lang->line('purchase_date')." : ".date_format($date,"d M, Y"); ?></b>
			            		</div>
			            	</div>
			            </div>


			            <div class="row">
			            	<div class="col-sm-6">
		            			<b><h4>
		            				<?php if(isset($data[0]->customer_name)){ echo $data[0]->customer_name; } ?>
		            				<br/><span style="font-size: 12px;">(Customer)</span>
		            			</h4></b>
			            			<?php if(isset($data[0]->customer_address)){ echo $data[0]->customer_address; } ?>
			            		<br>
			            			<?php if(isset($data[0]->customer_city)){ echo $data[0]->customer_city; } ?>
	            				<br>
			            			<?php if(isset($data[0]->customer_state)){ echo $data[0]->customer_state; } ?>
			            		<br>
			            			<?php if(isset($data[0]->customer_country)){ echo $data[0]->customer_country; } ?>
			            		<br>
			            			<?php 
		            					if(isset($data[0]->customer_mobile)){
		            						echo $this->lang->line('purchase_mobile')." : ".$data[0]->customer_mobile;
		            					}else{
		            						echo $this->lang->line('purchase_mobile')." : Not Available";
		            					} 
		            				?>
			            		<br>
			            			<?php 
		            					if(isset($data[0]->customer_email)){
		            						echo $this->lang->line('company_setting_email')." : ".$data[0]->customer_email;
		            					}else{
		            						echo $this->lang->line('company_setting_email')." : Not Available";
		            					} 
		            				?>
			            	</div>
			            	<div class="col-sm-6" style="text-align: right;">
		            			<b><h4><?php echo $data[0]->biller_name ?><br/><span style="font-size: 12px;">(Branch Office)</span></h4></b>
			            		<?php echo $data[0]->biller_address; ?>
			            		<br>
			            		<?php echo $data[0]->biller_city; ?>
			            		<br>
			            		<?php echo $data[0]->biller_country; ?>
			            		<br>
			            		<?php echo $this->lang->line('purchase_mobile')." : ".$data[0]->biller_mobile; ?>
			            		<br>
			            		<?php echo $this->lang->line('company_setting_email')." : ".$data[0]->biller_email; ?>
			            	</div>
			            </div>

			            <div class="row">
			            	<div class="col-sm-6">
			            			<b><h5 style='font-weight: 600'>Origin: <?php echo $data[0]->dispatch_from; ?></h5></b>
			            	</div>
			            	<div class="col-sm-6" style="text-align: right;">
			            		<b><h5 style='font-weight: 600'>Destination: <?php echo $data[0]->dispatch_to; ?></h5></b>
			            	</div>
			            </div>

			            <div class="row">
			            	<div class="col-sm-6">
			            		<?php 
		            			if(!empty($data[0]->vehicle_id)) {
		            				$vehicle = $this->challan_model->getTransportbyid($data[0]->vehicle_id);
		            				echo "<b><h5 style='font-weight: 600'>Driver Name: ".$vehicle[0]->driver_name."</h5></b>";
		            				echo "<b><h5 style='font-weight: 600'>Vehicle Type: ".$vehicle[0]->vehicle_type."</h5></b>";
		            			}
		            			?>
			            	</div>
			            	<div class="col-sm-6" style="text-align: right;">
			            		<?php 
		            			if(!empty($data[0]->vehicle_id)) {
		            				$vehicle = $this->challan_model->getTransportbyid($data[0]->vehicle_id);
		            				echo "<b><h5 style='font-weight: 600'>Vehicle Number: ".$vehicle[0]->vehicle_number."</h5></b>";
		            			}
		            			?>
			            	</div>
			            </div>

			            <div class="col-sm-12" style="overflow-y: auto;">
			            	<table class="table table-hover table-bordered">
			            		<thead>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
			            			<th width="40%"><?php echo $this->lang->line('product_description'); ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
			            			<th style="text-align: center;">Weight</th>
			            			<th style="text-align: center;">Price</th>
			            			<th style="text-align: center;">Amount</th>
			            			<th style="text-align: center;">Received Quantity</th>
			            		</thead>
			            		<tbody>
			            			<?php $i = 1; $total = $weight = $quantity = 0;
			            				foreach ($items as $value) { ?>
			            			<tr>
			            				<td align="center"><?php echo $i;?></td>
			            				<td><?php echo "HSN:".$value->hsn_sac_code.'<br/>'.$value->name.'('.$value->code.')'; ?></td>
			            				<td align="center"><?php $quantity = $quantity + $value->quantity; echo $value->quantity; ?></td>
			            				<td align="center"><?php $weight = $weight + $value->weight; echo $value->weight; ?></td>
			            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php echo $value->price; ?></td>
			            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php $total = $total + $value->total; echo $value->total; ?></td>
			            				<td align="center"><?php echo $value->received_quantity; ?></td>
			            			</tr>
			            			<?php $i++; } ?>

			            			<tr>
			            				<td align="center"></td>
			            				<td></td>
			            				<td align="center"><?php echo $quantity; ?></td>
			            				<td align="center"><?php echo $weight; ?></td>
			            				<td align="center"></td>
			            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php echo $total; ?></td>
			            				<td align="center"></td>
			            			</tr>
			            		</tbody>
			            	</table>
			            </div>

			            <div class="row">
			            	<div class="col-sm-12">
			            		<b><?php if(!empty($data[0]->note)) { echo "Note:". $data[0]->note; } ?></b>
			            		<b><?php if(!empty($data[0]->internal_note)) { echo "Internal Note:". $data[0]->internal_note; } ?></b>
			            	</div>
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
									
									<div class="btn-group">
										<a class="tip btn btn-info tip" href="<?php echo base_url('challan/email/'); ?><?php echo $data[0]->id; ?>" title="Email">
											<i class="fa fa-envelope-o"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('company_setting_email'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('challan/pdf/');?><?php echo $data[0]->id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('product_alert_pdf'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('challan/print1/');?><?php echo $data[0]->id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs">Print<!-- <?php echo $this->lang->line('product_alert_pdf'); ?> --></span>
										</a>
									</div>
									<?php if(isset($check_invoice->challan_id)){
											if($check_invoice->challan_id==null){ ?>
									<div class="btn-group">
										<a class="tip btn btn-warning tip" href="<?php echo base_url('challan/edit/'); ?><?php echo $data[0]->id; ?>" title="Edit">
											<i class="fa fa-edit"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_edit'); ?></span>
										</a>
									</div>
									<?php }}else{
									?>
										<div class="btn-group">
										<a class="tip btn btn-warning tip" href="<?php echo base_url('challan/edit/'); ?><?php echo $data[0]->id; ?>" title="Edit">
											<i class="fa fa-edit"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_edit'); ?></span>
										</a>
									</div>
									<?php
										} ?>
									<div class="btn-group">
										<a class="tip btn btn-danger bpo" href="javascript:delete_id(<?php echo $data[0]->id;?>)" title="Delete Purchase">
											<i class="fa fa-trash-o"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_delete'); ?></span>
										</a>
									</div>
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