<?php 

session_start();

require 'global/config.php';
require 'global/conexion.php';
require 'funcs/funcs.php';
require 'funcs/funcsUsers.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}

$schools = getSchool();
$knowledges = getknowledges();


$errorsEdit = array();
$msgEdit = "";
$errorsChange = array();
$msgChange = "";


if (isset($_POST['Editar'])) {

	$titulo = $mysqli->real_escape_string($_POST['titulo']);
	$subtitulo = $mysqli->real_escape_string($_POST['subtitulo']);
	$descripcion = $mysqli->real_escape_string($_POST['descripcion']);
	$tituloblog = $mysqli->real_escape_string($_POST['blogtitulo']);
	$descripcionBlog = $mysqli->real_escape_string($_POST['blogdescripcion']);
	
	if(editIndex($titulo, $subtitulo, $descripcion, $tituloblog, $descripcionBlog)) {

		$msgEdit = '<p style="color: #4e9; text-align: center">Informacion editada</p>';

	} else {

		$errorsEdit[] = "Hubo un error al modificar la información. Intenta de nuevo";
	}
}

if (isset($_POST['Change'])) {

	$nombreCompleto = $mysqli->real_escape_string($_POST['nombreCompleto']);
	$edad = $mysqli->real_escape_string($_POST['edad']);
	$correoPersonal = $mysqli->real_escape_string($_POST['correoPersonal']);
	$telefono = $mysqli->real_escape_string($_POST['telefono']);
	$pais = $mysqli->real_escape_string($_POST['pais']);
	$estilo = $mysqli->real_escape_string($_POST['estilo']);
	
	if(editPersonalInfo($nombreCompleto, $edad, $correoPersonal, $telefono, $pais, $estilo)) {

		$msgChange = '<p style="color: #4e9; text-align: center">Informacion editada</p>';

	} else {

		$errorsChange[] = "Hubo un error al modificar la información. Intenta de nuevo";
	}
}

$info = getInfoIndex();
$personalInfo = getPersonalInfo();

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/dashboard.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Administración de la página | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include 'assets/navbar.php';?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature6.jpg")'>
				<div><p>Panel Administrativo De La Página Web.</p></div>
			</div>		
		</section>
		<section class="info">
			<div class="infoUser">
				<div class="typeInfo">
					<h4>Informacion del inicio</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#profile">
						<div class="itemInfo">
							<span>Titulo:</span> 
							<input type="text" name="titulo" class="dato" value="<?php echo  $info[0]['titulo'] ?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Subtitulo:</span>
							<input type="text" name="subtitulo" class="dato" value="<?php echo $info[0]['subtitulo'] ?>" require>	
						</div>
						<hr>
						<div class="itemInfo">
							<span>Descripcion:</span>
							<textarea rows="5" name="descripcion" class="dato" required><?php echo str_replace("\\r\\n", "\r\n", ($info[0]['descripcion'])) ?></textarea>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Titulo sección blog:</span>
							<input type="text" name="blogtitulo" class="dato" value="<?php echo $info[0]['blogtitulo'] ?>" require>	
						</div>
						<hr>
						<div class="itemInfo">
							<span>Descripcion sección blog:</span>
							<textarea rows="5" name="blogdescripcion" class="dato" required><?php echo str_replace("\\r\\n", "\r\n", ($info[0]['blogdescripcion'])) ?></textarea>

						</div>
						<input type="submit" name="Editar" value="Editar" id="profile">
						<?php echo blockErrors($errorsEdit);
						echo $msgEdit;?>
					</form>
				</div>
				<div class="typeInfo">
					<h4>Estudios</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#school" id="school">
						
						<?php if ($schools != null) {
								if (count($schools) > 0) {
									foreach ($schools as $school) { ?>
									
									<div class="itemInfo">
										<span><?php echo $school['titulo']?></span>
										<a href="<?php echo SERVERURL?>user/editschool.php?id=<?php echo $school['id']?>" class="dato">Modificar</a>
										
							
									</div>
									<hr>
							
						<?php }}} ?>

						
					</form>

					<br>
	
					<a href="<?php echo SERVERURL?>user/addSchool.php" >Agregar Escuela</a>
				</div>
				<div class="typeInfo">
					<h4>Conocimientos</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#knowledges" id="knowledges">
						
						<?php if ($knowledges != null) {
								if (count($knowledges) > 0) {
									foreach ($knowledges as $knowledge) { ?>
									
									<div class="itemInfo">
										<span><?php echo $knowledge['skill']?></span>
										<a href="<?php echo SERVERURL?>knowledge/desjoinusers.php?id=<?php echo $knowledge['id']?>" class="dato">Modificar</a>
										
							
									</div>
									<hr>
							
						<?php }}} ?>

						
					</form>

					<br>
	
					<a href="<?php echo SERVERURL?>user/addKnowledge.php" >Agregar Conocimiento</a>
				</div>
				<div class="typeInfo">
					<h4>Datos personales</h4>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>#personalInfo">
						<div class="itemInfo">
							<span>Nombre completo:</span> 
							<input type="text" name="nombreCompleto" class="dato" value="<?php echo $personalInfo[0]['nombreCompleto']?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Edad:</span> 
							<input type="text" name="edad" class="dato" value="<?php echo $personalInfo[0]['edad']?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Correo:</span> 
							<input type="email" name="correoPersonal" class="dato" value="<?php echo $personalInfo[0]['correo']?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Teléfono:</span> 
							<input type="text" name="telefono" class="dato" value="<?php echo $personalInfo[0]['telefono']?>" require>
						</div>
						<hr>
						<div class="itemInfo">
							<span>Pais:</span> 
							<input type="text" name="pais" class="dato" value="<?php echo $personalInfo[0]['pais']?>" require>
						</div>
						<div class="itemInfo">
							<span>Estilo:</span>
							<textarea rows="5" name="estilo" class="dato" required><?php echo str_replace("\\r\\n", "\r\n", ($personalInfo[0]['estilo'])) ?></textarea>

						</div>
						<input type="submit" name="Change" value="Editar" id="personalInfo">
						<?php echo blockErrors($errorsChange);
						echo $msgChange;?>
					</form>
				</div>
			</div>	

		</section>
	</main>
	<?php  include 'assets/footer.php';?>
</body>
</html>