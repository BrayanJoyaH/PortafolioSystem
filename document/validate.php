<?php  
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';

$errors = array();
$nombre = "";
$flag = 0;
$msg = "";

if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token']) && isset($_GET['success']) && !empty($_GET['success'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);
	$success = $mysqli->real_escape_string($_GET['success']);

	if(validateTokenPass($id, $token)) {

		if ($success == "true") {
		
			$flag = 1;
	
		
		} else {

			cancelChangePassword($id, $token);
			$msg = "<h4>Se ha cancelado el cambio de contraseña en segundos será redireccionado a la página de inicio de sesión<h4>";
			$flag = 3;

		}
	

	} else {

			echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/403.php">';
			die();
	}

	
	
		
} elseif (!empty($_POST)) {

	if ( isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['token']) && !empty($_POST['token'])) {
		$flag = 1;
	} else {
		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/403.php">';
			die();
	}
	
	if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['conpassword']) && !empty($_POST['conpassword']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['token']) && !empty($_POST['token'])) {

		$id = $mysqli->real_escape_string($_POST['id']);
		$token = $mysqli->real_escape_string($_POST['token']);
		$password = $mysqli->real_escape_string($_POST['password']);
		$conpassword = $mysqli->real_escape_string($_POST['conpassword']);

		if (validatePassword($password, $conpassword)) {

			$password = hashPassword($password);
			changePassword($password, $id, $token);
			$msg = "<h4>La contraseña ha sido cambiada con éxito en segundos será redireccionado a la página de inicio de sesión<h4>";
			$flag = 2;
		} else {

			$errors[] = "Las contraseñas no coinciden";
		}
	} else{

		$errors[] = "Debe llenar todos los campos";
	}
	
} else {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
		die();
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
	<title>Recuperar Contraseña</title>
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

	<?php if($flag === 1) {?>

	<form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<p class="title-login"><i class="fas fa-server"></i>Recuperar contraseña</p>
		<input type="hidden" name="id" value="<?php echo $id?>">
		<input type="hidden" name="token" value="<?php echo $token?>">
		<input type="password" name="password" id="password" required autocomplete="off" placeholder="Contraseña">
		<input type="password" name="conpassword" id="conpassword" required autocomplete="off" placeholder="Confirmar contraseña">
		<input type="submit" value="Cambiar" id="login">	
		<?php echo blockErrors($errors);?>
	</form>	

	<?php } elseif($flag === 2) {

		echo $msg;
		echo '<meta http-equiv="refresh" content="3; url='.SERVERURL.'login.php">';
		die();
	} elseif($flag == 3) {

		echo $msg;
		echo '<meta http-equiv="refresh" content="3; url='.SERVERURL.'login.php">';
		die();
	}?>



	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>