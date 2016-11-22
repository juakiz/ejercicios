<!DOCTYPE html>
<html> 
<head> 
	<meta charset="UTF-8">
	<title>Sesión video</title>
</head> 
<?php
if (!isset($_COOKIE['sesion_activa'])){

	setcookie("sesion_activa[estado]", 1, time()+36000);
	session_set_cookie_params(30, "/", "localhost", 0);
	session_name('sesion_video');
	session_start(); // inicia la sesión o sigue con ella
	
} else{

	if(!$estado['estado'])
		header("Location: end.php");

	else{

		session_set_cookie_params(30, "/", "localhost", 0);
		session_name('sesion_video');
		session_start(); // inicia la sesión o sigue con ella

	}
}


/*echo "<h4> Datos de la sesión actual: </h4>";
echo "ID: ".session_id();
echo "<br> Nombre: ".session_name()."<br>";
echo "Parámetros de la cookie de sesión:";
$parametrosCookie = session_get_cookie_params();
foreach ($parametrosCookie as $c=>$v)
echo "<br>&nbsp;&nbsp;".$c." = ".$v;
echo "<br> <br> Estos datos se perderán en 10 segundos o al cerrar la página";
echo "<br> Se creará una nueva sesión (nuevo ID) al abrir la página otra vez.";*/
?>
<iframe width="560" height="420" src="https://www.youtube.com/embed/XGSy3_Czz8k?autoplay=1?showinfo=0?start=0" frameborder="0">
<hr> <br> <a href="<?php echo $_SERVER['PHP_SELF']; ?>">RECARGAR LA PÁGINA</a> </body> </html>