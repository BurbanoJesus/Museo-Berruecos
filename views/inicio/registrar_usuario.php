<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'municipio.php';
session_start();

$estilos = ['estilos_inicio.css','jquery.Jcrop.min.css'];
require VIEWS.'templates/head.php';
$cuenta = "active";
include VIEWS.'templates/header.php';

// unset($_SESSION['url_redirect']);
// $_SESSION['url_redirect'] = 'http://localhost/museo/registrar_usuario';


if (isset($_SESSION['url_redirect'])) {
	$url_redirect = $_SESSION['url_redirect'];
}else{
	if (!isset($_GET['url_redirect'])) {
		$url_redirect = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$url_redirect = ($url_redirect === '') ? $host.'/inicio' : $url_redirect;
		$_SESSION['url_redirect'] = $url_redirect;
	}else{
		$url_redirect = $_GET['url_redirect'];
	}
}

$obj_municipio = new Municipio();
$array_municipio = $obj_municipio->listar();

?>

<main>
	<div class="main">
		<div class="contenido">
			<form id="registrar_usuario" class="form" method="POST" action="<?php echo CONTROLLERS?>inicio/c_registrar_usuario.php" enctype="multipart/form-data">
				<h2>Registrar Usuario</h2>
				<div class="input s100">
					<h3>Nombres</h3>
					<div class="contenido_input"><input class="input input_text" type="text" name="nombres"  placeholder="Ingresar Nombres..." /></div>
				</div>
				<div class="input s100">
					<h3>Lugar de residencia (Municipio)</h3>
					<div class="select" id="lugar" data="">
							<div class="head_select">
								<span class="nombre_select">Seleccione Municipio</span>
								<i class="icon-arrow"></i>
							</div>
							<div class="opciones">
								<?php foreach ($array_municipio as $key => $row) { ?>
									<div class="opcion"><i class="icon-filled-ubicacion"></i><span><?php echo ucwords($row->municipio)?></span></div>
								<?php } ?>
							</div>
							<input type="hidden" name="lugar" value="" />
						</div>
				</div>
				<div class="input s100">
					<h3>Numero de identificación</h3>
					<div class="contenido_input"><input class="input input_text" type="text" name="num_id"  placeholder="Ingresar Número de identificación..." /></div>
				</div>
				<!-- <div><img id="s1" src="<?php echo IMG?>default/default.jpg" alt="" width=200 style="" /></div> -->
				
				<div class="input s100">
					<h3>Elegir un nombre de usuario</h3>
					<div class="contenido_input"><input class="input input_usuario" type="text" name="usuario"  placeholder="Ingresar Usuario..." /></div>
				</div>
				<div class="input s100">
					<h3>Correo Electrónico</h3>
					<div class="contenido_input"><input class="input input_correo" type="text" name="correo"  placeholder="Ingresar Correo..." /></div>
				</div>
				<div class="input s100">
					<h3>Crear Contraseña</h3>
					<div class="contenido_input">
						<input class="input input_pass pass_equal" type="password" name="password"  placeholder="Ingresar Contraseña..." />
						<div class="icon_pass"><i class="icon-lineal-visible pass"></i></div>
					</div>
				</div>
				<div class="input s100">
					<h3>Repetir Contraseña</h3>
					<div class="contenido_input">
						<input class="input input_pass pass_equal" type="password" name="password_b"  placeholder="Repetir Contraseña..." />
						<div class="icon_pass"><i class="icon-lineal-visible pass"></i></div>
					</div>
				</div>
				<div class="input s100">
					<h3 class="text_center">Agregar foto de perfil.</h3>
					<div class="contenido_input">
						<div id="contenido_img" class="contenido_img perfil">
							<div id="loading_inf_1" class="loading_inf"><img src="<?php echo IMG?>loading/loading3.gif" alt=""></div>
							<div class="agregar_mult perfil">
					        	<input class="input_file_one input_preview input_jcrop" id="input_file_1" name="images" type="file" accept="image/*" required />
					            <!-- accept="image/*" or accept="image/jpeg,image/png" -->
					            <label class="label_icon icon-filled-add-multimedia" for="input_file_1"></label>
								<div class="div_button"><label class="button" for="input_file_1">Agregar</label></div>
					        </div>
						</div>
					</div>
					<input type="hidden" name="x" value="" />
					<input type="hidden" name="y" value="" />
					<input type="hidden" name="w" value="" />
					<input type="hidden" name="h" value="" />
					<input type="hidden" name="w_jcrop" value="500" />
				</div>
				<input type="hidden" name="fecha" value="" />
				<input type="hidden" name="url" value="<?php echo $url_redirect ?>" />
				<?php if (isset($_GET['validate_msj'])) {
					echo '<div class="input s100"><div class="validate_msj">'.$_GET['validate_msj'].'</div></div>';
				} ?>
				<div class="content_button next">
					<button type="submit" class="button"><i class="icon-filled-check"></i>Registrar</button>
				</div>
			</form>
		</div>
	</div>
</main>

<?php 
$scripts = ['jquery.Jcrop.min.js','jrecortar_perfil_b.js'];
include VIEWS.'templates/footer.php';
include VIEWS.'templates/foot.php'; 
?>