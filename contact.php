<?php

//Retrieve form data.
$name = ($_GET['name']) ? $_GET['name'] : $_POST['name'];
$email = ($_GET['email']) ?$_GET['email'] : $_POST['email'];
$subject = ($_GET['subject']) ?$_GET['subject'] : $_POST['subject'];
$message = ($_GET['message']) ?$_GET['message'] : $_POST['message'];
$acceptterms = ($_GET['acceptterms']) ?$_GET['acceptterms'] : $_POST['acceptterms'];


//flag to indicate which method it uses. If POST set it to 1

if ($_POST) $post=1;

//Simple server side validation for POST data, of course, you should validate the email
if (!$name) $errors[count($errors)] = 'Por favor introduzca el Nombre.';
if (!$email) $errors[count($errors)] = 'Por favor introduzca el Correo Electronico.';
if (!$subject) $errors[count($errors)] = 'Por favor introduzca el asunto.';
if (!$message) $errors[count($errors)] = 'Por favor introduzca el mensaje.';
if (!$acceptterms) $errors[count($errors)] = 'Por acepte la política de privacidad y el aviso legal.';

//if the errors array is empty, send the mail
if (!$errors) {

	//recipient - replace your email here
	$to = 'mpereznarciso@cop.es';
	//sender - from the form
	$from = $name . ' <' . $email . '>';

	//subject and the html message

	$message = 'Nombre: ' . $name . '<br/><br/>
		        Email: ' . $email . '<br/><br/>
		        Mensaje: ' . nl2br($message) . '<br/>';

	//send the mail
	$result = sendmail($to, $subject, $message, $from);

	//if POST was used, display the message straight away
	if ($_POST) {
		if ($result) echo 'Gracias! Hemos recibido el mensaje correctamente.';
		else echo 'Disculpe las molestias, ha ocurrido un error al enviar el mensaje, pruevelo más tarde';

	//else if GET was used, return the boolean value so that
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
		echo $result;
	}

//if the errors array has values
} else {
	//display the errors message
	for ($i=0; $i<count($errors); $i++) echo $errors[$i] . '<br/>';
	echo '<a href="index.html">Back</a>';
	exit;
}


//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: ' . $from . "\r\n";

	$result = mail($to,$subject,$message,$headers);

	if ($result) return 1;
	else return 0;
}

?>
