<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'pieza.php';
session_start();

require_once VIEWS.'templates/head.php';

$museo = "active";
include VIEWS.'templates/header.php';

$categoria = (isset($_GET['categoria'])) ? $_GET['categoria'] : '';
$busqueda = (isset($_GET['busqueda'])) ? $_GET['busqueda'] : '';

$obj_pieza = new Pieza();
if ($categoria != '' || $busqueda != '') {
	$array = $obj_pieza->filtrar($categoria,$busqueda);
} else {
	$array = $obj_pieza->listar();
}

?>

<main>
	<div class="main">
	<?php if (isset($_SESSION['usuario'])){ 
		$tipo_usuario = $_SESSION['usuario']->tipo_usuario;
	?>
	<form id="form_lista_piezas" class="flex" method="POST" action="<?php echo CONTROLLERS?>inicio/c_lista_piezas.php">
		<div class="content_filtros">
			<div class="r_filtros responsive_movil_on <?php echo $get_on ?>">
				<span>Filtros</span>
				<i class="icon-filled-filtros r_filtros_arrow"></i>
			</div>
			<div class="filtros">
				<div class="filtro">
					<div class="check" id="categoria" data="<?php echo $categoria ?>">
						<h2>Categoria</h2>
						<div class="elemento"><i class="icon-filled-label"></i><span>Estatuaria en Piedra</span></div>
						<div class="elemento"><i class="icon-filled-label"></i><span>Cerámica</span></div>
						<div class="elemento"><i class="icon-filled-label"></i><span>Residuos Vegetales</span></div>
						<div class="elemento"><i class="icon-filled-label"></i><span>Residuos Óseos</span></div>
						<input type="hidden" name="categoria" value="" />
					</div>
				</div>
				<div class="content_button">
					<button class="button" type="submit">Aplicar</button>
				</div>
			</div>
		</div>
		<div id="contenido" class="contenido contenido_g">
			<div class="busqueda busqueda_g">
				<div class="vista">
					<span>Tipo de Vista:</span>
					<i class="icon-filled-galeria vista_grid active"></i>
					<i class="icon-filled-lista vista_lista"></i>
				</div>
				<div class="div_busqueda">
					<input type="text" name="busqueda" placeholder="Ingresar Busqueda..." value="<?php echo $busqueda ?>" />
					<i class="icon-filled-lupa" onclick="javascript:$('#lista_articulos').submit();"></i>
				</div>
			</div>
			<div class="productos_g">
				<?php 
				if ($array !== False){
					if ($array !== Null) {
						foreach ($array as $key => $row) {
							// $serial = serialize($row);
							// $serial = urlencode($serial); // echo $serial para pasarlo por get
							// $_SESSION['row'.$cont]= $row;
							$collect_id[]= $row->id_pieza;
							$fecha = to_fecha_str($row->fecha_pub);
						?>
						<div id="<?php echo $key?>" class="info_producto_g parent_me_elemento" id_data="<?php echo $row->id_pieza?>" url_data="c_eliminar_pieza">
							<div class="img">
								<?php
								$type = type_multimedia($row->preview);
								if ($type == 'image') { ?>
									<img src="<?php echo $row->preview?>" />
								<?php } else { ?>
									<video>
										<source src="<?php echo $row->preview?>" type="video/mp4">Your browser does not support HTML5 video
									</video>
								<?php } ?>
							</div>
							<div class="caracteristicas">
								<h2><?php echo ucfirst($row->titulo) ?></h2>
								<p class="fecha responsive_movil_off"><i class="icon-filled-calendario-b"></i>Publicado: <?php echo $fecha ?></p>
								<p class="fecha responsive_movil_on"><i class="icon-filled-calendario-b"></i><?php echo $fecha ?></p>
								<p class="categoria"><i class="icon-filled-label"></i>Categoria: <?php echo $row->categoria ?></p>
								<div class="detalles"><span>Ver Detalles </span><i class="icon-arrow-c"></i></div>
							</div>
							<?php if ($tipo_usuario === 'administrador'){ ?>
							<div class="menu_elemento">
								<div class="me_icon"><i class="icon-filled-ellipsis"></i></div>
								<div class="me_opciones">
									<span class="me_opcion me_eliminar"><i class="icon-filled-eliminar-b"></i>Eliminar</span>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php 
						}
					}else{
						include VIEWS.'templates/empty.php';
					}
				}else{
					include VIEWS.'templates/not_found.php';
				}
				?>
			</div>
			<?php 
			echo '<div class="responsive_movil_off flex_center">';
			$obj_pieza->mostrarPaginas(5).'</div>';
			echo '</div>';
			echo '<div class="responsive_movil_on flex_center">';
			$obj_pieza->mostrarPaginas(1);
			echo '</div>';
			?>
		</div>
		<div id="div_mod_eliminar"></div>
	</form>
	<?php 
		}else{
			echo '<div class="contenido">';
			include VIEWS.'templates/init_session.php';
			echo '</div>';
		} 
	?>
	</div>
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
// $bd->close();
?>