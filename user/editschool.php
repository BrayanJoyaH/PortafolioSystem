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
$titulo = "";
$institucion = "";


if(isset($_GET['id']) && !empty($_GET['id'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	

	if (!schoolExist($id)) {
		
		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
		die();
	} else {
		$titulo = getInfo('titulo', 'estudios', 'id', $id);
	}
 
} else {

	if(isset($_POST['id']) && !empty($_POST['id'])) {


		$id = $mysqli->real_escape_string($_POST['id']); 
		

		if (schoolExist($id)) {

			if(deleteSchool($id)) {

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'dashboard.php#school">';
			} else {

				$errors[] = "Error al eliminar";
			}

		
			
		} else {
			echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
			die();
		}


		
 	}  else {

 		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'dashboard.php">';
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
		<p class="title-login"><i class="fas fa-user-times"></i>Editar el estudio?</p>
		<p><small><?php echo $titulo ?></small></p>
		<input type="hidden" name="id" id="id" required value="<?php echo $id ?>">
		
		
		<input type="submit" name="edit" value="Edit" id="Edit">
		<input type="submit" name="delete" value="Eliminar" id="Eliminar">
		<?php  echo blockErrors($errors); ?>	
	</form>	

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>