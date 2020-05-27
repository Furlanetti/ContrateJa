<?php
class Category_model extends CI_Model {
	
	public function insert($data){
		$this->db->insert('category',$data);
		return $this->db->insert_id();
	}
	
	public function select(){
		$this->db->select('title,category_id');
		$this->db->where('active','1');
		return $this->db->get('category')->result();
	}
    
    public function select_by_id($category_id){
        $this->db->select('title,category_id');
        $query = $this->db->get_where('category',array('category_id' => $category_id))->row();
        return $query;
    }
}
?>
	