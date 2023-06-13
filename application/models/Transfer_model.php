<?php
defined('BASEPATH') OR exit('NO direct script access allowed');
class Transfer_model extends CI_Model
{
	/*
		return all record of transfer
	*/
	public function get(){
		return  $this->db->select('t.*,wf.warehouse_name as from_warehouse_name,wt.warehouse_name as to_warehouse_name')
						->from('transfer t')
						->join('warehouse wf','wf.warehouse_id = t.from_warehouse')
						->join('warehouse wt','wt.warehouse_id = t.to_warehouse')
						->where('t.delete_status',0)
						->get()
						->result();
						//return $this->db->get('transfer')->result();
	}
	/*
		return all record of warehouse
	*/
	public function getWarehouse(){

		return $this->db->select('*')
						->from('warehouse w')
						->join('branch b','w.branch_id = b.branch_id')
						->where('w.delete_status',0)
						->get()
						->result();
		
	}
	/* 
		return  single product to add dynamic table 
	*/
	public function getProduct($product_id,$warehouse_id){
		return $this->db->select('p.product_id,code,unit,name,size,cost,price,alert_quantity,image,category_id,subcategory_id,wp.quantity,warehouse_id')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->where('wp.warehouse_id',$warehouse_id)
			 ->where('wp.product_id',$product_id)
		     ->get()
		     ->result();
	}
	/* 
		return  product list to add product 
	*/
	public function getProducts($warehouse_id){
		return  $this->db->select('p.*')
					 ->from('products p')
					 ->join('warehouses_products wp','p.product_id = wp.product_id')
					 ->where('wp.warehouse_id',$warehouse_id)
					 ->where('wp.quantity > 0')
					 ->where('p.delete_status',0)
				     ->get()
				     ->result();
	}
	/*
		add new transfer record in database 
	*/
	public function add($data){
		/*$sql = "insert into transfer (date,to_warehouse,from_warehouse,total,note,user) values(?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('transfer',$data)){
			return $insert_id = $this->db->insert_id(); 
		}
		else{
			return FALSE;
		}
	}
	/*  
		add newly transfer items record in database 
	*/
	public function addAransferItem($data,$product_id,$from_warehouse,$to_warehouse,$quantity){
		$sql = "select * from warehouses_products where product_id = ? AND warehouse_id = ?";
		$query = $this->db->query($sql,array($product_id,$to_warehouse));
		if($query->num_rows()>0){
			$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
			$from_warehouse_quantity = $this->db->query($sql,array($from_warehouse,$product_id))->row()->quantity;

			$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
			$to_warehouse_quantity = $this->db->query($sql,array($to_warehouse,$product_id))->row()->quantity;

			$wquantity = $from_warehouse_quantity - $quantity;
			$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
			$this->db->query($sql,array($wquantity,$from_warehouse,$product_id));

			$wquantity = $to_warehouse_quantity + $quantity;
			$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
			$this->db->query($sql,array($wquantity,$to_warehouse,$product_id));
		}
		else{
			$sql = "insert into warehouses_products (product_id,warehouse_id,quantity) values (?,?,?)";
			$this->db->query($sql,array($product_id,$to_warehouse,$quantity));

			$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
			$from_warehouse_quantity = $this->db->query($sql,array($from_warehouse,$product_id))->row()->quantity;

			$wquantity = $from_warehouse_quantity - $quantity;
			$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
			$this->db->query($sql,array($wquantity,$from_warehouse,$product_id));
		}

	  	/*$sql = "insert into transfer_items (product_id,quantity,gross_total,transfer_id) values (?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('transfer_items',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/*
		return record specify id
	*/
	public function getRecord($id){
		return $this->db->get_where('transfer',array("id"=>$id))->result();
	}
	/*
		return all records of specified id
	*/
	public function getTransferItems($id,$warehouse_id){
		$this->db->select('transfer_items.*,warehouses_products.quantity as warehouses_quantity,products.product_id,code,name,unit,price,cost')
				 ->from('transfer_items')
				 ->join('products','transfer_items.product_id = products.product_id')
				 ->join('warehouses_products','warehouses_products.product_id = products.product_id')
				 ->where('transfer_items.transfer_id',$id)
				 ->where('warehouses_products.warehouse_id',$warehouse_id)
				 ->where('transfer_items.delete_status',0);
		if($query = $this->db->get()){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		save edited record in database 
	*/
	public function edit($id,$data){
		/*$data['id'] = $id;
		$sql = "update transfer set date = ?,to_warehouse = ?,total = ?,note = ?,user = ? where id = ?";
		if($this->db->query($sql,$data)){*/
		$this->db->where('id',$id);
		if($this->db->update('transfer',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete old transfer item when edit transfer
	*/
	public function delete_transfer_items($id,$product_id,$to_warehouse,$from_warehouse){
		
		$sql = "select * from transfer_items where transfer_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($from_warehouse,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$from_warehouse,$product_id));

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($to_warehouse,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity - $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$to_warehouse,$product_id));
		
		/*$sql = "delete from transfer_items where transfer_id = ? AND product_id = ?";
		if($this->db->query($sql,array($id,$product_id))){*/
		$this->db->where('transfer_id',$id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('transfer_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		when warehouse change selected items is delete this function  
	*/
	public function change_warehouse_delete_transfer_items($id,$product_id,$old_warehouse_id,$from_warehouse){
		echo $old_warehouse_id.' '.$product_id;
		exit;
		$sql = "select * from transfer_items where transfer_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($from_warehouse,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$from_warehouse,$product_id));

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($old_warehouse_id,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity - $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$old_warehouse_id,$product_id));

		
		/*$sql = "delete from transfer_items where transfer_id = ? AND product_id = ?";
		if($this->db->query($sql,array($id,$product_id))){*/
		$this->db->where('transfer_id',$id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('transfer_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		check product available in transfer or not 
	*/
	public function checkProductInTransfer($id,$product_id){
		$sql = "select * from transfer_items where transfer_id = ? AND product_id = ? AND delete_status = 0";
		if($quantity = $this->db->query($sql,array($id,$product_id))->num_rows() > 0){

			$sql = "select * from transfer_items where transfer_id = ? AND product_id = ? AND delete_status = 0";
			$quantity = $this->db->query($sql,array($id,$product_id));
			return $quantity->row()->quantity;
		}
		else{
			return false;
		}
		
	}
	/* 
		update quantity in product table 
	*/
	public function updateQuantity($id,$product_id,$to_warehouse,$from_warehouse,$quantity,$old_quantity){
		$sql = "update transfer_items set quantity = ? where transfer_id = ? AND product_id = ?";
		$this->db->query($sql,array($quantity,$id,$product_id));

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($to_warehouse,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity + $quantity - $old_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$to_warehouse,$product_id));

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($from_warehouse,$product_id))->row()->quantity;
		$wquantity = $warehouse_quantity - $quantity + $old_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$from_warehouse,$product_id));
	}
	/* 
		delete transfer record in database 
	*/
	public function delete($id){
		/*$sql = "delete from transfer where id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('id',$id);
		if($this->db->update('transfer',array('delete_status'=>1))){
			/*$sql = "delete from transfer_items where transfer_id = ?";
			if($this->db->query($sql,array($id))){
				return TRUE;
			}*/
			$this->db->where('transfer_id',$id);
			$this->db->update('transfer_items',array('delete_status'=>1));
		}
		else{
			return FALSE;
		}
	}
  	public function addtransport($data){
		/*$sql = "insert into transfer (date,to_warehouse,from_warehouse,total,note,user) values(?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('transport_pay',$data)){
			return $insert_id = $this->db->insert_id(); 
		}
		else{
			return FALSE;
		}
	}
 
  public function get_data() {
       $this->db->select('*');
		$this->db->from('transport_pay');
     $this->db->where('delete_status','!=',1);
		$query = $this->db->get();
		return $query->result();
    }
  public function get_editrecord($id){
  	$sql = "select * from transport_pay where id = ?";
		if($query = $this->db->query($sql,array($id))){
			return $query->result();
		}
		else{
			return FALSE;
		}
  }
  public function update_transport($data,$id){
  	$this->db->where('id',$id);
		if($this->db->update('transport_pay',$data)){
			return true;
		}
		else{
			return false;
		}
  
  }
  public function deletetransport($id){		
    $this->db->where('id',$id);
		if($this->db->update('transport_pay',array('delete_status'=>1))){
			
		}
		else{
			return FALSE;
		}

	}
  	public function projectadd($data){
		/*$sql = "insert into transfer (date,to_warehouse,from_warehouse,total,note,user) values(?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('project',$data)){
			return $insert_id = $this->db->insert_id(); 
		}
		else{
			return FALSE;
		}
	}
   public function get_project() {
       $this->db->select('*');
		$this->db->from('project');
     $this->db->where('delete_status','!=',1);
		$query = $this->db->get();
		return $query->result();
    }
  public function get_edit_project($id){
  	$sql = "select * from project where id = ?";
		if($query = $this->db->query($sql,array($id))){
			return $query->result();
		}
		else{
			return FALSE;
		}
  }
  public function update_project($data,$id){
  
  	$this->db->where('id',$id);
		if($this->db->update('project',$data)){
			return true;
		}
		else{
			return false;
		}
  }
  public function project_delete($id){
  	
    $this->db->where('id',$id);
		if($this->db->update('project',array('delete_status'=>1))){
		
		}
		else{
			return FALSE;
		}
  }
  
}
?>