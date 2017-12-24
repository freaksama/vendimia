<?php
    #cabeceras necesarias para la comunicacion con angular
    //error_reporting(2);
	header('Access-Control-Allow-Origin: *');	
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');	
	header('Access-Control-Allow-Headers:application/x-www-form-urlencoded; charset=UTF-8');
	header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');    	
	header('Content-Type: text/html; charset=iso-8859-1');    	
        //header('Access-Control-Allow-Headers');
	//include('lib/config/conexion_mysqli.php');
	//include('lib/base/class_base.php');    
	
	//$db 	= new MySQLi_conexion();	
    /*
        .htaccess
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?PATH_INFO=$1 [L,QSA]
    */
	#Carga de librerias 

	#include('../pymes/app/include.php');         
    #include('../app/include.php');     

    //include('../pymes/app/include.php');     
    include('../app/include.php');     
	


	# Se obtiene el End point solicitado
    $pre_end_point  = explode('/',$_GET['PATH_INFO']);
	$end_point      = $pre_end_point[0]; 
    
	# Se obtiene el metodo enviado, (post,get,delete,put,)
	$metodo       	= Base::obtenerMetodo(); 

    # Se identifica el metodo y se guarda los parametros 
    $parametros     = Base::obtenerValoresMetodo($metodo);     

    #Se obtiene la cabecesa con el token de identificacion
    //$cabeceras 		=  apache_request_headers();     
    //$token_valido 	= Base::validarJWT($cabeceras); 

    #Validacion de token valido, Si el token no es valido y la solicitud es diferente al login, envia codigo de respuesta 401    
    /*if($end_point != 'login' & $token_valido==false)
    {
        //http_response_code(401);     
        //die();    
    } */

    //var_dump($pre_end_point); 

    include('rutas.php'); 

    //if(count($resultado) > 0)
    //{
    	$json = json_encode($resultado); 
    	echo $json; 	
    //}
?>	