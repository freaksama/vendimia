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

	}
?>
