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
	table { width: 100%; }

    #table2 {
    	border: 1px solid black;
        border-collapse: collapse;
    }

    #table3 td { border: 1px solid; }

    #table3 {
    	width: 100%;
    	border: 1px solid black;
        border-collapse: collapse;
    }

    #table4 {
    	width: 100%;
        border-collapse: collapse;
    }

    #table4 th {
    	border: 1px solid black;
    	padding: 7px 0px;
    	background: #f1f1f1;
    }

    #table4 td {
    	border: 1px solid black;
    }

  td.tablebor {
    border-left: 1px solid #000;
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

		            	<table id="table2">
					        <tr>
					            <th style="text-align: center;">DELIVERY CHALLAN <?php echo strtoupper($data[0]->type); ?></th>
					        </tr>
					    </table>
					    
					    <table id="table2">    
					        <tr>
					            <th style="width: 20%;">
					                <div class="col1">
					                    <?php if(isset($company[0]->logo)){?>
	    									<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" width="150px">	
		    							<?php }else{?>
		    								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="100%">
		    							<?php } ?>
					                </div>
					            </th>
					            <th style="width: 80%; text-align: right;">    
					                <div class="col1">
					                    <b><h4 style="font-size: 26px; font-weight: 900"><?php echo $company[0]->name; ?><br/></h4></b>
					            		REGD. OFFICE: <?php echo $company[0]->street; ?>
					            		<br>
					            		<?php echo $company[0]->city_name; ?>,
					            		<?php echo $company[0]->state_name; ?>,
					            		<?php echo $company[0]->country_name; ?>,
					            		<?php echo $company[0]->zip_code; ?>
					            		<br>
					            		WORKS: <?php echo $company[0]->work_address; ?>
					            		<br>
					            		GSTIN : <?php echo $company[0]->gstin; ?> <br>
					            		<?php echo $this->lang->line('purchase_mobile')." : ".$company[0]->phone; ?>,			            		
					            		<?php echo $this->lang->line('company_setting_email')." : ".$company[0]->email; ?>
					                </div>
					            </th>
					        </tr>
					    </table>

					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">CONSIGNEE</td>
					            <td style="width: 20%">Challan No.</td>
					            <td style="width: 20%"><?php echo $data[0]->serial_number; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">Name:- <?=$data[0]->customer_name?> </td>
					            <td style="width: 20%">Challan Date.</td>
					            <td style="width: 20%"><?php $date=date_create($data[0]->date); ?>
				            		<b><?php echo date_format($date,"d M, Y"); ?></b></td> 
					        </tr>
					    </table>

					    <?php $vehicle = $this->challan_model->getTransportbyid($data[0]->vehicle_id); ?>

					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">Address:- <?=$data[0]->shipping_address?> </td>
					            <td style="width: 20%">Vehicle No</td>
					            <td style="width: 20%"><?php echo $vehicle[0]->vehicle_number; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%"></td>
					            <td style="width: 20%">Vehicle Type</td>
					            <td style="width: 20%"><?php echo $vehicle[0]->vehicle_type; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%"></td>
					            <td style="width: 20%">Transporter </td>
					            <td style="width: 20%"><?php echo $data[0]->transporter; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">GST NO:- <?php echo $company[0]->gstin; ?> </td>
					            <td style="width: 20%">Order By </td>
					            <td style="width: 20%"><?php echo $data[0]->order_by; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">SITE CONTACT NO.:- <?php echo $data[0]->site_contact_no; ?></td>
					            <td style="width: 20%">Dispatch By </td>
					            <td style="width: 20%"><?php echo $data[0]->dispatch_by; ?></td> 
					        </tr>
					    </table>
					    <table id="table3">  
					        <tr>
					            <td style="width: 60%">Unloading By:- <?php echo $data[0]->unloaded_by; ?> </td>
					            <td style="width: 20%">Loading By </td>
					            <td style="width: 20%"><?php echo $data[0]->loaded_by; ?></td> 
					        </tr>
					    </table>

					    <table id="table2">  
					        <tr>
					            <td style="width: 50%; border-right: 1px solid; padding-left: 20px ">FROM:- <?php echo $data[0]->dispatch_from; ?> </td>
					            <td style="width: 50%; text-align: right; padding-right: 20px">DESTINATION:- <?php echo $data[0]->dispatch_to; ?> </td>
					        </tr>
					    </table>


					    <table id="table4">
		            		<thead>
		            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
		            			<th width="40%"><?php echo $this->lang->line('product_description'); ?> of Product</th>
		            			<th style="text-align: center;">HSN</th>
		            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
		            			<th style="text-align: center;">Weight</th>
		            			<th style="text-align: center;">Price</th>
		            			<th style="text-align: center;">Amount</th>
		            			<th style="text-align: center;">Received Quantity</th>
		            			<th style="text-align: center;">Short Quantity</th>
		            		</thead>
		            		<tbody>
		            			<?php $i = 1; $total = $weight = $quantity = 0;
		            				foreach ($items as $value) { ?>
		            			<tr>
		            				<td align="center"><?php echo $i;?></td>
		            				<td><?php echo $value->name.'('.$value->code.')'; ?></td>
		            				<td><?=$value->hsn_sac_code?></td>
		            				<td align="center"><?php $quantity = $quantity + $value->quantity; echo $value->quantity; ?></td>
		            				<td align="center"><?php $weight = $weight + $value->weight; echo $value->weight; ?></td>
		            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php echo $value->price; ?></td>
		            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php $total = $total + $value->total; echo $value->total; ?></td>
		            				<td align="center"><?php echo $value->received_quantity; ?></td>
		            				<td align="center"><?php echo $value->quantity- $value->received_quantity; ?></td>
		            			</tr>
		            			<?php $i++; } ?>
		            		</tbody>
		            	</table>

					    <table id="table3">   
					        <tr>
						        <td style="width: 50%">
					        		Note: This Material is NOT FOR SALE only Exhibition Purpose
					    		</td> 
						        <td style="width: 50%">
						        	<div class="row">
						        		<div class="col-md-12">
							        		<div class="col-sm-6">Approximate Value </div>
								        	<div class="col-sm-6" style="float: right; padding-right: 20px;"><?php echo $this->session->userdata('symbol'); ?> <?php echo $total; ?> </div>
								        </div>	
							        </div>
							     <!--    <div class="row">
							        	<div class="col-sm-12">FOR DEEPALI DESIGNS & EXHIBITS PVT. LTD</div>
							        </div>	 -->
							    </td>    
					        </tr>
					    </table>

					    <table id="table2" style="height:100px">                       
					        <tr>
					           
					            <td valign="top"  style="width: 50%; text-align: center; ">            
					            	RECEIVED BY <br><br> <span style="font-size: 24px;"><?php echo $data[0]->material_received; ?></span>
					            </td> 
					            <td  style="width: 50%; position: relative;" valign="top"  class="tablebor" >
					            	<div class="rowcol">
					                    <div class="coldiv2"  style="text-align:center; position: absolute; top: 0px; right: 30px;">
					                      FOR DEEPALI DESIGNS & EXHIBITS PVT. LTD
					                    </div>
					                    <div class="coldiv2"  style="position: absolute; bottom: 0px; right: 30px;">
					                    AUTH.SIGN.
					                    </div>
					                </div>
					         
				            	</td> 
				        	</tr>
					    </table>

			            <div class="row">
			            	<div class="col-sm-12">
			            		<b><?php if(!empty($data[0]->note)) { echo "Note:". $data[0]->note; } ?></b>
			            		<b><?php if(!empty($data[0]->internal_note)) { echo "Internal Note:". $data[0]->internal_note; } ?></b>
			            	</div>
			            </div>

			            <div class="col-sm-12">
			            	<div class="buttons">
								<div class="btn-group btn-group-justified">
									
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('challan/orpdf/');?><?php echo $data[0]->id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('product_alert_pdf'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('challan/shortPrint/');?><?php echo $data[0]->id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs">Print<!-- <?php echo $this->lang->line('product_alert_pdf'); ?> --></span>
										</a>
									</div>
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