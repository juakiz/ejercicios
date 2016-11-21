<?php
session_name('sesion_seguros'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if ($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!empty($_POST['fecha']))
		$_SESSION['fecha'] = $_POST['fecha'];

	if (isset($_POST['submitS']))
		header("Location: paso4.php");
	else
		header("Location: paso2.php");
}
?>
<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion Seguros</title>
	<meta charset="UTF-8">
</head> 
<body bgcolor="#FFFFF0"> 
	<h1 style="color:gray;">¿Cuándo lo compraste?</h1>
	<form method="post" action="" >
		<input type="date" name="fecha" required <?php if (isset($_SESSION['fecha'])) echo "value=\"".$_SESSION['fecha']."\""?>>
		<input type="submit" name="submitA" value="<<ANTERIOR">
		<input type="submit" name="submitS" value="SIGUIENTE>>">

	</form>
	<hr>	
</body>
</html>