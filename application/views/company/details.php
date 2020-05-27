<div class="container main" style="margin-top:30px;">
    <div class="col-md-16">
        <?php if(isset($company)){ ?>
            <div class="col-md-2">
                <?php if(isset($company->image)){ ?>
                    <img src="<?php echo site_url('assets/img/'.$company->company_id.'.jpg'); ?>"/>        
                <?php }else{ ?>
                    <img src="<?php echo site_url('assets/img/pattern_company.jpg'); ?>" />
                <?php } ?>
            </div>
            <div class="col-md-7">
                <h2 class="list-pagina-inicial"><?php echo $company->company_name; ?></h2>
                <p><?php echo $company->description; ?></p>
            </div>
        <?php }else{ ?>
            <div class="col-md-9 prestadores">
                <h2 class="list-pagina-inicial">Desculpe, mas não encontramos nenhuma empresa com estas especificações :/</h2>
            </div> 
        <?php } ?>
</div>
</div>

<script type="text/javascript">
function esconde_erros(){
    // hide nos erros 
    $("#company_name_error").hide('slow');
    $("#cnpj_error").hide('slow');
    $("#ie_error").hide('slow');
    $("#email_error").hide('slow');
    $("#password_error").hide('slow');
    $("#phone_error").hide('slow');
    $("#whatsapp_error").hide('slow');
    $("#category_error").hide('slow');
    $("#subcategory_error").hide('slow');
    $("#address_error").hide('slow');
    $("#number_error").hide('slow');
    $("#neighborhood_error").hide('slow');
    $("#city_error").hide('slow');
    $("#state_error").hide('slow');
    
    //altera a cor da borda do campo
}

