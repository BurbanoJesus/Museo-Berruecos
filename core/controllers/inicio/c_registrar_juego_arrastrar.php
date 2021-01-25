<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS.'validate.php';
require MODELS.'juego_arrastrar.php';
use Museo\Libs\Validate;

	$enunciado = $_POST['enunciado'];
	$respuesta = $_POST['respuesta'];
	$fecha = $_POST['fecha'];

	// Validate
	$view = 'agregar_juego';
	// $obj_validar = new Validate($view);
	// $obj_validar->validar_texto($titulo);
	// $fecha = $obj_validar->validar_fecha_actual($fecha);

	$obj_juego = new Juego_arrastrar();
	$insertar_mu = $obj_juego->insertar(Null,$enunciado,$respuesta);
	$url_redirect = HOST.'administrar_juego_arrastrar';
	$active = 'juegos';
	header("Location: ".HOST."inicio/success?&url_redirect=$url_redirect&active=$active");
	exit;
?>

