<script type="text/javascript" src="http://localhost/auto/scripts/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="http://localhost/auto/scripts/jquery.mockjax.js"></script>
<script type="text/javascript" src="http://localhost/auto/src/jquery.autocomplete.js"></script>
<script type="text/javascript" src="http://localhost/auto/scripts/countries.js"></script>
<!--script type="text/javascript" src="http://localhost/auto/scripts/demo.js"></script-->

<script type="text/javascript">
    var lista_articulos = [];     
    var importe_total = 0; 
    var total = 0;


    $(function(){


        

        obtener_siguiente_clave_venta(); 

        obtener_clientes_auto(); 
        obtener_articulos_auto();

        var clientes_json = [{
            id : '1',
            value : '001 - Diego Guerra Atienzo',
            data: 'GUAD880129160'
        }]; 


        $("#btn_agregar_articulo").click(function(){

            var id  = $("#txt_articulo").val(); 

            if(id != '')
            {
                agregar_articulo_venta(id); 
                $("#txt_articulo").val(''); 
                $("#txt_nombre_articulo").val(''); 
            }

        }); 


        $("#txt_nombre").keyup(function(e){
          var consulta = $("#txt_nombre").val(); 
          buscar_cliente(consulta);
        }); 


        $(document).on('change','.input-cantidad',function(){
            
            var json      = {
                id_articulo : $(this).data('id-articulo'), 
                descripcion : $(this).data('descripcion'),
                modelo : $(this).data('modelo'),
                cantidad : $(this).val(),
                precio : $(this).data('precio'),
                precio_venta : $(this).data('precio'),
                importe :  $(this).data('precio') * $(this).val()
            }; 

            $("#tr_art_"+$(this).data('id-articulo')).remove(); 

            lista_articulos.forEach(function(e){
                if(e.id_articulo==json.id_articulo)
                {
                    e.cantidad = json.cantidad; 
                    e.importe = json.importe; 
                }
            }); 

            $(this).focus(); 

            pintar_articulo(json); 
            calcular_importe_total(); 
        }); 

        $(document).on('click','.drop-element',function(){
            if(confirm('Realmente desea eliminar este registro?'))
            {
                $("#tr_art_"+$(this).data('id-articulo')).remove();                 
            }
        }); 

        
        $("#btn_siguiente").click(function(){

            if($("#txt_cliente").val() == '')
            {
                alert('Los datos ingresados no son correctos, favor de verificar') ; 
                return false; 
            }

            if(lista_articulos.length == 0)
            {
                alert('Los datos ingresados no son correctos, favor de verificar') ; 
                return false;    
            }

            if(importe_total == '0')
            {
                alert('Los datos ingresados no son correctos, favor de verificar') ; 
                return false;    
            }

            $("#abonos").fadeIn();
            $("#btn_siguiente").hide();
            $("#btn_enviar").show(); 

            calcular_abonos(total); 
            return false;
        }); 
      

      $("#btn_cancelar").click(function(){
        window.location.href = 'index.php?op=ventas'; 
        return false; 
      });

      $("#btn_enviar").click(function(){

        if($("#txt_cliente").val() == '')
        {
            alert('Los datos ingresados no son correctos, favor de verificar') ; 
            return false; 
        }

        if(lista_articulos.length == 0)
        {
            alert('Los datos ingresados no son correctos, favor de verificar') ; 
            return false;    
        }

        if(importe_total == '0')
        {
            alert('Los datos ingresados no son correctos, favor de verificar') ; 
            return false;    
        }


        var cliente     = $("#txt_cliente").val(); 
        var articulos   = $("#txt_articulo").val(); 
        var plazos      = ''; 
        var articulos_json = JSON.stringify(lista_articulos); 

        var $elegido =$("input[name=plazos]:checked");
        if ($elegido.val())
        {   
            plazos = $elegido.val();
        }
        else 
        {
            alert("Debe seleccionar un plazo para realizar el pago de su compra")  
            return false; 
        }

        

        guardar_venta(cliente,articulos,plazos,total,articulos_json); 

        


        return false; 


      }); 

    });

    function pintar_articulo(json)
    {
        if(json.id_articulo!= '')
        {
            var html = ''; 

            html += '<tr id="tr_art_'+json.id_articulo+'">'; 
            html += '   <td>'+json.descripcion+'</td>'; 
            html += '   <td>'+json.modelo+'</td>'; 
            html += '   <td><input type="text" style="width:60px;" class="input-cantidad" data-id-articulo="'+json.id_articulo+'" data-descripcion="'+json.descripcion+'" data-modelo="'+json.modelo+'" data-importe="'+json.importe+'" data-precio="'+json.precio_venta+'" onKeyPress="return soloNumeros(event)" value="'+json.cantidad+'" /> </td>'; 
            html += '   <td>'+formatMoney(json.precio_venta)+'</td>'; 
            html += '   <td>'+formatMoney(json.importe)+'</td>'; 
            html += '   <td><a href="javascript:void(0)" class="drop-element" data-id-articulo="'+json.id_articulo+'"><img src="img/drop.png" /></a></td>'; 
            html += '</tr>'; 

            $("#t_new_ventas tbody").append(html);
        }
    }

    function calcular_importe_total()
    {
        var total = 0; 
        lista_articulos.forEach(function(e){
            total += parseFloat(e.importe); 
        }); 

        importe_total = total; 

        calcular_enganche(importe_total); 
    }




