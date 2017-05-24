<?phperror_reporting(0);
	session_start();
?>
<html>

</head>

<title>Chimpa - Album</title>

<script language="javascript" src="./js/jquery.min.js"></script>

<style>
.celda
{
	border:1px solid black;
	text-align:center;
}
</style>


<script language="javascript">

$(document).ready(function()
{

	//Validar formulario agregar album.
	$("#btn_add_foto").click(function()
	{
		//Revisa si el usuario y contraseña fueron escritos.
		var archivo  = $("#file_foto").val();
		
		if (archivo!="")
		{
			$("#frm_add_foto").submit();
		}
		else
		{
			alert("Debe elegir un archivo PNG,GIF o JPG para cargar al album.");
		}
		
	});
	
});

</script>

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
<div style="width:600px;margin:auto;border:1px dotted black;padding:10px;">

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
	
	<?php

		//Si se carga el archivo de la foto
		if (isset($_POST['descrip_add']))
		{
				if ($_FILES["file_foto"]["error"] > 0)
				{
					echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al al subir la foto.</div>";			
				}
				else
				{
					if (formato_imagen(extraer_tipo($_FILES["file_foto"]["name"])))
					{
						if (($_FILES["file_foto"]["size"] / 1024)<=1024)
						{
							$id      = $_GET['id_album'];
							$nombre  = $_FILES["file_foto"]["name"];
							$descrip = $_POST['descrip_add'];
							$file    = timestamp()."_".$_FILES["file_foto"]["name"];
							move_uploaded_file($_FILES["file_foto"]["tmp_name"],"./fotos/".$file);
							
							$a->agregar_foto_album($id,$nombre,$file,$descrip);							
							$_POST=NULL;
						}
						else
						{
							echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> la foto excede 1MB.</div>";
						}  								
					}
					else
					{
							echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> la foto no cumple el formato correcto solo png o jpg.</div>";
					}
				}
		}
		
		//Si se envia borrar.
		if (isset($_GET['del_foto']))
		{
			$a->borrar_foto($_GET['del_foto']);
		}
	?>
	
	<!-- LISTADO DE ALBUMS -->
	<div>
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:10px;color:white;">
			<div><b>Listado de fotos del Album</b></div>	
		</div>
		<i>* En la lista se pueden ver las fotos cargadas actualmente.</i><br>
		<i>* Para modificar la descripci&oacute;n de una foto borrela y vuelva a cargala.</i><br>
		<i>* Haga click en la columna <u>borrar</u> para eliminar un album.</i><br>
		<br><br>
		<?php
			//Dibujar la tabla.
			echo "<table style='border:1px solid black;' align='center'>";
			echo "<tr>
						<td class='celda' style='background:#5F441A;color:white;'>Archivo</td>
						<td class='celda' style='background:#5F441A;color:white;'>Descripci&oacute;n</td>
						<td class='celda' style='background:#5F441A;color:white;'>Borrar</td>
				  </tr>";
			$a->traer_fotos_album($_GET['id_album']);
			echo "</table>";
		?>
	</div>
	
	<!-- FORMULARIO PARA NUEVO ALBUM-->
	<div>
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:5px;margin-top:20px;color:white;">
			<div><b>Agregar foto</b></div>
		</div>
		<i>* Formulario para cargar una nueva foto al album.</i><br>
		<i>* Haga click en <u>seleccionar archivo</u> para elegir la foto.</i><br>
		<div style="margin-top:10px;">
			<form id="frm_add_foto" action="album.php?id_album=<?php echo $_GET['id_album']; ?>" method="post" enctype="multipart/form-data">
				<div>
					<b>Archivo:</b><br>
					<input type="file"    name="file_foto" id="file_foto">
					<input type="hidden"  name="id_album"  id="id_album" value="<?php if (isset($_GET['id_album']))echo $_GET['id_album']; ?>">
					<BR><br>	
					<b>Descripci&oacute;n:</b><br>
					<textarea name="descrip_add" id="descrip_foto" style="width:600px;height:100px;background:#FFF5E4;border:1px solid #986820;" maxlength="500"></textarea>
					<div style="margin-top:4px;">
						<input type="button" id="btn_add_foto" value="Agregar"  style="padding:5px;">
						<input type="reset"  value="Limpiar"  style="padding:5px;">	
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div>
		<a href="index.php" style="text-decoration:none;"><b><< Volver</b></a>
	</div>
</div>

</body>

</html>