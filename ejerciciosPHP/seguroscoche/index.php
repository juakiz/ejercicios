<?php
session_name('sesion_seguros'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){

	if(!empty($_POST['marca']))
		$_SESSION['marca'] = $_POST['marca'];

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
	<h1 style="color:gray;">¿Cuál es la marca de coche que quiere asegurar?</h1>
	<form method="post" action="" >
		<input type="radio" name="marca" value="AUDI" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "AUDI") echo "checked"?>> AUDI<br>
		<input type="radio" name="marca" value="BMW" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "BMW") echo "checked"?>> BMW<br>
		<input type="radio" name="marca" value="CITROEN" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "CITROEN") echo "checked"?>> CITROEN<br>
		<input type="radio" name="marca" value="DACIA" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "DACIA") echo "checked"?>> DACIA<br>
		<input type="radio" name="marca" value="FIAT" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "FIAT") echo "checked"?>> FIAT<br>
		<input type="radio" name="marca" value="FORD" required <?php if (isset($_SESSION['marca']) && $_SESSION['marca'] == "FORD") echo "checked"?>> FORD<br>
		<input type="submit" name="submit" value="SIGUIENTE>>">

	</form>
	<hr>	
</body>
</html>