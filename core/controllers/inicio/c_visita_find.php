<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'/lugar.php';

$id_lugar= $_POST['id_lugar'];
$obj_user = new Lugar();
$row = $obj_user->detalles($id_lugar);
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
// var_dump($lista);
if($row != false){
	echo json_encode(array('error' => false,'row' => $row));
	}
else{
	echo json_encode(array('error' => true));
	}
 ?>