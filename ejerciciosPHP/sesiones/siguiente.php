<?php
session_name('sesion_array'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión

	if(!empty($_SESSION['nombre']))
		$nombre = $_SESSION['nombre'];
	else
		header("Location: sesionarray.php");

	if(!empty($_SESSION['color']))
		$color = $_SESSION['color'];
	else
		header("Location: sesionarray.php");

	if(!empty($_SESSION['lenguaje']))
		$lenguaje = $_SESSION['lenguaje'];
	else
		header("Location: sesionarray.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sesion array</title>
</head> 
<body bgcolor=" <?php echo $color;?> "> 

	<h1>Mi Web</h1>
	<hr>
	<h2> 
		<?php 
			echo "<br>";
			echo "<br>";
			if ($lenguaje == "español") {
				echo "Hola " . $nombre . ",<br>";
				echo "Esto es una página que guarda tus preferencias en una sesion con:<br>";
				echo "tu nombre, color de fondo y el lenguaje seleccionados.";
			}
			if ($lenguaje == "ingles") {
				echo "Hi " . $nombre . ",<br>";
				echo "This web saves your preferences in a session with:<br>";
				echo "your name, background color and language selected.";
			}				
		?> 
	</h2> 
</body>
</html>