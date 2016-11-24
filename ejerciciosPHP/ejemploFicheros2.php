<html>
  <head></head>
<body>  

<!-- VALIDACION -->
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

  // Variables para almacenar los valores leídos del formulario:
  $nombre = $apellidos = $edad = "";
  
  // Variables para almacenar los posibles errores encontrados:
  $errorNombre = $errorApellidos = $errorEdad = "";

  $validacionOK = true;
    // Validación:
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["nombre"])) { 
      $errorNombre = "Se requiere el nombre";
      $validacionOK = false;
    } else {
      $nombre = procesarValor($_POST["nombre"]);
      // Valida si el nombre solo contiene letras y espacios:
      if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
        $errorNombre = "Solo se permite letras y espacios"; 
    $validacionOK = false;
      }
    }

  if (empty($_POST["apellidos"])) { 
      $errorApellidos = "Se requiere los apellidos";
    $validacionOK = false;
    } else {
      $apellidos = procesarValor($_POST["apellidos"]);
      // Valida si los apellidos solo contienen letras y espacios:
      if (!preg_match("/^[a-zA-Z ]*$/",$apellidos)) {
        $errorApellidos = "Solo se permite letras y espacios"; 
    $validacionOK = false;
      }
    }
      if ($_POST["edad"] == "") { 
        $errorEdad = "Se requiere la edad";
    $validacionOK = false;
    } else {
       $edad = procesarValor($_POST["edad"]);
    if (!is_numeric($edad)) {  // Valida si la edad es un número
         $errorEdad = "Solo se permite números"; 
    $validacionOK = false;
      } else {
      if ($edad <= 0) {
        $errorEdad = "Número incorrecto para la edad"; 
        $validacionOK = false;
  } } }    }
?>

<h2>GUARDAR DATOS EN UN FICHERO</h2> <p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <table><tr>
  <td>Nombre:</td><td><input type="text" name="nombre" value="<?php echo $nombre;?>">
  * <?php imprimeError($errorNombre); ?></td>
  </tr><tr>
  <td>Apellidos:</td><td><input type="text" name="apellidos" value="<?php echo
  $apellidos;?>"> * <?php imprimeError($errorApellidos); ?></td>
  </tr><tr>
  <td>Edad:</td><td><input type="text" name="edad" value="<?php echo $edad;?>">
  * <?php imprimeError($errorEdad); ?></td>
  </tr>
  </table>
  <input type="submit" name="submit" value="ENVIAR">
</form>
<!-- VALORES LEIDOS DEL FORMULARIO -->
<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($validacionOK == true) {
      // Guarda los valores del formulario al final del archivo
      // Lo crea si no existe
      $fichero = fopen("datos.txt","a+");
      // Recorre los campos del formulario y los guarda en el archivo:
      foreach($_POST as $campo=>$valor) {
        if ($campo != "submit") {
          fputs($fichero, $campo.": ".$valor.PHP_EOL);
        }
      }
    
      echo "<span style= \"color: blue;\">";
      echo "<br><h3>Contenido del archivo:<br></h3>";
      // Lee todos los datos escritos hasta el momento:
      rewind($fichero);  // rebobina el fichero para colocarse al principio
      while (!feof($fichero)) {
        $linea = fgets($fichero);
        echo $linea,"<br>";
      }
      fclose($fichero);
      echo "</span>";
    }
  }
?>
</body>
</html>