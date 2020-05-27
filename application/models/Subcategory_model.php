<?php
class Subcategory_model extends CI_Model {
	
	public function insert($data){
		$this->db->insert('subcategory',$data);
		return $this->db->insert_id();
	}
	
	public function select(){
		$this->db->select('title,subcategory_id,category');
		$this->db->where('active','1');
		return $this->db->get('subcategory')->result();
	}
	
	public function select_by_category($category_id){
		$this->db->select('title,subcategory_id');
		$this->db->where('category_id',$category_id);
		$this->db->where('active','1');
		return $this->db->get('subcategory')->result();
	}
	
    public function get_by_id($subcategory_id){
        return $this->db->get_where('subcategory',array('subcategory_id' => $subcategory_id))->row();
    }
}
?>
	