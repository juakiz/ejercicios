<!-- VALIDACIÓN DEL FORMULARIO -->
<?php
	$errorValidacion = "";
	$validacionOK = true;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_FILES['fichero']['name'])) {
			$validacionOK = false;
			$errorValidacion .= "Debe especificar un fichero a subir.";
		} else {
			$tamaño = $_FILES['fichero']['size'];
			if ($tamaño > 10000000 || $tamaño == 0) {  // tamaño máximo 10 MB = 10000000 B
				$validacionOK = false;
				$errorValidacion .= "El tamaño ".$tamaño." excede el límite de 10 MB permitido.";
			}
		}
		if (empty($_POST['directorio'])) {
			$errorValidacion .= "Debe especificar un directorio de destino en el servidor.";
		}
	}
?>

<!DOCTYPE html>
<html>
    <head><title>Subir fichero</title></head>
<body>
	<p><span style="font-family: arial; font-size: 22px; color: #0022DD; font-weight: bold;">
		SUBIDA DE FICHEROS AL SERVIDOR
	</span></p>
	<p><span style="font-family: arial; font-size: 12px; color: #0000DD;">
		Solo puede subir ficheros de hasta 10 MB
	</span></p>

	<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table border="1">
	<tr>
	  <td><span style="font-family: verdana ; font-size: 14px; color: #0000DD;">Fichero:</span></td>
	  <td><input type="file" name="fichero" style="height: 20px; border:1px solid #0000FF; background: #0000DD; font-family: Arial; font-size: 12px; color: #FFF;"> <?php echo $errorValidacion; ?></td>
	</tr>
	<tr><td><br></td><td></td></tr>
	<tr>
	  <td><span style="font-family: verdana ; font-size: 14px; color: #0000DD;">Directorio del servidor:</span> </td>
	  <td><select name="directorio">
		<?php
			$ficheros = scandir(".");
			for ($i = 0; $i < count($ficheros); $i++) {
				if (is_dir($ficheros[$i]) && $ficheros[$i] != "." && $ficheros[$i] != "..") {
					echo "<option value=\"".$ficheros[$i]."\">" . $ficheros[$i] . "</option>";
				}
			}
		?>
		</select>
	  </td>
	</tr>
	<tr><td><br></td><td></td></tr>
	<tr>
	  <td colspan="2"><input type="submit" name="enviar" value="ENVIAR" style="height: 24px; width: 100px; border-radius:2px 2px 2px 2px; border:1px solid #0000FF; background: #0000DD; font-family: Arial; font-size: 12px; color: #FFF; text-shadow: 0 1px #aa4040; font-weight: bold;"></td>
	</tr>
	 </table>
	</form>
	<hr>

<!-- FICHERO SUBIDO CON EL FORMULARIO -->
	<?php
	   if ($_SERVER["REQUEST_METHOD"] == "POST" && $validacionOK == true) {
			// Copia el archivo a la carpeta de destino y borra el archivo temporal
			$directorio = $_POST['directorio'];
			$rutaDef = "./" . $directorio . "/";
			$nombreTmp = $_FILES['fichero']['tmp_name'];
			$nombreDef = $rutaDef . $_FILES['fichero']['name'];
			$resultado = copy($nombreTmp,$nombreDef);
			if ($resultado == 0) {
				unlink($nombreTmp);
			}

			echo "<h4> Fichero subido correctamente. </h4>";
			echo "<p>Contenido del directorio de destino: ".$rutaDef."</p>";
			$listadoFicheros = scandir($rutaDef);
			for ($i = 2; $i < count($listadoFicheros); $i++) {
				$nombreFichero = $listadoFicheros[$i];
				echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $nombreFichero . "<br>";
			}
		}
	?>
</body>
</html>
