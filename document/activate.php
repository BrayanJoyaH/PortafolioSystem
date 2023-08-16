<?php  
session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcsUsers.php';

$activate = "";

if(isset($_GET['id']) && isset($_GET['token'])) {

	$id = $_GET['id'];
	$token = $_GET['token'];

	$activate = validateIdToken($id, $token);

} else {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google" content="notranslate">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<!--    CUSTOM CSS    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/document.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title>Cuenta activada | <?php echo APPTITLE; ?></title>
	<style type="text/css">
		
		h3 {
			background-color: #49e;
			color: #fff;
			border-radius: 8px;
			padding: 14px 24px;

		}

		h3:hover {

			background-color: #27c;
		}

		a {
			text-decoration: none;

		}

	</style>
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

	<h1><?php echo $activate; ?></h1>
	<a href="<?php echo SERVERURL ?>login.php">
		<h3><i>Iniciar Sesión</i></h3>
	</a>


	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>