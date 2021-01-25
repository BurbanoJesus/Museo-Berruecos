<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS.'validate.php';
require MODELS.'juego_ahorcado.php';
use Plataforma\Libs\Validate;

	$id_juego = $_POST['id_juego'];
	$enunciado = $_POST['enunciado'];
	$respuesta = $_POST['respuesta'];
	$fecha = $_POST['fecha'];

	// Validate
	$view = 'agregar_juego';
	// $obj_validar = new Validate($view);
	// $obj_validar->validar_texto($titulo);
	// $fecha = $obj_validar->validar_fecha_actual($fecha);

	$obj_juego = new Juego_ahorcado();
	$insertar_mu = $obj_juego->actualizar($id_juego,$enunciado,$respuesta);
	$url_redirect = HOST.'administrar_juego_ahorcado';
	$active = 'juegos';
	$action = 'Actualizacion';
	header("Location: ".HOST."inicio/success?&url_redirect=$url_redirect&active=$active&action=$action");
	exit;
?>

