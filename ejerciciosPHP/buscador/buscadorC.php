<?php
	session_cache_limiter('nocache');
	header('Expires: ' . gmdate('r', 0));

	header('Content-type: application/json');

	libxml_use_internal_errors(true);
	$Coches = simplexml_load_file("coches.xml") or die("No se encuentra el archivo .xml");
	if ($Coches === false)
		echo "Error en el archivo XML";

	// Pasar de xml a array, pasando por json:
	$json = json_encode($Coches);
	//echo var_dump($json);
	$arrayCoches = json_decode($json,TRUE);
	//echo var_dump($arrayCoches);

	//echo json_encode($arrayCoches);

	//echo '<pre>'; foreach($arrayCoches as $coche) echo print_r($coche)."\n"; echo '</pre>';

	if(isset($_REQUEST['valoresSelect'])){
		$arrayValores = $_REQUEST['valoresSelect'];
		//echo json_encode($arrayValores);
		buscarCoches($arrayCoches, $arrayValores);
	}

	//$arrayValores = array("marca"=>"TODOS", "motor"=>"TODOS", "anyo"=>"TODOS", "km"=>"TODOS", "precio"=>"TODOS");

	//buscarCoches($arrayCoches, $arrayValores);

	function buscarCoches ($arrayCoches, $arrayValores) {
		$arrayCochesEncontrados = array();
		//echo ">>".print_r($arrayCoches,0)."<br>";
		foreach ($arrayCoches["Coche"] as $Coche) {
			//echo json_encode($Coche);
			if ((strtoupper($Coche["Marca"]) == $arrayValores["Marca"] || $arrayValores["Marca"] == "TODOS") && 
				(strtoupper($Coche["Motor"]) == $arrayValores["Motor"] || $arrayValores["Motor"] == "TODOS") &&
				($Coche["Anyo"] == $arrayValores["Anyo"] || $arrayValores["Anyo"] == "TODOS") &&
				($Coche["Km"] <= $arrayValores["Km"] || $arrayValores["Km"] == "TODOS") &&
				($Coche["Precio"] <= $arrayValores["Precio"] || $arrayValores["Precio"] == "TODOS")) {
					array_push($arrayCochesEncontrados, $Coche);
			}
		}
		echo json_encode($arrayCochesEncontrados);
	}

	/*
	function listarValores ($arrayCoches, $atributo) {
		$resultado = array();
			
		foreach ($arrayCoches as $Coche) {
			switch ($atributo) {
				case "marca":
					$valor = (string)$Coche->Marca;
					break;
				case "motor":
					$valor = (string)$Coche->Motor;
					break;
				case "anyo":
					$valor = (string)$Coche->Anyo;
					break;
				case "km":
					$valor = (string)$Coche->Km;
					break;
				case "precio":
					$valor = (string)$Coche->Precio;
					break;
				default:
					break;
			}
			
			if (!in_array($valor, $resultado)) {
				array_push($resultado, $valor);
			}
		}
		sort($resultado);
		array_unshift($resultado, "TODOS");
		//echo count($resultado);
		return $resultado;
	}
	

	function mostrarTablaCoches ($arrayCoches) {
		echo "<span class=\"titulo\">".count($arrayCoches)." coches encontrados</span>";
		echo "<br><br>";
		echo "<table class=\"titulo\" style=\"border:1px solid #0000DD; width:630px; text-align:center;\" border=\"0\" cellpadding=\"2\">";
		echo "<tr><th> </th><th>Marca</th><th>Modelo</th><th>Anyo</th><th>Motor</th><th>Km</th><th>Precio</th></tr>";
		for ($i = 0; $i < count($arrayCoches); $i++) {
			$Coche = $arrayCoches[$i];
			echo "<tr onMouseOver=\"cambiarColorOver(this)\" onMouseOut=\"cambiarColorOut(this)\" onClick=\"mostrarCoche(".$Coche->ID.")\">";
			echo "<td>";
				echo "<img id=\"".$Coche->ID."\" src=\"".$Coche->URLImagen."\" width=\"98\" height=\"70\">";
			echo "</td><td>";
				echo $Coche->Marca;
			echo "</td><td>";
				echo $Coche->Modelo;
			echo "</td><td>";
				echo $Coche->Anyo;
			echo "</td><td>";
				echo $Coche->Motor;
			echo "</td><td>";
				echo $Coche->Km;
			echo "</td><td>";
				echo $Coche->Precio." €";
			echo "</td></tr>";
		}
		echo "</table>";
	}
	
	function buscarCoches ($arrayCoches, $marca, $motor, $anyo, $km, $precio) {
		$arrayCochesEncontrados = array();
		foreach ($arrayCoches as $Coche) {
			if ((strtoupper($Coche->Marca) == $marca || $marca == "TODOS") && 
				(strtoupper($Coche->Motor) == $motor || $motor == "TODOS") &&
				($Coche->Anyo == $anyo || $anyo == "TODOS") &&
				($Coche->Km <= $km || $km == "TODOS") &&
				($Coche->Precio <= $precio || $precio == "TODOS")) {
					array_push($arrayCochesEncontrados, $Coche);
			}
		}	
		return $arrayCochesEncontrados;
	}*/
?>