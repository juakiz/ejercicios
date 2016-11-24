<html>
<head></head>
<body>
  <h2>SUBE UN ARCHIVO COMPRIMIDO AL SERVIDOR</h2>
  <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Archivo: <input type="file" name="archivo"> <br>
  <input type="submit" name="enviar" value="SUBIR">
  </form> <hr>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_FILES['archivo']['name'])) {
    // Copia el archivo temporal a la carpeta de destino
    $carpetaDestino = "./upload_zip/";
    if (!is_dir($carpetaDestino))
      mkdir($carpetaDestino);

    $nombreTmp = $_FILES['archivo']['tmp_name'];
    $nombre = $_FILES['archivo']['name'];
    $nombreDef = $carpetaDestino . $nombre;
    $resultado = copy($nombreTmp,$nombreDef);
    // Borra el archivo temporal
    if ($resultado == 0)
      unlink($nombreTmp);

    // Crea el archivo .zip dentro de la carpeta de destino
    $nombreZip = $nombreDef . ".zip";
    $archivoZip = new ZipArchive;
    if ($archivoZip->open($nombreZip, ZipArchive::CREATE) !== TRUE)
      exit("No se puede crear el archivo".$archivoZip);

    // Añade el archivo al .zip
    $archivoZip->addFile($nombreDef, $nombre);
    // se puede añadir más archivos al mismo .zip: $archivoZip->addFile(otro,otro);
    // Cierra el archivo .zip
    $archivoZip->close();
    // Borra el archivo original subido para dejar solo el comprimido
    unlink($nombreDef);
    // Lista el directorio de Destino con todos los .zip
    echo "<h3>Listado de archivos subidos y comprimidos al servidor:</h3>";
    $listadoFicheros = scandir($carpetaDestino);

    for ($i = 2; $i < count($listadoFicheros); $i++) {
      $nombreFichero = $listadoFicheros[$i];
      echo $nombreFichero . "<br>";
    }
  }
  ?>
</body>
</html>
