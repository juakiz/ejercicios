<?php // EL MANEJO DE LAS COOKIES DEBE SER LO PRIMERO DEL ARCHIVO
    // Comprueba si ya existe la cookie
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
	<title>Cookie array</title> 
</head> 
<body bgcolor=" <?php echo $color;?> "> 
	<p>Personalice el sitio web:</p>
	<form method="post" action="" >
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
		<input type="submit" name="submit" value="GUARDAR">
	</form>
	<hr>
	<br>
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