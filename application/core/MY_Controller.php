<?php
class MY_Controller extends CI_Controller {
	function __construct() {
		date_default_timezone_set('America/Sao_Paulo');
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->library('session');
	}

	protected function check_perfil($perfis, $redirect = false) {
	}

	protected function check_login() {
		//Verificação de Login
		if (!isset($_SESSION['google_data'])) {
			header('Location:' . $this->config->item('ilogix_url'));
			exit ;
		}
		//Verificação de permissões de acesso
		$this->controller_action = $this->router->fetch_class() . '/' . str_replace('index', '', $this->router->fetch_method());
		if (!in_array($this->controller_action, $_SESSION['google_data']['sistemas']['supply']['urls'])) {
			if (isset($_SESSION['google_data']['sistemas']['supply']['urls']))
				redirect(site_url($_SESSION['google_data']['sistemas']['supply']['urls'][0]));
			else
				header('Location:' . $this->config->item('ilogix_url') . 'login?logout');
			exit ;
		}
		//Menu para Módulos
		$this->monta_menu_modulos();
	}

	protected function formatar($valor, $real = null) {
		if ($real)
			$valor = 'R$ ' . number_format($valor, 2, ',', '.');
		else
			$valor = number_format($valor, 0, ',', '.');
		return $valor;
	}

	protected function formatar_cnpj($val, $mask) {
		$maskared = '';
		$k = 0;
		for ($i = 0; $i <= strlen($mask) - 1; $i++) {
			if ($mask[$i] == '#') {
				if (isset($val[$k]))
					$maskared .= $val[$k++];
			} else {
				if (isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}

	protected function formatar_decimal_persistencia($qtd) {
		return number_format(floatval(str_replace(',', '.', $qtd)), 4, '.', '');
	}

	protected function formatar_decimal_view($qtd) {
		return str_replace('.', ',', $qtd);
	}

	/**
	 * echo $this->remover_formatacao_numero("R$ 1.487.257,55"); //Vai exibir na tela 1487257.55
	 * echo $this->remover_formatacao_numero("1.487.257,55"); //Vai exibir na tela 1487257.55
	 */
	protected static function remover_formatacao_numero($strNumero) {
		$strNumero = trim(str_replace("R$", null, $strNumero));

		$vetVirgula = explode(",", $strNumero);
		if (count($vetVirgula) == 1) {
			$acentos = array(".");
			$resultado = str_replace($acentos, "", $strNumero);
			return $resultado;
		} else if (count($vetVirgula) != 2) {
			return $strNumero;
		}

		$strNumero = $vetVirgula[0];
		$strDecimal = mb_substr($vetVirgula[1], 0, 2);

		$acentos = array(".");
		$resultado = str_replace($acentos, "", $strNumero);
		$resultado = $resultado . "." . $strDecimal;

		return $resultado;

	}
	
	public function get_usuario_id() {
		return $_SESSION['google_data']['usuario_id'];
	}

	/**
	 *
	 * Vai exibir na tela "um milhão, quatrocentos e oitenta e sete mil, duzentos e cinquenta e sete e cinquenta e cinco"
	 * echo $this->valor_por_extenso("R$ 1.487.257,55", false, false);
	 * Vai exibir na tela "um milhão, quatrocentos e oitenta e sete mil, duzentos e cinquenta e sete reais e cinquenta e cinco centavos"
	 * echo $this->valor_por_extenso("R$ 1.487.257,55", true, false);
	 * Vai exibir na tela "duas mil e setecentas e oitenta e sete"
	 * echo $this->valor_por_extenso("2787", false, true);
	 *
	 */
	protected static function valor_por_extenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false) {
		$valor = self::remover_formatacao_numero($valor);
		$singular = null;
		$plural = null;

		if ($bolExibirMoeda) {
			$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
			$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
		} else {
			$singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
			$plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
		}

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

		if ($bolPalavraFeminina) {
			if ($valor == 1) {
				$u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
			} else {
				$u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
			}
			$c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
		}

		$z = 0;
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);

		for ($i = 0; $i < count($inteiro); $i++) {
			for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
				$inteiro[$i] = "0" . $inteiro[$i];
			}
		}

		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
		$rt = null;
		$fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
		for ($i = 0; $i < count($inteiro); $i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

			$r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
			$t = count($inteiro) - 1 - $i;
			$r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")
				$z++;
			elseif ($z > 0)
				$z--;

			if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
				$r .= (($z > 1) ? " de " : "") . $plural[$t];

			if ($r)
				$rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		$rt = mb_substr($rt, 1);
		return ($rt ? ucfirst(strtolower(trim($rt))) :   “zero); ;
	}

	public function get_form_errors($errors) {
	  $data = array();
	  
	  foreach ($errors as $field) {
	  	$data{$field['field']} = form_error($field['field']);
	  }
	  return $data;
 	}
	

}
?>
