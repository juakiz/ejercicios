<?php
// Carga XML
libxml_use_internal_errors(true);
$usuarios = simplexml_load_file("usuarios.xml");
if ($usuarios === false)
echo "Error en el archivo XML";
//print_r($usuarios);

session_start();
if (isset($_SESSION['usuario']))
	session_destroy();
?>
<html> 
<head> <title>Login</title> </head> 
<body bgcolor="#BBDDAA">
<?php
$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// Validación
	if (empty($_POST['usuario']) || empty($_POST['password'])) {
		$error = "Debes rellenar todos los datos";
	} else {
		// Acceder con usuario y pass
		$usuarioP = $_POST['usuario']; 
		$passwordP = $_POST['password'];
		$userYpassOK = false;

		foreach($usuarios->Usuario as $usuario){
			if($usuario->Nombre == $usuarioP){
				if($usuario->Clave == $passwordP){
					$userYpassOK = true;
					break;
				}
			}
		}

		if ($userYpassOK) {
			$_SESSION['usuario'] = $usuarioP;
			$_SESSION['passwd'] = $passwordP;
			$_SESSION['hora'] = date("H:i:s");
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			header("Location: principal.php");
		} else {
			$error = "Usuario o clave incorrectos";
		}
	}
}
?>
<br>
<form name="login" method="post" action="">
<table width="300" border="0" cellpadding="3" cellspacing="4">
	<tr><td>Usuario:</td><td><input name="usuario" type="text" ></td></tr>
	<tr><td>Password:</td><td><input name="password" type="password" ></td></tr>
	<tr align="center"><td colspan="2"><input name="enviar" type="submit" value="ACCEDER"></td>
	</tr> 
</table>
</form>
<center> <?php echo $error; ?> </center>
</body>
</html>