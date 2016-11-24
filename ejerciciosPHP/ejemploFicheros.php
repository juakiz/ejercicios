<?php
   if (file_exists("fichero.txt")) {
	  echo "<br><H2>Contenido del fichero:</H2>";
	
	  // lee el fichero en una única string
	  $lineasDelFichero = readfile("fichero.txt");
	  echo $lineasDelFichero, "<br><br>";

	  // muestra el contenido del fichero
      include("fichero.txt"); 	  
	  echo "<br><br>";
	
	  // lee el fichero y lo guarda en un array que se muestra por líneas
	  $arrayLineasDelFichero = file("fichero.txt");
	  foreach($arrayLineasDelFichero as $linea=>$texto) {
	 	  echo "Linea: ",$linea," Texto: ",$texto,"<br>";
	  }

	  echo "<br><br>Ultima modificación a las: <br>";
	  echo date("h:i:s A", filemtime ("fichero.txt"));
	  echo "<br>del día: <br>";
	  echo date("j-n-Y", filemtime ("fichero.txt"));
   } else
	  echo "El fichero \"fichero.txt\" no existe";
?>