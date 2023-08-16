<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsProyects.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = getInfo('token', 'proyectos', 'id', $id);
	$products = null;

	if (!proyectExistIdToken($id, $token)) {
		echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
		die();
	}

	$nombre = getInfo('nombre', 'proyectos', 'id', $id);
	$logo = getInfo('logo', 'proyectos', 'id', $id);
	$minidescripcion = getInfo('minidescripcion', 'proyectos', 'id', $id);
	$descripcion = getInfo('descripcion', 'proyectos', 'id', $id);
	$eslogan = getInfo('eslogan', 'proyectos', 'id', $id);
	$users = getUserProyect($token);
	

} else {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/view.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title><?php echo $nombre ?> | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL ?>user/<?php echo $logo ?>")'>
				<div><p><?php echo $nombre; ?></p></div>
			</div>		
		</section>
		<section class="introduccion">
			<h1><?php echo $nombre ?></h1>

			<div class="content">
				<div class="img-des Item-content">
					<div class="Item-img-des">
						<p class="minidescripcion">	<?php echo str_replace("\\r\\n", "<br>", $minidescripcion ) ?> </p>
					</div>
					

					<div class="Item-img-des">
						<p>
							<?php if ($users != null) {
									if (count($users) > 0) { ?>
										<b>En colaboración con: </b>
										<?php foreach ($users as $user) { ?>
											
											<?php echo $user['nombre']; if ($users[count($users) - 1]['nombre'] == $user['nombre']) {

												echo ".";
											} else {
												if ($users[count($users) - 2]['nombre'] == $user['nombre']) {
													echo " y ";
												} else {
													echo ", ";
												}
												
											}?>
										
									<?php }}} ?> 
						</p>

					</div>
					
					<div class="Item-img-des img">
						<img src=" <?php echo SERVERURL ?>user/<?php echo $logo ?> ">
					</div>
					
					<div class="Item-img-des ">
						<h4><b>	"<?php echo $eslogan ?>"</b></h4>
					</div>
					

				</div>
				<div class="descripcion Item-content">
					<p>	<?php echo str_replace("\\r\\n", "<br>", $descripcion ) ?> </p>
				</div>
				
			</div>
		</section>
		<section class="proyectos">
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
		</section>
		<?php include '../assets/contact.php'; ?>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>