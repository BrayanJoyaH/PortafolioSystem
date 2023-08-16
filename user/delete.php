<?php 
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';
require '../funcs/files.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 

$errors = array();
$email = "";
$id = "";
$auth = "";
$token = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (userExistIdToken($id, $token)) {
		$email = getInfo('correo', 'usuarios', 'id', $id);
		$auth = 1;
	} else {
		$errors[] = "El usuario no existe";
	}
 
} else {

	if(isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['auth']) && !empty($_POST['auth']) && isset($_POST['token']) && !empty($_POST['token'])) {

		$userId = $mysqli->real_escape_string($_POST['userId']); 
		$auth = $mysqli->real_escape_string($_POST['auth']);
		$token = $mysqli->real_escape_string($_POST['token']);

		if (userExistIdToken($userId, $token)) {

			if($userId > 0 && $auth > 0 ) {
			
				deleteUser($userId, $token);
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/users.php">';
				die();
			} else {

				$errors[] = "El usuario no existe";
			}


		} else {

			$errors[] = "El usuario no existe";
		}
	}  else {

		$errors[] = "El usuario no existe";
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
	<title>Eliminar Usuario | <?php echo APPTITLE ?></title>
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
		<p class="title-login"><i class="fas fa-user-times"></i>¿Quieres eliminar este usuario?</p>
		<p><small><?php echo $email; ?></small></p>
		<input type="hidden" name="userId" id="userId" required value="<?php echo $id ?>">
		<input type="hidden" name="auth" id="auth" required value="<?php echo $auth ?>">
		<input type="hidden" name="token" id="token" required value="<?php echo $token ?>">
		<input type="submit" value="Eliminar" id="Eliminar">
		<?php  echo blockErrors($errors); ?>	
	</form>	

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>