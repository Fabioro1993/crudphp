<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
			foreach ($errors as $error) {
				echo $error;
			}
		?>
</div>