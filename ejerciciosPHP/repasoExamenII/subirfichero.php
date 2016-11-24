<!--
Elabora un programa en PHP llamado
subirfichero.php capaz de subir un fichero (de
cualquier tipo pero que no exceda los 10 MB) a un
directorio particular del servidor. El usuario indicará
en un formulario el archivo a subir y el directorio
remoto donde copiarlo. Los directorios de destino
que podrá elegir el usuario para subir su fichero
deben ser subdirectorios de la carpeta pública del
server (los subdirectorios de C:\xampp\htdocs).
Tras subir el archivo, la página le listará el contenido
de dicho directorio:
-->
<html>
<head>
  <meta charset="utf-8">
  <style type="text/css">
    body{
      color:blue;
    }
  </style>
</head>
<body>
  <h2>SUBIDA DE FICHEROS AL SERVIDOR</h2>
  <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    Sólo se puede subir ficheros de hasta 10 MB <br>
    <table>
      <tr>
        <td>Fichero:</td>
        <td><input type="file" name="archivo"> </td>
      </tr>
      <tr>
        <td>Directorio del servidor:</td>
        <td>
          <select>
            <option>Imágenes</option>
            <option>Texto</option>
            <option>Zip</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" name="enviar" value="ENVIAR">
        </td>
      </tr>
    </table>
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
