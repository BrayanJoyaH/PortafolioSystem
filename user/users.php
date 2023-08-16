<?php 

session_start();

require '../global/config.php';
require '../global/conexion.php';
require '../funcs/funcs.php';
require '../funcs/funcsUsers.php';

if (!validateSessionMegaAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'login.php">';
	die();

}

$users = getUsers();

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/users.css">
	<link rel="icon" href="<?php echo SERVERURL ?>images/hoja.png">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<title>Usuarios | <?php echo APPTITLE ?></title>
</head>
<body>
	<?php include '../assets/navbar.php'; ?>
	<main>
		<section class="principal">
			<div class="principal-image" style='background-image: url("<?php echo SERVERURL?>images/nature8.jpg")'>
				<div>
					<p>Usuarios Registrados</p>
				</div>
				
			</div>		
		</section>
		<section class="userList">
			<?php foreach ($users as $user ) {?>
				<div class="UserInfo">
					<div class="user">
						<details>
							<summary>
								<p><span>&rsaquo;&nbsp;</span><?php echo subString($user['nombre'], 10, 6, -1)?></p>
								<span>
									<a href="<?php echo SERVERURL; ?>user/delete.php?id=<?php echo $user['id']?>&token=<?php echo $user['token']?>"><i class="far fa-trash-alt"></i></a>
									<a href="<?php echo SERVERURL; ?>user/edit.php?id=<?php echo $user['id']?>&token=<?php echo $user['token']?>"><i class="far fa-edit"></i></a>
								</span>
							</summary>
							<p>Nombre:&nbsp;&nbsp; <?php echo subString($user['nombre'], 10, 6, -1) ?> </p>
							<p>Usuario:&nbsp;&nbsp; <?php echo subString($user['usuario'], 10, 6, -1) ?></p>
							<p>Email:&nbsp;&nbsp; <?php echo subString($user['correo'], 10, 6, -1) ?></p>
							<p>Tipo de Usuario:&nbsp;&nbsp; <?php if ($user['id_tipo'] == 1) {
																$TypeUser = 'Editor';				
															} else if($user['id_tipo'] == 2) {
																$TypeUser = 'Usuario';
															} elseif ($user['id_tipo'] == 3) {
																$TypeUser = 'Administrador';
															}
															echo $TypeUser;
													?></p>
							<p>Estado:&nbsp;&nbsp; <?php if ($user['activacion'] == 1) {
																$activate = 'Activo';				
															} else {
																$activate = 'Inactivo';
															}
															echo $activate;
													?></p>
						</details>
					</div>
				</div>
			<?php } ?>
		</section> 
	</main>
	<?php include '../assets/footer.php'; ?>
</body>
</html>