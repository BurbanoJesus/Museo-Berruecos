<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'publicacion.php';
session_start();

require_once VIEWS.'templates/head.php';

$obj_publicacion = new Publicacion();
$array = $obj_publicacion->listar();

$aprende = "active";
include VIEWS.'templates/header.php';

?>
<main>
	<div class="main">
		<div class="contenido" id="aprende">
			<?php 
			if (isset($_SESSION['usuario'])){
			?>
			<div class="informacion">
				<h2 class="">Juegos</h2>
				<span class="descripcion_juego">Para ver los juegos disponibles haz click en el siguiente botón</span>
				<div class="elemento_juego">
					<div class="main_jugar" onclick="javascript:window.location='/museo/lista_juegos?id_user=123'">
						<img class="main_jugar" src="<?php echo  IMG?>default/jugar1.png" alt="" />
						<span class="sp_jugar">VER JUEGOS</span>
					</div>
				</div>
			</div>
			<div class="informacion last">
				<h2 class="">Artículos</h2>
				<div class="publicaciones">
				<?php 
				if ($array !== Null){
				foreach ($array as $key => $row){ 
					$last = (count($array) == $key + 1) ? 'last' : ''; ?>
					<div id="<?php echo $key ?>" class="publicacion parent_me_elemento <?php echo $last ?>" id_data="<?php echo $row->id_publicacion?>" url_data="c_eliminar_publicacion" model="publicacion">
						<img class="" src="<?php echo  $row->preview?>" alt="">
						<div class="prop" onclick="window.location = '<?php echo HOST?>detalles_publicacion?id=<?php echo  $row->id_publicacion?>'">
							<h2><?php echo  $row->titulo?></h2>
							<span><?php echo strip_tags($row->descripcion) ?></span>
						<a class="button responsive_movil_off" href="<?php echo HOST?>detalles_publicacion?id=<?php echo  $row->id_publicacion?>">Ver más</a>
						</div>
						<?php if ($tipo_usuario == 'administrador') { ?>
						<div class="menu_elemento">
							<div class="me_icon"><i class="icon-filled-ellipsis"></i></div>
							<div class="me_opciones">
								<span class="me_opcion me_eliminar"><i class="icon-filled-eliminar-b"></i>Eliminar</span>
							</div>
						</div>
						<?php } ?>
					</div>
				<?php } 
				}else{
				include VIEWS.'templates/empty.php';
				} ?>
				</div>
				<?php if ($tipo_usuario == 'administrador') { ?>
				<div class="nuevo_registro last">
					<h2>Agregar un nuevo Artículo</h2>
					<div class="content_button">
						<button onclick="window.location = '<?php echo HOST?>registrar_publicacion'" type="button" class="button"><i class="icon-filled-add"></i>Agregar nuevo</button>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php 
			}else{ 
				include VIEWS.'templates/init_session.php';
			} ?>
		</div>
		<div id="div_mod_eliminar"></div>
	</div>	
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>