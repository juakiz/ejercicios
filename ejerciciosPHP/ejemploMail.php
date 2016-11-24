<?php
require_once('./../PHPMailer-master/class.phpmailer.php');
$destinatario = "juakizpruebas@gmail.com";
$asunto = "Probando mails desde php";
$texto = "Hola, he sido escrito desde PHP.";
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
?>