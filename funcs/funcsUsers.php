<?php  

function isNullRegister($user, $password, $conPassword, $name,  $email, $conEmail) {

	if(empty(trim($user)) || empty(trim($password)) || empty(trim($conPassword)) || empty(trim($name)) || empty(trim($email)) || empty(trim($conEmail))) {

		return true;
	} else {
		return false;
	}

}

function isEmail($email) {

	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

		return true;
	} else {
		return false;
	}
}

function validatePassword($psw1, $psw2) {

	if(strcmp($psw1, $psw2) !== 0) {

		return false;
	} else {
		return true;
	}
}

function minMax($min, $max, $var) {
	if(strlen(trim($var)) < $min) {
		return true;
	} else if(strlen(trim($var)) > $max) {
		return true;
	} else {
		return false;
	}
}

function userExist($usuario) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");

	$stmt->bind_param("s", $usuario);
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

function emailExist($email) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
	$stmt->bind_param("s", $email);
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

function generateToken() {

	$token = md5(uniqid(mt_rand(), false));
	return $token;

} 

function hashPassword($password) {
	$hash = password_hash($password, PASSWORD_DEFAULT);
	return $hash;
}

function registerUser($user, $pass_hash, $name, $email, $activo, $token, $type_user) {

	global $mysqli;

	$image = 'user/images/default/user.png';

	$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, id_tipo, imagen, cid) VALUES(?,?,?,?,?,?,?,?,0)");
	$stmt->bind_param('ssssisis', $user, $pass_hash, $name, $email, $activo, $token, $type_user, $image);

	if ($stmt->execute()) {

		$insertId = $mysqli->insert_id;
		createFolderRegister($insertId, $token);
		
		return $insertId;

	} else {
		return 0;
	}

}

function validateIdToken($id, $token) {

	global $mysqli;

	$stmt =	 $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
	$stmt->bind_param("is", $id, $token);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if ($rows > 0) {
		$stmt->bind_result($activacion);
		$stmt->fetch();

		if($activacion == 1) {
			$msg = "La cuenta ha sido activada anteriormente";
		} else {
			if (activateUser($id)) {
				$msg = 'Cuenta activada';
			} else {
				$msg = 'Error al activar la cuenta';
			}
		}
	} else {
		$msg = "La cuenta no existe";
	}

	return $msg;

}

function activateUser($id) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET activacion = 1 WHERE id = ?");
	$stmt->bind_param('s', $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

function isNullLogin($user, $password) {

	if (empty(trim($user)) || empty(trim($password))) {
		return true;
	} else {
		return false;
	}

}

function login($usuario, $password) {

	global $mysqli;
	$errors = null;

	$stmt = $mysqli->prepare("SELECT id, id_tipo, password, nombre, usuario, correo, imagen FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");

	$stmt->bind_param("ss", $usuario, $usuario);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if($rows > 0) {
		if(isActivate($usuario)) {

			$stmt->bind_result($id, $id_tipo, $pswd, $nombre, $usuario, $correo, $imagen);
			$stmt->fetch();

			$verifyPassword = password_verify($password, $pswd);

			if ($verifyPassword) {
				setLastSession($id);

				$_SESSION['id'] = $id;
				$_SESSION['id_tipo'] = $id_tipo;
				$_SESSION['name'] = $nombre;
				$_SESSION['user'] = $usuario;
				$_SESSION['email'] = $correo;

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/account.php">';


			} else {
				$errors = "Contraseña Incorrecta";
			}
		} else {
			$errors = "La cuenta aún no ha sido activada";
		}
	} else {
		$errors = "El usuario o correo no existe";
	}

	return $errors;

}

function setLastSession($id) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=0 WHERE id = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}

function isActivate($usuario) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
	$stmt->bind_param("ss", $usuario, $usuario);
	$stmt->execute();
	$stmt->bind_result($activacion);
	$stmt->fetch();

	if ($activacion == 1) {
		return true;
	} else {
		return false;
	}
}

function generateTokenPass($id) {

	global $mysqli;

	$token = generateToken();

	$stmt = $mysqli->prepare("UPDATE usuarios SET token_password = ?, password_request = 1 WHERE id = ?");
	$stmt->bind_param('ss', $token, $id);
	$stmt->execute();
	$stmt->close();

	return $token;
}


