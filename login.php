<?php
	session_start();
?>
<html>

<head>

<title>Chimpa - Login</title>

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

	$("#entrar").click(function()
	{
		//Revisa si el usuario y contraseña fueron escritos.
		var user  = $("#usuario").val();
		var passw = $("#password").val();
		
		if ((user!="")&&(passw!=""))
		{
			$("#form_login").submit();
		}
		else
		{
			alert("Debe escribir el usuario y la contraseña para poder ingresar.");
		}
		
	});

});

</script>

</head>

<?php
	include('./libs/Backend.php');
	include('./libs/misc.php');
?>

<body>

<!-- CUERPO -->
<div style="width:600px;margin:auto;border:1px dotted black;padding:10px;padding-top:20px;">

	<!-- BANNER -->
	<div style="font-size:40px;margin:auto;width:300px;">
		<div style="float:left;color:#986820;"><b>Chimpa v1.0</b></div>
		<div style="float:left;margin-left:6px;"><img src="imgs/mono.png"></div>
		<br><br>
		<div style="margin-top:-40px;font-size:20px;">Login de usuarios:</div>
		
		<?php	
				if ((isset($_POST['user_login']))&&(isset($_POST['passw_login'])))
				{
					$user  = $_POST['user_login'];
					$passw = $_POST['passw_login'];
					
						$a =  new Backend_bd();
						
						if ($a->login($user,$passw))
						{	
							$_SESSION['usuario'] = $user;
							redireccionar(0,'index.php');
						}
						else
						{
							echo "<div style='color:red;font-size:20px;'><b>Usuario o Contrase&ntilde;a incorrecta!</b></div>";
						}
				}	
		?>	
		
		<div style="font-size:15px;margin-top:10px;border-top:1px dotted silver;padding-top:10px;">
			<form action="login.php" method="post" id="form_login">
			<div style="margin:auto;width:200px;">
				<b>Usuario:</b><br>
				<input type="text" maxlength="100" name="user_login" id="usuario" style="padding:8px;width:200px;background:#FFF5E4;border:1px solid #986820;" placeholder="Escriba el usuario.">
				<br><br>
				<b>Contrase&ntilde;a:</b><br>
				<input type="password" maxlength="10" name="passw_login" id="password" style="padding:8px;width:200px;background:#FFF5E4;border:1px solid #986820;" placeholder="Escriba su contrase&ntilde;a.">				
				<input type="button" id="entrar" value="Entrar" style="padding:10px;margin-top:10px;margin-left:70px;">
			</div>
			</form>
		</div>		
	</div>
	<span style="font-size:15px;margin-left:420px;color:#986820;" align="rigth">Creado por <a href="https://twitter.com/DamCipolat"  target="_blank">@Damcipolat</a>&nbsp;&nbsp;<img src="./imgs/arg_flag.png"></span>
</div>

</body>

</html>