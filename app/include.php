<?

	include 'config/conexion_mysqli.php';
	include 'class/class_base.php';
	include 'class/class_servicio.php';
	include 'controladores/c_servicios.php';
	
	$db 		 = new MySQLi_conexion();		
	$c_sistema   = new c_servicios($db);
?>