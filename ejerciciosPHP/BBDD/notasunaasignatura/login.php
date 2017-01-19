<?php
	session_start();
	
	// cierra posibles sesiones existentes
	if (isset($_SESSION['usuario'])) {	
		$_SESSION = array();
		setcookie(session_name(),'',time()-100, '/');
		session_destroy(); 
		header("Location: login.php");
	}
	
	$error = "";	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {		
		if (empty($_POST['usuario']) || empty($_POST['clave'])) {
			$error = "Debes rellenar todos los datos";
		} else {
			$usuario = $_POST['usuario'];
			$clave = $_POST['clave'];

			$conexion = new mysqli("localhost", "root", "", "db_notas");
			if ($conexion->connect_error)
				die("Conexión fallida: ".$conexion->connect_error);			
			$tipo = compruebaUsuario($usuario, $clave);
			if ($tipo != null) {
				$_SESSION['usuario'] = $usuario;
				$_SESSION['tipo'] = $tipo;
				$_SESSION['horainicio'] = date("H:i:s");
				$conexion->close();
				
				if ($tipo == "Alumno")
					header("Location: alumno.php");
				if ($tipo == "Profesor")
					header("Location: profesor.php");
			} 
			$error = "Usuario o clave incorrectos";
			$conexion->close();
		}				
	}
	
	function compruebaUsuario ($usuario, $clave) {
		global $conexion;
		$consultaSQL = "SELECT * FROM t_usuarios WHERE usuario = '".$usuario."' AND clave = '".$clave."';";
		$resultado = $conexion->query($consultaSQL);
		if ($resultado->num_rows > 0) {
			$registro = $resultado->fetch_assoc();
			$resultado->close();
			return $registro["tipo"];
		} else	
			return false;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Notas</title>
	<link rel="stylesheet" href="estilos.css">
</head>
<body bgcolor="#11AAEE">
	
	<div style="position:absolute; left:20px; top:5px;">
		<table>
			<tr><td align="center"><p class="logo"> Notas </p></td></tr>
			<tr><td><img src="imagenes/logo.png" width="170" height="170"></td></tr>
		</table>
	</div>
	
	<div style="position:absolute; left:250px; top:85px;">
		<p class="titulo"> Inicie sesión: </p>
		<div style="position:relative; width:240px; height:150px; background:#DDDDDD; border:1px solid gray; padding:10px;">
			<form name="login" method="post" action="">
				<table width="250" border="0" cellpadding="3" cellspacing="4">
					<tr><td class="titulo">Usuario:</td><td><input name="usuario" type="text" class="boton" maxlength="10" required></td></tr>
					<tr><td class="titulo">Clave:</td><td><input name="clave" type="password" class="boton" maxlength="10" required></td></tr>
					<tr height="10"></tr>
					<tr align="center"><td colspan="2"><input class="boton" name="acceder" type="submit" value="ACCEDER"></td></tr>
				</table>
			</form>
		</div>
		<p class="titulo" style="color:red; text-align:center;"> <?php echo $error; ?> </p>
	</div>
	
</body>
</html>