<html>
  <head>
    <meta charset="UTF-8">
  </head>
<body>  

<?php
/*
Elabora un programa llamado recuento.php capaz de leer un archivo de texto guardado
en el servidor y mostrarle al usuario:
- El número de líneas que tiene.
- El número de palabras que contiene.
- El número total de caracteres que contiene (incluyendo los espacios en blanco).
- El número de letras A (mayúsculas y minúsculas) que hay presentes.
*/

if(!file_exists("recuento.txt")){

  echo 'El archivo no existe';

} else {

  $recuento = fopen("recuento.txt", "r");

  //cuenta las lineas
  $numeroLineas = 0;
  while(!feof($recuento)){
    $linea = fgets($recuento);
    $numeroLineas++;
  }
  
  if($numeroLineas>1)
    echo "El fichero tiene ".$numeroLineas." lineas.";
  else if ($numeroLineas==1)
    echo "El fichero tiene una linea.";
  else
    echo "El fichero está vacio.";

  echo "<br>";

  //cuenta las palabras buscando los espacios
  rewind($recuento);
  $numeroPalabras = 0;
  while(!feof($recuento)){
    $linea = fgets($recuento);
    $aLinea = explode(" ", $linea);
    $numeroPalabras += count($aLinea);
  }

  echo "El fichero tiene ".$numeroPalabras." palabras.";

  echo "<br>";

  //cuenta el numero de caracteres y la cantidad de Aes y aes
  rewind($recuento);
  $archivoString = "";
  $numeroCaracteres = 0;
  $aes = 0;
  while(!feof($recuento)){
    $char = fgetc($recuento);
    $numeroCaracteres++;
    if($char == "a" || $char == "A")
      $aes++;
  }

  echo "El fichero tiene ".$numeroCaracteres." caracteres.";

  echo "<br>";

  echo "El fichero tiene ".$aes." a/A.";

  echo "<br>";

  fclose($recuento);
}

?>
</body>
</html>

