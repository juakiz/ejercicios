<!-- 
Programa una aplicación llamada eliminarsubcadena.php que permita al usuario introducir mediante un formulario: una cadena de texto, una posición inicial y una posición

final. La aplicación imprimirá otra cadena que es el resultado de eliminarle a la cadena del usuario los caracteres

comprendidos entre la posición inicial y final indicadas (ambos incluidos). Deberemos validar previamente que la cadena del

usuario no está vacía; que la posición inicial no es negativa, es menor o igual que la posición final; y que la posición final no

excede del número de caracteres de la cadena. Sólo puedes emplear la función de PHP substr($cadena, $inicio, $cuantos).

Por ejemplo, si el usuario introdujese la cadena “HOLA MUNDO” y especificase eliminar la subcadena comprendida

entre los caracteres de las posiciones 2 y 6; la web devolverá “HONDO”.

-->

<!DOCTYPE HTML>  
<html>
  <head></head>
<body>  

<!-- VALIDACIÓN  -->
<?php
  function procesarValor (&$dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
  }

  function imprimeError ($error) {
    echo "<span style = \"color: red;\">".$error."</span>";
  }

  // Variables para almacenar los valores leidos del formulario:
  $cadena = $inicio = $fin = "";
  
  // Variables para mostrar los posibles errores encontrados al validar:
  $errorCadena = $errorInicio = $errorFin = "";

  // Validación:
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['cadena'])) {
      $errorCadena = "Se requiere la cadena";
    } else {
        $cadena = $_POST['cadena'];
    }
  
    if (empty($_POST['inicio'])) {
      $errorInicio = "Se requiere la posición inicial";
    } else {
      $inicio = procesarValor($_POST['inicio']);
      if (!is_numeric($inicio)) {
        $errorInicio = "La posición inicial debe ser un número"; 
      } else {
          if ($inicio < 0) {
            $errorInicio = "La posición inicial no puede ser menor que 0"; 
          }
      }
    }
    
    if (empty($_POST['fin'])) {
      $errorFin = "Se requiere la posición final";
    } else {
      $fin = procesarValor($_POST['fin']);
      if (!is_numeric($fin)) {
        $errorFin = "La posición final debe ser un número"; 
      } else {
          if ($fin < $inicio || $fin >= strlen($cadena)) {
            $errorFin = "La posición final es incorrecta"; 
          }
      }
    }


  }
?>


<!-- FORMULARIO -->
<h2>EXTRAER SUBCADENA</h2>
<p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Cadena: <input type="text" name="cadena" value="<?php echo $cadena;?>">
  * <?php imprimeError($errorCadena); ?>
  <br><br>
  Inicio: <input type="text" name="inicio" value="<?php echo $inicio;?>">
  * <?php imprimeError($errorInicio); ?>
  <br><br>
  Fin: <input type="text" name="fin" value="<?php echo $fin;?>">
  * <?php imprimeError($errorFin); ?>
  <br><br>
  <input type="submit" name="submit" value="ENVIAR">
</form>


<!-- VALORES LEIDOS DEL FORMULARIO: -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   $cadenaInicial = substr($cadena, 0, $inicio);
   $cadenaFinal = substr($cadena, $fin+1);
   $resultado = $cadenaInicial . $cadenaFinal;
   echo "<br>Resultado: <h2>".$resultado."</h2>";
   
}
?>
</body>
</html>