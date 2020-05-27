<div class="container main">
	<div class="col-md-12">
		
		<?php if(isset($user)){ ?>
		<h2>Informações Pessoais</h2>
        <hr>
        <h3>Requisições de orçamento</h3>    
        <?php if(isset($requests_estimate)){?>
            
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <td>Data / Hora</td>
                    <td>Título</td>
                    <?php if($type == "company"){?>
                        <td>Nome Cliente</td>
                    <?php }elseif($type=="consumer"){?>
                        <td>Nome Profissional</td>
                    <?php } ?>
                    <td>Status</td>
                    <td>Opções</td>
                </tr>
                </thead>
            <?php foreach ($requests_estimate as $request_estimate) { ?>
                <tr>
                    <td><?php echo $request_estimate->datetime_request;?></td>
                    <td><?php echo $request_estimate->title;?></td>
                    <?php if($type == "company"){?>
                        <td><?php echo $request_estimate->consumer_name;?></td>
                    <?php }elseif($type == "consumer"){?>
                        <td><?php echo $request_estimate->company_name;?></td>
                    <?php } ?>
                    <td><?php echo $request_estimate->status;?></td>
                    <td>
                        <div class="dropdown">
                          <button class="btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Opções
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="<?php echo site_url('request_estimate/more_info/?request_estimate_id='.$request_estimate->request_estimate_id); ?>" data-toggle="modal" data-target="#modalMoreInfo<?php echo $request_estimate->request_estimate_id;?>">+ informações</a></li>
                            <?php if($type=="company" && $request_estimate->status == "Não Respondido"){?>
                                <li><a href="<?php echo site_url('request_estimate/answer_request/?request_estimate_id='.$request_estimate->request_estimate_id); ?>" data-toggle="modal" data-target="#modalAnswerRequest<?php echo $request_estimate->request_estimate_id;?>">responder requisição</a></li>
                            <?php } ?>
                            <?php if($type=="consumer" && $request_estimate->status == "Respondido"){?>
                                <li><a href="<?php echo site_url('request_estimate/aprove_estimate/?estimate_id='.$request_estimate->estimate_id); ?>" data-toggle="modal" data-target="#modalAnswerRequest<?php echo $request_estimate->request_estimate_id;?>">aprovar orçamento</a></li>
                            <?php } ?>
                            <li><a href="<?php echo site_url('request_estimate/remove/?request_estimate_id='.$request_estimate->request_estimate_id); ?>" data-toggle="modal" data-target="#modalRemove<?php echo $request_estimate->request_estimate_id;?>">remover da lista</a></li>
                          </ul>
                          <?php if($request_estimate->status == 'Respondido'){?>
                            <a href="<?php echo site_url('estimate/show/?estimate_id='.$request_estimate->estimate_id); ?>" data-toggle="modal" data-target="#modalEstimate<?php echo $request_estimate->request_estimate_id;?>" class="btn-sm btn-info">Ver Resposta</a>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
                
                <div class="modal fade" id="modalMoreInfo<?php echo $request_estimate->request_estimate_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="modalAnswerRequest<?php echo $request_estimate->request_estimate_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="modalRemove<?php echo $request_estimate->request_estimate_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                        </div>
                    </div>
                </div>
                
            <?php } ?>
            </table> 
            
            
                        
            
            
            
        <?php }else{ ?>
            Não existem requisições de orçamento.
        <?php } ?>
		<?php }else{ ?>
		    <h2>
		    Para visualizar detalhes você precisa estar logado. Clique em <a href="<?php echo site_url('account/login'); ?>">entrar</a> para logar.
		    </h2>
		<?php } ?>
</div></div>