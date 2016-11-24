<!DOCTYPE html>
<?php
	if(isset($_COOKIE['ultima_busqueda'])){ 
		$ultimaBusqueda = $_COOKIE['ultima_busqueda'];
	}
	$error = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST['busqueda'])) { 
			$error = "<p><span style=\"font-family: verdana ; font-size: 10px; color: #DD0000;\"> Debe introducir un criterio de búsqueda. </span></p>";
		} else {
			$error = "";
			$caducidad = time() + 30*24*60*60; // un mes 
			$valor = $_POST['busqueda'];
			setcookie('ultima_busqueda', $valor, $caducidad); 
		}
	}
?>
<html>
  <head> <title> Buscador basado en Google </title> </head>
<body>  
	<p> <span style="font-family: arial; font-size: 22px; color: #0022DD; font-weight: bold;">
		Buscador basado en Google
	</span>	</p>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<table>
	<tr>
	  <td><span style="font-family: verdana ; font-size: 14px; color: #0000DD;">Búsqueda: </span></td> 
	  <td><input type="text" name="busqueda" size="18" value="<?php echo $ultimaBusqueda; ?>"></td>
	  <td>
		  <input type="submit" name="buscar" value="Buscar" Style="height: 20px; border-radius:2px 2px 2px 2px; border:1px solid #0000FF; background: #0000DD; font-family: Arial; font-size: 12px; color: #FFF; text-shadow: 0 1px #aa4040; font-weight: bold;">
	  </td>
	</tr>
	</table>
	</form>
	<?php 
		echo $error;
		echo "<hr>";
	
	    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busqueda'])) {
			$urlBuscador = "http://www.google.com/search?q=" . $_POST['busqueda'];
			header("Location: $urlBuscador");		
		}
	?>
</body>
</html>
