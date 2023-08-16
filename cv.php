<?php 

	$ubicacion = "files/private/0/cv.pdf";
	$nombreOriginal = "cv.pdf";
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=$nombreOriginal");
	readfile($ubicacion);

 ?>