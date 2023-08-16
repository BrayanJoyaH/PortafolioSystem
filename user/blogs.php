<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcsUsers.php';
require '../funcs/funcsProyects.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}

$proyects = null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/adminproyects.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Administrar Articulos | <?php echo APPTITLE ?></title>

</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>

		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature9.jpg")'>
				<div>
					<p>Administrar los Articulos</p>
				</div>
				
			</div>		
		</section>

		<section class="proyectos">
			
			<div class="opcionesAdmin">
				<a href="<?php echo SERVERURL?>user/addblogs.php" title="Añadir Proyecto"><i class="fas fa-plus-circle"></i></a>
			</div>
			
			<h3>Articulos</h3>
			
			<div class="container">
				<?php 
				if ($proyects != null) {
					if (count($proyects) > 0) { 
						
					 	foreach ($proyects as $proyect){ ?>
							<div class="card">
								<div class="image"><img src="<?php echo SERVERURL.'user/'.$proyect['logo']?>" alt="logo"></div>
								<div class="body">
									<a  href="<?php echo SERVERURL ?>view.php?id=<?php echo $proyect['id']?>">Ver Articulo</a>

									<h5><?php echo $proyect['nombre']; ?></h5>
									<p><?php echo $proyect['minidescripcion']; ?></p>
									
								</div>
								<a href="<?php echo SERVERURL ?>user/deleteproyect.php?id=<?php echo $proyect['id']?>&token=<?php echo $proyect['token']?>"><i class="far fa-trash-alt"></i></a>
								<a  href="<?php echo SERVERURL ?>user/editproyect.php?id=<?php echo $proyect['id']?>&token=<?php echo $proyect['token']?>"><i class="far fa-edit"></i></a>
							</div>
				<?php }}} else { echo "<h3>No hay articulos para mostrar</h3>";}?>
			
			</div>
		</section>
		
		<section class="contacto">
			
		</section> 
	</main>
	<?php include '../assets/footer.php'; ?>
	
</body>
</html>