<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'lugar.php';
session_start();

require_once VIEWS.'templates/head.php';

$obj_lugar = new lugar();
$array = $obj_lugar->listar_detalles();

// $id_old = '';
// $array_lugares = [];
// $cont = -1;
// if ($array != False){
// 	foreach ($array as $key => $row) {
// 		$id_new = $row->id_lugar;
// 		if ($id_new != $id_old) {
// 			$cont++;
// 			$array_lugares[$cont] = [];
// 			array_push($array_lugares[$cont], $row);
// 		}else{ 
// 			array_push($array_lugares[$cont], $row);
// 		}
// 		$id_old= $row->id_lugar;
// 	}
// }

$visita = "active";
include VIEWS.'templates/header.php';

?>
<main>
	<div class="main">
		<div class="contenido" id="visita">
			<?php
			if (isset($_SESSION['usuario'])){
				// if ($array != False) {
				// 	foreach ($array_lugares as $key => $array) {
				// 		echo '<div id="multimedia_'.$key.'" style="display: none;" latitud="'.$array[0]->latitud.'" longitud="'.$array[0]->longitud.'" titulo="'.$array[0]->titulo.'" class="multimedia_data img">';
				// 		foreach ($array as $key => $row) {
				// 			$type = type_multimedia($row->url);
				// 			if ($type == 'imagen') { 
				// 				echo '<img index="'.$key.'" src="'.$row->url.'" target="theater" class="call_theater multimedia" />';
				// 			 } else { 
				// 				echo '<video index="'.$key.'" target="theater" class="call_theater multimedia" controls>
				// 					<source src="'.$row->url.'" type="video/mp4">Your browser does not support HTML5 video
				// 				</video>';
				// 			}
				// 		}
				// 		echo '</div>'.PHP_EOL;
				// 	}
				// }
			?>
			<?php if ($tipo_usuario == 'administrador') { ?>
			<div class="nuevo_registro">
				<h2>Ingresar un nuevo registro</h2>
				<div class="content_button">
					<button onclick="window.location = '<?php echo HOST?>registrar_visita'" type="button" class="button"><i class="icon-filled-add"></i>Agregar</button>
				</div>
			</div>
			<?php } 
			if ($array != False) {
			?>
			<div class="informacion">
				<h2>Tour Virtual Museo Arqueológico Berruecos Nariño</h2>
				<p class="p_info">Haz click en los nombres de los marcadores que aparecen en el mapa</p>
				<div class="maps">
					<div id="map" style="height: 800px;"></div>
				</div>
			</div>
			<?php }else{
				include VIEWS.'templates/empty.php';
			} ?>
		</div>
		<div id="theater" class="theater" data="">
			<div index="" class="indicador"></div>
			<div class="close"><i class="icon-cancelar"></i></div>
			<div index="" class="btn_left"><i class="icon-arrow-c"></i></div>
			<div index="" class="btn_right"><i class="icon-arrow-c"></i></div>
			<div class="theater_main">
				<div class="theater_content">
					
				</div>
			</div>
		</div>
		<?php 
			}else{ 
				include VIEWS.'templates/init_session.php';
			} 
		?>
	</div>	
</main>
<?php 
$scripts = ['https://maps.googleapis.com/maps/api/js?key=AIzaSyChPpLC5zuF6bKJYUb7Br2-geN5UvbxBC4','mapas.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>