<?php
	session_start();
?>
<html>

<head>

<title>Chimpa - Fotos</title>

<style>
.celda
{
	border:1px solid black;
	text-align:center;
}
</style>

</head>

<?php

	include('./libs/misc.php');
	include('./libs/Backend.php');
	
	
	
	if (!isset($_SESSION['usuario']))
	{
		//header('Location: login.php');
		redireccionar(0,'login.php');
	}

	//Si llega el msj de cerrar sesion.
	if (isset($_GET['logout']))
	{
		 session_destroy();
	   //header('Location: login.php');
		 redireccionar(0,'login.php');
	}
	
	$a =  new Backend_bd();
?>

<body>

<!-- CUERPO -->
<div style="width:90%;margin:auto;border:1px dotted black;padding:10px;">

	<!-- BANNER -->
	<div style="font-size:40px;padding-bottom:8px;">
		<div style="float:left;color:#986820;"><b>Chimpa v1.0</b></div>
		<div style="float:left;margin-left:6px;"><img src="imgs/mono.png"></div>
		<br><br>
		<div style="margin-top:-40px;font-size:20px;">ABM fotos creado por <a href="https://twitter.com/DamCipolat" target="_blank">@Damcipolat</a>&nbsp;&nbsp;<img src="./imgs/arg_flag.png"></div>
	</div>
	
	<!--USUARIO-->
	<div style="font-size:14px;margin-bottom:5px;">
		Hola <b><?php echo $_SESSION['usuario']; ?></b> | <a href="album.php?logout">Cerrar sesion</a>
	</div>
	
	<!-- LISTADO DE ALBUMS -->
	<div>
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:10px;color:white;">
		<?php
			//Traer datos sobre el album
			$album = $a->traer_album($_GET['id_album']);
		?>
			<div><b>Listado de fotos del Album <i>"</b><?php echo $album['titulo'];?>"</i></div>	
		</div>
		<div style="overflow:auto;margin-bottom:10px;">
		<?php
			//Dibujar la tabla.
			$a->traer_fotos_album_divs($_GET['id_album']);
		?>
		</div>		
	</div>
	
	<div style="border-top:1px dotted black;padding-top:8px;">
		<a href="index.php" style="text-decoration:none;"><b><< Volver</b></a>
	</div>
</div>

</body>

</html>