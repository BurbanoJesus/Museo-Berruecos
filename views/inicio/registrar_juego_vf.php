<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

$estilos = ['estilos_inicio.css','estilos_form.css','comp_select.css'];
include VIEWS.'templates/head.php';


$juegos = "active";
include VIEWS.'templates/header.php';
include_once LIBS.'verificar_sesion.php';
?>

<main>
	<div class="main" id="registrar_juego_vf">
		<div class="contenido">
			<form class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_registrar_juego_vf.php" id="form_registrar_juego_vf" enctype="multipart/form-data">
				<h2>Registrar Juego</h2>
				<div class="input s100">
					<h3>Titulo de Juego</h3>
					<div class="contenido_input"><input class="input" type="text" name="titulo"  placeholder="Ingresar titulo..." required /></div>
				</div>
				<div class="separador"></div>
				<div class="content_juegos_vf">
					<div class="contenido_preguntas">
						<div class="input s100">
							<h3>Pregunta 1.</h3>
							<div class="contenido_input"><textarea class="input input_text" name="pregunta_1" id="" placeholder="Ingresar Información..." required></textarea></div>
						</div>
						<div class="input s100">
							<h3>Respuesta 1.</h3>
							<div class="select" id="categoria" data="">
							<div class="head_select">
								<span class="nombre_select">Seleccione respuesta</span>
								<i class="icon-arrow"></i>
							</div>
							<div class="opciones">
								<div class="opcion"><i class="icon-filled-check"></i><span>Verdadero</span></div>
								<div class="opcion"><i class="icon-filled-check"></i><span>Falso</span></div>
							</div>
							<input type="hidden" name="respuesta_1" required />
						</div>
						</div>
						<div class="input s100">
							<h3>Agregar Imagen.</h3>
							<div class="contenido_input">
								<div id="contenido_img" class="contenido_img">
									<div id="loading_inf_1" class="loading_inf"><img src="<?php echo IMG?>loading/loading3.gif" alt=""></div>
									<div class="agregar_mult">
							            <input class="input_preview input_file_one" id="input_file_1" name="image_1" type="file" accept="image/*" required />
							            <!-- accept="image/*" or accept="image/jpeg,image/png" -->
							            <label class="label_icon icon-filled-add-multimedia" for="input_file_1"></label>
										<div class="div_button"><label class="button" for="input_file_1">Agregar</label></div>
							        </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="content_button agregar_nuevo">
					<a id="add_pregunta" class="button" type="button"><i class="icon-lineal-add"></i>Agregar Nueva Pregunta</a>
					<a id="remove_pregunta" class="disabled button" type="button"><i class="icon-cancelar"></i>Quitar Pregunta</a>
				</div>
				<input type="hidden" name="fecha" value="" />
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-check"></i>Registrar</button>
				</div>
				<?php if (isset($_GET['validate_msj'])) {
					echo '<div class="input s100"><div class="validate_msj">'.$_GET['validate_msj'].'</div></div>';
				} ?>
			</form>
		</div>
	</div>
</main>
<?php
$scripts = ['comp_select.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>