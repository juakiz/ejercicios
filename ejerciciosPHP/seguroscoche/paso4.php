<?php
session_name('sesion_seguros'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if ($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!empty($_POST['email']))
		$_SESSION['email'] = $_POST['email'];

	if (isset($_POST['submitS']))
		header("Location: fin.php");
	else
		header("Location: paso3.php");
}
?>
<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion Seguros</title>
	<meta charset="UTF-8">
</head> 
<body bgcolor="#FFFFF0"> 
	<h1 style="color:gray;">Te enviaremos los datos al email que introduzcas:</h1>
	Marca: <?php echo $_SESSION['marca'];?><br>
	Combustible: <?php echo $_SESSION['combustible'];?><br>
	Fecha: <?php echo $_SESSION['fecha'];?><br>
	<form method="post" action="" >
		Email:
		<input type="email" name="email" required <?php if (isset($_SESSION['email'])) echo "value=\"".$_SESSION['email']."\""?>><br>
		<input type="submit" name="submitA" value="<<ANTERIOR">
		<input type="submit" name="submitS" value="SIGUIENTE>>">
	</form>
	<hr>	
</body>
</html>