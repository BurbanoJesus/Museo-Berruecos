<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'usuario.php';
session_start();

include VIEWS.'templates/head.php';
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == ""){
	if (isset($_SERVER['HTTP_REFERER'])) {
		$_SESSION['url_redirect'] =  $_SERVER['HTTP_REFERER'];
	}else{
		if (!isset($_SESSION['url_redirect'])) {
			$_SESSION['url_redirect'] = HOST.'inicio';
		}
	}
	$url_redirect = $_SESSION['url_redirect'];
	if(isset($_GET['cod']) && isset($_GET['usuario'])){
		$codigo = $_GET['cod'];
		$usuario = $_GET['usuario'];
		$obj_inicio = new Usuario();
		$comprobar_codigo = $obj_inicio->comprobar_codigo($usuario,$codigo);
		if ($comprobar_codigo == True) {
			$obj_inicio->actualizar_estado($usuario);
		}
	}
?>
<main class="login">
	<div class="main">
		<div class="login">
			<form id="login" action="<?php echo CONTROLLERS?>c_login.php" method="POST">
				<div class="relieve"></div>
				<?php 
				if (isset($_GET['cod']) && isset($_GET['usuario'])) {
					if ($comprobar_codigo != False){ ?>
					<div class="cuenta_activada"><span>Su cuenta ha sido activada correctamente</span></div>
				<?php } else{ ?>
					<div class="cuenta_activada error_cuenta_activada"><span>Ha ocurrido un error</span></div>
				<?php } 
				}
				?>
				<div class="logo">
					<img src="<?php echo IMG?>logo_texto.png">
				</div>
				<!-- <i class="icon-perfil-login"></i> -->
				<div class="input_login">
					<input type="text" name="usuario" />
					<label for="">Usuario</label>
				</div>
				<div class="input_login password">
					<input type="password" name="password" />
					<label for="">Contraseña</label>
					<div class="icon_pass"><i class="icon-lineal-visible pass"></i></div>
				</div>
				<span class="sp_url_redirect" data="<?php echo $url_redirect ?>" style="display: none;"></span>
				<div class="error_login"></div>
				<button class="button pulse" type="submit" disabled>INICIAR SESIÓN</button>
				<div class="crear_cuenta">
					<a href="<?php echo HOST?>registrar_usuario" class="crear_cuenta">Crear una nueva cuenta</a>
					<a href="<?php echo HOST?>recuperar_password" class="crear_cuenta">Recuperar contraseña</a>
				</div>
			</form>
		</div>
	</div>
</main>
<?php }else{
	header("Location: ".HOST."inicio");
} 
?>
<?php 
$scripts = ['login.js'];
include VIEWS.'templates/foot.php'; 
?>