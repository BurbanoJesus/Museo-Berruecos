<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
require MODELS.'usuario.php';
	// sleep(1);
	// $bd->set_charset('utf8');
	$usuario = $_POST['usuario'];
	$pass = $_POST['password'];

$obj_user = new Usuario();
$login = $obj_user->login($usuario,$pass);
// echo "SELECT * FROM usuarios WHERE nick_name = $usuario AND password = $pass";
if($login != false){
	session_start();
	$_SESSION['usuario'] = $login;
	echo json_encode(array('error' => false));
	}
else{
	echo json_encode(array('error' => true));
	}
?>