<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('company_model');
		$this->load->library('encrypt');
        //$this->load->library('pagination');
        $this->load->model('category_model');
        $GLOBALS['categories'] = $this->category_model->select();
	}
	
	public function register()
	{
		$this->load->model('city_model');
		$data['cities'] = $this->city_model->select();

		$this->load->view('templates/template_head');
		$this->load->view('company/register',$data);
		$this->load->view('templates/template_footer');
	}
	
	public function register_ajax(){
	    $this->load->model('consumer_model');
		$password = $this->input->post('password');
		$password_confirm = $this->input->post('password_confirm');
		$cnpj = $this->input->post('cnpj');
		$email = $this->input->post('email');
		
		// validação
		$this->load->library('form_validation');
		$rules = array( 
			array('field' => 'company_name','label' => 'Razão Social','rules' => 'required'),
			array('field' => 'email','label' => 'E-mail','rules' => 'required|valid_email'),
			//array('field' => 'password','label' => 'Senha','rules' => 'required|callback_confirm_password["'.$password.'","'.$password_confirm.'"]'),
			array('field' => 'password','label' => 'Senha','rules' => 'required'),
			array('field' => 'phone','label' => 'Telefone','rules' => 'required'),
			array('field' => 'city','label' => 'Cidade','rules' => 'required'),
			array('field' => 'category','label' => 'Categoria','rules' => 'required|is_natural_no_zero'),
			array('field' => 'subcategory[]','label' => 'Sub-Categoria','rules' => 'required'));
			//array('field' => 'state','label' => 'Estado','rules' => 'required'));
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()){
			if($this->input->post('password') == $this->input->post('password_confirm')){
			    $email_exists = $this->consumer_model->email_exists($this->input->post('email'));
                $email_exists_company = $this->company_model->email_exists($this->input->post('email'));
                if($email_exists->email_exists > 0 || $email_exists_company->email_exists > 0){
                    echo json_encode(array("error" => array('email'=>'Este e-mail já esta sendo utilizado.')));   
                }else{
    				$company_insert = new stdClass(); 
    				$company_insert->company = array('company_name' => $this->input->post('company_name'),
    					'cnpj' => $this->input->post('cnpj'),
    					'email' => $this->input->post('email'),
    					'password' => sha1($this->input->post('password')),
    					'how_contact' => $this->input->post('how_contact')
    					);
    					
    				$company_insert->address = array('city_id' => $this->input->post('city'),
    					'neighborhood' => $this->input->post('neighborhood'),
    					'street' => $this->input->post('street'),
    					'number' => $this->input->post('number'));
    				
    				$company_insert->inf_contact = array(//'cellphone' => $this->input->post('cellphone'),
    					'phone' => $this->input->post('phone'),
    					'whatsapp' => $this->input->post('whatsapp'));
    				
    				$company_insert->category = array('category_id' => $this->input->post('category'));
    				
    				$company_insert->subcategory = array();
    				foreach ($this->input->post('subcategory') as $subcategory_post) {
    					array_push($company_insert->subcategory,array('subcategory_id' => $subcategory_post));
    				}
    			
    				$this->company_model->insert($company_insert);
    				if($this->send_confirmation_email($email,$msg_confirm)){
    					echo json_encode(array("success" => "Seu pedido foi enviado com sucesso! <br> A requisição de cadastro da sua empresa será analisada. Entraremos em contato em breve."));	
    				}else{
    					echo json_encode(array("success" => "Você foi cadastrado com sucesso!<br> Porém não foi possível enviar seu email de confirmação de cadastro."));
    				}
    		    }
			}else{
				echo json_encode(array("error" => array('password'=>'As senhas não batem')));	
			}
		}else{
			echo json_encode(array("error" => $this->get_form_errors($rules)));
		}
	}

	public function var_exists($value,$table,$column,$label){ // ex : ('felipe.furlanetti1@gmail.com', 'company','email','Email')
		$var_exists = $this->company_model->var_exists($value,$table,$column); // se > 0 : existe
		if($var_exists > 0){
			$this->form_validation->set_message($column, 'O/A '.$label.' já existe na nossa base de dados.');	
			return false;
		}else{
			return true;
		}
	}
	
	public function show_by_category(){
		$category = $this->input->get('category');
		$search = $this->input->get('search');
		
		if(isset($search)){
			$data['companies'] = $this->company_model->select_company_by_category($category,$search);
		}else{
			$data['companies'] = $this->company_model->select_company_by_category($category,'');
		}
		
		if(isset($category)){
		    $this->load->model('subcategory_model');
		    $data['category'] = $this->category_model->select_by_id($category);
            $data['subcategories'] = $this->subcategory_model->select_by_category($category);
		}else{
		    $data['category'] = $this->category_model->select();
		}
		$this->load->view('templates/template_head');
		$this->load->view('company/show',$data);
		$this->load->view('templates/template_footer');
	}
	
	public function show_by_subcategory(){
		$subcategory = $this->input->get('subcategory');
        $this->load->model('subcategory_model');
		$data['companies'] = $this->company_model->select_company_by_subcategory($subcategory);
		$data['subcategory'] = $this->subcategory_model->get_by_id($subcategory);
        
		$this->load->view('templates/template_head');
		$this->load->view('company/show',$data);
		$this->load->view('templates/template_footer');
	}
	
	public function show(){
		$data['companies'] = $this->company_model->select_company();
		$this->load->view('templates/template_head');
		$this->load->view('company/show',$data);
		$this->load->view('templates/template_footer');
	}
	
	public function send_confirmation_email($email_consumer, $msg){
		$this->load->library('email');
 
		$this->email->initialize();
		$this->email->subject('Confirmação de cadastro');
		$this->email->from('contato@mecontrateja.com.br');
		$this->email->to($email_consumer);
		$this->email->message($msg);
		
		return $this->email->send();
	}

	public function send_message()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$subject = $this->input->post('subject');
		$messate = $this->input->post('message');
		
		// validação
		$this->load->library('form_validation');
		$rules = array( 
			array('field' => 'name','label' => 'Razão Social','rules' => 'required'),
			array('field' => 'email','label' => 'E-mail','rules' => 'required|valid_email'),
			array('field' => 'message','label' => 'Mensagem','rules' => 'required'));
		$this->form_validation->set_rules($rules);	
		
		if($this->form_validation->run()){
			$msg = "Razão Social: ".$name."<br> E-mail: ".$email."<br> Telefone: ".$phone."<br> Assunto: ".$subject."<br> Mensagem: ".$message;
			if($this->send_email_contact_us($msg)){
				echo json_encode(array("success" => "Você foi cadastrado com sucesso!"));	
			}else{
				echo json_encode(array("error" => array('email'=>'Ocorreu um erro durante o envio do e-mail')));
			}
		}else{
			echo json_encode(array("error" => $this->get_form_errors($rules)));
		}
		
	}

    public function details(){
        $company_id = $this->input->get('company_id');
        $data['company'] = $this->company_model->get_by_id($company_id);
        $this->load->view('templates/template_head');
        $this->load->view('company/details',$data);
        $this->load->view('templates/template_footer');
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
