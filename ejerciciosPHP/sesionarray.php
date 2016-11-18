<?php
session_name('sesion_array'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
if (!isset($_SESSION['sesion_array'])) { // No existe la variable->primera vez que se visita->contador a 1
$contador = 1;
$mensaje = "Es la primera vez que me visitas en esta sesión.";
} else { // Ya existe la variable-> ya ha visitado-> incrementar contador
$contador = $_SESSION['contador']; // Lee el valor de la variable de sesión
$contador++;
$mensaje = "Me has visitado en esta sesión con este navegador ".$contador." veces.";
}
$_SESSION['contador'] = $contador; // Asigna un valor a la variable de sesión
?>
<!-- XXXX -->
<?php // EL MANEJO DE LAS COOKIES DEBE SER LO PRIMERO DEL ARCHIVO
    // Comprueba si ya existe la cookie
/*
	if (!isset($_COOKIE['perfilUsuario'])){
		$mensaje = "No existe la cookie con preferencias almacenadas. Se usarán valores del perfil por defecto";
		$nombre = "Sin Nombre";
		$color = "#FFFFFF";
		$lenguaje = "español";
	} else {
		// Existe la cookie --> leer su array de valores:
		$mensaje = "";
		$perfil = $_COOKIE['perfilUsuario'];
		
		$nombre = $perfil['nombre'];
		$color = $perfil['color'];
		$lenguaje = $perfil['lenguaje'];
	}
*/
	
	// Crear-Modificar la cookie:
	if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['nombre'])) {
		$mensaje = "";
		$nombre = $_POST['nombre'];
		$color = $_POST['color'];
		if ($color == "rojo")
			$color = "#FF0000";
		if ($color == "verde")
			$color = "#00FF00";
		if ($color == "azul")
			$color = "#0044FF";
		
		$lenguaje = $_POST['lenguaje'];
		
		setcookie("perfilUsuario[nombre]", $nombre, time()+3600);
		setcookie("perfilUsuario[color]", $color, time()+3600);
		setcookie("perfilUsuario[lenguaje]", $lenguaje, time()+3600);
	}
?> 

<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion array</title> 
</head> 
<body> 
	<p>Personalice el sitio web antes de acceder:</p>
	<form method="post" action="siguiente.php" >
		Nombre: <input type="text" name="nombre" value="<?php echo $nombre ?>">
		<select name="color">
			<option value="rojo" <?php if ($color == "#FF0000") echo "selected"?> >rojo</option>
			<option value="verde" <?php if ($color == "#00FF00") echo "selected"?> >verde</option>
			<option value="azul" <?php if ($color == "#0044FF") echo "selected"?> >azul</option>
		</select>
		<select name="lenguaje">
			<option value="español" <?php if ($lenguaje == "español") echo "selected"?> >español</option>
			<option value="ingles" <?php if ($lenguaje == "ingles") echo "selected"?> >ingles</option>
		</select>
		<input type="submit" name="submit" value="ACCEDER>>">
	</form>
	<hr>
</body> 
</html> 