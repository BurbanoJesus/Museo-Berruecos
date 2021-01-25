<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

require VIEWS.'templates/head.php';

include VIEWS.'templates/header.php';
?>

<main>
	<div class="main">
		<div class="contenido">
			<form class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_recuperar_pass.php" id="recuperar_pass">
				<div class="input">
					<h3>Se debe ingresar el Correo electrónico con el cual se realizo el registro de su cuenta para enviar el correo de recuperación.</h3>
					<div class="contenido_input">
						<input class="input input_correo" type="text" name="correo"  placeholder="Ingresar Correo..." minlength="5" required />
					</div>
				</div>
				<input type="hidden" name="fecha" value="" />
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-correo"></i>Enviar Correo</button>
				</div>
			</form>
		</div>
	</div>
</main>

<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>