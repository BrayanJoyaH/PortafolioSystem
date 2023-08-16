<?php 

session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';

$info = getInfoIndex();
$personalInfo = getPersonalInfo();
$imgProfile = getInfo('imagen', 'usuarios', 'id_tipo', 3);
$schools = getSchool();
$knowledges = getknowledges();



?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/about.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Acerca de mi | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include 'assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/tec5.jpg")'>
				<div><p>Mas sobre mi</p></div>
			</div>		
		</section>
		<section class="inicio" id="inicio">
			<div class="item img">

				<img src="<?php echo SERVERURL.$imgProfile ?>" alt="Brayan Joya">

				<div class="Aside">
					<h1>Conoce más sobre mí</h1>
					<a href="#about">▶ ¿Quién Soy?</a>
					<a href="#study">▶ Mis Estudios</a>
					<a href="#knowledge">▶ Mis Conocimientos</a>
					<a href="#style">▶ Mi estilo</a>

					<h2>Datos personales</h2>
					<label for="telefono">Nombre Completo:</label>
					<p id="telefono"><?php echo $personalInfo[0]['nombreCompleto']?></p>

					<label for="telefono">Edad:</label>
					<p id="telefono"><?php echo $personalInfo[0]['edad']?></p>

					<label for="telefono">Correo:</label>
					<p id="telefono"><?php echo $personalInfo[0]['correo']?></p>

					<label for="telefono">Teléfono:</label>
					<p id="telefono"><?php echo $personalInfo[0]['telefono']?></p>

					<label for="telefono">Pais:</label>
					<p id="telefono"><?php echo $personalInfo[0]['pais']?></p>

				</div>
				<div class="Aside end">

					<a href="#inicio">Volver arriba</a>
					
				</div>
			</div>
			
			<div class="item info" id="about">
				<h2>Brayan Joya - Desarrollador Web</h2>
				<p><?php echo str_replace("\\r\\n", "<br>", ($info[0]['descripcion'])) ?></p>

				<h3 id="study">Mis estudios</h3>

				<?php if ($schools != null) {
					if (count($schools) > 0) {
						foreach ($schools as $school) { ?>
									
							<div class="containerItems-study">
								<div class="item-study"><i class="<?php echo $school['icono']?>"></i></div>
								<b><?php echo $school['titulo']?></b>&nbsp;|&nbsp;
								<p><?php echo $school['institucion']?></p>
							</div><br>
							
				<?php }}} ?>


				<h3 id="knowledge">Mis conocimientos</h3>
				<p>Mis conocimientos se basan en las siguientes tecnologías y skills: </p>
				<div class="containerItems-knowledge">

					<?php if ($knowledges != null) {
								if (count($knowledges) > 0) {
								foreach ($knowledges as $knowledge) { ?>
									
									<div class="item-knowledge">
										<b><?php echo $knowledge['skill'] ?> - <?php echo $knowledge['experiencia']; ?></b>
										<img src="<?php echo SERVERURL.$knowledge['imagen'] ?>" alt="">
									</div>
												
							
					<?php }}} ?>
					
					
				</div>

				<h3 id="style">Mi estilo</h3>
				<p><?php echo str_replace("\\r\\n", "<br>", ($personalInfo[0]['estilo'])) ?></p>
				
				
			</div>
			
		</section>
		<?php include 'assets/contact.php'; ?>
	</main>
	<?php include 'assets/footer.php'; ?>
</body>
</html>