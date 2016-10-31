<?php
   $f1 = fopen("fichero.txt","w+");    // borra el contenido y lo crea si no existe
   fputs($f1,"Primera linea<br>\r\n"); // escribe al inicio del fichero. Salto de línea!
   fclose($f1);   				     // cierra el fichero

   $f1 = fopen("fichero.txt","a+"); 	// abrimos para añadir al final (append)
   fputs($f1,"Añadido al final<br>\r\n");
   fclose($f1);

   echo "<br><H2>Contenido del fichero:</H2>";	 // imprime el contenido del fichero 	
   include("fichero.txt");

   $f1 = fopen("fichero.txt","r");     // abrimos para leer desde el principio
   echo "<br><h2>Lee los 2 primeros caracteres de la primera línea:</h2>";
   $c = fgetc($f1);		echo "Primer carácter: ",$c,"<br>";
   $c = fgetc($f1);		echo "Segundo carácter: ",$c,"<br>";
   fclose($f1);

   echo "<br><H2>Contenido de todo el fichero:</h2>";
   $f1 = fopen("fichero.txt","r");     // lo abre desde el principio
   while (!feof($f1)) {
	$linea = fgets($f1);
	echo $linea;
   }
   fclose($f1);

   unlink("fichero.txt");   // borra el fichero
?>