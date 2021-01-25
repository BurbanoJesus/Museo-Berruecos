<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'usuario.php';
// require MODELS.'juego_vf.php';
session_start();

$id_juego = $_POST['id_juego'];
// $obj_juego = new Juego_vf();
// $lista = $obj_juego->detalles($id_juego);

$obj_usuario = new Usuario();
$flag = $obj_usuario->actualizar_progreso('juego_vf',$id_juego);

// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($flag != false){
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
 ?>