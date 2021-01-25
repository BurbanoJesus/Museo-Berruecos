<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS."validate.php";
use Museo\Libs\Validate;

	$categoria = $_POST['categoria'];
	$busqueda = $_POST['busqueda'];

	// Validate
	$view = 'lista_piezas';
	$obj_validar = new Validate($view);

	$fecha = $obj_validar->validar_fecha_actual($fecha);
	$busqueda = $obj_validar->randerizar_texto_sql($busqueda);
	
  	
  	$categoria_lenght = strlen($categoria);
  	$busqueda_lenght = strlen($busqueda);

	// $listar = $obj_publicacion->listar($categoria,$vereda_barrio,$busqueda);
    
    $filtros = "";
    ($categoria_lenght > 0 || $busqueda_lenght > 0) ? $filtros .= "?" : true;
    ($categoria_lenght > 0) ? $filtros .= "categoria=$categoria&" : true;
    ($busqueda_lenght > 0) ? $filtros .= "busqueda=$busqueda&" : true;

    $filtros = substr($filtros, 0,-1);

	header("Location: ".HOST."/lista_piezas$filtros");
	exit;
?>