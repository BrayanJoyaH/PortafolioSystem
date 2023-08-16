<?php  
session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';
require 'funcs/funcsUsers.php';
require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';
require 'funcs/sendMail.php';

$errors = array();
$email = "";

if (!empty($_POST)) {

	$email = $mysqli->real_escape_string($_POST['email']);

	if(!empty($email)) {

		if (isEmail($email)) {

			if (emailExist($email)) {
				
				$id = getInfo('id', 'usuarios', 'correo', $email);
				$name = getInfo('nombre', 'usuarios', 'correo', $email);
				$token = generateTokenPass($id);

				$url = SERVERURL."document/validate.php?id=".$id."&token=".$token."&success=true";
				$url2 = SERVERURL."document/validate.php?id=".$id."&token=".$token."&success=false";

				$subject = "Recuperar contraseña - Brayan Joya";

				$styleB = 'style = "font-family: century gothic; font-variant: small-caps; background-color: #ededed; border-radius: 8px; text-align: center; font-size: 20px; font-weight: 200"';
				$styleA = 'style = "background-color: #49e; border-radius: 8px; color: #fff; padding: 12px 8px; text-decoration: none"';
				$stylec = 'style = "background-color: #999; color: #000; padding: 20px 10px; font-size: 13px;"';
				$src = "https://brayanjoya.github.io/Tarjeta/images/logps.png";

				$body = "<div $styleB><img src='$src' width='70%'><br>Hola $name: <br><br><p>Has notificado que has olvidado tu contraseña.</p> <p>Visita el siguiente enlace para recuperar tu contraseña</p><br><br><a href='$url' $styleA target='_parent'>Recuperar contraseña</a><br><br><p>Si no fuiste tú reporta el movimiento como intento de robo de tu cuenta<p><br><br><a href='$url2' $styleA target='_parent'>Reportar movimiento</a><br><br><br><p $stylec>© 2020-2021   Brayan Joya.  Todos los derechos reservados</p></div>";

				if (sendMail($email, $name, $subject, $body)) {
					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/success.php?success=true&mail='.$email.'&type=2">';
					die();
				} else {
					$errors[] = "Error al enviar email";
				}
			} else {

				$errors[] = "El correo ingresado no se encuentra registrado";
			}

		} else {

			$errors[] = "Escribe un correo válido";
		}

		 

	} else {

		$errors[] = "Debes ingresar tu email";
	}	
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<!--    CUSTOM CSS    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/document.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title>Recuperar contraseña</title>
</head>
<body>
	<div class="icons">
		<?php 
		
		for ($i=0; $i < 20; $i++) { 
			$selector = rand(1,3);
			$rand = rand(160, 240);
			$medida = $rand."px";
			switch ($selector) {
			case 1:
				echo "<i class='icon fas fa-feather-alt' style='top: -$medida; color: #49e'></i>";
				break;
			case 2:
				echo "<i class='icon fab fa-pagelines' style='top: -$medida; color: #49e'></i>";
				break;
			case 3:
				echo "<i class='icon fas fa-user' style='top: -$medida; color: #49e'></i>";
				break;
			
			default:
				break;
			}
		}
		 ?>
	</div>

	<header><img src="<?php echo SERVERURL?>/images/ambientepix.png" alt=""></header>

	<form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<p class="title-login"><i class="fas fa-server"></i>Recupera tu contraseña</p>
		<input type="email" name="email" id="email" required autocomplete="off" placeholder="Escribe tu correo" value="<?php echo $email ?>">
		<p><sub>Si el correo está registrado se te enviará un mensaje</sub></p>
		<input type="submit" value="Enviar mensaje" id="login">	

		<?php echo blockErrors($errors);?>
	</form>	
	<a href="<?php echo SERVERURL?>register.php">¿No tienes una cuenta? Registrate</a>
	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>