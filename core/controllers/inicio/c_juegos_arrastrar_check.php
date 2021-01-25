<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'usuario.php';
require MODELS.'juego_arrastrar.php';
session_start();

$datos_respuestas = json_decode($_POST['datos']);

$obj_juego = new Juego_arrastrar();
$obj_usuario = new Usuario();
$lista = $obj_juego->listar_load();
$cont = 0;
foreach ($lista as $key => $value) {
	if ($value->respuesta == $datos_respuestas[$key]){
		$cont++;
	}
}

$flag = ($cont == count($lista)) ? true: false;
// var_dump($lista);

// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($flag != false){
	foreach ($lista as $key => $value) {
		$obj_usuario->actualizar_progreso_juegos('juego_arrastrar',$value->id_juego);
	}
	echo json_encode(array('error' => false, 'correctas' => $cont));
}
else{
	echo json_encode(array('error' => true, 'correctas' => $cont));
	}
 ?>