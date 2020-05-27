<div class="container main">
	<div class="col-md-6"style="border-right: 1px dashed #cccccc; ">
		<h2>Já sou cadastrado</h2>
		<hr>
		
		<form method="post" id="form_login">
			<div class="row space">
				<div class="col-md-2 vertical-center">
					E-mail	
				</div>	
				<div class="col-md-10 ">
					<input type="text" name="login_email" id="login_email" class="form-control" style="width:300px;">		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					Senha	
				</div>	
				<div class="col-md-7">
					<input type="password" name="login_password" id="login_password" class="form-control" style="width:300px;">
					<span id="login_email_error" class="error_message"></span>		
				</div>
			</div>
			
			<div class="row space">
				<div class="col-md-2"></div>		
				<div class="col-md-7">
					<a href="#" class="forgot_password" data-toggle="modal" data-target="#modalForgotPassword">Esqueci minha senha</a>			
				</div>	
			</div>
			
			<div class="row space">
				<div class="col-md-2"></div>		
				<div class="col-md-7">
					<button type="submit" id="btn_login" class="btn btn-primary" style="width: 150px;">Entrar</button>			
				</div>	
			</div>
			<div class="alert alert-success" id="success"></div>
		</form>

		<!-- Modal -->
		<div class="modal fade" id="modalForgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-dm" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">trocar senha</h4>
		      </div>
		      <form method="post" action="<?php echo site_url('account/forgot_password');?>" >
			      <div class="modal-body">
				      <div class="row space">
				        <div class="col-md-12">
				        	Digite abaixo seu e-mail de cadastro e receba sua senha por e-mail.
				        </div>
				      </div>
				      <div class="row space">  
				        <div class="col-md-3 vertical-center">
							E-mail	
						</div>	
						<div class="col-md-8 ">
							<input type="text" name="email" <?php if(isset($email)){echo "value='$email'";}?> id="login_email" class="form-control">		
						</div>
				      </div>  
			      </div>
			      <div class="modal-footer">
			        <button type="submit" class="btn btn-primary" style="width: 160px;">Continuar</button>
			      </div>
			  </form>
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-6 space">
		<h2>Não sou cadastrado</h2>
		<hr>
		
		<form method="post" action="<?php echo site_url('account/register'); ?>" id="form_register">
			<div class="row space">
				<div class="col-md-10">
					Se não possui uma conta, faça um cadastro é rápido e receba informações 
					de profissionais indicados para você<br><br>	
				</div>	
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					E-mail	
				</div>	
				<div class="col-md-7">
					<?php $email = $this->input->get('email');?>
					<?php $email_nulo = $this->input->get('email_nulo');?>
					<?php $email_valid = $this->input->get('email_valid');?>
					<?php $email_exists = $this->input->get('email_exists');?>
					<input type="text" name="email" id="register_email" <?php if(isset($email)){echo "value='$email'";}?> class="form-control <?php if(isset($email_exists) || isset($email_valid) || isset($email_nulo)){echo 'borda_vermelha'; }?>" style="width:300px;">
					<span id="email_error" class="error_message">
						<?php if(isset($email_exists)){echo "<p>Este endereço de e-mail já está cadastrado. Tente Entrar ao lado.</p>";} ?>
						<?php if(isset($email_valid)){echo "<p>Este endereço de e-mail não é válido.</p>";} ?>
						<?php if(isset($email_nulo)){echo "<p>Digite um endereço de e-mail.</p>";} ?>
					</span>		
				</div>
			</div>
			
			<div class="row space">
				<div class="col-md-2"></div>		
				<div class="col-md-7">
					<button type="submit" id="btn_register" class="btn btn-primary" style="width: 150px;">Cadastrar</button>			
				</div>	
			</div>
		</form>
	</div>
	<div class="ou">ou</div>
</div>

<script type="text/javascript">
function esconde_erros(){
	// hide nos erros 
	$("#email_error").hide('slow');
    $("#password_error").hide('slow');
    $("#login_email_error").hide('slow');
    $("#login_password_error").hide('slow');
	
	//altera a cor da borda do campo
}
$(document).ready(function() {
    //esconde_erros();
	$("#success").hide();
	
	$("#email").on("change",function(){
		$("#email_error").hide('slow');
		$("#email").removeClass('borda_vermelha');
	});
	
	$("#password").on("change",function(){
		$("#password_error").hide('slow');
		$("#password").removeClass('borda_vermelha');
	});
	
	// submit
	$('#form_login').submit(function(){
		var dados = jQuery( this ).serialize();
		
		$('#btn_login').attr("disabled", "disabled");
		$.ajax({
			dataType: 'json',
			type: "POST",
			url: "<?php echo site_url('account/login_ajax'); ?>",
			data: dados,
			success: function( data )
			{
				var result = data;
				if(result.success){
				    window.history.back();
					$("#success").html(result.success);
					$("#success").show('slow');
					esconde_erros();
				}
				if(result.error){
					if(result.error.email){
						$("#email_error").html(result.error.email);
						$("#email_error").show();
						$("#email").addClass('borda_vermelha');
					}if(result.error.password){
                        $("#password_error").html(result.error.password);
                        $("#password_error").show();
                        $("#password").addClass('borda_vermelha');
                    }if(result.error.login_password){
                        $("#login_password_error").html(result.error.login_password);
                        $("#login_password_error").show();
                        $("#login_password").addClass('borda_vermelha');
                    }if(result.error.login_email){
                        $("#login_email_error").html(result.error.login_password);
                        $("#login_email_error").show();
                        $("#login_email").addClass('borda_vermelha');
                    }					
				}
				$('#btn_login').removeAttr("disabled");
			}
		});
		
		return false;
	});
});
</script>