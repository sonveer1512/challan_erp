<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Challan extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('challan_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('sales_model');
		$this->load->model('log_model');
		$this->load->model('product_model');
		$this->load->model('ion_auth_model');
		$this->load->model('purchase_return_model');
     	 $this->load->model('transfer_model');
		if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}
	public function index(){
      	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		$data['data'] = $this->challan_model->getQuotation();
      	//echo $this->db->last_query();exit;
    	$this->load->view('challan/list',$data);
	}
	public function site($id){
        $id = base64_decode($id);
		$data['data'] = $this->challan_model->getsiteQuotation($id);
		$this->load->view('challan/list',$data);
	}
	public function siteWiseChallan(){
		$data['data'] = $this->challan_model->getdashboardsiteQuotation();
		// print_r($data);exit;
		$this->load->view('challan/siteWiseChallan',$data);
	}

  	public function transport($id){
       $id = base64_decode($id);
		$data['data'] = $this->challan_model->gettranportQuotation($id);
     
		$this->load->view('challan/list',$data);
	}
  	public function transportChallen(){
		$data['data'] = $this->challan_model->getdashboardtransportQuotation();
		$this->load->view('challan/transportChallan',$data);
	}
	public function short(){
		$data['data'] = $this->challan_model->getQuotation();
		$this->load->view('challan/shortlist',$data);
	}
	public function add(){
		$data['warehouse'] = $this->sales_model->getSalesWarehouse();
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['warehouse_products'] = $this->challan_model->getWarehouseProducts();
		$data['biller'] = $this->challan_model->getBiller();
		$data['customer'] = $this->challan_model->getCustomer();
		$data['vehicle'] = $this->challan_model->getTransport();
		$data['reference_no'] = $this->challan_model->createReferenceNo();
		$data['uqc']  = $this->product_model->getUqc();
      	$data['warehouselist'] = $this->challan_model->werehouselist();
       	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		$this->load->view('challan/add',$data);
	}
	/*
		this function is used to get discount data when discount is change
	*/
	public function getDiscountAjax($id){
		$data = $this->sales_model->getDiscountAjax($id);
		echo json_encode($data);
	}
	/* get all product warehouse wise */
	public function getProducts($warehouse_id){
		$data = $this->sales_model->getProducts($warehouse_id);
	    echo json_encode($data);
	}
	/* get single product */
	public function getProduct($product_id,$warehouse_id){
		$data = $this->sales_model->getProduct($product_id,$warehouse_id);
		$data['discount'] = $this->sales_model->getDiscount();
		$data['tax'] = $this->sales_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}

	/*
		this function is used to search product name / code in auto complite
	*/
	public function getAutoCodeName($code,$search_option,$warehouse){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->sales_model->getProductCodeName($p_code,$p_search_option,$warehouse);
          if($search_option=="Code"){
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->code.">".$val->code."</li>";
          	}
          	$list .= "</ul>";
          }
          else{
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->product_id.">".$val->name."</li>";
          	}
          	$list .= "</ul>";
          }

          echo $list;
          //echo json_encode($data);
          //print_r($data);
	}

	/*
		this fucntion is used to add sales record in database
	*/
	public function addChallan(){

		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		if($this->form_validation->run()==false){
			$this->add();
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
          
            $rent_product = $this->input->post('product[]');
            $rent_product_description = $this->input->post('productdescription[]');
            $rent_product_unit= $this->input->post('productunit[]');
            $quantity = $this->input->post('qty[]');
            $weight=$this->input->post('weight[]');
            $price=$this->input->post('price[]');
            $total=$this->input->post('total[]');
          	$vendor_name=$this->input->post('vendor_name[]');
          	$warehose = "/".$this->input->post('warehouse_id');
          	$customer_id  =  $this->input->post('customer');
			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"serial_number" 	  =>  $this->input->post('reference_no'),
						"warehouse_id" 		  =>  str_replace($warehose,"",$this->input->post('user_id')),
						"customer_id" 		  =>  $this->input->post('customer'),
						"biller_id" 		  =>  $this->input->post('biller'),
						"note" 				  =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"internal_note"       =>  $this->input->post('internal_note'),
						"dispatch_from"       =>  $this->input->post('dispatch_from'),
						"dispatch_to"    	  =>  $this->input->post('dispatch_to'),
						"vehicle_id"    	  =>  $this->input->post('vehicle_id'),
						"site_contact_no"	  =>  $this->input->post('site_contact_no'),
						"transporter"	  	  =>  $this->input->post('transporter'),
						"order_by"	  		  =>  $this->input->post('order_by'),
						"dispatch_by"	  	  =>  $this->input->post('dispatch_by'),
						"loaded_by"	  	  	  =>  $this->input->post('loaded_by'),
						"user"			      =>  $this->session->userdata('user_id'),
						"type"				  => 'outward',
              			"unloaded_by"	  	  =>  $this->input->post('unloaded_by'),
						"material_received"	  =>  $this->input->post('material_received'),
              			"project_id"		  => $this->input->post('project_id'),
              			"transport_id"		  => $this->input->post('transport_id'),
              			"e_pay"				  => $this->input->post('e_pay'),
              			"vendor"			  => $this->input->post('vendor'),
              			"transport_price"	  => $this->input->post('rate_price'),
					);
          
                
          //print_r($_POST); exit;
         
          //print_r($data);exit;
         
			if($challan_id = $this->challan_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $challan_id,
						'message'  => 'Challan Inserted'
					);
             
				$this->log_model->insert_log($log_data);
				$sales_item_data = $this->input->post('table_data');
              
				$js_data = json_decode($sales_item_data);
              
				foreach ($js_data as $key => $value) {
                 
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"challan_id" => $challan_id,
							"weight" => $value->weight,
							"price" => $value->price,
							"total" => $value->total
							);
                      
                     if($this->input->post('warehouse_id') == 'warehouse'){                      
                          $this->sales_model->checkProductInWarehouse($product_id,$value->quantity,$customer_id);
                          if($this->challan_model->addQuotationItem($data,$product_id,$warehouse_id,$value->quantity)){
                          }
                     }else{
                       
                     	 $this->sales_model->checkProductaddWarehouse($product_id,$value->quantity,$warehouse_id);
                     } 
					}  
				}
              
          
                  for ($i = 0; $i < count($rent_product); $i++) {
                        $data2 = array(
                                "product_source" 			  =>  "rent",
                                 "challan_id"                 =>  $challan_id,
                          		"vendor_name" 			  	  =>  $vendor_name[$i],
                                "rent_product" 			  	  =>  $rent_product[$i],
                                "rent_product_description" 	  =>  $rent_product_description[$i],
                                "rent_product_unit" 		  =>  $rent_product_unit[$i],
                                "quantity" 		  			  =>  $quantity[$i],
                                "weight" 		              =>  $weight[$i],
                                "price" 				      =>  $price[$i],
                                "total"                       =>  $total[$i]
                            );
                    
                       // $this->db->insert('challan_items', $data2);
                     
                    }
              
              
              
				redirect('challan/view/'.$challan_id);
			}
			else{
				redirect('challan','refresh');
			}
          
		}
	}
	public function addProduct(){
		$this->load->helper('security');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric|xss_clean');
		if ($this->form_validation->run() == FALSE)
        {
            $temp = array('status' => false);
        }
        else
        {
        	$url = "assets/images/product/no_image.jpg";

			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"weight"         => $this->input->post('weight'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('cost'),
					"image"          => base_url().''.$url,
					"date"           => date('Y-m-d'),
					"category_id"	 => '1',
					'user_id'  		 => $this->session->userdata('user_id'),
				);
			if($id = $this->product_model->addModel($data)){
				$this->product_model->insertOpeningStock($id,'500');
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Product Inserted'
					);
				$this->log_model->insert_log($log_data);
				$temp = $this->purchase_return_model->getProductUseCode2($id);
			}
			else{
				$temp = array('status' => false);
			}
		}
		echo json_encode($temp);
	}
	/*
		call edit view to edit sales record
	*/
	public function edit($id){
		$data['data'] = $this->challan_model->getRecord($id);
		$data['warehouse'] = $this->challan_model->getQuotationWarehouse();
		$data['biller'] = $this->challan_model->getBiller();
		$data['biller_id'] = $data['data'][0]->biller_id;
		$data['biller_state_id'] = $this->sales_model->getBillerStateIdFromBiller($data['data'][0]->biller_id);
		$data['customer'] = $this->challan_model->getCustomer();
		$data['tax'] = $this->challan_model->getTax();
		$data['discount'] = $this->challan_model->getDiscount();
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->shipping_country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->shipping_state_id);
		$data['product'] = $this->challan_model->getProducts($data['data'][0]->warehouse_id);
		$data['items'] = $this->challan_model->getItems($data['data'][0]->id);
		$data['shipping_state_id'] =  $data['data'][0]->shipping_state_id;
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['vehicle'] = $this->challan_model->getTransport();
		$data['warehouse_products'] = $this->challan_model->getWarehouseProducts();
      	$data['warehouselist'] = $this->challan_model->werehouselist();
      	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('challan/edit',$data);
	}
	public function addinward($id){
		$data['data'] = $this->challan_model->getRecord($id);
		$data['warehouse'] = $this->challan_model->getQuotationWarehouse();
		$data['biller'] = $this->challan_model->getBiller();
		$data['biller_id'] = $data['data'][0]->biller_id;
		$data['biller_state_id'] = $this->sales_model->getBillerStateIdFromBiller($data['data'][0]->biller_id);
		$data['customer'] = $this->challan_model->getCustomer();
		$data['tax'] = $this->challan_model->getTax();
		$data['discount'] = $this->challan_model->getDiscount();
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->shipping_country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->shipping_state_id);
		$data['product'] = $this->challan_model->getProducts($data['data'][0]->warehouse_id);
		$data['items'] = $this->challan_model->getItems($data['data'][0]->id);
		$data['shipping_state_id'] =  $data['data'][0]->shipping_state_id;
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['vehicle'] = $this->challan_model->getTransport();
		$data['warehouse_products'] = $this->challan_model->getWarehouseProducts();
		$data['reference_no'] = $this->challan_model->createReferenceNo();
      	$data['warehouselist'] = $this->challan_model->werehouselist();
      	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('challan/iedit',$data);
	}
	public function editinward($id){
		$data['data'] = $this->challan_model->getRecord($id);
		$data['warehouse'] = $this->challan_model->getQuotationWarehouse();
		$data['biller'] = $this->challan_model->getBiller();
		$data['biller_id'] = $data['data'][0]->biller_id;
		$data['biller_state_id'] = $this->sales_model->getBillerStateIdFromBiller($data['data'][0]->biller_id);
		$data['customer'] = $this->challan_model->getCustomer();
		$data['tax'] = $this->challan_model->getTax();
		$data['discount'] = $this->challan_model->getDiscount();
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->shipping_country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->shipping_state_id);
		$data['product'] = $this->challan_model->getProducts($data['data'][0]->warehouse_id);
		$data['items'] = $this->challan_model->getItems($data['data'][0]->id);
		$data['shipping_state_id'] =  $data['data'][0]->shipping_state_id;
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['vehicle'] = $this->challan_model->getTransport();
		$data['warehouse_products'] = $this->challan_model->getWarehouseProducts();
      	$data['project'] = $this->transfer_model->get_project();
      	$data['transport'] = $this->transfer_model->get_data();
		$this->load->view('challan/edit',$data);
	}
	public function editinwardChallan(){
		$id = $this->input->post('challan_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');

		if($this->form_validation->run()==false){
			$this->edit($id);
		}
		else
		{
          $qty = $this->input->post('qty');
           $recvqty = $this->input->post('received_qty');
      
         
			$warehouse_id = $this->input->post('user_id');
			$qty = $this->input->post('qty');
			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"serial_number" 	  =>  $this->input->post('reference_no'),
						"warehouse_id" 		  =>  $this->input->post('warehouse'),
						"customer_id" 		  =>  $this->input->post('customer'),
						"biller_id" 		  =>  $this->input->post('biller'),
						"note" 				  =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"internal_note"       =>  $this->input->post('internal_note'),
						"dispatch_from"       =>  $this->input->post('dispatch_from'),
						"dispatch_to"    	  =>  $this->input->post('dispatch_to'),
						"vehicle_id"    	  =>  $this->input->post('vehicle_id'),
						"site_contact_no"	  =>  $this->input->post('site_contact_no'),
						"transporter"	  	  =>  $this->input->post('transporter'),
						"order_by"	  		  =>  $this->input->post('order_by'),
						"dispatch_by"	  	  =>  $this->input->post('dispatch_by'),
						"loaded_by"	  	  	  =>  $this->input->post('loaded_by'),
						"user"			      =>  $this->session->userdata('user_id'),
              			"project_id"		  => $this->input->post('project_id'),
              			"transport_id"		  => $this->input->post('transport_id'),
						"type"				  => 'inward'
					);
			if($challan_id = $this->challan_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $challan_id,
						'message'  => 'Challan Inserted'
					);
				$this->log_model->insert_log($log_data);
				$sales_item_data = $this->input->post('table_data');
				$js_data = json_decode($sales_item_data);
				foreach ($js_data as $key => $value) {
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"challan_id" => $challan_id,
							"weight" => $value->weight,
							"price" => $value->price,
							"total" => $value->total,
                          	
							);
						$old_qty = $this->sales_model->checkrecieveProductInWarehouse($product_id,$quantity,$warehouse_id);
						if($this->challan_model->addQuotationItem($data,$product_id,$warehouse_id,$old_qty)){
                          
                          	$qty = $this->input->post('qty');
    						
                        	$sql = "select * from warehouses_products where product_id = $product_id AND warehouse_id = $warehouse_id";
		$query = $this->db->query($sql);
                          if($query->num_rows()>0){
			$warehouse_quantity = $query->row()->quantity;
                           
                           
                         	$newqty = $quantity + $warehouse_quantity;
							
                           
                             $sql = "update warehouses_products set quantity = $newqty  where product_id =$product_id  AND warehouse_id = $warehouse_id";
								$this->db->query($sql);
                            
                          }
						}
					}
				}
				$arr = array('inward_id' => $challan_id);
				$this->challan_model->update_common('challan',$arr,'id',$id);
				redirect('challan/view/'.$challan_id);
			}
			else{
				redirect('challan','refresh');
			}
		}
	}

	/*
		this fucntion is to edit sales record and save in database
	*/
	public function editQuotation(){
		$id = $this->input->post('challan_id');
      
        $challanmainid = $this->input->post('challanmainid[]');

        $rent_product = $this->input->post('product[]');
        $rent_product_description = $this->input->post('productdescription[]');
        $rent_product_unit= $this->input->post('productunit[]');
        $quantity=$this->input->post('qty[]');
        $weight=$this->input->post('weight[]');
        $price=$this->input->post('price[]');
        $total=$this->input->post('total[]');
      
      
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
      
      
      

		if($this->form_validation->run()==false){
			$this->edit($id);
		}
		else
		{
           $qty = $this->input->post('qty');
           $recvqty = $this->input->post('received_qty');
          	$productID = $this->input->post('product_id');
          
			$warehouse_id = $this->input->post('warehouse');
          	$warehouseId = $this->input->post('warehouse_id');
          
			$data = array(
						"internal_note"       =>  $this->input->post('internal_note'),
						"unloaded_by"         =>  $this->input->post('unloaded_by'),
						"material_received"   =>  $this->input->post('material_received'),
              			"e_pay"				  => $this->input->post('e_pay'),
              			"vendor"			  => $this->input->post('vendor'),
              			"transport_price"	  => $this->input->post('rate_price'),
              			"project_id"		  => $this->input->post('project_id'),
              			"transport_id"		  => $this->input->post('transport_id'),
              				
					);
          	for ($i = 0; $i < count($rent_product); $i++) {
          		$data2 = array(
                  		"product_source" 			  =>  "rent",
                        "rent_product" 			  	  =>  $rent_product[$i],
                        "rent_product_description" 	  =>  $rent_product_description[$i],
                        "rent_product_unit" 		  =>  $rent_product_unit[$i],
                        "quantity" 		  			  =>  $quantity[$i],
                        "weight" 		              =>  $weight[$i],
                        "price" 				      =>  $price[$i],
                        "total"                       =>  $total[$i]
                      );
               $this->challan_model->updatechallanrent($challanmainid[$i],$data2);
            };
          
			$this->challan_model->update_common('challan',$data,'id', $id);
			$js_data = json_decode($this->input->post('table_data'));
			if($this->challan_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Challan Updated'
					);
				$this->log_model->insert_log($log_data);
				$received_qty = $this->input->post('received_qty');
              $qty = $this->input->post('qty');
              $challan_items_id = $this->input->post('challan_items_id');
              $proID = $this->input->post('product_id');
             
				
                       for ($i = 0; $i < count($challan_items_id); $i++) {
      
      					$ch_id = $challan_items_id[$i];
                         $rquan = $received_qty[$i];
						$data = array(
							"received_quantity" =>$rquan
						);
						
						if($old_quantity = $this->challan_model->checkProductInQuotation($ch_id)){
                         
                          if($received_qty > $qty)
                          {
                            echo '<script>alert("You have seleted more than recived quantity")</script>';
                          }
                          else{
							$this->challan_model->updateQuantity($ch_id,$proID,$warehouse_id,$rquan,$old_quantity,$data);
                         	
                          }
                          
                        
                        }
                       }
                          //$this->challan_model->InWarehouse($vid,$product_id,$warehouse_id,$quantity,$old_quantity,$data);
						}else{
							$this->challan_model->addQuotationItem($data,$proID,$warehouse_id,$qty);
                $warehouseId = $this->input->post('warehouse_id');
                            
                            $sql = "select * from warehouses_products where product_id = $proID AND warehouse_id = $warehouseId";
                            $query = $this->db->query($sql);
                          if($query->num_rows()>0){
                            $warehouse_quantity = $query->row()->quantity;
                            $warehouse_warehouse_id = $query->row()->warehouse_id;
                            $warehouse_product_id = $query->row()->product_id;
                           
                            $newqty= $recvqty+$warehouse_quantity;
                            
                           
                             $sql = "update warehouses_products set quantity = $newqty  where product_id =$proID  AND warehouse_id = $warehouseId";
                                $this->db->query($sql);
                            
						}
            }
                        
					
				
                  $sql = "select * from warehouses_products";
		$query = $this->db->query($sql,array($proID,$warehouseId));
                          if($query->num_rows()>0){
			$warehouse_ID = $query->row()->warehouse_id;
                      $warehouse_product_id      =$warehouse_quantity = $query->row()->product_id;
                            
                            
				}
				// $item_id 	  = $this->input->post('item_id');
				// $received_qty = $this->input->post('received_qty');
				// for($i = 0; $i < count($item_id); $i++) {
				// 	$datas['received_quantity'] = $received_qty[$i];
				// 	$this->challan_model->updateReceivedQuantity($item_id[$i],$datas);
				// }
				redirect('challan','refresh');
			}
		}
	
	
	/*
		this function is used to delete sales record from database
	*/
	public function delete($id){
		if($this->challan_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Challan Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('challan','refresh');
		}
		else{
			redirect('challan','refresh');
		}
	}
	/*
		display data in dashboard calendar
	*/
	public function calendar(){
		log_message('debug', print_r($this->db->get('category')->result(), true));
		$data = $this->challan_model->getCalendarData();
		$total = 0;
		foreach ($data as $value) {
			$date = Date('Y-m-d');
			if($date == $value->date){
				$total += $value->total;
			}
			$temp = array(
					"title" => $total,
					"start" => "2017-04-05T00:01:00+05:30"
				);
		}
		 echo json_encode($temp);
	}
	/*
		view Sales details
	*/
	public function view($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/view',$data);
	}
	public function orview($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/outward_edit_view',$data);
	}
	public function iview($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/view',$data);
	}
	public function irview($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/view',$data);
	}
	/*
		generate pdf
	*/
	public function pdf($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Quotation PDF Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);
		$data['data'] = $this->challan_model->getDetails($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$html = $this->load->view('challan/pdf',$data,true);
		include(APPPATH.'third_party/mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no,'I');
	}
	public function print1($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/pdf',$data);
	}
	public function orprint1($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/orpdf',$data);
	}
	public function shortPrint($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/shortPrint',$data);
	}
	public function iprint1($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/pdf',$data);
	}
	public function irprint1($id){
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/pdf',$data);
	}
	public function save_pdf($id){
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);
		$data['data'] = $this->challan_model->getDetails($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$html = $this->load->view('challan/pdf',$data,true);
		include(APPPATH.'third_party/mpdf60/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output(realpath(dirname(dirname(__DIR__)) . '/assets/uploads')."/".$data['data'][0]->reference_no.'.pdf','F');

	}
	/*
		send email
	*/
	public function email($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Quotation Email Send'
			);
		$this->save_pdf($id);
		$this->log_model->insert_log($log_data);
		$email = $this->challan_model->getSmtpSetup();
		$data = $this->challan_model->getCustomerEmail($id);
		$company = $this->purchase_model->getCompany();
		$this->load->view('class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $email->smtp_host;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Port = $email->smtp_port;
		$mail->Username = $email->smtp_username;
		$mail->Password = $email->smtp_password;
		$mail->From = $email->from_address;
		$mail->FromName = $email->from_name;
		$mail->AddAddress($data[0]->email);
		//$mail->AddReplyTo("mail@mail.com");
		$mail->IsHTML(true);
		$mail->Subject = "Quotation order No : ".$data[0]->reference_no." From ".$company[0]->name;
		$mail->Body = "Date : ".$data[0]->date."<br>Total : ".$data[0]->total;
		$mail->AddAttachment(realpath(dirname(dirname(__DIR__)) . '/assets/uploads')."/".$data[0]->reference_no.'.pdf');
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
		if(!$mail->Send())
		{
			$message =  "Email could not be sent";
		}
		else{
			$message =  "Email has been sent";
		}
		$this->session->set_flashdata('message', $message);
		redirect('quotation','refresh');
	}
	/*
	*/
	public function getCustomerData($id){
		$data['data'] = $this->customer_model->getRecord($id);
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->state_id);
		echo json_encode($data);
	}
	public function generate_invoice($id){
		$data = $this->challan_model->getRecord($id);
		$items = $this->challan_model->getItems($id);
		$reference_no =  $this->sales_model->createReferenceNo();
		if($reference_no==null){
            $no = sprintf('%06d',intval(1));
        }
        else{
          foreach ($reference_no as $value) {
            $no = sprintf('%06d',intval($value->sales_id)+1);
          }
        }
		$sales_data = array(
						"date" 				  =>  date('Y-m-d'),
						"reference_no" 		  =>  'SO-'.$no,
						"warehouse_id" 		  =>  $data[0]->warehouse_id,
						"customer_id" 		  =>  $data[0]->customer_id,
						"biller_id" 		  =>  $data[0]->biller_id,
						"note" 				  =>  $data[0]->note,
						"shipping_city_id"    =>  $data[0]->shipping_city_id,
						"shipping_state_id"   =>  $data[0]->shipping_state_id,
						"shipping_country_id" =>  $data[0]->shipping_country_id,
						"shipping_address"    =>  $data[0]->shipping_address,
						"shipping_charge"     =>  $data[0]->shipping_charge,
						"internal_note"       =>  $data[0]->internal_note,
						"dispatch_from"	      =>  $data[0]->dispatch_from,
						"dispatch_to"  		  =>  $data[0]->dispatch_to,
						"vehicle_id"    	  =>  $data[0]->vehicle_id,
						"user"			      =>  $this->session->userdata('user_id')
					);
		$invoice = array(
				"invoice_no" => $this->sales_model->generateInvoiceNo(),
				"challan_id" => $data[0]->challan_id,
				"invoice_date" => date('Y-m-d')
			);
			if($sales_id = $this->sales_model->addModel($sales_data,$invoice)){
				$query = 'UPDATE quotation SET sales_id = '.$sales_id.' WHERE quotation_id = '.$data[0]->quotation_id;
				$this->db->query($query);
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $sales_id,
						'message'  => 'Sales Inserted'
					);
				$this->log_model->insert_log($log_data);
				foreach ($items as $key => $value) {
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"price" => $value->price,
							"gross_total" => $value->gross_total,
							"discount_id" => $value->discount_id,
							"discount_value" => $value->discount_value,
							"discount" => $value->discount,
							"igst" => $value->igst,
							"igst_tax" => $value->igst_tax,
							"cgst" => $value->cgst,
							"cgst_tax" => $value->cgst_tax,
							"sgst" => $value->sgst,
							"sgst_tax" => $value->sgst_tax,
							"sales_id" => $sales_id
							);
						$this->sales_model->addSalesItem($data,$product_id,$warehouse_id,$quantity);
					}
				}
				redirect('sales/view/'.$sales_id);
			}
			else{
				redirect('sales','refresh');
			}
	}
	/*
		check character and space validation
	*/
	function alpha_dash_space($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha and spaces');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
    function shortView($id){
        $data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['items'] = $this->challan_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('challan/shortView',$data);
    }

    function week(){
       $id = $this->session->userdata('user_id');
        $sql  ="SELECT q.*,b.*,c.*, t.driver_name, t.id as tid, t.vehicle_number , date FROM   challan q Join biller b on q.biller_id=b.biller_id
        JOIN  customer c on q.customer_id=c.customer_id
        JOIN transport_settings t ON t.id=q.vehicle_id
        WHERE  q.user = $id  AND q.delete_status = 0  AND q.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY  AND q.date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ";
       $query = $this->db->query($sql);
         $data['data'] = $query->result_array();
         $this->load->view('challan/time',$data);

  }

   function month(){
      $id = $this->session->userdata('user_id');
         $sql  ="SELECT q.*,b.*,c.*, t.driver_name, t.id as tid, t.vehicle_number , date FROM   challan q Join biller b on q.biller_id=b.biller_id
        JOIN  customer c on q.customer_id=c.customer_id
        JOIN transport_settings t ON t.id=q.vehicle_id
        WHERE  q.user = '$id'  AND q.delete_status = 0  AND MONTH(q.date) = MONTH(CURRENT_DATE()) AND YEAR(q.date) = YEAR(CURRENT_DATE())";
      	 $query = $this->db->query($sql);
         $data['data'] = $query->result_array();
         $this->load->view('challan/time',$data);
    }
  function year(){
      $id = $this->session->userdata('user_id');
        $sql  ="SELECT q.*,b.*,c.*, t.driver_name, t.id as tid, t.vehicle_number , date FROM   challan q Join biller b on q.biller_id=b.biller_id
        JOIN  customer c on q.customer_id=c.customer_id
        JOIN transport_settings t ON t.id=q.vehicle_id
        WHERE  q.user = '$id'  AND q.delete_status = 0  AND YEAR(q.date) = YEAR(CURDATE())";
      	 $query = $this->db->query($sql);
         $data['data'] = $query->result_array();
         $this->load->view('challan/time',$data);
    }
  function all(){
      $id = $this->session->userdata('user_id');
        $sql  ="SELECT q.*,b.*,c.*, t.driver_name, t.id as tid, t.vehicle_number , date FROM   challan q Join biller b on q.biller_id=b.biller_id
        JOIN  customer c on q.customer_id=c.customer_id
        JOIN transport_settings t ON t.id=q.vehicle_id
        WHERE  q.user = '$id'  AND q.delete_status = 0 ";
      	 $query = $this->db->query($sql);
         $data['data'] = $query->result_array();
         $this->load->view('challan/time',$data);
    }
   function today(){
      $id = $this->session->userdata('user_id');
        $sql  ="SELECT q.*,b.*,c.*, t.driver_name, t.id as tid, t.vehicle_number , date FROM   challan q Join biller b on q.biller_id=b.biller_id
        JOIN  customer c on q.customer_id=c.customer_id
        JOIN transport_settings t ON t.id=q.vehicle_id
        WHERE  q.user = '$id'  AND q.delete_status = 0  AND q.date = date('d')";
      	 $query = $this->db->query($sql);
         $data['data'] = $query->result_array();
         $this->load->view('challan/time',$data);
    }


	function  summary($id){
      $id = base64_decode($id);
      
    
		$data['data'] = $this->challan_model->getDetails($id);
		$data['check_invoice'] = $this->challan_model->checkInvoice($id);
		$data['company'] = $this->purchase_model->getCompany();

		$sqlone = "SELECT ci.*,SUM(ci.quantity) AS Quantity, p.* FROM challan c JOIN challan_items ci ON c.id = ci.challan_id JOIN products p ON p.product_id = ci.product_id WHERE c.dispatch_to = '$id' GROUP BY ci.product_id";
		$query = $this->db->query($sqlone);
		$data['items'] = $query->result_array();
      
     
      $sqltwo = "SELECT * from challan WHERE dispatch_to = '$id'";
		$query = $this->db->query($sqltwo);
		$data['c_data'] = $query->result_array();
		$this->load->view('challan/summary',$data);
	}
    public function inward(){
        $data['inward'] = $this->challan_model->getQuotationtypewise('inward');
        // print_r($data);
        // exit;
		
		$this->load->view('challan/inward',$data);
	}
    public function outward(){
        $data['outward'] = $this->challan_model->getQuotationtypewise('outward');
		// print_r($data);
        // exit;
		$this->load->view('challan/outward',$data);
	}
	public function warehouse($id){

		$sql = "SELECT * FROM `warehouses_products` wp JOIN   products p on wp.product_id = p.product_id  JOIN category c  on p.category_id = c.category_id   where wp.warehouse_id  = $id";
		$query = $this->db->query($sql);
		$data['warehouse'] = $query->result_array();
		
		$this->load->view('product/warehouseProduct',$data);
	}
  	public function transportrate($id){
     	$data = $this->challan_model->get_transportrate($id);
        $hsn = $data[0]['rate'];
        echo json_encode($hsn);
    }
    public function addtransport(){
			$data = array(
						"p_name"     	=>$this->input->post('p_name'),
						"t_name"		=>$this->input->post('t_name'),
						"vehicle_no"	=>$this->input->post('vehicle_no'),
						"from"			=>$this->input->post('from'),
              			"to"			=>$this->input->post('to'),
              			"rate"			=>$this->input->post('rate'),
              			"bill_date"		=>$this->input->post('bill_date'),
              			"bill_no"		=>$this->input->post('bill_no'),
              			"remark"		=>$this->input->post('remark'),
					);
       
          $rand = rand(1000, 9999);
        if ($_FILES['image']['name']) {
            $file = $rand . $_FILES['image']['name'];
            $data['image'] = "assets/transport_pay/" . basename($file);
            move_uploaded_file($_FILES['image']['tmp_name'], "assets/transport_pay/" . $file);
        }
    	$add = $this->transfer_model->addtransport($data);
    	
			if($add){ 
				
				$this->session->set_flashdata('Transport Added Successfully.');
				redirect('challan/add','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Vehicle can not be Inserted.');
				redirect("challan",'refresh');
			}
        	
		
	}
  
  
  
  
  
  
  
}
?>