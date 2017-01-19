<?php

	function crearSelect ($arrayCoches, $atributo, $valor) {
		$arrayValores = listarValores($arrayCoches, $atributo);
		echo "<select name=\"".$atributo."\" style=\"width:100px;\">";
			foreach ($arrayValores as $v) {
				if (strtoupper($v) == $valor)
					$seleccionado = "selected";
				else
					$seleccionado = "";
				echo "<option value=\"".$v."\" ".$seleccionado.">".$v."</option>";
			}
		
		echo "</select>";
	}


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
		echo "<span class=\"titulo\">".count($arrayCoches)." coches encontrados"."</span>";
		echo "<br><br>";
		echo "<table class=\"titulo\" style=\"border:1px solid black; width:600px; text-align:center;\" border=\"0\" cellpadding=\"2\">";
		echo "<tr><th> </th><th>Marca</th><th>Modelo</th><th>Motor</th><th>Km</th><th>Precio</th></tr>";
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
				echo $Coche->Motor;
			echo "</td><td>";
				echo $Coche->Km;
			echo "</td><td>";
				echo $Coche->Precio." €";
			echo "</td></tr>";
		}					
		echo "</table>";
	}
	
	function buscarCoches ($arrayCoches, $marca, $motor, $km, $precio) {
		$arrayCochesEncontrados = array();
		foreach ($arrayCoches as $Coche) {
			if ((strtoupper($Coche->Marca) == $marca || $marca == "TODOS") && 
				(strtoupper($Coche->Motor) == $motor || $motor == "TODOS") &&
				($Coche->Km <= $km || $km == "TODOS") &&
				($Coche->Precio <= $precio || $precio == "TODOS")) {
					array_push($arrayCochesEncontrados, $Coche);
			}
		}	
		return $arrayCochesEncontrados;
	}
?>