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















































}
?>
