<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'juego_arrastrar.php';
session_start();

$estilos = ['estilos_inicio.css','estilos_form.css'];
require VIEWS.'templates/head.php';

$id_juego = (isset($_GET['id_juego'])) ? $_GET['id_juego'] : '';
$obj_juego_arrastrar = new Juego_arrastrar();
$row = $obj_juego_arrastrar->detalles($id_juego);


$cuenta = "active";
include VIEWS.'templates/header.php';


?>

<main>
	<div class="main" id="registrar_juego_arrastrar">
		<div class="contenido">
			<form id="form_registrar_juego_arrastrar" class="form s40" method="POST" action="<?php echo CONTROLLERS?>inicio/c_editar_juego_arrastrar.php">
				<h2>Editar Juego Colocar Respuestas</h2>
				<div class="input s100">
					<h3>Enunciado</h3>
					<div class="contenido_input"><textarea class="input input_text" name="enunciado"  placeholder="Ingresar Enunciado..."><?php echo $row->enunciado ?></textarea></div>
				</div>
				<div class="input s100">
					<h3>Respuesta</h3>
					<div class="contenido_input"><input class="input input_text" type="text" name="respuesta"  placeholder="Ingresar Respuesta..." value="<?php echo $row->respuesta ?>" /></div>
				</div>
				<input type="hidden" name="id_juego" value="<?php echo $row->id_juego ?>" />
				<input type="hidden" name="fecha" value="" />
				<?php if (isset($_GET['validate_msj'])) {
					echo '<div class="input s100"><div class="validate_msj">'.$_GET['validate_msj'].'</div></div>';
				} ?>
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-editar"></i>Actualizar</button>
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