<?php 

require '../global/config.php';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<meta name="theme-color" content="#4e9">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/document.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="js/script.js"></script>
	<title>El servidor no responde | <?php echo APPTITLE ?></title>
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

	<h1>Error 502 ¡El servidor no responde!</h1>

	<footer>
		<a href="<?php echo SERVERURL ?>">
			<i>Inicio</i>
		</a>
	</footer>

</body>
</html>