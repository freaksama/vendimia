<?
	$_SESSION['s']['modulo_activo'] = $_GET['op']; 
	switch ($_GET['op']) 
	{
		case '0': echo'<script type="text/javascript">window.location.href = "index.php?sub=emp";</script>';             	 break;
		case '1': echo'<script type="text/javascript">window.location.href = "index.php?sub=mln&op=pro";</script>';  break;
		case '2': echo'<script type="text/javascript">window.location.href = "index.php?sub=rdd&op=pac";</script>';  break;
	}
	
?>
