<input type="checkbox" name="btn-search" id="btn-search">
<nav class="navbar" id="navbar">

		<input type="checkbox" name="btn-navbar" id="btn-navbar">

		<div>
			<div class="logo">
				<label for="btn-navbar"><i class="fas fa-bars"></i></label>

				<img src="<?php echo SERVERURL?>/images/ambientepix.png" alt="">
			</div>
			
			<ul>
				<li><a href="<?php echo SERVERURL?>">Inicio</a></li>
				<li><a href="<?php echo SERVERURL?>proyectos">Proyectos</a></li>
				<li><a href="<?php echo SERVERURL?>productos">Productos</a></li>
				<li><a href="<?php echo SERVERURL?>blog">Blog</a></li>
				<?php if (isset($_SESSION['id_tipo'])){ 
						if ( $_SESSION['id_tipo'] == 2) {?>

							<li>
								<a><i class="fas fa-cog"></i></a>
								<ul class="items-modal config">
									<li><a href="<?php echo SERVERURL?>user/account.php">Perfil</a></li>
									<li><a href="<?php echo SERVERURL?>user/setting.php">Configuración</a></li>
									<li><a href="<?php echo SERVERURL?>exit.php">Cerrar Sesión</a></li>

								</ul>
							</li>
							
				<?php }} ?>
				<?php if (isset($_SESSION['id_tipo'])){ 
						if ( $_SESSION['id_tipo'] == 1) {?>

							<li>
								<a><i class="fas fa-cog"></i></a>
								<ul class="items-modal config">
									<li><a href="<?php echo SERVERURL?>user/account.php">Perfil</a></li>
									<li><a href="<?php echo SERVERURL?>user/setting.php">Configuración</a></li>
									<li><a href="<?php echo SERVERURL?>user/blogs.php">Blogs</a></li>
									<li><a href="<?php echo SERVERURL?>user/productos.php">Productos</a></li>
									<li><a href="<?php echo SERVERURL?>exit.php">Cerrar Sesión</a></li>

								</ul>
							</li>
							
				<?php }} ?>
				<?php if (isset($_SESSION['id_tipo'])){ 
						if ( $_SESSION['id_tipo'] == 3) {?>

							<li>
								<a><i class="fas fa-cog"></i></a>
								<ul class="items-modal config">
									<li><a href="<?php echo SERVERURL?>dashboard.php">Dashboard</a></li>
									<li><a href="<?php echo SERVERURL?>user/account.php">Perfil</a></li>
									<li><a href="<?php echo SERVERURL?>user/setting.php">Configuración</a></li>
									<li><a href="<?php echo SERVERURL?>user/users.php">Usuarios</a></li>
									<li><a href="<?php echo SERVERURL?>user/blogs.php">Blogs</a></li>
									<li><a href="<?php echo SERVERURL?>user/productos.php">Productos</a></li>
									<li><a href="<?php echo SERVERURL?>user/proyectos.php">Proyectos</a></li>
									<li><a href="<?php echo SERVERURL?>exit.php">Cerrar Sesión</a></li>

								</ul>
							</li>
							
				<?php }} ?>
			</ul>
		</div>
		<div class="nav-redes">
			<a href="<?php echo FACEBOOK?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
			<a href="<?php echo TWITTER?>" target="_blank"><i class="fab fa-twitter"></i></a>
			<a href="<?php echo INSTAGRAM?>" target="_blank"><i class="fab fa-instagram"></i></a>
			<a href="<?php echo YOUTUBE?>" target="_blank"><i class="fab fa-youtube"></i></a>
			<a href="<?php echo PAYPAL?>" target="_blank"><i class="fab fa-paypal"></i></a>
			<label for="btn-search"><i class="fas fa-search"></i></label>
			<form action="<?php echo SERVERURL?>search.php">
				<input type="search" name="search" id="search">
			</form>
			
		</div>
	</nav>