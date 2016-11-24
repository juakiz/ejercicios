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

  <br><br><button><a href="./agregarNoticia.php" style="text-decoration:none;">Agregar noticia</a></button>

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
  $usuario = $clave = "";

  // Variables para mostrar los posibles errores encontrados al validar:
  $errorUsuario = $errorClave = "";

  // Validación:
  if( !empty($_POST) ){
    //print_r(array_values($_POST));
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['usuario']) && empty($_POST['usuario'])) {
          $errorUsuario = "El campo no puede estar vacio";
        } else {
          $usuario = procesarValor($_POST['usuario']);
        }


        if (isset($_POST['clave']) && empty($_POST['clave'])) {
          $errorClave = "El campo no puede estar vacio";
        } else {
          $clave = procesarValor($_POST['clave']);
        }

      }
  }

?>
<br>
<h2>ADMINISTRACIÓN</h2>
<p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  <table border="0">
    <tr>
        <td>Usuario:</td>	<td> <input type="text" name="usuario" placeholder="Introduzca el usuario..."> * <?php imprimeError($errorUsuario); ?></td>
    </tr>
    <tr>
        <td>Clave:</td>	<td> <input type="text" name="clave" placeholder="Introduzca la clave..."> * <?php imprimeError($errorClave); ?></td>
    </tr>
    <tr>
  			<td colspan="2"> <input type="submit" name="submit" value="AGREGAR"> </td>
    </tr>
  </table>
</form>

<?php
if(empty($errorUsuario) && empty($errorClave)){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!file_exists("usuarios.dat")){

      echo 'Error al abrir el archivo de passwords.';

    } else {

      $matching = fopen("usuarios.dat", "r");


      $existe = false;
      while(!feof($matching)){

        $linea = fgets($matching);
        $linea = trim($linea);
        $aLinea = explode("#", $linea);

        if($aLinea[0]==$usuario){
          $existe = true;
        }

      }

      fclose($matching);

      if($existe)
        imprimeError("Ya hay un usuario con ese nombre, por favor elige otro.");
      else {
        $anyade = fopen("usuarios.dat", "a");

          fputs($anyade, $usuario."#".$clave.PHP_EOL);

          echo "El usuario ".$usuario." con clave ".$clave." ha sido agregado.";

        fclose($anyade);
      }



    }
  }
}
?>

</body>
</html>