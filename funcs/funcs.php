<?php  

function blockErrors($errors) {

	if (count($errors) > 0 && $errors != null) {
		echo '<div style="text-align: center">
		<ul style="color: red; margin: 0; padding: 0;">';
		foreach ($errors as $error) {
			echo '<li style="list-style-type: none; margin: 0; padding: 0;">'.$error.'</li>';
		}

		echo '</ul></div>';
	}
}

function getInfo($info, $table, $whereParam, $whereValue) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT $info FROM $table WHERE $whereParam = ? LIMIT 1");
	$stmt->bind_param('s', $whereValue);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if ($rows > 0) {

		$stmt->bind_result($_info);
		$stmt->fetch();
		return $_info;		
	} else {
		return null;
	}
}

function subString($str, $lenMax, $lenCut, $back) {

	if (strlen($str) > $lenMax) {
		
		$str = substr($str, 0, $lenCut)."...".substr($str, $back);
		
	} else {
		$str = $str;
	}
	return $str;
}

function getInfoIndex() {

	global $mysqli;
	$rows = null;

	$stmt = $mysqli->prepare("SELECT * FROM inicio WHERE 1");
	$stmt->execute();
	$result = $stmt->get_result();

	while($info = $result->fetch_array(MYSQLI_ASSOC)) {

		$rows[] = $info;
	}

	return $rows;

}

function editIndex($titulo, $subtitulo, $descripcion, $tituloblog, $descripcionBlog) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE inicio SET titulo = ?, subtitulo = ?, descripcion = ?, blogtitulo = ?, blogdescripcion = ?");
	$stmt->bind_param('sssss', $titulo, $subtitulo, $descripcion, $tituloblog, $descripcionBlog);

	if ($stmt->execute()) {
		return true;
	}

	return false;
}

function getPersonalInfo() {

	global $mysqli;
	$rows = null;

	$stmt = $mysqli->prepare("SELECT * FROM infopersonal WHERE 1");
	$stmt->execute();

	$result = $stmt->get_result();

	while($info = $result->fetch_array(MYSQLI_ASSOC)) {

		$rows[] = $info;
	}

	return $rows;
}

function editPersonalInfo($nombreCompleto, $edad, $correoPersonal, $telefono, $pais, $estilo) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE infopersonal SET nombreCompleto = ?, edad = ?, correo = ?, telefono = ?, pais = ?, estilo = ?");
	$stmt->bind_param('ssssss', $nombreCompleto, $edad, $correoPersonal, $telefono, $pais, $estilo);

	if ($stmt->execute()) {
		return true;
	}

	return false;
}

function getSchool() {

	global $mysqli;
	$rows = null;

	$stmt = $mysqli->prepare("SELECT * FROM estudios WHERE 1");
	$stmt->execute();
	$result = $stmt->get_result();

	while($school = $result->fetch_array(MYSQLI_ASSOC)) {

		$rows[] = $school;
	}

	return $rows;
}

function addSchool($icon, $school, $titulo) {

	global $mysqli;

	$stmt = $mysqli->prepare("INSERT INTO estudios (icono, institucion, titulo) VALUES (?,?,?) ");
	$stmt->bind_param('sss', $icon, $school, $titulo);

	if ($stmt->execute()) {
		
		return true;
	} 

	return false;
}


function deleteSchool($id) {

	global $mysqli;

	$stmt = $mysqli->prepare("DELETE FROM estudios WHERE id = ? LIMIT 1");
	$stmt->bind_param('s', $id);

	if ($stmt->execute()) {
		
		return true;
	} 

	return false;
}

function schoolExist($id) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM estudios WHERE id = ? LIMIT 1");

	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	if($num > 0) {
		return true;
	} else {
		return false;
	}

}

function getknowledges() {

	global $mysqli;
	$rows = null;

	$stmt = $mysqli->prepare("SELECT * FROM conocimientos WHERE 1");
	$stmt->execute();
	$result = $stmt->get_result();

	while($school = $result->fetch_array(MYSQLI_ASSOC)) {

		$rows[] = $school;
	}

	return $rows;
}

function addKnowledges($skill, $experience, $file) {

	global $mysqli;

	$targetDir = '../images';

	if(file_exists($targetDir)) {

		$targetFile = $targetDir."/" . basename($file['file']['name']);
		$name = basename($file['file']['name']);
		$uploadDk = 1;
		$FileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

		if ($file['file']['size'] > 3000000000) {

			$errors = "El archivo es muy grande";
			$uploadDk = 0;
		}

		if ($FileType != 'jpeg' && $FileType != 'jpg' && $FileType != 'png' && $FileType != 'sgv') {
			$errors = "Solo se admiten jpeg, jpg, png y sgv";
			$uploadDk = 0;
		}

		if ($uploadDk != 0) {

			if (move_uploaded_file($file['file']['tmp_name'], $targetFile)) {

				$direccion = 'images/'.basename($file['file']['name']);

				$stmt = $mysqli->prepare("INSERT INTO conocimientos (imagen, skill, experiencia) VALUES (?,?,?) ");
				$stmt->bind_param('sss', $direccion, $skill, $experience);

				if ($stmt->execute()) {
					
					return true;
				} 

			} else {
				$errors = "Lo siento, ha ocurrido un error";
			}
		} else {
				
			$errors = "Lo siento, ha ocurrido un error";
		}
	}


	return false;
}

function searchPt($query) {

	global $mysqli;

	$result = null;

	$stmt = $mysqli->prepare("SELECT * FROM proyectos WHERE nombre LIKE '%$query%' OR eslogan LIKE '%$query%' OR minidescripcion LIKE '%$query%' OR descripcion LIKE '%$query%'");
	$stmt->execute();
	$answers = $stmt->get_result();

	while ($row = $answers->fetch_assoc()) {
		
		$result[] = $row;
	}

	return $result;
}
?>