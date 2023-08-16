<?php 

require '../global/config.php';

if(isset($_GET['success']) && isset($_GET['mail']) && isset($_GET['type']) && !empty($_GET['success']) && !empty($_GET['mail']) && !empty($_GET['type'])) {

	$success = $_GET['success'];
	$mail = $_GET['mail'];
	$type = $_GET['type'];

	if ($type == 1) {
		if ($success == "true") {
		
			$msg = "Usuario registrado, revisa tu email $mail para activar tu cuenta";
		} else {

			$msg = "No se pudo registrar la cuenta";
		}
	} elseif ($type == 2) {
		if ($success == "true") {
		
			$msg = "Mensaje enviado, revisa tu email $mail";
		} else {

			$msg = "Error al enviar Email";
		}
	}

	

} else {
	$msg = "Empty Info";
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<!--    CUSTOM CSS    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/document.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="js/script.js"></script>
	<title>Success</title>
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

	<h4><?php echo $msg; ?></h4>

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>
</body>
</html>