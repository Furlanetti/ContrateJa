<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>ContrateJÁ</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo base_url("assets/js/ie-emulation-modes-warning.js"); ?>"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    
    <!-- inicializar select2 -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<link href="<?php echo base_url("assets/css/select2.css");?>" rel="stylesheet" />
	<script src="<?php echo base_url("assets/js/select2.js");?>"></script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top nav-main">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand contrate_ja" href="<?php echo site_url();?>"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse busca">
          <form class="navbar-form navbar-right" id="form_busca_head" action="javascript:void(0);" onSubmit="redirect()">
          	<div class="input-group">
	        	<input type="text" placeholder="Pesquisar..." class="form-control" id="search_head" <?php if($this->input->get('search')){echo "value = '".$this->input->get('search')."'";}?>>
	            <div class="input-group-btn">
			        <button type="button" class="btn btn-default dropdown-toggle categoria" id="categoria_busca" data-toggle="dropdown">
			        	<?php if(isset($_GET['category']) && $_GET['category']!='null'){?>
                            <?php foreach ($GLOBALS['categories'] as $category) { 
                                if($category->category_id == $this->input->get('category')) echo $category->title;
                            } ?>
			        	<?php }else{?>
			        	    Selecione uma Categoria
			        	<?php } ?>
			        	<span class="caret" id="caret_busca"></span>
			        </button>
			        <ul class="dropdown-menu dropdown-menu-left" id="ul_busca">
			            <?php foreach ($GLOBALS['categories'] as $category) { ?>
						      <li id="<?php echo $category->category_id; ?>" class="li_busca"><a href="#"><?php echo $category->title; ?></a></li>	
						<?php } ?>
			        </ul>
	        		<button type="submit" class="btn btn-success" id="btn_buscar">Buscar</button>
      			</div><!-- /btn-group -->
      		</div>
      		<div class="navbar-form navbar-right entrar">
      			<?php
      			if(isset($this->session->userdata['name'])){
      				$names = explode(' ',$this->session->userdata['name']); 
      				$first_name = $names[0];
      			?>
      			<div class="dropdown">
      				<a href="<?php echo site_url("account/login");?>" class="dropdown-toggle" data-toggle="dropdown">
			        	<span class="glyphicon glyphicon-user entrar_icone"></span> 
			        	<span class="entrar_texto">
			        		Olá, <?php echo $first_name;?> <span class="caret" id="caret_busca"></span>
			        	</span>
			        </a>
			        <ul class="dropdown-menu dropdown-menu-right" id="li_user" style="margin-top: 10px;">
						<li id="user_info"><a href="<?php echo site_url('account/details'); ?>">Informações Pessoais</a></li>
						<li id="user_logout"><a href="<?php echo site_url('account/logout'); ?>">Sair</a></li>
					</ul>
      			</div>				
      			<?php }else{ ?>
	        	<a href="<?php echo site_url("account/login");?>">
	        		<span class="glyphicon glyphicon-user entrar_icone"></span> 
	        		<span class="entrar_texto">
	        			Entrar<span class="caret" id="caret_busca"></span>
	        		</span>
	        	</a>
	        	<?php }?> 
	        </div>
          </form>
	        
        </div>
      </div>
    </nav>
    
    <div id="navbar" class="navbar navbar-collapse menu-principal">
    	<div class="container" style="padding-left: 0;">
	    	<div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-phone" style="margin-right: 7px;"></span>T.I
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=1');?>">Manutenção de Computadores</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=2');?>">Manutenção de Smartphones</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=3');?>">Manutenção de Notebooks</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=4');?>">Redes</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=5');?>">Compra de Equipamentos</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=6');?>">Desenvolvimento Sistemas</a></li>
			    </ul>
			</div>
	    	<div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-home" style="margin-right: 7px;"></span>Manutenção Residencial
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=7');?>">Serviços de Jardinagem</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=8');?>">Manutenção Piscinas</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=9');?>">Serviços de Pintura</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=10');?>">Serviços Elétricos</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=11');?>">Serviços Gerais</a></li>
		    	</ul>
		    </div>
		    <div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-wrench" style="margin-right: 7px;"></span>Manutenção de Máquinas 
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=12');?>">Equipamento de Aquecimento</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=13');?>">Equipamentos de Refrigeração</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=14');?>">Mecânico de Carros</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=15');?>">Mecânico de Motos</a></li>
		    	</ul>
		    </div>
		    <div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-plane" style="margin-right: 7px;"></span>Transporte 
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=16');?>">Transporte Intermunicipal de Pessoas</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=17');?>">Transporte Municipal de Pessoas</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=18');?>">Transporte de Objetos</a></li>
		    	</ul>
		    </div>
		    <div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-lamp" style="margin-right: 7px;"></span>Decoração 
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=19');?>">Decoração Residêncial</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=20');?>">Decoração Empresarial</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=21');?>">Decoração de Eventos</a></li>
		    	</ul>
		    </div>
		    <div class="dropdown">
	    		<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
	    			<span class="glyphicon glyphicon-trash" style="margin-right: 7px;"></span>Limpeza 
	    		</button>	
		    	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=22');?>">Diarista</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=23');?>">Empregada Mensalista</a></li>
			    	<li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory=24');?>">Limpeza Empresarial</a></li>
		    	</ul>
		    </div>
		    
    	</div>
    </div>
    
<script type="text/javascript">
    var category_selected = null;
    <?php if($this->input->get('category')){?>
        category_selected = <?php echo $this->input->get('category');?>;
    <?php } ?>
    var url = '<?php echo site_url('company/show_by_category/'); ?>';
    $(".li_busca").on("click",function(){
        category_selected = this.id;
    });
    
    function redirect(){
        var search = $("#search_head").val();
        var category = category_selected;
        var url_submit = url + '/?search=' + search + '&&category=' + category;
        $(location).attr('href',url_submit);
    }
    
    $('#ul_busca li').on('click',function(){
        <?php foreach ($GLOBALS['categories'] as $category) { ?>
            if(this.id == <?php echo $category->category_id; ?>){
                $("#categoria_busca").html('<?php echo $category->title; ?> <span class="caret" id="caret_busca"></span>'); 
            }
        <?php } ?>
    });
</script>