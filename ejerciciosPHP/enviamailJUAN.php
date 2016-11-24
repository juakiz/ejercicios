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
  $asunto = $urgente = $tipo = $fecha = $identificador = $email = $descripcion = "";
  
  // Variables para mostrar los posibles errores encontrados al validar:
  $errorAsunto = $errorDescripcion = "";
  $validacionOK = true;
  
  // Validación:
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $asunto = procesarValor($_POST['asunto']);
	  if (isset($_POST['urgente']))
		$urgente = true;
	  else	
		$urgente = false;
	  $tipo = procesarValor($_POST['tipo']);
	  $fecha = procesarValor($_POST['fecha']);
	  $identificador = procesarValor($_POST['identificador']);
	  $email = procesarValor($_POST['email']);
	  $descripcion = procesarValor($_POST['descripcion']);
  }
?>


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
<br>
<font color="#00EE00" face="verdana" size="4">ENVÍO DE INCIDENCIAS POR EMAIL</font>
<p>* campo obligatorio</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  
<table border="0">
  <tr>
  <td>Asunto:</td>		<td> <input type="text" name="asunto" value="<?php echo $asunto; ?>" required> * </td>
  </tr>
  <tr>
  <td>Urgente:</td>		<td> <input type="checkbox" name="urgente" <?php if ($urgente == true) echo "checked"; ?>></td>
  </tr>
  <tr>
  <td>Tipo:</td>		<td>
						<input type="radio" name="tipo" value="hardware" <?php if ($tipo == "hardware") echo "checked"; ?> required>Hardware<br>
						<input type="radio" name="tipo" value="redes" <?php if ($tipo == "redes") echo "checked"; ?> required>Redes<br>
						<input type="radio" name="tipo" value="software" <?php if ($tipo == "software") echo "checked"; ?> required>Software<br>
						</td>
  </tr>
  <tr>
  <td>Fecha:</td>					<td> <input type="date" name="fecha" required value="<?php echo $fecha; ?>"> * </td>
  </tr>
  <tr>
  <td>Identificador:</td>			<td> <input type="number" name="identificador" min="1" value="<?php echo $identificador; ?>" required> * </td>
  </tr>
  <tr>
  <td>E-mail de contacto:</td>		<td> <input type="email" name="email" value="<?php echo $email; ?>" required> * </td>
  </tr>
  <tr>
  <td>Descripción:</td>				<td> <textarea name="descripcion" rows="10" cols="21" required><?php echo $descripcion; ?></textarea> * </td>
  </tr>
  <tr>
			<td colspan="2"> <input type="submit" name="submit" value="ENVIAR"> </td>
  </tr>
</table>
</form>
</body>
</html>

<?php

function enviarEmail($direccion, $asunto, $texto) {
		$mail = new phpmailer();
		$mail->IsSMTP();
		$mail->Mailer = "smtp";
		// Rellenar los datos con una cuenta de GMail:
		$mail->Host = "smtp.googlemail.com";
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Port = 465;
		$mail->Username = "ALUMNO@gmail.com"; // Cuenta del emisor
		$mail->Password = "CLAVE"; // Contraseña del emisor
		$mail->From = "ALUMNO@gmail.com"; // Dirección del emisor
		$mail->FromName = "ALUMNO"; // Remitente que le aparece al receptor
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
		if ($exito) {
			echo "<p style=\"color:green;\"> Mensaje enviado a " . $direccion . "correctamente.</p>";
		} else {
			echo "<p style=\"color:red;\"> No se ha podido enviar el correo electronico: " . $mail->ErrorInfo . "</p>";
		}
	}

 if ($_SERVER['REQUEST_METHOD'] == "POST" && $validacionOK == true) {
	require_once('PHPMailer-master/class.phpmailer.php');
	$destinatario = "ALUMNO@gmail.com";
	
	$texto = "Urgente: ";
	$texto .= ($urgente == true)?"sí".PHP_EOL:"no".PHP_EOL;
	$texto .= "Tipo: " . $tipo . PHP_EOL;
	$texto .= "Fecha: " . $fecha . PHP_EOL;
	$texto .= "Identificador: " . $identificador . PHP_EOL;
	$texto .= "E-mail de contacto: " . $email . PHP_EOL;
	$texto .= "Descripción: " . $descripcion . PHP_EOL;
	
	enviarEmail($destinatario, $asunto, $texto);
	
	$fichero = fopen($asunto.".txt", "w");
	fputs($fichero, $texto);
	fclose($fichero);
 }
?>
