<div class="text-center col-lg-12">
	<h3><b>Vendimia - Concredito </b></h3>
</div>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
    <?
        if(count($modulos_pendiente) >0 )
        {
            foreach ($modulos_pendiente as $mod) 
            {
                ?>
                    <div class="alert alert-dismissible alert-danger">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <div class="fr">
                                <img src="<?=$mod['icon'];?>" class="w64" />
                            </div>
                            
                            Actualmente cuenta un pago pendiente para el m&oacute;dulo de <b><?=$mod['nombre_modulo'];?></b> 
                            por la cantidad <b> <?=$mod['precio'];?></b>
                            <br><br>
                    </div>                    
                <?
            }
        }
    ?>
    </div>
</div>

<div class="col-lg-3">
	<div class="panel panel-default">
		<div class="panel-body">
			<b><img src="img/info.png" /> Informaci&oacute;n sobre m&oacute;dulos</b>
			<hr>

			Los modulos de pyme an&uacute;nciate son secciones especiales para los usuarios. 
			Cuentan con herramientas especialmente dirigidas hacia un p&uacute;blico, por ejemplo 
			el m&oacute;dulos de <b>Multinivel</b> cuenta con opciones que ser&aacute;n de mucha ayuda para quien 
			este construyendo una red de contactos y desea contar con toda la informaci&oacute;n 
			al dia sobre esta Empresa. <br><br>

			Por su parte el m&oacute;dulo de <b>RedDental</b> cuenta con herramientas para dar de alta

			pacientes, y dar seguimiento de expediente. 

			<br><br>

			Estos m&oacute;dulos para garantia de soporte y de desarrollo de nuevas caracter&iacute;sticas.
            Si estas interesado en utilizar alguno de nuestros m&oacute;dulos, no dudes en preguntar lo que gustes. 
		</div>
	</div>
</div>


	<div class="col-lg-8 ">		
		<table width="900" style="cellspacing:10px"  cellpadding="10" class="table table-striped table-hover  ">                
            <?
                if(count($modulos) > 0)
                {
                    foreach($modulos as $rec)
                    {
                        ?>
                            <tr>
                                <td>
                                    <a href="index.php?sub=exp&op=det&id=<?=$e['id_empresa'];?>">
                                        <img src="<?=$rec['icon'];?>" class="img_box"  style="padding:10px;border:1px solid #CCCCCC; width: 200px; height: 150px;" />
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?sub=exp&op=det&id=<?=$e['id_empresa'];?>">
                                        <b class="f20"><?=$rec['nombre_modulo'];?></b><br><br>
                                    </a>
                                    <?=$rec['descripcion'];?>
                                    <br>
                                    <br>
                                    <b>Membres&iacute;a : </b><?=$rec['tipo_membresia'];?>
                                    <br>
                                    <!--b>Precio : </b> <span class="text-danger"><?=$rec['precio'];?></span-->
                                    <br><br>
                                    <!--a href="#metodos" role="button" data-toggle="modal" title="Ver detalles">Formas de Pago</a-->
                                    <div class="fr">                                    
                                      <a class="activar_modulo btn btn-default" href="index.php?sub=mod&modulo=<?=$rec['id_modulo'];?>" data-id-modulo="<?=$rec['id_modulo'];?>" >
                                      <?
                                        if($rec['id_usuario']!= '')
                                        {

                                          ?><img src="img/check-32.png" class="w32" /> <span class="text-success">Listo</span><?

                                        }
                                        else
                                        {
                                          ?><img src="img/check-alt-32.png" /> Activar<?
                                        }
                                      ?>
                                      </a>
                                    </div>
                                </td>
                            </tr>    
                        <?
                    }
                }
            ?>
        </table>
	</div>


<div id="metodos" class="modal">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header text-center">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title">Metodos de Pago</h4>
      		</div>



      		<div  class="modal-body" class="loader">        
      			<br><br>
                <h4>
          			Para activar su cuenta, es necesario realizar un deposito a la cuenta Bancoppel  137730180006924641. 
                <br><br>
                Recuerde que esta inversi&oacute;n nos ayuda a seguir desarrollando nuevas herramientas. 

                </h4>
          		<br><br>
      		</div>

      		<div class="modal-footer">
        		<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>        		
      		</div>
    	</div>

  	</div>

</div>



















