<?php
	class c_servicios extends servicio
	{
		function __construct($db)
		{
			parent::__construct($db);
		}


		
		/******************************************************************************
		*
		*   B L O Q U E            C L I E N T E S 
		*
		********************************************************************************/

		function ListadoClientes($datos)
		{
			$r = $this->listado_clientes(); 
			$r = $this->ConvertirResultMatriz($r); 			
			return $r;  
		}

		function ObtenerSiguienteClaveCliente(){
			$r = $this->obtener_siguiente_clave_cliente(); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  	
		}

		function BuscarCliente()
		{
			$r = $this->buscar_cliente(); 
			$r = $this->ConvertirResultMatriz($r); 			
			return $r;  
		}

		function RegistrarCliente($datos)
		{
			$datos = $this->clean_r($datos); 

			$r = $this->registrar_cliente($datos); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarCliente($datos)
		{
			$datos = $this->clean_r($datos); 

			$r = $this->actualizar_cliente($datos); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Actualizacion exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ObtenerClienteId($datos)
		{
			$datos = $this->clean_r($datos); 
			$r = $this->obtener_cliente_id($datos); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  	
		}	

		/******************************************************************************
		*
		*   B L O Q U E            ARTICULOS
		*
		********************************************************************************/

		function ListadoArticulos()
		{
			$r = $this->listado_articulos(); 
			$r = $this->ConvertirResultMatriz($r); 			
			return $r;  
		}		

		function BuscarArticulo()
		{
			$r = $this->buscar_articulos(); 
			$r = $this->ConvertirResultMatriz($r); 			
			return $r;  
		}

		function ObtenerSiguienteClaveArticulo()
		{
			$r = $this->obtener_siguiente_clave_articulo(); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  	
		}

		function RegistrarArticulo($datos)
		{
			$datos = $this->clean_r($datos); 

			$r = $this->registrar_articulo($datos); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarArticulo($datos)
		{
			$datos = $this->clean_r($datos); 

			$r = $this->actualizar_articulo($datos); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Actualizacion exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ObtenerArticuloId($datos)
		{
			$datos = $this->clean_r($datos); 
			$r = $this->obtener_articulo_id($datos); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  
		}	

		/******************************************************************************
		*
		*   B L O Q U E            C O N F I G U R A C I O N
		*
		********************************************************************************/
		function ObtenerConfiguracion()
		{
			$r = $this->obtener_configuracion(); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  	
		}

		function ActualizarConfiguracion($datos)
		{
			$datos = $this->clean_r($datos); 

			$r = $this->actualizar_configuracion($datos); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Actualizacion exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		/******************************************************************************
		*
		*   B L O Q U E            V E N T A S
		*
		********************************************************************************/

		function ListadoVentas()
		{
			$r = $this->listado_ventas(); 
			$r = $this->ConvertirResultMatriz($r); 
			return $r;  	
		}
		
		function ObtenerSiguienteClaveVenta()
		{
			$r = $this->obtener_siguiente_clave_ventas(); 
			$r = $this->ConvertirResultArray($r); 
			return $r;  	
		}

		function CalcularPrecioArticuloId($datos)
		{
			$datos = $this->clean_r($datos); 

			/* se obtiene articulo */
			$articulo = $this->obtener_articulo_id($datos); 
			$articulo = $this->ConvertirResultArray($articulo); 

			/* Se obtiene configuacion*/			
			$config = $this->obtener_configuracion(); 
			$config = $this->ConvertirResultArray($config); 

			$articulo['cantidad'] = '1';
			$articulo['precio_venta'] = $articulo['precio'] * (1 +($config['tasa_financiamiento'] * $config['plazo'])/100); 
			$articulo['importe'] = $articulo['precio_venta']; 

			return $articulo;  
		}


		function CalcularEnganche($datos)
		{
			$valores['importe'] = $datos['importe']; 

			/* Se obtiene configuacion*/			
			$config = $this->obtener_configuracion(); 
			$config = $this->ConvertirResultArray($config); 


			$resultado['importe'] 		= $valores['importe'];
			$resultado['enganche'] 		= ($config['enganche']/100) * $valores['importe'];
			$resultado['bonificacion'] 	= round($resultado['enganche'] * (($config['tasa_financiamiento'] * $config['plazo'])/100),2); 
			$resultado['total'] 		= round($valores['importe'] - $resultado['enganche'] - $resultado['bonificacion'],2);

			return $resultado; 
		} 

		function CalculoAbonoMeses($datos)
		{

			$valores['importe'] = $datos['importe']; 

			/* Se obtiene configuacion*/			
			$config = $this->obtener_configuracion(); 
			$config = $this->ConvertirResultArray($config); 

			$resultado = $this->CalcularEnganche($valores); 

			$resultado['precio_contado'] = round($resultado['importe'] / (1 + (($config['tasa_financiamiento'] * $config['plazo'])/100)),2);

			$abonos = array(); 

			for($i = 1;$i <= 4; $i++)
			{
				$num_meses = $i * 3; 

				$tmp['plazos'] 			= $num_meses;
				$tmp['descripcion']		= $num_meses.' ABONOS DE ';				
				$tmp['total_pagar'] 	= round($resultado['precio_contado'] * (1 + (($config['tasa_financiamiento'] * $num_meses )/100)),2);
				$tmp['total_pagar_des']	= 'TOTAL A PAGAR $'.number_format($tmp['total_pagar'],2);
				$tmp['cantidad_abono'] 	= round(($tmp['total_pagar'] / $num_meses),2);				
				$tmp['ahorro']  		= round(($resultado['importe'] - $tmp['total_pagar']),2); 

				$abonos[] = $tmp; 
			}

			return $abonos;
		}

		function RegistrarVenta($datos)
		{
			$datos = $this->clean_r($datos); 
			
			$valores['id_cliente'] 	= $datos['cliente']; 
			$valores['total'] 		= $datos['total']; 
			$valores['estatus'] 	= 'A'; 
			$valores['plazos'] 		= $datos['plazos']; 
			$valores['fecha'] 		= date('Y-m-d',time()); 


			$json	= str_replace('\"','"',$datos['articulos_json']);
			$json 	= json_decode($json, true);

			//print_r($json);

			$r = $this->registrar_venta($valores); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Actualizacion exitoso';

				for($i=0; $i <= count($json); $i++)
				{
					$t['id_articulo'] = $json[$i]['id_articulo']; 

					$r = $this->obtener_articulo_id($t); 
					$r = $this->ConvertirResultArray($r); 

					$tmp['id_articulo'] = $r['id_articulo']; 
					$tmp['existencia']    = $r['existencia'] - $json[$i]['cantidad']; 

					$this->actualizar_existencia_articulo($tmp); 
				}
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		

























		/* FUNCIONES PORTADA */
		function ObtenerEmpresasPortada($datos)
		{
			$r = $this->obtener_empresas_portada($datos);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function ObtenerEmpresasGeneral($datos)
		{
			$datos = $this->clean_r($datos);

			# se obtiene el numero de empresas
			$tmp = $this->count_obtener_empresas($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			if($datos['consulta'] != '')
			{
				$this->RegistrarBusqueda($datos);
			}

			$datos['limit'] = $paginador['limit'];

			$r = $this->obtener_empresas($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

		function ObtenerNumeroEmpresas()
		{
			$tmp = $this->count_obtener_empresas($datos);
			$tmp = $this->ConvertirResultArray($tmp);
			return $tmp['num_row'];

		}

		function ObtenerEmpresasFavoritas($datos)
		{
			$datos = $this->clean_r($datos);

			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];

			# se obtiene el numero de empresas
			$tmp = $this->count_obtener_empresas_favoritas($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			$datos['limit'] = $paginador['limit'];



			$r = $this->obtener_empresas_favoritas($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

		function InicioSession($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['correo']  	= $datos['correo'];
			$valores['password']	= md5($datos['password']);

			$r = $this->inicio_session_usuario($valores);
			$r = $this->ConvertirResultArray($r);



			if(count($r) > 0)
			{
				$modulos = $this->obtener_modulos_usuario($r);
				$modulos = $this->ConvertirResultMatriz($modulos);

				$_SESSION['s'] = array();
			    $_SESSION['s']['id_usuario']  		= $r['id_usuario'];
			    $_SESSION['s']['id_empresa']  		= $r['id_empresa'];
			    $_SESSION['s']['nombre']  			= $r['nombre'];
			    $_SESSION['s']['apellidos']  		= $r['apellidos'];
			    $_SESSION['s']['correo']  			= $r['correo'];

			    $_SESSION['s']['tema']   			= $r['tema'];
			    $_SESSION['s']['tipo_usuario']   	= $r['id_tipo_usuario'];
			    $_SESSION['s']['avatar']			= $r['avatar'];
			    $_SESSION['s']['id_last_n']			= $r['id_ult_not'] ;
			    $_SESSION['s']['registro_completo']	= $r['registro_completo'];
			    $_SESSION['s']['token_web']			= $this->generar_token_MJWT($r);
			    $_SESSION['s']['modulos']			= $modulos;
			    $_SESSION['s']['modulo_activo']		= '0';

			    if($_SESSION['s']['id_last_n'] == '')
			    {
			    	$_SESSION['s']['id_last_n'] = 0;
			    }

			    if($t['codigo'] == '000')
			    {
			    	$_SESSION['s']['token']	= $tmp['token_session'];
			    }

		        $data['mensaje'] = 'Ingreso exitoso!';
				$data['codigo']  = '000';
			}
			else
			{
				$data['mensaje'] = 'No se encontro el usuario!';
				$data['codigo']  = '001';
			}
			return $data;
		}

		function ActualizarConfiguracionInicial($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['id_usuario'] 		= $datos['id_usuario'];
			$valores['nombre'] 			= $datos['txt_nombre'];
			$valores['apellidos'] 		= $datos['txt_apellidos'];
			$valores['bio'] 			= $datos['txt_bio'];
			$valores['sexo'] 			= $datos['sexo'];
			$valores['avatar'] 			= $datos['txt_avatar'];
			$valores['registro_completo'] = '2';
			$valores['nombre_empresa'] 	= $datos['txt_nombre_empresa'];
			$valores['razon_social'] 	= $datos['txt_razon'];
			$valores['id_estado'] 		= $datos['txt_estado'];
			$valores['direccion'] 		= $datos['txt_direccion'];
			$valores['telefono'] 		= $datos['txt_telefono'];

			$r1  = $this->actualizar_configuracion_inicial_usuario($valores);

			$r2  = $this->actualizar_configuracion_inicial_empresa($valores);

			if($r1->affectedRows() > 0 & $r2->affectedRows() > 0)
			{
				$_SESSION['s']['avatar'] = $valores['avatar'];

				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;



		}

		function ObtenerDatosCompletosUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']  	= $datos['id_usuario'];

			$r = $this->obtener_datos_completos_usuario($valores);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}

		function RegistrarUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_tipo_usuario'] 	= '1';
			$valores['correo'] 				= $datos['txt_correo'];
			$valores['password']			= md5($datos['txt_new_pass']);
			$valores['nombre']				= '';
			$valores['apellidos']			= '';
			$valores['bio']					= '';
			$valores['avatar']				= 'img/avatar_pre/1.jpg';
			$valores['id_ult_not']			= 0;
			$valores['visitas_perfil']		= 0;
			$valores['tema']				= '9';
			$valores['sexo']				= 'H';
			$valores['fecha']				= date("Y-m-d",time());
			$valores['registro_completo'] 	= '1';
			$valores['notificacion_correo']	= 'S';
			$valores['status'] 				= 'A';

			$correo_valido = $this->validar_correo($valores);

			$correo_valido = $this->ConvertirResultArray($correo_valido);

			if(count($correo_valido) == 1)
			{
				$data['codigo'] 	= '002';
				$data['mensaje']	= 'El correo ya se encuestra registrado ';
				return $data;
			}

			$r = $this->registrar_usuario($valores);

			if($r->affectedRows() > 0)
			{
				/* Registro de empresa */

				$tmp['id_usuario']	= $r->insertID();
				$tmp['nombre'] 		= 'Empresa-Default';
				$tmp['latitud'] 	= '24.809065';
				$tmp['longitud'] 	= '-107.39401199999';

				$emp = $this->RegistrarEmpresa($tmp);
				$emp['fecha'] 		= date("Y-m-d",time());
				$emp['id_usuario']  = $tmp['id_usuario'];
				$emp['status'] 		= 'A';


				$rs  = $this->registrar_redes_sociales($emp);

				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarDetallesUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']			= $datos['id_usuario'];
			$valores['nombre']				= $datos['txt_nombre'];
			$valores['apellidos']			= $datos['txt_apellidos'];
			$valores['bio']					= $datos['txt_bio'];
			$valores['correo'] 				= $datos['txt_correo'];
			$valores['sexo']				= $datos['txt_sexo'];
			$valores['ubicacion']			= $datos['txt_ubicacion'];
			$valores['id_tipo_usuario']		= $datos['txt_tipo'];
			$valores['fecha']				= date("Y-m-d",time());


			$correo_valido = $this->validar_correo($valores);
			$correo_valido = $this->ConvertirResultArray($correo_valido);

			if(count($correo_valido) > 1)
			{
				$data['codigo'] 	= '002';
				$data['mensaje']	= 'El correo ya se encuestra registrado ';
				return $data;
			}

			$r = $this->actualizar_detalles_usuario($valores);

			if($r->affectedRows() > 0)
			{

				if($valores['id_tipo_usuario'] == '3')
				{

					
					
					$tmp = $this->obtener_empresa_usuario_id($valores); 
					$tmp = $this->ConvertirResultArray($tmp); 

					$valores['id_empresa'] 			= $tmp['id_empresa'];
					$valores['publicar_empresa'] 	= 'S'; 
					$valores['titulo_productos'] 	= 'Productos';
					$valores['mostrar_precio'] 		= 'S'; 
					$valores['mostrar_productos'] 	= 'S';
					$valores['mostrar_blog'] 		= 'S';
					$valores['mostrar_informacion']	= 'S';
					$valores['mostrar_ubicacion'] 	= 'S';
					$valores['mostrar_galeria'] 	= 'S';
					$valores['mostrar_contacto'] 	= 'S';
					$valores['fecha'] 				= date("Y-m-d",time());
					$valores['id_usuario'] 			= $_SESSION['s']['id_usuario'];

					$r = $this->actualizar_configuracion_empresa($valores);
				}

				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarNotificacionUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']			= $datos['id_usuario'];
			$valores['notificacion_correo']	= $datos['notificacion_correo'];
			$valores['fecha']				= date("Y-m-d",time());

			$r = $this->actualizar_notificacion_usuario($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarPasswordUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']	= $datos['id_usuario'];
			$valores['password']	= md5($datos['txtpasswordnuevo']);
			$valores['fecha']		= date("Y-m-d",time());

			$r = $this->actualizar_password_usuario($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarTemaUsuario($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']	= $datos['id_usuario'];
			$valores['tema']		= $datos['txttema'];
			$valores['fecha']		= date("Y-m-d",time());

			$r = $this->actualizar_tema_usuario($valores);

			if($r->affectedRows() > 0)
			{
				$_SESSION['s']['tema'] = $valores['tema'];
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '001';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}

		function ActualizarAvatarUsuario($datos,$file)
		{
			$datos = $this->clean_r($datos);

			$valores['id_usuario']	= $datos['id_usuario'];
			$valores['fecha']		= date("Y-m-d",time());

			$img = $this->SubirAvatarUsuario($file);

			$valores['avatar'] = $img['avatar'];

			$r = $this->actualizar_avatar_usuario($valores);

			$_SESSION['s']['avatar'] = $valores['avatar'];

			if($r->affectedRows() > 0)
			{
				$data['codigo'] 	= '000';
				$data['mensaje'] 	= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] 	= '000';
				$data['mensaje']	= 'Ocurrio un error al registrar';
			}

			return $data;
		}




		function RegistrarVisitaPerfil($datos)
		{
			if($datos['id_usuario'] != $_SESSION['s']['id_usuario'])
			{
				$r = $this->obtener_visitas_perfil($datos);
				$r = $this->ConvertirResultArray($r);

				$datos['visitas_perfil'] = $r['visitas_perfil'] + 1;

				$resultado = $this->actualizar_visitas_perfil_usuario($datos);
				if($resultado->affectedRows() > 0)
				{
					$data['codigo'] = '000';
					$data['mensaje']= 'Visita registrada con exito';
				}
				else
				{
					$data['codigo'] = '001';
					$data['mensaje']= 'Ocurrio un error al registra la visita';
				}
			}
			else
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'No es visita';
			}

			return $data;
		}


		function RegistrarEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_ciudad'] 			= 0;
			$valores['id_giro'] 			= 0;
			$valores['id_subgiro'] 			= 0;
			$valores['nombre_empresa'] 		= $datos['nombre_comercial'];
			$valores['razon_social'] 		= $datos['razon_social'];
			$valores['nombre_clave'] 		= '';
			$valores['descripcion'] 		= $datos['descripcion_act'];
			$valores['servicios'] 			= '';
			$valores['rfc'] 				= '';
			$valores['direccion'] 			= $datos['tipo_via'].' '.$datos['nombre_via'].' # '.$datos['numero_exterior'].','.$datos['nombre_asentamiento'];
			$valores['telefono'] 			= $datos['telefono'];
			$valores['correo'] 				= $datos['correo'];
			$valores['sitio_web'] 			= $datos['sitio_web'];
			$valores['visitas']				= $datos['visitas'] ;
			$valores['logo'] 				= 'src/logo/logo.png';
			$valores['num_personas']		= $datos['num_personas'];
			$valores['informacion'] 		= '';
			$valores['publicar_empresa']	= 'S';
			$valores['titulo_productos']	= 'Servicios';
			$valores['mostrar_precio'] 		= 'N';
			$valores['mostrar_productos'] 	= 'N';
			$valores['mostrar_blog'] 		= 'N';
			$valores['mostrar_informacion'] = 'S';
			$valores['mostrar_ubicacion'] 	= 'S';
			$valores['mostrar_galeria'] 	= 'N';
			$valores['mostrar_contacto'] 	= 'S';
			$valores['lat']			 		= $datos['latitud'];
			$valores['lng'] 				= $datos['longitud'];
			$valores['fecha'] 				= date("Y-m-d",time());
			$valores['id_usuario'] 			= $datos['id_usuario'];
			$valores['status']				= 'A';


			if($valores['visitas'] == '')
			{
				$valores['visitas'] = 0;
			}

			$r = $this->registrar_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['id_empresa'] = $r->insertID();
				$data['codigo'] = '000';
				$data['mensaje']= 'Registro de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al registrar una empresa';
			}

			return $data;

		}// fin de Registrar Empresa



		function ObtenerEmpresaCompleta($datos)
		{
			$datos = $this->clean_r($datos);

			$datos['id_empresa'] = $datos['id_empresa'];

			$r = $this->obtener_empresa_completa($datos);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}

		function ActualizarDetallesEmpresa($datos)
		{
			//$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['nombre_empresa'] 	= $datos['txt_nombre'];
			$valores['nombre_clave'] 	= $datos['txt_nombre'];
			$valores['id_estado'] 		= $datos['txt_estado'];
			$valores['id_ciudad'] 		= $datos['txt_ciudad'];
			$valores['id_giro']			= $datos['txt_giro'];
			$valores['descripcion'] 	= $datos['txt_descripcion'];
			$valores['servicios'] 		= $datos['txt_servicios'];
			$valores['rfc'] 			= $datos['txt_rfc'];
			$valores['direccion'] 		= $datos['txt_direccion'];
			$valores['telefono'] 		= $datos['txt_telefono'];
			$valores['correo'] 			= $datos['txt_correo'];
			$valores['sitio_web'] 		= $datos['txt_sitio_web'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			if($valores['id_ciudad'] == '')
			{
				$valores['id_ciudad']  = 0;
			}

			$r = $this->actualizar_detalles_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}

		function ActualizarConfiguracionEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 			= $datos['id_empresa'];
			$valores['publicar_empresa'] 	= $datos['rb_publicar'];
			$valores['titulo_productos'] 	= $datos['txt_titulo_productos'];
			$valores['mostrar_precio'] 		= $datos['rb_precio'];
			$valores['mostrar_productos'] 	= $datos['rb_mos_productos'];
			$valores['mostrar_blog'] 		= $datos['rb_mos_blog'];
			$valores['mostrar_informacion']	= $datos['rb_mos_informacion'];
			$valores['mostrar_ubicacion'] 	= $datos['rb_mos_ubicacion'];
			$valores['mostrar_galeria'] 	= $datos['rb_mos_galeria'];
			$valores['mostrar_contacto'] 	= $datos['rb_mos_contacto'];
			$valores['fecha'] 				= date("Y-m-d",time());
			$valores['id_usuario'] 			= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_configuracion_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}


		function ActualizarInformacionEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['informacion'] 	= $datos['txt_informacion'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			$r = $this->actulizar_informacion_vision($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}

		function ActualizarLogoEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 	= $datos['id_empresa'];
			$valores['logo'] 		= $datos['logo'];
			$valores['fecha'] 		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];

			$img = $this->SubirLogoEmpresa($files,$valores);

			if($img['codigo']!='000')
			{
				$data['codigo'] 	= $img['codigo'];
				$data['mensaje']	= $img['mensaje'];
				return $data;
			}

			$valores['logo'] 		= $img['logo'];

			$r = $this->actualizar_logo($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}

		function ActualizarGiroSubgiro($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 	= $datos['id_empresa'];
			$valores['id_giro'] 	= $datos['txt_giro'];
			$valores['id_subgiro'] 	= $datos['txt_subgiro'];
			$valores['fecha'] 		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_giro_subgiro($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}

		function ActualizarMapaEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 	= $datos['id_empresa'];
			$valores['lat']			= $datos['lat'];
			$valores['lng'] 		= $datos['lng'];

			$valores['fecha'] 		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_mapa_subgiro($valores);

			if($r->affectedRows() > 0)
			{

				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}


		function ActualizarMetodosPagosEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['metodos_pagos']	= $datos['txt_metodo'];

			$valores['fecha'] 		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_metodos_pagos_subgiro($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}


		function ActualizarConfigProductos($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['titulo_productos']= $datos['txt_titulo'];
			$valores['mostrar_precio'] 	= $datos['txt_mostrar'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_titulo_producto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de empresa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al actualizar';
			}

			return $data;
		}

		function RegistrarProductoEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['nombre_producto'] = $datos['txt_nombre'];
			$valores['descripcion'] 	= $datos['txt_descripcion'];
			$valores['id_categoria'] 	= $datos['txt_categoria'];
			$valores['marca'] 			= $datos['txt_marca'];
			$valores['modelo'] 			= $datos['txt_modelo'];
			$valores['precio'] 			= $datos['txt_precio'];
			$valores['precio_oferta'] 	= $datos['txt_precio_oferta'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];
			$valores['status'] 			= 'A';

			if(trim($files['file1']['tmp_name']) != '')
			{
				$img = $this->SubirImagenProducto($files, $valores);

				if($img['codigo'] != '000')
				{
					$data['codigo']  = $img['codigo'];
					$data['mensaje'] = $img['mensaje'];
					return $data;
				}

				$valores['img']	= $img['img_producto'];
			}
			else
			{
				$valores['img'] = 'img/producto-default.png';
			}





			$r = $this->registrar_producto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Registro de productos';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al registra producto';
			}

			return $data;
		}

		function ActualizarImagenProductoEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_producto'] = $datos['id_producto'];
			$valores['fecha'] 		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status'] 		= 'A';

			$img = $this->SubirImagenProducto($files,$valores);

			if($img['codigo'] != '000')
			{
				$data['codigo']  = $img['codigo'];
				$data['mensaje'] = $img['mensaje'];
				return $data;
			}

			$valores['img'] = $img['img_producto'];

			$r = $this->actualizar_imagen_producto_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Registro de productos';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al registra producto';
			}

			return $data;
		}

		function obtenerProductosEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] = $datos['id_empresa'];

			$r = $this->obtener_productos_empresa($valores);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function obtenerProductoID($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_producto'] = $datos['id_producto'];

			$r = $this->obtener_producto_ID($valores);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}

		function ActualizarProductoEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_producto'] 	= $datos['txt_id'];
			$valores['nombre_producto'] = $datos['txt_nombre'];
			$valores['descripcion'] 	= $datos['txt_descripcion'];
			$valores['id_categoria'] 	= $datos['txt_categoria'];
			$valores['marca'] 			= $datos['txt_marca'];
			$valores['modelo'] 			= $datos['txt_modelo'];
			$valores['precio'] 			= $datos['txt_precio'];
			$valores['precio_oferta'] 	= $datos['txt_precio_oferta'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			$r = $this->actualizar_producto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizar de productos';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al registra producto';
			}

			return $data;
		}

		/*function ActualizarImagenProductoEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_producto'] 	= $datos['txt_id'];
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			$img = $this->SubirImagenProducto($files);

			if($img['codigo'] != '')
			{
				$data['codigo']  = $img['codigo'];
				$data['mensaje'] = $img['mensaje'];
				return $data;
			}

			$valores['img_producto'] = $img['img_producto'];

			$r = $this->actualizar_imagen_producto_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizar de productos';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al registra producto';
			}

			return $data;
		}*/


		function EliminarProductoEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_producto'] 	= $datos['id_producto'];
			$valores['id_empresa']		= $datos['id_empresa'];
			$valores['status']			= 'C';
			$valores['fecha'] 			= date("Y-m-d",time());
			$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];

			$r = $this->eliminar_producto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Eliminaacion de productos';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error al eliminar producto';
			}

			return $data;
		}

		function RegistrarImagenGaleriaEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa'] 	= $datos['id_empresa'];
			$valores['descripcion']	= $datos['txt_descripcion'];
			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status']		= 'A';

			$img = $this->SubirImagenGaleria($files,$datos);

			if($img['codigo'] != '000')
			{
				$data['codigo']  = $img['codigo'];
				$data['mensaje'] = $img['mensaje'];
				return $data;
			}

			$valores['img'] = $img['img'];

			$r = $this->registrar_imagen_galeria_empresa($valores);


			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Registrar imagen exitoso';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ActualizarImagenGaleriaEmpresa($datos,$files)
		{
			$datos = $this->clean_r($datos);

			$valores['id_galeria'] 	= $datos['txt_id'];
			$valores['descripcion']	= $datos['txt_descripcion'];
			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status']		= 'A';

			/* si se capturo una nueva imagen se registran y se actualiza la imagen*/
			if($files['file1']['tmp_name'] != '')
			{
				$img = $this->SubirImagenGaleria($files,$datos);

				if($img['codigo'] != '000')
				{
					$data['codigo']  = $img['codigo'];
					$data['mensaje'] = $img['mensaje'];
					return $data;
				}

				$valores['img'] 	= $img['img'];
				$valores['opcion']  = '2';
			}
			else
			{
				$valores['opcion']  = '1';
			}

			$r = $this->actualizar_imagen_galeria_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion de imagen exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function EliminarImagenGaleriaEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_galeria'] 	= $datos['id_galeria'];
			$valores['id_empresa']	= $datos['id_empresa'];

			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status']		= 'C';

			$r = $this->eliminar_imagen_galeria_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Eliminacion de imagen exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ObtenerGaleriaEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_galeria_empresa($datos);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function ObtenerImagenGaleriaEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_imagen_galeria_empresa($datos);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}


		function ObtenerEstados()
		{
			$r = $this->obtener_estados();
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function ObtenerCiudades($datos)
		{
			$datos = $this->clean_r($datos);
			$valores['id_estado'] = $datos['id_estado'];

			$r = $this->obtener_ciudades($valores);
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function ObtenerCategoriasProductos()
		{
			$r = $this->obtener_categorias_productos($valores);
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function ObtenerGiros()
		{
			$r = $this->obtener_giros();
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function RegistrarGiro($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['nombre_giro'] = $datos['txt_nombre'];			

			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status']		= 'A';

			$r = $this->registrar_giro($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';				
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function count_mensajes_nuevos()
		{
			$datos = $this->clean_r($datos);

			$datos['id_empresa'] = $_SESSION['s']['id_empresa'];			

			$r = $this->obtener_mensajes_nuevos_empresa($datos);
			$r = $this->ConvertirResultArray($r);
			if($r['num_mensajes'] == '0')
			{
				$r['num_mensajes'] = '';
			}
			$data = $r['num_mensajes'];			

			return $data;
		}
		function ActualizarGiro($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_giro']		= $datos['txt_id'];
			$valores['nombre_giro'] = $datos['txt_nombre'];			
			$valores['status']		= $datos['txt_status'];

			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];			

			$r = $this->actualizar_giro($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';				
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ObtenerGiro($datos)
		{			
			$r = $this->obtener_giro($datos);
			$r = $this->ConvertirResultArray($r);
			return $r;
		} 


		function ObtenerSubgiros($datos)
		{
			$datos = $this->clean_r($datos);
			$valores['id_giro'] = $datos['id_giro'];

			$r = $this->obtener_subgiros($valores);
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function ObtenerRedesSociales($datos)
		{
			$datos = $this->clean_r($datos);
			$valores['id_empresa'] = $datos['id_empresa'];

			$r = $this->obtener_redes_sociales($valores);
			$r = $this->ConvertirResultArray($r);
			return $r;
		}

		function ActualizarRedesSociales($datos)
		{
			$datos = $this->clean_r($datos);

			$valores['id_empresa']	= $datos['id_empresa'];


			$valores['facebook']		= $datos['txt_facebook'];
			$valores['twitter'] 		= $datos['txt_twitter'];
			$valores['linkedin'] 		= $datos['txt_linkedin'];
			$valores['youtube'] 		= $datos['txt_youtube'];
			$valores['google_plus'] 	= $datos['txt_google_plus'];
			$valores['pinterest'] 	= $datos['txt_pinterest'];
			$valores['skype'] 		= $datos['txt_skype'];
			$valores['blogger'] 		= $datos['txt_blogger'];

			$valores['fecha']		= date("Y-m-d",time());
			$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];
			$valores['status']		= 'C';

			$r = $this->actualizar_redes_sociales($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Eliminacion de imagen exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ObtenerMensajesEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_mensajes_empresa($datos);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function ObtenerMensajesNuevosEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_mensajes_nuevos_empresa($datos);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function ObtenerDetallesMensajeID($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_detalles_mensaje_ID($datos);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}

		function MarcarVistoMensaje($datos)
		{
			$datos = $this->clean_r($datos);

			$datos['status'] = 'A';

			$r = $this->marcar_visto_mensaje($datos);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Exito';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function RegistrarMensajeEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$session = $this->validar_token_MJWT($datos['token']);

			$valores['id_empresa'] 	= $datos['empresa'];
			$valores['nombre']		= $datos['nombre'];
			$valores['correo']		= $datos['correo'];
			$valores['mensaje']		= $datos['mensaje'];
			$valores['id_usuario']	= $session['id_usuario'];
			$valores['fecha_envio'] = date("Y-m-d H:i:s",time());
			$valores['ip']			= $_SERVER['REMOTE_ADDR'];
			$valores['status'] 		= 'E';

			$r = $this->registrar_mensaje_empresa($valores);			

			if($r->affectedRows() > 0)
			{
				# Notificacion por correo a la empresa. 
				$r2 = $this->GenerarCorreoContactoEmpresa($valores);
				$data['codigo'] = '000';
				$data['mensaje']= 'Exito';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function GenerarCorreoContactoEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$c = $this->obtener_correo_usuario_empresa($datos); 
			$c = $this->ConvertirResultArray($c);

			if($c['notificacion_correo']=='N') 
			{
				return; 
			}

			$valores['mensaje'] 	= 'Acabas de recibir un mensaje desde pymeanunciate. <br><br> <b>'.$datos['mensaje'].'</b>'; 

			$valores['asunto']		= 'Nuevo mensaje desde Pymeanunciate';
			$valores['to']	   		= $c['correo'];
			$valores['from']		= 'contacto@pymeanunciate.com';
			$valores['id_plantilla']= '1';
        	$valores['fecha_c']  	= date("Y-m-d H:i:s",time());
			$valores['fecha_e']  	= '0000-00-00 00:00:00';
			$valores['status'] 		= 'P';

			$r 	= $this->registrar_correo_pendiente($valores); 

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Exito';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function EliminarMensajeEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$datos['status'] 		= 'C';
			$r = $this->eliminar_mensaje_empresa($datos);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Exito';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function RegistrarVisitaEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_visitas_empresa($datos);
			$r = $this->ConvertirResultArray($r);

			$datos['visitas'] = $r['visitas'] + 1 ;

			$resultado = $this->actualizar_visitas_empresa($datos);

			if($resultado->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Exito';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ObtenerPublicacionesEmpresa($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->listado_publicaciones_empresa($datos);
			$r = $this->ConvertirResultMatriz($r);

			return $r;
		}

		function ObtenerPublicacionID($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obtener_publicacion_ID($datos);
			$r = $this->ConvertirResultArray($r);

			return $r;
		}


		function RegistrarPublicacionEmpresa($datos,$files)
		{
			//$datos = $this->clean_r($datos);

			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['titulo'] 			= $datos['txt_titulo'];
			$valores['descripcion'] 	= $datos['txt_descripcion'];
			$valores['img'] 			= '';
			$valores['fecha_c']  		= date("Y-m-d H:i:s",time());
			$valores['fecha_m'] 		= date("Y-m-d H:i:s",time());
			$valores['fecha_p'] 		= date("Y-m-d H:i:s",time());
			$valores['num_likes'] 		= 0;
			$valores['num_comentarios'] = 0;
			$valores['num_visitas'] 	= 0;
			$valores['id_usuario']		= $_SESSION['s']['id_usuario'];
			$valores['status'] 			= $datos['txt_status'];

			if($files['file1']['tmp_name'] != '')
			{
				$img = $this->SubirImagenPublicaciones($files,$datos);

				if($img['codigo'] != '000')
				{
					$data['codigo']  = $img['codigo'];
					$data['mensaje'] = $img['mensaje'];
					return $data;
				}

				$valores['img'] 	= $img['img'];
			}

			$r = $this->registrar_publicacion($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ActualizarPublicacionEmpresa($datos)
		{
			//$datos = $this->clean_r($datos);
			$valores['id_publicacion']  = $datos['txt_id'];
			$valores['id_empresa'] 		= $datos['id_empresa'];
			$valores['titulo'] 			= $datos['txt_titulo'];
			$valores['descripcion'] 	= $datos['txt_descripcion'];
			$valores['fecha_m'] 		= date("Y-m-d H:i:s",time());
			$valores['fecha_p'] 		= date("Y-m-d H:i:s",time());
			$valores['id_usuario']		= $_SESSION['s']['id_usuario'];
			$valores['status'] 			= $datos['txt_status'];

			$r = $this->actualizar_publicacion($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitoso';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ActualizarImagenPublicacionEmpresa($datos,$files)
		{
			$valores['id_publicacion']  = $datos['txt_id'];
			$valores['id_empresa']		= $datos['id_empresa'];
			$valores['img'] 			= '';
			$valores['fecha_m'] 		= date("Y-m-d H:i:s",time());
			$valores['fecha_p'] 		= date("Y-m-d H:i:s",time());
			$valores['id_usuario']		= $_SESSION['s']['id_usuario'];

			if($files['file1']['tmp_name'] != '')
			{
				$img = $this->SubirImagenPublicaciones($files,$datos);

				if($img['codigo'] != '000')
				{
					$data['codigo']  = $img['codigo'];
					$data['mensaje'] = $img['mensaje'];
					return $data;
				}

				$valores['img'] 	= $img['img'];
			}

			$r = $this->actualizar_imagen_publicacion($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function EliminarPublicacionEmpresa($datos)
		{
			$valores['id_publicacion']  = $datos['id_publicacion'];
			$valores['id_empresa']		= $datos['id_empresa'];
			$valores['fecha_m'] 		= date("Y-m-d H:i:s",time());
			$valores['id_usuario']		= $_SESSION['s']['id_usuario'];
			$valores['status']			= 'C';

			$r = $this->eliminar_publicacion_empresa($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ObtenerPublicacionesPortada()
		{
			$r = $this->listado_publicaciones_portada();
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function RegistrarVisitaPublicacion($datos)
		{
			$datos = $this->clean_r($datos);

			$post  = $this->obtener_publicacion_ID($datos);
			$post  = $this->ConvertirResultArray($post);

			$datos['num_visitas'] = $post['num_visitas'] + 1 ;

			$r = $this->actualizar_visitas_publicacion($datos);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ActualizarLikePublicacion($datos)
		{
			$datos = $this->clean_r($datos);

			$post  = $this->obtener_publicacion_ID($datos);
			$post  = $this->ConvertirResultArray($post);

			if($datos['opcion'] == 'R')
			{
				$datos['num_likes'] = $post['num_likes'] + 1 ;
			}
			else
			{
				$datos['num_likes'] = $post['num_likes'] - 1 ;
			}

			$r = $this->actualizar_like_publicacion($datos);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}


		function ActualizarComentariosPublicacion($datos)
		{
			$datos = $this->clean_r($datos);

			$post  = $this->obtener_publicacion_ID($datos);
			$post  = $this->ConvertirResultArray($post);

			if($datos['opcion'] == 'R')
			{
				$datos['num_comentarios'] = $post['num_comentarios'] + 1 ;
			}
			else
			{
				$datos['num_comentarios'] = $post['num_comentarios'] - 1 ;
			}

			$r = $this->actualizar_comentarios_publicacion($datos);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function AgregarEmpresaFavoritos($datos)
		{
			$datos = $this->clean_r($datos);

			$session = $this->validar_token_MJWT($datos['token']);

			$valores['id_empresa']	= $datos['id_empresa'];
			$valores['fav'] 		= $datos['fav'];
			$valores['fecha'] 		= date("Y-m-d H:i:s",time());
			$valores['id_usuario']	= $session['id_usuario'];
			$valores['status']		= 'A';

			if($valores['fav'] == 'N')
			{
				$r = $this->registrar_empresa_favorita($valores);
			}
			else
			{
				$r = $this->eliminar_empresa_favorita($valores);
			}

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ListadoContactos($datos)
		{
			$datos = $this->clean_r($datos);

			$datos['consulta'] 	= $datos['consulta'];
			$datos['letra'] 	= $datos['letra'];

			$session = $this->validar_token_MJWT($datos['token']);

			$datos['id_usuario'] = $session['id_usuario'];

			# se obtiene el numero de empresas
			$tmp = $this->count_listado_contactos($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			$datos['limit'] = $paginador['limit'];

			$r = $this->listado_contactos($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

		function ObtenerTiposContactos()
		{
			$r = $this->obtener_tipos_contactos();
			$r = $this->ConvertirResultMatriz($r);
			return $r;
		}

		function ObtenerContactoID($datos)
		{
			$datos = $this->clean_r($datos);

			$r = $this->obterner_contacto_ID($datos);
			$r = $this->ConvertirResultArray($r);
			return $r;
		}

		function RegistrarContacto($datos)
		{
			$datos = $this->clean_r($datos);

			$session = $this->validar_token_MJWT($datos['token']);

			$valores['id_tipo_contacto'] 	= $datos['tipo'];
			$valores['nombre_completo'] 	= $datos['nombre'];
			$valores['empresa'] 			= $datos['empresa'];
			$valores['celular'] 			= $datos['celular'];
			$valores['correo'] 				= $datos['correo'];
			$valores['domicilio'] 			= $datos['domicilio'];
			$valores['detalles'] 			= $datos['detalles'];
			$valores['fecha'] 				= date("Y-m-d H:i:s",time());
			$valores['id_usuario']			= $session['id_usuario'];
			$valores['id_usuario_raiz']		= $session['id_usuario'];
			$valores['id_padre'] 			= $session['id_usuario'];
			$valores['status']				= 'A';
			$valores['avatar'] 				= 'img/user2.png';
			$valores['sexo'] 					= '';

			$r = $this->registrar_contacto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Registro exitoso';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ActualizarContacto($datos)
		{
			$datos = $this->clean_r($datos);

			$session = $this->validar_token_MJWT($datos['token']);

			$valores['id_contacto']			= $datos['id'];
			$valores['id_tipo_contacto'] 	= $datos['tipo'];
			$valores['nombre_completo'] 	= $datos['nombre'];
			$valores['empresa'] 			= $datos['empresa'];
			$valores['celular'] 			= $datos['celular'];
			$valores['correo'] 				= $datos['correo'];
			$valores['domicilio'] 			= $datos['domicilio'];
			$valores['detalles'] 			= $datos['detalles'];
			$valores['fecha'] 				= date("Y-m-d H:i:s",time());
			$valores['id_usuario']			= $session['id_usuario'];
			$valores['id_usuario_raiz']		= $session['id_usuario'];
			$valores['id_padre'] 			= $session['id_usuario'];
			$valores['status']				= 'A';
			$valores['avatar'] 				= 'img/user2.png';

			$r = $this->actualizar_contacto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}


		function EliminarContacto($datos)
		{
			$datos = $this->clean_r($datos);

			$session = $this->validar_token_MJWT($datos['token']);

			$valores['id_contacto']			= $datos['id'];
			$valores['fecha'] 				= date("Y-m-d H:i:s",time());
			$valores['id_usuario']			= $session['id_usuario'];
			$valores['status']				= 'C';

			$r = $this->eliminar_contacto($valores);

			if($r->affectedRows() > 0)
			{
				$data['codigo'] = '000';
				$data['mensaje']= 'Actualizacion exitosa';
			}
			else
			{
				$data['codigo'] = '001';
				$data['mensaje']= 'Ocurrio un error ';
			}

			return $data;
		}

		function ListadoUsuariosAdmin($datos)
		{
			$datos = $this->clean_r($datos);

			# se obtiene el numero de empresas
			$tmp = $this->count_listado_usuarios_admin($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			$datos['limit'] = $paginador['limit'];

			$r = $this->listado_usuarios_admin($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

		function ObtenerEmpresasAdmin($datos)
		{
			$datos = $this->clean_r($datos);

			# se obtiene el numero de empresas
			$tmp = $this->count_obtener_empresas_admin($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			$datos['limit'] = $paginador['limit'];

			$r = $this->obtener_empresas_admin($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

		function ObtenerEstadisticas()
		{
			$r = $this->obtener_estadisticas();
			$r = $this->ConvertirResultArray($r);
			return $r;
		}

		function ObtenerEmpresasMexicoAdmin($datos)
		{
			$datos = $this->clean_r($datos);

			# se obtiene el numero de empresas
			$tmp = $this->count_obtener_empresas_mexico_admin($datos);
			$tmp = $this->ConvertirResultArray($tmp);

			# se calculan el numero de paginas
			$datos['num_row'] = $tmp['num_row'];
			$paginador = $this->crear_paginas($datos);

			//$datos['limit'] = $paginador['limit'];

			$r = $this->obtener_empresas_mexico_admin($datos);
			$r = $this->ConvertirResultMatriz($r);

			$metadata['datos'] 		= $r;
			$metadata['paginador'] 	= $paginador;

			return $metadata;
		}

	function ObtenerEmpresaInegiCompleta($datos)
	{
		$datos = $this->clean_r($datos);

		$r = $this->obtener_empresas_inegi_completa($datos);
		$r = $this->ConvertirResultArray($r);

		return $r;
	}

	function ActualizarDetallesEmpresaInegi($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['id_empresa'] 			= $datos['id_empresa'];
	    $valores['nombre_comercial'] 	= $datos['txt_nombre_comercial'];
	    $valores['razon_social'] 		= $datos['txt_razon_social'];
	    $valores['descripcion_act'] 	= $datos['txt_actividad'];
	    $valores['num_personas'] 		= $datos['txt_num_personas'];
	    $valores['tipo_via'] 			= $datos['txt_tipo_via'];
	    $valores['nombre_via'] 			= $datos['txt_nombre_via'];
	    $valores['numero_exterior'] 	= $datos['txt_numero'];
	    $valores['tipo_asentamiento'] 	= $datos['txt_tipo_asentamiento'];
	    $valores['nombre_asentamiento'] = $datos['txt_nombre_asentamiento'];
	    $valores['codigo_postal'] 		= $datos['txt_codigo_postal'];
	    $valores['nombre_entidad'] 		= $datos['txt_estado'];
	    $valores['municipio'] 			= $datos['txt_munucipio'];
	    $valores['localidad'] 			= $datos['txt_localidad'];
	    $valores['correo'] 				= $datos['txt_correo'];
	    $valores['sitio_web'] 			= $datos['txt_sitio_web'];
	    $valores['latitud'] 			= $datos['txt_latitud'];
	    $valores['longitud'] 			= $datos['txt_longitud'];
	    $valores['tipo_establecimiento']= $datos['txt_tipo_establecimiento'];
	    $valores['telefono'] 			= $datos['txt_telefono'];
	    $valores['status'] 				= $datos['txt_status'];

		$r = $this->actualizar_detalles_empresa_inegi($valores);

		if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Actualizacion exitosa';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error ';
		}

		return $data;
	}

	function CrearEmpresaCompletaInegi($datos)
	{

		$datos = $this->clean_r($datos);

		$empresa = $this->ObtenerEmpresaInegiCompleta($datos);


		$valores['id_tipo_usuario'] 	= '1';
		$valores['correo'] 				= $empresa['correo'];
		$valores['password']			= md5('pymeanunciate_inegi');
		$valores['nombre']				= $empresas['nombre_comercial'];
		$valores['apellidos']			= '';
		$valores['bio']					= '';
		$valores['avatar']				= 'img/avatar-default.jpg';
		$valores['id_ult_not']			= 0;
		$valores['visitas_perfil']		= 0;
		$valores['tema']				= '9';
		$valores['sexo']				= 'H';
		$valores['fecha']				= date("Y-m-d",time());
		$valores['registro_completo'] 	= '1';
		$valores['notificacion_correo']	= 'S';
		$valores['status'] 				= 'A';

		$correo_valido = $this->validar_correo($valores);

		$correo_valido = $this->ConvertirResultArray($correo_valido);

		if(count($correo_valido) == 1 || $valores['correo']== '')
		{
			$data['codigo'] 	= '002';
			$data['mensaje']	= 'El correo ya se encuestra registrado o esta vacio';
			return $data;
		}

		$r = $this->registrar_usuario($valores);

		if($r->affectedRows() > 0)
		{
			/* Registro de empresa */

			$empresa['id_usuario']	= $r->insertID();
			$empresa['nombre'] 		= $empresas['nombre_comercial'];


			$empresa['visitas'] 	= 0;

			$emp = $this->RegistrarEmpresa($empresa);

			$emp['fecha'] 		= date("Y-m-d",time());
			$emp['id_usuario']  = $empresa['id_usuario'];
			$emp['status'] 		= 'A';

			$rs  = $this->registrar_redes_sociales($emp);

			$data['codigo'] 	= '000';
			$data['mensaje'] 	= 'Registro exitoso';
		}
		else
		{
			$data['codigo'] 	= '001';
			$data['mensaje']	= 'Ocurrio un error al registrar';
		}

		return $data;

	}



	/*
	function ObtenerEmpresasMexicoCorreo($datos)
	{
		$datos = $this->clean_r($datos);

		$r = $this->obtener_empresas_mexico_correo($datos);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function ActualizarCorreoEnviadoEmpresaMexico($datos)
	{
		$datos['envio_correo'] = 'S';

		$r = $this->actualizar_correo_enviado_empresa_mexico($datos);

		if($r->affectedRows() > 0 )
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Exito';
		}
		else
		{
			$data['codigo']  = '001';
			$data['mensaje'] = 'Error';
		}

		return $data;
	}

	function ActualizarSuscripcionEmpresaMexico($datos)
	{
		$r = $this->actualizar_suscripcion_empresa_mexico($datos);

		if($r->affectedRows() > 0 )
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Exito';
		}
		else
		{
			$data['codigo']  = '001';
			$data['mensaje'] = 'Error';
		}

		return $data;
	}*/

	function ObtenerEstadisticasEmpresasMexico()
	{
		$r = $this->obtener_estadisticas_empresas_mexico();
		$r = $this->ConvertirResultArray($r);
		return $r;
	}

	function registrarVisita($datos)
	{
		$datos['page'] = " http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$datos = $this->clean_r($datos);
		if($datos['seccion']=='')
		{
			$datos['seccion'] = 'index';
		}
		if($datos['src']=='')
		{
			$datos['src'] = 'Pagina Principal';
		}

		if($datos['id_usuario'] == '')
		{
			$datos['id_usuario'] = 0;
		}

		$r = $this->registrar_visita($datos);

		if($r->affectedRows() > 0)
	    {
	        $data['codigo'] = '000' ;
	        $data['mensaje'] ='exito';
	    }
	    else
	    {
	        $data['codigo'] = '001' ;
	        $data['mensaje'] ='Error';
	    }

	    return $data;
	}


	function RegistrarBusqueda($datos)
	{

		$datos = $this->clean_r($datos);

		$valores['busqueda']	= $datos['consulta'];
		$valores['ip']			= $_SERVER['REMOTE_ADDR'];
		$valores['fecha'] 		= date("Y-m-d H:i:s",time());
		$valores['nav'] 		= $_SERVER['HTTP_USER_AGENT'];
		$valores['id_usuario'] 	= $_SESSION['s']['id_usuario'];

		if($valores['id_usuario'] == '')
		{
			$valores['id_usuario'] = 0;
		}

		$r = $this->registrar_busqueda($valores);

		if($r->affectedRows() > 0)
	    {
	        $data['codigo'] = '000' ;
	        $data['mensaje'] ='exito';
	    }
	    else
	    {
	        $data['codigo'] = '001' ;
	        $data['mensaje'] ='Error';
	    }

	    return $data;
	}


	/**********************************************************************************
	*
	*
	*
	*                  M O D U L O      D E       I  N B O X
	*
	*
	*
	***********************************************************************************/



	function listadoUsuariosInbox($datos)
	{
		$valores['id_consultorio'] 	= $datos['id_consultorio'];
		$valores['id_usuario']		= $datos['id_usuario'];

		if($_SESSION['s']['id_tipo_usuario'] == '2')
		{
			$r = $this->listado_usuarios_admin($valores);
		}
		else
		{
			$r = $this->listado_usuarios_inbox($valores);
		}


		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function registrarInbox($datos,$files)
	{
		$datos = $this->clean_r($datos);

		$valores['id_usuario_e'] 	= $datos['id_usuario'];
		$valores['id_usuario_r']	= $datos['usuario_destino'];
		$valores['mensaje'] 		= utf8_decode($datos['mensaje']);
		$valores['src'] 			= '';
		$valores['tamanio'] 		= '';
		$valores['tipo_archivo'] 	= '';
		$valores['fecha_envio'] 	= date("Y-m-d H:i:s",time());
		$valores['fecha_visto'] 	= '0000-00-00 00:00:00';
		$valores['fecha_mod'] 		= date("Y-m-d H:i:s",time());
		$valores['status_m'] 		= 'E';
		$valores['status'] 			= 'A';

		if( $files['file3']["name"] != '')
		{
			$img = $this->registrarImagenGeneralMensajeInboxAjax($files);

			if($img['codigo'] == '000')
			{
				$valores['src']			= $img['src'];
				$valores['src_mini']	= $img['src_mini'];
				$valores['tipo_archivo']= $img['tipo_archivo'];
				$valores['tamanio']		= $img['tamanio'];
			}
			else
			{
				$data['codigo'] = $img['codigo'];
				$data['mensaje']= $img['mensaje'];
				return $data;
			}
		}


		$r = $this->registrar_inbox($valores);

		if($r->affectedRows() > 0 )
		{
			$data['codigo']  	= '000';
			$data['mensaje'] 	= 'Registro de Inbox exitosamente';
			$data['src'] 		= $valores['src'];
			$data['src_mini']	= $valores['src_mini'];
		}
		else
		{
			$data['codigo']  = '001';
			$data['mensaje'] = 'Error al Registrar';
		}

		return $data;
	}

	function eliminarInbox($datos)
	{
		$valores['id_inbox'] 		= $datos['id_inbox'];
		$valores['fecha_mod'] 		= date("Y-m-d H:i:s",time());
		$valores['status'] 			= 'B';

		$r = $this->eliminar_inbox($valores);

		if($r->affectedRows() > 0 )
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Inbox borrado exitosamente';
		}
		else
		{
			$data['codigo']  = '001';
			$data['mensaje'] = 'Error al eliminar';
		}

		return $data;
	}

	function marcarVistoInbox($datos)
	{
		$valores['id_inbox'] 		= $datos['id_inbox'];
		$valores['id_usuario_e']	= $datos['id_usuario'];
		$valores['fecha_visto'] 	= date("Y-m-d H:i:s",time());
		$valores['status_m'] 		= 'V';

		$r = $this->marcar_visto_inbox($valores);

		if($r->affectedRows() > 0 )
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Marca de Inbox visto exitosamente';
		}
		else
		{
			$data['codigo']  = '001';
			$data['mensaje'] = 'Error al Marcar';
		}

		return $data;
	}

	function listadoInboxGeneral($datos)
	{
		$valores['id_usuario_r'] = $datos['id_usuario'];
		$valores['page']		 = $datos['page'];

		if($valores['page'] == '' ||  $valores['page'] <= 0)
		{
			$valores['page'] = 1;
		}

		$valores['limit']	= ' LIMIT '.(10 * ($valores['page'] - 1)).',10';

		$r = $this->listado_inbox_general($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function listadoInboxUsuario($datos)
	{
		$valores['id_usuario_r'] = $datos['id_usuario'];
		$valores['id_usuario_e'] = $datos['id_usuario_envia'];

		if($valores['page'] == '' ||  $valores['page'] <= 0)
		{
			$valores['page'] = 1;
		}

		$valores['limit']	= ' LIMIT '.(10 * ($valores['page'] - 1)).',10';

		$r = $this->listado_inbox_general($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function listadoInboxEnviadosGeneral($datos)
	{
		$valores['id_usuario_e'] = $datos['id_usuario'];
		$valores['page']		 = $datos['page'];

		if($valores['page'] == '' ||  $valores['page'] <= 0)
		{
			$valores['page'] = 1;
		}

		$valores['limit']	= ' LIMIT '.(10 * ($valores['page'] - 1)).',10';

		$r = $this->listado_inbox_enviados_general($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function cargarConversacionAnteriorUsuario($datos)
	{
		$valores['id_usuario_e'] = $datos['id_usuario'];
		$valores['id_usuario_r'] = $datos['id_usuario_r'];
		$valores['page']		 = $datos['page'];

		if($valores['page'] == '' ||  $valores['page'] <= 0)
		{
			$valores['page'] = 1;
		}

		$valores['limit']	= ' LIMIT '.(10 * ($valores['page'] - 1)).',10';

		$r = $this->listado_conversacion_anterior_usuario($valores);
		$r = $this->ConvertirResultMatriz($r);

		$data= array();
		array_reverse($r);
		foreach($r as $rec)
		{

			$rec['fecha_envio_mini'] = $this->hace($rec['fecha_envio']);

			$rec['src_mini'] = '';
			if($rec['src'] != '')
			{
				$rec['src_mini'] = str_replace('/img/', '/64/', $rec['avatar']);
			}
            $rec['mensaje'] = utf8_encode($rec['mensaje']);
			$data[] = $rec;

		}

		return $data;
	}

	function listadoInboxSinLeer($datos)
	{
		$valores['id_usuario_r'] = $datos['id_usuario_r'];
		$valores['id_inbox_max'] = $datos['id_inbox_max'];
		//$datos['id_usuario'] 	 = '1';// $_SESSION['u']['id_usuario'];
		$r = $this->listado_inbox_sin_leer_general($valores);
		$r = $this->ConvertirResultMatriz($r);

		$data = array();
		array_reverse($r);
		foreach($r as $rec)
		{
			$rec['fecha_envio_mini'] = $this->hace($rec['fecha_envio']);

			$rec['src_mini'] = '';
			if($rec['src'] != '')
			{
				$rec['src_mini'] = str_replace('/img/', '/64/', $rec['avatar']);
			}
			 $rec['mensaje'] = utf8_encode($rec['mensaje']);
			$data[] = $rec;
		}
		return $data;
	}

	function contarInboxSinLeer($datos)
	{
		$valores['id_usuario_r'] = $datos['id_usuario'];
		$r = $this->count_inbox_general($valores);
		$r = $this->ConvertirResultArray($r);
		if($r['num_men'] == '0')
		{
			$data = '';
		}
		else
		{
			$data = $r['num_men'];
		}
		return $data;
	}

	function contarPendientes($datos)
	{
		$valores['id_usuario'] = $datos['id_usuario'];
		$r = $this->count_pendientes($valores);
		$r = $this->ConvertirResultArray($r);
		if($r['num_pen'] == '0')
		{
			$data = '';
		}
		else
		{
			$data = $r['num_pen'];
		}
		return $data;
	}

	function obtenerInbox($datos)
	{
		$valores['id_usuario_r'] 	= $datos['id_usuario_r'];
		$valores['id_inbox']		= $datos['id_inbox'];
		$r = $this->obtener_inbox($valores);
		$r = $this->ConvertirResultArray($r);
		return $r;
	}

    function registrarImagenGeneralMensajeInboxAjax($file)
	{
		$valores     = array();
        $data        = array();
        $alto        = 64;
        $ancho       = 64;
        $raiz        = '../src/inbox/64/';
        $dir_temp    = '../src/inbox/pic/';

        $calidad     = 99; #Definimos la calidad de la imagen final

        $data['src'] 			= '';
        $data['tipo_archivo']	= '';
        $data['tamanio']		= '';

        //print_r($file);

        #Nombre del archivo
        $nombre = 'in_'.time().'_'.md5(uniqid(rand()));


        #verificamos que se selecciono una imagen
        if(sizeof($file)==0)
        {
            $data['codigo']  = '001';
            $data['mensaje'] = 'Es necesario seleccionar un archivo';
            return $data;
        }

        #nombre temporal del archivo a subir
        $valores['archivo'] = $file['file_inbox']["tmp_name"];

        #Definimos un array para almacenar el tamaño del archivo
        $tamanio=array();

        #obtenemos el tamaño del archivo
        $tamanio = $file['file3']["size"];

        $data['tamanio'] = $this->tamano_archivo($file['file3']["size"]);



        #Obtenemos el mime o tipo de archivo
        $valores['tipo'] = $file['file3']["type"];



        # solo se permite subir archivos, open projec, projec manager, excel,  y pdf
        switch($valores['tipo'])
        {
        	case 'image/jpg' : $data['tipo_archivo'] = 'jpg' ;	break;
            case 'image/jpeg': $data['tipo_archivo'] = 'jpeg' ;	break;
            case 'image/png' : $data['tipo_archivo'] = 'png' ;	break;
            case 'image/gif' : $data['tipo_archivo'] = 'gif' ;	break;
            default:
                $data['codigo'] = '002';
                $data['mensaje']= 'Solo se permite subir archivos open *.jpe, *.png, y *.gif';
                return $data;
            break;

        }

        #Obtenemos el nombre real del archivo
        $nombre_archivo = $nombre.'.'.$data['tipo_archivo'];


        //Verificamos de nuevo que se selecciono un archivo
        if( $valores['archivo'] != "none" )
        {
            #Valida que el directorio exista, si no lo crea y le asigna los permisos.
            if(!is_dir($dir_temp))
            {
                //mkdir($raiz, 0777, true);
                mkdir($dir_temp,0777);
            }

            #Crea la ruta de destino de la carpeta del folio
            $destino = $dir_temp;

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
                imagejpeg($lienzo,$raiz . $nombre_archivo,$calidad);


                $data['codigo']     	= '000';
                $data['mensaje']    	= 'Archivo subido exitosamente';
                $data['src_mini']    	= str_replace('../', '',$raiz.$nombre_archivo);
                $data['src']			= str_replace('../', '',$dir_temp.$nombre_archivo);
                $data['tipo_archivo']	= $data['tipo_archivo'];
                $data['tamanio']		= $data['tamanio'];
            }
            else
            {
                $data['codigo'] = '003';
                $data['mensaje']= 'Error al Subir el archivo';
            }
        }

        return $data;
	}

	function tamano_archivo($peso , $decimales = 2 )
	{
		$clase = array(" Bytes", " KB", " MB", " GB", " TB");
		$decimales = 2;

		//echo 'peso : '.$peso;

		//echo (int)pow(1024,($i = floor(log($peso, 1024))));

		return round($peso/(int)pow(1024,($i = floor(log($peso, 1024)))),$decimales ).$clase[$i];
	}


	/******************************************************************************
	*
	*   M O D U L O          D E        PENDIENTES
	*
	*
	*
	*******************************************************************************/

	function registrarPendienteAjax($datos)
	{
		$datos = $this->clean_r($datos) ;

		$session = $this->validar_token_MJWT($datos['token']);

		$valores['descripcion'] 	= $datos['descripcion'];
		$valores['solucion']		= '';
		$valores['fecha_r']	 		= date("Y-m-d H:i:s",time());
		$valores['fecha_a']	 		= '0000-00-00 00:00:00';
		$valores['id_usuario_r']	= $session['id_usuario'];
		$valores['id_usuario_a']	= '0';
		$valores['status_p'] 		= 'P';
		$valores['visibilidad']		= $datos['visibilidad'];
		$valores['status'] 			= 'A';

		$r  = $this->registrar_pendiente($valores);
		if($r->affectedRows()>0)
		{
			$data['id_pendiente'] 	= $r->insertID();
			$data['codigo']  		= '000';
			$data['mensaje'] 		= 'Registro de pendiente exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al registra el pendiente';
		}

		return $data;
	}

	function actualizarPendienteAjax($datos)
	{
		$datos = $this->clean_r($datos) ;

		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_pendiente']	= $datos['id'];
		$valores['fecha_a']	 		= date('Y-m-d H:i:s',time());;
		$valores['id_usuario_r']	= $session['id_usuario'];
		$valores['status'] 			= $datos['status'];

		$r = $this->actualizar_pendiente($valores);

		if($r->affectedRows()>0)
		{
			$data['codigo']  = '000';
			$data['mensaje'] =  'Actualizacion de pendiente exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al actualizar el pendiente';
		}

		return $data;
	}

	function eliminarPendiente($datos)
	{
		$valores['id_pendiente']	= $datos['id_pendiente'];
		$valores['status'] 		= 'B';

		$r = $this->eliminar_pendiente($valores);

		if($r->affectedRows()>0)
		{
			$data['codigo']  = '000';
			$data['mensaje'] =  'Eliminacion de pendiente exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al actualizar el pendiente';
		}

		return $data;
	}

	function listadoPendientes($datos)
	{
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['status_p']	= 'P';
		$valores['id_usuario']	= $session['id_usuario'];

		$r = $this->listado_pendientes_general($valores);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function obtenerPendiente($datos)
	{
		$valores['id_pendiente']= $datos['id_pendiente'];
		$valores['id_usuario']	= $_SESSION['s']['id_usuario'];

		$r = $this->obtener_pendiente($valores);
		$r = $this->ConvertirResultArray($r);

		return $r;
	}

	function ListadoBusquedasAdmin()
	{
		$r = $this->listado_busquedas_general($valores);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}


	function ObtenerVisitasHoy($datos)
	{
	    $r =  $this->listado_visitas_general($fecha);
	    $r = $this->ConvertirResultArray($r);
	    return $r;
	}

	function obtenerDatosGenerales()
	{
		$r = $this->obtener_datos_generales();
		$r = $this->ConvertirResultArray($r);

		return $r;
	}

	function obtenerGrafica7dias()
	{
		$r = $this->obtener_grafica_7_dias();
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

   function obtenerGraficaAnual()
	{
        $valores['anio'] = '2017';
		$r = $this->obtener_grafica_visitas_general($valores);
		$r = $this->ConvertirResultArray($r);

		return $r;
	}

    function obtenerPaginasVisitasIP($datos)
    {
        $valores['fecha']   = $datos['fecha'];
        $valores['ip']      = $datos['ip'];

        $r = $this->obtener_paginas_visitas_ip($valores);
        $r = $this->ConvertirResultMatriz($r);

        return $r;
    }

	function obtenerFechasVisitasIP($datos)
    {
        $valores['ip']      = $datos['ip'];

        $r = $this->obtener_fechas_visitas_ip($valores);
        $r = $this->ConvertirResultMatriz($r);

        return $r;
    }

	function obtenerVisitasIP($datos)
	{
		$valores['fecha']	= $datos['fecha'];

		$r = $this->obtener_visitas_ip($valores);

		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function ObtenerVisitasFecha($datos)
	{
		$valores['fecha'] = $datos['fecha'];
	    $r =  $this->listado_paginas_visitados($valores);
	    $r = $this->ConvertirResultMatriz($r);
	    return $r;
	}

	function obtenerDatosCalculoPeso($datos)
	{
		$datos = $this->clean_r($datos);

		$puntos    = 0;
		$empresa = $this->obtener_datos_empresa_calculo_peso($datos);
		$empresa = $this->ConvertirResultArray($empresa);

		return $empresa;
	}

	/********************************************************
	*Descripcion: Funcion que calcula el peso de una empresa
	*             dependiendo de los valores capturados sera el
	*             peso de la empresa, y por tanto mas importante
	*********************************************************/
	function CalcularPesoEmpresa($datos)
	{
		$datos = $this->clean_r($datos);

		$puntos    = 0;
		$empresa = $this->obtener_datos_empresa_calculo_peso($datos);
		$empresa = $this->ConvertirResultArray($empresa);

		#$puntosr = array();

		//$puntosr[] = $t; unset($t);

		$servicios = explode(',',$empresa['servicios']);

		/* Si tiene capturado un logo (+10) */
		if($empresa['logo']!= 'src/logos/logo.png')
		{
			#$t['concepto']	= 'Logo propio';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Por cada servicio capturado (+2) */
		if(count($servicios) > 0)
		{
			#$t['concepto']	= 'Servicios capturados';
			#$t['valor'] 	= '+ '.(count($servicios) * 2);
			#$puntosr[] = $t; unset($t);
			$peso = $peso + (count($servicios) * 2);
		}
		/* Si tiene descripcion (+10) */
		if($empresa['descripcion']!= '')
		{
			#$t['concepto']	= 'Descripcion de la empresa';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene giro (+10) */
		if($empresa['id_giro']!= '0')
		{
			#$t['concepto']	= 'Giro';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene Pais (+10) */
		if($empresa['pais']!= '')
		{
			#$t['concepto']	= 'Pais capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene estado (+10) */
		if($empresa['id_estado']!= '0')
		{
			#$t['concepto']	= 'Estado capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene ciudad (+10) */
		if($empresa['id_ciudad']!= '')
		{
			#$t['concepto']	= 'Ciudad capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Por cada producto capturado (+5) */
		if($empresa['num_productos'] > 0)
		{
			#$t['concepto']	= 'Productos ';
			#$t['valor'] 	= '+'.($empresa['num_productos'] * 5);
			#$puntosr[] = $t; unset($t);
			$peso = $peso + ($empresa['num_productos'] * 5);
		}
		/* Si tiene la ubicacion (+10) */
		if($empresa['lat']!= '')
		{
			#$t['concepto']	= 'Ubicacion capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene razon (+10) */
		if($empresa['razon_social'] != '')
		{
			#$t['concepto']	= 'Razon social ';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si direccion (+10) */
		if($empresa['direccion'] != '')
		{
			#$t['concepto']	= 'Direccion';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene correo (+10) */
		if($empresa['correo'] != '')
		{
			#$t['concepto']	= 'correo';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene sitio web (+50) */
		if($empresa['sitio_web'] != '')
		{
			#$t['concepto']	= 'Sitio Web';
			#$t['valor'] 	= '+50';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 50 ;
		}
		/* Si tiene facebook (+10) */
		if($empresa['facebook'] != '')
		{
			#$t['concepto']	= 'Facebook capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene twitter (+10) */
		if($empresa['twitter'] != '')
		{
			#$t['concepto']	= 'twitter capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Si tiene Youtube (+10) */
		if($empresa['youtube'] != '')
		{
			#$t['concepto']	= 'Youtube capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Por cada galeria (+5) */
		if($empresa['num_galeria'] > 0)
		{
			#$t['concepto']	= 'Galeria';
			#$t['valor'] 	= '+'.($empresa['num_galeria'] * 5);
			#$puntosr[] = $t; unset($t);
			$peso = $peso + ($empresa['num_galeria'] * 5);
		}
		/* Si tiene informacio de empresa (+10) */
		if($empresa['informacio'] != '')
		{
			#$t['concepto']	= 'Informacion capturado';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}
		/* Por cada visita (+ 0.01)*/
		if($empresa['visitas'] > 0)
		{
			#$t['concepto']	= 'Visitas capturado';
			#$t['valor'] 	= '+'.($empresa['visitas'] * 0.01);
			#$puntosr[] = $t; unset($t);
			$peso = $peso + ($empresa['visitas'] * 0.01);
		}
		/* Si cuenta es premium (+100) */
		if($empresa['premium'] != '')
		{
			#$t['concepto']	= 'Premium';
			#$t['valor'] 	= '+10';
			#$puntosr[] = $t; unset($t);
			$peso = $peso + 10 ;
		}

		$datos['peso'] 		= ceil($peso);
		$metadata['peso']  	= ceil($peso);
                #$metadata['empresa'] = $empresa;

		$r = $this->actualizar_peso_empresa($datos);
		/*if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Actualizacion de empresa';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al actualizar';
		}*/

		return  $metadata;



	}

         function ListadoEmpresasTotal()
	{
		$r = $this->listado_empresas_total();
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function ActualizarPesoEmpresa($datos)
	{
		$r = $this->actualizar_peso_empresa($datos);
		if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Actualizacion de empresa';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al actualizar';
		}

		return $data;

	}


    function RegistrarRanking($datos)
    {
        $valores['id_empresa']     = $datos['id_empresa'] ;
        $valores['calificacion']= $datos['calificacion'];
        $valores['id_usuario']     = $session['id_usuario'];
        $valores['ip']             = $_SERVER[''];
        $valores['fecha']         = date("Y-m-d H:i:s",time());

        /* Se valida si ya habia votado*/
        $valida = $this->validar_calificacion_ranking($datos);
        $valida = $this->ConvertirResultMatriz($valida);

        if(count($valida) > 0)
        {
            $r = $this->actualizar_ranking($valores);
        }
        else
        {
            $r = $this->registrar_ranking($valores);
        }

        if($r->affecterdRows() > 0)
        {
            /* Obtiene el nuevo total de ranking de la empresa*/
            $tmp = $this->obtener_ranking_empresa($datos);
            $tmp = $this->ConvertirResultMatriz($tmp);

            /* Se actualiza el raking total de la empresa*/
            $r2 = $this->actualizar_ranking_empresa($tmp);

            if($r->affecterdRows() > 0)
            {
                $data['codigo']  = '000';
                $data['mensaje'] = 'Registro exitoso';
            }
        }
        else
        {
            $data['codigo']  = '001';
            $data['mensaje'] = 'Error';
        }

        return $data;
    }

    /************************************************************************************************************
    *
    * MODULO DE MODULOS (???)
    *
    *
    *
    ************************************************************************************************************/


    function ObtenerModulos()
    {
    	$r = $this->obtener_modulos();
    	$r = $this->ConvertirResultMatriz($r);

    	return $r;
    }

    function ObtenerModulosDisponiblesUsuarios($datos)
    {
    	$datos = $this->clean_r($datos);

    	$r = $this->obtener_modulos_disponibles_usuarios($datos);
    	$r = $this->ConvertirResultMatriz($r);

    	return $r;
    }

    function RegistrarUsuarioModulo($datos)
    {
    	$datos = $this->clean_r($datos);

    	if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}


    	$valores['id_usuario'] 	= $datos['id_usuario'];
    	$valores['id_modulo'] 	= $datos['id_modulo'];
    	$valores['fecha'] 		= date("Y-m-d",time());
    	$valores['status'] 		= 'P';

    	$valida = $this->validar_modulo_usuario($valores);
    	$valida = $this->ConvertirResultMatriz($valida);

    	if(count($valida) > 0 )
    	{
    		$data['codigo'] = '000';
    		$data['mensaje']= 'Ya se encuentra activado este modulo';
    		return $data;
    	}

    	$r = $this->registrar_usuario_modulo($valores);

    	if($r->affectedRows() > 0)
        {

        	if($datos['id_modulo'] == '2')
        	{
        		$tmp = $this->ConfiguracionInicialReddental($valores); 
        	}

            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '000';
            $data['mensaje'] = 'Ocurrio un error ';
        }

        return $data;
    }

    function ObtenerModulosUsuarios($datos)
    {
    	$datos = $this->clean_r($datos);

    	$r = $this->obtener_modulos_usuarios($datos);
    	$r = $this->ConvertirResultMatriz($r);

    	return $r;
    }

    function ConfiguracionInicialReddental($datos)
    {
    	// Se registra un servicio nuevo 
    	$valores['id_usuario'] = $datos['id_usuario']; 
    	$valores['nombre_servicio'] = 'Consulta general'; 
    	$valores['descripcion'] = ''; 
    	$valores['precio_normal'] =  '0'; 
    	$valores['fecha'] 			= date("Y-m-d",time());
    	$valores['status'] 	= 'A';

    	$r = $this->registrar_servicio_clinica($valores); 
    	if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Registro exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error ';
		}

		return $data;
    }

    /************************************************************************************************************
    *
    * MODULO DE AMWAY
    *
    ************************************************************************************************************/


    function ListadoContactosAmway($datos)
	{
		$datos = $this->clean_r($datos);

		$datos['consulta'] 	= $datos['consulta'];
		$datos['letra'] 	= $datos['letra'];

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		# se obtiene el numero de empresas
		$tmp = $this->count_listado_contactos_amway($datos);
		$tmp = $this->ConvertirResultArray($tmp);

		# se calculan el numero de paginas
		$datos['num_row'] = $tmp['num_row'];
		$paginador = $this->crear_paginas($datos);

		$datos['limit'] = $paginador['limit'];

		$r = $this->listado_contactos_amway($datos);
		$r = $this->ConvertirResultMatriz($r);

		$metadata['datos'] 		= $r;
		$metadata['paginador'] 	= $paginador;

		return $metadata;
	}

	function RegistrarContactoAmway($datos)
	{
		$datos = $this->clean_r($datos);

		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_tipo_contacto'] 	= $datos['tipo'];
		$valores['nombre_completo'] 	= $datos['nombre'];
		$valores['empresa'] 			= $datos['empresa'];
		$valores['celular'] 			= $datos['celular'];
		$valores['correo'] 				= $datos['correo'];
		$valores['domicilio'] 			= $datos['domicilio'];
		$valores['detalles'] 			= $datos['detalles'];
		$valores['fecha'] 				= date("Y-m-d H:i:s",time());
		$valores['id_usuario']			= $session['id_usuario'];
		$valores['id_usuario_raiz']		= $session['id_usuario'];
		$valores['id_padre'] 			= $session['id_usuario'];
		$valores['status']				= 'A';
		$valores['avatar'] 				= 'img/user2.png';

		$r = $this->registrar_contacto($valores);

		$valores['id_contacto'] = $r->insertID();

		$r = $this->registrar_avance_etapa_contacto($valores);

		if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Registro exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error ';
		}

		return $data;
	}

    function RegistrarAvanceEtapaContacto($datos)
    {
    	$datos = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario']	= $session['id_usuario'];
    	$valores['id_paso'] 	= $datos['id_paso'];
    	$valores['opcion'] 		= $datos['opcion'];
    	$valores['fecha']		= date("Y-m-d",time());

    	if($valores['opcion']=='N')
    	{
    		$valores['opcion'] = 'S';
    	}
    	else
    	{
    		$valores['opcion'] = 'N';
    	}


    	/*
    	$valida = $this->valida_avance_contacto($valores);
    	$valida = $this->ConvertirResultMatriz($valida);

    	if(!isset($valida[0]['1']))
    	{
    		$resultado = $this->registrar_avance_etapa_contacto($valores);

    		if($resultado->affectedRows() > 0)
    		{
    			$data['codigo'] = '000';
    			$data['mensaje'] = 'Exito';
    		}
    		else
    		{
    			$data['codigo'] = '001';
    			$data['mensaje'] = 'Error al registrar';
    			return $data;
    		}
    	}*/

    	$r = $this->actualizar_avance_etapa_contacto($valores);

    	if($r->affectedRows() > 0)
        {
            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }


        return $data;
    }

    function RegistrarAvanceEtapaContactoCompleto($datos)
    {
    	$datos = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario']	= $session['id_usuario'];
    	$valores['opcion'] 		= $datos['opcion'];
    	$valores['fecha']		= date("Y-m-d",time());

    	if($valores['opcion']=='N')
    	{
    		$valores['opcion'] = 'S';
    	}
    	else
    	{
    		$valores['opcion'] = 'N';
    	}

    	$r = $this->actualizar_avance_etapa_contacto_completo($valores);

    	if($r->affectedRows() > 0)
        {
            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }


        return $data;
    }

    function RegistrarComentarioContacto($datos)
    {
    	$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario'] 	= $session['id_usuario'];
    	$valores['comentario'] 	= $datos['comentario'];
    	$valores['fecha']		= date("Y-m-d H:i:s",time());
    	$valores['status']		= 'A';


    	$r = $this->actualizar_avance_etapa_contacto($valores);

    	if($r->affecterdRows() > 0)
        {
            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }

        return $data;
    }

    function ActualizarComentarioContacto($datos)
    {
    	$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario'] 	= $session['id_usuario'];
    	$valores['comentario'] 	= $datos['comentario'];
    	$valores['fecha']		= date("Y-m-d H:i:s",time());

    	$r = $this->actualizar_avance_etapa_contacto($valores);

    	if($r->affecterdRows() > 0)
        {
            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }

        return $data;
    }

    function ObtenerComentariosContacto($datos)
    {
    	$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario'] 	= $session['id_usuario'];

    	$r = $this->obtener_comentarios_contacto_id($valores);
    	$r = $this->ConvertirResultMatriz($r);

    	return $r;
    }

    function EliminarComentarioContacto($datos)
    {
    	$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_contacto'] = $datos['id_contacto'];
    	$valores['id_usuario'] 	= $session['id_usuario'];
    	$valores['status']    	= 'C';
    	$valores['fecha']		= date("Y-m-d H:i:s",time());

    	$r = $this->eliminar_comentario_contacto($valores);

    	if($r->affecterdRows() > 0)
        {
            $data['codigo']  = '000';
            $data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }

        return $data;
    }

    function obtenerPeriodosDisponibles($datos)
	{
		$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

		$valores['fecha'] 		= $datos['fecha'];
		$valores['id_usuario'] 	= $session['id_usuario'];

		$r = $this->listado_periodos_disponibles($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function registrarCita($datos)
	{
		$datos = $this->clean_r($datos);

		$data = array();

		$valores['id_cita']				= $datos['txt_id_cita'];
		$valores['id_usuario'] 			= $_SESSION['s']['id_usuario'];
		$valores['id_modulo'] 			= $_SESSION['s']['modulo_activo'];
		$valores['id_contacto'] 		= $datos['txt_contacto'];
		$valores['id_periodo'] 			= $datos['txtperiodo'];
		$valores['descripcion'] 		= $datos['txtrazon'];
		$valores['fecha']				= $datos['txtfecha'];
		$valores['fecha_agenda'] 		= date('Y-m-d H:i:s',time());
		$valores['color']				= $datos['txtcolor'];
		$valores['status'] 				= 'A';

		if($valores['id_cita'] != '')
		{
			$resultado = $this->actualizar_cita($valores);
		}
		else
		{
			$resultado = $this->registrar_cita($valores);
		}


		if($resultado->affectedRows()>0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Registro  exitoso';
			$data['id']		= $resultado->insertID();
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al registrar la cita';
		}

		return $data;
	}

	function obtenerCitasSemana($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['fecha_inicio'] 	= $datos['fecha_inicio'];
		$valores['fecha_final'] 	= $datos['fecha_final'];
		$valores['id_usuario']		= $datos['id_usuario'];
		$valores['id_modulo'] 		= $_SESSION['s']['modulo_activo'];

		$r = $this->listado_citas_semana($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function obtenerCitasMes($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['fecha_inicio'] 	= $datos['fecha_inicio'];
		$valores['fecha_final'] 	= $datos['fecha_final'];
		$valores['id_usuario']		= $datos['id_usuario'];
		$valores['id_modulo'] 		= $_SESSION['s']['modulo_activo'];

		$r = $this->listado_citas_semana($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function obtenerPeriodos($datos)
	{
		$r = $this->obtener_listado_periodos($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function ObtenerProximasCitas($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['fecha_inicio'] 	= $datos['fecha_inicio'];
		$valores['fecha_final'] 	= $datos['fecha_final'];
		$valores['id_usuario']		= $datos['id_usuario'];
		$valores['id_modulo'] 		= $_SESSION['s']['modulo_activo'];

		$r = $this->listado_citas_semana($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function ObtenerCitasProximasContacto($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['fecha_inicio'] 	= date("Y-m-d H:i:s",time());		
		$valores['id_usuario']		= $datos['id_usuario'];
		$valores['id_contacto']		= $datos['id_contacto']; 
		$valores['id_modulo'] 		= $_SESSION['s']['modulo_activo'];

		$r = $this->listado_citas_semana($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;	
	}

	function ObtenerCitasContacto($datos)
	{
		$datos = $this->clean_r($datos);
		$valores['id_usuario']		= $datos['id_usuario'];
		$valores['id_contacto']		= $datos['id_contacto']; 

		$r = $this->listado_citas_contacto($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;	
	}



	function EliminarCita($datos)
	{
		$datos   = $this->clean_r($datos);
    	$session = $this->validar_token_MJWT($datos['token']);

    	$valores['id_cita']		= $datos['id'];
    	$valores['id_usuario'] 	= $session['id_usuario'];
    	$valores['status']    	= 'C';
    	$valores['fecha']		= date("Y-m-d H:i:s",time());

    	$r = $this->eliminar_cita($valores);

    	if($r->affectedRows() > 0)
        {
            $data['codigo']  = '000';
            //$data['mensaje'] = 'Registro exitoso';
        }
        else
        {
        	$data['codigo']  = '002';
            $data['mensaje'] = 'Ocurrio un error ';
        }

        return $data;
	}

	function ListadoUsuariosMultinivel($datos)
	{
		$datos = $this->clean_r($datos);

		$r = $this->listado_usuarios_multinivel($datos);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}


	/************************************************************************************************************
    *
    * MODULO DE RED DENTAL
    *
    ************************************************************************************************************/


    function ListadoPacientesRedDental($datos)
	{
		$datos = $this->clean_r($datos);

		$datos['consulta'] 	= $datos['consulta'];
		$datos['letra'] 	= $datos['letra'];

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		# se obtiene el numero de empresas
		$tmp = $this->count_listado_contactos_reddental($datos);
		$tmp = $this->ConvertirResultArray($tmp);

		# se calculan el numero de paginas
		$datos['num_row'] = $tmp['num_row'];
		$paginador = $this->crear_paginas($datos);

		//$datos['limit'] = $paginador['limit'];

		$r = $this->listado_contactos_redental($datos);
		$r = $this->ConvertirResultMatriz($r);

		$metadata['datos'] 		= $r;
		$metadata['paginador'] 	= $paginador;

		return $metadata;
	}

	function RegistrarContactoRedDental($datos)
	{
		$datos = $this->clean_r($datos);
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_tipo_contacto'] 	= $datos['tipo'];
		$valores['nombre_completo'] 	= $datos['nombre'];
		$valores['empresa'] 			= $datos['empresa'];
		$valores['celular'] 			= $datos['celular'];
		$valores['correo'] 				= $datos['correo'];
		$valores['domicilio'] 			= $datos['domicilio'];
		$valores['detalles'] 			= $datos['detalles'];
		$valores['fecha'] 				= date("Y-m-d H:i:s",time());
		$valores['id_usuario']			= $session['id_usuario'];
		$valores['id_usuario_raiz']		= $session['id_usuario'];
		$valores['id_padre'] 			= $session['id_usuario'];
		$valores['status']				= 'A';
		$valores['avatar'] 				= 'img/user2.png';

		$r = $this->registrar_contacto($valores);

		if($r->affectedRows() > 0)
		{
			$data['codigo'] = '000';
			$data['mensaje']= 'Registro exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error ';
		}

		return $data;
	}

	function obtenerServiciosClinica($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['id_usuario']	= $datos['id_usuario'];
		$r = $this->listado_servicios_clinica($valores);
		$r = $this->ConvertirResultMatriz($r);
		return $r;
	}

	function registrarServicioClinica($datos)
	{
		$datos = $this->clean_r($datos);
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['nombre_servicio'] = $datos['servicio'];
		$valores['descripcion'] 	= $datos['des'];
		$valores['precio_normal'] 	= $datos['precio'];
		$valores['id_usuario'] 		= $session['id_usuario'];
		$valores['fecha'] 	 		= date("Y-m-d",time());
		$valores['status'] 			= 'A';

		$r = $this->registrar_servicio_clinica($valores);

		if($r->affectedRows()>0)
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Registro de servicio exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al Registro el servicio';
		}

		return $data;

	}

	function actualizarServicioClinica($datos)
	{
		$datos = $this->clean_r($datos);
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_servicio']		= $datos['id_servicio'];
		$valores['nombre_servicio'] = $datos['servicio'];
		$valores['descripcion'] 	= $datos['des'];
		$valores['precio_normal'] 	= $datos['precio'];
		$valores['id_usuario'] 		= $session['id_usuario'];
		$valores['fecha'] 	 		= date("Y-m-d",time());

		$r = $this->actualizar_servicio_clinica($valores);

		if($r->affectedRows()>0)
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Registro de servicio exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al Registro el servicio';
		}

		return $data;
	}

	function eliminarServicioClinica($datos)
	{
		$datos = $this->clean_r($datos);
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_servicio']		= $datos['id_servicio'];
		$valores['id_usuario'] 		= $session['id_usuario'];
		$valores['fecha'] 	 		= date("Y-m-d",time());
		$valores['status']			= 'C';

		$r = $this->eliminar_servicio_clinica($valores);
		if($r->affectedRows()>0)
		{
			$data['codigo']  = '000';
			$data['mensaje'] = 'Registro de servicio exitoso';
		}
		else
		{
			$data['codigo'] = '001';
			$data['mensaje']= 'Ocurrio un error al Registro el servicio';
		}

		return $data;
	}

	function obtenerServicio($datos)
	{
		$valores['id_servicio']		= $datos['id_servicio'];
		$r = $this->obtener_servicio($valores);
		$r = $this->ConvertirResultArray($r);
		return $r;
	}



	function ListadoMedicamentos($datos)
	{
		$datos = $this->clean_r($datos);

		$datos['consulta'] 	= $datos['consulta'];
		$datos['letra'] 	= $datos['letra'];
		$datos['tipo']		= $datos['tipo'];

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		$tmp = $this->count_listado_medicamentos_general($datos);
		$tmp = $this->ConvertirResultArray($tmp);

		# se calculan el numero de paginas
		$datos['num_row'] = $tmp['num_row'];
		$paginador = $this->crear_paginas($datos);

		$datos['limit'] = $paginador['limit'];

		$r = $this->listado_medicamentos_general($datos);
		$r = $this->ConvertirResultMatriz($r);

		$metadata['datos'] 		= $r;
		$metadata['paginador'] 	= $paginador;

		return $metadata;

	}

	function registrarMedicamentoClinica($datos)
	{
		$datos = $this->clean_r($datos);

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}


		$valores['nombre_medicamento']	= $datos['txtnombre'];
		$valores['descripcion'] 		= $datos['txtdes'];
		$valores['presentacion'] 		= $datos['txtpresentacion'];
		$valores['cantidad'] 			= $datos['txtcantidad'];
		$valores['tipo_medicamento']	= 'B';
		$valores['fecha_ult_mod'] 		= date('Y-m-d',time());
		$valores['id_usuario'] 			= $datos['id_usuario'];
		$valores['status'] 				= 'A';
		$valores['id_grupo_med'] 		= '0';
		$valores['nivel']				= '0';
		$valores['codigo']				= '0000';
		$valores['comentario']			= '';
		
		$resultado  = $this->registrar_medicamento_clinica($valores);
		if($resultado->affectedRows()>0)
		{
			$data['codigo'] 	= '000' ;
			$data['mensaje'] 	= 'Registro de Medicamento Exitoso';
		}
		else
		{
			$data['codigo'] = '001' ;
			$data['mensaje'] ='Error al registrar Medicamento';
		}
		return $data;
	}// fin

	function obtenerMedicamentoClinica($datos)
	{
		$datos = $this->clean_r($datos);
		$valores['id_medicamento'] = $datos['id_medicamento'];
		$r = $this->buscar_medicamento_clinica($valores);
		$r = $this->ConvertirResultArray($r);
		return $r;
	}


	function actualizarMedicamentoClinica($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['id_medicamento']			= $datos['txt_id'];
		$valores['nombre_medicamento']	= $datos['txtnombre'];
		$valores['descripcion'] 		= $datos['txtdes'];
		$valores['presentacion'] 		= $datos['txtpresentacion'];
		$valores['cantidad'] 			= $datos['txtcantidad'];
		$valores['tipo_medicamento']	= 'B';
		$valores['fecha_ult_mod'] 		= date('Y-m-d',time());
		$valores['id_usuario'] 			= $_SESSION['s']['id_usuario'];
		$valores['status'] 				= 'A';
		$valores['id_grupo_med'] 	= '0';
		$valores['nivel']					= '0';
		$valores['codigo']				= '0000';
		$valores['comentario']		= '';
		$resultado  = $this->actualizar_medicamento_clinica($valores);
		if($resultado->affectedRows()>0)
		{
			$data['codigo'] 	= '000' ;
			$data['mensaje'] 	= 'Registro de Medicamento Exitoso';
		}
		else
		{
			$data['codigo'] = '001' ;
			$data['mensaje'] ='Error al registrar Medicamento';
		}
		return $data;
	}

	/* I N G R E R S O S */

	function RegistrarIngreso($datos)
	{
		$datos = $this->clean_r($datos);

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		$valores['id_modulo'] 	= $datos['modulo'];
		$valores['id_usuario'] 	= $datos['id_usuario'];
		$valores['fecha'] 		= date("Y-m-d H:i:s",time());
		$valores['status'] 		= 'A';


		 
		$json	= str_replace('\"','"',$datos['json']);
		$json 	= json_decode($json, true);

		for($i=0; $i < count($json); $i++)
		{
			$valores['tipo']		= $json[$i]['tipo']; 
			$valores['concepto'] 	= $json[$i]['concepto'];
			$valores['cantidad']	= $json[$i]['cantidad'];
			$valores['ingreso'] 	= str_replace('$','', $json[$i]['ingreso']);
			$valores['iva'] 		= str_replace('$','', $json[$i]['iva']);
			$valores['total'] 		= str_replace('$','', $json[$i]['total']);	

			$r = $this->registrar_ingreso($valores);
			if($r->affectedRows()>0)
			{
				$data['codigo'] 	= '000' ;
				$data['mensaje'] 	= 'Exito';
			}
			else
			{
				$data['codigo'] = '001' ;
				$data['mensaje'] ='Error';
				return $data; 
			}	
		}

		return $data; 
	}
	
	function ActualizarIngreso($datos)
	{
		$datos = $this->clean_r($datos);

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		$valores['id_ingreso'] 	= $datos['id'];
		$valores['id_modulo'] 	= $datos['modulo'];
		$valores['id_usuario'] 	= $datos['id_usuario'];
		$valores['concepto'] 	= $datos['concepto'];
		$valores['cantidad'] 	= $datos['cantidad'];
		$valores['ingreso'] 	= str_replace('$','', $datos['ingreso']);
		$valores['iva'] 		= str_replace('$','', $datos['iva']);
		$valores['total'] 		= str_replace('$','', $datos['total']);
		$valores['fecha'] 		= date("Y-m-d H:i:s",time());

		$r = $this->actualizar_ingreso($valores);
		if($r->affectedRows()>0)
		{
			$data['codigo'] 	= '000' ;
			$data['mensaje'] 	= 'Exito';
		}
		else
		{
			$data['codigo'] = '001' ;
			$data['mensaje'] ='Error';
		}

		return $data;
	}
	function EliminarIngreso($datos)
	{
		$datos = $this->clean_r($datos);

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		$valores['id_ingreso'] 	= $datos['id'];		
		$valores['id_usuario'] 	= $datos['id_usuario'];
		$valores['fecha'] 		= date("Y-m-d H:i:s",time());
		$valores['status']		= 'C';

		$r = $this->eliminar_ingreso($valores);

		if($r->affectedRows()>0)
		{
			$data['codigo'] 	= '000' ;
			$data['mensaje'] 	= 'Exito';
		}
		else
		{
			$data['codigo'] = '001' ;
			$data['mensaje'] ='Error';
		}

		return $data;
	}
	function ObtenerIngreso($datos)
	{
		$datos = $this->clean_r($datos);

		$valores['id_ingreso'] = $datos['id'];
		$valores['id_usuario'] = $datos['id_usuario'];

		$r = $this->obtener_ingreso($valores);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}
	function ListadoIngresos($datos)
	{
		$datos = $this->clean_r($datos);

		$datos['consulta'] 	= $datos['consulta'];

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		# se obtiene el numero de empresas
		$tmp = $this->count_listado_ingresos($datos);
		$tmp = $this->ConvertirResultArray($tmp);

		# se calculan el numero de paginas
		$datos['num_row'] = $tmp['num_row'];
		$paginador = $this->crear_paginas($datos);

		$datos['limit'] = $paginador['limit'];

		$r = $this->listado_ingresos($datos);
		$r = $this->ConvertirResultMatriz($r);

		$metadata['datos'] 		= $r;
		$metadata['paginador'] 	= $paginador;

		return $metadata;

	}

	function ObtenerResumenIngresosMes($datos)
	{
		$valores['id_usuario'] 		= $datos['id_usuario'];
		$valores['fecha_inicio']    = $datos['fecha_inicio'];
		$valores['fecha_final']		= $datos['fecha_final'];
		$valores['id_modulo']		= $datos['id_modulo']; 

		$r = $this->obtener_resumen_ingresos_mes($datos);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function ObtenerIngresosGraficaSemana($datos)
	{
		$valores['id_usuario'] = $datos['id_usuario'];
		$valores['id_modulo']	= $_SESSION['s']['modulo_activo']; 
		$valores['tipo']		= 'I'; 

		$r = $this->obtener_ingresos_grafica_semana($valores);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function ObtenerEgresosGraficaSemana($datos)
	{
		$valores['id_usuario'] = $datos['id_usuario'];

		$valores['tipo']		= 'E'; 

		$r = $this->obtener_ingresos_grafica_semana($valores);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function ObtenerUltimosIngresos($datos)
	{
		$valores['id_usuario'] = $datos['id_usuario'];

		$r = $this->obtener_ultimos_ingreso($datos);
		$r = $this->ConvertirResultMatriz($r);

		return $r;
	}

	function RegistrarConsulta($datos)
	{
		$datos = $this->clean_r($datos); 

		$session = $this->validar_token_MJWT($datos['token']);
		$valores['id_usuario'] 	= $session['id_usuario'];
		$valores['id_modulo']	= $datos['id_modulo']; 
		$valores['id_contacto']	= $datos['id_contacto']; 
		$valores['fecha']		= date("Y-m-d H:i:s",time()); 
		$valores['status']		= 'A'; 

		$j_servicios 	= str_replace('\"', '"', $datos['j_servicios']); 
		$j_servicios 	= json_decode($j_servicios,true); 

		$j_medicamentos = str_replace('\"', '"', $datos['j_medicamentos']); 
		$j_medicamentos = json_decode($j_medicamentos,true); 	

		$j_ingresos 	= str_replace('\"', '"', $datos['j_ingresos']); 
		$j_ingresos 	= json_decode($j_ingresos,true); 	

		$r = $this->registrar_consulta($valores); 

		if($r->affectedRows() > 0)
		{
			$valores['id_consulta'] = $r->insertID(); 	

			for($i = 0; $i < count($j_servicios); $i++)
			{
				$valores['id_servicio'] = $j_servicios[$i]['id_servicio']; 
				$r = $this->registrar_consulta_servicios($valores); 
			}

			for($i = 0; $i < count($j_medicamentos); $i++)
			{
				$valores['id_medicamento'] 	= $j_medicamentos[$i]['id_medicamento']; 
				$valores['dosis']			= $j_medicamentos[$i]['dosis']; 
				$r = $this->registrar_consulta_medicamentos($valores); 	
			}

			for($i = 0; $i < count($j_ingresos); $i++)
			{
				$valores['tipo']			= $j_ingresos[$i]['tipo'];
				$valores['id_tipo_ingreso']= '2'; 
				$valores['id_ref']		= $valores['id_consulta']; 
				$valores['concepto']	= $j_ingresos[$i]['concepto']; 
				$valores['cantidad']	= $j_ingresos[$i]['cantidad']; 
				$valores['ingreso']		= str_replace('$','', $j_ingresos[$i]['ingreso']); 
				$valores['iva']			= str_replace('$','', $j_ingresos[$i]['iva']); 
				$valores['total']		= str_replace('$','', $j_ingresos[$i]['total']); 

				$r = $this->registrar_ingreso($valores); 
			}

			$data['id_consulta'] = $valores['id_consulta'];
			$data['codigo'] = '000' ; 
			$data['mensaje']= 'Exito'; 
		}
		else
		{
			$data['codigo'] = '001' ; 
			$data['mensaje']= 'Error'; 
		}

		return $data; 
	}

	function ActualizarConsulta($datos)
	{
		$datos = $this->clean_r($datos); 
		$session = $this->validar_token_MJWT($datos['token']);

		$valores['id_consulta'] = $datos['id_consulta']; 		
		$valores['id_usuario'] 	= $session['id_usuario'];
		$valores['id_modulo']	= $datos['id_modulo']; 
		$valores['id_contacto']	= $datos['id_contacto']; 
		$valores['fecha']		= date("Y-m-d",time()); 
		$valores['status']		= 'A'; 

		$j_servicios 	= str_replace('\"', '"', $datos['j_servicios']); 
		$j_servicios 	= json_decode($j_servicios,true); 

		$j_medicamentos = str_replace('\"', '"', $datos['j_medicamentos']); 
		$j_medicamentos = json_decode($j_medicamentos,true); 	

		$j_ingresos 	= str_replace('\"', '"', $datos['j_ingresos']); 
		$j_ingresos 	= json_decode($j_ingresos,true); 

		$r = $this->actualizar_consulta($valores); 

		if($r->affectedRows() > 0)
		{
			$valores['id_consulta'] = $r->insertID(); 	

			$tmp = $this->eliminar_consulta_medicamentos($valores); 
			$tmp = $this->eliminar_consulta_servicios($valores); 

			for($i = 0; $i < count($j_servicios); $i++)
			{
				$valores['id_servicio'] = $j_servicios[$i]['id_servicio']; 
				$r = $this->registrar_consulta_servicios($valores); 
			}

			for($i = 0; $i < count($j_medicamentos); $i++)
			{
				$valores['id_medicamento'] 	= $j_medicamentos[$i]['id_medicamento']; 
				$valores['dosis']			= $j_medicamentos[$i]['dosis']; 
				$r = $this->registrar_consulta_medicamentos($valores); 	
			}

			for($i = 0; $i < count($j_ingresos); $i++)
			{
				$valores['tipo_ingreso']= '2'; 
				$valores['id_ref']		= $valores['id_consulta']; 
				$valores['concepto']	= $j_ingresos['concepto']; 
				$valores['cantidad']	= $j_ingresos['cantidad']; 
				$valores['ingreso']		= str_replace('$','', $j_ingresos[$i]['ingreso']); 
				$valores['iva']			= str_replace('$','', $j_ingresos[$i]['iva']); 
				$valores['total']		= str_replace('$','', $j_ingresos[$i]['total']); 

				$r = $this->registrar_ingreso($valores); 
			}

			$data['codigo'] = '000' ; 
			$data['mensaje']= 'Exito'; 
		}
		else
		{
			$data['codigo'] = '001' ; 
			$data['mensaje']= 'Error'; 
		}

		return $data; 
	}

	function EliminarConsulta($datos)
	{
		$datos = $this->clean_r($datos); 

		$session = $this->validar_token_MJWT($datos['token']);
		$valores['id_usuario'] 	= $session['id_usuario'];
		$valores['id_consulta'] = $datos['id_consulta']; 
		$valores['id_ref']		= $datos['id_consulta']; 
		$valores['fecha'] 		= date("Y-m-d H:i:s",time());
		$valores['status'] 		='C'; 
		$valores['id_tipo_ingreso'] = '2'; 

		$r = $this->eliminar_consulta($valores); 

		if($r->affectedRows() > 0)
		{

			$r2 = $this->eliminar_ingreso_referencia($valores); 
			$data['codigo'] = '000' ; 
			$data['mensaje']= 'Exito'; 
		}
		else
		{
			$data['codigo'] = '001' ; 
			$data['mensaje']= 'Error'; 
		}

		return $data; 
	}

	function ObtenerConsultaID($datos)
	{
		$datos = $this->clean_r($datos); 

		//$session = $this->validar_token_MJWT($datos['token']);
		$valores['id_usuario'] 		= $_SESSION['s']['id_usuario'];
		$valores['id_consulta'] 	= $datos['id_consulta'];
		$valores['id_tipo_ingreso'] = '2'; 		

		$data = array(); 

		$r = $this->obtener_consulta($valores); 
		$r = $this->ConvertirResultMatriz($r); 

		$s = $this->obtener_consulta_servicios($valores); 
		$s = $this->ConvertirResultMatriz($s); 

		$m = $this->obtener_consulta_medicamentos($valores); 
		$m = $this->ConvertirResultMatriz($m); 

		$m = $this->obtener_consulta_medicamentos($valores); 
		$m = $this->ConvertirResultMatriz($m); 

		$i = $this->obtener_consulta_ingresos($valores); 
		$i = $this->ConvertirResultMatriz($i); 

		$data['consulta'] 		= $r[0]; 
		$data['servicios'] 		= $s; 
		$data['medicamentos']	= $m; 
		$data['ingresos']		= $i; 

		return $data; 
	}

	function ListadoConsultas($datos)
	{
		$datos = $this->clean_r($datos);

		$datos['consulta'] 	= $datos['consulta'];

		if($_SESSION['s']['id_usuario']!= '')
		{
			$datos['id_usuario'] = $_SESSION['s']['id_usuario'];
		}
		else
		{
			$session = $this->validar_token_MJWT($datos['token']);
			$datos['id_usuario'] = $session['id_usuario'];
		}

		# se obtiene el numero de empresas
		$tmp = $this->count_listado_consultas($datos);
		$tmp = $this->ConvertirResultArray($tmp);

		# se calculan el numero de paginas
		$datos['num_row'] = $tmp['num_row'];
		$paginador = $this->crear_paginas($datos);

		$datos['limit'] = $paginador['limit'];

		$r = $this->listado_consultas($datos);
		$r = $this->ConvertirResultMatriz($r);

		$metadata['datos'] 		= $r;
		$metadata['paginador'] 	= $paginador;

		return $metadata;
	}

	function EnviarCorreosPendientes()
	{
		$correos = $this->obtener_correos_pendientes(); 
		$correos = $this->ConvertirResultMatriz($correos);

		$plantillas = $this->obtener_plantillas(); 
		$plantillas = $this->ConvertirResultMatriz($plantillas);  

		if(count($correos) > 0)
		{
			foreach ($correos as $c) 
			{
				if(count($plantillas) > 0)
				{
					foreach ($plantillas as $p) 
					{
						if($p['id_plantilla'] == $c['id_plantilla'])
						{
							$c['mensaje'] = str_replace('{CUERPO}', $c['mensaje'],$p['plantilla_externa']); 
							break;
						}
					}	
				}

				$correo['mensaje'] 	= $c['mensaje'];
				$correo['asunto']	= $c['asunto'];
				$correo['to']	   	= $c['toc'];
				$correo['from']		= $c['fromc'];

				print_r($correo);

				$tmp 	= $this->enviarCorreo($correo);    

				echo 'Aqui deberia de imprimirse la respuesta del servidor de correo : '.var_dump($tmp);

				print_r($tmp); 

				if($tmp['codigo']=='000')
				{
					$c['fecha_e']	= date("Y-m-d H:i:s",time());
					$this->actualizar_correo_enviado($c); 
				}
			}
		}
	}

	function GenerarCorreosNotificacionCita()
	{
		$datos['fecha']		= date("Y-m-d",(strtotime("+1 day")));		
		$datos['id_modulo']	= '2'; 
		$citas    	= $this->listado_citas_dia($datos);
		$citas 		= $this->ConvertirResultMatriz($citas); 

		if(count($citas) > 0)
		{
			# Notificacion de citas para los pacientes
			foreach($citas as $c)
			{
				$correo = array();
	            if($c['correo_paciente'] != '')
	            {
					$correo['mensaje'] ='Buen dia '.$c['nombre_paciente'].' <br><br>Te recordamos que tienes una Cita Dental para el dia '.$c['fecha'].' (Ma&ntilde;ana) de <b>'.$c['periodo'].'</b> con el Dentista <b>'.$c['nombre'].' '.$c['apellidos'].' </b>.
							<br><br>
							<br><br>
							<br><br>
							<br><br>
							Saludos, <br>
							que tenga un buen dia';
					$correo['asunto']		= 'Recuerda que tienes una Cita - Red Dental';
					$correo['to']	   		= $c['correo_paciente'];
					$correo['from']			= 'contacto@redmedicaonline.com';	 
					$correo['id_plantilla'] = '1';
					$correo['fecha_c']  	= date("Y-m-d H:i:s",time());
					$correo['fecha_e']  	= '0000-00-00 00:00:00';
					$correo['status'] 		= 'P';

	            
	            	$tmp 	= $this->registrar_correo_pendiente($correo);            	
	            }
			}

			# Notificacion de cita para Los dentistas		
			foreach($citas as $c)
			{
				$correo = array();
	            
				$correo['mensaje'] ='Buen dia '.$c['nombre'].' <br><br>Te recordamos que tienes una Cita para el dia '.$c['fecha'].' (Ma&ntilde;ana) de <b>'.$c['periodo'].'</b> con el paciente <b>'.$c['nombre_completo'].'</b>.
						<br><br>
						<br><br>
						<br><br>
						<br><br>
						Saludos, <br>
						que tenga un buen dia';
				$correo['asunto']		= 'Cita para el dia de Ma&ntilde;ana - Red Dental';
				$correo['to']	   		= $c['correo_dentista'];
				$correo['from']			= 'contacto@redmedicaonline.com';
				$correo['id_plantilla'] = '1';
	        	$correo['fecha_c']  	= date("Y-m-d H:i:s",time());
				$correo['fecha_e']  	= '0000-00-00 00:00:00';
				$correo['status'] 		= 'P';
	        	
	            $tmp 	= $this->registrar_correo_pendiente($correo);            	
	            
			}

		}
	}





	}
?>
