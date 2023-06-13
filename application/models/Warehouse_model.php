<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouse_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	public function index(){
		
	} 
	/* return warehouse details to display list*/
	public function getWarehouse(){
		return $this->db->select('w.warehouse_id,w.warehouse_name,b.branch_name,primary_warehouse,u.first_name,u.last_name')
				 ->from('warehouse w')
				 ->join('branch b ','w.branch_id = b.branch_id')
				 ->join('users u','u.id = w.user_id')
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
	}
	/* return branch detalis */
	public function getBranch(){
		$this->db->select('*');
		$query = $this->db->get_where('branch',array('delete_status'=>0));
		return $query->result();
		
	}

	/* return warehouse count */
	public function getWarehouseCount(){
		$this->db->select('*');
		$query = $this->db->get_where('warehouse',array('delete_status'=>0));
		// $data = $query->result();

		// if($data != null){
		// 	return sizeof($data);
		// }else{
		// 	return 0;
		// }
		return $query->result();
		
	}
  
   //add product werehouse  
  
   function getwerehouse(){

   
 
    // Select werehouse
    $this->db->select('*');
    $query = $this->db->get('warehouse');
   return $query->result();

    
  }


  function getwerehouseproduct(){
  
 
    // Select record
    $query=$this->db->select('*')
				 ->from('products')
				 
				
				
				 ->get();
     return $query->result();
  }
  function getproduct(){
  
 
    // Select record
    $query=$this->db->select('wp.product_id,wp.warehouse_id,p.name,p.product_id')
				 ->from('warehouses_products wp')
				 ->join('products p ','wp.product_id = p.product_id')
					->where('wp.product_id = p.product_id')
				
				 ->get();
     return $query->result();
  }
  public function add_product_werehouse($data)
{
    $this->db->insert('warehouses_products', $data);
}
	

	/* add new record in databse */
	public function addModel($data){

		/*if($data['primary_warehouse']==1){
			$this->makeWarehouseSecondary($this->getCurrentPrimaryWarehouse());
		}*/

		$sql = "insert into warehouse (warehouse_name,primary_warehouse,branch_id,user_id) values(?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('warehouse',$data)){*/
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* return record to edit record */
	public function getRecord($id){
		$sql = "select * from warehouse where warehouse_id = ?";
		if($query = $this->db->query($sql,array($id))){
		/*$this->db->where('warehouse_id',$data);
		if($query = $this->db->get('warehouse')){*/
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* save edited record in database */
	public function editModel($data,$id){

		/*if($data['primary_warehouse']==1){
			$this->makeWarehouseSecondary($this->getCurrentPrimaryWarehouse());
		}*/

		$sql = "update warehouse set branch_id = ?,warehouse_name = ?,user_id = ?, primary_warehouse = ? where warehouse_id = ?";
		if($this->db->query($sql,array($data['branch_id'],$data['warehouse_name'],$data['user_id'],$data['primary_warehouse'],$id))){
		/*$this->db->where('warehouse_id',$id);
		if($this->db->update('warehouse',$data)){*/
			
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/* make other warehouse secondary */
	public function makeWarehouseSecondary(){

			$data = $this->db->select('*')
					 ->from('warehouse')
					 ->where('delete_status',0)
					 ->get()
					 ->result();
			if($data != null){
				$secondary_warehouse_sql = "update warehouse set primary_warehouse = 0";
				$this->db->query($secondary_warehouse_sql,array($this->getCurrentPrimaryWarehouse()));	
			}
			
			
	}

	/* get warehouse id of current primary warehouse */
	public function getCurrentPrimaryWarehouse(){

		$sql = "select warehouse_id from warehouse where primary_warehouse = 1";
		if($query = $this->db->query($sql)){
			/*$this->db->where('warehouse_id',$data);
			if($query = $this->db->get('warehouse')){*/
			$data = $query->result();
			return $data[0]->warehouse_id; 
			//return $data->warehouse_id;
		}
		else{
			return FALSE;
		}
	}

	/* check warehouse if primary or not */
	public function isPrimaryWarehouse($warehouse_id){

		$sql = "select primary_warehouse from warehouse where warehouse_id = ?";
		if($query = $this->db->query($sql,array($warehouse_id))){
			/*$this->db->where('warehouse_id',$data);
			if($query = $this->db->get('warehouse')){*/
			$data = $query->result();
			if($data[0]->primary_warehouse == 1){
				return TRUE;
			}else{
				return FALSE;
			}
			
			//return $data->warehouse_id;
		}
		else{
			return FALSE;
		}
	}

	/* delete record in database */
	public function deleteModel($id){
		/*$sql = "delete from warehouse where warehouse_id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('warehouse_id',$id);
		if($this->db->update('warehouse',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>