<div class="container main">
	<div class="col-md-12">
		<h2>Fale Conosco</h2>
		<hr>
		
		<?php if($this->input->get('type')=='company'){?>
			<form method="post" action="<?php echo site_url('account/send_message'); ?>" id="form_contact_company">
			<div class="row space">
				<div class="col-md-2 vertical-center">
					Razão Social	
				</div>	
				<div class="col-md-10 ">
					<input type="text" name="company_name" id="company_name" class="form-control" style="width:300px;">
					<span id="company_name_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					E-mail	
				</div>	
				<div class="col-md-10 ">
					<input type="text" name="email" id="email" class="form-control" style="width:300px;">
					<span id="email_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					Telefone	
				</div>	
				<div class="col-md-7">
					<input type="text" name="phone" id="phone" class="form-control" style="width:300px;">
					<span id="phone_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					Assunto	
				</div>	
				<div class="col-md-7">
					<input type="text" name="subject" id="subject" class="form-control" style="width:300px;">
					<span id="subject_error" class="error_message"></span>		
				</div>
			</div>
			<div class="row space">
				<div class="col-md-2 vertical-center">
					Mensagem	
				</div>	
				<div class="col-md-7">
					<textarea name="message" id="message" class="form-control" rows="3"></textarea>
					<span id="message_error" class="error_message"></span>		
				</div>
			</div>
			
			<div class="row space">
				<div class="col-md-2"></div>		
				<div class="col-md-7">
					<button type="submit" id="btn_send_message" class="btn btn-primary" style="width: 150px;">Enviar</button>			
				</div>	
			</div>
		</form>
		<?php }elseif($this->input->get('type')=='consumer'){?>
			<form method="post" action="<?php echo site_url('account/send_message'); ?>" id="form_contact_consumer">
				<div class="row space">
					<div class="col-md-2 vertical-center">
						Nome	
					</div>	
					<div class="col-md-10 ">
						<input type="text" name="name" id="name" class="form-control" style="width:300px;">
						<span id="name_error" class="error_message"></span>		
					</div>
				</div>
				<div class="row space">
					<div class="col-md-2 vertical-center">
						E-mail	
					</div>	
					<div class="col-md-10 ">
						<input type="text" name="email" id="email" class="form-control" style="width:300px;">
						<span id="email_error" class="error_message"></span>		
					</div>
				</div>
				<div class="row space">
					<div class="col-md-2 vertical-center">
						Telefone	
					</div>	
					<div class="col-md-7">
						<input type="text" name="phone" id="phone" class="form-control" style="width:300px;">
						<span id="phone_error" class="error_message"></span>		
					</div>
				</div>
				<div class="row space">
					<div class="col-md-2 vertical-center">
						Assunto	
					</div>	
					<div class="col-md-7">
						<input type="text" name="subject" id="subject" class="form-control" style="width:300px;">
						<span id="subject_error" class="error_message"></span>		
					</div>
				</div>
				<div class="row space">
					<div class="col-md-2 vertical-center">
						Mensagem	
					</div>	
					<div class="col-md-7">
						<textarea name="message" id="message" class="form-control" rows="3"></textarea>
						<span id="message_error" class="error_message"></span>		
					</div>
				</div>
				<div class="row space">
					<div class="col-md-2"></div>		
					<div class="col-md-7">
						<button type="submit" id="btn_send_message" class="btn btn-primary" style="width: 150px;">Enviar</button>			
					</div>	
				</div>
			</form>
			<script type="text/javascript">
				function esconde_erros(){
					// hide nos erros 
					$("#name_error").hide('slow');
					$("#email_error").hide('slow');
					$("#message_error").hide('slow');
	
					//altera a cor da borda do campo
				}	
				
				$(document).ready(function() {
					// submit
					$('#form_contact_consumer').submit(function(){
						var dados = jQuery( this ).serialize();
						
						$('#btn_send_message').attr("disabled", "disabled");
						$.ajax({
							dataType: 'json',
							type: "POST",
							url: "<?php echo site_url('account/send_message'); ?>",
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
									if(result.error.email){
										$("#email_error").html(result.error.email);
										$("#email_error").show();
										$("#email").addClass('borda_vermelha');
									}if(result.error.name){
										$("#name_error").html(result.error.name);
										$("#name_error").show();
										$("#name").addClass('borda_vermelha');
									}if(result.error.message){
										$("#message_error").html(result.error.message);
										$("#message_error").show();
										$("#message").addClass('borda_vermelha');
									}					
								}
								$('#btn_send_message').removeAttr("disabled");
							}
						});
						
						return false;
					});
				}
			</script>
		<?php } ?>
</div></div>