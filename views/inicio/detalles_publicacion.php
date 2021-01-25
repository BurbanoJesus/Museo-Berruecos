<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'publicacion.php';
session_start();

require_once VIEWS.'templates/head.php';
?>

<?php
// $actualidad = "active";
include VIEWS.'templates/header.php';
$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$obj_publicacion = new Publicacion();
$array = $obj_publicacion->detalles($id);

if ($array != False){ 
$row_principal = $array[0];
$fecha = to_fecha_str($row_principal->fecha_pub);
$hora = to_hora_str($row_principal->fecha_pub);
?>
<main>
	<div class="main" id="detalles_publicacion">
		<div class="contenido">
			<?php if (isset($_SESSION['usuario'])){ ?>
			<div class="detalles_pb">
				<?php $type = type_multimedia($row_principal->url);
				if ($type == 'image') { ?>
					<div class="img"><img index="0" src="<?php echo $row_principal->url?>" target="theater" class="call_theater simple" /></div>
				<?php } else { ?>
					<div class="img"><video index="0" target="theater" class="call_theater simple" controls>
						<source src="<?php echo $row_principal->url?>" type="video/mp4">Your browser does not support HTML5 video
					</video></div>
				<?php } ?>
				<div class="titulo_detalles">
					<h1 class="detalles"><?php echo $row_principal->titulo?></h1>
					<span class="fecha"><?php echo $fecha.' '.$hora?></span>
				</div>

				<?php echo $row_principal->descripcion?>
				
				<?php if (isset($row_principal->id_multimedia)) { ?>
				<span class="galeria">Galeria</span>
				<div class="galeria_detalles">
					<div class="img" id="detalles">
						<?php foreach ($array as $key => $row) {
								$multimedia = '';
								$type = type_multimedia($row->url);
								if ($type == 'image') {
									$multimedia .= "<img index='$key' target='theater' class='call_theater simple file' src= '$row->url' />";
								} else {
									$multimedia .= "<video index='$key' target='theater' class='call_theater simple file' disablePictureInPicture controls src='$row->url'>Your browser does not support HTML5 video</video>";
								}
								echo $multimedia;
							}
						?>
					</div>
				</div>
				<?php } ?>
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
			<?php 
			}else{ 
				include VIEWS.'templates/init_session.php';
			} 
		?>
		</div>
	</div>	
</main>
<?php
    }else{ 
	include VIEWS.'templates/error404.php';
	}

$scripts= ['summernote.js','funciones_editor_texto.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>