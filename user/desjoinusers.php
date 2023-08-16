<?php 
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';
require '../funcs/files.php';
require '../funcs/funcsProyects.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 

$errors = array();
$email = "";
$id = "";
$auth = "";
$token = "";
$cid = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token']) && isset($_GET['cid']) && !empty($_GET['cid'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$cid = $mysqli->real_escape_string($_GET['cid']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (userExistIdToken($id, $token)) {
		$email = getInfo('nombre', 'usuarios', 'id', $id);
		$proyectName = getInfo('nombre', 'proyectos', 'token', $cid);
		if ($proyectName != 'null') {

			if (proyectExist($proyectName)) {
				
				$auth = 1;

			} else {
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/proyectos.php">';
 				die();
			}

		}
	} else {
		$errors[] = "El usuario no existe";
	}
 
} else {

	if(isset($_POST['cidProyect']) && !empty($_POST['cidProyect']) && isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['auth']) && !empty($_POST['auth']) && isset($_POST['token']) && !empty($_POST['token'])) {


		$cidProyect = $mysqli->real_escape_string($_POST['cidProyect']); 
 		$userId = $mysqli->real_escape_string($_POST['userId']); 
		$auth = $mysqli->real_escape_string($_POST['auth']);
		$token = $mysqli->real_escape_string($_POST['token']);

		if (userExistIdToken($userId, $token)) {

			$proyectName = getInfo('nombre', 'proyectos', 'token', $cidProyect);
			if ($proyectName != 'null') {

				if (proyectExist($proyectName)) {
					
					$auth = 1;

				} else {

					$auth = 0;
 					$errors[] = "El proyecto no existe";
			
				} 
			}


			if($userId > 0 && $auth > 0 ) {
			
				desjoinUserProyect($cidProyect, $userId, $token);
				$idproyect = getInfo('id', 'proyectos', 'token', $cidProyect);
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/editproyect.php?id='.$idproyect.'&token='.$cidProyect.'">';
				die();

			} else {
 				$errors[] = "Error";
			}


		} else {

 			$errors[] = "El usuario no existe";
 		}
 	}  else {

 		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/proyectos.php">';
 		die();
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
	<title>Desvincular Usuario | <?php echo APPTITLE ?></title>
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
		<p class="title-login"><i class="fas fa-user-times"></i>¿Quieres desvincular el usuarios?</p>
		<p><small><?php echo $email; ?></small></p>
		<input type="hidden" name="userId" id="userId" required value="<?php echo $id ?>">
		<input type="hidden" name="token" id="token" required value="<?php echo $token ?>">
		<input type="hidden" name="cidProyect" name="cidProyect"  required value="<?php echo $cid ?>">
		<input type="hidden" name="auth" id="auth" required value="<?php echo $auth ?>">
		
		<input type="submit" value="Desvincular" id="Desvincular">
		<?php  echo blockErrors($errors); ?>	
	</form>	

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>