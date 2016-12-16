<?php
$error ="";
if (isset($_POST['usuario']) && $_POST['usuario'] == "root"){
	session_destroy();
	session_start();
	if(isset($_POST['sesion'])){
		$_SESSION['mantener']= "Si";
		session_set_cookie_params(3600000, "/", "localhost", 0);
	}else{
		$_SESSION['mantener']= "No";
		session_set_cookie_params(30, "/", "localhost", 0);
	}
	//session_name('root');
	$_SESSION['nombre'] = "root";
	$_SESSION['idioma'] = $_POST['idioma'];
	$_SESSION['tamanyo'] = $_POST['tamano'];
	$_SESSION['hora'] =  date("H:i:s");
	header("Location: principal.php");
} elseif (isset($_POST['usuario']) && $_POST['usuario'] == "alumno"){
	session_destroy();
	session_start();
	if(isset($_POST['sesion'])){
		$_SESSION['mantener']= "Si";
		session_set_cookie_params(3600000, "/", "localhost", 0);
	}else{
		$_SESSION['mantener']= "No";
		session_set_cookie_params(30, "/", "localhost", 0);
	}
	//session_name('alumno');
	$_SESSION['nombre'] = "alumno";
	$_SESSION['idioma'] = $_POST['idioma'];
	$_SESSION['tamanyo'] = $_POST['tamano'];
	$_SESSION['hora'] =  date("H:i:s");
	header("Location: principal.php");
} elseif (isset($_POST['usuario'])) {
	$error = "Usuario no permitido";
}

?>
<html>
<head>
<title>Login</title>
		<style>
			.principal { font-family: arial; font-size: 20px; color: #0022DD; font-weight: bold; }
			.titulo { font-family: verdana; font-size: 15px; color: #0000DD; }
			.boton { height: 30px; width: 140px; border-radius:2px 2px 2px 2px; border:1px solid #00DDEE; background: #7777FF; font-family: Arial; font-size: 12px; color: #FFF; }
		</style>
</head>
<body bgcolor="#EEEEEE">
	<p><span class="principal"> Iniciar sesión </span></p> 
	<form name="login" method="post" action="">
		<table width="300" border="0" cellpadding="3" cellspacing="4">
			<tr><td class="titulo">Usuario:</td><td><input name="usuario" type="text" class="boton" required></td></tr>
			<tr><td class="titulo">Idioma:</td>
				<td><select name="idioma" class="boton">
						<option value="espanol"> Español </option>
						<option value="ingles"> Inglés </option>
					</select>
				</td>
			</tr>
			<tr><td class="titulo">Tamaño fuente:</td>
				<td><select name="tamano" class="boton">
						<option value="12"> 12 pixels </option>
						<option value="16"> 16 pixels </option>
						<option value="20"> 20 pixels </option>
					</select>
				</td>
			</tr>
			<tr align="center">
				<td class="titulo" colspan="2">
					<input type="checkbox" name="sesion" value="abierto"> mantener la sesión abierta 
				</td>
			</tr>
			<tr></tr>
			<tr align="center"><td colspan="2"><input class="boton" name="acceder" type="submit" value="ACCEDER"></td></tr>
		</table>
	</form>
	<center> <?php echo $error; ?> </center>
</body>
</html>