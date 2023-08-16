<?php  
session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';
require 'funcs/funcs.php';
require 'funcs/funcsUsers.php';
require 'funcs/files.php';
require 'funcs/sendMail.php';


$email = "";
$name = "";
$user = "";

$errors = array();

if (!empty($_POST)) {

	$user = $mysqli->real_escape_string($_POST['user']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$confirmPassword = $mysqli->real_escape_string($_POST['confirmPassword']);
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = $mysqli->real_escape_string($_POST['email']);	
	$confirmEmail = $mysqli->real_escape_string($_POST['conEmail']);
	$activo = 0;
	$type_user = 2;

	if (!isNullRegister($user, $password, $confirmPassword, $name, $email, $confirmEmail)) {

		if (!isEmail($email)) {

			$errors[] = "Correo Invalido";
		}

		if (!validatePassword($email, $confirmEmail)) {
			$errors[] = "Los correos no coinciden";
		}

		if (userExist($user)) {

			$errors[] = "El usuario ingresado ya existe";
		}

		if (emailExist($email)) {

			$errors[] = "El correo ingresado ya existe
			";
		}

		if (!validatePassword($password, $confirmPassword)) {

			$errors[] = "La contraseñas no coinciden";
		}

		if (count($errors) == 0) {

			$pass_hash = hashPassword($password);
			$token = generateToken();
			
			$registro = registerUser($user, $pass_hash, $name, $email, $activo, $token, $type_user);

			if ($registro > 0) {

				$url = SERVERURL."document/activate.php?id=".$registro."&token=".$token;

				$subject = "Activar Cuenta - Brayan Joya";

				$styleB = 'style = "font-family: century gothic; font-variant: small-caps; background-color: #ededed; border-radius: 8px; text-align: center; font-size: 20px; font-weight: 200"';
				$styleA = 'style = "background-color: #49e; border-radius: 8px; color: #fff; padding: 12px 8px; text-decoration: none"';
				$stylec = 'style = "background-color: #999; color: #000; padding: 20px 10px; font-size: 13px;"';
				$src = "https://brayanjoya.github.io/Tarjeta/images/logps.png";

				$body = "<div $styleB><img src='$src' width='70%'><br>Hola $name: <br><br><p>Ahora estás registrad@ en Mi página.</p> <p>Visita el siguiente enlace para activar la cuenta</p><br><br><a href='$url' $styleA target='_parent'>Activar cuenta</a><br><br><br><p $stylec>© 2020-".date('o')."   Brayan Joya.  Todos los derechos reservados</p></div>";

				if (sendMail($email, $name, $subject, $body)) {
					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/success.php?success=true&mail='.$email.'&type=1">';
					die();
				} else {
					$errors[] = "Error al enviar email";
				}

			} else {

				$errors[] = "Error al registrar usuario";
			}
		}
		
	} else {

		$errors[] = "Debes llenar todos los campos";

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
	<title><?php echo TITLEREGISTER ?></title>
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
		<p class="title-login"><i class="fas fa-server"></i>Register</p>
		<input type="text" name="name" id="name" required autocomplete="off" placeholder="Nombre" value="<?php echo $name ?>">
		<input type="text" name="user" id="user" required autocomplete="off" placeholder="Usuario" value="<?php echo $user ?>">
		<input type="email" name="email" id="email" required autocomplete="off" placeholder="Email" value="<?php echo $email ?>">
		<input type="email" name="conEmail" id="conEmail" required autocomplete="off" placeholder="Confirmar Email">
		<input type="password" name="password" id="password" required autocomplete="off" placeholder="Contraseña">
		<input type="password" name="confirmPassword" id="confirmPassword" required autocomplete="off" placeholder="Confirmar Contraseña">
		<input type="submit" value="Registrar" id="Register">	
		<?php echo blockErrors($errors);  ?> 
	</form>	
	<a href="<?php echo SERVERURL?>login.php">¿Ya tienes una cuenta? Inicia Sesión</a>
	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>

</body>
</html>