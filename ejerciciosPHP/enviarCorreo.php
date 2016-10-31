<?php
require_once('PHPMailer-master/class.phpmailer.php');
$destinatario = "alumno@gmail.com";
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
$mail->Username = "alumno@gmail.com"; // Cuenta del emisor
$mail->Password = "clave"; // Contraseña del emisor