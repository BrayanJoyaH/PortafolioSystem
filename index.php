<?php 

session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';
require 'funcs/funcsProyects.php';

$proyects = getProyects();
$products = null;
$blogs = null;
$info = getInfoIndex();


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/main.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Inicio | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include 'assets/navbar.php';?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/desarrollo-web.jpg")'>
				<div><p><?php echo $info[0]['titulo'] ?></p></div>
			</div>		
		</section>
		<section class="introduccion">
			<h1><?php echo $info[0]['subtitulo'] ?></h1>
			<p><?php echo str_replace("\\r\\n", "<br>", ($info[0]['descripcion'])) ?></p>
			<br>
			<b>TE INTERESA ? </b>
			<div class="btnContainer">
				<a href="<?php echo SERVERURL?>about.php">Saber más sobre mi</a>
				<a href="<?php echo SERVERURL?>cv.php">Descargar mi cv</a>
			</div>
		</section>
		<section class="proyectos">
			<h3>Mis proyectos</h3>
			<div class="container">
				<?php 
				if ($proyects != null) {
					if (count($proyects) > 0) { 

						$flag = 0;
						
					 	foreach ($proyects as $proyect){ 
					 		if ($flag == 4) { break; } else { $flag += 1;}?>

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
			<div class="btnContainer">
				<a href="<?php echo SERVERURL?>proyectos">Ver Más</a>
			</div>
		</section>
		<section class="proyectos productos">
			<h3>Productos</h3>
			<div class="container">
				<?php 
				if ($products != null) {
					if (count($products) > 0) { 

						$flag = 0;
						
					 	foreach ($products as $product){ 
					 		if ($flag == 4) { break; } else { $flag += 1;}?>

							<div class="card">
								<div class="image"><img src="<?php echo SERVERURL.'user/'.$product['logo']?>" alt="logo"></div>
								<div class="body">
									<a  href="<?php echo SERVERURL ?>productos/view.php?id=<?php echo $product['id']?>">Ver producto</a>

									<h5><?php echo $product['nombre']; ?></h5>
									<p><?php echo $product['minidescripcion']; ?></p>
									
								</div>
								
							</div>
				<?php }}} else { echo "<h3>No hay productos para mostrar</h3>";}?>		
			</div>
			<div class="btnContainer">
				<a href="<?php echo SERVERURL?>productos">Ver Más</a>
			</div>
		</section>
		<section class="blogInformacion">
			<h3><?php echo $info[0]['blogtitulo'] ?></h3>
			<p><?php echo str_replace("\\r\\n", "<br>", ($info[0]['blogdescripcion'])) ?></p>
		</section>
		<section class="proyectos">
			<h3>Mis artículos</h3>
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
			<div class="btnContainer">
				<a href="<?php echo SERVERURL?>blog">Ver Más</a>
			</div>
		</section>
		<?php include 'assets/contact.php'; ?>
	</main>
	<?php  include 'assets/footer.php';?>
</body>
</html>