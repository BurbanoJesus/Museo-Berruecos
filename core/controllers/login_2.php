<?php 

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require './database/conexion.php';
	sleep(1);
	
	$bd = conectar();
	$bd->set_charset('utf8');
	$usuario = $bd->real_escape_string($_POST['usuario']);
	$pas = $bd->real_escape_string($_POST['password']);

if($nueva_consulta = $bd->prepare("SELECT * FROM usuarios WHERE nick_name = ? AND password = ? ")){
	$nueva_consulta -> bind_param('ss',$usuario,$pas);
	$nueva_consulta -> execute();
	$resultado = $nueva_consulta->get_result();


if($resultado->num_rows == 1){
	$datos =$resultado->fetch_assoc();
	session_start();
	$_SESSION['usuario'] = $datos;
	// var_dump($_SESSION['usuario']);
	echo json_encode(array('error' => false));
	}

else{
		echo json_encode(array('error' => true));
		}
	$nueva_consulta->close();
	}
}
// var_dump($resultado);
$bd->close();

 ?>