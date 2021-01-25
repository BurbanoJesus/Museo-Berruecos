<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();
require_once LIBS.'verificar_general.php';

$estilos = ['summernote.css'];
include VIEWS.'templates/head.php';

$aprende = "active";
include VIEWS.'templates/header.php';

?>

<main>
	<div class="main" id="registrar_publicacion">
		<div class="contenido">
			<form class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_registrar_publicacion.php" enctype="multipart/form-data">
				<h2>Registrar un artículo o publicación</h2>
				<div class="input s100">
					<h3>Titulo.</h3>
					<div class="contenido_input"><input class="input input_text" type="text" name="titulo"  placeholder="Ingresar titulo..." /></div>
				</div>
				<div class="input s100">
					<h3>Descripción.</h3>
					<div class="editor editor_pb"><textarea id="editor_texto" name="descripcion" height = '400px'></textarea></div>
				</div>
				<div class="input s100">
					<h3>Agregar Contenido Multimedia.</h3>
					<div class="contenido_input">
						<div id="contenido_img" class="contenido_img">
							<div id="loading_inf_1" class="loading_inf"><img src="<?php echo IMG?>loading/loading3.gif" alt=""></div>
							<div class="agregar_mult">
					        	<input class="input_mult input_preview" id="input_file_1" name="images[]" type="file" accept="image/*,video/mp4" required />
					            <!-- accept="image/*" or accept="image/jpeg,image/png" -->
					            <label class="label_icon icon-filled-add-multimedia" for="input_file_1"></label>
								<div class="content_button"><label class="button" for="input_file_1">Agregar</label></div>
					        </div>
						</div>
					</div>
				</div>
				<input type="hidden" name="fecha" value="" />
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-check"></i>Registrar</button>
				</div>
			</form>
		</div>
	</div>
</main>
<?php
$scripts= ['summernote.js','funciones_editor_texto.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>