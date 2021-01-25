<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

require VIEWS.'templates/head.php';
include VIEWS.'templates/header.php';

$msj = (isset($_GET['msj'])) ? $_GET['msj'] : '';
?>

<main>
	<div class="main">
		<div class="contenido">
			<form class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_email_active.php" id="email_active">
				<div class="input">
					<h3>Correo electrónico.</h3>
					<div class="contenido_input">
						<input class="input input_correo" type="text" name="correo"  placeholder="Ingresar Correo..." minlength="5" required />
					</div>
				</div>
				<input type="hidden" name="fecha" value="" />
				<div class="button siguiente">
					<button type="submit" class="button"><i class="icon-filled-correo"></i>Enviar Correo</button>
				</div>
				<?php if($msj != ''){
					echo '<div class="c_msj_php">'.$msj.'</div>';
				} ?>
			</form>
		</div>
	</div>
</main>

<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>