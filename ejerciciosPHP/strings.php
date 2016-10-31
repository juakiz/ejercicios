<?php

/* 1) Desarrollar una simple aplicación en PHP que compruebe si un número es capicúa: si se lee igual de izquierda a derecha que al revés.
 Por ejemplo, si el usuario introduce el número “2332”, “181”, “44” ó “7”, el programa devolverá en todos los casos que sí son capicúas.*/

	$numero = "37869";
	$numero2 = "37873";

	function capicua ($num){

		$compnum = substr($num,strlen($num)-1,0);

		for( $i=strlen($num)-1 ; $i>=0 ; $i-- ){

			$compnum .= substr($num,$i,1);

		}

		echo "<br>num es ".$num;
		echo "<br>compnum es ".$compnum;

		if($compnum==$num)
			echo "<br>Es capicua.";
		else
			echo "<br>No es capicua.";

	}

	capicua($numero);
	capicua($numero2);

/* 2) Desarrolla un programa en PHP que permita insertar una cadena dentro de otra. Recibirá como valores de entrada:
una primera cadena, una segunda cadena y una posición donde insertar la segunda en la primera. 
Deberemos comprobar previamente que la posición no es negativa y que es menor o igual que la posición final. 
Por ejemplo, para las cadenas “HOLA MUNDO” y “a todo el “; y la posición 5; el programa devolverá la cadena “HOLA a todo el MUNDO”.*/

$cadenaMain = "HOLA MUNDO";
$cadenaIn = "a todo el ";

function insertar ($str1, $str2, $pos){

	if($pos<(strlen($str1)-1) || $pos>0){

		$a = substr($str1,0,$pos);
		$b = substr($str1,$pos);

		$final = "<br>".$a.$str2.$b;

		return $final;

	}else{
		return "<br>La posicion esta fuera de rango de la cadena.";
	}
}

	$resultado = insertar($cadenaMain,$cadenaIn,5);

	echo $resultado;

?>