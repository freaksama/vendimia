<?
	$tmp['opcion']    	= 'Empresas Portada'; 
	$tmp['des']		  	= 'Obtiene las empresas de la portada inicial'; 
	$tmp['metodo']		= 'GET';
	$tmp['input']		= ''; 
	$tmp['output']		= 'Matriz'; 
	$tmp['url']			= '/servicios/empresasportada'; 

	$metodos[] = $tmp; unset($tmp);

	$tmp['opcion']    	= 'Listado Empresas'; 
	$tmp['des']		  	= 'Obtiene el listado completo de las empresas'; 
	$tmp['metodo']		= 'GET';
	$tmp['input']		= ''; 
	$tmp['output']		= 'Matriz'; 
	$tmp['url']			= '/servicios/empresasgeneral'; 

	$metodos[] = $tmp; unset($tmp);

	$url_base  = str_replace('/servicios/info', '',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); 

	$color1 = '#0066ff';
	$color2 = '#b3d1ff'; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Informaci&oacute;n </title>
<style type="text/css">
	body{
		background-color: #CCCCCC;
		font-family: Arial;
		font-size: 13px;
	}

	a{
		color: <?=$color1;?>;
		text-decoration: none;
	}

	a:hover{
		text-decoration: underline;
	}

	pre
	{
		font-size: 11px;
	}

	.info{
		margin-left: 10% ; 
		margin-right: 10% ; 
		padding: 20px;
		background-color: #FFFFFF;
		border-radius: 5px;
		border: 1px solid <?=$color1;?>;		
	}

	.title
	{
		color: <?=$color1;?>;
		font-size: 24px;
		font-weight: bold;
	}

	.text-center
	{
		text-align: center;
	}

	.end
	{
		background-color:<?=$color2;?>; 
		border: 1px solid <?=$color1;?>;
		padding: 10px;
		border-radius: 3px;
		margin-bottom: 15px;
	}

	.f
	{
		float: right;
	}
</style>
</head>


<body>
	<div class="info" />		
		<div class="text-center">
			<span class="title">M&oacute;dulo Encuestas</span>
		</div>
		<br>

		
		
		<div class="end">			
			<?
				if(count($metodos) > 0)
				{	
					$i = 0; 
					foreach($metodos as $rec)
					{
						$id = str_replace(' ','', $rec['opcion']);
						$i++;

						?>
							<a href="#<?=$id;?>"><?=$i.'.-'.ucfirst(strtolower($rec['opcion']));?></a> : <?=$rec['des'];?>
							<br>
							<br>
						<?
					}	
				}				
			?>
		</div>
		<?
			if(count($metodos) > 0)
			{
				foreach($metodos as $rec)
				{
					$id = str_replace(' ','', $rec['opcion']);
					?>
						<div id="<?=$id;?>" class="end">	
							<div class="f">
								<a href="http://<?=$url_base.$rec['url'];?>"><?=$url_base.$rec['url'];?></a>	
							</div>
							<b>Opcion : </b> <?=$rec['opcion']?>	
							<br>
							<b>Descripci&oacute;n :</b>	<?=$rec['des'];?>
							<br>
							<b>Metodo : </b> <?=$rec['metodo']?>	
							<br>
							<b>Entradas : </b><?=$rec['input']?>	
							<br>
							<b>Salida :</b>	<?=$rec['output'];?>
						</div>				
					<?
				}
			}
		?>
		</div>
	</body>
</html>