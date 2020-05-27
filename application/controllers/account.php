<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('consumer_model');
        $this->load->model('category_model');
        $GLOBALS['categories'] = $this->category_model->select();
        $this->urlRetornoPagamento = base_url('ofertas/retornoPagamento');
	}
	
	public function login()
	{
		$this->load->view('templates/template_head');
		$this->load->view('account/login');
		$this->load->view('templates/template_footer');
	}
	
	public function login_ajax(){
	    $this->load->model('company_model');
		// VALIDATION RULES
        $this->load->library('form_validation');
        $rules = array(
            $this->form_validation->set_rules('login_email', 'E-mail', 'required'),
            $this->form_validation->set_rules('login_password', 'Senha', 'required')
        );
        
        if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("error" => $this->get_form_errors($rules)));
        } else {
            $consumer = $this->consumer_model->validate($this->input->post('login_email'),$this->input->post('login_password'));
            $company = $this->company_model->validate($this->input->post('login_email'),$this->input->post('login_password'));
            if($company){
                $data = array(
                    'name' => $company->company_name,
                    'email' => $this->input->post('login_email'),
                    'user_id' => $company->company_id,
                    'type' => 'company',
                    'logged' => true
                );
                $this->session->set_userdata($data);
                // redirecionar para tela inial para atualizar o template head e pegar novas infs do usuario logado
                echo json_encode(array("success" => "Profissional logado com sucesso"));
            }else if ($consumer) { // VERIFICA LOGIN E SENHA
                $data = array(
                	'name' => $consumer->name,
                    'email' => $this->input->post('login_email'),
                    'user_id' => $consumer->consumer_id,
                    'type' => 'consumer',
                    'logged' => true
                );
                $this->session->set_userdata($data);
				// redirecionar para tela inial para atualizar o template head e pegar novas infs do usuario logado
                echo json_encode(array("success" => "Logado com sucesso"));
            } else {
				echo json_encode(array("error" => array('login_password'=>'E-mail e senha incorretos','login_email'=>'E-mail e senha incorretos')));
            }
        }
	}

	public function logout(){
		$this->session->set_userdata('logged', FALSE);
    	$this->session->sess_destroy();
        echo "<script>window.history.back();</script>";
	}
	
	public function contact_us()
	{
		$this->load->view('templates/template_head');
		$this->load->view('account/contact_us');
		$this->load->view('templates/template_footer');
	}

	public function register()
	{
	    $this->load->model('company_model');
		$data['email'] = $this->input->post('email');
		
		// email valido
		$this->load->library('form_validation');
		$rules = array(array('field' => 'email','label' => 'E-mail','rules' => 'required|valid_email'));
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$email_exists = $this->consumer_model->email_exists($data['email']);
            $email_exists_company = $this->company_model->email_exists($data['email']);
			if($email_exists->email_exists > 0 || $email_exists_company->email_exists > 0){
				redirect('account/login/?email_exists=1&&email='.$data['email']);
			}else{
				$this->load->view('templates/template_head');
				$this->load->view('account/register',$data);
				$this->load->view('templates/template_footer');
			}
		}else{
			if($this->input->post('email')){
				redirect('account/login/?email_valid=1&&email='.$data['email']);
			}else{
				redirect('account/login/?email_nulo=1&&email='.$data['email']);
			}
		}
	}
	
	public function register_ajax(){
		$password = $this->input->post('password');
		$password_confirm = $this->input->post('password_confirm');
		$email = $this->input->post('email');
		
		//var_dump($this->input->post('state'));
		
		// validação
		$this->load->library('form_validation');
		$rules = array( 
			array('field' => 'name','label' => 'Nome','rules' => 'required'),
			array('field' => 'email','label' => 'E-mail','rules' => 'required|valid_email'),
			array('field' => 'password','label' => 'Senha','rules' => 'required'));
		$this->form_validation->set_rules($rules);	
		
		if($this->form_validation->run()){
			if($this->input->post('password') == $this->input->post('password_confirm')){
				$account_insert = new stdClass(); 
				$account_insert = array('name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password')));
					
				$msg_confirm = '<p> E-mail de confirmação de cadastro</p><p> clique no <a href="'.site_url('account/confirm_email').'">link</a> para confirmar seu cadastro ';
			
				$this->consumer_model->insert($account_insert);
				if($this->send_confirmation_email($email,$msg_confirm)){
					echo json_encode(array("success" => "Você foi cadastrado com sucesso!"));	
				}else{
					echo json_encode(array("success" => "Você foi cadastrado com sucesso!<br> Porém não foi possível enviar seu email de confirmação de cadastro."));
				}
			}else{
				echo json_encode(array("error" => array('password'=>'As senhas não batem')));
			}
		}else{
			echo json_encode(array("error" => $this->get_form_errors($rules)));
		}
	}

    public function details(){
        if($_SESSION['user_id']){
            if($_SESSION['type']=='consumer'){
                $this->load->model('request_estimate_model');
                $this->load->model('consumer_model');
                
                $data['user'] = $this->consumer_model->details($_SESSION['user_id']);
                $data['requests_estimate'] = $this->request_estimate_model->select_by_consumer_id($_SESSION['user_id']);
                $data['type'] = 'consumer';
                
            }elseif($_SESSION['type']=='company'){
                $this->load->model('company_model');
                $this->load->model('request_estimate_model');
                $this->load->model('estimate_model');
                
                $data['requests_estimate'] = $this->request_estimate_model->select_by_company_id($_SESSION['user_id']);
                $data['user'] = $this->company_model->get_by_id($_SESSION['user_id']);
                $data['type'] = 'company';
            }
            
        }else{
            $data['user'] = null;
        }
        
        $this->load->view('templates/template_head');
        $this->load->view('account/details',$data);
        $this->load->view('templates/template_footer');
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
			array('field' => 'name','label' => 'Nome','rules' => 'required'),
			array('field' => 'email','label' => 'E-mail','rules' => 'required|valid_email'),
			array('field' => 'message','label' => 'Mensagem','rules' => 'required'));
		$this->form_validation->set_rules($rules);	
		
		if($this->form_validation->run()){
			$msg = "Nome: ".$name."<br> E-mail: ".$email."<br> Telefone: ".$phone."<br> Assunto: ".$subject."<br> Mensagem: ".$message;
			if($this->send_email_contact_us($msg)){
				echo json_encode(array("success" => "Você foi cadastrado com sucesso!"));	
			}else{
				echo json_encode(array("error" => array('email'=>'Ocorreu um erro durante o envio do e-mail')));
			}
		}else{
			echo json_encode(array("error" => $this->get_form_errors($rules)));
		}
		
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
	
	public function send_email_contact_us($msg){
		$this->load->library('email');
 
		$this->email->initialize();
		$this->email->subject('Fale Conosco Consumidor - ContrateJÁ');
		$this->email->from('contato@mecontrateja.com.br');
		$this->email->to('felipe.furlanetti1@gmail.com');
		$this->email->message($msg);
		
		return $this->email->send();
	}
    
    public function pay(){
        $this->load->library('PagSeguroLibrary');
        
        /** INICIO PROCESSO PAGSEGURO */
        $paymentrequest = new PagSeguroPaymentRequest();
         
        $data = Array(
         'id' => '01', // identificador
         'description' => 'Mouse', // descrição
         'quantity' => 1, // quantidade
         'amount' => 2.00, // valor unitário
         'weight' => 10 // peso em gramas
        );
        $item = new PagSeguroItem($data);
        /* $paymentRequest deve ser um objeto do tipo PagSeguroPaymentRequest */
         
        $paymentrequest->addItem($item);
        //Definindo moeda
        $paymentrequest->setCurrency('BRL');
         
        // 1- PAC(Encomenda Normal)
        // 2-SEDEX
        // 3-NOT_SPECIFIED(Não especificar tipo de frete)
        $paymentrequest->setShipping(3);
        //Url de redirecionamento
        //$paymentrequest->setRedirectURL($redirectURL);// Url de retorno
         
        $credentials = PagSeguroConfig::getAccountCredentials();//credenciais do vendedor
         
        //$compra_id = App_Lib_Compras::insert($produto);
        //$paymentrequest->setReference($compra_id);//Referencia;
         
        $url = $paymentrequest->register($credentials);
         
        header("Location: $url");
        
    }
	
}
