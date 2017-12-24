<?
class servicio extends Base
{
	public $db;

	function __construct(&$db)
	{
		$this->db=&$db;
	}

	/******************************************************************************
	*
	*   B L O Q U E  C L I E N T E S 
	*
	********************************************************************************/

	function listado_clientes()
	{
		$q="SELECT 
				id_cliente,
				LPAD(id_cliente,4,'0') as clave_cliente,
				nombre, 
				apellido_paterno, 
				apellido_materno, 
				rfc
			FROM clientes"; 
		return $this->db->query($q);
	}

	function buscar_cliente()
	{
		$q="SELECT 					
				id_cliente as id,
				CONCAT(LPAD(id_cliente,3,'0'),' - ',nombre,' ',apellido_paterno,' ',apellido_materno) as value, 				
				rfc as data
			FROM clientes";  
		return $this->db->query($q);
	}

	function obtener_siguiente_clave_cliente()
	{
		$q="SELECT 	
				LPAD(IFNULL(MAX(id_cliente),0)+1,4,'0') as clave_cliente
			FROM clientes"; 
		return $this->db->query($q);
	}

	function registrar_cliente($datos)
	{
		$q="INSERT INTO clientes (
				nombre,
				apellido_paterno, 
				apellido_materno, 
				rfc) 
			VALUES(
			'".$datos['nombre']."', 
			'".$datos['apellido_paterno']."', 
			'".$datos['apellido_materno']."', 
			'".$datos['rfc']."')"; 
		return $this->db->query($q);
	}

	function actualizar_cliente($datos)
	{
		$q="UPDATE clientes  SET 
				nombre 				= '".$datos['nombre']."', 
				apellido_paterno 	= '".$datos['apellido_paterno']."', 
				apellido_materno 	= '".$datos['apellido_materno']."', 
				rfc 				= '".$datos['rfc']."'
			WHERE id_cliente = '".$datos['id']."' "; 
		return $this->db->query($q);
	}

	function obtener_cliente_id($datos)
	{
		$q="SELECT 
				id_cliente,
				LPAD(id_cliente,4,'0') as clave_cliente,
				nombre, 
				apellido_paterno, 
				apellido_materno, 
				rfc
			FROM clientes
			where id_cliente = '".$datos['id_cliente']."'"; 
		return $this->db->query($q);
	}


	/******************************************************************************
	*
	*   B L O Q U E         A R T I C U L O S
	*
	********************************************************************************/

	function listado_articulos()
	{
		$q="SELECT 
				id_articulo,
				LPAD(id_articulo,4,'0') as clave_articulo,
				descripcion, 
				modelo, 
				precio, 
				existencia
			FROM articulos"; 
		return $this->db->query($q);
	}

		function buscar_articulos()
	{
		$q="SELECT 					
				id_articulo as id,
				CONCAT(LPAD(id_articulo,3,'0'),' - ',descripcion) as value
			FROM articulos";  
		return $this->db->query($q);
	}

	function obtener_siguiente_clave_articulo()
	{
		$q="SELECT 	
				LPAD(IFNULL(MAX(id_articulo),0)+1,4,'0') as clave_articulo
			FROM articulos"; 
		return $this->db->query($q);
	}

	function registrar_articulo($datos)
	{
		$q="INSERT INTO articulos (			
			descripcion, 
			modelo, 
			precio, 
			existencia)
			VALUES(
			'".$datos['descripcion']."', 
			'".$datos['modelo']."', 
			'".$datos['precio']."', 
			'".$datos['existencia']."')"; 
		return $this->db->query($q);
	}

	function obtener_articulo_id($datos)
	{
		$q="SELECT 
				id_articulo,
				LPAD(id_articulo,4,'0') as clave_articulo,
				descripcion, 
				modelo, 
				precio, 
				existencia
			FROM articulos
			WHERE id_articulo = '".$datos['id_articulo']."' "; 
		return $this->db->query($q);	
	}

	function actualizar_existencia_articulo($datos)
	{
		$q="UPDATE articulos SET 
				existencia = '".$datos['existencia']."'
			WHERE id_articulo = '".$datos['id_articulo']."'"; 
		return $this->db->query($q);	
	}

	function actualizar_articulo($datos)
	{
		$q="UPDATE  articulos  SET 
				descripcion = '".$datos['descripcion']."',
				modelo 		= '".$datos['modelo']."', 
				precio 		= '".$datos['precio']."', 
				existencia 	= '".$datos['existencia']."'
			WHERE id_articulo = '".$datos['id']."'";			
		return $this->db->query($q);	
	}

	/******************************************************************************
	*
	*   B L O Q U E         CONFIGURACION 
	*
	********************************************************************************/


	function obtener_configuracion()
	{
		$q="SELECT 
				id, 
				tasa_financiamiento, 
				enganche, 
				plazo
			FROM configuracion
			where id = '1' "; 
		return $this->db->query($q);
	}

	function actualizar_configuracion($datos)
	{
		$q="UPDATE configuracion SET 
				tasa_financiamiento = '".$datos['tasa']."', 
				enganche 			= '".$datos['enganche']."', 
				plazo 				= '".$datos['plazo']."'
			WHERE id = '1'"; 
		return $this->db->query($q);
	}



	/******************************************************************************
	*
	*   B L O Q U E        V E N T A S
	*
	********************************************************************************/

	function listado_ventas()
	{
		$q="SELECT 
				LPAD(a.id_venta,4,'0') as folio_venta,
				a.total,
				a.fecha,
				a.plazos,
				a.estatus, 
				LPAD(b.id_cliente,4,'0') as clave_cliente,
				b.nombre, 
				b.apellido_paterno, 
				b.apellido_materno
			FROM ventas a 
			INNER JOIN clientes b ON  a.id_cliente =  b.id_cliente"; 
		return $this->db->query($q);
	}

	function obtener_siguiente_clave_ventas()
	{
		$q="SELECT 	
				LPAD(IFNULL(MAX(id_venta),0)+1,4,'0') as clave_venta
			FROM ventas"; 
		return $this->db->query($q);
	}

	function registrar_venta($datos)
	{
		$q="INSERT INTO ventas (
				id_cliente,
				total,
				fecha,
				plazos,
				estatus)
			VALUES(
			'".$datos['id_cliente']."', 
			'".$datos['total']."', 
			'".$datos['fecha']."', 
			'".$datos['plazos']."', 
			'".$datos['estatus']."')"; 
		return $this->db->query($q);
	}















































	function inicio_session_usuario($datos)
	{
		$q="SELECT
				b.id_empresa,
				a.id_usuario,
				a.id_tipo_usuario,
				a.nombre,
				a.apellidos,
				a.sexo,
				a.avatar,
				a.id_ult_not,
				a.visitas_perfil,
				a.ubicacion,
				a.celular,
				a.fecha,
				a.password,
				a.correo,
				a.tema,
				a.status,
				a.registro_completo
			FROM usuarios a
			INNER JOIN empresas b ON a.id_usuario = b.id_usuario
			WHERE a.correo  = '".$datos['correo']."'
			AND a.password  = '".$datos['password']."'";
		return $this->db->query($q);
	}

	function actualizar_configuracion_inicial_usuario($datos)
	{
		$q="update  usuarios set
				nombre 		 = '".$datos['nombre']."',
				apellidos  	 = '".$datos['apellidos']."',
				bio  	 	 = '".$datos['bio']."',
				sexo 		 = '".$datos['sexo']."',
				avatar 	 	 = '".$datos['avatar']."',
				registro_completo = '".$datos['registro_completo']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function obtener_modulos_usuario($datos)
	{
		$q="SELECT
				a.id_modulo,
				a.nombre_modulo
			FROM modulos a
			INNER JOIN usuarios_modulos b ON a.id_modulo = b.id_modulo
			WHERE b.id_usuario = '".$datos['id_usuario']."'
			AND (b.status = 'A' OR b.status = 'P' )";
		return $this->db->query($q);
	}

	function obtener_modulos_disponibles_usuarios($datos)
	{
		$q="SELECT
				a.id_modulo,
    			a.nombre_modulo,
    			a.descripcion,
    			a.icon,
    			a.tipo_membresia,
    			a.precio,
    			a.metodo_pago,
    			(select id_usuario
    				from usuarios_modulos
    				where id_modulo = a.id_modulo
    				and id_usuario = '".$datos['id_usuario']."'
    				and (status = 'A' || status = 'P')
    			) as id_usuario
			FROM modulos a
			WHERE  a.status = 'A' ";
		return $this->db->query($q);
	}

	function obtener_modulos_usuarios($datos)
	{
		$q="SELECT
				a.id_modulo,
    			a.nombre_modulo,    			
    			a.icon,
    			a.tipo_membresia,
    			a.precio,    			
    			b.status    			
			FROM modulos a
			INNER JOIN usuarios_modulos b ON a.id_modulo = b.id_modulo
			WHERE  a.status = 'A'
			AND b.id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}

	function obtener_datos_completos_usuario($datos)
	{
		$q="SELECT
				id_usuario,
				nombre,
				apellidos,
				bio,
				sexo,
				avatar,
				id_ult_not,
				id_tipo_usuario,
				visitas_perfil,
				ubicacion,
				celular,
				fecha,
				password,
				correo,
				registro_completo,
				notificacion_correo,
				tema,
				status
			FROM usuarios
			WHERE id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}

	function registrar_usuario($datos)
	{
		$q ="INSERT INTO usuarios (
				id_tipo_usuario,
				nombre,
				apellidos,
				bio,
				sexo,
				avatar,
				id_ult_not,
				visitas_perfil,
				ubicacion,
				celular,
				fecha,
				password,
				correo,
				tema,
				registro_completo,
				notificacion_correo,
				status)
			VALUES(
				 ".$datos['id_tipo_usuario'].",
				'".$datos['nombre']."',
				'".$datos['apellidos']."',
				'".$datos['bio']."',
				'".$datos['sexo']."',
				'".$datos['avatar']."',
				'".$datos['id_ult_not']."',
				'".$datos['visitas_perfil']."',
				'".$datos['ubicacion']."',
				'".$datos['celular']."',
				'".$datos['fecha']."',
				'".$datos['password']."',
				'".$datos['correo']."',
				'".$datos['tema']."',
				'".$datos['registro_completo']."',
				'".$datos['notificacion_correo']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_detalles_usuario($datos)
	{
		$q="update  usuarios set
				nombre 		 	= '".$datos['nombre']."',
				apellidos  	 	= '".$datos['apellidos']."',
				bio  	 	 	= '".$datos['bio']."',
				id_tipo_usuario = '".$datos['id_tipo_usuario']."',
				sexo 		 	= '".$datos['sexo']."',
				ubicacion 	 	= '".$datos['ubicacion']."',
				celular 	 	= '".$datos['celular']."',
				correo 		 	= '".$datos['correo']."'
			where id_usuario 	= '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_password_usuario($datos)
	{
		$q="update  usuarios set
				password = '".$datos['password']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_avatar_usuario($datos)
	{
		$q="update  usuarios set
				avatar = '".$datos['avatar']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_ultnot_usuario($datos)
	{
		$q="update  usuarios set
				id_ult_not = '".$datos['id_ult_not']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_status_usuario($datos)
	{
		$q="update  usuarios set
				status = '".$datos['status']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_notificacion_usuario($datos)
	{
		$q="update  usuarios set
				notificacion_correo = '".$datos['notificacion_correo']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_visitas_perfil_usuario($datos)
	{
		$q="update  usuarios set
				visitas_perfil = '".$datos['visitas_perfil']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function actualizar_tema_usuario($datos)
	{
		$q="update usuarios set
				tema = '".$datos['tema']."'
			where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function validar_correo($datos)
	{
		$q="SELECT 1 FROM usuarios where correo = '".$datos['correo']."'";
		return $this->db->query($q);
	}

	function obtener_visitas_perfil($datos)
	{
		$q="SELECT visitas_perfil FROM usuarios where id_usuario = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}


	/******************************************************************************
	*
	*   B L O Q U E  D E  E M P R E S A S
	*
	********************************************************************************/



	function obtener_empresas_portada()
	{
		$q="SELECT
				a.id_empresa,
				a.id_ciudad,
				a.nombre_empresa,
				a.nombre_clave,
				a.descripcion,
				a.sitio_web,
				a.logo, 
				b.nombre_giro
			FROM empresas a
			LEFT JOIN cat_giros b ON a.id_giro = b.id_giro
			WHERE a.logo != 'src/logo/logo.png'
			AND a.publicar_empresa = 'S'
			ORDER BY a.id_empresa DESC
			LIMIT 0,9
			";
		return $this->db->query($q);
	}

	function count_obtener_empresas($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'  OR 
								c.nombre_giro LIKE '%".$datos['consulta']."%'  ) " ;
		}

		if($datos['giro'] != '')
		{
			//$filtro .= " AND (	c.nombre_giro  LIKE '%".$datos['giro']."%' ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM empresas a
			LEFT JOIN cat_giros   c ON a.id_giro = c.id_giro
			WHERE publicar_empresa = 'S'
			".$filtro;
		return $this->db->query($q);
	}

	function obtener_empresas($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND  (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'  OR 
								c.nombre_giro LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['giro'] != '')
		{
			$filtro .= " AND (	c.nombre_giro  LIKE '%".$datos['giro']."%' ) " ;
		}

		$q="SELECT
				a.id_empresa,
				b.id_empresa as fav,
				a.id_ciudad,
				a.nombre_empresa,
				a.razon_social,
				a.descripcion,
				a.servicios,
				a.direccion,
				a.sitio_web,
				a.logo,
				c.nombre_giro, 
				a.lat, 
				a.lng
			FROM empresas a
			LEFT JOIN empresas_favoritas b ON a.id_empresa = b.id_empresa
			LEFT JOIN cat_giros          c ON a.id_giro = c.id_giro
			WHERE a.publicar_empresa = 'S'
			".$filtro."
			Order by a.peso DESC
			".$datos['limit'];
		return $this->db->query($q);
	}

	function count_obtener_empresas_favoritas($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM empresas a
			INNER JOIN empresas_favoritas b ON a.id_empresa = b.id_empresa
			WHERE a.publicar_empresa = 'S'
			and b.id_usuario = '".$datos['id_usuario']."'
			".$filtro;
		return $this->db->query($q);
	}

	function obtener_empresas_favoritas($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		$q="SELECT
				a.id_empresa,
				b.id_empresa as fav,
				a.id_ciudad,
				a.nombre_empresa,
				a.nombre_clave,
				a.descripcion,
				a.servicios,
				a.sitio_web,
				a.logo
			FROM empresas a
			INNER JOIN empresas_favoritas b ON a.id_empresa = b.id_empresa
			WHERE a.publicar_empresa = 'S'
			and b.id_usuario = '".$datos['id_usuario']."'
			".$filtro."
			Order by a.id_empresa DESC
			".$datos['limit'];

		return $this->db->query($q);
	}

	function registrar_empresa($datos)
	{
		$q="INSERT INTO empresas (
			id_estado,
			id_ciudad,
			id_giro,
			id_subgiro,
			nombre_empresa,
			razon_social,
			nombre_clave,
			descripcion,
			servicios,
			rfc,
			direccion,
			telefono,
			correo,
			sitio_web,
			logo,
			num_personas,
			informacion,
			publicar_empresa,
			titulo_productos,
			mostrar_precio,
			mostrar_productos,
			mostrar_blog,
			mostrar_ubicacion,
			mostrar_informacion,
			mostrar_galeria,
			mostrar_contacto,
			fecha,
			visitas,
			lat,
			lng,
			id_usuario,
			status)
			VALUES(
			'0',
			'".$datos['id_ciudad']."',
			'".$datos['id_giro']."',
			'".$datos['id_subgiro']."',
			'".$datos['nombre_empresa']."',
			'".$datos['razon_social']."',
			'".$datos['nombre_clave']."',
			'".$datos['descripcion']."',
			'".$datos['servicios']."',
			'".$datos['rfc']."',
			'".$datos['direccion']."',
			'".$datos['telefono']."',
			'".$datos['correo']."',
			'".$datos['sitio_web']."',
			'".$datos['logo']."',
			'".$datos['num_personas']."',
			'".$datos['informacion']."',
			'".$datos['publicar_empresa']."',
			'".$datos['titulo_productos']."',
			'".$datos['mostrar_precio']."',
			'".$datos['mostrar_productos']."',
			'".$datos['mostrar_blog']."',
			'".$datos['mostrar_ubicacion']."',
			'".$datos['mostrar_informacion']."',
			'".$datos['mostrar_galeria']."',
			'".$datos['mostrar_contacto']."',
			'".$datos['fecha']."',
			'".$datos['visitas']."',
			'".$datos['lat']."',
			'".$datos['lng']."',
			'".$datos['id_usuario']."',
			'".$datos['status']."')
		";
		return $this->db->query($q);
	}

	function obtener_empresa_usuario_id($datos)
	{
		$q="SELECT id_empresa FROM empresas WHERE id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}

	function obtener_empresa_completa($datos)
	{
		$q="SELECT
				a.id_empresa,
				a.id_estado,
				d.id_ciudad,
				d.nombre_ciudad,
				a.id_giro,
				b.nombre_giro,
				a.id_subgiro,
				a.nombre_empresa,
				a.nombre_clave,
				a.descripcion,
				a.servicios,
				a.direccion,
				a.telefono,
				a.correo,
				a.rfc,
				a.sitio_web,
				a.logo,
				a.publicar_empresa,
				a.titulo_productos,
				a.mostrar_precio,
				a.informacion,
				a.visitas,
				a.lat,
				a.lng,
				a.metodos_pagos,
				a.mostrar_productos,
				a.mostrar_blog,
				a.mostrar_informacion,
				a.mostrar_ubicacion,
				a.mostrar_galeria,
				a.mostrar_contacto, 
				a.peso
			FROM empresas a
			LEFT JOIN cat_giros b 		ON a.id_giro = b.id_giro
			LEFT JOIN cat_ciudades d 	ON d.id_ciudad = a.id_ciudad
			WHERE a.id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_detalles_empresa($datos)
	{
		$q="update empresas set
				nombre_empresa 	= '".$datos['nombre_empresa']."',
				nombre_clave 	= '".$datos['nombre_clave']."',
				descripcion 	= '".$datos['descripcion']."',
				servicios 		= '".$datos['servicios']."',
				id_ciudad		= '".$datos['id_ciudad']."',
				id_estado 		= '".$datos['id_estado']."',
				id_giro 		= '".$datos['id_giro']."',
				rfc  			= '".$datos['rfc']."',
				direccion 		= '".$datos['direccion']."',
				telefono 		= '".$datos['telefono']."',
				correo 			= '".$datos['correo']."',
				sitio_web 		= '".$datos['sitio_web']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_configuracion_empresa($datos)
	{
		$q="update empresas set
				publicar_empresa    = '".$datos['publicar_empresa']."',
				titulo_productos 	= '".$datos['titulo_productos']."',
				mostrar_precio 		= '".$datos['mostrar_precio']."',
				mostrar_productos 	= '".$datos['mostrar_productos']."',
				mostrar_blog 		= '".$datos['mostrar_blog']."',
				mostrar_informacion	= '".$datos['mostrar_informacion']."',
				mostrar_ubicacion 	= '".$datos['mostrar_ubicacion']."',
				mostrar_galeria  	= '".$datos['mostrar_galeria']."',
				mostrar_contacto 	= '".$datos['mostrar_contacto']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_configuracion_inicial_empresa($datos)
	{
		$q="update empresas set
				nombre_empresa 	= '".$datos['nombre_empresa']."',
				id_estado		= '".$datos['id_estado']."',
				direccion 		= '".$datos['direccion']."',
				telefono 		= '".$datos['telefono']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actulizar_informacion_vision($datos)
	{
		$q="update empresas set
				informacion  = '".$datos['informacion']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_logo($datos)
	{
		$q="update empresas set
				logo = '".$datos['logo']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_giro_subgiro($datos)
	{
		$q="update empresas set
				id_giro  	= '".$datos['id_giro']."',
				id_subgiro 	= '".$datos['id_subgiro']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_titulo_producto($datos)
	{
		$q="update empresas set
				titulo_productos  	= '".$datos['titulo_productos']."',
				mostrar_precio  	= '".$datos['mostrar_precio']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_mapa_subgiro($datos)
	{
		$q="update empresas set
				lat  	= '".$datos['lat']."',
				lng  	= '".$datos['lng']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_metodos_pagos_subgiro($datos)
	{
		$q="update empresas set
				metodos_pagos  	= '".$datos['metodos_pagos']."'
			where id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}





	function obtener_productos_empresa($datos)
	{
		$q="select
				id_producto,
				nombre_producto,
				descripcion,
				id_categoria,
				marca,
				img,
				modelo,
				precio,
				precio_oferta,
				fecha
			from productos
			where id_empresa = '".$datos['id_empresa']."'
			and status = 'A'
			ORDER by id_producto desc";
		return $this->db->query($q);
	}

	function obtener_producto_ID($datos)
	{
		$q="select
				id_producto,
				nombre_producto,
				descripcion,
				id_categoria,
				marca,
				modelo,
				precio,
				precio_oferta,
				img,
				fecha,
				id_usuario,
				status
			from productos
			where id_producto = '".$datos['id_producto']."'
			and status = 'A'";
		return $this->db->query($q);
	}

	function registrar_producto($datos)
	{
		$q="INSERT INTO productos (
			id_empresa,
			nombre_producto,
			descripcion,
			id_categoria,
			marca,
			modelo,
			precio,
			precio_oferta,
			img,
			fecha,
			id_usuario,
			status)
			VALUES(
			'".$datos['id_empresa']."',
			'".$datos['nombre_producto']."',
			'".$datos['descripcion']."',
			'".$datos['id_categoria']."',
			'".$datos['marca']."',
			'".$datos['modelo']."',
			'".$datos['precio']."',
			'".$datos['precio_oferta']."',
			'".$datos['img']."',
			'".$datos['fecha']."',
			'".$datos['id_usuario']."',
			'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_producto($datos)
	{
		$q="update productos set
				nombre_producto = '".$datos['nombre_producto']."',
				descripcion 	= '".$datos['descripcion']."',
				id_categoria 	= '".$datos['id_categoria']."',
				marca 			= '".$datos['marca']."',
				modelo 			= '".$datos['modelo']."',
				precio 			= '".$datos['precio']."',
				precio_oferta 	= '".$datos['precio_oferta']."',
				fecha 			= '".$datos['fecha']."'
			where id_producto   = '".$datos['id_producto']."'";
		return $this->db->query($q);
	}

	function eliminar_producto($datos)
	{
		$q="update productos set
				status 	= '".$datos['status']."',
				fecha 	= '".$datos['fecha']."'
			where id_producto  = '".$datos['id_producto']."'
			and id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function actualizar_imagen_producto_empresa($datos)
	{
		$q="update productos set
				img  = '".$datos['img']."'
			where id_producto = '".$datos['id_producto']."'";
		return $this->db->query($q);
	}

	function obtener_galeria_empresa($datos)
	{
		$q="select
				id_galeria,
				descripcion,
				img
			from  galerias
			where id_empresa = '".$datos['id_empresa']."'
			and status = 'A'
			order by id_galeria desc";
		return $this->db->query($q);
	}

	function obtener_imagen_galeria_empresa($datos)
	{
		$q="select
				id_galeria,
				descripcion,
				img
			from  galerias
			where id_galeria = '".$datos['id_galeria']."'
			and status = 'A'
			";
		return $this->db->query($q);
	}


	function registrar_imagen_galeria_empresa($datos)
	{
		$q="insert into galerias (
				id_empresa,
				descripcion,
				img,
				fecha,
				id_usuario,
				status)
			values(
				'".$datos['id_empresa']."',
				'".$datos['descripcion']."',
				'".$datos['img']."',
				'".$datos['fecha']."',
				'".$datos['id_usuario']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_imagen_galeria_empresa($datos)
	{
		if($datos['opcion'] == '1')
		{
			$q="update galerias set
					descripcion = '".$datos['descripcion']."',
					id_usuario  = '".$datos['id_usuario']."',
					fecha 		= '".$datos['fecha']."'
				where id_galeria = '".$datos['id_galeria']."' ";
		}
		else
		{
			$q="update galerias set
					img 		= '".$datos['img']."',
					descripcion = '".$datos['descripcion']."',
					id_usuario  = '".$datos['id_usuario']."',
					fecha 		= '".$datos['fecha']."'
				where id_galeria = '".$datos['id_galeria']."' ";
		}

		echo $q;

		return $this->db->query($q);
	}

	function eliminar_imagen_galeria_empresa($datos)
	{
		$q="update galerias set
					status 		= '".$datos['status']."',
					id_usuario  = '".$datos['id_usuario']."',
					fecha 		= '".$datos['fecha']."'
				where id_galeria = '".$datos['id_galeria']."'
				and id_empresa   = '".$datos['id_empresa']."' ";

		return $this->db->query($q);
	}



	function obtener_estados()
	{
		$q="SELECT id_estado, nombre_estado FROM cat_estados";
		return $this->db->query($q);
	}

	function obtener_ciudades($datos)
	{
		if($datos['id_estado'] != '')
		{
			$filtro = " WHERE id_estado = '".$datos['id_estado']."' ";
		}

		$q="SELECT id_ciudad, nombre_ciudad FROM cat_ciudades ".$filtro;
		return $this->db->query($q);
	}

	function obtener_categorias_productos()
	{
		$q="select id_categoria, nombre_categoria from cat_categorias where status = 'A'";
		return $this->db->query($q);
	}

	function obtener_giros()
	{
		$q="select id_giro, nombre_giro, status from cat_giros where status = 'A' ";
		return $this->db->query($q);
	}

	function registrar_giro($datos)	
	{
		$q="INSERT INTO cat_giros(
			nombre_giro,
			fecha, 
			id_usuario, 
			status)
			VALUES(
			'".$datos['nombre_giro']."',
			'".$datos['fecha']."',
			'".$datos['id_usuario']."',
			'".$datos['status']."')"; 
		return $this->db->query($q);
	}

	function actualizar_giro($datos)
	{
		$q="UPDATE cat_giros SET 
				nombre_giro = '".$datos['nombre_giro']."', 
				fecha 		= '".$datos['fecha']."', 
				id_usuario 	= '".$datos['id_usuario']."', 
				status  	= '".$datos['status']."' 
			WHERE id_giro = '".$datos['id_giro']."'"; 
		return $this->db->query($q);
	}

	function obtener_giro($datos)
	{
		$q="select id_giro, nombre_giro, status from cat_giros where id_giro = '".$datos['id_giro']."' ";
		return $this->db->query($q);
	}



	function obtener_subgiros($datos)
	{
		if($datos['id_giro'] != '')
		{
			$filtro = " WHERE id_giro = '".$datos['id_giro']."' ";
		}

		$q="select id_subgiro, nombre_subgiro from cat_subgiros ".$filtro;
		return $this->db->query($q);
	}

	function obtener_redes_sociales($datos)
	{
		$q="select
				facebook,
				twitter,
				linkedin,
				youtube,
				google_plus,
				pinterest,
				skype,
				blogger
		 from redes_sociales
		 where id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function registrar_redes_sociales($datos)
	{
		$q="INSERT INTO redes_sociales (
				id_empresa,
				facebook,
				twitter,
				linkedin,
				youtube,
				google_plus,
				pinterest,
				skype,
				blogger,
				fecha,
				id_usuario,
				status)
			VALUES(
				'".$datos['id_empresa']."',
				'".$datos['facebook']."',
				'".$datos['twitter']."',
				'".$datos['linkedin']."',
				'".$datos['youtube']."',
				'".$datos['google_plus']."',
				'".$datos['pinterest']."',
				'".$datos['skype']."',
				'".$datos['blogger']."',
				'".$datos['fecha']."',
				'".$datos['id_usuario']."',
				'".$datos['status']."') ";
		return $this->db->query($q);
	}

	function actualizar_redes_sociales($datos)
	{
		$q="update redes_sociales set
				facebook 	= '".$datos['facebook']."',
				twitter 	= '".$datos['twitter']."',
				linkedin 	= '".$datos['linkedin']."',
				youtube 	= '".$datos['youtube']."',
				google_plus = '".$datos['google_plus']."',
				pinterest 	= '".$datos['pinterest']."',
				skype 		= '".$datos['skype']."',
				blogger 	= '".$datos['blogger']."',
				fecha 	    = '".$datos['fecha']."',
				id_usuario  = '".$datos['id_usuario']."'
			where id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function obtener_mensajes_empresa($datos)
	{
		$q="select
				id_mensaje,
				nombre,
				correo,
				mensaje,
				fecha_envio,
				ip,
				nav,
				status
			from mensajes
			where id_empresa = '".$datos['id_empresa']."'			
			order by id_mensaje desc";
		return $this->db->query($q);
	}

	function obtener_mensajes_nuevos_empresa($datos)
	{
		$q="select count(*) as num_mensajes
			from mensajes
			where id_empresa = '".$datos['id_empresa']."'
			and status = 'E'
			order by id_mensaje desc";
		return $this->db->query($q);
	}



	function obtener_detalles_mensaje_ID($datos)
	{
		$q="select
				a.id_mensaje,
				a.nombre,
				a.correo,
				a.mensaje,
				a.fecha_envio,
				a.ip,
				a.nav,
				a.status,
				b.id_empresa
			from mensajes a
			left join empresas b on a.id_usuario_envia = b.id_usuario
			where a.id_mensaje = '".$datos['id_mensaje']."'
			and a.id_empresa = '".$datos['id_empresa']."'
			and a.status != 'C'
			 ";
		return $this->db->query($q);
	}

	function marcar_visto_mensaje($datos)
	{
		$q="update mensajes set
				status  = '".$datos['status']."'
			where id_mensaje = '".$datos['id_mensaje']."'
			and id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function eliminar_mensaje_empresa($datos)
	{
		$q="update mensajes set
				status  = '".$datos['status']."'
			where id_mensaje = '".$datos['id_mensaje']."'
			and id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function registrar_mensaje_empresa($datos)
	{
		$q="INSERT INTO mensajes(
				id_empresa,
				nombre,
				correo,
				mensaje,
				fecha_envio,
				ip,
				nav,
				id_usuario_envia,
				status)
			VALUES(
			'".$datos['id_empresa']."',
			'".$datos['nombre']."',
			'".$datos['correo']."',
			'".$datos['mensaje']."',
			'".$datos['fecha_envio']."',
			'".$datos['ip']."',
			'".$datos['nav']."',
			'".$datos['id_usuario']."',
			'".$datos['status']."') ";
		return $this->db->query($q);
	}

	function obtener_visitas_empresa($datos)
	{
		$q = "select visitas from empresas where id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function actualizar_visitas_empresa($datos)
	{
		$q = "update empresas set visitas = '".$datos['visitas']."' where id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}


	/******************************************************************************
	*
	*   B L O Q U E  D E  P U B L I C A C I O N E S
	*
	********************************************************************************/

	function registrar_publicacion($datos)
	{
		$q="insert into publicaciones(
				id_empresa,
				titulo,
				descripcion,
				img,
				fecha_c,
				fecha_m,
				fecha_p,
				num_likes,
				num_comentarios,
				num_visitas,
				id_usuario,
				status)
			VALUES(
			'".$datos['id_empresa']."',
			'".$datos['titulo']."',
			'".$datos['descripcion']."',
			'".$datos['img']."',
			'".$datos['fecha_c']."',
			'".$datos['fecha_m']."',
			'".$datos['fecha_p']."',
			'".$datos['num_likes']."',
			'".$datos['num_comentarios']."',
			'".$datos['num_visitas']."',
			'".$datos['id_usuario']."',
			'".$datos['status']."') ";
		return $this->db->query($q);
	}

	function actualizar_publicacion($datos)
	{
		$q="update  publicaciones set
				titulo 			= '".$datos['titulo']."',
				descripcion 	= '".$datos['descripcion']."',
				fecha_m 		= '".$datos['fecha_m']."',
				fecha_p 		= '".$datos['fecha_p']."',
				id_usuario 		= '".$datos['id_usuario']."',
				status 			= '".$datos['status']."'
			where id_publicacion = '".$datos['id_publicacion']."'
			and id_empresa = '".$datos['id_empresa']."'";

		return $this->db->query($q);
	}


	function listado_publicaciones_empresa($datos)
	{
		$q="SELECT
				a.id_publicacion,
				a.id_empresa,
				a.titulo,
				a.descripcion,
				a.img,
				a.fecha_c,
				a.fecha_m,
				a.fecha_p,
				a.num_likes,
				a.num_comentarios,
				a.num_visitas,
				a.id_usuario,
				b.nombre,
				b.apellidos
			FROM publicaciones a
			INNER JOIN usuarios b ON a.id_usuario = b.id_usuario
			WHERE a.id_empresa = '".$datos['id_empresa']."'
			AND (a.status = 'A' OR a.status = 'P' )
			order by a.id_publicacion desc";
		return $this->db->query($q);
	}

	function listado_publicaciones_portada()
	{
		$q="SELECT
				a.id_publicacion,
				a.id_empresa,
				a.titulo,
				a.descripcion,
				a.img,
				a.fecha_c,
				a.fecha_m,
				a.fecha_p,
				a.num_likes,
				a.num_comentarios,
				a.num_visitas,
				a.id_usuario,
				b.nombre,
				b.apellidos
			FROM publicaciones a
			INNER JOIN usuarios b ON a.id_usuario = b.id_usuario
			WHERE a.id_empresa = '1'
			AND   a.status = 'A'
			order by a.id_publicacion desc
			LIMIT 0,3";
		return $this->db->query($q);
	}

	function obtener_publicacion_ID($datos)
	{
		$q="SELECT
				a.id_publicacion,
				a.id_empresa,
				a.titulo,
				a.descripcion,
				a.img,
				a.fecha_c,
				a.fecha_m,
				a.fecha_p,
				a.num_likes,
				a.num_comentarios,
				a.num_visitas,
				a.status,
				a.id_usuario,
				b.nombre,
				b.apellidos
			FROM publicaciones a
			INNER JOIN usuarios b ON a.id_usuario = b.id_usuario
			WHERE id_publicacion = '".$datos['id_publicacion']."' ";
		return $this->db->query($q);
	}

	function actualizar_visitas_publicacion($datos)
	{
		$q="update publicaciones set num_visitas = '".$datos['num_visitas']."' where id_publicacion = '".$datos['id_publicacion']."' ";
		return $this->db->query($q);
	}

	function actualizar_like_publicacion($datos)
	{
		$q="update publicaciones set num_likes = '".$datos['num_likes']."' where id_publicacion = '".$datos['id_publicacion']."' ";
		return $this->db->query($q);
	}

	function actualizar_comentarios_publicacion($datos)
	{
		$q="update publicaciones set num_comentarios = '".$datos['num_comentarios']."' where id_publicacion = '".$datos['id_publicacion']."' ";
		return $this->db->query($q);
	}

	function actualizar_imagen_publicacion($datos)
	{
		$q="update  publicaciones set
				img 			= '".$datos['img']."',
				fecha_m 		= '".$datos['fecha_m']."'
			where id_publicacion= '".$datos['id_publicacion']."'
			and id_empresa 		= '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function eliminar_publicacion_empresa($datos)
	{
		$q="update  publicaciones set
				status 			= '".$datos['status']."',
				fecha_m 		= '".$datos['fecha_m']."'
			where id_publicacion= '".$datos['id_publicacion']."'
			and id_empresa 		= '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function registrar_empresa_favorita($datos)
	{
		$q="INSERT INTO empresas_favoritas (
				id_empresa,
				id_usuario,
				fecha,
				status)
				VALUES(
				'".$datos['id_empresa']."',
				'".$datos['id_usuario']."',
				'".$datos['fecha']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function eliminar_empresa_favorita($datos)
	{
		$q="DELETE FROM empresas_favoritas
			WHERE id_empresa = '".$datos['id_empresa']."'
			AND id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}


	function count_listado_contactos($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								celular LIKE '%".$datos['consulta']."%'  OR
								correo   LIKE '%".$datos['consulta']."%'  OR
								detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM contactos
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND status = 'A'";
		return $this->db->query($q);
	}

	function listado_contactos($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								a.celular LIKE '%".$datos['consulta']."%'  OR
								a.correo   LIKE '%".$datos['consulta']."%'  OR
								a.detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}


		$q="SELECT
				a.id_contacto,
				a.nombre_completo,
				a.empresa,
				a.celular,
				a.correo,
				a.domicilio,
				a.detalles,
				a.avatar,
				b.tipo_contacto
			FROM contactos 	a
			INNER JOIN cat_tipo_contacto b ON a.id_tipo_contacto = b.id_tipo_contacto
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND a.status = 'A'
			Order by a.nombre_completo
			".$datos['limit'];
		return $this->db->query($q);
	}

	function obterner_contacto_ID($datos)
	{
		$q="SELECT
				id_tipo_contacto,
				id_contacto,
				nombre_completo,
				celular,
				correo,
				domicilio,
				empresa,
				detalles,
				avatar
			FROM contactos
			WHERE id_contacto = '".$datos['id_contacto']."'
			AND id_usuario_raiz = '".$datos['id_usuario']."' ";
		return $this->db->query($q);
	}

	function registrar_contacto($datos)
	{
		$q="INSERT INTO contactos(
				id_tipo_contacto,
				id_usuario,
				nombre_completo,
				empresa,
				celular,
				correo,
				domicilio,
				sexo,
				detalles,
				avatar,
				fecha,
				id_usuario_raiz,
				id_padre,
				status)
			VALUES(
			'".$datos['id_tipo_contacto']."',
			'".$datos['id_usuario']."',
			'".$datos['nombre_completo']."',
			'".$datos['empresa']."',
			'".$datos['celular']."',
			'".$datos['correo']."',
			'".$datos['domicilio']."',
			'".$datos['sexo']."',
			'".$datos['detalles']."',
			'".$datos['avatar']."',
			'".$datos['fecha']."',
			'".$datos['id_usuario_raiz']."',
			'".$datos['id_padre']."',
			'".$datos['status']."')";
		return $this->db->query($q);
	}

	function obtener_tipos_contactos()
	{
		$q="SELECT id_tipo_contacto, tipo_contacto from cat_tipo_contacto where status = 'A'";
		return $this->db->query($q);
	}

	function actualizar_contacto($datos)
	{
		$q="update contactos set
				nombre_completo = '".$datos['nombre_completo']."',
				empresa 		= '".$datos['empresa']."',
				celular 		= '".$datos['celular']."',
				correo 			= '".$datos['correo']."',
				domicilio 		= '".$datos['domicilio']."',
				detalles 		= '".$datos['detalles']."',
				fecha 			= '".$datos['fecha']."',
				id_usuario 		= '".$datos['id_usuario']."'
			WHERE id_contacto   = '".$datos['id_contacto']."' ";
		return $this->db->query($q);
	}

	function eliminar_contacto($datos)
	{
		$q="update contactos set
				status 		= '".$datos['status']."',
				fecha 		= '".$datos['fecha']."',
				id_usuario 	= '".$datos['id_usuario']."'
			WHERE id_contacto   = '".$datos['id_contacto']."' ";
		//echo $q; 
		return $this->db->query($q);
	}

	function count_listado_usuarios_admin($datos)
	{
		$q="SELECT count(*) as num_row FROM usuarios ";
		return $this->db->query($q);
	}

	function listado_usuarios_admin($datos)
	{
		$q="SELECT
				id_usuario,
				id_tipo_usuario,
				nombre,
				apellidos,
				bio,
				avatar,
				status
			FROM usuarios
			ORDER BY id_usuario".$datos['limit'];
		return $this->db->query($q);
	}

	function count_obtener_empresas_admin($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['giro'] != '')
		{
			$filtro .= " AND (	c.nombre_giro  LIKE '%".$datos['giro']."%' ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM empresas a
			LEFT JOIN cat_giros          c ON a.id_giro = c.id_giro
			".$filtro;
		return $this->db->query($q);
	}

	function obtener_empresas_admin($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND  (	a.nombre_empresa      LIKE '%".$datos['consulta']."%'  OR
								a.descripcion LIKE '%".$datos['consulta']."%'  OR
								a.servicios   LIKE '%".$datos['consulta']."%'  OR
								a.sitio_web   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['giro'] != '')
		{
			$filtro .= " AND (	c.nombre_giro  LIKE '%".$datos['giro']."%' ) " ;
		}

		$q="SELECT
				a.id_empresa,
				b.id_empresa as fav,
				a.id_ciudad,
				a.nombre_empresa,
				a.nombre_clave,
				a.descripcion,
				a.servicios,
				a.sitio_web,
				a.logo,
				c.nombre_giro
			FROM empresas a
			LEFT JOIN empresas_favoritas b ON a.id_empresa = b.id_empresa
			LEFT JOIN cat_giros          c ON a.id_giro = c.id_giro
			".$filtro."
			Order by a.id_empresa DESC
			".$datos['limit'];
		return $this->db->query($q);
	}

	function count_obtener_empresas_mexico_admin($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_comercial      LIKE '%".$datos['consulta']."%'  OR
								a.razon_social      	LIKE '%".$datos['consulta']."%'  OR
								a.descripcion_act       LIKE '%".$datos['consulta']."%'  OR
								a.nombre_asentamiento   LIKE '%".$datos['consulta']."%'  OR
								a.nombre_entidad 		LIKE '%".$datos['consulta']."%'  OR
								a.municipio   			LIKE '%".$datos['consulta']."%'  OR
								a.municipio   			LIKE '%".$datos['consulta']."%'  OR
								a.localidad   			LIKE '%".$datos['consulta']."%'  OR
								a.correo   				LIKE '%".$datos['consulta']."%'     ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM empresas_inegi a
			Where a.correo != ''
			".$filtro;
		return $this->db->query($q);
	}

	function obtener_empresas_mexico_admin($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_comercial      LIKE '%".$datos['consulta']."%'  OR
								a.razon_social      	LIKE '%".$datos['consulta']."%'  OR
								a.descripcion_act       LIKE '%".$datos['consulta']."%'  OR
								a.nombre_asentamiento   LIKE '%".$datos['consulta']."%'  OR
								a.nombre_entidad 		LIKE '%".$datos['consulta']."%'  OR
								a.municipio   			LIKE '%".$datos['consulta']."%'  OR
								a.municipio   			LIKE '%".$datos['consulta']."%'  OR
								a.localidad   			LIKE '%".$datos['consulta']."%'  OR
								a.correo   				LIKE '%".$datos['consulta']."%'     ) " ;
		}



		$q="SELECT
				a.id_empresa,
				a.nombre_comercial,
				a.razon_social,
				a.descripcion_act,
				a.num_personas,
				a.tipo_asentamiento,
				a.nombre_asentamiento,
				a.nombre_entidad,
				a.municipio,
				a.localidad,
				a.correo,
				a.sitio_web,
				a.latitud,
				a.longitud,
				a.tipo_establecimiento,
				a.telefono
			FROM empresas_inegi a
			Where a.correo != ''
			Order by a.id_empresa
			".$datos['limit'];
		return $this->db->query($q);
	}

	function obtener_empresas_inegi_completa($datos)
	{
		$q="SELECT
				a.id_empresa,
				a.nombre_comercial,
				a.razon_social,
				a.descripcion_act,
				a.num_personas,
				a.tipo_via,
				a.nombre_via,
				a.numero_exterior,
				a.tipo_asentamiento,
				a.nombre_asentamiento,
				a.codigo_postal,
				a.nombre_entidad,
				a.municipio,
				a.localidad,
				a.correo,
				a.sitio_web,
				a.latitud,
				a.longitud,
				a.tipo_establecimiento,
				a.telefono,
				a.envio_correo,
				a.suscripcion,
				a.status
			FROM empresas_inegi a
			WHERE id_empresa = '".$datos['id_empresa']."'
			";
		return $this->db->query($q);
	}

	function actualizar_detalles_empresa_inegi($datos)
	{
		$q="update empresas_inegi set
				nombre_comercial	= '".$datos['nombre_comercial']."',
				razon_social 		= '".$datos['razon_social']."',
				descripcion_act 	= '".$datos['descripcion_act']."',
				num_personas 		= '".$datos['num_personas']."',
				tipo_via 			= '".$datos['tipo_via']."',
				nombre_via 			= '".$datos['nombre_via']."',
				numero_exterior 	= '".$datos['numero_exterior']."',
				tipo_asentamiento	= '".$datos['tipo_asentamiento']."',
				nombre_asentamiento = '".$datos['nombre_asentamiento']."',
				codigo_postal 		= '".$datos['codigo_postal']."',
				nombre_entidad 		= '".$datos['nombre_entidad']."',
				municipio 			= '".$datos['municipio']."',
				localidad 			= '".$datos['localidad']."',
				correo				= '".$datos['correo']."',
				sitio_web 			= '".$datos['sitio_web']."',
				latitud 			= '".$datos['latitud']."',
				longitud 			= '".$datos['longitud']."',
				tipo_establecimiento= '".$datos['tipo_establecimiento']."',
				telefono 			= '".$datos['telefono']."',
				status 				= '".$datos['status']."'
			WHERE id_empresa = '".$datos['id_empresa']."'";

		return $this->db->query($q);
	}


	function obtener_empresas_mexico_correo($datos)
	{
		$q="SELECT
				a.id_empresa,
				a.razon_social,
				a.estado,
				a.municipio,
				a.colonia,
				a.scian,
				a.giro,
				a.correo,
				a.telefono
			FROM empresas_mexico a
			WHERE envio_correo != 'S'
			AND sucripcion     != 'N'
			Order by a.id_empresa
			LIMIT 0,300";
		return $this->db->query($q);
	}

	function obtener_estadisticas_empresas_mexico()
	{
		$q="SELECT
				(select count(*) FROM empresas_mexico) as num_empresas,
				(select count(*) FROM empresas_mexico where envio_correo = 'S') as num_empresas_correos_enviados,
				(select count(*) FROM empresas_mexico where sucripcion   = 'N') as num_empresas_suscripcion
			FROM empresas_mexico
			LIMIT 0,1";
		return $this->db->query($q);
	}


	function actualizar_correo_enviado_empresa_mexico($datos)
	{
		$q="UPDATE empresas_mexico SET envio_correo = 'S' WHERE id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}

	function actualizar_suscripcion_empresa_mexico($datos)
	{
		$q="UPDATE empresas_mexico SET sucripcion = 'N' WHERE id_empresa = '".$datos['id_empresa']."' ";
		return $this->db->query($q);
	}




	function obtener_estadisticas()
	{
		$q=" SELECT
			(select count(*) from usuarios) as usuarios,
			(select count(*) from productos) as productos,
			(select count(*) from galerias) as galerias,
			(select count(*) from busquedas) as busquedas,
			(select count(*) from contactos) as contactos
		 FROM usuarios where id_usuario = '1'";
		return $this->db->query($q);
	}

	function registrar_visita($datos)
	{
		$q="INSERT INTO visitas(
				seccion,
				src,
				page,
				fecha,
				id_usuario,
				ip,
				nav)
				VALUES(
				'".$datos['seccion']."',
				'".$datos['src']."',
				'".$datos['page']."',
				'".$datos['fecha']."',
				'".$datos['id_usuario']."',
				'".$datos['ip']."',
				'".$datos['nav']."')";
		return $this->db->query($q);
	}

	function registrar_busqueda($datos)
	{
		$q="INSERT INTO busquedas(
				busqueda,
				ip,
				id_usuario,
				fecha,
				navegador)
				VALUES(
				'".$datos['busqueda']."',
				'".$datos['ip']."',
				'".$datos['id_usuario']."',
				'".$datos['fecha']."',
				'".$datos['nav']."')";
		return $this->db->query($q);
	}


	/*************************************************************************************
	*
	*
	*     M O D U L O       D E      I N B O X
	*
	*
	*
	*************************************************************************************/

	function listado_usuarios_inbox($datos)
	{
		$q="SELECT
				u.id_usuario,
				u.nombre,
				u.apellidos,
				u.avatar,
				u.id_tipo_usuario,
				s.id_usuario as id_usuario_session
			FROM usuarios u
			LEFT JOIN session_activa s ON u.id_usuario = s.id_usuario
			AND u.id_usuario != '".$datos['id_usuario']."'
			OR id_tipo_usuario = '2'
			AND u.status = 'A'ORDER BY s.id_usuario  DESC";

		return $this->db->query($q);
	}

	function registrar_inbox($datos)
	{
		$q="INSERT INTO inbox(
			id_usuario_e,
			id_usuario_r,
			mensaje,
			src,
			tamanio,
			tipo_archivo,
			fecha_envio,
			fecha_visto,
			status_m,
			status)
			VALUES(
			'".$datos['id_usuario_e']."',
			'".$datos['id_usuario_r']."',
			'".$datos['mensaje']."',
			'".$datos['src']."',
			'".$datos['tamanio']."',
			'".$datos['tipo_archivo']."',
			'".$datos['fecha_envio']."',
			'".$datos['fecha_mod']."',
			'".$datos['status_m']."',
			'".$datos['status']."')";
		return $this->db->query($q);
	}

	function eliminar_inbox($datos)
	{
		$q="UPDATE inbox SET
				status 		= '".$datos['status']."'
			WHERE id_inbox 	= '".$datos['id_inbox']."' ";
		return $this->db->query($q);
	}

	function marcar_visto_inbox($datos)
	{
		$q="UPDATE inbox SET
				status_m 	= '".$datos['status_m']."',
				fecha_visto = '".$datos['fecha_visto']."'
			WHERE id_inbox 	<= '".$datos['id_inbox']."'
			AND id_usuario_e= '".$datos['id_usuario_e']."'
			AND status_m 	= 'E'";
		//echo $q;
		return $this->db->query($q);
	}

	function listado_inbox_general($datos)
	{
		if($datos['id_usuario_e'] != '')
		{
			$filtro = " AND i.id_usuario_e = '".$datos['id_usuario_e']."' ";
		}

		$q="SELECT
				i.id_inbox,
				i.mensaje,
				i.src,
				i.tamanio,
				i.fecha_envio,
				i.fecha_visto,
				i.status_m,
				i.id_usuario_e 		as id_usuario_envia,
				ue.nombre 	as usuario_envia,
				ue.nombre,
				ue.apellidos,
				ue.avatar  			as avatar_usuario_envia
			FROM inbox i
			INNER JOIN usuarios ue ON i.id_usuario_e = ue.id_usuario
			WHERE i.id_usuario_r = '".$datos['id_usuario_r']."'
			AND i.status = 'A'
			".$filtro."
			ORDER BY i.id_inbox DESC
			".$datos['limit'];

		//echo $q;

		return $this->db->query($q);
	}

	function listado_inbox_enviados_general($datos)
	{

		$q="SELECT
				i.id_inbox,
				i.mensaje,
				i.src,
				i.tamanio,
				i.fecha_envio,
				i.fecha_visto,
				i.status_m,
				i.id_usuario_e 		as id_usuario_envia,
				ue.nombre 			as usuario_envia,
				ue.nombre,
				ue.apellidos,
				ue.avatar  			as avatar_usuario_envia
			FROM inbox i
			INNER JOIN usuarios ue ON i.id_usuario_e = ue.id_usuario
			WHERE i.id_usuario_e = '".$datos['id_usuario_e']."'
			AND i.status = 'A'
			".$filtro."
			ORDER BY i.id_inbox DESC
			".$datos['limit'];

		return $this->db->query($q);
	}

	function listado_inbox_sin_leer_general($datos)
	{
		$q="SELECT
				i.id_inbox,
				i.mensaje,
				i.src,
				i.tamanio,
				i.fecha_envio,
				i.fecha_visto,
				i.status_m,
				i.id_usuario_r,
				i.id_usuario_e 		as id_usuario_envia,
				ue.nombre 	as usuario_envia,
				ue.nombre,
				ue.apellidos,
				ue.avatar  			as avatar_usuario_envia
			FROM inbox i
			INNER JOIN usuarios ue ON i.id_usuario_e = ue.id_usuario
			WHERE i.id_usuario_r = '".$datos['id_usuario_r']."'
			AND i.status = 'A'
			AND i.status_m = 'E'
			AND i.id_inbox > ".$datos['id_inbox_max']."
			".$filtro."
			ORDER BY i.id_inbox
			".$datos['limit'];


		return $this->db->query($q);
	}

	function listado_conversacion_anterior_usuario($datos)
	{
		$q="SELECT
				i.id_inbox,
				i.mensaje,
				i.src,
				i.tamanio,
				i.fecha_envio,
				i.fecha_visto,
				i.status_m,
				i.id_usuario_r,
				i.id_usuario_e 		as id_usuario_envia,
				ue.nombre 			as usuario_envia,
				ue.nombre,
				ue.apellidos,
				ue.avatar  			as avatar_usuario_envia
			FROM inbox i
			INNER JOIN usuarios ue ON i.id_usuario_e = ue.id_usuario
			WHERE ((i.id_usuario_r = '".$datos['id_usuario_r']."' AND i.id_usuario_e = '".$datos['id_usuario_e']."') OR
					(i.id_usuario_r = '".$datos['id_usuario_e']."' AND i.id_usuario_e = '".$datos['id_usuario_r']."')
				  )
			AND i.status = 'A'
			".$filtro."
			ORDER BY i.id_inbox
			";
		//echo $q;

		return $this->db->query($q);
	}

	function count_inbox_general($datos)
	{
		$q="SELECT
				count(*) as num_men
			FROM inbox i
			WHERE i.id_usuario_r = '".$datos['id_usuario_r']."'
			AND i.status_m = 'E'
			AND i.status = 'A'";
		//echo $q;
		return $this->db->query($q);
	}

	function obtener_inbox($datos)
	{
		$q="SELECT
				i.id_inbox,
				i.mensaje,
				i.src,
				i.tamanio,
				i.fecha_envio,
				i.fecha_visto,
				i.status_m,
				ue.nombre as usuario_envia
			FROM inbox i
			INNER JOIN usuarios ue ON i.id_usuario_e = ue.id_usuario
			WHERE i.id_inbox =  '".$datos['id_inbox']."'
			AND i.id_usuario_r = '".$datos['id_usuario_r']."'";

		return $this->db->query($q);
	}

	/***********************************************************************
	*
	* MODULO DE PENDIENTES
	*
	*
	************************************************************************/

	function registrar_pendiente($datos)
	{
		$q="INSERT INTO pendientes (
			descripcion,
			solucion,
			id_usuario_r,
			id_usuario_a,
			fecha_r,
			fecha_a,
			visibilidad,
			status_p,
			status)
			VALUES(
			'".$datos['descripcion']."',
			'".$datos['solucion']."',
			'".$datos['id_usuario_r']."',
			'".$datos['id_usuario_a']."',
			'".$datos['fecha_r']."',
			'".$datos['fecha_a']."',
			'".$datos['visibilidad']."',
			'".$datos['status_p']."',
			'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_pendiente($datos)
	{
		$q="UPDATE pendientes SET
				id_usuario_a 	= '".$datos['id_usuario_a']."',
				fecha_a 		= '".$datos['fecha_a']."',
				status_p 		= '".$datos['status']."'
			where id_pendiente 	= '".$datos['id_pendiente']."'";
		return $this->db->query($q);
	}

	function eliminar_pendiente($datos)
	{
		$q="UPDATE pendientes SET
				status 			= '".$datos['status']."'
			where id_pendiente 	= '".$datos['id_pendiente']."'";
		return $this->db->query($q);
	}

	function buscar_pendiente_general($datos)
	{
		$q="SELECT
				p.id_pendiente,
				p.nombre,
				p.descripcion,
				p.solucion,
				p.fecha_r,
				p.fecha_a,
				p.visibilidad,
				p.status_p,
				ur.nombre,
				ua.nombre
			FROM pendientes p
			INNER JOIN usuarios ur ON p.id_usuario_r = ur.id_usuario
			INNER JOIN usuarios ua ON p.id_usuario_r = ua.id_usuario
			WHERE p.id_pendiente  = '".$datos['id_pendiente']."'
			AND p.status = 'A'";
		return $this->db->query($q);
	}

	function listado_pendientes_general($datos)
	{
		$q="SELECT
				p.id_pendiente,
				p.descripcion,
				p.solucion,
				p.fecha_r,
				p.fecha_a,
				p.visibilidad,
				p.status_p,
				ur.nombre as usuario_registro,
				ua.nombre as usuario_atendio
			FROM pendientes p
			LEFT JOIN usuarios ur ON p.id_usuario_r = ur.id_usuario
			LEFT JOIN usuarios ua ON p.id_usuario_a = ua.id_usuario
			WHERE p.id_usuario_r = '".$datos['id_usuario']."'
			AND p.status = 'A'
			AND p.status_p = '".$datos['status_p']."'
			ORDER BY p.status_p DESC,p.id_pendiente DESC ";
		return $this->db->query($q);
	}

	function count_pendientes($datos)
	{
		$q="SELECT
				count(*) as num_pen
			FROM pendientes p
			LEFT JOIN usuarios ur ON p.id_usuario_r = ur.id_usuario
			LEFT JOIN usuarios ua ON p.id_usuario_a = ua.id_usuario
			WHERE p.id_usuario_r = '".$datos['id_usuario']."'
			AND p.status = 'A'
			AND p.status_p = 'P'
			ORDER BY p.status_p DESC,p.id_pendiente DESC
			".$datos['limit'];
		//echo $q;
		return $this->db->query($q);
	}

	function obtener_pendiente($datos)
	{
		$q="SELECT
				p.id_pendiente,
				p.descripcion,
				p.solucion,
				p.fecha_r,
				p.fecha_a,
				p.visibilidad,
				p.status_p,
				ur.nombre_usuario as usuario_registro,
				ua.nombre_usuario as usuario_atendio
			FROM pendientes p
			LEFT JOIN usuarios ur ON p.id_usuario_r = ur.id_usuario
			LEFT JOIN usuarios ua ON p.id_usuario_a = ua.id_usuario
			WHERE p.id_pendiente = '".$datos['id_pendiente']."'
			AND p.status = 'A'";
		return $this->db->query($q);
	}

	function listado_busquedas_general()
	{
		$q="SELECT
				id_busqueda,
				busqueda,
				ip,
				fecha,
				navegador
			FROM busquedas
			ORDER BY id_busqueda DESC";
		return $this->db->query($q);
	}


	function obtener_datos_generales()
    {
    	$fecha_p = date("Y-m-d H:i:s",time());
    	$q="SELECT
    			(select count(*) from contenido where status = 'A' and visibilidad = 'P') as num_con,
    			(select count(*) from usuarios where status = 'A') as num_user,
    			(select count(*) from comentarios where status = 'A') as num_comm,
    			(select count(*) from session_activa) as num_online,
    			(select count(*) from contenido WHERE status = 'A' AND fecha_p > '".$fecha_p."') as num_pub_pen,
                (select count(*) from contenido WHERE status = 'P' AND id_usuario ='1') as send_post
    		FROM usuarios
    		LIMIT 0,1";
    	return $this->db->query($q);
    }

    function obtener_grafica_7_dias()
    {
    	$q="SELECT
    				DATE(fecha) as fecha,
    				count(*) as num_visitas
    		FROM visitas
    		GROUP BY DATE(fecha)
    		ORDER BY DATE(fecha) DESC
    		LIMIT 0,7";
    	return $this->db->query($q);

    }

    function obtener_grafica_visitas_general($datos)
    {
        if($datos['anio'] != '')
        {
            $anio = $datos['anio'];
        }
        $q = "SELECT
                (select count(*) from visitas WHERE fecha >= '".$anio."-01-01 00:00:00' AND fecha <= '".$anio."-01-31 23:59:59' ) as enero,
                (select count(*) from visitas WHERE fecha >= '".$anio."-02-01 00:00:00' AND fecha <= '".$anio."-02-28 23:59:59' ) as febrero,
                (select count(*) from visitas WHERE fecha >= '".$anio."-03-01 00:00:00' AND fecha <= '".$anio."-03-31 23:59:59' ) as marzo,
                (select count(*) from visitas WHERE fecha >= '".$anio."-04-01 00:00:00' AND fecha <= '".$anio."-04-30 23:59:59' ) as abril,
                (select count(*) from visitas WHERE fecha >= '".$anio."-05-01 00:00:00' AND fecha <= '".$anio."-05-31 23:59:59' ) as mayo,
                (select count(*) from visitas WHERE fecha >= '".$anio."-06-01 00:00:00' AND fecha <= '".$anio."-06-30 23:59:59' ) as junio,
                (select count(*) from visitas WHERE fecha >= '".$anio."-07-01 00:00:00' AND fecha <= '".$anio."-07-31 23:59:59' ) as julio,
                (select count(*) from visitas WHERE fecha >= '".$anio."-08-01 00:00:00' AND fecha <= '".$anio."-08-31 23:59:59' ) as agosto,
                (select count(*) from visitas WHERE fecha >= '".$anio."-09-01 00:00:00' AND fecha <= '".$anio."-09-30 23:59:59' ) as septiembre,
                (select count(*) from visitas WHERE fecha >= '".$anio."-10-01 00:00:00' AND fecha <= '".$anio."-10-31 23:59:59' ) as octubre,
                (select count(*) from visitas WHERE fecha >= '".$anio."-11-01 00:00:00' AND fecha <= '".$anio."-11-30 23:59:59' ) as noviembre,
                (select count(*) from visitas WHERE fecha >= '".$anio."-12-01 00:00:00' AND fecha <= '".$anio."-12-31 23:59:59' ) as diciembre
            FROM visitas
            LIMIT 0,1";
        return $this->db->query($q);
    }

    function obtener_visitas_ip($datos)
    {
        $q="SELECT
                v.ip,
                count(*) as num_vis
            FROM visitas v
            WHERE DATE(v.fecha) = '".$datos['fecha']."'
            ORDER BY num_vis DESC ";
        return $this->db->query($q);
    }

    function listado_visitas_general()
	{
		$q="SELECT
			count(*) as visitas
			FROM visitas
			";
		return $this->db->query($q);
	}

	function listado_paginas_visitados($datos)
	{
		$q="SELECT
				v.page,
				u.nombre as nombre_usuario,
				v.fecha,
				v.nav,
				v.ip
			FROM visitas v
			LEFT JOIN usuarios u ON u.id_usuario = v.id_usuario
			WHERE DATE(v.fecha) = '".$datos['fecha']."'
                        AND v.nav NOT LIKE '%google%'
                        AND v.nav NOT LIKE '%bing%'
                        AND v.nav NOT LIKE '%baidu%'
                        AND v.nav NOT LIKE '%yandex%'
			ORDER BY id_visita DESC";
		return $this->db->query($q);
	}

function obtener_datos_empresa_calculo_peso($datos)
	{
		$q="SELECT
				a.id_empresa,
				a.id_estado,
				a.id_ciudad,
				a.id_giro,
				a.id_subgiro,
				a.nombre_empresa,
				a.nombre_clave,
				a.direccion,
				a.descripcion,
				a.servicios,
				a.direccion,
				a.telefono,
				a.correo,
				a.rfc,
				a.sitio_web,
				a.logo,
				a.informacion,
				a.visitas,
				a.lat,
				(select count(*) from productos where id_empresa = a.id_empresa and status = 'A') as num_productos,
				b.facebook,
				b.twitter,
				b.youtube
			FROM empresas a
			LEFT JOIN redes_sociales b ON a.id_empresa = b.id_empresa
			WHERE a.id_empresa = '".$datos['id_empresa']."'";
		return $this->db->query($q);
	}

	function listado_empresas_total()
	{
		$q="select id_empresa FROM empresas where sitio_web != ''";
		return $this->db->query($q);
	}

	function actualizar_peso_empresa($datos)
	{
		$q="UPDATE empresas set peso = '".$datos['peso']."' where id_empresa = '".$datos['id_empresa']."'";		
		return $this->db->query($q);
	}


	/***********************************************************************
	*
	* MODULO DE RANKING
	*
	*
	************************************************************************/



	function registrar_ranking($datos)
    {
        $q="INSERT INTO empresa_ranking (
            id_empresa,
            calificacion,
            id_usuario,
            ip,
            fecha)
            VALUES(
            '".$datos['id_empresa']."',
            '".$datos['calificacion']."',
            '".$datos['id_usuario']."',
            '".$datos['ip']."',
            '".$datos['fecha']."')";
        return $this->db->query($q);
    }

    function actualizar_ranking($datos)
    {
        $q="UPDATE empresa_ranking SET
                calificacion = '".$datos['calificacion']."'
            WHERE id_empresa = '".$datos['id_empresa']."'
            ÁND id_usuario = '".$datos['id_usuario']."'";
        return $this->db->query($q);
    }

    function obtener_ranking_empresa($datos)
    {
        $q="SELECT
                SUM(calificacion) as ranking
            FROM empresa_ranking
            WHERE id_empresa = '".$datos['id_empresa']."'";
        return $this->db->query($q);
    }

    function actualizar_ranking_empresa($datos)
    {
        $q="UPDATE empresas SET ranking = '".$datos['ranking']."' WHERE id_empresa = '".$datos['id_empresa']."'";
        return $this->db->query($q);
    }

    function validar_calificacion_ranking($datos)
    {
        $q="SELECT 1 FROM empresa_ranking
        WHERE id_empresa = '".$datos['id_empresa']."'
        AND id_usuario = '".$datos['id_usuario']."' ";
        return $this->db->query($q);
    }

    function obtener_modulos()
    {
    	$q="SELECT
    			id_modulo,
    			nombre_modulo,
    			descripcion,
    			icon,
    			tipo_membresia,
    			precio,
    			metodo_pago
    		FROM modulos
    		WHERE status = 'A' ";
    	return $this->db->query($q);
    }

    function validar_modulo_usuario($datos)
    {
    	$q="SELECT 1 FROM
    		usuarios_modulos
    		WHERE id_usuario = '".$datos['id_usuario']."'
    		AND id_modulo = '".$datos['id_modulo']."'";
    	return $this->db->query($q);
    }


    function count_listado_contactos_amway($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								celular LIKE '%".$datos['consulta']."%'  OR
								correo   LIKE '%".$datos['consulta']."%'  OR
								detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM contactos
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND status = 'A'";
		return $this->db->query($q);
	}

	function listado_contactos_amway($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								a.celular LIKE '%".$datos['consulta']."%'  OR
								a.correo   LIKE '%".$datos['consulta']."%'  OR
								a.detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}


		$q="SELECT
				a.id_contacto,
				a.nombre_completo,
				a.empresa,
				a.celular,
				a.correo,
				a.domicilio,
				a.detalles,
				a.avatar,
				b.tipo_contacto,
				c.paso_1,
				c.paso_2,
				c.paso_3,
				c.paso_4,
				c.paso_5,
				c.paso_6,
				c.paso_7,
				c.paso_8,
				c.paso_9
			FROM contactos 	a
			INNER JOIN cat_tipo_contacto b ON a.id_tipo_contacto = b.id_tipo_contacto
			INNER JOIN am_avance_etapas_contactos c ON c.id_contacto = a.id_contacto
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND a.status = 'A'
			Order by a.nombre_completo
			".$datos['limit'];

		return $this->db->query($q);
		//(select count(*) from am_comentarios_contacto where id_contacto = a.id_contacto and status = 'A') as num_comentarios
	}



    function registrar_usuario_modulo($datos)
    {
    	$q="INSERT INTO usuarios_modulos(
    		id_usuario,
    		id_modulo,
    		fecha,
    		status)
    		VALUES(
    		'".$datos['id_usuario']."',
    		'".$datos['id_modulo']."',
    		'".$datos['fecha']."',
    		'".$datos['status']."') ";

    	return $this->db->query($q);
    }

    function valida_avance_contacto($datos)
    {
    	$q="SELECT 1 FROM
    		am_avance_etapas_contactos
    		WHERE id_usuario = '".$datos['id_usuario']."'
    		AND id_contacto = '".$datos['id_contacto']."'";
    	return $this->db->query($q);
    }

    function registrar_avance_etapa_contacto($datos)
    {
    	$q="INSERT INTO am_avance_etapas_contactos(
    			id_contacto,
    			paso_1,
    			paso_2,
    			paso_3,
    			paso_4,
    			paso_5,
    			paso_6,
    			paso_7,
    			paso_8,
    			paso_9,
    			paso_10,
    			fecha,
    			id_usuario) VALUES(
    			'".$datos['id_contacto']."',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'N',
    			'".$datos['fecha']."',
    			'".$datos['id_usuario']."')";
    		return $this->db->query($q);
    }

    function actualizar_avance_etapa_contacto($datos)
    {
    	$q="UPDATE am_avance_etapas_contactos SET
    			paso_".$datos['id_paso']." = '".$datos['opcion']."',
    			fecha 						 = '".$datos['fecha']."'
    		WHERE id_contacto = '".$datos['id_contacto']."'
    		AND id_usuario = '".$datos['id_usuario']."' ";
    	return $this->db->query($q);
    }

    function actualizar_avance_etapa_contacto_completo($datos)
    {
    	$q="UPDATE am_avance_etapas_contactos SET
    			paso_1 = '".$datos['opcion']."',
    			paso_2 = '".$datos['opcion']."',
    			paso_3 = '".$datos['opcion']."',
    			paso_4 = '".$datos['opcion']."',
    			paso_5 = '".$datos['opcion']."',
    			paso_6 = '".$datos['opcion']."',
    			paso_7 = '".$datos['opcion']."',
    			paso_8 = '".$datos['opcion']."',
    			paso_9 = '".$datos['opcion']."',
    			fecha  = '".$datos['fecha']."'
    		WHERE id_contacto = '".$datos['id_contacto']."'
    		AND id_usuario = '".$datos['id_usuario']."' ";
    	return $this->db->query($q);
    }

    function registrar_comentario_contacto($datos)
    {
    	$q="INSERT INTO am_comentarios_contacto (
    			id_contacto,
    			comentario,
    			id_usuario,
    			fecha,
    			status)
    		VALUES(
    			'".$datos['id_contacto']."',
    			'".$datos['comentario']."',
    			'".$datos['id_usuario']."',
    			'".$datos['fecha']."',
    			'".$datos['status']."')";
    	return $this->db->query($q);
    }

    function actualizar_comentario_contacto($datos)
    {
    	$q="UPDATE am_comentarios_contacto SET
    			comentario 	= '".$datos['comentario']."',
    			fecha  		= '".$datos['fecha']."'
    	WHERE id_contacto = '".$datos['id_contacto']."'";
    	return $this->db->query($q);
    }

    function obtener_comentarios_contacto_id($datos)
    {
    	$q="SELECT
    			id_comentario_contacto,
    			comentario,
    			fecha
    		FROM am_comentarios_contacto
    		WHERE id_contacto  = '".$datos['id_contacto']."'
    		AND id_usuario = '".$datos['id_usuario']."'
    		AND status = 'A'";
    	return $this->db->query($q);
    }

    function eliminar_comentario_contacto($datos)
    {
    	$q="UPDATE am_comentarios_contacto SET
    			status = '".$datos['status']."',
    			fecha  = '".$datos['fecha']."'
    		WHERE id_contacto  = '".$datos['id_contacto']."'
    		AND id_usuario     = '".$datos['id_usuario']."'  ";
    	return $this->db->query($q);
    }

    function listado_periodos_disponibles($datos)
	{
		$q="SELECT
				p.id_periodo,
				p.periodo,
				(	SELECT 1 FROM citas
					WHERE fecha 		= '".$datos['fecha']."'
					AND id_usuario     = '".$datos['id_usuario']."'
					AND id_periodo     = p.id_periodo LIMIT 0,1) as cita
			FROM periodos p
			WHERE p.status = 'A'";
		return $this->db->query($q);
	}

	function registrar_cita($datos)
	{
		$q="INSERT INTO citas(
			id_usuario,
			id_modulo, 
			id_contacto,
			id_periodo,
			fecha,
			descripcion,
			fecha_agenda,
			color,
			status)
			VALUES(
				'".$datos['id_usuario']."',
				'".$datos['id_modulo']."',
				'".$datos['id_contacto']."',
				'".$datos['id_periodo']."',
				'".$datos['fecha']."',
				'".$datos['descripcion']."',
				'".$datos['fecha_agenda']."',
				'".$datos['color']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_cita($datos)
	{
		$q="UPDATE citas SET
				id_usuario 		= '".$datos['id_usuario']."',
				id_contacto 	= '".$datos['id_contacto']."',
				id_periodo 		= '".$datos['id_periodo']."',
				fecha 			= '".$datos['fecha']."',
				descripcion 	= '".$datos['descripcion']."',
				fecha_agenda 	= '".$datos['fecha_agenda']."',
				color 			= '".$datos['color']."'
			WHERE  id_cita = '".$datos['id_cita']."' ";
		return $this->db->query($q);
	}

	function listado_citas_semana($datos)
	{
		if($datos['id_contacto'] != '')
		{
			$filtro = " AND c.id_contacto = '".$datos['id_contacto']."' "; 
		}

		$q="SELECT
				c.id_cita,
				c.id_usuario,
				c.id_contacto,
				c.id_periodo,
				c.fecha,
				c.descripcion,
				c.fecha_agenda,
				c.color,
				c.status,
				p.nombre_completo,
				p.avatar,
				u.nombre as nombre,
				u.apellidos as apellidos,
				pe.periodo
			FROM citas c
			LEFT JOIN contactos p  ON c.id_contacto = p.id_contacto
			LEFT JOIN usuarios  u  ON c.id_usuario  = u.id_usuario
			INNER JOIN periodos  pe ON c.id_periodo = pe.id_periodo
			WHERE c.id_usuario = '".$datos['id_usuario']."'
			AND c.fecha >= '".$datos['fecha_inicio']."'			
			AND c.status = 'A'
			AND c.id_modulo = '".$datos['id_modulo']."'
			".$filtro."
			ORDER BY c.fecha, c.id_periodo";						
		return $this->db->query($q);
	}

	function listado_citas_contacto($datos)
	{
		$q="SELECT
				c.id_cita,
				c.id_usuario,
				c.id_contacto,
				c.id_periodo,
				c.fecha,
				c.descripcion,
				c.fecha_agenda,
				c.color,
				c.status,
				p.nombre_completo,
				p.avatar,
				u.nombre as nombre,
				u.apellidos as apellidos,
				pe.periodo
			FROM citas c
			LEFT JOIN contactos p  ON c.id_contacto = p.id_contacto
			LEFT JOIN usuarios  u  ON c.id_usuario  = u.id_usuario
			INNER JOIN periodos  pe ON c.id_periodo = pe.id_periodo
			WHERE c.id_usuario = '".$datos['id_usuario']."'			
			AND c.status = 'A'
			AND c.id_contacto = '".$datos['id_contacto']."'
			ORDER BY c.fecha, c.id_periodo";		
		return $this->db->query($q);
	}

	function obtener_listado_periodos($datos)
	{
		$q="SELECT
				id_periodo,
				periodo
			FROM periodos
			WHERE status = 'A'";
		return $this->db->query($q);
	}

	function eliminar_cita($datos)
	{
		$q="UPDATE citas SET
				status = '".$datos['status']."'
			WHERE id_cita = '".$datos['id_cita']."'";
		return $this->db->query($q);
	}

	function listado_usuarios_multinivel($datos)
	{
		$q="SELECT
				a.id_usuario,
				a.id_tipo_usuario,
				a.nombre,
				a.apellidos,
				a.bio,
				a.avatar,
				a.status
			FROM usuarios a
			INNER JOIN usuarios_modulos b ON a.id_usuario = b.id_usuario";
		return $this->db->query($q);
	}

	function count_listado_contactos_reddental($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								celular LIKE '%".$datos['consulta']."%'  OR
								correo   LIKE '%".$datos['consulta']."%'  OR
								detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}

		$q="SELECT count(*) as num_row
			FROM contactos
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND id_tipo_contacto = '6'
			AND status = 'A'";
		return $this->db->query($q);
	}

	function listado_contactos_redental($datos)
	{
		if($datos['consulta'] != '')
		{
			$filtro = " AND (	a.nombre_completo      LIKE '%".$datos['consulta']."%'  OR
								a.celular LIKE '%".$datos['consulta']."%'  OR
								a.correo   LIKE '%".$datos['consulta']."%'  OR
								a.detalles   LIKE '%".$datos['consulta']."%'     ) " ;
		}

		if($datos['letra'] != '')
		{
			$filtro = " and (	nombre_completo      LIKE '".$datos['letra']."%' ) " ;
		}


		$q="SELECT
				a.id_contacto,
				a.nombre_completo,
				a.empresa,
				a.celular,
				a.correo,
				a.domicilio,
				a.detalles,
				a.avatar,
				b.tipo_contacto
			FROM contactos 	a
			INNER JOIN cat_tipo_contacto b ON a.id_tipo_contacto = b.id_tipo_contacto
			WHERE id_usuario_raiz = '".$datos['id_usuario']."'
			".$filtro."
			AND a.id_tipo_contacto = '6'
			AND a.status = 'A'
			Order by a.nombre_completo
			".$datos['limit'];

		return $this->db->query($q);
	}

	function listado_servicios_clinica($datos)
	{
		$q="SELECT
				sc.id_servicio,
				sc.nombre_servicio,
				sc.descripcion,
				sc.precio_normal,
				u.nombre,
				u.apellidos
			FROM rd_servicios sc
			LEFT JOIN usuarios u ON sc.id_usuario = u.id_usuario
			WHERE (sc.id_usuario = '".$datos['id_usuario']."')
			AND sc.status = 'A'";
		return $this->db->query($q);
	}

	function registrar_servicio_clinica($datos)
	{
		$q="INSERT INTO rd_servicios(
				nombre_servicio,
				descripcion,
				precio_normal,
				fecha,
				id_usuario,
				status)
			VALUES(
				'".$datos['nombre_servicio']."',
				'".$datos['descripcion']."',
				'".$datos['precio_normal']."',
				'".$datos['fecha']."',
				'".$datos['id_usuario']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_servicio_clinica($datos)
	{
		$q="UPDATE rd_servicios SET
				nombre_servicio = '".$datos['nombre_servicio']."',
				descripcion 	= '".$datos['descripcion']."',
				precio_normal 	= '".$datos['precio_normal']."',
				fecha 			= '".$datos['fecha']."',
				id_usuario 		= '".$datos['id_usuario']."'
			WHERE id_servicio = '".$datos['id_servicio']."'";
		return $this->db->query($q);
	}

	function eliminar_servicio_clinica($datos)
	{
		$q="UPDATE rd_servicios SET
				status 			= '".$datos['status']."',
				fecha 			= '".$datos['fecha']."',
				id_usuario 		= '".$datos['id_usuario']."'
			WHERE id_servicio = '".$datos['id_servicio']."'";
		return $this->db->query($q);
	}


	function obtener_servicio($datos)
	{
		$q="SELECT
				id_servicio,
				nombre_servicio,
				descripcion,
				precio_normal
			FROM rd_servicios
			WHERE id_servicio = '".$datos['id_servicio']."'
			AND status = 'A'";
		return $this->db->query($q);
	}

	function count_listado_medicamentos_general($datos)
	{
		if($datos['consulta']!='')
		{
			$filtro =  " AND (m.nombre_medicamento LIKE '%".$datos['consulta']."%') ";
		}

		if($datos['tipo'] != '')
		{
			$filtro .= " AND tipo_medicamento = '".$datos['tipo']."' " ;
		}

		$q="SELECT count(*) as num_row
		FROM medicamentos m
		WHERE m.status = 'A'
		AND ( tipo_medicamento = 'A' OR id_usuario = '".$datos['id_usuario']."')
		".$filtro;

		return $this->db->query($q);
	}

	function listado_medicamentos_general($datos)
	{
		if($datos['consulta']!='')
		{
			$filtro =  " AND (m.nombre_medicamento LIKE '%".$datos['consulta']."%') ";
		}

		if($datos['tipo'] != '')
		{
			$filtro .= " AND tipo_medicamento = '".$datos['tipo']."' " ;
		}

		$q="SELECT
			m.id_medicamento,
			m.nivel,
			m.codigo,
			m.nombre_medicamento,
			m.descripcion,
			m.cantidad,
			m.presentacion,
			m.fecha_ult_mod,
			m.id_usuario,
			m.tipo_medicamento,
			m.status
		FROM medicamentos m
		WHERE m.status = 'A'
		AND ( tipo_medicamento = 'A' OR id_usuario = '".$datos['id_usuario']."')
		".$filtro.$datos['limit'];

		return $this->db->query($q);
	}

	function registrar_medicamento_clinica($datos)
	{
		$q="INSERT INTO medicamentos (
		id_grupo_med,
		nivel,
		codigo,
		nombre_medicamento,
		descripcion,
		cantidad,
		presentacion,
		fecha_ult_mod,
		comentario,
		tipo_medicamento,
		id_usuario,
		status)
		VALUES(
		'".$datos['id_grupo_med']."',
	 	'".$datos['nivel']."',
		'".$datos['codigo']."',
		'".$datos['nombre_medicamento']."',
		'".$datos['descripcion']."',
		'".$datos['cantidad']."',
		'".$datos['presentacion']."',
		'".$datos['fecha_ult_mod']."',
		'".$datos['comentario']."',
		'".$datos['tipo_medicamento']."',
		'".$datos['id_usuario']."',
		'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_medicamento_clinica($datos)
	{
		$q="UPDATE medicamentos SET
			nombre_medicamento 		= '".$datos['nombre_medicamento']."',
			descripcion 			= '".$datos['descripcion']."',
			cantidad				= '".$datos['cantidad']."',
			presentacion 			= '".$datos['presentacion']."',
			fecha_ult_mod 			= '".$datos['fecha_ult_mod']."',
			id_usuario  			= '".$datos['id_usuario']."'
		WHERE id_medicamento 	= '".$datos['id_medicamento']."'";

		return $this->db->query($q);
	}

	function eliminar_medicamento_clinica($datos)
	{
		$q="UPDATE medicamentos SET
			status 				= '".$datos['status']."',
			fecha_ult_mod = '".$datos['fecha_ult_mod']."',
			id_usuario  	= '".$datos['id_usuario']."'
		WHERE id_medicamento 	= '".$datos['id_medicamento']."' ";
		return $this->db->query($q);
	}

	function buscar_medicamento_clinica($datos)
	{
		$q="SELECT
			m.id_medicamento,
			m.nombre_medicamento,
			m.descripcion,
			m.cantidad,
			m.presentacion,
			m.fecha_ult_mod,
			m.id_usuario,
			m.status
		FROM medicamentos m
		WHERE m.id_medicamento = '".$datos['id_medicamento']."'";
		return $this->db->query($q);
	}


	function registrar_ingreso($datos)
	{
		$q="INSERT INTO ingresos (
					id_modulo,
					id_usuario,
					id_tipo_ingreso,
					tipo,
					id_ref,
					concepto,
					cantidad,
					ingreso,
					iva,
					total,
					fecha,
					status)
				VALUES(
				'".$datos['id_modulo']."',
				'".$datos['id_usuario']."',
				'".$datos['id_tipo_ingreso']."',
				'".$datos['tipo']."', 
				'".$datos['id_ref']."',
				'".$datos['concepto']."',
				'".$datos['cantidad']."',
				'".$datos['ingreso']."',
				'".$datos['iva']."',
				'".$datos['total']."',
				'".$datos['fecha']."',
				'".$datos['status']."')";
		return $this->db->query($q);
	}

	function actualizar_ingreso($datos)
	{
		$q="UPDATE ingresos SET
					concepto = '".$datos['concepto']."',
					cantidad = '".$datos['cantidad']."',
					ingreso  = '".$datos['ingreso']."',
					iva      = '".$datos['iva']."',
					total 	 = '".$datos['total']."',
					fecha    = '".$datos['fecha']."'
			  WHERE id_ingreso = '".$datos['id_ingreso']."'
				AND id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}

	function eliminar_ingreso($datos)
	{
		$q="UPDATE ingresos SET
					status 	 = '".$datos['status']."',
					fecha    = '".$datos['fecha']."'
			  WHERE id_ingreso = '".$datos['id_ingreso']."'
				AND id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);
	}

	function eliminar_ingreso_referencia($datos)
	{
		$q="UPDATE ingresos SET
					status 	 = '".$datos['status']."',
					fecha    = '".$datos['fecha']."'
			WHERE id_tipo_ingreso = '".$datos['id_tipo_ingreso']."'
			AND id_ref = '".$datos['id_ref']."'
			AND id_usuario = '".$datos['id_usuario']."'";
		return $this->db->query($q);	
	}

	function obtener_ingreso($datos)
	{
		$q="SELECT
					id_ingreso,
					id_modulo,
					id_usuario,
					concepto,
					cantidad,
					ingreso,
					iva,
					total,
					fecha,
					status
				FROM ingresos
				WHERE id_ingreso = '".$datos['id_ingreso']."'
				AND id_usuario = '".$datos['id_usuario']."'				
				AND status = 'A' ";
			
			return $this->db->query($q);
	}

	function count_listado_ingresos($datos)
	{
		if($datos['consulta']!='')
		{
			$filtro =  " AND concepto LIKE '%".$datos['consulta']."%' ";
		}
		$q="SELECT count(*) as num_row FROM ingresos
		WHERE id_usuario = '".$datos['id_usuario']."'
		AND id_modulo = '".$datos['id_modulo']."'
		AND status = 'A' ".$filtro;
		return $this->db->query($q);
	}

	function listado_ingresos($datos)
	{
		$q="SELECT
					id_ingreso,
					id_modulo,
					id_usuario,
					tipo, 
					concepto,
					cantidad,
					ingreso,
					iva,
					total,
					fecha,
					status
				FROM ingresos
				WHERE id_usuario = '".$datos['id_usuario']."'
				AND status = 'A' 
				AND id_modulo = '".$datos['id_modulo']."'
				ORDER BY id_ingreso DESC".$datos['limit'];
			return $this->db->query($q);
	}

	function obtener_resumen_ingresos_mes($datos)
	{
		$q="SELECT
					SUM(ingreso) as ingreso,
					SUM(iva) as iva,
					SUM(total) as total					
				FROM ingresos
				WHERE id_usuario = '".$datos['id_usuario']."'
				AND fecha >= '".$datos['fecha_inicio']." 00:00:00'
				AND fecha <= '".$datos['fecha_final']." 23:59:59'
				AND status = 'A'
				AND tipo = 'I'
				AND id_modulo = '".$datos['id_modulo']."' ";
			return $this->db->query($q);
	}

	function obtener_ingresos_grafica_semana($datos)
	{
		$q="SELECT
				DATE(fecha) as fecha,
				SUM(total) as total, 
				tipo 
			FROM ingresos
			WHERE id_usuario = '".$datos['id_usuario']."'						
			AND id_modulo  = '".$datos['id_modulo']."'
			GROUP BY DATE(fecha), tipo
			ORDER BY DATE(fecha), tipo DESC
			LIMIT 0, 7";						
		return $this->db->query($q);
	}

	function obtener_ultimos_ingreso($datos)
	{
		$q="SELECT
					id_ingreso,
					id_modulo,
					id_usuario,
					tipo,
					concepto,
					cantidad,
					ingreso,
					iva,
					total,
					fecha,
					status
				FROM ingresos
				WHERE id_usuario = '".$datos['id_usuario']."'
				AND id_modulo = '".$datos['id_modulo']."'
				AND status = 'A'
				ORDER BY id_ingreso DESC
				LIMIT 0,10";
			return $this->db->query($q);
	}

function registrar_consulta($datos)
	{
		$q="INSERT INTO rd_consultas (
				id_usuario,
				id_contacto,
				fecha, 
				status)
			VALUES(
			'".$datos['id_usuario']."',
			'".$datos['id_contacto']."',
			'".$datos['fecha']."',
			'".$datos['status']."')"; 
		return $this->db->query($q);
	}	

	function registrar_consulta_servicios($datos)
	{
		$q="INSERT INTO rd_consulta_servicios (
				id_consulta, 
				id_servicio)
			VALUES(
			'".$datos['id_consulta']."', 
			'".$datos['id_servicio']."')"; 
		return $this->db->query($q);
	}

	function eliminar_consulta_servicios($datos)
	{
		$q="DELETE FROM rd_consulta_servicios WHERE id_consulta = '".$datos['id_cosulta']."'"; 
		return $this->db->query($q);
	}

	function registrar_consulta_medicamentos($datos)
	{
		$q="INSERT INTO rd_consulta_medicamentos(
				id_consulta, 
				id_medicamento, 
				dosis)
			VALUES(
			'".$datos['id_consulta']."', 
			'".$datos['id_medicamento']."', 
			'".$datos['dosis']."')"; 
		return $this->db->query($q);	
	}

	function eliminar_consulta_medicamentos($datos)
	{
		$q="DELETE FROM rd_consulta_medicamentos WHERE id_consulta = '".$datos['id_cosulta']."'"; 
		return $this->db->query($q);
	}

	function actualizar_consulta($datos)
	{
		$q="UPDATE rd_consultas SET 
				id_contacto = '".$datos['id_contacto']."',
				fecha 		= '".$datos['fecha']."',
				status = '".$datos['status']."'
			WHERE id_consulta = '".$datos['id_consulta']."' 
			AND id_usuario = '".$datos['id_usuario']."'"; 
		return $this->db->query($q);
	}

	function eliminar_consulta($datos)
	{
		$q="UPDATE rd_consultas SET 				
				fecha 		= '".$datos['fecha']."',
				status 		= '".$datos['status']."'
			WHERE id_consulta = '".$datos['id_consulta']."'
			AND id_usuario = '".$datos['id_usuario']."'"; 
		return $this->db->query($q);
	}

	function obtener_consulta($datos) 
	{
		$q="SELECT 				
				a.id_consulta,
				a.fecha, 
				b.id_contacto,
				b.nombre_completo, 
				b.correo, 
				b.celular, 
				b.empresa, 
				c.nombre, 
				c.avatar
			FROM rd_consultas a
			INNER JOIN contactos b ON a.id_contacto = b.id_contacto
			INNER JOIN usuarios  c ON a.id_usuario = c.id_usuario
			WHERE a.id_consulta = '".$datos['id_consulta']."' "; 
		return $this->db->query($q);
	}

	function obtener_consulta_servicios($datos)
	{
		$q="SELECT 	
				b.id_servicio, 
				b.nombre_servicio, 
				b.descripcion, 
				b.precio_normal
			FROM rd_consulta_servicios a 
			LEFT JOIN rd_servicios b ON a.id_servicio = b.id_servicio
			WHERE a.id_consulta = '".$datos['id_consulta']."' "; 
		return $this->db->query($q);
	}

	function obtener_consulta_medicamentos($datos)
	{
		$q="SELECT 	
				b.id_medicamento, 
				b.nombre_medicamento, 
				b.descripcion, 
				b.cantidad, 
				b.presentacion, 
				a.dosis
			FROM rd_consulta_medicamentos a 
			LEFT JOIN medicamentos b ON a.id_medicamento = b.id_medicamento
			WHERE a.id_consulta = '".$datos['id_consulta']."' "; 
		return $this->db->query($q);		
	}

	function obtener_consulta_ingresos($datos)
	{
		$q="SELECT 	
				concepto, 
				cantidad, 
				ingreso, 
				iva, 
				total
			FROM ingresos
			WHERE id_ref = '".$datos['id_consulta']."'
			AND id_tipo_ingreso = '".$datos['id_tipo_ingreso']."' "; 
		return $this->db->query($q);			
	} 

	function count_listado_consultas($datos)
	{
		if($datos['consulta']!='')
		{
			$filtro =  " AND concepto LIKE '%".$datos['consulta']."%' ";
		}

		if($datos['id_contacto'] != '')
		{
			$filtro .=" AND id_contacto = '".$datos['id_contacto']."' "; 
		}

		$q="SELECT count(*) as num_row FROM rd_consultas
		WHERE id_usuario = '".$datos['id_usuario']."'
		AND status = 'A' ".$filtro;
		return $this->db->query($q);		
	}

	function listado_consultas($datos)
	{
		if($datos['consulta']!='')
		{
			$filtro =  " AND concepto LIKE '%".$datos['consulta']."%' ";
		}

		if($datos['id_contacto'] != '')
		{
			$filtro .=" AND a.id_contacto = '".$datos['id_contacto']."' "; 
		}

		$q="SELECT
				a.id_consulta,
				a.fecha,
				b.id_contacto,
				b.nombre_completo,
				b.correo,
				b.celular,
				b.empresa,
				c.nombre,
				c.apellidos,
				c.avatar, 
				(select SUM(total) FROM ingresos WHERE id_tipo_ingreso = '2' AND id_ref = a.id_consulta) as ingreso
			FROM rd_consultas a
			INNER JOIN contactos b ON a.id_contacto = b.id_contacto
			INNER JOIN usuarios  c ON a.id_usuario = c.id_usuario
			WHERE a.id_usuario = '".$datos['id_usuario']."' 
			AND a.status = 'A'
			ORDER BY a.id_consulta DESC
			".$datos['limit']; 
		return $this->db->query($q);
	}

	function registrar_correo_pendiente($datos)
	{
		$q="INSERT INTO correos_pendientes(
				fromc, 
				toc, 
				asunto, 
				mensaje, 
				id_plantilla,
				tipo, 
				fecha_c,
				fecha_e, 
				status)
			VALUES(
			'".$datos['from']."', 
			'".$datos['to']."', 
			'".$datos['asunto']."', 
			'".$datos['mensaje']."', 
			'".$datos['id_plantilla']."', 
			'".$datos['tipo']."', 
			'".$datos['fecha_c']."', 
			'".$datos['fecha_e']."', 
			'".$datos['status']."') "; 
		return $this->db->query($q);
	}

	function obtener_correos_pendientes()
	{
		$q="SELECT 
				id_correo_p, 
				fromc, 
				toc, 
				asunto, 
				mensaje, 
				id_plantilla
			FROM correos_pendientes 
			WHERE status = 'P'"; 
		return $this->db->query($q);
	}

	function obtener_plantillas()
	{	
		$q="SELECT 
				id_plantilla, 
				nombre_plantilla, 
				plantilla_externa, 
				plantilla_interna 
			FROM plantillas_correo
			WHERE status = 'A' "; 
		return $this->db->query($q);
	}

	function actualizar_correo_enviado($datos)
	{
		$q="UPDATE correos_pendientes SET 
				status 	= 'E', 
				fecha_e = '".$datos['fecha_e']."'
			WHERE id_correo_p = '".$datos['id_correo_p']."' "; 
		return $this->db->query($q);		
	}

	function listado_citas_dia($datos)
	{
		$q="SELECT 
				c.id_cita,
				c.id_usuario,
				c.id_contacto,
				c.id_periodo,
				c.fecha,
				c.descripcion,
				c.fecha_agenda,				
				c.color,
				c.status,
				p.nombre_completo,				
				p.correo as correo_paciente,
				pe.periodo,
				u.nombre,
				u.apellidos,
				u.correo as correo_dentista
			FROM citas c
			LEFT JOIN contactos p  ON c.id_contacto = p.id_contacto
			LEFT JOIN periodos  pe ON pe.id_periodo = c.id_periodo
			LEFT JOIN usuarios 	u  ON u.id_usuario 	= c.id_usuario
			WHERE c.fecha = '".$datos['fecha']."'            
			AND c.status = 'A'
			AND c.id_modulo = '".$datos['id_modulo']."'
			ORDER BY u.id_usuario ";

		return $this->db->query($q);
	}

	function obtener_correo_usuario_empresa($datos)
	{
		$q="SELECT 
				u.correo, 
				u.notificacion_correo
			FROM usuarios u 
			INNER JOIN empresas e ON u.id_usuario = e.id_usuario
			WHERE id_empresa = '".$datos['id_empresa']."'
			AND u.status = 'A'"; 
		return $this->db->query($q);
	}










}
?>
