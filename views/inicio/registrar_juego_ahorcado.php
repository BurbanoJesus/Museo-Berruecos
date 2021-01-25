<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

$estilos = ['estilos_inicio.css','estilos_form.css'];
require VIEWS.'templates/head.php';
$cuenta = "active";
include VIEWS.'templates/header.php';


?>

<main>
	<div class="main" id="registrar_juego_ahorcado">
		<div class="contenido">
			<form id="form_registrar_juego_ahorcado" class="form s40" method="POST" action="<?php echo CONTROLLERS?>inicio/c_registrar_juego_ahorcado.php">
				<h2>Agregar Juego Ahorcado</h2>
				<div class="input s100">
					<h3>Enunciado</h3>
					<div class="contenido_input"><textarea class="input input_text" name="enunciado"  placeholder="Ingresar Enunciado..."></textarea></div>
				</div>
				<div class="input s100">
					<h3>Respuesta</h3>
					<div class="contenido_input"><input class="input input_text" type="text" name="respuesta"  placeholder="Ingresar Respuesta..." /></div>
				</div>
				<input type="hidden" name="id_curso" value="<?php echo $id_curso ?>" />
				<input type="hidden" name="fecha" value="" />
				<?php if (isset($_GET['validate_msj'])) {
					echo '<div class="input s100"><div class="validate_msj">'.$_GET['validate_msj'].'</div></div>';
				} ?>
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-add"></i>Agregar</button>
				</div>
			</form>
		</div>
	</div>
</main>

<?php
// $scripts = [''];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>