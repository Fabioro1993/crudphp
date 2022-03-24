<?php
include('is_logged.php');
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['firstname'])){
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['lastname'])){
    $errors[] = "Apellidos vacíos";
} elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
    $errors[] = "Contraseña vacía";
} elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
    $errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
} elseif (strlen($_POST['user_password_new']) < 6) {
    $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
} elseif (empty($_POST['user_email'])) {
    $errors[] = "El correo electrónico no puede estar vacío";
} elseif (strlen($_POST['user_email']) > 64) {
    $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (
    !empty($_POST['firstname'])
    && !empty($_POST['lastname'])
    && !empty($_POST['user_email'])
    && strlen($_POST['user_email']) <= 64
    && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
    && !empty($_POST['user_password_new'])
    && !empty($_POST['user_password_repeat'])
    && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
) {
    require_once ("../config/db.php");
    require_once ("../config/connection.php");

        $firstname = mysqli_real_escape_string($con,(strip_tags($_POST["firstname"],ENT_QUOTES)));
        $lastname = mysqli_real_escape_string($con,(strip_tags($_POST["lastname"],ENT_QUOTES)));
        $user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email"],ENT_QUOTES)));
        $user_password = $_POST['user_password_new'];
        $date_added=date("Y-m-d H:i:s");

        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE user_email = '" . $user_email . "';";
        $query_check_user_name = mysqli_query($con,$sql);
        $query_check_user=mysqli_num_rows($query_check_user_name);
        if ($query_check_user == 1) {
            $errors[] = "Lo sentimos , la dirección de correo electrónico ya está en uso.";
        } else {
            $sql = "INSERT INTO users (firstname, lastname, user_password_hash, user_email, date_added)
                    VALUES('".$firstname."','".$lastname."', '" . $user_password_hash . "', '" . $user_email . "','".$date_added."');";
            $query_new_user_insert = mysqli_query($con,$sql);

            if ($query_new_user_insert) {
                $messages[] = "La cuenta ha sido creada con éxito.";
            } else {
                $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
            }
        }
    } else {
    $errors[] = "Un error desconocido ocurrió.";
}

if (isset($errors)){
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong>
            <?php
                foreach ($errors as $error) {
                    echo $error;
                }
            ?>
    </div>
    <?php
}
if (isset($messages)){
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
            foreach ($messages as $message) {
                echo $message;
            }
        ?>
    </div>
    <?php
}
?>