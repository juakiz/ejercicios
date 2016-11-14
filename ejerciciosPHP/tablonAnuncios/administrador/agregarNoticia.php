<!DOCTYPE HTML>
<html>
  <head><title>Administrar Tablon</title>
  <style>
	td { color:white;
		 font-family:verdana;
		 font-size:14px;
	   };
  </style>
  </head>
<body bgcolor=#00BBAA>

  <button><a href="./index.php" style="text-decoration:none;">LOG OUT</a></button>

  <br><br>
  <button><a href="./agregarUsuario.php" style="text-decoration:none;">Agregar usuario</a></button>

<?php

// Validacion

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
  $X = $Y = $ancho = $alto = $color = $tamano = $texto = "";

  // Variables para mostrar los posibles errores encontrados al validar:
  $errorX = $errorY = $errorAncho = $errorAlto = $errorColor = $errorTamano = $errorTexto = "";

  $sinErrores = true;

  // Validación:
  if( !empty($_POST) ){
    //print_r(array_values($_POST));
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['X']) && empty($_POST['X'])) {
          $errorX = "El campo no puede estar vacio";
          $sinErrores = false;
        } else if (!ctype_digit($_POST['X'])){
          $errorX .= " El valor tiene que ser numerico y positivo.";
          $sinErrores = false;
        } else {
          $X = procesarValor($_POST['X']);
        }


        if (isset($_POST['Y']) && empty($_POST['Y'])) {
          $errorY = "El campo no puede estar vacio";
          $sinErrores = false;
        } else if (!ctype_digit($_POST['Y'])){
          $errorY .= " El valor tiene que ser numerico y positivo.";
          $sinErrores = false;
        } else {
          $Y = procesarValor($_POST['Y']);
        }

        if (isset($_POST['ancho']) && empty($_POST['ancho'])) {
          $errorAncho = "El campo no puede estar vacio";
          $sinErrores = false;
        } else if (!ctype_digit($_POST['ancho'])){
          $errorAncho .= " El valor tiene que ser numerico y positivo.";
          $sinErrores = false;
        } else {
          $ancho = procesarValor($_POST['ancho']);
        }

        if (isset($_POST['alto']) && empty($_POST['alto'])) {
          $errorAlto = "El campo no puede estar vacio";
          $sinErrores = false;
        } else if (!ctype_digit($_POST['alto'])){
          $errorAlto .= " El valor tiene que ser numerico y positivo.";
          $sinErrores = false;
        } else {
          $alto = procesarValor($_POST['alto']);
        }

        if (isset($_POST['color']) && empty($_POST['color'])) {
          $errorColor = "El campo no puede estar vacio";
          $sinErrores = false;
        } else {
          $color = procesarValor($_POST['color']);
        }

        if (isset($_POST['tamano']) && empty($_POST['tamano'])) {
          $errorTamano = "El campo no puede estar vacio";
          $sinErrores = false;
        } else if (!ctype_digit($_POST['tamano'])){
          $errorTamano .= " El valor tiene que ser numerico y positivo.";
          $sinErrores = false;
        } else {
          $tamano = procesarValor($_POST['tamano']);
        }

        if (isset($_POST['texto']) && empty($_POST['texto'])) {
          $errorTexto = "El campo no puede estar vacio";
          $sinErrores = false;
        } else {
          $texto = procesarValor($_POST['texto']);
        }
      }
  }

?>
<br>
<h2>ADMINISTRACION</h2>
<p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  <table border="0">
    <tr>
        <td>X:</td>	<td> <input type="text" name="X"> * <?php imprimeError($errorX); ?></td>
    </tr>
    <tr>
        <td>Y:</td>	<td> <input type="text" name="Y"> * <?php imprimeError($errorY); ?></td>
    </tr>
    <tr>
        <td>Ancho:</td>	<td> <input type="text" name="ancho"> * <?php imprimeError($errorAncho); ?></td>
    </tr>
    <tr>
        <td>Alto:</td>	<td> <input type="text" name="alto"> * <?php imprimeError($errorAlto); ?></td>
    </tr>
    <tr>
        <td>Color Texto:</td>	<td> <input type="color" name="color"></td>
    </tr>
    <tr>
        <td>Tamano Texto:</td>	<td> <input type="text" name="tamano"> * <?php imprimeError($errorTamano); ?></td>
    </tr>
    <tr>
        <td>Texto Noticia:</td>	<td> <input type="text" name="texto"> * <?php imprimeError($errorTexto); ?></td>
    </tr>
    <tr>
  			<td colspan="2"> <input type="submit" name="submit" value="AÑADIR"> </td>
    </tr>
  </table>
</form>

<?php
if($sinErrores){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $noticias = fopen("./../Noticias.xml", "r+");

      $addUser = "string_for_new_user\n?>";
      fseek($noticias, -12, SEEK_END);

      fputs($noticias, "".PHP_EOL);
      fputs($noticias, " <Noticia>".PHP_EOL);
      fputs($noticias, "   <X>".$X."px</X>".PHP_EOL);
      fputs($noticias, "   <Y>".$Y."px</Y>".PHP_EOL);
      fputs($noticias, "   <Ancho>".$ancho."px</Ancho>".PHP_EOL);
      fputs($noticias, "   <Alto>".$alto."px</Alto>".PHP_EOL);
      fputs($noticias, "   <ColorTexto>".$color."</ColorTexto>".PHP_EOL);
      fputs($noticias, "   <TamanoTexto>".$tamano."px</TamanoTexto>".PHP_EOL);
      fputs($noticias, "   <Texto>".$texto."</Texto>".PHP_EOL);
      fputs($noticias, " </Noticia>".PHP_EOL);
      fputs($noticias, "</Noticias>".PHP_EOL);

      fclose($noticias);
  }
} else {
  imprimeError("Algo ha fallado, no se ha insertado la noticia...");
}
?>

</body>
</html>
