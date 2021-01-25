<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS."validate.php";
require MODELS.'usuario.php';
use Museo\Libs\Validate;
session_start();

	$usuario = $_SESSION['usuario_rec_pass'];
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$password_b = $_POST['password_b'];
	$fecha = $_POST['fecha'];
	// 
	$url = (isset($_SESSION['url_redirect'])) ? $_SESSION['url_redirect'] : $host.'/inicio';

	// Validate
	$view = 'nuevo_password';
	$obj_validar = new Validate($view);
	$obj_validar->validar_usuario($usuario);
	$obj_validar->validar_pass_equal($password,$password_b);
	$fecha = $obj_validar->validar_fecha_actual($fecha);
	$usuario = $obj_validar->randerizar_texto_sql($usuario);


	$obj_usuario = new Usuario();
	$actualizar_pass = $obj_usuario->actualizar_pass($usuario,$password);

	$url_redirect = $url;
	$action = 'Actualizacion';
	header("Location: ".HOST."inicio/success?&url_redirect=$url_redirect&action=$action");
	exit;
  
?>

