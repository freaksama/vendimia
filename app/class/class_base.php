<?class Base
{


	function __construct(&$db)
	{
		
	}



	function ConvertirResultArrayOdbc($result)
	{
		$data = array();

		if($result->size() > 0)
		{
			$data = $result->fetch();
		}
		return $data;
	}


	function ConvertirResultMatrizOdbc($result) 
	{
		$data = array(); 

		if($result != null)
		{
			$data = $result->fetchAll(); 	
		}
		
		return $data; 
	}


	# Funciones complementarias
	function ConvertirResultArray($result)
	{
		$data = array();

		if($result->size() > 0)
		{
			$data = $result->fetch();

		}
		return $data;
	}

	function ConvertirResultMatriz($result)
	{
		$data = array();

		if($result->size() > 0)
		{
			while($rec = $result->fetch())
			{
				$data[] = $rec;
			}
		}
		return $data;
	}

	# Descripcion :  limpia las cadenas de codigo html, php, elimina los espacios en blanco y agrega '/ en las comillas simples  y dobles
	# Fecha :  2016-08-19
	function clean($str)
	{
		$str = trim($str);
		$str = strip_tags($str);
		$str = addslashes($str);   
		$str = str_replace("'","", $str);
		$str = str_replace('"',"", $str);
		return $str;
	}

	# Descripcion :  limpia las cadenas de un array  de codigo html, php, elimina los espacios en blanco y agrega '/ en las comillas simples  y dobles
	# Fecha :  2016-08-19
	function clean_r($datos)
	{
    	if(count($datos) > 0)
    	{
	        foreach ($datos as $elemnto => $str)
	        {
	            if (is_array($str))
	            {
	                $datos[$elemnto]= $this->clean_r($str);
	            }
	            else
	            {  
	                $str = trim($str);		                
	                //$str = strip_tags($str);
	                $str = addslashes($str);                
	                $datos[$elemnto] = $str;
	            }
	        }
	    }
        return $datos;
	}

	public static function router($method,$url,$closure) 
	{  
	    $route = '/'.$_GET['PATH_INFO'];

	    if (strpos($route, '?')) {
	        $route = strstr($route, '?', true);
	    }

	    $urlRule = preg_replace('/:([^\/]+)/', '(?<\1>[^/]+)', $url);
	    $urlRule = str_replace('/', '\/', $urlRule);

	    # si la ruta coincide, se recogen los resultados que devuelve la función preg_match, y se compara con los parámetros que acepta la ruta: 
	    preg_match_all('/:([^\/]+)/', $url, $parameterNames);

	    $metodo = strtolower($_SERVER['REQUEST_METHOD']);

	    if($method == $metodo )
	    {
	    	if (preg_match('/^' . $urlRule . '\/*$/s', $route, $matches)) 
	    	{
		        $parameters = array_intersect_key($matches, array_flip($parameterNames[1]));
		        #Finalmente llamamos al closure y le enviamos todos los parámetros de la ruta
		        call_user_func_array($closure, $parameters);
		    }	
	    }	    
	}

	function date_to_timestamp($fecha)
	{
		return strtotime($fecha);
	}

	function obtener_meses()
	{
		$meses['1']  = 'Enero'; 
		$meses['2']  = 'Febrero'; 
		$meses['3']  = 'Marzo'; 
		$meses['4']  = 'Abril'; 
		$meses['5']  = 'Mayo'; 
		$meses['6']  = 'Junio'; 
		$meses['7']  = 'Julio'; 
		$meses['8']  = 'Agosto'; 
		$meses['9']  = 'Septiembre'; 
		$meses['10'] = 'Octubre'; 
		$meses['11'] = 'Noviembre'; 
		$meses['12'] = 'Diciembre'; 
		
		return $meses;
	}



	/******************************************************* 
	* Desarrollador : Diego Guerra
	* Entrada    	: correo_destinatario, Nombre, destinatario, asunto, body. 
	* Salida 		: Encuesta Completa
	* Fecha 		: 2017-01-17
	* Descripcion   : Obtiene el cuestionario completo con respuestas de un usuario 
	*******************************************************/ 	
	/*
	function enviar_correo($datos)
	{ 
		
		require_once ('mail/PHPMailerAutoload.php');		
		$mail = new PHPMailer;

		# CONFIGURACION DEL CORREO 				
		$host 				= 'smtp.fincamex.com.mx'; 
		$correo 			= 'soporte@fincamex.com.mx'; 
		$password 			= 'So4807FMX$'; 
		$puerto     		= '25'; 
		$correo_from		= 'soporte@fincamex.com.mx';  
		$nombre_from		= 'SIFWEB'; 

		#PREPARACION DE VARIABLES 
		$para 				= $datos['para']; 
		$nombre_para		= $datos['nombre']; 
		$asunto  			= $datos['asunto']; 
		$cuerpo 			= $datos['cuerpo']; 

		#CONFIGURACION PARA ENVIER CORREOS SIN SSL
		
		$mail->SMTPOptions = array(
		    	'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);
		
		//$mail->SMTPDebug  = 3;            			// Enable verbose debug output		
		$mail->isSMTP();                    			// Set mailer to use SMTP
		$mail->Host 		= $host;  					// Specify main and backup SMTP servers
		$mail->SMTPAuth 	= true;         			// Enable SMTP authentication
		$mail->Username 	= $correo_from; 			// SMTP username
		$mail->Password 	= $password;    			// SMTP password
		$mail->SMTPSecure 	= false ;       			// Enable TLS encryption, `ssl` also accepted
		$mail->Port 		= $puerto;     			 	// TCP port to connect to
		$mail->setFrom($correo_from, $nombre_from);		
		$mail->addAddress($para, $nombre_para); 		// Add a recipient
		$mail->isHTML(true);                   			// Set email format to HTML
		$mail->Subject 		= $asunto;
		$mail->Body    		= $cuerpo;
		$mail->AltBody 	 	= 'NO es posible ver el contenido html ';

		if(!$mail->send()) 
		{
			$data['codigo']  = '001'; 	
			$data['mensaje'] = 'Error al enviar el email : '. $mail->ErrorInfo;; 		    
		}
		else 
		{
			$data['codigo']  = '000'; 
			$data['mensaje'] = 'Correo Enviado'; 		    
		}

		return $data; 

	}*/

	function enviar_correo($datos)
    {
        $headers  = "From: ".strip_tags($datos['from'])."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if(mail($datos['to'], $datos['asunto'], $datos['mensaje'], $headers))
        {
        	$data['codigo'] = '000';
        	$data['mensaje'] = 'Exito'; 
        }
        else
        {
        	$data['codigo'] = '001';
        	$data['mensaje']= 'Error';
        }

        return $data;
    }
/*
	public static function generarJWT($datos)
	{
		# Palabra secreta
		$secret = 'fincamex'; 

		#Fecha actual
		$time  	= time(); 

		# Se genera la cabecera, esto es informacion del token
		$encoded_header  = base64_encode('{"alg": "HS256","typ": "JWT"}');

		# Se genera el payload, informacion del usuario para identificarlo
		$encoded_payload = base64_encode('{"id: "'.uniqid().'","numeroEmpleado": "'.$datos['NoEmpleado'].'","nombre": "'.$datos['Nombre'].'", "apellidoPaterno": "'.$datos['ApellidoPaterno'].'", "apellidoMaterno": "'.$datos['ApellidoMaterno'].'", "correo": "'.$datos['Correo'].'", "exp": "'.((string)$time+(60*60)).'","compania": "Fincamex"}'); 

		# Se unen el header y el payload
		$header_and_payload = $encoded_header.'.'.$encoded_payload; 

		# Se encripta en SHA256 con la palabra secreta
		$firma = base64_encode(hash_hmac('sha256', $header_and_payload,$secret,true)); 

		# Se crea token completo con el formato header.payload.firma
		$jwt_token = $header_and_payload.'.'.$firma; 

		return $jwt_token; 
	}*/

	/******************************************************* 
	* Desarrollador : Diego Guerra
	* Entrada    	: Token (JWT)
	* Salida 		: Bool true, false
	* Fecha 		: 2016-11-19
	* Descripcion   : Valida si el token en correcto 
	*******************************************************/
	/*
	public static function validarJWT($datos)
	{
		$jwt = $datos['Authorization'];

		# Palabra secreta
		$secret = 'fincamex'; 

		# Se separa el token en sus componentes
		$jwt_values = explode('.', $jwt);

		# Se obtiene la firma 
		$firma = $jwt_values[2]; 			

		# Se unen el header y el payload
		$header_and_payload = $jwt_values[0].'.'.$jwt_values[1]; 

		# Se calcula la firma con el header y el payload
		$firma_posible = base64_encode(hash_hmac('sha256', $header_and_payload,$secret,true)); 

		# Valida que la firma sea correcta 
		if($firma ==  $firma_posible)
		{
			$data = true; 
		}
		else
		{
			$data = false; 
		}

		return $data; 
	}*/

	function generar_token_MJWT($datos)
	{
		$secret = '10000001DIEGO1000000001';
		$time  	= time(); 

		$token = '{"id_usuario": "'.$datos['id_usuario'].'","id_empresa": "'.$datos['id_empresa'].'", "exp": "'.((string)$time+(60*60)).'","compania": "pymeanunciate"}'; 

		$firma = $this->encrypt($token,$secret); 

		return $firma;
	}

	function validar_token_MJWT($token)
	{
		$secret = '10000001DIEGO1000000001';
		$json   = $this->decrypt($token,$secret); 
		$json   = str_replace('\"','' ,$json); 
		$datos  = json_decode($json,true);
		return $datos;
	}


	function encrypt($string, $key) 
	{
	   $result = '';
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr($key, ($i % strlen($key))-1, 1);
	      $char = chr(ord($char)+ord($keychar));
	      $result.=$char;
	   }
	   return base64_encode($result);
	}
	function decrypt($string, $key) 
	{
	   $result = '';
	   $string = base64_decode($string);
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr($key, ($i % strlen($key))-1, 1);
	      $char = chr(ord($char)-ord($keychar));
	      $result.=$char;
	   }
	   return $result;
	}

	/******************************************************* 
	* Desarrollador : Diego Guerra
	* Entrada    	: 
	* Salida 		: metodo (get,post,delete,put)
	* Fecha 		: 2016-11-19
	* Descripcion   : Obtiene el metodo desde donde se envia la informacion
	*******************************************************/
	public static function obtenerMetodo()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}	


	/******************************************************* 
	* Desarrollador : Diego Guerra
	* Entrada    	: metodo
	* Salida 		: informacion (array)
	* Fecha 		: 2016-11-19
	* Descripcion   : Se obtiene el array con los datos, dependiendo el metodo
	*******************************************************/
	public static function obtenerValoresMetodo($metodo)
	{
		if($metodo == 'get' || $metodo == 'delete')
		{
			$parametros = $_GET; 
		}
		else if($metodo == 'post')
		{
			$parametros = $_POST; 
		}
		else
		{
			#$tmp = file_get_contents("php://input"); 
	    	#$parametros = json_decode($tmp, true);
	    	parse_str(file_get_contents("php://input"),$parametros);
		}

		return $parametros; 
	}

	function obtenerTemaSistema()
	{
		switch ($_SESSION['s']['tema']) 
	    {
	        case '1' : $tema_css = 'css/temas/bootstrap_cerulean.css';      break;
	        case '2' : $tema_css = 'css/temas/bootstrap_cosmo.css';         break;
	        case '3' : $tema_css = 'css/temas/bootstrap_cyborg.css';        break;
	        case '4' : $tema_css = 'css/temas/bootstrap_darkly.css';        break;
	        case '5' : $tema_css = 'css/temas/bootstrap_flatly.css';        break;
	        case '6' : $tema_css = 'css/temas/bootstrap_journal.css';       break;
	        case '7' : $tema_css = 'css/temas/bootstrap_lumen.css';         break;
	        case '8' : $tema_css = 'css/temas/bootstrap_paper.css';         break;
	        case '9' : $tema_css = 'css/temas/bootstrap_readable.css';      break;
	        case '10': $tema_css = 'css/temas/bootstrap_sandstone.css';     break;
	        case '11': $tema_css = 'css/temas/bootstrap_simplex.css';       break;
	        case '12': $tema_css = 'css/temas/bootstrap_slate.css';         break;
	        case '13': $tema_css = 'css/temas/bootstrap_spacelab.css';      break;
	        case '14': $tema_css = 'css/temas/bootstrap_superhero.css';     break;
	        case '15': $tema_css = 'css/temas/bootstrap_united.css';        break;
	        case '16': $tema_css = 'css/temas/bootstrap_yeti.css';          break;                
	        default  : $tema_css = 'css/temas/bootstrap_cerulean.css';                  break;
	    }

	    return $tema_css;
	}

	function crear_paginas($datos)
	{
		$data['row_page'] 	= '10';

		$data['page'] 		= $datos['page'];

		$data['num_row']  	= $datos['num_row'];

		$data['lastpage'] 	  = ceil( $data['num_row'] / $data['row_page']);
		
		if($data['page']=='')
		{
			$data['page'] = 1;	
		}
		if($data['page'] > $data['lastpage'] )
		{
			$data['page'] = $data['lastpage'];
		}
		if($data['page'] <= 0)
		{
			$data['page'] = 1;
		}

		$data['limit'] = ' LIMIT '.($data['row_page'] * ($data['page'] - 1)).','.$data['row_page'];

		return $data;
	}

	function generar_tags($cadena)
    {
		$link = 'localhost/p/pymes/index.php?sub=exp&tag='; 

    	$cadena = $cadena;

    	$cadenas = explode(" ", $cadena);
    	$des 	 = '';

      	if(count($cadenas) > 0)
		{            
			for($i=0 ;$i <= count($cadenas) ;$i++)
			{
				// Se buscan las tags que inicien con # 
				$findme   = '#';
                $pos = strpos(trim($cadenas[$i]), $findme);

				if ($pos !== false) 
				{
					if($pos == 0)
					{
                        // se limpia el tags de simbolos ratos 
			            $cadena_ori     = $cadenas[$i];
		           		$cadenas[$i] 	=  ltrim($cadenas[$i]);
						$cadenas[$i]	=  str_replace(' ', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('"', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace("'", '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('/', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('.', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('*', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('-', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('$', '', $cadenas[$i]);						
						$cadenas[$i]	=  str_replace('%', '', $cadenas[$i]);
						$cadenas[$i]	=  str_replace('(', '', $cadenas[$i]);
						$cadenas[$i]	=  str_replace(')', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('|', '', $cadenas[$i]);						
						$cadenas[$i] 	=  str_replace(',', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace(':', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace(';', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('{', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('}', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('=', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('~', '', $cadenas[$i]);
						$cadenas[$i] 	=  str_replace('^', '', $cadenas[$i]);

						$tags = substr($cadenas[$i], 1);
						$des .= '<a href="'.$link.$tags.'">'.$cadena_ori.' </a>';
					}
					else
					{
						$des .=  $cadenas[$i].' ';
					}

					continue;
				}
			}
			return $des;
		}
    }
	

	function generar_tags_servicios($cadena, $link = 'index.php?sub=exp&q=')
	{
    	$cadena = $cadena;
    	$cadenas = explode(",", $cadena);
    	$des 	 = '';

      	if(count($cadenas) > 0)
		{            
			for($i=0 ;$i < count($cadenas) ;$i++)
			{	
				$cadena_ori     = $cadenas[$i];
				$cadenas[$i] 	=  ltrim($cadenas[$i]);
				$tags = $cadenas[$i];
				$des .= '<a href="'.$link.$tags.'">'.$cadena_ori.'</a>,';
			}			
		}

		return $des;
	}


	#-------------------------------------------------------------------------------------------------------

		function SubirAvatarUsuario($file)
	    {
		    $valores     = array();
	        $data        = array();
	        $alto        = 48;
	        $ancho       = 48;
	        $alto2       = 200;
	        $ancho2      = 200;        
	        $raiz_48     = 'src/avatar/48/';
	        $raiz_200    = 'src/avatar/200/';
	        $raiz_pic    = 'src/avatar/pic/'; 

	        $calidad     = 90; #Definimos la calidad de la imagen final
	       
	        $valores['id_usuario'] = $_SESSION['s']['id_usuario'];     
	       
	       
	        #verificamos que se selecciono una imagen
	        if(sizeof($file)==0)
	        {
	            $data['codigo']  = '001';
	            $data['mensaje'] = 'Es necesario seleccionar un archivo';               
	            return $data;
	        }

	        #nombre temporal del archivo a subir
	        $valores['archivo'] = $file['file1']["tmp_name"];


	       
	        #Definimos un array para almacenar el tamaño del archivo
	        $tamanio=array();
	       
	        #obtenemos el tamaño del archivo
	        $tamanio = $file['file1']["size"];
	       
	        #Obtenemos el mime o tipo de archivo
	        $valores['tipo'] = $file['file1']["type"];

	        
	       
	        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf               
	        switch($valores['tipo'])
	        {
	            case 'image/jpeg': break;                                           
	            case 'image/png' : break;
	            case 'image/gif' : break;
	            default:               
	                $data['codigo'] = '002';
	                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
	                return $data;
	            break;
	               
	        }
	       
	        #Obtenemos el nombre real del archivo                
	        $nombre_archivo = $valores['id_usuario'].'.jpg';


	        //Verificamos de nuevo que se selecciono un archivo
	        if( $valores['archivo'] != "none" )
	        {   
	            #Valida que el directorio exista, si no lo crea y le asigna los permisos.   
	            if(!is_dir($raiz_pic))
	            {
	                //mkdir($raiz, 0777, true);
	                mkdir($raiz_pic,0777); 
	            }

	            #Crea la ruta de destino de la carpeta del folio
	            $destino = $raiz_pic;
	           
	            #Aqui se mueve el archivo y se le coloca el nombre final
	            if (move_uploaded_file($valores['archivo'], $destino.$nombre_archivo))
	            {
	                #Ruta de la original
	                $rtOriginal = $destino.$nombre_archivo;
	               
	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho;
	                $max_alto = $alto;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_48.$nombre_archivo,$calidad);
	                
	                //>> SEGUNDA IMAGEN    	                

	                

	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho2;
	                $max_alto = $alto2;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_200 . $nombre_archivo,$calidad);
	               
	                $data['id_usuario'] 	= $valores['id_usuario'];
	                $data['codigo']     	= '000';
	                $data['mensaje']    	= 'Archivo subido exitosamente';
	                $data['img']    		= str_replace('../', '',$raiz_pic.$nombre_archivo);
	                $data['img_48']    		= str_replace('../', '',$raiz_48.$nombre_archivo);
	                $data['img_200']		= str_replace('../', '',$raiz_200.$nombre_archivo);
	                $data['avatar']			= $data['img_200']; //'http://mypack.me/'.$data['rutaimagen'];	
					           
	            }
	            else
	            {
	                $data['codigo'] = '003';
	                $data['mensaje']= 'Error al Subir el archivo';
	            }
	        }
	       
	        return $data;

	    }

	    function SubirLogoEmpresa($file,$datos)
	    {
		    $valores     = array();
	        $data        = array();	        
	        $alto2       = 200;
	        $ancho2      = 200;        	        
	        $raiz_200    = 'src/logo/200/';
	        $raiz_pic    = 'src/logo/pic/'; 

	        $calidad     = 90; #Definimos la calidad de la imagen final
	       
	        $valores['id_empresa'] = $datos['id_empresa'];  
	       
	        #verificamos que se selecciono una imagen
	        if(sizeof($file)==0)
	        {
	            $data['codigo']  = '001';
	            $data['mensaje'] = 'Es necesario seleccionar un archivo';               
	            return $data;
	        }

	        #nombre temporal del archivo a subir
	        $valores['archivo'] = $file['file1']["tmp_name"];
	       
	        #Definimos un array para almacenar el tamaño del archivo
	        $tamanio=array();
	       
	        #obtenemos el tamaño del archivo
	        $tamanio = $file['file1']["size"];
	       
	        #Obtenemos el mime o tipo de archivo
	        $valores['tipo'] = $file['file1']["type"];	        
	       
	        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf               
	        switch($valores['tipo'])
	        {
	            case 'image/jpeg': break;                                           
	            case 'image/png' : break;
	            case 'image/gif' : break;
	            default:               
	                $data['codigo'] = '002';
	                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
	                return $data;
	            break;
	        }
	       
	        #Obtenemos el nombre real del archivo                
	        $nombre_archivo = $valores['id_empresa'].'_'.time().'jpg';

	        //Verificamos de nuevo que se selecciono un archivo
	        if( $valores['archivo'] != "none" )
	        {   
	            #Valida que el directorio exista, si no lo crea y le asigna los permisos.   
	            if(!is_dir($raiz_pic))
	            {
	                //mkdir($raiz, 0777, true);
	                mkdir($raiz_pic,0777); 
	            }

	            #Crea la ruta de destino de la carpeta del folio
	            $destino = $raiz_pic;
	           
	            #Aqui se mueve el archivo y se le coloca el nombre final
	            if (move_uploaded_file($valores['archivo'], $destino.$nombre_archivo))
	            {
	                #Ruta de la original
	                $rtOriginal = $destino.$nombre_archivo;
	                
	                //>> SEGUNDA IMAGEN

	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho2;
	                $max_alto = $alto2;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_200 . $nombre_archivo,$calidad);
	               
	                $data['id_usuario'] 	= $valores['id_usuario'];
	                $data['codigo']     	= '000';
	                $data['mensaje']    	= 'Archivo subido exitosamente';
	                $data['img']    		= str_replace('../', '',$raiz_pic.$nombre_archivo);	                
	                $data['img_200']		= str_replace('../', '',$raiz_200.$nombre_archivo);
	                $data['logo']			= $data['img_200']; 
	            }
	            else
	            {
	                $data['codigo'] = '003';
	                $data['mensaje']= 'Error al Subir el archivo';
	            }
	        }
	       
	        return $data;

	    }

	    function SubirImagenProducto($file,$datos)
	    {
		    $valores     = array();
	        $data        = array();	        
	        $alto2       = 200;
	        $ancho2      = 200;        	        
	        $raiz_200    = 'src/productos/200/';
	        $raiz_pic    = 'src/productos/pic/'; 

	        $calidad     = 90; #Definimos la calidad de la imagen final
	       
	        //$valores['id_empresa'] = $datos['id_empresa'];  
	       
	        #verificamos que se selecciono una imagen
	        if(sizeof($file)==0)
	        {
	            $data['codigo']  = '001';
	            $data['mensaje'] = 'Es necesario seleccionar un archivo';               
	            return $data;
	        }

	        #nombre temporal del archivo a subir
	        $valores['archivo'] = $file['file1']["tmp_name"];
	       
	        #Definimos un array para almacenar el tamaño del archivo
	        $tamanio=array();
	       
	        #obtenemos el tamaño del archivo
	        $tamanio = $file['file1']["size"];
	       
	        #Obtenemos el mime o tipo de archivo
	        $valores['tipo'] = $file['file1']["type"];	        
	       
	        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf               
	        switch($valores['tipo'])
	        {
	            case 'image/jpeg': break;                                           
	            case 'image/png' : break;
	            case 'image/gif' : break;
	            default:               
	                $data['codigo'] = '002';
	                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
	                return $data;
	            break;
	        }
	       
	        #Obtenemos el nombre real del archivo                
	        $nombre_archivo = 'pro_'.time().'.jpg';

	        //Verificamos de nuevo que se selecciono un archivo
	        if( $valores['archivo'] != "none" )
	        {   
	            #Valida que el directorio exista, si no lo crea y le asigna los permisos.   
	            if(!is_dir($raiz_pic))
	            {
	                //mkdir($raiz, 0777, true);
	                mkdir($raiz_pic,0777); 
	            }

	            #Crea la ruta de destino de la carpeta del folio
	            $destino = $raiz_pic;
	           
	            #Aqui se mueve el archivo y se le coloca el nombre final
	            if (move_uploaded_file($valores['archivo'], $destino.$nombre_archivo))
	            {
	                #Ruta de la original
	                $rtOriginal = $destino.$nombre_archivo;
	                
	                //>> SEGUNDA IMAGEN

	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho2;
	                $max_alto = $alto2;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_200 . $nombre_archivo,$calidad);
	               
	                $data['id_usuario'] 	= $valores['id_usuario'];
	                $data['codigo']     	= '000';
	                $data['mensaje']    	= 'Archivo subido exitosamente';
	                $data['img']    		= str_replace('../', '',$raiz_pic.$nombre_archivo);	                
	                $data['img_200']		= str_replace('../', '',$raiz_200.$nombre_archivo);
	                $data['img_producto']	= $data['img_200']; 
	            }
	            else
	            {
	                $data['codigo'] = '003';
	                $data['mensaje']= 'Error al Subir el archivo';
	            }
	        }
	       
	        return $data;

	    }

	    function SubirImagenGaleria($file,$datos)
	    {
	    	$valores     = array();
	        $data        = array();	        
	        $alto2       = 200;
	        $ancho2      = 200;        	        
	        $raiz_200    = 'src/galerias/200/';
	        $raiz_pic    = 'src/galerias/pic/'; 

	        $calidad     = 90; #Definimos la calidad de la imagen final
	       
	        //$valores['id_empresa'] = $datos['id_empresa'];  
	       
	        #verificamos que se selecciono una imagen
	        if(sizeof($file)==0)
	        {
	            $data['codigo']  = '001';
	            $data['mensaje'] = 'Es necesario seleccionar un archivo';               
	            return $data;
	        }

	        #nombre temporal del archivo a subir
	        $valores['archivo'] = $file['file1']["tmp_name"];
	       
	        #Definimos un array para almacenar el tamaño del archivo
	        $tamanio=array();
	       
	        #obtenemos el tamaño del archivo
	        $tamanio = $file['file1']["size"];
	       
	        #Obtenemos el mime o tipo de archivo
	        $valores['tipo'] = $file['file1']["type"];	        
	       
	        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf               
	        switch($valores['tipo'])
	        {
	            case 'image/jpeg': break;                                           
	            case 'image/png' : break;
	            case 'image/gif' : break;
	            default:               
	                $data['codigo'] = '002';
	                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
	                return $data;
	            break;
	        }
	       
	        #Obtenemos el nombre real del archivo                
	        $nombre_archivo = 'ga_'.time().'.jpg';

	        //Verificamos de nuevo que se selecciono un archivo
	        if( $valores['archivo'] != "none" )
	        {   
	            #Valida que el directorio exista, si no lo crea y le asigna los permisos.   
	            if(!is_dir($raiz_pic))
	            {
	                //mkdir($raiz, 0777, true);
	                mkdir($raiz_pic,0777); 
	            }

	            #Crea la ruta de destino de la carpeta del folio
	            $destino = $raiz_pic;
	           
	            #Aqui se mueve el archivo y se le coloca el nombre final
	            if (move_uploaded_file($valores['archivo'], $destino.$nombre_archivo))
	            {
	                #Ruta de la original
	                $rtOriginal = $destino.$nombre_archivo;
	                
	                //>> SEGUNDA IMAGEN

	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho2;
	                $max_alto = $alto2;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_200 . $nombre_archivo,$calidad);
	               
	                $data['id_usuario'] 	= $valores['id_usuario'];
	                $data['codigo']     	= '000';
	                $data['mensaje']    	= 'Archivo subido exitosamente';
	                $data['img']    		= str_replace('../', '',$raiz_pic.$nombre_archivo);	                
	                $data['img_200']		= str_replace('../', '',$raiz_200.$nombre_archivo);
	                $data['img']			= $data['img_200']; 
	            }
	            else
	            {
	                $data['codigo'] = '003';
	                $data['mensaje']= 'Error al Subir el archivo';
	            }
	        }
	       
	        return $data;
	    }

		function SubirImagenPublicaciones($file,$datos)
	    {
	    	$valores     = array();
	        $data        = array();	        
	        $alto2       = 200;
	        $ancho2      = 200;        	        
	        $raiz_200    = 'src/post/200/';
	        $raiz_pic    = 'src/post/pic/'; 

	        $calidad     = 90; #Definimos la calidad de la imagen final
	       
	        //$valores['id_empresa'] = $datos['id_empresa'];  
	       
	        #verificamos que se selecciono una imagen
	        if(sizeof($file)==0)
	        {
	            $data['codigo']  = '001';
	            $data['mensaje'] = 'Es necesario seleccionar un archivo';               
	            return $data;
	        }

	        #nombre temporal del archivo a subir
	        $valores['archivo'] = $file['file1']["tmp_name"];
	       
	        #Definimos un array para almacenar el tamaño del archivo
	        $tamanio=array();
	       
	        #obtenemos el tamaño del archivo
	        $tamanio = $file['file1']["size"];
	       
	        #Obtenemos el mime o tipo de archivo
	        $valores['tipo'] = $file['file1']["type"];	        
	       
	        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf               
	        switch($valores['tipo'])
	        {
	            case 'image/jpeg': break;                                           
	            case 'image/png' : break;
	            case 'image/gif' : break;
	            default:               
	                $data['codigo'] = '002';
	                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
	                return $data;
	            break;
	        }
	       
	        #Obtenemos el nombre real del archivo                
	        $nombre_archivo = 'post_'.time().'.jpg';

	        //Verificamos de nuevo que se selecciono un archivo
	        if( $valores['archivo'] != "none" )
	        {   
	            #Valida que el directorio exista, si no lo crea y le asigna los permisos.   
	            if(!is_dir($raiz_pic))
	            {
	                //mkdir($raiz, 0777, true);
	                mkdir($raiz_pic,0777); 
	            }

	            #Crea la ruta de destino de la carpeta del folio
	            $destino = $raiz_pic;
	           
	            #Aqui se mueve el archivo y se le coloca el nombre final
	            if (move_uploaded_file($valores['archivo'], $destino.$nombre_archivo))
	            {
	                #Ruta de la original
	                $rtOriginal = $destino.$nombre_archivo;
	                
	                //>> SEGUNDA IMAGEN

	                #Dependiendo de la extensión llamamos a distintas funciones
	                switch ($valores['tipo'])
	                {
	                    case "image/jpeg": $original = imagecreatefromjpeg($rtOriginal);         break;
	                    case "image/png" : $original = imagecreatefrompng($rtOriginal);         break;
	                    case "image/gif" : $original = imagecreatefromgif($rtOriginal);         break;
	                }
	                    
	                //Definir tamaño máximo y mínimo
	                $max_ancho = $ancho2;
	                $max_alto = $alto2;
	                 
	                #Recoger ancho y alto de la original
	                list($ancho,$alto)=getimagesize($rtOriginal);
	                 
	                #/Calcular proporción ancho y alto
	                $x_ratio = $max_ancho / $ancho;
	                $y_ratio = $max_alto / $alto;


	                if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	                #Si es más pequeña que el máximo no redimensionamos
	                    $ancho_final = $ancho;
	                    $alto_final = $alto;
	                }
	                #si no calculamos si es más alta o más ancha y redimensionamos
	                elseif (($x_ratio * $alto) < $max_alto){
	                    $alto_final = ceil($x_ratio * $alto);
	                    $ancho_final = $max_ancho;
	                }
	                else{
	                    $ancho_final = ceil($y_ratio * $ancho);
	                    $alto_final = $max_alto;
	                }

	                #Crear lienzo en blanco con proporciones
	                $lienzo=imagecreatetruecolor($ancho_final,$alto_final);
	                 
	                #Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
	                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	                 
	                #Limpiar memoria
	                imagedestroy($original);

	                #Se crea la imagen final en el directorio indicado
	                imagejpeg($lienzo,$raiz_200 . $nombre_archivo,$calidad);
	               
	                $data['id_usuario'] 	= $valores['id_usuario'];
	                $data['codigo']     	= '000';
	                $data['mensaje']    	= 'Archivo subido exitosamente';
	                $data['img']    		= str_replace('../', '',$raiz_pic.$nombre_archivo);	                
	                $data['img_200']		= str_replace('../', '',$raiz_200.$nombre_archivo);
	                $data['img']			= $data['img_200']; 
	            }
	            else
	            {
	                $data['codigo'] = '003';
	                $data['mensaje']= 'Error al Subir el archivo';
	            }
	        }
	       
	        return $data;
	    }

	function hace($fecha)
	{
		$a = substr($fecha,0,4);
		$m = substr($fecha,5,2);
		$d = substr($fecha,8,2);
		$h = substr($fecha,11,2);
		$i = substr($fecha,14,2);
		$s = substr($fecha,17,2);

		$fecha2 	= mktime($h, $i, $s, $m, $d, $a);
		$diferencia = time() - $fecha2 ;

		$segundos 	= $diferencia ;
		$minutos 	= round($diferencia / 60 );
		$horas 		= round($diferencia / 3600 );
		$dias 		= round($diferencia / 86400 );
		$semanas 	= round($diferencia / 604800 );
		$mes 		= round($diferencia / 2419200 );
		$anio 		= round($diferencia / 29030400 );

		$respuesta = '';

		if($segundos <= 60)
		{
			$respuesta = "hace $segundos segundos";
		}
		else if($minutos <=60)
		{
			if($minutos==1)
			{
				$respuesta = "hace un minuto";
			}
			else
			{
				$respuesta = "hace $minutos minutos";
			}
		}
		else if($horas <=24)
		{
			if($horas==1)
			{
				$respuesta = "hace una hora";
			}
			else
			{
				$respuesta = "hace $horas horas";
			}
		}
		else if($dias <= 7)
		{
			if($dias==1)
			{
				$respuesta = "hace un dia";
			}
			else
			{
				$respuesta = "hace $dias dias";
			}
		}
		else if($semanas <= 4)
		{
			if($semanas==1)
			{
				$respuesta = "hace una semana";
			}
			else
			{
				$respuesta = "hace $semanas semanas";
			}
		}
		else if($mes <=12)
		{
			if($mes==1)
			{
				$respuesta = "hace un mes";
			}
			else
			{
				$respuesta = "hace $mes meses";
			}
		}
		else
		{
			if($anio==1)
			{
				$respuesta = "hace un a&ntilde;o";
			}
			else
			{
				$respuesta = "hace $anio a&ntilde;os";
			}
		}
		return $respuesta ;
	}// fin 

	function hace_mini($fecha)
	{
		$a = substr($fecha,0,4);
		$m = substr($fecha,5,2);
		$d = substr($fecha,8,2);
		$h = substr($fecha,11,2);
		$i = substr($fecha,14,2);
		$s = substr($fecha,17,2);

		$fecha2 	= mktime($h, $i, $s, $m, $d, $a);
		$diferencia = time() - $fecha2 ;

		$segundos 	= $diferencia ;
		$minutos 	= round($diferencia / 60 );
		$horas 		= round($diferencia / 3600 );
		$dias 		= round($diferencia / 86400 );
		$semanas 	= round($diferencia / 604800 );
		$mes 		= round($diferencia / 2419200 );
		$anio 		= round($diferencia / 29030400 );

		$respuesta = '';

		if($segundos <= 60)
		{
			$respuesta = "$segundos s";
		}
		else if($minutos <=60)
		{
			if($minutos==1)
			{
				$respuesta = "1 m";
			}
			else
			{
				$respuesta = "$minutos m";
			}
		}
		else if($horas <=24)
		{
			if($horas==1)
			{
				$respuesta = "una h";
			}
			else
			{
				$respuesta = "$horas hs";
			}
		}
		else if($dias <= 7)
		{
			if($dias==1)
			{
				$respuesta = "un d";
			}
			else
			{
				$respuesta = "$dias d";
			}
		}
		else if($semanas <= 4)
		{
			if($semanas==1)
			{
				$respuesta = "una sem";
			}
			else
			{
				$respuesta = " $semanas sem";
			}
		}
		else if($mes <=12)
		{
			if($mes==1)
			{
				$respuesta = "un mes";
			}
			else
			{
				$respuesta = "$mes meses";
			}
		}
		else
		{
			if($anio==1)
			{
				$respuesta = "un a&ntilde;o";
			}
			else
			{
				$respuesta = " $anio a&ntilde;os";
			}
		}
		return $respuesta ;
	}// fin 


	function enviarCorreo($datos)
	{
		$headers  = "From: " . strip_tags($datos['from']) . "\r\n";			
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$salida = mail($datos['to'], $datos['asunto'], $datos['mensaje'], $headers); 

		var_dump($salida); 
		die(); 

		if(mail($datos['to'], $datos['asunto'], $datos['mensaje'], $headers))
		{
			$data['codigo'] = '000'; 
			$data['mensaje']= 'Mensaje enviado'; 
		}
		else
		{
			$data['codigo'] = '001'; 
			$data['mensaje']= 'Ocurrio un error al enviar el correo'; 				
		}

		return $data; 

	}






	
}

?>