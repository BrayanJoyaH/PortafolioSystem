<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';

$blogs = null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/blogmain.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Blog | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/tec.jpg")'>
				<div>
					<p>Lee Distintos Articulos</p>
				</div>
				
			</div>		
		</section>
		<section class="proyectos">
			<h3>Articulos</h3>
			
			<div class="container">
				<?php 
				if ($blogs != null) {
					if (count($blogs) > 0) { 

						$flag = 0;
						
					 	foreach ($blogs as $blog){ 
					 		if ($flag == 4) { break; } else { $flag += 1;}?>

							<div class="card">
								<div class="image"><img src="<?php echo SERVERURL.'user/'.$blog['imagen']?>" alt="imagen"></div>
								<div class="body">
									<a  href="<?php echo SERVERURL ?>blog/view.php?id=<?php echo $blog['id']?>">Ver Proyecto</a>

									<h5><?php echo $blog['nombre']; ?></h5>
									<p><?php echo $blog['minidescripcion']; ?></p>
									
								</div>
								
							</div>
				<?php }}} else { echo "<h3>No hay articulos para mostrar</h3>";}?>
			
			</div>
		</section>
		<?php include '../assets/contact.php'; ?>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>