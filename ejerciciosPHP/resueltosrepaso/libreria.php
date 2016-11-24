<!DOCTYPE html>
<html>
<body bgcolor=#FEFEFE>
	<p> <span style="font-family: arial; font-size: 22px; color: #0022DD; font-weight: bold;">
		Librería on-line
	</span>	</p>
	<hr>

	<?php
		echo "<br>";
		libxml_use_internal_errors(true);
		$Libreria = simplexml_load_file("catalogo.xml") or die("No se encuentra el archivo .xml");
		if ($Libreria === false)
			echo "Error en el archivo XML";
		
		// copiar todos los libros en un array para ordenarlo:
		$Libros = array();
		for ($i = 0; $i < count($Libreria->Libro); $i++) {
			$Libro = $Libreria->Libro[$i];
			$Libros[$i]['Titulo'] = $Libro->Titulo;
			$Libros[$i]['Autor'] = $Libro->Autor;
			$Libros[$i]['Precio'] = $Libro->Precio;
			$Libros[$i]['Novedad'] = $Libro->Novedad;
		}
		//print_r($Libros);
		
		// ordenar el array mediante el campo Precio usando el método de selección del máximo:
		for ($i = 0; $i < count($Libros)-1; $i++) {
			$precioMaximo = $Libros[$i]['Precio'];
			$tituloDelMaximo = $Libros[$i]['Titulo'];
			$autorDelMaximo = $Libros[$i]['Autor'];
			$novedadDelMaximo = $Libros[$i]['Novedad'];
			$posicionMaximo = $i;
			for ($j = $i+1; $j < count($Libros); $j++) {
				if ($Libros[$j]['Precio'] > (int)$precioMaximo) {
					$precioMaximo = $Libros[$j]['Precio'];
					$posicionMaximo = $j;
					$tituloDelMaximo = $Libros[$j]['Titulo'];
					$autorDelMaximo = $Libros[$j]['Autor'];
					$novedadDelMaximo = $Libros[$j]['Novedad'];
				}
			}
		
			$auxPrecio = $Libros[$i]['Precio'];
			$Libros[$i]['Precio'] = $precioMaximo;
			$Libros[$posicionMaximo]['Precio'] = $auxPrecio;
			
			$auxTitulo = $Libros[$i]['Titulo'];
			$Libros[$i]['Titulo'] = $tituloDelMaximo;
			$Libros[$posicionMaximo]['Titulo'] = $auxTitulo;
			
			$auxAutor = $Libros[$i]['Autor'];
			$Libros[$i]['Autor'] = $autorDelMaximo;
			$Libros[$posicionMaximo]['Autor'] = $auxAutor;
			
			$auxNovedad = $Libros[$i]['Novedad'];
			$Libros[$i]['Novedad'] = $novedadDelMaximo;
			$Libros[$posicionMaximo]['Novedad'] = $auxNovedad;
		}		
		
		echo "<table border=\"1\">";
		echo "<tr><th>Titulo</th><th>Autor</th><th>Precio</th></tr>";
			foreach ($Libros as $Libro) {
				echo "<tr><td>";
					echo $Libro['Titulo'];
				echo "</td><td>";
					echo $Libro['Autor'];
					if (strtoupper($Libro['Novedad']) == "SI") {
						echo "&nbsp;<img src=\"nuevo.gif\">";
					}					
				echo "</td><td>";
					echo $Libro['Precio'];
				echo "</td></tr>";
			}
		echo "</table>";
		
		
		
		
		/*
		echo "<table border=\"1\">";
		echo "<tr><th>Titulo</th><th>Autor</th><th>Precio</th></tr>";
			foreach ($Libreria->Libro as $Libro) {
				echo "<tr><td>";
					echo $Libro->Titulo;
				echo "</td><td>";
					echo $Libro->Autor;
					if (strtoupper($Libro->Novedad) == "SI") {
						echo "&nbsp;<img src=\"nuevo.gif\">";
					}					
				echo "</td><td>";
					echo $Libro->Precio;
				echo "</td></tr>";
			}
		echo "</table>";
		*/
	?>
</body>
</html>