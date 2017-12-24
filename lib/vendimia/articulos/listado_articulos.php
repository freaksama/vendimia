
<script type="text/javascript"> 
    $(function(){
        obtener_listado_articulos(); 
    }); 
</script>


<div class="col-lg-3">
   <? include 'lib/menus/sub_menu.php'; ?>
</div>

<div class="col-lg-8">
    <div class="fr">    
        <a href="index.php?op=new_articulo" class="btn btn-sm btn-default">
            <img src="img/new.png" width="24" /> 
            Nuevo Articulo
        </a>
    </div>

    <div>
        <h3>Articulos Registrados</h3>
    </div>

    <table id="t_articulos" class="table table-striped table-hover table-bordered ">
    <thead>
        <tr>
            <th style="width: 150px;">Clave Articulo</th>
            <th>Descripci&oacute;n</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    </table>
</div>

