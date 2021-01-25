<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
session_start();

include VIEWS.'templates/head.php';
$active = (isset($_GET['active'])) ? $_GET['active'] : '';
$url_redirect = (isset($_GET['url_redirect'])) ? $_GET['url_redirect'] : HOST.'inicio';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';

switch (True) {
	case ($action == 'Actualizacion'):
		$str_action = 'Actualización Exitosa';
		break;

	case ($action == 'Enviado'):
		$str_action = 'Enviado Correctamente';
		break;
	
	default:
		$str_action = 'Registro Exitoso';
		break;
}

$titulo = (isset($_GET['titulo'])) ? $_GET['titulo'] : '';
${$active} = 'active';
include VIEWS.'templates/header.php';
?>

<main>
	<div class="main">
		<div class="contenido">
			<form class="form" action="" id="success">
				<div class="success">
					<i class="icon-lineal-check"></i>
					<span><?php echo $str_action?></span>
					<?php 
						if (strlen($titulo) > 0 ) {
							echo '<p class="success_p">'.$titulo.'</p>';
						}
					?>
					<div class="content_button next">
						<button onclick="javascript:window.location ='<?php echo $url_redirect?>'" type="button" class="button">Aceptar</button>
					</div>
				</div>
				<!-- <div class="error">
					<i class="icon-filled-no-check"></i>
					<span>Ha Ocurrido Un Error Intentelo de Nuevo</span>
					<div class="content_button next">
						<button type="submit" class="button">Aceptar</button>
					</div>
				</div> -->
			</form>
		</div>
	</div>
</main>
<?php 
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>