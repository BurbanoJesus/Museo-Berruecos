<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

require_once VIEWS.'templates/head.php';

$juegos = "active";
include VIEWS.'templates/header.php';

?>
<main>
	<div class="main">
		<div class="contenido" id="juegos">
			<?php
			require_once LIBS.'verificar_sesion.php';
			if ($flag_session === False){
			?>
			<div class="informacion parent_me_elemento">
				<!-- <div class="absolute">
					<span class="estado_progreso completo">
						<i class="icon-check-b"></i>
						<p>Completado</p>
					</span>
				</div> -->
				<h2 class="h2_informacion">Juego Verdadero o Falso</h2>
				<span class="descripcion_juego">En este juego debes decidir si una afirmación sobre un tema es verdadera o falsa.</span>
				<div class="lista_juegos">
					<div class="elemento_juego">
						<div class="div_main_jugar_one">
							<div onclick="javascript:window.location='/museo/lista_juego_vf'" class="main_jugar">
								<img class="main_jugar" src="<?php echo IMG?>default/jugar1.png" alt="" />
								<span class="sp_jugar">JUGAR!</span>
							</div>
						</div>
					</div>
				</div>
				<?php if ($tipo_usuario == 'administrador'){ ?>
				<div class="menu_elemento">
					<div class="me_icon filled"><i class="icon-filled-ellipsis"></i></div>
					<div class="me_opciones">
						<span onclick="javascript:window.location = '<?php echo HOST?>registrar_juego_vf'" class="me_opcion"><i class="icon-filled-add"></i>Agregar Registro</span>
						<span onclick="javascript:window.location = '<?php echo HOST?>administrar_juego_vf'" class="me_opcion"><i class="icon-filled-lista"></i>lista de Registros</span>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="informacion parent_me_elemento">
				<!-- <div class="absolute">
					<span class="estado_progreso">
						<p>No Completado</p>
					</span>
				</div> -->
				<h2 class="h2_informacion">Juego Ahorcado</h2>
				<span class="descripcion_juego">En este juego debes adivinar una palabra deacuerdo a la descripción, tienes un numero de intentos limitados.</span>
				<div class="lista_juegos">
					<div class="elemento_juego">
						<div class="div_main_jugar_one">
							<div onclick="javascript:window.location = '/museo/juego_ahorcado'" class="main_jugar">
								<img class="main_jugar" src="<?php echo IMG?>default/jugar1.png" alt="" />
								<span class="sp_jugar">JUGAR!</span>
							</div>
						</div>
					</div>
				</div>
				<?php if ($tipo_usuario == 'administrador'){ ?>
				<div class="menu_elemento">
					<div class="me_icon filled"><i class="icon-filled-ellipsis"></i></div>
					<div class="me_opciones">
						<span onclick="javascript:window.location = '<?php echo HOST?>registrar_juego_ahorcado'" class="me_opcion"><i class="icon-filled-add"></i>Agregar Registro</span>
						<span onclick="javascript:window.location = '<?php echo HOST?>administrar_juego_ahorcado'" class="me_opcion"><i class="icon-filled-lista"></i>lista de Registros</span>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="informacion parent_me_elemento">
				<!-- <div class="absolute">
					<span class="estado_progreso">
						<p>No Completado</p>
					</span>
				</div> -->
				<h2 class="h2_informacion">Juego Arrastrar Respuestas</h2>
				<span class="descripcion_juego">En este juego debes arrastrar la respuesta que creas correcta hacia los enunciados disponibles.</span>
				<div class="lista_juegos">
					<div class="elemento_juego">
						<div class="div_main_jugar_one">
							<div onclick="javascript:window.location='/museo/juego_arrastrar'" class="main_jugar">
								<img class="main_jugar" src="<?php echo IMG?>default/jugar1.png" alt="" />
								<span class="sp_jugar">JUGAR!</span>
							</div>
						</div>
					</div>
				</div>
				<?php if ($tipo_usuario == 'administrador'){ ?>
				<div class="menu_elemento">
					<div class="me_icon filled"><i class="icon-filled-ellipsis"></i></div>
					<div class="me_opciones">
						<span onclick="javascript:window.location = '<?php echo HOST?>registrar_juego_arrastrar'" class="me_opcion"><i class="icon-filled-add"></i>Agregar Registro</span>
						<span onclick="javascript:window.location = '<?php echo HOST?>administrar_juego_arrastrar'" class="me_opcion"><i class="icon-filled-lista"></i>lista de Registros</span>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>	
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>