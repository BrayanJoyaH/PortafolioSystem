<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcsProyects.php';

$proyects = getProyects();

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/blogmain.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Proyectos | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/web.jpg")'>
				<div>
					<p>Mira mis Proyectos</p>
				</div>
				
			</div>		
		</section>
		<section class="proyectos">
			<h3>Decubre distintos proyectos</h3>
			
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
				<?php }}} else { echo "<h3>No hay proyectos para mostrar</h3>";}?>
			
			</div>
		</section>
		<?php include '../assets/contact.php'; ?>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>