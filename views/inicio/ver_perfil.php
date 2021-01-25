<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'usuario.php';
session_start();

require_once VIEWS.'templates/head.php';

include VIEWS.'templates/header.php';
$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$obj_juegos = new Usuario();
$array = $obj_juegos->usuario_por_nickname_all($usuario);
$array_1 = $obj_juegos->actualizar_progreso_juegos('juego_vf');
// var_dump($array_1);

if ($array != False){
$fecha = to_fecha_str($array->fecha_reg);
$hora = to_hora_str($array->fecha_reg);

?>
<main>
	<div class="main" id="detalles_perfil">
		<div class="contenido">
			<form class="s100" method="POST" action="<?php echo CONTROLLERS?>panel/c_ver_perfil.php" id="form_ver_perfil">
				<h2 class="titulo">Perfil de usuario</h2>
				<div class="separador"></div>
				<div class="content_detalles">
					<div class="info_detalles">
						<div class="nombre_detalles usuario">
							<img target="theater" class="call_theater simple" src="<?php echo $array->img_preview ?>" alt="" />
							<span class="main"><?php echo $array->nombres ?></span>
						</div>
						<div class="lista_detalles">
							<div class="opcion">
								<span class="info_label">Tipo de usuario</span>
								<span class="info"><?php echo $array->tipo_usuario ?></span>
							</div>
							<div class="opcion">
								<span class="info_label">Fecha de registro</span>
								<span class="info"><?php echo $fecha ?></span>
							</div>
							<div class="opcion">
								<span class="info_label">Municipio</span>
								<span class="info"><?php echo $array->municipio ?></span>
							</div>
							<div class="opcion last">
								<span class="info_label">Correo</span>
								<span class="info"><?php echo $array->correo ?></span>
							</div>
						</div>
					</div>
					<div class="h2_detalles"><h2>Información de Juegos</h2></div>
					<div class="info_detalles">
						<div class="lista_detalles progreso">
							<div class="opcion">
								<span class="info_label">Juego Verdadero/Falso</span>
								<?php $estado = ($array->estado_juego_vf == 'D')? 'Incompleto':'Completo'; ?>
								<?php $str_class = ($array->estado_juego_vf == 'D')? '':'completo'; ?>
								<div class="info_progreso"><span class="estado_progreso <?php echo $str_class ?>"><?php echo $estado ?></span></div>
							</div>
							<div class="opcion">
								<span class="info_label">Juego Ahorcado</span>
								<?php $estado = ($array->estado_juego_ahorcado == 'D')? 'Incompleto':'Completo'; ?>
								<?php $str_class = ($array->estado_juego_ahorcado == 'D')? '':'completo'; ?>
								<div class="info_progreso"><span class="estado_progreso <?php echo $str_class ?>"><?php echo $estado ?></span></div>
							</div>
							<div class="opcion last">
								<span class="info_label">Juego Mueve y juega</span>
								<?php $estado = ($array->estado_juego_arrastrar == 'D')? 'Incompleto':'Completo'; ?>
								<?php $str_class = ($array->estado_juego_arrastrar == 'D')? '':'completo'; ?>
								<div class="info_progreso"><span class="estado_progreso <?php echo $str_class ?>"><?php echo $estado ?></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="content_button next">
					<button type="button" class="button inline" onclick="window.location = '<?php echo HOST?>inicio'"><i class="icon-lineal-flecha volver"></i>Regresar</button>
				</div>
			</form>
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
</main>
<?php
}else{ 
include VIEWS.'templates/error404.php';
}
// $scripts= ['summernote.js','funciones_editor_texto.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>