$(document).ready(function() {
    $("#success").hide();
    
    $("#company_name").on("change",function(){
        $("#company_name_error").hide('slow');
        $("#company_name").removeClass('borda_vermelha');
    });
    
    $("#cnpj").on("change",function(){
        $("#cnpj_error").hide('slow');
        $("#cnpj").removeClass('borda_vermelha');
    });
    
    $("#ie").on("change",function(){
        $("#ie_error").hide('slow');
        $("#ie").removeClass('borda_vermelha');
    });
    
    $("#email").on("change",function(){
        $("#email_error").hide('slow');
        $("#email").removeClass('borda_vermelha');
    });
    
    $("#password").on("change",function(){
        $("#password_error").hide('slow');
        $("#password").removeClass('borda_vermelha');
    });
    
    $("#phone").on("change",function(){
        $("#phone_error").hide('slow');
        $("#phone").removeClass('borda_vermelha');
    });
    
    $("#category").on("change",function(){
        $("#category_error").hide('slow');
        $("#category").removeClass('borda_vermelha');
    });
    
    $("#subcategory").on("change",function(){
        $("#subcategory_error").hide('slow');
        $("#subcategory").removeClass('borda_vermelha');
    });
    
    $("#address").on("change",function(){
        $("#address_error").hide('slow');
        $("#address").removeClass('borda_vermelha');
    });
    
    $("#number").on("change",function(){
        $("#number_error").hide('slow');
        $("#number").removeClass('borda_vermelha');
    });
    
    $("#neighborhood").on("change",function(){
        $("#neighborhood_error").hide('slow');
        $("#neighborhood").removeClass('borda_vermelha');
    });
    
    $("#city").on("change",function(){
        $("#city_error").hide('slow');
        $("#city").removeClass('borda_vermelha');
    });
    
    // $("#state").on("change",function(){
    //  $("#state_error").hide('slow');
    //  $("#state").removeClass('borda_vermelha');
    // });
    
    // submit
    $('#main_form').submit(function(){
        var dados = jQuery( this ).serialize();
        
        $('#btn_register').attr("disabled", "disabled");
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo site_url('company/register_ajax'); ?>",
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
                    if(result.error.company_name){
                        $("#company_name_error").html(result.error.company_name);
                        $("#company_name_error").show();
                        $("#company_name").addClass('borda_vermelha');
                    }if(result.error.cnpj){
                        $("#cnpj_error").html(result.error.cnpj);
                        $("#cnpj_error").show();
                        $("#cnpj").addClass('borda_vermelha');
                    }if(result.error.ie){
                        $("#ie_error").html(result.error.ie);
                        $("#ie_error").show();
                        $("#ie").addClass('borda_vermelha');
                    }if(result.error.email){
                        $("#email_error").html(result.error.email);
                        $("#email_error").show();
                        $("#email").addClass('borda_vermelha');
                    }if(result.error.password){
                        $("#password_error").html(result.error.password);
                        $("#password_error").show();
                        $("#password").addClass('borda_vermelha');
                    }if(result.error.phone){
                        $("#phone_error").html(result.error.phone);
                        $("#phone_error").show();
                        $("#phone").addClass('borda_vermelha');
                    }if(result.error.whatsapp){
                        $("#whatsapp_error").html(result.error.whatsapp);
                        $("#whatsapp_error").show();
                        $("#whatsapp").addClass('borda_vermelha');
                    }if(result.error.category){
                        $("#category_error").html('<p>O campo Categoria é obrigatório.</p>');
                        $("#category_error").show();
                        $("#select2-category-container").addClass('borda_vermelha');
                    }if(result.error.subcategory){
                        $("#subcategory_error").html(result.error.subcategory);
                        $("#subcategory_error").show();
                        $("#subcategory").addClass('borda_vermelha');
                    }if(result.error.address){
                        $("#address_error").html(result.error.address);
                        $("#address_error").show();
                        $("#address").addClass('borda_vermelha');
                    }if(result.error.number){
                        $("#number_error").html(result.error.number);
                        $("#number_error").show();
                        $("#number").addClass('borda_vermelha');
                    }if(result.error.neighborhood){
                        $("#neighborhood_error").html(result.error.neighborhood);
                        $("#neighborhood_error").show();
                        $("#neighborhood").addClass('borda_vermelha');
                    }if(result.error.city){
                        $("#city_error").html(result.error.city);
                        $("#city_error").show();
                        $("#city").addClass('borda_vermelha');
                    }
                    // if(result.error.state){
                    //  $("#state_error").html('<p>O campo Estado é obrigatório.</p>');
                    //  $("#state_error").show();
                    //  $("#state").addClass('borda_vermelha');
                    // }
                                        
                }
                $('#btn_register').removeAttr("disabled");
            }
        });
        
        return false;
    });
});
    var subcategory = {};
    subcategory[1] = [{id:1 ,text:'Manutenção de Computadores'},
        {id:2 ,text:'Manutenção de Smartphones'},
        {id:3 ,text:'Manutenção de Notebooks'},
        {id:4 ,text:'Redes'},
        {id:5 ,text:'Compra de Equipamento'},
        {id:6 ,text:'Desenvolvimento de Sistemas'}];
    subcategory[2] = [{id:7 ,text:'Serviços de Jardinagem'},
        {id:8 ,text:'Manutenção de Piscinas'},
        {id:9 ,text:'Serviços de Pintura'},
        {id:10 ,text:'Serviços Elétricos'},
        {id:11 ,text:'Serviços Gerais'}];
    subcategory[3] = [{id:12 ,text:'Equipamentos de Aquecimento'},
        {id:13 ,text:'Equipamentos de Refrigeração'},
        {id:14 ,text:'Mecânico de Carros'},
        {id:15 ,text:'Mecânico de Motos'}];
    subcategory[4] = [{id:16 ,text:'Transporte Intermunicipal de Pessoas'},
        {id:17 ,text:'Transporte Municipal de Pessoas'},
        {id:18 ,text:'Transporte de Objetos'}];
    subcategory[5] = [{id:19 ,text:'Decoração Residêncial'},
        {id:20 ,text:'Decoração Empresarial'},
        {id:21 ,text:'Decoração de Eventos'}];
    subcategory[6] = [{id:22 ,text:'Diarista'},
        {id:23 ,text:'Empregada Mensalista'},
        {id:24 ,text:'Limpeza Empresarial'}];
        
    var vector_category = [{id:0,text:'Selecione uma categoria'},
        {id:1,text:'T.I'},
        {id:2,text:'Manutenção Residencial'},
        {id:3,text:'Manutenção de Máquinas'},
        {id:4,text:'Transporte'},
        {id:5,text:'Decoração'},
        {id:6,text:'Limpeza'}];
        
    // $('#state').select2();
    $('#city').select2();
    $('#category').select2({ placeholder: "Selecione uma categoria",data: vector_category});
    $('#subcategory').select2({ placeholder: "Selecione uma categoria para apresentar sub-categorias" });
            
    $('#category').on('change', function() {
        var category = $(this).val(); 
        
        $('#subcategory').html('').select2({data: {id:null, text: null}});
        if(category == 1){
            $('#subcategory').select2({
                data: subcategory[1]
            }); 
        }else if(category == 2){
            $('#subcategory').select2({
                data: subcategory[2]
            }); 
        }else if(category == 3){
            $('#subcategory').select2({
                data: subcategory[3]
            }); 
        }else if(category == 4){
            $('#subcategory').select2({
                data: subcategory[4]
            }); 
        }else if(category == 5){
            $('#subcategory').select2({
                data: subcategory[5]
            }); 
        }else if(category == 6){
            $('#subcategory').select2({
                data: subcategory[6]
            }); 
        }
    });
</script>