<?php
session_name('sesion_seguros'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
$_SESSION = array(); // Borra todas las variables de sesión
// Borra la cookie que almacena la sesión:
setcookie(session_name(),'',time()-3600,'/');
session_destroy(); // Destruye la sesión

?>
<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion Seguros</title>
	<meta charset="UTF-8">
</head> 
<body bgcolor="#FFFFF0"> 
	<h1 style="color:gray;">Gracias por usar esta mierda.</h1>
	<a href="index.php">VOLVER AL INICIO</a>
	<hr>	
</body>
</html>