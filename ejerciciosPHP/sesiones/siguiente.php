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
			echo $mensaje; 
			echo "<br>";
			if ($lenguaje == "español") {
				echo "Hola " . $nombre . ",<br>";
				echo "Esto es una página que guarda tus preferencias en una cookie con:<br>";
				echo "tu nombre, color de fondo y el lenguaje seleccionados.";
			}
			if ($lenguaje == "ingles") {
				echo "Hi " . $nombre . ",<br>";
				echo "This web saves your preferences in a cookie with:<br>";
				echo "your name, background color and language selected.";
			}				
		?> 
	</h2> 
</body>
</html>