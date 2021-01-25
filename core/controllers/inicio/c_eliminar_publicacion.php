<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'/publicacion.php';
	// sleep(1);
	// $bd->set_charset('utf8');
	$id = $_POST['id'];

$obj_publicacion = new Publicacion();
$eliminar = $obj_publicacion->eliminar($id);
$eliminar_archivos = $obj_publicacion->eliminar_archivos($id);
// $eliminar = $obj_publicacion->eliminar($id);
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($eliminar != false && $eliminar_archivos != false){
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
?>