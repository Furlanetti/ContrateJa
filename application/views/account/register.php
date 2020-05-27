<div class="container main">
	<div class="col-md-12">
		<h2>Cadastro</h2>
		<hr>
				
		<form method="post" id="main_form">
			<div class="row space">
				<div class="col-md-3 vertical-center">
					Nome	
				</div>	
				<div class="col-md-5">
					<input type="text" name="name" id="name" class="form-control">
					<span id="name_error" class="error_message"></span>
				</div>
			</div>
			<div class="row space">
				<div class="col-md-3 vertical-center">
					E-mail
				</div>	
				<div class="col-md-5">
					<input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
					<span id="email_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-3 vertical-center">
					Senha
				</div>	
				<div class="col-md-5">
					<input type="password" name="password" id="password" class="form-control">
					<span id="password_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-3 vertical-center">
					Confirmação de Senha
				</div>	
				<div class="col-md-5">
					<input type="password" name="password_confirm" id="password_confirm" class="form-control">
					<span id="password_confirm_error" class="error_message"></span>		
				</div>
			</div>
				
			<div class="row space">
				<div class="col-md-3"></div>		
				<div class="col-md-5">
					<button type="submit" id="btn_register" class="btn btn-primary" style="width: 150px;">Cadastrar</button>
					<div class="alert alert-success" id="success"></div>
					<div class="alert alert-error" id="error"></div>			
				</div>	
			</div>
		</form>
</div>
</div>

<script type="text/javascript">
function esconde_erros(){
	// hide nos erros 
	$("#name_error").hide('slow');
	$("#email_error").hide('slow');
	$("#password_error").hide('slow');
	
	//altera a cor da borda do campo
}

$(document).ready(function() {
	$("#success").hide();
	
	$("#name").on("change",function(){
		$("#name_error").hide('slow');
		$("#name").removeClass('borda_vermelha');
	});
	
	$("#email").on("change",function(){
		$("#email_error").hide('slow');
		$("#email").removeClass('borda_vermelha');
	});
	
	$("#password").on("change",function(){
		$("#password_error").hide('slow');
		$("#password").removeClass('borda_vermelha');
	});
	
	// submit
	$('#main_form').submit(function(){
		var dados = jQuery( this ).serialize();
		
		$('#btn_register').attr("disabled", "disabled");
		$.ajax({
			dataType: 'json',
			type: "POST",
			url: "<?php echo site_url('account/register_ajax'); ?>",
			data: dados,
			success: function( data )
			{
				var result = data;
				if(result.success){
					$("#success").html(result.success);
					$("#success").show('slow');
					esconde_erros();
				}
				if(result.error){
					if(result.error.name){
						$("#name_error").html(result.error.name);
						$("#name_error").show();
						$("#name").addClass('borda_vermelha');
					}if(result.error.email){
						$("#email_error").html(result.error.email);
						$("#email_error").show();
						$("#email").addClass('borda_vermelha');
					}if(result.error.password){
						$("#password_error").html(result.error.password);
						$("#password_error").show();
						$("#password").addClass('borda_vermelha');
					}
										
				}
				$('#btn_register').removeAttr("disabled");
			}
		});
		
		return false;
	});
});
</script>