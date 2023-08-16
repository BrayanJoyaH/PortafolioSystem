<?php  
session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';
require 'funcs/funcsUsers.php';

$errors = array();
$user = "";

if (!empty($_POST)) {

	$user = $mysqli->real_escape_string($_POST['user']);
	$password = $mysqli->real_escape_string($_POST['password']);

	if(!isNullLogin($user, $password)) {

		$errors[] = login($user, $password);

	} else {

		$errors[] = "Debes Llenar todos los campos";
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
	<title><?php echo TITLELOGIN?></title>
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
		<p class="title-login"><i class="fas fa-server"></i>Log In</p>
		<input type="text" name="user" id="user" required autocomplete="off" placeholder="Usuario" value="<?php echo $user ?>">
		<input type="password" name="password" id="password" required autocomplete="off" placeholder="Contraseña">
		<input type="submit" value="Iniciar Sesión" id="login">	
		<a href="<?php echo SERVERURL?>recuperarpass.php">¿Olvidaste tu contraseña?</a>
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