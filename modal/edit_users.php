<?php
if (isset($con)) {
?>
<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Editar usuario</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="edit_user">
					<div id="result_ajax_user"></div>
					<div class="form-group">
						<label for="firstname_edit" class="col-sm-3 control-label">Nombres</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="firstname_edit" name="firstname_edit" placeholder="Nombres" required>
							<input type="hidden" id="mod_id" name="mod_id">
						</div>
					</div>
					<div class="form-group">
						<label for="lastname_edit" class="col-sm-3 control-label">Apellidos</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="lastname_edit" name="lastname_edit" placeholder="Apellidos" required>
						</div>
					</div>
					<div class="form-group">
						<label for="user_email_edit" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="user_email_edit" name="user_email_edit" placeholder="Correo electrónico" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="update_data">Actualizar datos</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}
?>