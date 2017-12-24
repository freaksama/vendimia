<?
	/*****************************************************************************
	* Descripcion: Archivo principal para cargar scripts necesario para la pantalla.
	* Cuando hay un usuario logueado en el sistema, se cargan diferentes pantallas.
	* De esta manera se controla lo que el usuario puede ver.
	*
	*
	*
	*
	*
	*
	******************************************************************************/
	
	switch ($_GET['op'])
	{
		case 'ventas'		: include 'lib/vendimia/ventas/listado_ventas.php'; 				break;
		case 'new_venta' 	: include 'lib/vendimia/ventas/frm_registrar_venta.php'; 			break;
		case 'det_venta'	: include 'lib/vendimia/ventas/frm_actualizar_venta.php'; 			break;
		case 'clientes'		: include 'lib/vendimia/clientes/listado_clientes.php'; 			break;
		case 'new_cliente' 	: include 'lib/vendimia/clientes/frm_registrar_cliente.php'; 		break;
		case 'edi_cliente'  : include 'lib/vendimia/clientes/frm_actualizar_cliente.php'; 		break;
		case 'articulos'	: include 'lib/vendimia/articulos/listado_articulos.php'; 			break;
		case 'new_articulo'	: include 'lib/vendimia/articulos/frm_registrar_articulo.php'; 		break;
		case 'edi_articulo'	: include 'lib/vendimia/articulos/frm_actualizar_articulo.php'; 	break;			
		case 'configuracion': include 'lib/vendimia/configuracion/configuracion_general.php'; 	break;			
		default 			: include 'lib/vendimia/portada.php' ;	 							break;
	}	

?>
