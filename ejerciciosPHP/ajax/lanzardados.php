<?php
$cuantos = $_REQUEST['cuantos'];
if ($cuantos > 0) {
	$resultado = "";
	for ($i = 0; $i < $cuantos; $i++) {
		$dado = rand(1,6);
		switch ($dado) {
			case 1:
				$resultado .= "&#9856"; break;
			case 2:
				$resultado .= "&#9857"; break;
			case 3:
				$resultado .= "&#9858"; break;
			case 4:
				$resultado .= "&#9859"; break;
			case 5:
				$resultado .= "&#9860"; break;
			case 6:
				$resultado .= "&#9861"; break;
		}
	}
} else {
	$resultado = "Cantidad de dados errónea";
}
echo $resultado; // código HTML devuelto a la página y que es recuperado por JavaScript
// mediante la propiedad responseText del objeto XMLHttpRequest
?>