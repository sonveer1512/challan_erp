<!DOCTYPE html>
<html>
<head>
	<title>
		Delivery Challan
	</title>
	<style type="text/css">
		h4 { margin: 5px 0px;  }

		table { width: 100%; }
		table td { padding: 1px 5px; }
		table th { padding: 2px 10px; }

	    #table2 {
	    	border: 1px solid black;
	        border-collapse: collapse;
	    }

	    #table2 td { font-size: 11px; }

	    #table3 td { border: 1px solid;font-size: 11px; }

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
	    	font-size: 11px;
	    }

	    #table4 td {
	    	border: 1px solid black;
	    	font-size: 11px;
	    }

		td.tablebor {
		    border-left: 1px solid #000;
		}

		.for-watermark-div {
			position: fixed;
		    bottom: 40%;
		    text-align: center;
		    right: 26%;
		    font-weight: 700;
		    font-family: system-ui;
		    font-size: 53px;
		    opacity: 0.5;
		    z-index: 99;
		    color: #96919496;
		    -ms-transform: rotate(60deg);
		    -webkit-transform: rotate(60deg);
		    transform: rotate(320deg);
		}

	</style>
</head>
<body>

	<div class="for-watermark-div">NOT FOR SALE <br><br> ONLY FOR EXHIBITION USE</div>

	<div class="row">
      	<!-- right column -->
      	<div class="col-md-12">
	        <div class="box">
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
				                <div class="col1" style="font-size: 11px;">
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
				            <td style="width: 60%">Site Contact No.:- <?php echo $data[0]->site_contact_no; ?></td>
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
	            			<th style="text-align: center;">Received Qty</th>
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
	            				<td align="center">₹ <?php echo $value->price; ?></td>
	            				<td align="center">₹ <?php $total = $total + $value->total; echo $value->total; ?></td>
	            				<td align="center"> <?=$value->received_quantity?> </td>
	            			</tr>
	            			<?php $i++; } ?>

	            			<?php for($j = $i; $j < 39; $j++) { ?>
	            				<tr>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            				<td>&nbsp;</td>
		            			</tr>
	            			<?php } ?>
	            		</tbody>
	            	</table>

				    <table id="table3">   
				        <tr>
					        <td style="width: 50%">
				        		Note: This Material is NOT FOR SALE only Exhibition Purpose
				    		</td> 
					        <td style="width: 50%">
					        	Approximate Value:-  <span style="float: right; padding-right: 20px;">₹ <?php echo $total; ?></span>
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
		            	<div class="col-sm-12 col-xs-12">
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
</body>
</html>
<script>
window.print();
</script>