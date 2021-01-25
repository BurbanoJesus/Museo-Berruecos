<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'/pieza.php';
	// sleep(1);
	// $bd->set_charset('utf8');
	$id = $_POST['id'];

$obj_pieza = new Pieza();
$eliminar = $obj_pieza->eliminar($id);
$eliminar_archivos = $obj_pieza->eliminar_archivos($id);
// $eliminar = $obj_pieza->eliminar($id);
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($eliminar != false && $eliminar_archivos != false){
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
?>