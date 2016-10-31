<html>
  <head>
    <meta charset="UTF-8">
  </head>
<body>  

<?php
/*
Codifica un programa llamado justifica.php que abra un archivo de texto alojado en el
servidor y justifique a la derecha todas sus líneas. Las líneas justificadas serán almacenadas
en otro archivo a crear con el mismo nombre pero añadiéndole la palabra “_justificado”:
*/

if(!file_exists("justificame.txt")){

  echo 'El archivo no existe';

} else {

  $justificame = fopen("justificame.txt", "r");
  $tejustifico = fopen("justificame_justificado.txt", "w");

  $numeroCaracteres = 0;
  $numeroFilasTotal = 0;
  while(!feof($justificame)){
    $leeLinea = fgets($justificame);
    //echo "<br>>>".$leeLinea."--> mide ".strlen($leeLinea);
    if(strlen($leeLinea)>$numeroCaracteres)
      $numeroCaracteres = strlen($leeLinea);
    $numeroFilasTotal++;
  }
  //echo "<br>>>La linea mas larga mide: ".$numeroCaracteres;

  rewind($justificame);
  $numeroFilasActual = 0;
  while(!feof($justificame)){
    
    $numeroFilasActual++;
    $leeLinea = fgets($justificame);

    //echo "<br>>>La linea leida mide: ".strlen($leeLinea);
      $numEspacios = $numeroCaracteres-strlen($leeLinea);

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


  $tejustifico = fopen("justificame_justificado.txt", "r");

  echo "<pre>";
  while (!feof($tejustifico)) {
      $linea = fgets($tejustifico);
      echo $linea;
  }
  echo "</pre>";
  fclose($tejustifico);

}

?>
</body>
</html>

