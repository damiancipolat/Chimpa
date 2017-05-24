<?php
		error_reporting(0);
	session_start();
?>
<html>
<head>

<title>Chimpa - ver albums</title>

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
	$("#btn_form_add").click(function()
	{
		//Revisa si el usuario y contraseña fueron escritos.
		var titulo  = $("#titulo_add").val();
		var descrip = $("#descrip_add").val();
		
		if ((titulo!="")&&(descrip!=""))
		{
			$("#form_add_album").submit();
		}
		else
		{
			alert("Debe escribir el titulo del album y la descripción para agregar un nuevo album.");
		}		
	});

	//Validar formulario editar album.
	$("#btn_form_edit").click(function()
	{
		//Revisa si el usuario y contraseña fueron escritos.
		var titulo  = $("#titulo_edit").val();
		var descrip = $("#descrip_edit").val();
		
		if ((titulo!="")&&(descrip!=""))
		{
			$("#form_edit_album").submit();
		}
		else
		{
			alert("Debe escribir el titulo del album y la descripción para modificar el album.");
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
		redireccionar(0,'login.php');
		exit;
	}
	
	//Si llega el msj de cerrar sesion.
	if (isset($_GET['logout']))
	{
		 session_destroy();
		 redireccionar(0,'login.php');
	}

	$listar  = true;
	$agregar = true;
	$editar  = false;
	
	$a =  new Backend_bd();
?>

<body>

<!-- CUERPO -->
<div style="width:600px;margin:auto;border:1px dotted black;padding:10px;">

	<!-- BANNER -->
	<div style="font-size:40px;padding-bottom:8px;">
		<div style="float:left;color:#986820;"><b>Chimpa v1.0</b></div>
		<div style="float:left;margin-left:6px;"><img src="imgs/mono.png"></div>
		<br>
		<br>
		<div style="margin-top:-40px;font-size:20px;">ABM fotos creado por <a href="https://twitter.com/DamCipolat"  target="_blank">@Damcipolat</a>&nbsp;&nbsp;<img src="./imgs/arg_flag.png"></div>
	</div>
	
	<!--USUARIO-->
	<div style="font-size:14px;margin-bottom:5px;">
		Hola <b><?php echo $_SESSION['usuario']; ?></b> | <a href="index.php?logout">Cerrar sesion</a>
	</div>
	
	<?php
	 
		//Si viene el msj de borrar.
		if (isset($_GET['del_album']))
		{
			$id = $_GET['del_album'];
			$a->borrar_album($id);
			
			$agregar = true;
			$listar  = true;
			$editar  = false;
		}
		
		//Si viene el msj de agregar.
		if (isset($_POST['titulo_add']))
		{
			$titulo  = $_POST['titulo_add'];
			$descrip = $_POST['descrip_add'];
			$a->agregar_album($titulo,$descrip);
			
			$agregar = true;
			$listar  = true;
			$editar  = false;
		}
		
		//Si viene el msj de borrar.
		if (isset($_GET['edit_album']))
		{			
			$agregar = false;
			$listar  = false;
			$editar  = true;
		}
		
		//Si vienen los datos por post de modif.
		if (isset($_POST['titulo_edit']))
		{
			$t = $_POST['titulo_edit'];
			$e = $_POST['descrip_edit'];
			$i = $_POST['id_edit'];
			$a->editar_album($i,$t,$e);
			
			$agregar = true;
			$listar  = true;
			$editar  = false;			
		}
	?>


	<!-- LISTADO DE ALBUMS -->
	<div <?php if (!$listar)echo "style='display:none;'"?>>
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:10px;color:white;">
			<div><b>Listado de Albums</b></div>	
		</div>
		<i>* En la lista se pueden ver los albunes cargados actualmente.</i><br>
		<i>* Haga click en la columna <u>titulo</u> para ver las fotos del album sin poder editarlas.</i><br>
		<i>* Haga click en la columna <u>agregar</u> para agregar fotos al album.</i><br>
		<i>* Haga click en la columna <u>borrar</u> para eliminar un album.</i><br>
		<i>* Haga click en la columna <u>editar</u> para cambiar el titulo o descrip del album.</i>
		<br><br>
		<?php

		//Dibujar la tabla.
		echo "<table style='border:1px solid black;' align='center'>";
		echo "<tr>
					<td class='celda' style='background:#5F441A;color:white;'>Titulo</td>
					<td class='celda' style='background:#5F441A;color:white;'>Descripci&oacute;n</td>
					<td class='celda' style='background:#5F441A;color:white;'>Agregar</td>
					<td class='celda' style='background:#5F441A;color:white;'>Editar</td>
					<td class='celda' style='background:#5F441A;color:white;'>Borrar</td>
			  </tr>";
		$a->traer_albunes();
		echo "</table>";	
	?>
	</div>
	
	<!-- FORMULARIO PARA NUEVO ALBUM-->
	<div <?php if (!$agregar)echo "style='display:none;'"?>>
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:5px;margin-top:20px;color:white;">
			<div><b>Agregar album</b></div>
		</div>
		<i>* Complete el formulario para cargar un nuevo album.</i><br>
		<div style="margin-top:10px;">
			<form action="index.php" method="post" id="form_add_album">
				<hidden id="add_album"></hidden>
				<div>
					<b>Nombre:</b><br>
					<input type=text maxlength="100" name="titulo_add" id="titulo_add" style="padding:8px;width:200px;background:#FFF5E4;border:1px solid #986820;" placeholder="Escriba el titulo del album.">
					<BR><br>	
					<b>Descripci&oacute;n:</b><br>
					<textarea name="descrip_add" id="descrip_add" style="width:600px;height:100px;background:#FFF5E4;border:1px solid #986820;" maxlength="500"></textarea>
					<div style="margin-top:4px;">
						<input type="button" value="Agregar" id="btn_form_add" style="padding:5px;">
						<input type="reset" value="Limpiar"  style="padding:5px;">	
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<!-- FORMULARIO PARA EDITAR ALBUM-->
	<div <?php if (!$editar)echo "style='display:none;'"?>>	
		<?php
			$titulo_edit  = "";
			$descrip_edit = "";
			$id_edit      = "";
			
			if (isset($_GET['edit_album']))
			{
				$id      = $_GET['edit_album'];				
				$datos   = $a->traer_album($id);
				$id_edit = $_GET['edit_album'];	
				
				if ($datos!=null)
				{
					$titulo_edit   = $datos["titulo"];
					$descrip_edit  = $datos["descrip"];
				}
			}
		?>	
		<div style="background:#986820;border-right:1px solid black;border-bottom:1px solid black;padding:5px;margin-bottom:5px;margin-top:20px;color:white;">
			<div><b>Editar album</b></div>
		</div>
		<i>* En la lista se pueden ver los albunes cargados actualmente.</i>
		<br>
		<div style="margin-top:10px;">
			<form action="index.php" method="post" id="form_edit_album">
				<hidden id="edit_album"></hidden>
				<div>
					<b>Nombre:</b><br>
					<input type=text maxlength="100" id="titulo_edit" name="titulo_edit" style="padding:8px;width:200px;background:#FFF5E4;border:1px solid #986820;" placeholder="Escriba el titulo del album." value="<?php echo $titulo_edit;?>">
					<BR><br>	
					<b>Descripci&oacute;n:</b><br>
					<textarea id="descrip_edit" name="descrip_edit" style="width:600px;height:100px;background:#FFF5E4;border:1px solid #986820;" maxlength="500"><?php echo $descrip_edit;?></textarea>
					<input type="hidden" name="id_edit" value="<?php echo $id_edit;?>">
					<div style="margin-top:4px;">
						<input type="button" value="Guardar" id="btn_form_edit" style="padding:5px;">
						<input type="reset" value="Limpiar"  style="padding:5px;">	
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div>
		<?php
			$tmp = explode('/',$_SERVER['REQUEST_URI']);
			if ((strpos(end($tmp),'?')>0))
				echo "<a href='index.php' style='text-decoration:none;'><b><< Volver</b></a>";
		?>		
	</div>
</div>

</body>

</html>