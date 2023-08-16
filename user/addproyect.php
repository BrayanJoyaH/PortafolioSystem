<?php  
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';
require '../funcs/files.php';
require '../funcs/funcsProyects.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}


$name = "";
$eslogan = "";
$minidescripcion = "";
$descripcion = "";

$errors = array();

if (isset($_POST['name']) && isset($_POST['eslogan']) && !empty($_POST['name']) && !empty($_POST['eslogan']) && isset($_POST['minidescripcion']) && !empty($_POST['minidescripcion']) && isset($_POST['descripcion']) && !empty($_POST['descripcion']))  {

	
	$eslogan = $mysqli->real_escape_string($_POST['eslogan']);
	$minidescripcion = $mysqli->real_escape_string($_POST['minidescripcion']);
	$name = $mysqli->real_escape_string($_POST['name']);
	$descripcion = $mysqli->real_escape_string($_POST['descripcion']);	

	if (proyectExist($name)) {

		$errors[] = "El proyecto ingresado ya existe";
	}

	if ($_FILES) {
		
		$logo = $_FILES;
	
		if (count($errors) == 0) {

			
			$token = generateToken();
			
			$registro = addProyect($name, $eslogan, $minidescripcion, $descripcion, $token, $logo);

			if ($registro > 0) {

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/joinusers.php?id='.$registro.'&token='.$token.'">';
				die();

			} else {

				$errors[] = "Error al añadir el proyecto";
			}
		}
	} else {

		$errors[] = "Debes seleccionar el logo";
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
	<title>Añadir proyecto | <?php echo APPTITLE ?></title>
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

	<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<p class="title-login"><i class="fas fa-server"></i>Añadir</p>
		<input type="text" name="name" id="name" required autocomplete="off" placeholder="Nombre" value="<?php echo $name ?>">
		<input type="text" name="eslogan" id="eslogan" required autocomplete="off" placeholder="Eslogan" value="<?php echo $eslogan ?>">
		
		<textarea name="minidescripcion" id="minidescripcion" required autocomplete="off" placeholder="Da una pequeña descripcion" value="<?php echo $minidescripcion ?>"></textarea>
		<textarea name="descripcion" id="descripcion" required autocomplete="off" placeholder="Da la descripcion completa del proyecto" value="<?php echo $descripcion ?>"></textarea>
		<input type="file" name="file" id="file" onchange="cambiar()" required class="dato">
		<label for="file" id="info" class="dato">Selecciona imagen de logo <small>500x450</small></label>
		<input type="submit" value="Añadir" id="Añadir">	
		<?php echo blockErrors($errors);  ?> 
	</form>	
	
	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>

</body>
</html>