<?php 
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 

$errors = array();
$typeUser = "";
$Activate = "";
$email = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (userExistIdToken($id, $token)) {
		$email = getInfo('correo', 'usuarios', 'id', $id);
		$typeUser = getInfo('id_tipo', 'usuarios', 'id', $id);

		if ($typeUser == 3) {
			$typeUser = "Administrador";
		} else if ($typeUser == 2) {
			$typeUser = "Usuario";
		} else if ($typeUser == 1) {
			$typeUser = "Editor";
		}

		$Activate = getInfo('activacion', 'usuarios', 'id', $id);
		$Activate = $Activate == 1 ? "Activo" : "Inactivo";
	} else {
		$errors[] = "El usuario no existe";
	}
 
} else {

	if(isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['token']) && !empty($_POST['token']) && isset($_POST['Activate']) && !empty($_POST['Activate']) && isset($_POST['typeUser']) && !empty($_POST['typeUser'])) {

	
		$userId = $mysqli->real_escape_string($_POST['userId']); 
		$Activate = $mysqli->real_escape_string($_POST['Activate']);
		$token = $mysqli->real_escape_string($_POST['token']);
		$typeUser = $mysqli->real_escape_string($_POST['typeUser']);

		if (userExistIdToken($userId, $token)) {

			if ($typeUser == "Administrador") {
				$typeUser = 3;
			} else if ($typeUser == "Editor") {
				$typeUser = 1;
			} else if ($typeUser == "Usuario") {
				$typeUser = 2;
			}
			$Activate = $Activate == "Activo" ? 1 : 0;

			if (editUserState($userId, $token, $typeUser, $Activate)) {

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/users.php">';
				die();
				

			} else {

				$errors[] = "Error al actualizar la información";
			}


		} else {

			$errors[] = "El usuario no existe";
		}
	}  else {

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
	<title>Edit user | <?php echo APPTITLE ?></title>
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
		<p class="title-login"><i class="fas fa-edit"></i>Editar Usuario</p>
		<p><small><?php echo $email; ?></small></p>
		<input type="hidden" name="userId" id="userId" required value="<?php echo $id ?>">
		<input type="hidden" name="token" id="token" required value="<?php echo $token ?>">
		<select name="typeUser" >
			<option value="<?php echo $typeUser?>"><?php echo $typeUser?></option>
			<?php if ($typeUser == "Administrador"){ ?>
				<option value="Usuario">Usuario</option>
				<option value="Editor">Editor</option>
				
			<?php } elseif ($typeUser == "Usuario") { ?>

				<option value="Administrador">Administrador</option>
				<option value="Editor">Editor</option>
			<?php } elseif ($typeUser == "Editor") { ?>
				<option value="Administrador">Administrador</option>
				<option value="Usuario">Usuario</option>
			<?php }?>

		</select>
		<select name="Activate" >
			<option value="<?php echo $Activate?>"><?php echo $Activate?></option>
			<?php if ($Activate == "Activo"){ ?>
				<option value="Inactivo">Inactivo</option>
				
			<?php } else { ?>

				<option value="Activo">Activo</option>
			<?php }?>

		</select>
		
		<input type="submit" value="Editar" id="Editar">	
		<?php  echo blockErrors($errors); ?>
	</form>	

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>