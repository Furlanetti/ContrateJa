<?php if(isset($_SESSION['user_id'])){ 
    if($_SESSION['type'] == 'company'){?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 style="margin-top:0px;">
            Para requisitar um orçamento é preciso estar logado como pessoa física :/<br><br>
            Clique em <a href="<?php echo site_url('account/login/'); ?>">entrar</a> ou então <a href="<?php echo site_url('account/login/'); ?>">cadastre-se</a> para cadastrar-se como pessoa física.
        </h3>
    </div>
    <?php }elseif($_SESSION['type'] == 'consumer'){?>
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="margin-top:0px;"><?php echo $company->company_name; ?></h3>
                <p style="margin-bottom:0px;">
                <?php
                    if(isset($company->category)){
                        foreach ($company->category as $category) {
                            echo "<span class='label label-primary'>".$category->title."</span> &nbsp;";
                        }
                    }
                    if(isset($company->subcategory)){
                        foreach ($company->subcategory as $subcategory) {
                            echo "<span class='label label-info'>".$subcategory->title."</span> &nbsp;";
                        }
                    }
                ?>
                </p>
              </div>
              <form method="post" id="form_request">
                  <div class="modal-body">
                  <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id;?>">
                      <div class="row space">
                        <div class="col-md-12">
                            Preencha as informações abaixo e a empresa entrará em contato logo.
                        </div>
                      </div>
                      <div class="row space">  
                        <div class="col-md-10 vertical-center">
                            Título do serviço  
                        </div>  
                        <div class="col-md-8 ">
                            <input type="text" name="title" id="title" class="form-control"> 
                            <span id="title_error" class="error_message"></span>
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
                    <button type="submit" class="btn btn-primary" id="btn_request" style="width: 160px;">requisitar orçamento</button>
                  </div>
              </form>
            </div>        
            
<script type="text/javascript">
function esconde_erros(){
    // hide nos erros 
    $("#title_error").hide('slow');
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
    
    $("#description").on("change",function(){
        $("#description_error").hide('slow');
        $("#description").removeClass('borda_vermelha');
    });
    // submit
    $('#form_request').submit(function(){
        var dados = jQuery( this ).serialize();
        
        $('#btn_request').attr("disabled", "disabled");
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo site_url('request_estimate/request_ajax'); ?>",
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
                    }                   
                }
                $('#btn_request').removeAttr("disabled");
            }
        });
        
        return false;
    });
});
</script>           
<?php }}else{?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 style="margin-top:0px;">
            Para requisitar um orçamento é preciso estar logado antes :/<br><br>
            Clique em <a href="<?php echo site_url('account/login/'); ?>">entrar</a> ou então <a href="<?php echo site_url('account/login/'); ?>">cadastre-se</a> é rapidinho
        </h3>
    </div>
<?php } ?>
