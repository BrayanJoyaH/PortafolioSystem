<?php 

require '../global/config.php';
require '../global/conexion.php';
require '../Phpmailer/Exception.php';
require '../Phpmailer/PHPMailer.php';
require '../Phpmailer/SMTP.php';
require 'sendMail.php';

$msj = "";

if($_POST) {

	$email = "example@gmail.com";
	$name = $mysqli->real_escape_string($_POST['nombre']);
	$subject = $mysqli->real_escape_string($_POST['asunto']);
	$body = str_replace("\\r\\n", "<br>", ($mysqli->real_escape_string($_POST['pqr'])))."<br><br>"." Correo de: ".$name."<br>".$mysqli->real_escape_string($_POST['email']);

	if (!empty(trim($email)) && !empty(trim($name)) && !empty(trim($subject)) && !empty(trim($body))) {

		if (filter_var($mysqli->real_escape_string($_POST['email']), FILTER_VALIDATE_EMAIL)) {

			if(sendMail($email, $name, $subject, $body)) {

				$msj = "Mensaje enviado, Gracias por comentar";
			

			} else {

				$msj = "Error al enviar el mensaje";
			
			}
		} else {

			$msj = "Ingresa un correo válido";
		}
		
	} else {

		$msj = "Debes Llenar Todos los campos";
	}


}

echo $msj;

?>