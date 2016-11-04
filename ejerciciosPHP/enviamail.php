<!DOCTYPE HTML>  
<html>
  <head><title>ENVÍO DE INCIDENCIAS</title>
  <style>
	td { color:white;
		 font-family:verdana;
		 font-size:14px;
	   };
  </style>
  </head>
<body bgcolor=#5591BB> 

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
  $asunto = $Identificador = $fecha = $descripcion = $email = "";
  
  // Variables para mostrar los posibles errores encontrados al validar:
  $errorAsunto = $errorIdentificador = $errorFecha = $errorDescripcion = $errorEmail = "";

  // Validación:
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['asunto'])) {
      $errorAsunto = "El campo no puede estar vacio";
    } else {
      $asunto = procesarValor($_POST['asunto']);
    }

    if(isset($_POST['urgente'])){
      $urgente = "Si";
    } else {
       $urgente = "No";
    }

    $tipo = procesarValor($_POST['tipo']);
    
    if (empty($_POST['fecha'])) {
      $errorFecha = "El campo no puede estar vacio";
    } else {
      $fecha = procesarValor($_POST['fecha']);
    }

    if (empty($_POST['identificador'])) {
      $errorIdentificador = "El campo no puede estar vacio";
    } else {
      $identificador = procesarValor($_POST['identificador']);
    }

    if (empty($_POST['email'])) {
      $errorEmail = "El campo no puede estar vacio";
    } else {
      $email = procesarValor($_POST['email']);
    } 

    if (empty($_POST['descripcion'])) {
      $errorDescripcion = "El campo no puede estar vacio";
    } else {
      $descripcion = procesarValor($_POST['descripcion']);
    }

    // String con todos los errores
    $erroresTotales = "";
    $erroresTotales .= $errorAsunto . $errorIdentificador . $errorFecha . $errorDescripcion . $errorEmail;

  }

?>
<br>
<font color="#00EE00" face="verdana" size="4">ENVÍO DE INCIDENCIAS POR EMAIL</font>
<p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
<table border="0">
  <tr>
      <td>Asunto:</td>		<td> <input type="text" name="asunto" placeholder="Resumen..."> * <?php imprimeError($errorAsunto); ?></td>
  </tr>
  <tr>
      <td>Urgente:</td>		<td> <input type="checkbox" name="urgente"></td>
  </tr>
  <tr>
      <td>Tipo:</td>		<td>
						<input type="radio" name="tipo" value="Hardware" checked>Hardware<br>
						<input type="radio" name="tipo" value="Redes">Redes<br>
						<input type="radio" name="tipo" value="Software">Software<br>
						</td>
  </tr>
  <tr>
      <td>Fecha:</td>					<td> <input type="date" name="fecha"> * <?php imprimeError($errorFecha); ?></td>
  </tr>
  <tr>
      <td>Identificador:</td>			<td> <input type="number" name="identificador" placeholder="1"> * <?php imprimeError($errorIdentificador); ?></td>
  </tr>
  <tr>
      <td>E-mail de contacto:</td>		<td> <input type="email" name="email" placeholder="usuario@mail.com"> * <?php imprimeError($errorEmail); ?></td>
  </tr>
  <tr>
      <td>Descripción:</td>				<td> <textarea rows="10" cols="21" name="descripcion" placeholder="Por favor, detalle su incidencia..."></textarea> * <?php imprimeError($errorDescripcion); ?></td>
  </tr>
  <tr>
			<td colspan="2"> <input type="submit" name="submit" value="ENVIAR"> </td>
  </tr>
</table>
</form>

<?php
  
// Enviar Mail con PHPMailer

if(empty($erroresTotales)){
  require_once('./../PHPMailer-master/class.phpmailer.php');
  $destinatario = "juakizpruebas@gmail.com";
  //$asunto = "Probando mails desde php";
  $texto = 
  "Urgente: " . 
  $descripcion;
  enviarEmail($destinatario, $asunto, $texto);
  function enviarEmail($direccion, $asunto, $texto){
    $mail = new phpmailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    // Rellenar los datos con una cuenta de GMail:
    $mail->Host = "smtp.googlemail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->Username = "juakizpruebas@gmail.com"; // Cuenta del emisor
    $mail->Password = "gatitogatito"; // Contraseña del emisor
    $mail->From = "juakizpruebas@gmail.com"; // Dirección del emisor
    $mail->FromName = "FULANITO DE TAL"; // Remitente que le aparece al receptor
    $mail->Timeout=30;
    $mail->AddAddress($direccion); // Dirección del destinatario
    $mail->Subject = $asunto; // Asunto del email
    $mail->Body = $texto; // Contenido del email
    $mail->AltBody = $texto; // Contenido del email alternativo
    $exito = $mail->Send();
    $intentos=1;
    while ((!$exito) && ($intentos < 5)) {
      sleep(5);
      $exito = $mail->Send();
      $intentos++;
    }
    if (!$exito) {
      echo "<p style=\"color:red;\"> No se ha podido enviar el correo
      electronico: " . $mail->ErrorInfo . "</p>";
    } else {
      echo "<p style=\"color:green;\"> Mensaje enviado a " . $direccion . "
      correctamente.</p>";
    }
  }
} else{
  echo "<br><br>No se ha enviado el email porque se han detectado errores.";
}
?>
</body>
</html>