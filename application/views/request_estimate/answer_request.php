<?php if(isset($_SESSION['user_id'])){ 
    if($_SESSION['type'] == 'company'){?>
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="margin-top:0px;"><?php echo $request_estimate->title; ?></h3>
                <p style="margin-bottom:0px;">
                    <b><?php echo $request_estimate->name;?></b> 
                </p>
                <p><?php echo $request_estimate->description;?></p>
              </div>
              <form method="post" id="form_estimate">
                  <div class="modal-body">
                  <input type="hidden" name="company_id" id="company_id" value="<?php echo $request_estimate->company_id;?>">
                  <input type="hidden" name="request_estimate_id" id="request_estimate_id" value="<?php echo $request_estimate->request_estimate_id;?>">
                      <div class="row space">
                        <div class="col-md-12">
                            Preencha as informações abaixo.
                        </div>
                      </div>
                      <div class="row space">  
                        <div class="col-md-10 vertical-center">
                            Título do orçamento 
                        </div>  
                        <div class="col-md-8 ">
                            <input type="text" name="title" id="title" class="form-control"> 
                            <span id="title_error" class="error_message"></span>
                        </div>
                      </div>
                      
                      <div class="row space">  
                        <div class="col-md-10 vertical-center">
                            Preço 
                        </div>  
                        <div class="col-md-8 ">
                            <input type="text" name="price" id="price" class="form-control"> 
                            <span id="price_error" class="error_message"></span>
                        </div>
                      </div>

                      <div class="row space">    
                          <div class="col-md-10 vertical-center">
                              Descrição do serviço  
                          </div>  
                          <div class="col-md-12 ">
                              <textarea name="description" id="description" rows="6" class="form-control"></textarea>  
                              <span id="description_error" class="error_message"></span>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <div class="alert alert-success" id="success"></div>
                    <button type="submit" class="btn btn-primary" id="btn_request" style="width: 160px;">enviar orçamento</button>
                  </div>
              </form>
            </div>        
            
<script type="text/javascript">
function esconde_erros(){
    // hide nos erros 
    $("#title_error").hide('slow');
    $("#price_error").hide('slow');
    $("#description_error").hide('slow');
    
    //altera a cor da borda do campo
}
$(document).ready(function() {
    esconde_erros();
    $("#success").hide();
    
    $("#title").on("change",function(){
        $("#title_error").hide('slow');
        $("#title").removeClass('borda_vermelha');
    });
    
    $("#price").on("change",function(){
        $("#price_error").hide('slow');
        $("#price").removeClass('borda_vermelha');
    });
    
    $("#description").on("change",function(){
        $("#description_error").hide('slow');
        $("#description").removeClass('borda_vermelha');
    });
    // submit
    $('#form_estimate').submit(function(){
        var dados = jQuery( this ).serialize();
        
        $('#btn_request').attr("disabled", "disabled");
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo site_url('request_estimate/answer_request_ajax'); ?>",
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
                    if(result.error.title){
                        $("#title_error").html(result.error.title);
                        $("#title_error").show();
                        $("#title").addClass('borda_vermelha');
                    }if(result.error.description){
                        $("#description_error").html(result.error.description);
                        $("#description_error").show();
                        $("#description").addClass('borda_vermelha');
                    }if(result.error.price){
                        $("#price_error").html(result.error.price);
                        $("#price_error").show();
                        $("#price").addClass('borda_vermelha');
                    }                   
                }
                $('#btn_request').removeAttr("disabled");
            }
        });
        
        return false;
    });
});
</script>           
<?php }else{?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 style="margin-top:0px;">
            Para requisitar um orçamento é preciso estar logado antes :/<br><br>
            Clique em <a href="<?php echo site_url('account/login/'); ?>">entrar</a> ou então <a href="<?php echo site_url('account/login/'); ?>">cadastre-se</a> é rapidinho
        </h3>
    </div>
<?php } } ?>
