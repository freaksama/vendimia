<script type="text/javascript">
    $(function(){

        obtener_configuracion(); 

      $("#btn_enviar").click(function(){        
        var campo_error = ''; 
        if($("#txt_tasa").val() == ''){            
            campo_error = 'Tasa Financiamiento'; 
        }

        if($("#txt_enganche").val() == '' & campo_error == ''){
            campo_error = 'Enganche'; 
        }

        if($("#txt_plazo").val() == '' & campo_error == ''){
            campo_error = 'Plazo'; 
        }

        if(campo_error != '')
        {
            alert('No es posible continuar, debe ingresar ' + campo_error + ', es obligatorio'); 
            return false;     
        }
        
        var tasa        = $("#txt_tasa").val(); 
        var enganche    = $("#txt_enganche").val(); 
        var plazo       = $("#txt_plazo").val();         

        actualizar_configuracion(tasa,enganche,plazo); 
        return false;
      });   

      $("#btn_cancelar").click(function(){
        window.location.href = 'index.php?op=ventas'; 
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

      <form class="form-horizontal" action="index.php?op=configuracion" method="POST">
        <fieldset>
          <legend>Configuraci&oacute;n General</legend>

          <div class="form-group">
            <label for="txt_tasa" class="col-lg-4 control-label">Tasa Financiamiento</label>
            <div class="col-lg-2">
              <input type="text" class="form-control input-sm" id="txt_tasa" name="txt_tasa" maxlength="5" onKeyPress="return soloNumeros(event)" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_enganche" class="col-lg-4 control-label">% Enganche</label>
            <div class="col-lg-2">
              <input type="text" class="form-control input-sm" id="txt_enganche" name="txt_enganche" maxlength="5" onKeyPress="return soloNumeros(event)" />
            </div>
          </div>

          <div class="form-group">
            <label for="txt_plazo" class="col-lg-4 control-label">Plazo Maximo</label>
            <div class="col-lg-2">
              <input type="text" class="form-control input-sm" id="txt_plazo" name="txt_plazo" maxlength="5" onKeyPress="return soloNumeros(event)" />
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