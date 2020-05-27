    
    <div class="container" style="margin-top:50px;">
      <!-- Example row of columns -->
      <?php if(isset($subcategory)){?>
      	<div class="col-md-3 categoria_subcategoria">
          <h4><?php echo $subcategory->title;?></h4>
        </div>
      <?php	}else if(isset($category)){?>
      	<div class="col-md-3 categoria_subcategoria">
          <h4><?php echo $category->title;?></h4>
          <?php if(isset($subcategories)){?>
              <ul class="subcategoria">
                <?php foreach ($subcategories as $subcategory) { ?>
                      <li><a href="<?php echo site_url('company/show_by_subcategory/?subcategory='.$subcategory->subcategory_id);?>"><?php echo $subcategory->title; ?></a></li>
                <?php } ?>
              </ul>
          <?php } ?>
        </div>
      <?php	}else{?>	
      	<div class="col-md-3 categoria_subcategoria">
          <h4>Selecione uma categoria</h4>
          <ul class="subcategoria">
          	<?php foreach ($GLOBALS['categories'] as $cat) { ?>
				  <li><a href="<?php echo site_url('company/show_by_category/?category='.$cat->category_id);?>"><?php echo $cat->title; ?></a></li>
			<?php } ?>
          </ul>
        </div>
      <?php } ?>
        
      <?php if(count($companies) > 0){?>  
        <div class="col-md-9 prestadores">
        <h2 class="list-pagina-inicial">Mais Contratadas</h2>
        </div>
        
        <?php foreach ($companies as $company) { ?>
        <div class="col-md-9 prestadores">
          <div class="media">
          		<div class="media-left">
          		    <?php if(isset($company->image)){ ?>
          		        <img src="<?php echo site_url('assets/img/'.$company->company_id.'.jpg'); ?>" class="img-prestador"/>        
          		    <?php }else{ ?>
          		        <img src="<?php echo site_url('assets/img/pattern_company.jpg'); ?>" class="img-prestador"/>
          		    <?php } ?>

					<!--
					<div class="navbar-left">
						<span class="glyphicon glyphicon-star star"></span>
						<span class="glyphicon glyphicon-star star"></span>
						<span class="glyphicon glyphicon-star star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>	
					</div>
					-->
          		</div>
          		<div class="media-body">
         			<h3><?php echo $company->company_name; ?></h3>
         			<p>
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
          			<p>
          				<?php echo $company->description;?>
          			</p>
          			<p>
          			    <a class="btn btn-info" href="<?php echo site_url('company/details/?company_id='.$company->company_id);?>" role="button">+ informações</a>
                        <a class="btn btn-info" href="<?php echo site_url('request_estimate/request/?company_id='.$company->company_id); ?>" data-toggle="modal" data-target="#myModal<?php echo $company->company_id;?>">requisitar orçamento</a>
                        
                        <div class="modal fade" id="myModal<?php echo $company->company_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
          			</p>
          		</div>	
          </div>  
        </div>
        <?php } ?>
		
		<?php }else{ ?>
    		<div class="col-md-9 prestadores">
                <h2 class="list-pagina-inicial">Desculpe, mas não encontramos nenhuma empresa com estas especificações :/</h2>
            </div>    
		<?php } ?>
</div> <!-- /container -->
<script type="text/javascript">
    
</script>