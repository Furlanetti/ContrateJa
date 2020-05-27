<?php
class Consumer_model extends CI_Model {
	
	public function email_exists($email){
		$this->db->select('count(consumer_id) email_exists');
		$this->db->where('email',$email);
		return $this->db->get('consumer')->row();
	}
	
	public function insert($data){
		$this->db->insert('consumer',$data);
		return $this->db->insert_id();
	}
    
    public function details($consumer_id){
        return $this->db->get_where('consumer',array('consumer_id' => $consumer_id))->row();
    }
	
    public function validate($email,$password) {
    	$this->db->select('name,consumer_id');
        $this->db->where('email', $email); 
        $this->db->where('password', sha1($password));
        $this->db->where('active', 1); 

        $query = $this->db->get('consumer');
        if ($query->num_rows() == 1) { 
            return $query->row();
        }
    }

    public function logged() {
        $logged = $this->session->userdata('logged');

        if (!isset($logged) || $logged != true) {
            echo 'Voce nao tem permissao para entrar nessa pagina. <a href="https://www.oficinadanet.com.br/login">Efetuar Login</a>';
            die();
        }
    }
}
?>
	