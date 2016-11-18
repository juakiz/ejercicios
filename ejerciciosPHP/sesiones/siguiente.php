<?php
session_name('sesion_array'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){

	if(!empty($_POST['nombre']))
		$nombre = $_SESSION['nombre'] = $_POST['nombre'];

	if(!empty($_POST['color'])){
		$color = $_POST['color'];
		if ($color == "rojo")
			$color = "#FF0000";
		if ($color == "verde")
			$color = "#00FF00";
		if ($color == "azul")
			$color = "#0044FF";
	}

	if(!empty($_POST['lenguaje']))
		$lenguaje = $_SESSION['lenguaje'] = $_POST['lenguaje'];

}
/*
if (!isset($_SESSION['contador'])) { // No existe la variable->primera vez que se visita->contador a 1
$contador = 1;
$mensaje = "Es la primera vez que me visitas en esta sesión.";
} else { // Ya existe la variable-> ya ha visitado-> incrementar contador
$contador = $_SESSION['contador']; // Lee el valor de la variable de sesión
$contador++;
$mensaje = "Me has visitado en esta sesión con este navegador ".$contador." veces.";
}
$_SESSION['contador'] = $contador; // Asigna un valor a la variable de sesión
*/
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