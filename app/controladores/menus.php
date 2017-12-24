<?
	switch ($_SESSION['s']['tipo_usuario']) 
	{
		case '1': 

			switch ($_SESSION['s']['modulo_activo']) 
			{
				case '0': include 'lib/menus/menu_mod_empresa.php'; 	break; 
				case '1': include 'lib/menus/menu_mod_amway.php';  		break; 				
				case '2': include 'lib/menus/menu_mod_reddental.php';  	break;
				default: include 'lib/menus/menu_mod_empresa.php';  	break; 
			}
		break;

		case '2'		: 
			switch ($_SESSION['s']['modulo_activo']) 
			{
				case '0': include 'lib/menus/menu_admin.php'; 			break; 
				case '1': include 'lib/menus/menu_mod_amway.php';  		break;
				case '2': include 'lib/menus/menu_mod_reddental.php';  	break; 				
				default : include 'lib/menus/menu_admin.php';  			break; 	
			}
		break;

		case '3': 

			switch ($_SESSION['s']['modulo_activo']) 
			{
				case '0': include 'lib/menus/menu_mod_empresa.php'; 	break; 
				case '1': include 'lib/menus/menu_mod_amway.php';  		break; 				
				case '2': include 'lib/menus/menu_mod_reddental.php';  	break;
				default: include 'lib/menus/menu_mod_empresa.php';  	break; 
			}
		break;


		
		default 		: include 'lib/menus/menu_portada.php' ;	 		break;
	}
?>