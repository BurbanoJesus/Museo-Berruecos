<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'pieza.php';
session_start();

require_once VIEWS.'templates/head.php';

$seguridad = "active";
include VIEWS.'templates/header.php';
include_once LIBS.'verificar_sesion.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$obj_pieza = new Pieza();
$array = $obj_pieza->detalles($id);
// var_dump($array);
if ($array != False){ 
$row_principal = $array[0];
$row_principal->fecha_pub = to_fecha_str($row_principal->fecha_pub);

?>
<main>
	<div class="main">
		<div class="contenido">
			<div class="producto">
				<div class="slider_multimedia" id="multimedia" numero_imgs="9">
					<div class="img_main">
						<?php $length = count($array);
						 if($length > 1 && isset($row_principal->id_multimedia)) { 
						?>
						<i index="<?php echo $length ?>" class="icon-arrow-c btn_left"></i>
						<i index="1" class="icon-arrow-c btn_right"></i>
						<?php } ?>
						<div class="current_mult">
						<?php
						if (isset($row_principal->id_multimedia)) {
							$type = $row_principal->tipo;
							$file_principal = $row_principal->url;
						}else{
							$type = $row_principal->tipo_preview;
							var_dump($row_principal->tipo);
							$file_principal = $row_principal->preview;
						}
						if ($type == 'image') { ?>
							<img class="call_theater multimedia file" index="0" target="theater" src="<?php echo $file_principal?>" />
						<?php } else if ($type == 'video') { ?>
							<!-- <video class="call_theater multimedia file" index="0" target="theater" controls>
								<source src="<?php echo $file_principal?>" type="video/mp4">Your browser does not support HTML5 video
							</video> -->
						<?php } else if ($type == 'audio') { ?>
							<!-- <audio class="call_theater multimedia file" index="0" target="theater" controls>
								<source src="<?php echo $file_principal?>" type="audio/mp3">Your browser does not support HTML5 video
							</audio> -->
						<?php } else if ($type == 'youtube') { ?>
							<iframe class="call_theater multimedia file" target="theater" width="900" height="450" src="https://www.youtube.com/embed/BNNNArKGz3g"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						<?php } ?>
						</div>
					</div>
					<div class="file_multimedia">
						<?php  

						$cont = 0;
						if (isset($row_principal->id_multimedia)) {
						foreach ($array as $key => $row) {
							$last = '';
							$multimedia = '';
							$active = ($key == 0) ? 'active' : '';
							$none = ($key > 9) ? 'none' : '';

							$type = $row->tipo;
							// echo $type;
							if($key == 9){
								$last = 'last';
								$span_num = sizeof($array)-10;
								$multimedia = "<span>+$span_num</span>";
							}

							if ($type == 'image') {
								$multimedia .= "<img class='file' src= $row->url />";
							} else if ($type == 'video'){
								$multimedia .= "<div class='video_img'></div>";
								$multimedia .= "<video class='file' disablePictureInPicture controls src='$row->url'>Your browser does not support HTML5 video</video>";
							} else if ($type == 'audio'){
								$multimedia .= "<div class='video_img'></div>";
								$multimedia .= "<audio class='file' disablePictureInPicture controls src='$row->url'>Your browser does not support HTML5 audio</audio>";
							} else if ($type == 'youtube'){
								$multimedia .= "<div class='video_img'></div>";
								$multimedia .= "<div class='file'>video de youtube</div>";
							}
						?>
								<!-- <video disablePictureInPicture width='300' id="video" controls src="https://rawcdn.githack.com/Freshman-tech/custom-html5-video/911e6fbfc39d670cb26e94d6f3013b9426f4a679/video.mp4"></video> -->
						<div index="<?php echo $key ?>" class="imagen <?php echo $active?> <?php echo $last?> <?php echo $none?>"><?php echo $multimedia?></div>
					<?php } }?>
					
					</div>
				</div>
				<div class="vista_detalles">
					<div class="caracteristicas first">
						<h1><?php echo $row_principal->titulo?></h1>
						<p class="fecha">Publicado: <?php echo $row_principal->fecha_pub ?></p>
					</div>
					<div class="caracteristicas">
						<h2>Descripcion</h2>
						<p><?php echo $row_principal->descripcion ?></p>
					</div>
					<div class="caracteristicas last">
						<h2>Categoria</h2>
						<div class="caracteristica">
							<div class="elemento">
								<p><?php echo $row_principal->categoria ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="theater" class="theater multimedia" data="">
				<div index="" class="indicador"></div>
				<div class="close"><i class="icon-cancelar"></i></div>
				<div index="" class="btn_left"><i class="icon-arrow-c"></i></div>
				<div index="" class="btn_right"><i class="icon-arrow-c"></i></div>
				<div class="theater_main">
					<div class="theater_content">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
    }else{ 
	include VIEWS.'templates/error404.php';
	}
?>

<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>