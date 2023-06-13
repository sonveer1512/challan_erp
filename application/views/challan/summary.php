<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');

if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
  $this->load->view('layout/header');
}
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

    <!-- Main content -->
    <section class="content">
      	<div class="row">
	      	<!-- right column -->
	      	<div class="col-md-12">
		        <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Challan Details</h3>
		            </div>
		           
		            <div class="box-body">

		            	<table id="table2">
					        <tr>
					            <th style="text-align: center;">DELIVERY CHALLAN </th>
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
                      <?php
						foreach ($c_data as $challan_data) { 
							echo "Dispatch To -" . $challan_data['dispatch_to'];?><br>
                         <?php echo "Dispatch From -" . $challan_data['dispatch_from']; 
                        }
                      ?>

					    <table id="table4">
                        
		            		<thead>
                              
		            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
		            			<th width="40%"><?php echo $this->lang->line('product_description'); ?> of Product</th>
		            			<th style="text-align: center;">HSN</th>
		            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
		            			<th style="text-align: center;">Weight</th>
		            			<th style="text-align: center;">Price</th>
		            			<th style="text-align: center;">Amount</th>
		            		</thead>
		            		<tbody>
		            			<?php $i = 1; $total = $weight = $quantity = 0;
		            				foreach ($items as $value) { ?>
		            			<tr>-

		            				<td align="center"><?php echo $i;?></td>
		            				<td><?= $value['name'];?><?= $value['code']; ?></td>
		            				<td><?=$value['hsn_sac_code'];?></td>
		            				<td align="center"><?php $quantity = $quantity + $value['Quantity']; echo $value['Quantity']; ?></td>
		            				<td align="center"><?php $weight +=(int) filter_var($value['weight'], FILTER_SANITIZE_NUMBER_INT); echo $value['weight']; ?></td>
		            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php echo $value['price']; ?></td>
		            				<td align="center"><?php echo $this->session->userdata('symbol'); ?> <?php $total = $total + !empty($value['total'] ? $value['total'] : '0' ); echo $value['total']; ?></td>
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
								        	<div class="col-sm-6" style="text-align: right; padding-right: 20px;"><?php echo $this->session->userdata('symbol'); ?> <?php echo $total; ?> </div>
								        </div>
							        </div>
							    
							    </td>
					        </tr>
					    </table>

					    <table id="table2" style="height:100px">
					        <tr>

					            <td valign="top"  style="width: 50%; text-align: center; ">
					            	RECEIVED BY
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
