<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_estimate extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('company_model');
        $this->load->model('request_estimate_model');
		$this->load->library('encrypt');
        //$this->load->library('pagination');
        $this->load->model('category_model');
        $GLOBALS['categories'] = $this->category_model->select();
	}
	
    public function request(){
        $data['company_id'] = $this->input->get('company_id');
        $data['company'] = $this->company_model->get_by_id($data['company_id']);
        $this->load->view('company/request_estimate',$data);
    }
    
    public function request_ajax(){
        $this->load->library('form_validation');
        $rules = array(
            array('field' => 'title','label' => 'Título do Serviço','rules' => 'required'),
            array('field' => 'description','label' => 'Descrição do Serviço','rules' => 'required'),
            array('field' => 'company_id','label' => 'Empresa','rules' => 'required')
        );
        
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $title = $this->input->post('title');
            $description = $this->input->post('description');
            $company_id = $this->input->post('company_id');
            
            $request = array('title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'company_id' => $this->input->post('company_id'),
                'consumer_id' => $_SESSION['user_id'],
            );
            
            if($this->request_estimate_model->insert($request,null)){
                echo json_encode(array("success" => "Requisição de orçamento enviada com sucesso! <br> Logo, a empresa responderá seu orçamento."));
            }else{
                echo json_encode(array("error" => 'Houve um erro durante o cadastro, tente novamente mais tarde.'));
            }
                
        }else{
            echo json_encode(array("error" => $this->get_form_errors($rules)));
        }
        
    }

    public function more_info(){
        $request_estimate_id = $this->input->get('request_estimate_id');
        $request_estimate = $this->request_estimate_model->get_by_id($request_estimate_id);
        $data['request_estimate'] = $request_estimate;
        $this->load->view('request_estimate/more_info',$data);
    }
    
    public function answer_request(){
        $request_estimate_id = $this->input->get('request_estimate_id');
        if($request_estimate_id){
            $data['request_estimate'] = $this->request_estimate_model->get_by_id($request_estimate_id);    
        }
        
        $this->load->view('request_estimate/answer_request',$data);
    }
    
    public function answer_request_ajax(){
        $this->load->library('form_validation');
        $rules = array(
            array('field' => 'title','label' => 'Título do orçamento','rules' => 'required'),
            array('field' => 'description','label' => 'Descrição do orçamento','rules' => 'required'),
            array('field' => 'price','label' => 'Preço do orçamento','rules' => 'required'),
            array('field' => 'company_id','label' => 'Empresa','rules' => 'required'),
            array('field' => 'request_estimate_id','label' => 'Requisição','rules' => 'required')
        );
        
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
            $this->load->model('estimate_model');
            $estimate = array('title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'company_id' => $this->input->post('company_id'),
                'request_estimate_id' => $this->input->post('request_estimate_id'),
                'price' => $this->input->post('price'));
            
            if($this->estimate_model->insert($estimate)){
                echo json_encode(array("success" => "Orçamento enviado com sucesso!"));
            }else{
                echo json_encode(array("error" => 'Houve um erro durante o cadastro, tente novamente mais tarde.'));
            }
        }else{
            echo json_encode(array("error" => $this->get_form_errors($rules)));
        }
    }

    public function aprove_estimate(){
        $this->load->model('estimate_model');
        $estimate_id = $this->input->get('estimate_id');
        $aprove = $this->estimate_model->aprove($estimate_id);
        if($aprove == true){
            echo json_encode(array("success" => "Orçamento aprovado com sucesso!"));
        }else{
            echo json_encode(array("success" => "Orçamento enviado com sucesso!"));
        }
    }

	public function send_email_contact_us($msg){
		$this->load->library('email');
 
		$this->email->initialize();
		$this->email->subject('Fale Conosco Empresa - ContrateJÁ');
		$this->email->from('contato@mecontrateja.com.br');
		$this->email->to('felipe.furlanetti1@gmail.com');
		$this->email->message($msg);
		
		return $this->email->send();
	}
}
