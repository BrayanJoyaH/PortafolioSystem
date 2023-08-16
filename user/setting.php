<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';

if (!validateSession()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}

$errorsActualize = array();
$errorsEdit = array();
$errorsChange = array();
$msgEdit = "";
$msgChange = "";

if (isset($_POST['Actualizar'])) {

	if ($_FILES) {

		$newImage = $_FILES;
		$errorsActualize[] = changeImageUser($newImage);
	}
	
}

if (isset($_POST['Editar'])) {

	if (isset($_POST['user']) && isset($_POST['name']) && isset($_POST['email']) && !empty($_POST['user']) && !empty($_POST['name']) && !empty($_POST['email'])) {

		$newUser = $mysqli->real_escape_string($_POST['user']);
		$newName = $mysqli->real_escape_string($_POST['name']);
		$newEmail = $mysqli->real_escape_string($_POST['email']);

		if (userExist($newUser) && $newUser != $_SESSION['user']) {
			
			$errorsEdit[] = "El usuario ingresado ya existe";

		}

		if (emailExist($newEmail) && $newEmail != $_SESSION['email']) {

			$errorsEdit[] = "El correo ingresado ya existe";
		}

		if (!isEmail($newEmail)) {
			
			$errorsEdit[] = "Correo Invalido";
		}

		if (count($errorsEdit) == 0) {

			if (settingUser($newUser, $newName, $newEmail)) {
				$msgEdit = '<p style="color: #4e9; text-align: center">Informacion editada</p>';
			} else {

				$errorsEdit[] = "Error al editar intenta de nuevo";
			}

		}



	} else {

		$errorsEdit[] = "Debes llenar todos los campos";
	}
	

}

if (isset($_POST['Cambiar'])) {

	if (isset($_POST['password']) && isset($_POST['Confirmpassword']) &&!empty($_POST['password']) && !empty($_POST['Confirmpassword'])) {

		$newPassword = $mysqli->real_escape_string($_POST['password']);
		$confirmNewPassword = $mysqli->real_escape_string($_POST['Confirmpassword']);

		if (!validatePassword($newPassword, $confirmNewPassword)) {

			$errorsChange[] = "Las contraseñas no coinciden";
		}

		if (count($errorsChange) == 0) {

			$pass_hash = hashPassword($newPassword); 
			
			if (editPassword($pass_hash)) {
				$msgChange = '<p style="color: #4e9; text-align: center">Se cambió la contraseña</p>';
			} else {

				$errorsChange[] = "Error intenta de nuevo";
			}
		}

	} else {

		$errorsChange[] = "Debes llenar todos los campos";
	}
	

}

$imageUser = getInfo('imagen', 'usuarios', 'id', $_SESSION['id']);
$nameUser = getInfo('nombre', 'usuarios', 'id', $_SESSION['id']);
$User = getInfo('usuario', 'usuarios', 'id', $_SESSION['id']);
$emailUser = getInfo('correo', 'usuarios', 'id', $_SESSION['id']);
$typeUser = getInfo('id_tipo', 'usuarios', 'id', $_SESSION['id']);
if ($typeUser == 3) {
	$typeUser = "Administrador";
} else if ($typeUser == 2) {
	$typeUser = "Usuario";
} else if ($typeUser == 1) {
	$typeUser = "Editor";
}
$Activate = getInfo('activacion', 'usuarios', 'id', $_SESSION['id']);
$Activate = $Activate == 1 ? "Activa" : "Inactiva";


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/setting.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Configuración | <?php echo APPTITLE ?></title>
	<script type="text/javascript" src="<?php echo SERVERURL?>js/script.js"></script>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature1.jpg")'>
				<div>
					<p>Configuración de tu cuenta</p>
				</div>
				
			</div>		
		</section>
		<section class="info">

			<div class="imageUser">
				<img src="<?php echo SERVERURL.$imageUser ?>" alt="">
			</div>
			<div class="infoUser">

				<div class="typeInfo">
					<h4>Actualizar Imagen de perfil</h4>
					<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
						<p>La imagen debe tener el mismo ancho y alto <b>(Debe ser cuadrada)</b></p>
						<div class="itemInfo">

							<span>Nueva Imagen:</span>

							<input type="file" name="file" id="file" onchange="cambiar()" required class="dato">
							<label for="file" id="info" class="dato">Selecciona Una imagen</label><br>
				
						</div>
			
						<input type="submit" name="Actualizar" value="Actualizar">
						<?php echo blockErrors($errorsActualize);?>
					</form>
				</div>

				<div class="typeInfo">
					<h4>Informacion del perfil</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#profile" id="profile">
						<div class="itemInfo">
							<span>Nombre:</span> 
							<input type="text" name="name" class="dato" value="<?php echo  $nameUser ?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Nombre de Usuario:</span>
							<input type="text" name="user" class="dato" value="<?php echo $User ?>" require>
								
						</div>
						<hr>
						
						<div class="itemInfo">
							<span>Correo:</span>
							<input type="email" name="email" class="dato" value="<?php echo $emailUser ?>" require>
								
						</div>
						
						<input type="submit" name="Editar" value="Editar">
						<?php echo blockErrors($errorsEdit);
						echo $msgEdit;?>
					</form>
				</div>
				<div class="typeInfo">
					<h4>Cambiar Contraseña</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#password" id="password">
						<div class="itemInfo">
							<span>Nueva Contraseña:</span>
							<input type="password" name="password" class="dato" require placeholder="**********">
				
						</div>
						<hr>
						<div class="itemInfo">
							<span>Confirmar Contraseña:</span>
							<input type="password" name="Confirmpassword" class="dato" require placeholder="**********">
				
						</div>

						<input type="submit" name="Cambiar" value="Cambiar">
						<?php echo blockErrors($errorsChange);
						echo $msgChange;?>
					</form>
				</div>
			
			</div>	
			
		</section>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>