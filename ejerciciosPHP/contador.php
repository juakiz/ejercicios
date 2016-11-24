<html>
  <head></head>
<body>  

<?php

/*
ACTIVIDAD: creación de un contador de visitas
• Desarrolla un script llamado contador.php que muestre un contador de
visitas que será almacenado en un archivo local al servidor.
• Cuando se visite esta página, deberá mostrar al usuario cuántas visitas
lleva la web (incluyéndole a él); y la fecha y hora del último usuario que la
visitó (el anterior a él).
• Para mostrar la cantidad de visitas, debes usar imágenes para cada uno
de los dígitos del número de visitas:
Lenguaje PHP: ficheros

La primera vez que se visite la web se creará el
archivo para el contador y se almacenará un 1. Las
siguientes visitas se abrirá el archivo para leer su
valor y luego actualizarlo.
*/

if(file_exists("visitas.txt")){

  $contadorVisitas = fopen("visitas.txt","r");

  $numeroActual = fgets($contadorVisitas);

  fclose($contadorVisitas);

  $contadorVisitas = fopen("visitas.txt","w");

  $numeroActual++;

  fputs($contadorVisitas, $numeroActual);

  fclose($contadorVisitas);

} else {

  $contadorVisitas = fopen("visitas.txt", "w");

  fputs($contadorVisitas, "1");

  $numeroActual = 1;

  fclose($contadorVisitas);
}


  //descomponer $numeroActual en sus dígitos para aplicar imagen
  $i=0;
  
  do{

  	$imagen = substr($numeroActual, $i, 1);

  	$i++;

  	echo '<img src="./digitos/'.$imagen.'.jpg"/>';

  }while(($numeroActual * pow(10,-$i))>=1);

?>
</body>
</html>

