<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'juego_vf.php';

$id_juego = $_POST['id_juego'];

$obj_juego = new Juego_vf();
$lista = $obj_juego->detalles($id_juego);
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($lista != false){
	echo json_encode(array('error' => false, 'lista' => $lista));
	}
else{
	echo json_encode(array('error' => true));
	}
 ?>