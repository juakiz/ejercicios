<!DOCTYPE HTML>
<html>
  <head> <title> EJEMPLO DE VALIDACION </title> </head>
<body>  

<!-- VALIDACIÓN  -->
<?php

 function validarFecha ($fecha) {
    // Comprueba si $fecha tiene el formato requerido:  dd/mm/aaaa
    $valores = explode("/", $fecha);
    $dia = $valores[0];
    $mes = $valores[1];
    $anho = $valores[2];
    return checkDate($mes, $dia, $anho);
 }

  function imprimeError ($error) {
	echo "<span style = \"color: red;\">".$error."</span>";
  }

  // Variables para almacenar los valores leidos del formulario:
	$fecha = "";

  // Variables para mostrar los errores encontrados al validar:
	$errorFecha = "";
  
    // Validación:
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fecha"])) {
      $errorFecha = "Se requiere la fecha";
    } else {
      $nombre = procesarValor($_POST["nombre"]);
      // Valida si el nombre solo contiene letras y espacios:
      if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
        $errorNombre = "Solo se permite letras y espacios"; 
      }
    }
  
  }
?>

<!-- FORMULARIO -->
<h2>VALIDACI&Oacute;N DE UNA FECHA CON PHP</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Fecha: <input type="text" name="fecha" value="">
    * <?php imprimeError($errorFecha); ?>
  <br><br>

  <input type="submit" name="submit" value="ENVIAR">
</form>



<!-- VALORES LEIDOS DEL FORMULARIO: -->
<?php
   echo "<span style= \"color: blue;\">";
   echo "<br><br><h2>Datos introducidos:</h2>";
   echo "Nombre: " . $fecha . "<br>";
   echo "</span>";
  
?>

</body>
</html>