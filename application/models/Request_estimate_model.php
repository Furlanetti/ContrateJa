<?php
class Request_estimate_model extends CI_Model {
	
	public function insert($data,$subcategories){
	    $this->db->set('datetime', 'NOW()', FALSE);
        $this->db->insert('request_estimate',$data);
        $request_estimate_id = $this->db->insert_id();
        /*
        foreach ($subcategories as $subcategory) {
            $var = array('subcategory_id' => $subcategory->subcategory_id,
                'request_estimate_id' => $request_estimate_id);
            $this->db->insert('request_estimate_subcategory',$var);    
        }*/
        return $request_estimate_id;
    }
    
    public function get_by_id($request_estimate_id){
        $this->db->select('DATE_FORMAT(re.datetime,"%d/%m/%Y %H:%i") datetime_request, c.name, re.request_estimate_id, comp.company_name, re.category_id, re.company_id, re.consumer_id, re.description, re.title');
        $this->db->join('company comp','comp.company_id = re.company_id','left');
        $this->db->join('consumer c','c.consumer_id = re.consumer_id','left');
        $this->db->where('re.status != 0');
        $request_estimate = $this->db->get_where('request_estimate re',array('re.request_estimate_id' => $request_estimate_id))->row();
        
        $this->db->select('s.title');
        $this->db->join('company_subcategory cs','cs.company_id = c.company_id');
        $this->db->join('subcategory s','s.subcategory_id = cs.subcategory_id');
        $subc = $this->db->get_where('company c',array('c.company_id' => $request_estimate->company_id))->result();
        
        $this->db->select('cat.title');
        $this->db->join('company_category cc','cc.company_id = c.company_id');
        $this->db->join('category cat','cat.category_id = cc.category_id');
        $cat = $this->db->get_where('company c',array('c.company_id' => $request_estimate->company_id))->result();
        
        $request_estimate->subcategory = $subc;
        $request_estimate->category = $cat;
        
        /*$this->db->select('s.subcategory_id,s.title');
        $this->db->join('subcategory s','s.subcategory_id = r.subcategory_id');
        $subcategories = $this->db->get_where('request_estimate_subcategory r',array('r.subcategory_id' => $request_estimate->subcategory_id))->result();
        
        $request_estimate->subcategories = $subcategories;*/
        return $request_estimate;
    }
    
    public function select_by_company_id($company_id){
        $this->db->select('if(e.request_estimate_id is null,"Não Respondido",if(e.status = 2, "Orçamento aprovado","Respondido")) status,
            if(e.request_estimate_id is null,null,e.estimate_id) estimate_id,
            re.request_estimate_id,
            DATE_FORMAT(re.datetime,"%d/%m/%Y %H:%i") datetime_request,
            DATE_FORMAT(e.datetime,"%d/%m/%Y %H:%i") datetime_estimate,
            re.category_id,
            re.company_id, 
            re.consumer_id,
            re.description,
            re.title,
            c.name consumer_name',false);
        $this->db->join('consumer c','c.consumer_id = re.consumer_id');
        $this->db->join('estimate e','e.request_estimate_id = re.request_estimate_id','left');
        $this->db->where('re.status != 0');
        $this->db->group_by('re.request_estimate_id');
        $requests_estimate = $this->db->get_where('request_estimate re',array('re.company_id' => $company_id))->result();
        return $requests_estimate;
    }
    
    public function select_by_consumer_id($consumer_id){
        $this->db->select('if(e.request_estimate_id is null,"Não Respondido",if(e.status = 2, "Orçamento aprovado","Respondido")) status,
            if(e.request_estimate_id is null,null,e.estimate_id) estimate_id,
            re.request_estimate_id,
            DATE_FORMAT(re.datetime,"%d/%m/%Y %H:%i") datetime_request,
            DATE_FORMAT(e.datetime,"%d/%m/%Y %H:%i") datetime_estimate,
            re.category_id,
            re.company_id, 
            re.consumer_id,
            re.description,
            re.title,
            c.company_name company_name',false);
        $this->db->join('company c','c.company_id = re.company_id');
        $this->db->join('estimate e','e.request_estimate_id = re.request_estimate_id','left');
        $this->db->where('re.status != 0');
        $this->db->group_by('re.request_estimate_id');
        $requests_estimate = $this->db->get_where('request_estimate re',array('re.consumer_id' => $consumer_id))->result();
        return $requests_estimate;
    }
}
?>
	