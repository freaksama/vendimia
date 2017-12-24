
<script type="text/javascript"> 
    $(function(){
        obtener_listado_ventas(); 
    }); 
</script>


<div class="col-lg-3">
   <? include 'lib/menus/sub_menu.php'; ?>
</div>

<div class="col-lg-8">
    <div class="fr">    
        <a href="index.php?op=new_venta" class="btn btn-sm btn-default">
            <img src="img/new.png" width="24" /> 
            Nueva Venta
        </a>
    </div>

    <div>
        <h3>Ventas Activas</h3>
    </div>

    <table id="t_ventas" class="table table-striped table-hover table-bordered ">
    <thead>
        <tr>
            <th style="width: 150px;">Folio Venta</th>
            <th>Clave Cliente</th>
            <th>Nombre</th>
            <th>Total</th>
            <th>Fecha</th>            
        </tr>
    </thead>
    <tbody>

    </tbody>
    </table>
</div>

