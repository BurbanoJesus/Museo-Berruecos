<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'juego_vf.php';
session_start();


$id_juego = $_POST['id'];

$obj_juego = new Juego_vf();
$eliminar = $obj_juego->eliminar($id_juego);
$eliminar_archivos = $obj_juego->eliminar_archivos($id_juego);

// $eliminar = True;

if($eliminar != False){
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
?>