<?php
class City_model extends CI_Model {
	
	public function insert($data){
		$this->db->insert('category',$data);
		return $this->db->insert_id();
	}
	
	public function select(){
		$this->db->select('city_id,name');
		$this->db->where('active','1');
		$query = $this->db->get('city')->result();
		return $query;
	}
	
}
?>
	