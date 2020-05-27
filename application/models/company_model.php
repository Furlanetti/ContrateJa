<?php
class Company_model extends CI_Model {
	
	public function insert($data){
		// colocar transaction
		
		$this->db->insert('address',$data->address);
		$address_id = $this->db->insert_id();
		
		$this->db->insert('inf_contact',$data->inf_contact);
		$inf_contact_id = $this->db->insert_id();
		
		$data->company['address_id'] = $address_id;
		$data->company['inf_contact_id'] = $inf_contact_id;
		
		$this->db->insert('company',$data->company);
		$company_id = $this->db->insert_id();
		
		$data->category['company_id'] = $company_id;
		$this->db->insert('company_category',$data->category);
		
		foreach ($data->subcategory as $subcategory) {
			$subcategory['company_id'] = $company_id;
			$this->db->insert('company_subcategory',$subcategory);
		}
	}
	
	public function var_exists($value, $table,$column){
		$this->db->select('count('.$column.')');
		$this->db->where($column,$value);
		return $this->db->get($table)->row();
	}
	
	public function select_company(){
		return $this->db->get_where('company',array('active' => 1))->result();
	}
	
	public function select_company_by_category($category,$search){
		$this->db->select('cat.title,c.company_name,c.description,c.image,c.company_id');
		$this->db->join('company_category cc','cc.company_id  = c.company_id');
		$this->db->join('category cat','cat.category_id = cc.category_id');
        $this->db->join('subcategory s','cat.category_id = s.category_id','left');
		$this->db->where('cat.active',1);
        $this->db->where('c.active',1);
        $this->db->where('s.active',1);
        if(isset($search)){
            $this->db->where('(c.company_name like "%'.$search.'%" OR s.title like "%'.$search.'%")');    
        }
        if(isset($category) && $category != 'null'){
            $this->db->where('cat.category_id',$category);    
        }
        $this->db->group_by('c.company_id');
		$companies = $this->db->get('company c')->result();
        
        foreach ($companies as $company) {
            $company->category = $this->select_category_by_company_id($company->company_id);
            $company->subcategory = $this->select_subcategory_by_company_id($company->company_id);   
        }
        
        return $companies;
	}
	
	public function select_company_by_subcategory($subcategory){
		$this->db->select('s.title,c.company_name,c.description,c.image,c.company_id');
		$this->db->join('company_subcategory cs','cs.company_id  = c.company_id');
		$this->db->join('subcategory s','s.subcategory_id = cs.subcategory_id');
		$this->db->where('s.active',1);
		$this->db->where('c.active',1);
		$this->db->where('s.subcategory_id',$subcategory);
		$companies = $this->db->get('company c')->result();
        
        foreach ($companies as $company) {
            $company->category = $this->select_category_by_company_id($company->company_id);
            $company->subcategory = $this->select_subcategory_by_company_id($company->company_id);   
        }
        
        return $companies;
	}
    
    public function select_subcategory_by_company_id($company_id){
        $this->db->select('s.title');
        $this->db->join('company_subcategory cs','cs.subcategory_id = s.subcategory_id','left');
        $this->db->where('cs.company_id',$company_id);
        return $this->db->get('subcategory s')->result();
    }
    
    public function select_category_by_company_id($company_id){
        $this->db->select('c.title');
        $this->db->join('company_category cc','cc.category_id = c.category_id');
        $this->db->where('cc.company_id',$company_id);
        return $this->db->get('category c')->result();
    }
	
    public function get_by_id($company_id){
        $company = $this->db->get_where('company',array('company_id' => $company_id))->row();
        
        //$company->category = $this->select_category_by_company_id($company_id);
        //$company->subcategory = $this->select_subcategory_by_company_id($company_id);    
        
        return $company;
    }
    
    public function email_exists($email){
        $this->db->select('count(company_id) email_exists');
        $this->db->where('email',$email);
        return $this->db->get('company')->row();
    }
    
    public function validate($email,$password){
        $return = $this->db->get_where('company',array('email' => $email,'password' => sha1($password)))->row();
        return $return;
    }
}
?>
	