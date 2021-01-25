<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'usuario.php';
require MODELS.'juego_ahorcado.php';
session_start();

$id_juego = (int) $_POST['id_juego'];

$obj_juego = new Juego_ahorcado();
$obj_usuario = new Usuario();
$row = $obj_juego->detalles($id_juego);


var_dump($id_juego);
var_dump($row);

$flag = ($id_juego == $row->id_juego) ? true: false;

// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($flag != false){
	$obj_usuario->actualizar_progreso_juegos('juego_ahorcado',$id_juego);
	echo json_encode(array('error' => false));
}
else{
	echo json_encode(array('error' => true));
	}
 ?>