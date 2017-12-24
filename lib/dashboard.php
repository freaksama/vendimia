<?

	if($_SESSION['u']['id_tipo_usuario']=='8')
	{
		echo '<script>window.location.href="index.php?menu=ma&sub=pan&op=anun";</script>';
		exit;
	}

	$datos['id_empresa'] = $_SESSION['s']['id_empresa'];
    $rec      = $c_sistema->ObtenerEmpresaCompleta($datos); 
    //$mensajes = $c_sistema->ObtenerMensajesNuevosEmpresa($datos); 


	//$citas    	= $c_sistema->obtenerCitasDia($datos);
	//$pendientes = $c_sistema->listadoPendientes($datos);

	//$count_servicios 	= $c_sistema->countServiciosClinica($datos);	
	//$citas_publicas 	= $c_sistema->obtenerCitasPublicas($datos);
	//$logs  				= $c_sistema->listadoUltimosLogAcceso($datos);
	//$visitas    		= $c_sistema->obtenerVisitasPerfilClinica($datos);    

	
?>

<script type="text/javascript">
	$(function(){

		obtener_pendientes(); 

		$("#txtq").focus()

		$("#linkbuscar").click(function(){

            var consulta = $("#txtq").val();

            if(consulta == '')
            {
                return false;
            }

            window.location.href="index.php?sub=exp&q=" + consulta;
            return false;

        });

        $('#txtq').keyup(function(e)
        {
            if(e.keyCode == 13)
            {
                var consulta = $("#txtq").val();

                if(consulta == '')
                {
                    return false;
                }

                window.location.href="index.php?sub=exp&q=" + consulta;
            }
        });
        

		$("#btnenviar_ser").click(function(){			
        	if($("#txtdes").val()!= '')
        	{
        		var descripcion  	 = $("#txtdes").val();
        		registrar_pendiente(descripcion);
        	}
        });

        $(document).on("change",".ck-box-pen",function(){

        	id_pendiente = $(this).data("id-pendiente"); 

        	if( $(this).is(':checked'))
        	{
        		var status = 'T'; 
        		cambiar_status_pendiente(id_pendiente, status);        		
        	}
        	else
        	{
        		var status = 'P'; 
        		cambiar_status_pendiente(id_pendiente, status);        		
        	}
        }); 

        $("#lk-clear").click(function(){
        	obtener_pendientes(); 
        }); 

	});// fin de ready 

</script>

<?
	if(!count($citas) > 0)
	{
		$ocultar = 'display:none;';
	}

?>




<div class="text-center col-lg-12">
	<h3><b>Bienvenido a Pyme Anunciate </b></h3>
</div>

<div class="col-lg-3">


	<div class="panel panel-default">
		<div class="panel-body">
			Visitas al perfil Directorio <b class="text-primary"><?=$rec['visitas'];?></b></a>
		</div>
	</div>

	
	<?
		if(count($mensajes) > 0)
		{
			?>
				<div class="panel panel-default">
				  	<div class="panel-heading">Mensajes Nuevos <img src="img/nuevo.gif" > <span class="badge"><?=count($mensajes);?></span></div>
				  	<div class="panel-body">
				    	<?
							foreach ($mensajes as $m)
							{
								?>
									<span><?=$m['mensaje']?></span>
									<a href="index.php?sub=men&op=det&id=<?=$m['id_mensaje'];?>">Leer</a>
									<hr>
								<?
							}
						?>
				 	</div>
				</div>
			<?
		}

	?>

	<?
		if(count($pendientes)>0)
		{
			?>
				<div class="panel panel-default">
				  	<div class="panel-heading">Pendientes <span class="badge"><?=count($pendientes);?></span></div>
				  	<div class="panel-body">
				    	<?
						if(count($pendientes)>0)
						{
							foreach($pendientes as $rec)
							{	
								if($rec['status_p']=='P')
								{
									$status = '<span class="text-danger">Pendiente</span>';
								}
								else
								{
									$status = '<span class="text-success">Cerrado</span>';
								}

								?>
								<?=$rec['descripcion'];?><?=$status;?>, 
								<a class="f10" href="index.php?menu=ma&sub=pen&op=act&id=<?=$rec['id_pendiente'];?>" class="act_pen" data-id="<?=$rec['id_pendiente'];?>" data-descripcion="<?=$rec['descripcion'];?>" data-solucion="<?=$rec['solucion'];?>" data-visibilidad="<?=$rec['visibilidad'];?>" data-status-p="<?=$rec['status_p'];?>" >Mas detalles</a>

									
								<?
							}
						}
					?>
				 	</div>
				</div>
			<?
		}
	?>
	

	

	

