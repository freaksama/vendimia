<?
	/*******************************************************************
	*
	*                 Archivo de configuración
	*
	******************************************************************** 
	* En esta opcion se agregaran las configuraciones necesarias para 
	* que todo funcione.  Se agregan entre otras cosas constantes y 
	* rutas a directorios ademas de algunas configuraciones que nos 
	* ayudaran a tener mejor organizado nuestro sistema .
	*********************************************************************
	*
	*
    */
    
	if($_SERVER['SERVER_NAME'] == 'localhost'){ $modo = 'Desarrollo';}
    
    if($modo == 'Desarrollo')
    {
        $config['url_sitio'] = 'http://localhost/vendimia/'; 
        $config['url_api']   = 'http://localhost/vendimia/api';
    }
    else
    {
        $config['url_sitio'] = 'http://pymeanunciate.com/vendimia/'; 
        $config['url_api']   = 'http://pymeanunciate.com/vendimia//api';    
    }






?>