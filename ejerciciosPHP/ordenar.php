<?php

	$vector;
	for ($i = 0; $i < 10; $i++)
		$vector[$i] = rand(1,50);

	echo "<h3>Array desordenado:  </h3>";
	foreach ($vector as $valor)
		echo $valor."  ";
		
	for ($i = 0; $i < count($vector)-1; $i++) {
		$minimo = $vector[$i];
		$posicionMinimo = $i;
		for ($j = $i+1; $j < count($vector); $j++) {
			if ($vector[$j] < $minimo) {
				$minimo = $vector[$j];
				$posicionMinimo = $j;
			}
		}
		
		$aux = $vector[$i];
		$vector[$i] = $minimo;
		$vector[$posicionMinimo] = $aux;
	}
	
	echo "<br><br>";
	echo "<h3>Array ordenado:     </h3>";
	foreach ($vector as $valor)
		echo $valor." ";
	


?>