</div>





	<div class="col-lg-6 ">		

		<div class="text-center" >
			<div class="form-group">
				<div style="text-align:center">
					<div class="col-lg-8 ">	
						<div class="form-group">			  
						  <input class="form-control"  type="text" id="txtq" name="txtq">
						  
						</div>
					</div>
					<div class="col-lg-1">	
						<a id="linkbuscar" href="#" class="btn btn-primary ">Buscar</a>
					</div>
				</div>
			</div>
			<br><br>
			<br>
			<br>

			<div style="padding-left:10px;">
				<span id="ms"></span>
			</div>			
		</div>

		<div id="contenido" class="text-center" style="display:none"></div>   

		<div id="opciones">
			
			<?
                if($_SESSION['s']['tipo_usuario'] != '1')
                {
                    ?>
                    	<a href="index.php?sub=emp&op=pro"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
							<img src="img/productos.png" class="w24" />
							<br>Productos
						</a>
                    <?
                 }
            ?>

			

	        <a href="index.php?sub=emp&op=act"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
	        	<img src="img/empresa.png" class="w24" />
	        	<br>Empresa
	        </a>

	        <?
                if($_SESSION['s']['tipo_usuario'] != '1')
                {
                    ?>
				        <a href="index.php?sub=emp&op=reds"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
				        	<img src="img/facebook-32.png" class="w24" />
				        	<br>Facebook
				        </a>
				        <a href="index.php?sub=emp&op=gal" class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
				        	<img src="img/galeria.png" class="w24" />
				        	<br>Galeria
				        </a>
				    <?
				}
			?>
	        <a href="index.php?sub=emp&op=mapa"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
	        	<img src="img/maps.png" class="w24" />
	        	<br>Ubicaci&oacute;n
	        </a>
	        <a href="index.php?sub=men"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
	        	<img src="img/mail-48.png" class="w24" />
	        	<br>Mensajes
	        </a>
	        <a href="index.php?sub=exp&op=fav"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
	        	<img src="img/start.png" class="w24" />
	        	<br>Favoritas
	        </a>

	        <?
                if($_SESSION['s']['tipo_usuario'] != '1')
                {
                    ?>                    
				        <a href="index.php?sub=blo&op=lis"  class="btn btn-default btn-sm"  style="margin:10px;width:100px;">
				        	<img src="img/avatar.png" class="w24" />
				        	<br>Posts
				        </a>				        
				    <?
				}    
			?>
	        

	        <br><br>

	        
	        
        </div>
	</div>






<br>






<div class="col-lg-3" >
    <div class="panel panel-default">
	 	<div class="panel-heading">
	 		<b>Lista pendientes <img src="img/nuevo.gif" /></b>
	 		<div class="fr">
	 			<!--a id="lk-clear" title="Limpiar pendientes"><img src="img/clear.png" /></a-->
	 			<a  href="#modal_nuevo_pendiente" role="button" data-toggle="modal" title="Registrar nuevo pendiente" ><img src="img/new.png" /></a>
	 		</div>
	 	</div>
	  	<div class="panel-body">	  		
	  		<table id="tb_pendientes" class="table table-striped table-hover">
	  			<tr id="pendiente_vacio">
	  				<td colspan="2">
	  					<div class="vacio text-center">
	  						<br><br><br><br>
	  						<img id="img_pen" src="img/check-128.png" />
	  						<br>
	  						<b id="txt_pen" class="text-success">Sin pendientes</b>
	  						<br>
	  						<br>
	  						<br>
	  					</div>
	  				</td>
	  			</tr>	  			
	  		</table>
	  	</div>
	</div>
</div>


<div id="modal_nuevo_pendiente" class="modal">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header text-center">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title">Nuevo pendiente</h4>
      		</div>

      		<div  class="modal-body" class="loader">        
                <div id="f_new_ser" >
                	<form  class="form-horizontal" name="frm_reg_paciente" id="frm_reg_paciente" accion="index.php?menu=ma&sub=con&op=reg" method="POST">	
					    <div class="form-group">
					      	<label for="txtrecomendacion" class="col-lg-2 control-label">Descripci&oacute;n </label>
					      	<div class="col-lg-10">
					        	<textarea name="txtdes" id="txtdes" class="form-control input-sm" rows="3"></textarea>
					      	</div>
					    </div>

					</form>
		        </div>
      		</div><!--  FIN DEL  BODY MODAL-->
      		
      		<div class="modal-footer">
        		<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
        		<button type="button" id="btnenviar_ser" name="btnenviar_ser" class="btn btn-success">Guardar Cambios</button>
      		</div>
    	</div>
  	</div>
</div>