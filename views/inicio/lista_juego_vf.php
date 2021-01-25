<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'juego_vf.php';
session_start();

$estilos = ['estilos_inicio.css'];
require_once VIEWS.'templates/head.php';

$obj_juegos_vf = new Juego_vf();
$array = $obj_juegos_vf->listar_all();

$juegos = "active";
include VIEWS.'templates/header.php';

?>
<main>
	<div class="main">
		<div class="contenido" id="aprende">
			<?php
			require_once LIBS.'verificar_sesion.php';
			$object = $array;
			require_once LIBS.'empty.php';
			if ($flag_empty === False){ 
			?>
			<div class="informacion">
				<h2 class="">Juego Verdadero o Falso</h2>
				<div class="lista_juegos">
					<?php foreach ($array as $key => $row) { ?>
					<div class="elemento_juego" onclick="javascript:window.location = '<?php echo HOST?>juego_verdadero_falso?id=<?php echo $row->id_juego_vf?>'">
						<span class="nombre_juego"><?php echo ($key+1) .'. Tema: '.$row->titulo ?></span>
						<div class="div_main_jugar">
							<div class="main_jugar">
								<img class="main_jugar" src="<?php echo IMG?>default/jugar1.png" alt="" />
								<span class="sp_jugar">JUGAR!</span>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>	
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>