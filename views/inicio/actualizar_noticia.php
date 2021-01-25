<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();


$estilos = ['summernote.css'];
include VIEWS.'templates/head.php';


$actualidad = "active";
include VIEWS.'templates/header.php';
include_once LIBS.'verificar_sesion.php';

?>

<main>
	<div class="main" id="actualizar_noticia">
		<div class="contenido">
			<form class="form s100" method="POST" action="<?php echo CONTROLLERS?>inicio/c_actualizar_noticia.php" id="form_actualizar_noticia" enctype="multipart/form-data">
				<h2>Ingresar Noticia</h2>
				<div class="div_s70">
					<div class="input s100">
						<h3>Titulo de la Noticia.</h3>
						<div class="contenido_input"><textarea class="titulo input" name="titulo"  placeholder="Ingresar Titulo..."></textarea></div>
					</div>
					<div class="input s100">
						<h3>Descripción de la Noticia.</h3>
						<div class="editor editor_pb"><textarea id="editor_texto" name="descripcion"></textarea></div>
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
								<div class="div_button"><label class="button" for="input_file_1">Agregar</label></div>
					        </div>
						</div>
					</div>
					</div>
					<input type="hidden" name="fecha" value="" />
					<div class="content_button next">
						<button type="submit" class="button"><i class="icon-filled-admin-c"></i>Actualizar</button>
					</div>
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