<?php 

function getProyects() {

	global $mysqli;

	$rows = null;

	$stmt = $mysqli->prepare("SELECT * FROM proyectos WHERE 1");
	$stmt->execute();
	$result = $stmt->get_result();

	while ($file = $result->fetch_assoc()) {
		
		$rows[] =  $file;
	}

	return $rows;
}

function addProyect($nameProyect, $eslogan, $minidescripcion, $descripcion, $token, $file) {

	global $mysqli;

	$targetDir = 'proyectInfo/'.$token;
	

	if(mkdir($targetDir)) {

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

				$stmt = $mysqli->prepare("INSERT INTO proyectos (nombre, minidescripcion, logo, eslogan, descripcion, token) VALUES (?,?,?,?,?,?)");
				$stmt->bind_param('ssssss', $nameProyect, $minidescripcion, $targetFile, $eslogan, $descripcion, $token);

				if ($stmt->execute()) {

					$insertId = $mysqli->insert_id;
					
					return $insertId;

				} else {
					return 0;
				}
				

			} else {
				$errors = "Lo siento, ha ocurrido un error";
			}
		} else {
				
			$errors = "Lo siento, ha ocurrido un error";
		}

	} else {

		$errors = "Error";
		
	}

}

function proyectExist($name) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM proyectos WHERE nombre = ? LIMIT 1");

	$stmt->bind_param("s", $name);
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

function proyectExistIdToken($id, $token) {


	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM proyectos WHERE id = ? AND token = ? LIMIT 1");

	$stmt->bind_param("ss", $id, $token);
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

function deleteProyect($id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("DELETE FROM proyectos WHERE id = ? AND token = ? LIMIT 1");
	$stmt->bind_param('ss', $id, $token);
	$stmt->execute();
	$stmt->close();

	$target = "proyectInfo/$token";
	

	if (file_exists($target)) {
		
		deleteDirectory($target);
	}

	

	desjoinUsersProyect($token);

}

function desjoinUsersProyect($cid) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET cid = 0 WHERE cid = ?");
	$stmt->bind_param('s', $cid);
	$stmt->execute();
	$stmt->close();


}

function desjoinUserProyect($cid, $id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET cid = 0 WHERE cid = ? AND id = ? AND token = ?");
	$stmt->bind_param('sis', $cid, $id, $token);
	$stmt->execute();
	$stmt->close();


}


function joinUsersProyect($cid, $nombre) {

	global $mysqli;

	$stmt = $mysqli->prepare("INSERT INTO integrantes_proyectos (nombre, cid) VALUES (?, ?)");
	$stmt->bind_param('ss', $cid, $nombre);
	$stmt->execute();
	$stmt->close();


}


function getUserProyect($cid) {

	global $mysqli;

	$users = null;

	$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE cid = ?");
	$stmt->bind_param('s', $cid);
	$stmt->execute();
	$rows = $stmt->get_result();

	while ($result = $rows->fetch_assoc()) {

		$users[] = $result;
	}

	return $users;
}

function changeImageProyect($id, $token, $file) {

	global $mysqli;

	$targetDir = 'proyectInfo/'.$token;
	

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

				$stmt = $mysqli->prepare("UPDATE proyectos SET logo = ? WHERE id = ? AND token = ?");
				$stmt->bind_param('sis', $targetFile, $id, $token);

				if ($stmt->execute()) {

					$insertId = $mysqli->insert_id;
					
					return $insertId;

				} else {
					return 0;
				}
				

			} else {
				$errors = "Lo siento, ha ocurrido un error";
			}
		} else {
				
			$errors = "Lo siento, ha ocurrido un error";
		}

	} else {

		$errors = "Error";
		
	}

}


function settingProyect($id, $token, $eslogan, $name, $minidescripcion, $descripcion) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE proyectos SET nombre = ?, minidescripcion = ?, eslogan = ?, descripcion = ? WHERE id = ? AND token = ?");
	$stmt->bind_param('ssssis', $name, $minidescripcion, $eslogan, $descripcion, $id, $token);

	if ($stmt->execute()) {
		
		return true;
	} else {
		return false;
	}
	

}


?>