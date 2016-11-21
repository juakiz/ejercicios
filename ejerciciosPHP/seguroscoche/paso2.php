<?php
session_name('sesion_seguros'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if ($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!empty($_POST['combustible']))
		$_SESSION['combustible'] = $_POST['combustible'];

	if (isset($_POST['submitS']))
		header("Location: paso3.php");
	else
		header("Location: index.php");
}
?>
<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion Seguros</title>
	<meta charset="UTF-8">
</head> 
<body bgcolor="#FFFFF0"> 
	<h1 style="color:gray;">¿Qué combustible usa su vehículo?</h1>
	<form method="post" action="" >
		<input type="radio" name="combustible" value="diesel" <?php if (isset($_SESSION['combustible']) && $_SESSION['combustible'] == "diesel") echo "checked"?>> Diesel<br>
		<input type="radio" name="combustible" value="gasolina" <?php if (isset($_SESSION['combustible']) && $_SESSION['combustible'] == "gasolina") echo "checked"?>> Gasolina<br>
		<input type="submit" name="submitA" value="<<ANTERIOR">
		<input type="submit" name="submitS" value="SIGUIENTE>>">

	</form>
	<hr>	
</body>
</html>