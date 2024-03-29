<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['user_id_mod'])){
	$errors[] = "ID vacío";
}  elseif (empty($_POST['user_password_new3']) || empty($_POST['user_password_repeat3'])) {
	$errors[] = "Contraseña vacía";
} elseif ($_POST['user_password_new3'] !== $_POST['user_password_repeat3']) {
	$errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
}  elseif (
		!empty($_POST['user_id_mod'])
	&& !empty($_POST['user_password_new3'])
	&& !empty($_POST['user_password_repeat3'])
	&& ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
) {
	require_once ("../config/db.php");
	require_once ("../config/connection.php");

		$user_id=intval($_POST['user_id_mod']);
		$user_password = $_POST['user_password_new3'];

		$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

		$sql = "UPDATE users SET user_password_hash='".$user_password_hash."' WHERE user_id='".$user_id."'";
		$query = mysqli_query($con,$sql);

		if ($query) {
			$messages[] = "contraseña ha sido modificada con éxito.";
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