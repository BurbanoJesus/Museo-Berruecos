<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'publicacion.php';
session_start();

require_once VIEWS.'templates/head.php';

$obj_publicacion = new Publicacion();
$array = $obj_publicacion->listar_inicio();

// var_dump($array);

$inicio = "active";
include VIEWS.'templates/header.php';
?>
<main>
	<div class="main" id="inicio">
		<div class="contenido">
			<div class="base_slider">
				<div id="contenedor_slider" class="contenedor_slider">
					<div id="slider" class="slider">
						<?php foreach ($array as $key => $row) { ?>
					    <section id="<?php echo $key ?>" class="slider_section">
					    	<?php 
							$type = type_multimedia($row->url);
							$extension = ext_multimedia($row->url);
							if ($type == 'image'){
								if ($extension != 'png') {
							?>
								<div class="img"><img index="0" src="<?php echo $row->url?>" target="theater" class="call_theater simple" /></div>
								<?php } else { ?>
								<div class="img"><img index="0" src="<?php echo IMG?>usuario/main_museo.jpg" target="theater" class="call_theater simple" /></div>
								<?php } ?>
							<?php } else { ?>
								<div class="img"><video index="0" target="theater" class="call_theater simple" src="<?php echo $row->url?>" type="video/mp4" controls></video></div>
							<?php } ?>
							<!-- <?php if ($tipo_usuario == 'admin') { ?>
								<div class="menu_elemento">
									<div class="me_icon"><i class="icon-filled-ellipsis"></i></div>
									<div class="me_opciones">
										<span class="me_opcion me_eliminar"><i class="icon-filled-editar"></i>Editar</span>
										<span class="me_opcion me_eliminar"><i class="icon-filled-eliminar-b"></i>Eliminar</span>
									</div>
								</div>
							<?php } ?> -->
							<div class="info_section">
								<h2><?php echo $row->titulo ?></h2>
								<span><?php echo strip_tags($row->descripcion) ?></span>
								<a href="<?php echo HOST?>detalles_publicacion?id=<?php echo  $row->id_publicacion?>" class="button section bg_b">Ver más</a>
							</div>
							<!-- <div class="info_section">
								<h2>Abre tu cuenta gratis</h2>
								<span>Puedes crear tu cuenta registrandote gratis y disfrutar los servicios del sistio web del plan de intervenciónes colectivas.</span>
								<a href="<?php echo HOST?>registrar_usuario" class="button section bg_b">Ver más</a>
							</div> -->
					    </section>
					   	<?php } ?>
					</div>
					<?php if(count($array) > 1){?>
				    <div id="btn_prev" class="btn_prev"><i class="icon-arrow-c"></i></div>
				    <div id="btn_next" class="btn_next"><i class="icon-arrow-c"></i></div>
				<?php } ?>
				</div>
			</div>
			<div class="informacion">
				<h2>Museo Arqueológico Berrruecos</h2>
				<p class="p_info">El Museo Arqueológico Berrruecos es una institución pública o privada, permanente, con o sin fines de lucro, al servicio de la sociedad y de su desarrollo, y abierta al público, que adquiere, conserva, investiga, comunica, expone o exhibe, con propósitos de estudio y educación, colecciones de arte, científicas, entre otros, siempre con un valor cultural.</p>
			</div>
			<div class="informacion last">
				<h2>Ubicación Museo.</h2>
				<div class="maps">
					<iframe class="iframe" src="https://maps.google.com/?q=1.5029142,-77.13532&z=16&t=k&output=embed" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div id="theater" class="theater" data="">
			<div index="" class="indicador"></div>
			<div class="close"><i class="icon-cancelar"></i></div>
			<div index="" class="btn_left"><i class="icon-arrow-c"></i></div>
			<div index="" class="btn_right"><i class="icon-arrow-c"></i></div>
			<div class="theater_main">
				<div class="theater_content">
					<img index="0" src="" id="img_theater">
				</div>
			</div>
		</div>
		<div id="div_mod_eliminar"></div>
	</div>	
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>