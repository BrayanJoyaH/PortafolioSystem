<form method="post" id="contact_form">
	<legend>ENVIANME TUS OPINONES O DUDAS</legend>
	<input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre" required>
	<input type="email" name="email" id="email" placeholder="Escribe tu email" required>
	<input type="text" name="asunto" id="asunto" placeholder="Asunto" required>
	<textarea rows="5" name="pqr" placeholder="Escribe tus opiniones o dudas" required></textarea>
	<p id="msj"></p>
	<input type="submit" value="Enviar" id="send" >
	
</form>
<script type="text/javascript">
	const d = document,
	$form = d.getElementById("contact_form");
	$xhr = d.getElementById("msj");
	$btnSubmit = d.getElementById("send");

	const ajax = (data) => {

		const xhr = new XMLHttpRequest();

		xhr.addEventListener("readystatechange",(e)=>{

			if (xhr.readyState !== 4) return;

			if (xhr.status >= 200 && xhr.status < 300) {

				$xhr.innerHTML = xhr.responseText;

				if (xhr.responseText == "Debes Llenar Todos los campos") {
					
					setTimeout(() => {
						$xhr.innerHTML = "";
						$btnSubmit.removeAttribute("disabled");
					}, 3000);

				}

				if (xhr.responseText == "Ingresa un correo válido") {
					
					setTimeout(() => {
						$xhr.innerHTML = "";
						$btnSubmit.removeAttribute("disabled");
					}, 3000);

				}

				if (xhr.responseText == "Mensaje enviado, Gracias por comentar") {
					
					$form.reset();

					setTimeout(() => {
						$xhr.innerHTML = "";
						$btnSubmit.removeAttribute("disabled");
					}, 6000);
				}

			} else {
				$xhr.innerHTML = "Error al enviar el mensaje. Intenta de nuevo";
				setTimeout(() => {
					$xhr.innerHTML = "";
					$btnSubmit.removeAttribute("disabled");
				}, 6000);
			}

		});
		xhr.open("POST", "<?php echo SERVERURL ?>funcs/sendmailAJAX.php");
		xhr.send(data);
	};

	d.addEventListener("submit", e => {

		if (e.target === $form) {
			e.preventDefault();

			const data = new FormData(e.target);
			$btnSubmit.setAttribute("disabled", true);
			ajax(data);


		}
	})

</script>