function validateTokenPass($id, $token) {

	global $mysqli;

	$stmt =	 $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
	$stmt->bind_param("is", $id, $token);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if ($rows > 0) {
		$stmt->bind_result($activacion);
		$stmt->fetch();

		if($activacion == 1) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function changePassword($password, $id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password = '', password_request = 0 WHERE id = ? AND token_password = ?");
	$stmt->bind_param('sis', $password, $id, $token);
	if ($stmt->execute()) {

		return true;
	} else {

		return false;
	}
	
}

function cancelChangePassword($id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET token_password = '', password_request = 0 WHERE id = ? AND token_password = ?");
	$stmt->bind_param('is', $id, $token);
	$stmt->execute();
}

function validateSession() {
	if(isset($_SESSION['id'])) {
		if (!empty($_SESSION['id']) &&  $_SESSION['id'] != null && $_SESSION['id'] > 0) {
			
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}
}

function validateSessionAdmin() {
	if(validateSession() && isset($_SESSION['id_tipo'])) {

		if ($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 3) {
			return true;
		} else  {
			return false;
		}
	} else {
		return false;
	}
}

function validateSessionMegaAdmin() {
	if(validateSession() && isset($_SESSION['id_tipo'])) {

		if ($_SESSION['id_tipo'] == 3) {
			return true;
		} else  {
			return false;
		}
	} else {
		return false;
	}
}

function getUsers() {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id, usuario, nombre, correo, activacion, id_tipo, token FROM usuarios WHERE 1");
	$stmt->execute();
	$rows = $stmt->get_result();

	while ($result = $rows->fetch_assoc()) {
		
		$users[] = $result;
	}

	return $users;
}

function getUsersForJoin() {

	global $mysqli;

	$users = null;

	$stmt = $mysqli->prepare("SELECT id, usuario, nombre, correo, token FROM usuarios WHERE id_tipo = 1 AND cid = 0");
	$stmt->execute();
	$rows = $stmt->get_result();

	while ($result = $rows->fetch_assoc()) {
		
		$users[] = $result;
	}

	return $users;
}


function deleteUser($id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
	$stmt->bind_param('ss', $id, $token);
	$stmt->execute();
	$stmt->close();

	$target = "images/$token";
	$link = "../files/private/$token";

	if (file_exists($target)) {
		
		deleteDirectory($target);
	}

	if (file_exists($link)) {
		
		deleteDirectory($link);
	}

	deleteAllUserFilesDB($id, $token);

}

function editUserState($id, $token, $typeUser, $Activate) {

	global $mysqli;

	$stmt = $mysqli->prepare("UPDATE usuarios SET id_tipo = ?, activacion = ? WHERE id = ? AND token = ?");
	$stmt->bind_param('iiis', $typeUser, $Activate, $id, $token);
	if ($stmt->execute()) {
		
		return true;
	} else {
		return false;
	}
}

function userExistIdToken($id, $token) {


	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE id = ? AND token = ? LIMIT 1");

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

function changeImageUser($newImage) {

	global $mysqli;

	$errors = null;
	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$targetDir = "images/$token";

	if(file_exists($targetDir)) {

		$targetFile = $targetDir."/" . basename($newImage['file']['name']);
		$uploadDk = 1;
		$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

		if ($newImage['file']['size'] > 10000000) {

			$errors = "El archivo es muy grande";
			$uploadDk = 0;
		}

		if ($imageFileType != "jpg"  && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		
			$errors = "Solo se admiten jpeg, png, jpg and gif";
			$uploadDk = 0;
		}

		if ($uploadDk == 0) {

			return $errors;

		} else {

			if (move_uploaded_file($newImage['file']['tmp_name'], $targetFile)) {
				
				$direction = "user/".$targetFile;
				$stmt = $mysqli->prepare("UPDATE usuarios SET imagen = ? WHERE id = ? AND token = ? LIMIT 1");
				$stmt->bind_param('sis', $direction, $_SESSION['id'], $token);
				$stmt->execute();

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/setting.php">';
			

			} else {
				$errors = "La imagen no se pudo subir, intenta de nuevo";
			}

		}

	} else {

		mkdir($targetDir);

		$errors = changeImageUser($newImage);
		
	}	

	return $errors;	

}

function settingUser($newUser, $newName, $newEmail) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("UPDATE usuarios SET usuario = ?, nombre = ?, correo = ? WHERE id = ? AND token = ?");
	$stmt->bind_param('sssis', $newUser, $newName, $newEmail, $_SESSION['id'], $token);

	if ($stmt->execute()) {
		
		return true;
	} else {
		return false;
	}
	

}

function editPassword($newPassword) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("UPDATE usuarios SET password = ? WHERE id = ? AND token = ?");
	$stmt->bind_param('sis', $newPassword,  $_SESSION['id'], $token);

	if ($stmt->execute()) {

		return true;
	} else {
		return false;
	}


}
?>