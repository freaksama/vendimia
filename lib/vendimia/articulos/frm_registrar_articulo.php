<script type="text/javascript">
    $(function(){

        obtener_siguiente_clave_articulo(); 

      $("#btn_enviar").click(function(){        
        var campo_error = ''; 
        if($("#txt_des").val() == ''){            
            campo_error = 'Descripcion'; 
        }

        if($("#txt_modelo").val() == '' & campo_error == ''){
            campo_error = 'Modelo'; 
        }

        if($("#txt_precio").val() == '' & campo_error == ''){
            campo_error = 'Precio'; 
        }

        if($("#txt_existencia").val() == '' & campo_error == ''){
            campo_error = 'Existencia'; 
        }

        if(campo_error != '')
        {
            alert('No es posible continuar, debe ingresar ' + campo_error + ', es obligatorio'); 
            return false;     
        }

        var des         = $("#txt_des").val(); 
        var modelo      = $("#txt_modelo").val(); 
        var precio      = $("#txt_precio").val(); 
        var existencia  = $("#txt_existencia").val(); 

        registrar_articulo(des,modelo,precio,existencia);         
        return false;
      });   

      $("#btn_cancelar").click(function(){
        window.location.href = 'index.php?op=articulos'; 
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

      <form class="form-horizontal" action="index.php?op=new_cliente" method="POST">
        <fieldset>
          <legend>Registro de Articulo</legend>

            <div class="fr">
                <b class="text-success">Clave: <span id="txt_clave"></span></b>
            </div>
          

          <div class="form-group">
            <label for="txt_des" class="col-lg-3 control-label">Descripci&oacute;n</label>
            <div class="col-lg-6">
              <input type="text" class="form-control input-sm" id="txt_des" name="txt_des" maxlength="30" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_modelo" class="col-lg-3 control-label">Modelo</label>
            <div class="col-lg-6">
              <input type="text" class="form-control input-sm" id="txt_modelo" name="txt_modelo" maxlength="30" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_precio" class="col-lg-3 control-label">Precio</label>
            <div class="col-lg-4">
              <input type="text" class="form-control input-sm" id="txt_precio" name="txt_precio" maxlength="30" onKeyPress="return soloNumeros(event)" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_existencia" class="col-lg-3 control-label">Existencia</label>
            <div class="col-lg-2">
              <input type="text" class="form-control input-sm" id="txt_existencia" name="txt_existencia" onKeyPress="return soloNumeros(event)" maxlength="20" />
            </div>
          </div>
          

            <div class="form-group text-right">
                <div class="col-lg-10 col-lg-offset-2">
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