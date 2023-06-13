<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transport_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	public function index(){
		
	} 
	/* 
		return all category data 
	*/
	public function getCategory(){
		$data = $this->db->get_where('transport_settings',array('delete_status'=>0));
		return $data->result();
	}

	/* return category count */
	public function getCategoryCount(){
		$this->db->select('*');
		$query = $this->db->get_where('transport_settings',array('delete_status'=>0));
		// $data = $query->result();

		// if($data != null){
		// 	return sizeof($data);
		// }else{
		// 	return 0;
		// }
		return $query->result();
		
	}
	/* 
		insert new categoty record in Database 
	*/
	public function addModel($data){
		/*$sql = "insert into category (category_code,category_name) values(?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('transport_settings',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return selected id record use in edit page 
	*/
	public function getRecord($id){
		$sql = "select * from transport_settings where id = ?";
		if($query = $this->db->query($sql,array($id))){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		this function is used to save edited record in database 
	*/

	public function editModel($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('transport_settings',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}

		

	}

	/* 
		this function delete category from database  
	*/
	public function deleteModel($id){	
		/*$sql = "delete from category where category_id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('id',$id);
		if($this->db->update('transport_settings',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>