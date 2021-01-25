<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS."helper.php";
include_once LIBS."validate.php";
require MODELS.'usuario.php';

use Museo\Libs\Helper;
use Museo\Libs\Validate;

	//
	$correo = $_POST['correo'];
	// Validate
	$view = 'email_active';
	$obj_validar = new Validate($view);
	$obj_validar->validar_correo($correo);
	$fecha = $obj_validar->validar_fecha_actual($fecha);
	$correo = $obj_validar->randerizar_texto_sql($correo);

	$obj_usuario = new Usuario();
	$row_usuario = $obj_usuario->usuario_por_email($correo,'email active');

	if ($row_usuario != False) {
		$codigo = $obj_usuario->createRandomCode();
		$fecha_codigo = date('Y-m-d H:i:s', strtotime($fecha_actual.'+24 hours'));
		$usuario = $row_usuario->usuario;
		$nombres = $row_usuario->nombres;
		$actualizar = $obj_usuario->actualizar_codigo($usuario,$codigo,$fecha_codigo);
	    if ($actualizar == True) {
	    	$template = file_get_contents(SERVER.'views/templates/template_email_active.php');
	    	$template = str_replace("{{host}}", HOST, $template);
	        $template = str_replace("{{name}}", $nombres, $template);
	        $template = str_replace("{{action_url_2}}", '<b>'.HOST.'login?cod='.$codigo.'&usuario='.$usuario.'</b>', $template);
	        $template = str_replace("{{action_url_1}}", HOST.'login?cod='.$codigo.'&usuario='.$usuario, $template);
	        $template = str_replace("{{year}}", date('Y'), $template);
	        $template = str_replace("{{operating_system}}", Helper::getOS(), $template);
	        $template = str_replace("{{browser_name}}", Helper::getBrowser(), $template);
	        $subject = 'Activar Cuenta Museo';
	    	$email = $obj_usuario->enviar_email($correo,$nombres,$template,$subject);
	    }
	}

	$msj = 'Se ha enviado un correo electronico a su bandeja de entrada.';
	header("Location: ".HOST."email_active?&msj=$msj");
	exit;
  
?>

