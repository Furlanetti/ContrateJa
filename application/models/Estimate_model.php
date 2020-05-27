<?php
class Estimate_model extends CI_Model {
	
	public function insert($data){
	    $this->db->set('datetime', 'NOW()', FALSE);
		$this->db->insert('estimate',$data);
		$estimate_id = $this->db->insert_id();
        return $estimate_id;
	}
    
    public function select_by_id($estimate_id){
        $this->db->select('company_id, description,price,status');
        $this->db->where('status != 0');
        $query = $this->db->get_where('estimate',array('estimate_id' => $estimate_id))->row();
        return $query;
    }
    
    public function select_by_company_id($company_id){
        $this->db->select('company_id, description,price,status');
        $this->db->where('status != 0');
        $query = $this->db->get_where('estimate',array('company_id' => $company_id))->row();
        return $query;
    }
    
    public function select_by_consumer_id($consumer_id){
        $this->db->select('e.company_id, e.description,e.price,e.status');
        $this->db->join('request_estimate re','re.request_estimate_id = e.request_estimate_id');
        $this->db->where('re.consumer_id',$consumer_id);
        $this->db->where('e.status != 0');
        $estimate = $this->db->get('estimate e')->result();
        return $estimate;
    }
    
    public function select_status_by_request_estimate_id($request_estimate_id){
        $this->db->select('if(count(estimate_id) > 0, "Respondido","Sem Resposta" ) status');
        $this->db->where('status != 0');
        return $this->db->get_where('estimate',array('request_estimate_id' => $request_estimate_id))->row();
    }
    
    public function aprove($estimate_id){
        $this->db->where('estimate_id',$estimate_id);
        return $this->db->update('estimate',array('status' => 2));
    }
}
?>
	