<?php 

session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';

$proyects = null;
$msg = '<h2 style="text-align: center;">No hay resultados para la búsqueda</h2><i class="fas fa-search query"></i>';

if (isset($_GET['search']) && !empty($_GET['search'])) {
	
	$s = $mysqli->real_escape_string($_GET['search']);

	$proyects = searchPt($s);
	
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/search.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Búsqueda | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include 'assets/navbar.php'; ?>
	<main>
			<?php if ($proyects != null) { ?>
				<section class="proyectos">
					<h3>Resultados para: proyectos</h3>
					<div class="container">
						<?php 
						if ($proyects != null) {
							if (count($proyects) > 0) { 
								
							 	foreach ($proyects as $proyect){ ?>

									<div class="card">
										<div class="image"><img src="<?php echo SERVERURL.'user/'.$proyect['logo']?>" alt="logo"></div>
										<div class="body">
											<a  href="<?php echo SERVERURL ?>proyectos/view.php?id=<?php echo $proyect['id']?>">Ver Proyecto</a>

											<h5><?php echo $proyect['nombre']; ?></h5>
											<p><?php echo $proyect['minidescripcion']; ?></p>
											
										</div>
										
									</div>
						<?php }}} else {  echo $msg;}?>		
					</div>
				</section>
			<?php } else { ?>
				<section class="search">
					<?php echo $msg; ?>
				</section>
			<?php } ?>		
		<?php include 'assets/contact.php'; ?>
	</main>
	<?php include 'assets/footer.php'; ?>
</body>
</html>