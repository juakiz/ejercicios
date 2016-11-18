<?php
session_name('sesion_array'); // Nombre de la sesión a crear/continuar.Mismo nombre que la cookie a crear
session_start(); // Crea la sesión con el nombre especificado o se continua si ya existe la sesión
?>
<!DOCTYPE html>
<html> 
<head> 
	<title>Sesion array</title> 
</head> 
<body bgcolor="#FFFFF0"> 
	<h1 style="color:#FFF000;">Mi Web</h1>
	<p>Personalice el sitio web antes de acceder:</p>
	<form method="post" action="siguiente.php" >
		Nombre: <input type="text" name="nombre" value="<?php if (isset($_SESSION['nombre'])) echo $_SESSION['nombre']; ?>" placeholder="Introduce tu nombre." required>
		<select name="color" required>
			<option value="rojo" <?php if (isset($_SESSION['color']) && $_SESSION['color'] == "#FF0000") echo "selected"?> >rojo</option>
			<option value="verde" <?php if (isset($_SESSION['color']) && $_SESSION['color'] == "#00FF00") echo "selected"?> >verde</option>
			<option value="azul" <?php if (isset($_SESSION['color']) && $_SESSION['color'] == "#0044FF") echo "selected"?> >azul</option>
		</select>
		<select name="lenguaje" required>
			<option value="español" <?php if (isset($_SESSION['lenguaje']) && $_SESSION['lenguaje'] == "español") echo "selected"?> >español</option>
			<option value="ingles" <?php if (isset($_SESSION['lenguaje']) && $_SESSION['lenguaje'] == "ingles") echo "selected"?> >ingles</option>
		</select>
		<input type="submit" name="submit" value="ACCEDER>>">
	</form>
	<hr>
	
</body>
</html>