<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'juego_ahorcado.php';
session_start();

$obj_juego = new Juego_ahorcado();
$lista = $obj_juego->listar_load();
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($lista != false){
	echo json_encode(array('error' => false, 'lista' => $lista));
	}
else{
	echo json_encode(array('error' => true));
	}
 ?>