</script>




<div class="col-lg-3">
   <? include 'lib/menus/sub_menu.php'; ?>
</div>

<div class="row">
<div class="col-lg-8">
    <div class="panel panel-default">
    <div class="panel-body">

      <form class="form-horizontal" action="#" method="POST">
        <fieldset>
          <legend>Registro de Ventas</legend>

            <div class="fr">
                <b class="text-success">Clave: <span id="txt_clave"></span></b>
            </div>
          

          <div class="form-group">
            <label for="txt_nombre" class="col-lg-1 control-label">Cliente</label>
            <div class="col-lg-4">
              <input type="hidden" name="txt_cliente" id="txt_cliente" />
              <input type="text" class="form-control input-sm" autocomplete="on" id="txt_nombre" name="txt_nombre" maxlength="30" />                            
            </div>
            <div class="col-lg-3">
              <label id="selction-ajax" for="txt_nombre" class="control-label"></label>              
            </div>
          </div>

          <div class="form-group">
            <label for="txt_nombre_articulo" class="col-lg-1 control-label">Articulo</label>
            <div class="col-lg-4">
              <input type="hidden" id="txt_articulo" name="txt_articulo" value="" />
              <input type="text" class="form-control input-sm" id="txt_nombre_articulo" name="txt_nombre_articulo" maxlength="30" />
            </div>
            <div class="col-lg-1">
              <a id="btn_agregar_articulo" class="btn btn-xs btn-default" ><img src="img/new.png" /></a>
            </div>
          </div>

          <hr>
          <div id="body-new-venta">
           <table id="t_new_ventas" class="table table-striped table-hover table-bordered ">
            <thead>
                <tr>
                    <th>Descripcion articulo</th>
                    <th>Modelo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            </table>
          </div>
          <hr>
            <div id="div-enganche" class="col-lg-12">
                <div class="col-lg-5 col-lg-offset-7">
                  <table class="table table-striped table-hover table-bordered">
                      <tr>
                          <td>Enganche</td>
                          <td><span id="enganche">$ 0.00</span></td>
                      </tr>
                      <tr>
                          <td>Bonificaci&oacute;n Enganche</td>
                          <td><span id="bonificacion_enganche">$ 0.00</span></td>
                      </tr>
                      <tr>
                          <td>Total</td>
                          <td><span id="total">$ 0.00</span></td>
                      </tr>
                  </table>
                </div>
            </div>

            <hr>

            <div id="abonos" class="col-lg-12" style="display: none">
               <div class="panel panel-primary">
                  <div class="panel-heading">
                    <div class="text-center">
                        <h3 class="panel-title">ABONOS MENSUALES</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <table id="t_abonos" class="table table-striped table-hover table-bordered">
                        <tbody>
                            
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
          

            <div class="form-group text-right">
                <div class="col-lg-10 col-lg-offset-2">
                    <button id="btn_cancelar" class="btn btn-default">Cancelar</button>
                    <button id="btn_siguiente"  class="btn btn-primary">Siguiente </button>
                    <button id="btn_enviar" style="display: none" class="btn btn-primary">Guardar </button>
                </div>
            </div>

        </fieldset>
      </form>
    </div>
    </div>
</div>
</div>