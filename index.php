<?
    session_start();
    date_default_timezone_set('America/Chihuahua');
    /*ini_set('default_charset','iso-8859-1');
    ini_set('mbstring.internal_encoding', 'iso-8859-1');
    ini_set('mbstring.http_output', 'iso-8859-1');
    ini_set('mbstring.encoding_translation', 'On');
    ini_set('mbstring.func_overload', '6');*/
    
    include 'app/config/config.php';
    include 'app/include.php';

?>
<!DOCTYPE html>
    <head>
        <script type="text/javascript">
            var token_web = '<?=$_SESSION['s']['token_web'];?>';            
            var api_url = '<?=$config['url_api'];?>';
        </script>
        <meta http-equiv="Content-Type" content="text/html;" >
        <meta charset="ISO-8859-1">
        <title>ConCredito </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <base href="<?=$config['url_sitio'];?>">
        <link href="<?=$config['url_sitio'];?><?=$c_sistema->obtenerTemaSistema();?>" rel="stylesheet">
        <script src="<?=$config['url_sitio'];?>js/jquery-1.9.1.js"></script>
    </head>
    <body>    
        <?
            include 'app/controladores/menus.php';
        ?>
        <div class="container">
            <br><br><br><br>
            <?
                include 'app/controladores/componentes.php';
            ?>
        </div>
        <script src="<?=$config['url_sitio'];?>js/main.js"></script>        
        <script src="<?=$config['url_sitio'];?>js/bootstrap.js"></script>
        <link href="<?=$config['url_sitio'];?>css/bootstrap-responsive.min.css" rel="stylesheet">
        <link  href="<?=$config['url_sitio'];?>css/style.css" rel="stylesheet">
        <script src="<?=$config['url_sitio'];?>js/controladores/empresas.controlador.js"></script>
        <script src="<?=$config['url_sitio'];?>js/app.services.js"></script>
    </body>
</html>
