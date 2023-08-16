<?php  
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';



if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}


$skill = "";
$experience = "";


$errors = array();

if (isset($_POST['skill']) && isset($_POST['experience']) && !empty($_POST['skill']) && !empty($_POST['experience']))  {

	
	$skill = $mysqli->real_escape_string($_POST['skill']);
	$experience = $mysqli->real_escape_string($_POST['experience']);

	if ($_FILES) {
		
		$file = $_FILES;

		if(addKnowledges($skill, $experience, $file)) {

			echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'dashboard.php#knowledges">';

		} else {

			$errors[] = "Error al agregar";
		}
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
	<title>Añadir Conocimiento | <?php echo APPTITLE ?></title>
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

		<input type="text" name="skill" id="skill" required placeholder="Skill" value="<?php echo $skill ?>">
		<input type="text" name="experience" id="experience" required  placeholder="Experiencia" value="<?php echo $experience ?>">
		<input type="file" name="file" id="file" onchange="cambiar()" required class="dato">
		<label for="file" id="info" class="dato">Selecciona imagen <small>100x100</small></label>
		
		
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