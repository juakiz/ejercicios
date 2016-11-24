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
			if ($tamaño > 32000 || $tamaño == 0) {  // tamaño máximo 10 MB = 10000000 B
				$validacionOK = false;
				$errorValidacion .= "El tamaño ".$tamaño." excede el límite de 32 KB permitido.";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Centrar texto</title>
		 
		<style>
			.principal { font-family: arial; font-size: 20px; color: #0022DD; font-weight: bold; }
			.titulo { font-family: verdana; font-size: 15px; color: #0000DD; }
			.parrafo { font-family: arial; font-size: 12px; color: #0000DD; }
			.boton { height: 30px; width: 140px; border-radius:2px 2px 2px 2px; border:1px solid #00DDEE; background: #0000DD; font-family: Arial; font-size: 12px; color: #FFF; text-shadow: 0 1px #aa4040; font-weight: bold; }
		</style>
	</head>
<body> 	
	<p><span class="principal">
		CENTRAR TEXTO ONLINE
	</span></p> 
	
	<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<table>
	<tr>
	  <td><span class="titulo">Fichero:</span></td> 
	  <td><input type="file" name="fichero" style="height: 20px; border:1px solid #0000FF; font-family: Arial; font-size: 12px; color: #0000FF;"> </td>
	</tr>
    </table>
	<br>
	<input type="submit" name="enviar" value="SUBIR y CENTRAR" class="boton">
	</form>
	<hr>

<!-- FICHERO SUBIDO CON EL FORMULARIO -->
	<?php
	// Copia el archivo a la carpeta de destino y borra el archivo temporal
	$rutaDef = "./centrar/";
	if (!is_dir($rutaDef)) // Crea el directorio de destino si no existe
		mkdir($rutaDef);
	$nombreTmp = $_FILES['fichero']['tmp_name'];
	$nombreDef = $rutaDef . $_FILES['fichero']['name'];
	$resultado = copy($nombreTmp,$nombreDef);
	if ($resultado == 0)
		unlink($nombreTmp); // Borra el archivo temporal
	echo "<br>Fichero subido correctamente.<br><br>";
// Abre el archivo y centra el texto

if(!file_exists($nombreDef)){

  echo 'El archivo no existe';

} else {

	$original=$nombreDef;
	$centrado=$rutaDef."centrado_".$_FILES['fichero']['name'];

  $justificame = fopen($original, "r");
  $tejustifico = fopen($centrado, "w");

  $numeroCaracteres = 0;
  $numeroFilasTotal = 0;

  echo "<br>Contenido del fichero sin centrar.<br><br>";

  while(!feof($justificame)){
    $leeLinea = fgets($justificame);
    echo $leeLinea."<br>";
    //echo "<br>>>".$leeLinea."--> mide ".strlen($leeLinea);
    if(strlen($leeLinea)>$numeroCaracteres)
      $numeroCaracteres = strlen($leeLinea);
    $numeroFilasTotal++;
  }
  //echo "<br>>>La linea mas larga mide: ".$numeroCaracteres;
  echo "<br>Contenido del fichero centrado.<br><br>";

  rewind($justificame);
  $numeroFilasActual = 0;
  while(!feof($justificame)){
    
    $numeroFilasActual++;
    $leeLinea = fgets($justificame);

    //echo "<br>>>La linea leida mide: ".strlen($leeLinea);
      $numEspacios = ($numeroCaracteres-strlen($leeLinea))/2;

      if($numeroFilasTotal == $numeroFilasActual)
        $numEspacios -=2;
      //echo "<br>>>Numero de espacios: ".$numEspacios;
      $espacios = "";

      for($i=0 ; $i<$numEspacios ; $i++){
        $espacios .= " ";
      }
      
      //echo "<br>>>".$espacios.$leeLinea;
      fputs($tejustifico, $espacios.$leeLinea);

  }

  fclose($justificame);
  fclose($tejustifico);


  $tejustifico = fopen($centrado, "r");

  echo "<pre>";
  while (!feof($tejustifico)) {
      $linea = fgets($tejustifico);
      echo $linea;
  }
  echo "</pre>";
  fclose($tejustifico);

}

echo '<a href="'.$centrado.'">DESCARGAR ARCHIVO CENTRADO</a>'

?>
		
</body>
</html>