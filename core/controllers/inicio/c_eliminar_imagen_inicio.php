<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'/inicio.php';
	// sleep(1);
	// $bd->set_charset('utf8');
	$url = $_POST['id'];

$obj_inicio = new Inicio();
$eliminar = $obj_inicio->eliminar($url);
$eliminar_archivo = $obj_inicio->eliminar_archivo($url);
$eliminar = true;
$eliminar_archivo = true;

if($eliminar != false && $eliminar_archivo != false){
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
?>