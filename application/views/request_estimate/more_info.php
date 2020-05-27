              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="margin-top:0px;"><?php echo $request_estimate->company_name; ?></h3>
                <p style="margin-bottom:0px;">
                <?php
                    if(isset($request_estimate->category)){
                        foreach ($request_estimate->category as $category) {
                            echo "<span class='label label-primary'>".$category->title."</span> &nbsp;";
                        }
                    }
                    if(isset($request_estimate->subcategory)){
                        foreach ($request_estimate->subcategory as $subcategory) {
                            echo "<span class='label label-info'>".$subcategory->title."</span> &nbsp;";
                        }
                    }
                ?>
                </p>
              </div>
              <div class="modal-body">
                <div class="row space">  
                    <div class="col-md-10 vertical-center">
                        Data / Hora:
                        <b><?php echo $request_estimate->datetime_request;?></b>
                    </div>
                </div>
                
                <div class="row space">  
                    <div class="col-md-10 vertical-center">
                        Nome do Contratante:
                        <b><?php echo $request_estimate->name;?></b>
                    </div>
                </div>
                
                <div class="row space">  
                    <div class="col-md-10 vertical-center">
                        Título do serviço:
                        <b><?php echo $request_estimate->title;?></b>
                    </div>
                </div>

                <div class="row space">    
                    <div class="col-md-10 vertical-center">
                        Descrição do serviço  
                    </div>  
                    <div class="col-md-12 ">
                        <b><?php echo $request_estimate->description; ?></b>
                    </div>
                </div>
              </div>
            </div>