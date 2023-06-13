<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('log_model');
		$this->load->library('zend');
	    $this->zend->load('Zend/Barcode');
	    $this->load->model('sales_model');
	    $this->load->model('ion_auth_model');
	    $this->load->model('warehouse_model');
	    $this->load->model('biller_model');

	    if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){

		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();

		// echo $data['user_group'][0]->name;
		if($data['user_group'][0]->name =="sales_person" || $data['user_group'][0]->name =="purchaser"){
			
			$data['data'] = $this->product_model->getProductsWarehouseWise($data['user']->id);

		}else{

			$data['data'] = $this->product_model->getProducts();

		}	

		$data['no_of_warehouse'] = sizeof($this->warehouse_model->getWarehouseCount());
		$data['no_of_category'] = sizeof($this->category_model->getCategoryCount());


		// $data['no_of_branch']	
		// echo '<pre>';
		// print_r($data);
		// exit;

		$this->load->view('product/list',$data);
	}



	/* 
		call add view to add product record 
	*/
	public function add(){
		$data['category'] = $this->product_model->getCategory();
      	$data['subcategory'] = $this->product_model->getSubcategory($id);
     
// 		$data['tax']      = $this->product_model->getTax();
	    $data['sac']      = $this->product_model->getSac();
		$data['chapter']  = $this->product_model->getHsnChapter();
		$data['hsn']      = $this->product_model->getHsn();
		$data['brand']	  = $this->product_model->getBrand();	
		$data['uqc']	  = $this->product_model->getUqc();	
		$this->load->view('product/add',$data);
	}
	/* 
		This function used when category is change subcategory list change  
	*/
	public function getSubcategory($id){
		$data = $this->product_model->selectSubcategory($id);
		echo json_encode($data);
	}
	/*

	*/
	public function getHsnData($id){
		$data = $this->product_model->getHsnData($id);
		echo json_encode($data);
	}
	/* 
		This function is used to add product record in database 
	*/
	public function addProduct(){
		$this->load->helper('security');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	if($_FILES["image"]["name"]){
        		$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "assets/images/product/".uniqid(rand()).'.'.$type;
						
				if(in_array($type,array("jpg","jpeg","gif","png"))){
							
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
								
						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
									
						}
					}	
				}
        	}
        	else{
        		$url = "assets/images/product/no_image.jpg";
        	}
					
		
			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"barcode"		 => $this->barcode($this->input->post('code')),
					"category_id"    => $this->input->post('category'),
					"subcategory_id" => $this->input->post('subcategory'),
					"subsubcat_id"       => $this->input->post('subsubcat'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"weight"         => $this->input->post('weight'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					"alert_quantity" => $this->input->post('alert_quantity'),					
					"opening_stock"  => $this->input->post('opening_stock'),
					"quantity"       => $this->input->post('opening_stock'),
					"igst" 			 => $this->input->post('igst'),
					"cgst" 			 => $this->input->post('cgst'),
					"sgst" 			 => $this->input->post('sgst'),
					/*"tax_id"         => $this->input->post('tax'),*/
					"image"          => base_url().''.$url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note'),
              		"length"		=> $this->input->post('length'),
              		"product_purchase" => $this->input->post('product'),
				);

			if($id = $this->product_model->addModel($data)){ 

				$this->product_model->insertOpeningStock($id,$this->input->post('opening_stock'));

				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Product Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('product','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Product can not be Inserted.');
				redirect("product",'refresh');
			}
		}
	}
	/*
		call edit view to edit product record 
	*/
	public function edit($id){
		$data['data']        = $this->product_model->getRecord($id);
		if($data['data'] == null){
			$this->session->set_flashdata('fail', 'Product is not available. It might be deleted or removed.');
			redirect("product/index",'refresh');
		}
		$data['category']    = $this->product_model->getCategory();
		$data['subcategory'] = $this->product_model->getSubcategory($id);
		$data['tax']         = $this->product_model->getTax();
		$data['sac']         = $this->product_model->getSac();
		$data['chapter']     = $this->product_model->getHsnChapter();
		$data['hsn']         = $this->product_model->getHsn();
		$data['brand']	     = $this->product_model->getBrand();	
		$data['uqc']	     = $this->product_model->getUqc();	
		$this->load->view('product/edit',$data);
	}
	/* 
		This function is used to edit product in database 
	*/
	public function editProduct(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');


		if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
				
			if($_FILES["image"]["name"] == null){
				$url = $this->input->post('hidden_image');
			}
			else{
				$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "./assets/images/product/".uniqid(rand()).'.'.$type;
						
				if(in_array($type,array("jpg","jpeg","gif","png"))){
							
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
								
						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
							$url = base_url().''.$url;	
						}
					}	
				}
			}	


			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"category_id"    => $this->input->post('category'),
					"subcategory_id" => $this->input->post('subcategory'),
					"subsubcat_id"       => $this->input->post('subsubcat'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"weight"         => $this->input->post('weight'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					"alert_quantity" => $this->input->post('alert_quantity'),					
					"opening_stock"  => $this->input->post('opening_stock'),
					"igst" 			 => $this->input->post('igst'),
					"cgst" 			 => $this->input->post('cgst'),
					"sgst" 			 => $this->input->post('sgst'),
					/*"tax_id"         => $this->input->post('tax'),*/
					"image"          => $url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note'),
              		"length"		=> $this->input->post('length'),
				);
			// echo '<pre>';
			// print_r($data);
			// exit;
			if($this->product_model->editModel($data,$id)){ 
				$this->product_model->updateOpeningStock($id,$this->input->post('opening_stock'),$this->input->post('old_qty'));
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Product Updated'
					);
				$this->log_model->insert_log($log_data);
				// redirect('product','refresh');
				$this->session->set_flashdata('success', 'Product updated successfully.');
				redirect("product",'refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Product can not be Updated.');
				redirect("product",'refresh');
			}
		}
	}
	/* 
		This function is used to delete product record in databse 
	*/
	public function delete($id){
		if($this->product_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Product Deleted'
				);
				$this->log_model->insert_log($log_data);
			redirect('product','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Product can not be Deleted.');
			redirect("product",'refresh');
		}
	}
	/*
		this function call CSV file view
	*/
	public function import(){
		$data['category'] = $this->product_model->getCategory();
		$this->load->view('product/import',$data);
	}
    
    public function export(){
        $data['products'] =  $this->product_model->getProducts();
        $this->load->view('product/ProductExport',$data);     
    }
	/*
		this  function get csv file data
	*/
	public function import_csv(){
        
        $category_id 	= $this->input->post('category');
        $update_records = $this->input->post('update_records');
        $filename		= $_FILES["csv"]["tmp_name"];      
    
        if($_FILES["csv"]["size"] > 0)
        {
            $file = fopen($filename, "r");
            
            for ($lines = 0; $data = fgetcsv($file,1000,",",'"'); $lines++) 
            {
            	
            
                if ($lines == 0){
                	if(sizeof($data)!=13){
						if(sizeof($data)<13){
							fclose($file);
	        				$this->session->set_flashdata('fail', 'Few columns are missing in uploaded file.');
							redirect("product/import",'refresh');		
						}else{
							fclose($file);
	        				$this->session->set_flashdata('fail', 'There are few extra columns are available in uploaded file.');
							redirect("product/import",'refresh');		
						}
						
					}else if(
								($data[0] != "Code") || 
								($data[1] != "Name") || 
								($data[2] != "Hsn Sac Code") || 
								($data[3] != "Unit") || 
								($data[4] != "Size") || 
								($data[5] != "Cost") || 
								($data[6] != "Price") || 
								($data[7] != "Opening Qty") || 
								($data[8] != "Alert Quantity") || 
								($data[9] != "Details") ||
								($data[10] != "IGST") ||
								($data[11] != "CGST") ||
								($data[12] != "SGST") ||
								($data[13] != "Weight") 
							){
        				
        				fclose($file);
        				$this->session->set_flashdata('fail', 'File is not having proper format as per sample product file.');
						redirect("product/import",'refresh');	
					}else{
						continue;
					}
                } 

                if($data[10] == null || $data[10] == ""){
                	$igst = 0;
                }else{
                	$igst = $data[10];
                }


                if($data[11] == null || $data[11] == ""){
                	$cgst = 0;
                }else{
                	$cgst = $data[11];
                }


                if($data[12] == null || $data[12] == ""){
                	$sgst = 0;
                }else{
                	$sgst = $data[12];
                }

                
                $sql = "INSERT INTO `products`(
                						`category_id`,
                						`code`, 
                						`name`, 
                						`hsn_sac_code`, 
                						`unit`, 
                						`size`, 
                						`cost`, 
                						`price`,
                						`quantity`, 
                						`opening_stock`, 
                						`alert_quantity`, 
                						`details`,
                						`igst`,
                						`cgst`,
                						`sgst`,
                						`weight`
                						) 
                					VALUES (
                						$category_id,'".
                						trim($data[0])."','".
                						trim($data[1])."','".
                						trim($data[2])."','".
                						trim($data[3])."','".
                						trim($data[4])."','".
                						trim($data[5])."','".
                						trim($data[6])."','".
                						trim($data[7])."','".
                						trim($data[7])."','".
                						trim($data[8])."','".
                						trim($data[9])."','".
                						trim($igst)."','".
                						trim($cgst)."','".
                						trim($sgst)."','".
                						trim($data[13])."')";
                $this->db->query($sql);
                if($id = $this->db->insert_id()){
                	$this->product_model->insertOpeningStock($id,$data[7]);
                }else{
                	$error = $this->db->error();

					if ($error['code'] == 1062) {
						if($update_records=="yes"){
							$product = $this->product_model->getRecordByCode(trim($data[0]));
							$this->product_model->updateOpeningStock($product->product_id,trim($data[7]),$product->quantity);
						}
					}
                }
            }
            fclose($file); 
            $this->session->set_flashdata('success', 'Products are imported successfully.');
			redirect("product",'refresh'); 


        }
        else{
            redirect("product/import",'refresh'); 
        }
        redirect('product','refresh');
	}
	/*
		generate basr code
	*/
	function barcode($code=100)
	{
	    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
	   	$code = time().$code;
	   	$store_image = imagepng($file,"./assets/images/barcode/{$code}.png");
	   	return   base_url('assets/images/barcode/').$code.'.png';
	 
	}
	/*
		call barcode list view
	*/
	public function products_barcode(){
		$data['data'] = $this->product_model->getBarcode();
		$this->load->view('product/barcode',$data);
	}
	function code_exists($code) {
		if($this->product_model->codeExist($code)){
			$this->form_validation->set_message('code_exists', 'Code Already Exist');
			return false;
		}
		else{
			return true;
		}
	}
	function alpha_dash_space($str) {
		if (! preg_match("/^([-a-zA-Z0-9_ ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
   public function datawithcat($category_id){
  
  		 if($category_id != '0') {
          
             
                        $query = $this->db->query("SELECT * FROM `sub_category` WHERE category_id = $category_id");
          					 $result = $query->result_array();	
                        

            $output = '<option value="" selected>Select</option>';
            foreach($result as $value) {
             
                $output .= '<option value="'.$value['sub_category_id'].'">'.$value['sub_category_name'].'</option>';
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }    
   
  }
} 
?>