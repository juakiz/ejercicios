<?php
session_start();

$usuario = "";
if (isset($_SESSION['usuario']) &&
	isset($_SESSION['passwd']) &&
	isset($_SESSION['hora'])) {
	$usuario = $_SESSION['usuario'];
	$passwd = $_SESSION['passwd'];
	$hora = $_SESSION['hora'];
	$ip = $_SESSION['ip'];
} else {
	header("Location: login.php");
}




if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['color'])){
	setcookie('color'.$usuario, $_POST['color'], time()+3600);
	header("Location: ".$_SERVER['PHP_SELF']);
} else {
	$color = "#BBDDAA";
}


if(isset($_COOKIE['color'.$usuario])){
	$color = $_COOKIE['color'.$usuario];

	if($color == "rojo")
		$color = "#FF0000";
	if($color == "azul")
		$color = "#0000FF";
	if($color == "amarillo")
		$color = "#FFFF00";
}


//echo ">>".$color;
?>
<head>
<title>PRINCIPAL</title>
</head>
<body bgcolor="<?php echo $color ?>" >
<br>
<h2>Estás en la página PRINCIPAL del SITIO</h2>
<h3>Has iniciado sesión con el usuario: <?php echo $usuario; ?></h3>
<h3>Con la contraseña: <?php echo $passwd; ?></h3>
<h3>A las: <?php echo $hora; ?></h3>
<h3>Y tu ip es: <?php echo $ip; ?></h3>
<form method="post" action="" >
	<input type="radio" name="color" value="rojo" <?php if (isset($_COOKIE['color'.$usuario]) && $_COOKIE['color'.$usuario] == "rojo") echo "checked"?>> Rojo<br>
	<input type="radio" name="color" value="azul" <?php if (isset($_COOKIE['color'.$usuario]) && $_COOKIE['color'.$usuario] == "azul") echo "checked"?>> Azul<br>
	<input type="radio" name="color" value="amarillo" <?php if (isset($_COOKIE['color'.$usuario]) && $_COOKIE['color'.$usuario] == "amarillo") echo "checked"?>> Amarillo<br>
	<input type="submit" name="boton" value="GUARDAR">
</form>
<hr>
<a href="logout.php">CERRAR SESIÓN</a>
</body>
</html>