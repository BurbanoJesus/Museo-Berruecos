<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

require_once VIEWS.'templates/head.php';
?>

<?php
$visita = "active";
include VIEWS.'templates/header.php';
include_once LIBS.'verificar_sesion.php';
?>
<main>
	<div class="main">
		<div class="contenido" id="registrar_visita">
			<form class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_registrar_visita.php" id="form_registrar_visita" enctype="multipart/form-data">
				<h2>Registrar nuevo lugar</h2>
				<div class="input s100">
					<h3>Nombre.</h3>
					<div class="contenido_input"><input class="input" type="text" name="titulo"  placeholder="Ingresar titulo..."/></div>
				</div>
				<div class="input s100">
					<h3>Descripción.</h3>
					<div class="contenido_input"><textarea class="input input_text" name="descripcion" id="" placeholder="Ingresar Descripción..."></textarea></div>
				</div>
				<div class="input s100">
					<h3>Elegir Ubicación.</h3>
					<div class="maps">
						<input id="search_maps" type="text" placeholder="Buscar Lugar...">
						<div id="map" style="height: 800px;"></div>
						<div class="btn_geolo">
							<div class="img_geolo"></div>
						</div>
						<div class="div_lat_lng" style="display: none;">
							<input class="lat" type="text" name="latitud" required>
							<input class="lng" type="text" name="longitud" required>
						</div>
					</div>
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
					<button type="submit" class="button"><i class="icon-filled-anuncio"></i>Registrar</button>
				</div>
			</form>
		</div>
	</div>	
</main>
<?php 
$scripts = ['https://maps.googleapis.com/maps/api/js?key=AIzaSyChPpLC5zuF6bKJYUb7Br2-geN5UvbxBC4&libraries=places','mapas_registro.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>