<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
	}

	/* Connect To Database*/
	require_once ("config/db.php");
	require_once ("config/connection.php");
	$active_users="active";
	$title="Usuarios | Workanda";
?>
<!DOCTYPE html>
<html lang="en">
<head> <?php include("head.php");?> </head>
<body>
	<?php include("navbar.php"); ?>
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<button type='button' class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span>Nuevo Usuario</button>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i>Buscar Usuarios</h4>
			</div>
			<div class="panel-body">
				<?php
					include("modal/register_users.php");
					include("modal/edit_users.php");
					include("modal/change_password.php");
				?>
				<form class="form-horizontal" role="form" id="register_users">
					<div class="form-group row">
						<label for="q" class="col-md-2 control-label">Nombres:</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="Nombre" onkeyup='load(1);'>
						</div>
						<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='load(1);'>
								<span class="glyphicon glyphicon-search" ></span> Buscar
							</button>
							<span id="loader"></span>
						</div>
					</div>
				</form>
				<div id="result"></div>
				<div class='outer_div'></div>
			</div>
		</div>
	</div>
	<hr>
	<?php include("footer.php"); ?>
	<script type="text/javascript" src="js/users.js"></script>
</body>
</html>
<script>
	$( "#save_user" ).submit(function( event ) {
		$('#save_data').attr("disabled", true);

		var parameters = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/new_user.php",
			data: parameters,
			beforeSend: function(objeto){
				$("#result_ajax").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$("#result_ajax").html(datos);
				$('#save_data').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	$( "#edit_user" ).submit(function( event ) {
		$('#update_data').attr("disabled", true);

		var parameters = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/edit_user.php",
			data: parameters,
			beforeSend: function(objeto){
				$("#result_ajax_user").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$("#result_ajax_user").html(datos);
				$('#update_data').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	$( "#edit_password" ).submit(function( event ) {
		$('#update_data_pass').attr("disabled", true);

		var parameters = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/edit_password.php",
			data: parameters,
			beforeSend: function(objeto){
				$("#result_ajax_pass").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$("#result_ajax_pass").html(datos);
				$('#update_data_pass').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})

	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function get_data(id){
		var name = $("#name"+id).val();
		var lastname = $("#lastname"+id).val();
		var email = $("#email"+id).val();

		$("#mod_id").val(id);
		$("#firstname_edit").val(name);
		$("#lastname_edit").val(lastname);
		$("#user_email_edit").val(email);
	}
</script>