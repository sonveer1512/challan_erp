<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Requirements extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('requirement_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('sales_model');
		$this->load->model('log_model');
		$this->load->model('ion_auth_model');

		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}


	public function index(){
		// get all sales to display list
		$data['data'] = $this->requirement_model->getQuotation();
		$this->load->view('requirements/list',$data);
	} 


	/* 
		call add view to add sales record 
	*/


	public function add(){
		$data['warehouse'] = $this->sales_model->getSalesWarehouse();
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['warehouse_products'] = $this->requirement_model->getWarehouseProducts(); 
		$data['biller'] = $this->requirement_model->getBiller();
		$data['customer'] = $this->requirement_model->getCustomer(); 
		$data['reference_no'] = $this->requirement_model->createReferenceNo();
		$this->load->view('requirements/add',$data);
	}



	public function edit($id){
		$data['data'] = $this->requirement_model->getRecord($id);
		$data['warehouse'] = $this->sales_model->getSalesWarehouse();
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		$data['warehouse_products'] = $this->requirement_model->getWarehouseProducts(); 
		$data['biller'] = $this->requirement_model->getBiller();
		$data['customer'] = $this->requirement_model->getCustomer(); 
		$data['reference_no'] = $this->requirement_model->createReferenceNo();
		$data['items'] = $this->requirement_model->getQuotationItems2($data['data'][0]->quotation_id);	
		$this->load->view('requirements/edit',$data);
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
	public function addQuotation(){
		
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			
			if($this->input->post('discount') == ""){
				$flat_discount = 0.00;
			}else{
				$flat_discount = $this->input->post('discount');
			}

			if($this->input->post('shipping_charge') ==""){
				$shipping_charge = 0;
			}else{
				$shipping_charge = $this->input->post('shipping_charge');
			}

			if($this->input->post('shipping_bill_date') ==""){
				$shipping_bill_date = null;
			}else{
				$shipping_bill_date = $this->input->post('shipping_bill_date');
			}

			$reference_no = $this->requirement_model->createReferenceNo();

			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"reference_no" 		  =>  $this->input->post('reference_no'),
						"warehouse_id" 		  =>  $this->input->post('warehouse'),
						"customer_id" 		  =>  $this->input->post('customer'),
						"biller_id" 		  =>  $this->input->post('biller'),
						"note" 				  =>  $this->input->post('note'),
						'sales_id'			  =>  $reference_no[0]->quotation_id,
						"user"			      =>  $this->session->userdata('user_id')
					);

			if($quotation_id = $this->requirement_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $quotation_id,
						'message'  => 'Quotation Inserted'
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
						if(isset($value->tax_type)){
							$tax_type = $value->tax_type;
						}else{
							$tax_type = "Exclusive";
						}
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"quotation_id" => $quotation_id
							);
						$this->sales_model->checkProductInWarehouse($product_id,$quantity,$warehouse_id);
						if($this->requirement_model->addQuotationItem($data,$product_id,$warehouse_id,$quantity)){
							
						}
						else{

						}
					}
				}
				redirect('requirements/view/'.$quotation_id);
			}
			else{
				redirect('requirements','refresh');
			}
		}
	}




	public function completed($id){
		$data['completed'] = '1';
		$this->requirement_model->editModel($id,$data);
		redirect('requirements');
	}

	/*  
		this fucntion is to edit sales record and save in database 
	*/
	public function editQuotation(){
		$id = $this->input->post('quotation_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$old_warehouse_id = $this->input->post('old_warehouse_id');
			$warehouse_change = $this->input->post('warehouse_change');

			if($this->input->post('discount') == ""){
				$flat_discount = 0.00;
			}else{
				$flat_discount = $this->input->post('discount');
			}

			if($this->input->post('shipping_charge') ==""){
				$shipping_charge = 0;
			}else{
				$shipping_charge = $this->input->post('shipping_charge');
			}

			if($this->input->post('shipping_bill_date') ==""){
				$shipping_bill_date = null;
			}else{
				$shipping_bill_date = $this->input->post('shipping_bill_date');
			}

			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"note" 				  =>  $this->input->post('note'),
						'sales_id'			  =>  $id,
						"user"			      =>  $this->session->userdata('user_id')
					);


			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));
			if($this->requirement_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Requirements Updated'
					);
				$this->log_model->insert_log($log_data);
				if($js_data!=""){
					foreach ($js_data as $key => $value) {
						if($value=='delete'){
							//echo " delete".$key;
							$product_id =  $php_data[$key];
							if($this->requirement_model->deleteQuotationItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
								//echo " 1.Dsuccess";
							}
						}
						else if($value==null){
							if($warehouse_id != $old_warehouse_id AND $php_data[$key] !=null){
								$product_id =  $php_data[$key];
								if($this->requirement_model->changeWarehouseDeleteQuotationItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
									//echo " 1.Dsuccess";
								}
							}
							else if($warehouse_change == "yes"){
								$product_id =  $php_data[$key];
								if($this->requirement_model->changeWarehouseDeleteQuotationItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
									//echo " 1.Dsuccess";
								}
							}
						}
						else{
							$product_id = $value->product_id;
							$quantity = $value->quantity;
							if(isset($value->tax_type)){
								$tax_type = $value->tax_type;
							}else{
								$tax_type = "Exclusive";
							}
							$data = array(
									"product_id" => $value->product_id,
									"quantity" => $value->quantity,
									"price" => $value->price,
									"quotation_id" => $id
								);
							if($old_quantity = $this->requirement_model->checkProductInQuotation($id,$product_id)){
								$this->requirement_model->updateQuantity($id,$product_id,$warehouse_id,$quantity,$old_quantity,$data);
							}
							else{
								if($this->requirement_model->addQuotationItem($data,$product_id,$warehouse_id,$quantity)){
									//echo " 1 Asuccess add";
								}
								else{

								}
							}
						}
					}
				}
				redirect('requirements','refresh');
			}
		}
	}
	/* 
		this function is used to delete sales record from database 
	*/
	public function delete($id){
		if($this->requirement_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Quotation Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('quotation','refresh');
		}
		else{
			redirect('quotation','refresh');
		}
	}
	/*
		display data in dashboard calendar
	*/
	public function calendar(){
		log_message('debug', print_r($this->db->get('category')->result(), true));
		$data = $this->requirement_model->getCalendarData();
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
		$data['data'] = $this->requirement_model->getDetails($id);
		//$data['check_invoice'] = $this->requirement_model->checkInvoice($id);
		$data['items'] = $this->requirement_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('requirements/view',$data);
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

		$data['data'] = $this->requirement_model->getDetails($id);
		$data['items'] = $this->requirement_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$html = $this->load->view('requirements/pdf',$data,true);

		include(APPPATH.'third_party/mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no,'I');
	}
	public function print1($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Printed'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->requirement_model->getDetails($id);
		$data['items'] = $this->requirement_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('requirements/pdf',$data);
	}

	public function save_pdf($id){

		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->requirement_model->getDetails($id);
		$data['items'] = $this->requirement_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$html = $this->load->view('requirements/pdf',$data,true);

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
		$email = $this->requirement_model->getSmtpSetup();

		$data = $this->requirement_model->getCustomerEmail($id);
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
		$data = $this->requirement_model->getRecord($id);
		$items = $this->requirement_model->getItems($id);
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
						"total" 			  =>  $data[0]->total,
						"discount_value"	  =>  $data[0]->discount_value,
						"tax_value" 		  =>  $data[0]->tax_value,
						"note" 				  =>  $data[0]->note,
						"shipping_city_id"    =>  $data[0]->shipping_city_id,
						"shipping_state_id"   =>  $data[0]->shipping_state_id,
						"shipping_country_id" =>  $data[0]->shipping_country_id,
						"shipping_address"    =>  $data[0]->shipping_address,
						"shipping_charge"     =>  $data[0]->shipping_charge,
						"internal_note"       =>  $data[0]->internal_note,
						"gst_payable"   	  =>  $data[0]->gst_payable,
						"sales_invoice"    	  =>  $data[0]->sales_invoice,
						"sales_type"    	  =>  $data[0]->sales_type,
						"port_code"     	  =>  $data[0]->port_code,
						"shipping_bill_no"    =>  $data[0]->shipping_bill_no,
						"shipping_bill_date"  =>  $data[0]->shipping_bill_date,
						"supplier_ref"     	  =>  $data[0]->supplier_ref,
						"buyer_order"         =>  $data[0]->buyer_order,
						"dispatch_document_no"=>  $data[0]->dispatch_document_no,
						"delivery_note_date"  =>  $data[0]->delivery_note_date,
						"dispatch_through"    =>  $data[0]->dispatch_through,
						"tax_id"     		  =>  $data[0]->tax_id,
						"user"			      =>  $this->session->userdata('user_id')
					);
		$invoice = array(
				"invoice_no" => $this->sales_model->generateInvoiceNo(),
				"sales_amount" => $data[0]->total,
				"quotation_id" => $data[0]->quotation_id,
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
}
?>