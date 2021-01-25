<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require_once MODELS.'juego_vf.php';
session_start();
require_once LIBS.'verificar_general.php';

$estilos = ['estilos_inicio.css'];
require_once VIEWS.'templates/head.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$obj_juego_vf = new Juego_vf();
$array = $obj_juego_vf->detalles($id);
$row_principal = (is_array($array)) ? $array[0] : '';

$juegos = "active";
include VIEWS.'templates/header.php';

?>
<main>
	<div class="main" id="juego_vf" data_id="<?php echo $id ?>">
		<div class="contenido">
			<?php
			require_once LIBS.'verificar_sesion.php';
			$object = $array;
			require_once LIBS.'empty.php';
			if ($flag_empty === False){ 
			?>
			<div class="informacion">
				<h2 class="h2_informacion">Juego Verdadero o Falso (<?php echo $row_principal->titulo ?>)</h2>
				<div class="div_juego" id="div_juego">
					<?php foreach ($array as $key => $row){ ?>
					<section>
						<img src="<?php echo $row->url ?>" alt="">
						<p><?php echo $row->pregunta ?></p>
						<div class="juego_respuesta">
							<div class="respuesta">
								<img class="verdadero juego_vf" src="<?php echo IMG?>default/verdadero1.png" alt="">
							</div>
							<div class="respuesta">
								<img class="falso juego_vf" src="<?php echo IMG?>default/falso1.png" alt="">
							</div>
						</div>
						<div class="check_respuesta">
						</div>
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg">
						   <filter id="blur">
						       <feGaussianBlur stdDeviation="3" />
						   </filter>
						</svg>
					</section>
					<?php } ?>
					<div class="resultados_juego">
						<div class="main_jugar">
							<img class="main_jugar" src="<?php echo IMG?>default/jugar1.png" alt="" />
							<span class="sp_jugar juego_vf">RESULTADOS</span>
						</div>
						<p>Aciertos: <span></span></p>
						<div class="buttons_inline">
							<button onclick="window.location = '<?php echo HOST?>juego_verdadero_falso?id=<?php echo $id ?>'" class="button">Volver a Jugar</button>
							<button onclick="window.location = '<?php echo HOST?>lista_juegos'" class="button">Regresar al menu</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<?php } ?>
	</div>	
</main>
<?php
$scripts = ['juego_vf.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php';
?>