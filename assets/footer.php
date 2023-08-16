<footer>
	<p>SITIO PERSONAL DE BRAYAN CAMILO JOYA HERRERA - DESARROLLADOR WEB</p><br>
	<div>
		<a href="#contact_form">CONTACTO</a>&nbsp;|&nbsp;<a href="<?php echo SERVERURL ?>about.php">MÁS SOBRE MI</a>&nbsp;|&nbsp;<a href="<?php echo SERVERURL ?>cv.php">MI CV</a>
	</div>	
	<div class="redes">
		<a href="<?php echo FACEBOOK?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
		<a href="<?php echo TWITTER?>" target="_blank"><i class="fab fa-twitter"></i></a>
		<a href="<?php echo INSTAGRAM?>" target="_blank"><i class="fab fa-instagram"></i></a>
		<a href="<?php echo YOUTUBE?>" target="_blank"><i class="fab fa-youtube"></i></a>
		<a href="<?php echo PAYPAL?>" target="_blank"><i class="fab fa-paypal"></i></a>
	</div>
	<p>© 2020-<?php echo date('o');?> &nbsp; Brayan Joya. &nbsp;Todos los derechos reservados</p>
	<div class="btn-login">
		<a href="<?php echo SERVERURL ?>login.php">Login</a>
	</div>
</footer>
<script>

	window.addEventListener('scroll', function (e) {
        var nav = document.getElementById('navbar');
        if (document.documentElement.scrollTop > 120 || document.body.scrollTop > window.innerHeight) {
                nav.classList.add('navbarScroll');
               
            } else {
                
                nav.classList.remove('navbarScroll');
            }
    });
		
</script>