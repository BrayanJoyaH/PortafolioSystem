<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';

if (!validateSession()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}

$blogs = 0;
$products = 0;

$imageUser = getInfo('imagen', 'usuarios', 'id', $_SESSION['id']);
$nameUser = getInfo('nombre', 'usuarios', 'id', $_SESSION['id']);
$User = getInfo('usuario', 'usuarios', 'id', $_SESSION['id']);
$emailUser = getInfo('correo', 'usuarios', 'id', $_SESSION['id']);
$typeUser = getInfo('id_tipo', 'usuarios', 'id', $_SESSION['id']);
if ($typeUser == 3) {
	$typeUser = "Administrador";
} else if ($typeUser == 2) {
	$typeUser = "Usuario";
} else if ($typeUser == 1) {
	$typeUser = "Editor";
}
$Activate = getInfo('activacion', 'usuarios', 'id', $_SESSION['id']);
$Activate = $Activate == 1 ? "Activa" : "Inactiva";


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/account.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Cuenta | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature7.jpg")'>
				<div>
					<p>Datos de tu cuenta</p>
				</div>
				
			</div>		
		</section>
		<section class="info">

			<div class="imageUser">
				<img src="<?php echo SERVERURL.$imageUser ?>" alt="">
			</div>
			<div class="infoUser">
				<div class="typeInfo">
					<h4>Informacion personal</h4>
					
					<div class="itemInfo">
						<span>Nombre:</span> 
						<span class="dato"><?php echo  $nameUser ?></span>
					</div>
					<hr>
					
					<div class="itemInfo">
						<span>Correo:</span>
						<span class="dato"><?php echo $emailUser ?></span>		
					</div>
		
				</div>
				<div class="typeInfo">
					<h4>Informacion de la cuenta</h4>
					<div class="itemInfo">
						<span>Nombre de usuario:</span>
						<span class="dato"><?php echo $User ?></span>		
					</div>
					<hr>
					<div class="itemInfo">
						<span>Correo:</span>
						<span class="dato"><?php echo $emailUser?></span>		
					</div>
					<hr>
					<div class="itemInfo">
						<span>Contraseña:</span>
						<span class="dato">********</span>		
					</div>
					<hr>
					<div class="itemInfo">
						<span>Tipo de Usuario:</span>
						<span class="dato"><?php echo $typeUser ?></span>		
					</div>
					<hr>
					<div class="itemInfo">
						<span>Estado de la cuenta:</span>
						<span class="dato"><?php echo $Activate ?></span>		
					</div>
	
				</div>
				
				<?php if ($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 3){ ?>
				<div class="typeInfo">
					<h4>Tu actividad</h4>
					<div class="itemInfo">
						<span>Blogs Escritos:</span>
						<span class="dato"><a href="<?php echo SERVERURL?>user/blogs.php"><?php echo $blogs?></a></span>		
					</div>
					<hr>
					<div class="itemInfo">
						<span>N° de productos:</span>
						<span class="dato"><a href="<?php echo SERVERURL?>user/productos.php"><?php echo $products?></a></span>		
					</div>
	
				</div>
				<?php } ?>
				

			</div>	

			<div class="btnContainer">

				<a href="<?php echo SERVERURL?>user/setting.php">Configuraciones</a>
			</div>

		</section>
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>