<script type="text/javascript">
    $(function(){

        var id = $("#txt_id").val();  

        obtener_cliente(id); 

      $("#btn_enviar").click(function(){        
        var campo_error = ''; 
        if($("#txt_nombre").val() == ''){            
            campo_error = 'Nombre'; 
        }

        if($("#txt_apellido_paterno").val() == '' & campo_error == ''){
            campo_error = 'Apellido Paterno'; 
        }

        if($("#txt_apellido_materno").val() == '' & campo_error == ''){
            campo_error = 'Apellido Materno'; 
        }

        if($("#txt_rfc").val() == '' & campo_error == ''){
            campo_error = 'RFC'; 
        }

        if(campo_error != '')
        {
            alert('No es posible continuar, debe ingresar ' + campo_error + ', es obligatorio'); 
            return false;     
        }

        var id                  = $("#txt_id").val(); 
        var nombre              = $("#txt_nombre").val(); 
        var apellido_paterno    = $("#txt_apellido_paterno").val(); 
        var apellido_materno    = $("#txt_apellido_materno").val(); 
        var rfc                 = $("#txt_rfc").val(); 

        actualizar_cliente(id,nombre,apellido_paterno,apellido_materno,rfc); 
        return false;
      });   

      $("#btn_cancelar").click(function(){
        window.location.href = 'index.php?op=clientes'; 
        return false; 
      }); 

    });
</script>


<div class="col-lg-3">
   <? include 'lib/menus/sub_menu.php'; ?>
</div>

<div class="row">
<div class="col-lg-6">
    <div class="panel panel-default">
    <div class="panel-body">

      <form class="form-horizontal" action="index.php?op=edi_cliente" method="POST">
        <fieldset>
          <legend>Actualizar Cliente</legend>

            <div class="fr">
                <b class="text-success">Clave: <span id="txt_clave"></span></b>
            </div>
          

          <div class="form-group">
            <label for="txt_nombre" class="col-lg-3 control-label">Nombre</label>
            <div class="col-lg-5">
              <input type="text" class="form-control input-sm" id="txt_nombre" name="txt_nombre" maxlength="30" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_apellido_paterno" class="col-lg-3 control-label">Apellido Paterno</label>
            <div class="col-lg-5">
              <input type="text" class="form-control input-sm" id="txt_apellido_paterno" name="txt_apellido_paterno" maxlength="30" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_apellido_materno" class="col-lg-3 control-label">Apellido Materno</label>
            <div class="col-lg-5">
              <input type="text" class="form-control input-sm" id="txt_apellido_materno" name="txt_apellido_materno" maxlength="30" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_rfc" class="col-lg-3 control-label">RFC</label>
            <div class="col-lg-4">
              <input type="text" class="form-control input-sm" id="txt_rfc" name="txt_rfc" maxlength="20" />
            </div>
          </div>
          

            <div class="form-group text-right">
                <div class="col-lg-10 col-lg-offset-2">
                    <input type="hidden" name="txt_id" id="txt_id" value="<?=$_GET['id'];?>" />
                    <button id="btn_cancelar" class="btn btn-default">Cancelar</button>
                    <button id="btn_enviar" class="btn btn-primary">Guardar</button>
                </div>
            </div>

        </fieldset>
      </form>
    </div>
    </div>
</div>
</div>