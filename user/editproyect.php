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

$errorsActualize = array();
$errorsEdit = array();

$id = "";
$token = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	$users = getUserProyect($token);

	if (!proyectExistIdToken($id, $token)) {
		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/proyectos.php">';
		die();
	}

} else {

	if (isset($_POST['Actualizar'])) {

		if (isset($_POST['id']) && isset($_POST['token']) && !empty($_POST['id']) && !empty($_POST['token'])) {

			$id = $mysqli->real_escape_string($_POST['id']);
			$token = $mysqli->real_escape_string($_POST['token']);


			if ($_FILES) {

				$newImage = $_FILES;
				$errorsActualize[] = changeImageProyect($id, $token, $newImage);


			}

			echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/editproyect.php?id='.$id.'&token='.$token.'">';
			die();

		
		}


	} elseif (isset($_POST['Editar'])) {

		if (isset($_POST['eslogan']) && isset($_POST['name']) && isset($_POST['minidescripcion']) && !empty($_POST['eslogan']) && !empty($_POST['name']) && !empty($_POST['minidescripcion']) && isset($_POST['id']) && isset($_POST['token']) && !empty($_POST['id']) && !empty($_POST['token']) && isset($_POST['descripcion']) && !empty($_POST['descripcion'])) {

			$id = $mysqli->real_escape_string($_POST['id']);
			$token = $mysqli->real_escape_string($_POST['token']);
			$eslogan = $mysqli->real_escape_string($_POST['eslogan']);
			$name = $mysqli->real_escape_string($_POST['name']);
			$minidescripcion = $mysqli->real_escape_string($_POST['minidescripcion']);
			$descripcion = $mysqli->real_escape_string($_POST['descripcion']);

			if (proyectExistIdToken($id, $token) ) {
				
				if (settingProyect($id, $token, $eslogan, $name, $minidescripcion, $descripcion)) {

					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/editproyect.php?id='.$id.'&token='.$token.'">';
					die();
				} else {

					$errorsEdit[] = "Error al editar intenta de nuevo";
				}

				
			}



		} else {

			$errorsEdit[] = "Debes llenar todos los campos";
		}
		
	} else {

		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/proyectos.php">';
		die();
	}


}


$imageProyect = getInfo('logo', 'proyectos', 'id', $id);
$name = getInfo('nombre', 'proyectos', 'id', $id);
$eslogan = getInfo('eslogan', 'proyectos', 'id', $id);
$minidescripcion = getInfo('minidescripcion', 'proyectos', 'id', $id);
$descripcion = getInfo('descripcion', 'proyectos', 'id', $id);

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/setting.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Configuración <?php echo $name?> | <?php echo APPTITLE ?></title>
	<script type="text/javascript" src="<?php echo SERVERURL?>js/script.js"></script>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature2.jpg")'>
				<div>
					<p><?php echo $name; ?></p>
				</div>
				
			</div>		
		</section>
		<section class="info">

			<div class="imageUser">

				<img src="<?php echo SERVERURL.'user/'.$imageProyect ?>" alt="">

			</div>
			<div class="infoUser">

				<div class="typeInfo">
					<h4>Actualizar Logo</h4>
					<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
						<p>La imagen debe tener el mismo ancho y alto <b>(Debe ser cuadrada)</b></p>
						<input type="hidden" name="id" value="<?php echo  $id ?>">
						<input type="hidden" name="token" value="<?php echo  $token ?>">
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
					<h4>Informacion del proyecto</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="profile">
						<input type="hidden" name="id" value="<?php echo  $id ?>" required>
						<input type="hidden" name="token" value="<?php echo  $token ?>" required>
						<div class="itemInfo">
							<span>Nombre:</span> 
							<input type="text" name="name" class="dato" value="<?php echo  $name ?>" required>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Eslogan:</span>
							<input type="text" name="eslogan" class="dato" value="<?php echo $eslogan ?>" required>
								
						</div>
						<hr>
						
						<div class="itemInfo">
							<span>Mini Descripción:</span>
							<textarea rows="5" name="minidescripcion" class="dato" required><?php echo str_replace("\\r\\n", "\r\n", $minidescripcion)?></textarea>
								
						</div>
						<hr>
						<div class="itemInfo">
							<span>Descripción:</span>
							<textarea rows="5" name="descripcion" class="dato" required><?php echo str_replace("\\r\\n", "\r\n", $descripcion)?></textarea>
								
						</div>
						
						<input type="submit" name="Editar" value="Editar">
						<?php echo blockErrors($errorsEdit);?>
					</form>
				</div>
				<div class="typeInfo">
					<h4>Usuarios</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="password">

						<?php if ($users != null) {
								if (count($users) > 0) {
									foreach ($users as $user) { ?>
									
									<div class="itemInfo">
										<span><?php echo $user['nombre']?></span>
										<a href="<?php echo SERVERURL?>user/desjoinusers.php?id=<?php echo $user['id']?>&token=<?php echo $user['token']?>&cid=<?php echo $token?>" class="dato">Desvincular</a>
										
							
									</div>
									<hr>
							
						<?php }}} ?>
						
						
					</form>
					<br>
	
					<a href="<?php echo SERVERURL?>user/joinusers.php?id=<?php echo $id?>&token=<?php echo $token?>" >Vincular usuario</a>

				</div>
			
			</div>	
			
		</section>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>