<?php 

function sendMail($email, $name, $subject, $body) {

	$mail = new PHPMailer\PHPMailer\PHPMailer(true);

	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;

	$mail->Username = 'example@gmail.com';
	$mail->Password = 'Example Password';

	$mail->SMTPSecure = 'tls';
	$mail->Port = '587';
	$mail->SMTPOptions = array(
    	'ssl' => array(
        	'verify_peer' => false,
        	'verify_peer_name' => false,
        	'allow_self_signed' => true
    	)
	);

	$mail->setFrom('example@gmail.com', 'Your Name');
	$mail->addAddress($email, $name);

	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Subject = $subject;
	$mail->Body = $body;

	if ($mail->send()) {
		return true;
	} else {
		return false;
	}
}

 ?>