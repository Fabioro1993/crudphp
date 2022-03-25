<?php
include('is_logged.php');
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['firstname_edit'])){
	$errors[] = "Nombres vacíos";
} elseif (empty($_POST['lastname_edit'])){
	$errors[] = "Apellidos vacíos";
}  elseif (empty($_POST['user_email_edit'])) {
	$errors[] = "El correo electrónico no puede estar vacío";
} elseif (strlen($_POST['user_email_edit']) > 64) {
	$errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['user_email_edit'], FILTER_VALIDATE_EMAIL)) {
	$errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (
	!empty($_POST['firstname_edit'])
	&& !empty($_POST['lastname_edit'])
	&& !empty($_POST['user_email_edit'])
	&& strlen($_POST['user_email_edit']) <= 64
	&& filter_var($_POST['user_email_edit'], FILTER_VALIDATE_EMAIL)
	)
	{
	require_once ("../config/db.php");
	require_once ("../config/connection.php");

		$firstname = mysqli_real_escape_string($con,(strip_tags($_POST["firstname_edit"],ENT_QUOTES)));
		$lastname = mysqli_real_escape_string($con,(strip_tags($_POST["lastname_edit"],ENT_QUOTES)));
		$user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email_edit"],ENT_QUOTES)));

		$user_id=intval($_POST['mod_id']);

		$sql = "UPDATE users SET firstname='".$firstname."', lastname='".$lastname."', user_email='".$user_email."'
					WHERE user_id='".$user_id."';";
		$query_update = mysqli_query($con,$sql);
		if ($query_update) {
			$messages[] = "La cuenta ha sido modificada con éxito.";
		} else {
			$errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
		}
} else {
	$errors[] = "Un error desconocido ocurrió.";
}

if (isset($errors)){
    include("errors.php");
}
if (isset($messages)){
    include("success.php");
}
?>