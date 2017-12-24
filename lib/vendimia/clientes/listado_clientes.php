
<script type="text/javascript"> 
    $(function(){
        obtener_listado_clientes(); 
    }); 
</script>


<div class="col-lg-3">
   <? include 'lib/menus/sub_menu.php'; ?>
</div>

<div class="col-lg-8">
    <div class="fr">    
        <a href="index.php?op=new_cliente" class="btn btn-sm btn-default">
            <img src="img/new.png" width="24" /> 
            Nuevo Cliente
        </a>
    </div>

    <div>
        <h3>Clientes Registrados</h3>
    </div>

    <table id="t_clientes" class="table table-striped table-hover table-bordered ">
    <thead>
        <tr>
            <th style="width: 100px;">Clave Cliente</th>
            <th>Nombre</th>            
        </tr>
    </thead>
    <tbody>

    </tbody>
    </table>
</div>

