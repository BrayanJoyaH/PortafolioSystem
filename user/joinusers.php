<?php  
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';
require '../funcs/funcsProyects.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}


$email = "";
$token = "";

$errors = array();
$users = getUsersForJoin();



if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (proyectExistIdToken($id, $token)) {
		$email = getInfo('nombre', 'proyectos', 'id', $id);
		$auth = 1;
	} else {
		$errors[] = "El proyecto no existe";
	}
 
} else {

	if ($_POST) {

		$cid = $mysqli->real_escape_string($_POST['cid']);
		$id = getInfo('id', 'proyectos', 'token', $cid);

	
		foreach ($_POST as $post ) {

			if ($post == $cid) {
				continue;
			}
			
			joinUsersProyect($cid, $post);
		}

		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/editproyect.php?id='.$id.'&token='.$cid.'">';
		die();
		
	
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
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title>Vincular usuarios a un proyecto | <?php echo APPTITLE ?></title>
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
		<p class="title-login"><i class="fas fa-server"></i>vincular a <?php echo $email?></p>

		<input type="hidden" name="cid" value="<?php echo $token ?>">


		<?php 
		if ($users != null) {
		
			foreach ($users as $user ){ ?>


			<label for="<?php echo $user['id']?>"><?php echo $user['nombre']?></label>
			<input type="checkbox" name="<?php echo $user['id']?>" id="<?php echo $user['id']?>" value="<?php echo $user['token']?>" style="display: inline; border: none"> 

		<?php } 
		} else { 
			echo 'No hay usuarios disponible';
		}?>

		<input type="submit" value="Vincular" id="Vincular">	
		<?php echo blockErrors($errors);  ?> 
	</form>	
	
	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>

</body>
</html>