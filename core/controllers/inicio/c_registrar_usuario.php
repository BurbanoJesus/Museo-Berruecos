<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS."helper.php";
include_once LIBS."validate.php";
include_once LIBS."gd_imagen.php";
require MODELS.'usuario.php';

use Museo\Libs\Helper;
use Museo\Libs\Validate;

	$carpeta_usuario = uniqid('US', true);
	$nombres = $_POST['nombres'];
	$lugar = $_POST['lugar'];
	$num_id = $_POST['num_id'];
	$correo = $_POST['correo'];
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	$password_b = $_POST['password_b'];
	$tipo_usuario = 'general';
	$fecha = $_POST['fecha'];
	$files = $_FILES['images'];
	$post_x = $_POST['x'];
	$post_y = $_POST['y'];
	$post_w = $_POST['w'];
	$post_h = $_POST['h'];
	$post_w_jcrop = $_POST['w_jcrop'];
	// 
	$url = $_POST['url'];
	//
	$carpeta_destino = MULTIMEDIA_S."usuarios/".$carpeta_usuario."/";
	$carpeta_host = MULTIMEDIA_H."usuarios/".$carpeta_usuario."/";

    if(!file_exists($carpeta_destino)){
	    $flag_validar = (@mkdir($carpeta_destino)) ? True : False; 
	    // if(@mkdir($carpeta_destino)) echo "si"; //para comprobar si se creo la carpeta.

		$obj_usuario = new Usuario();
		
		$name_archivo = $files["name"];
        $name_clear = pathinfo($name_archivo)['filename'];
        $origen_archivo= $files["tmp_name"];
        $url_archivo= $carpeta_destino.$name_archivo;

        $mime = $files["type"];
		$type = type_source($mime);
		$extension = ext_source($mime);
		$size = round(($files["size"] / 1000));
		$xf = 128;
		$yf = 128;
		$jcrop_x = $post_w_jcrop;
		$quality = 90;
        if ($type == 'image') {
			$name_mult = recortar_imagen($origen_archivo,$url_archivo,$xf,$yf,$post_x,$post_y,$post_w,$post_h,$jcrop_x,$extension, Null, 90);
			$xf = 1920;
			$yf = 1080;
			$preview = optimizar_imagen($origen_archivo,$url_archivo,$xf,$yf,$extension, Null, 90);
        }

        $img_preview = $carpeta_host.$preview;
        $img_usuario = $carpeta_host.$name_mult;

	}else{
		header("Location: ".HOST."$view?validate_msj=Ha ocurrido un error, intentelo nuevamente");
		exit;
	}

	$view = 'registrar_usuario';
	$obj_validar = new Validate($view);
	$obj_usuario = new Usuario();
	// VALIDAR SI EXISTEN EL USUARIO O CORREO.
	$existe_usuario = $obj_usuario->flag_usuario_nickname($usuario);
	// var_dump($existe_usuario);
	// echo '<br>';
	$obj_validar->validar_datos_db($existe_usuario,'El usuario ya existe');
	$existe_usuario = $obj_usuario->flag_usuario_email($correo);
	$obj_validar->validar_datos_db($existe_usuario,'El correo ya se ha registrado anteriormente');

	
	$password = password_hash($password, PASSWORD_BCRYPT);
	//DEFINIR LOS PARAMETROS QUE FALTAN Y HACER LA INSERCION EN LA BD
	$codigo = $obj_usuario->createRandomCode();
	$fecha_codigo = date('Y-m-d H:i:s', strtotime($fecha.'+24 hours'));
	$insertar = $obj_usuario->insertar($correo,$nombres,$usuario,$password,$tipo_usuario,$lugar,$img_preview,$img_usuario,$codigo,$fecha_codigo,$carpeta_usuario,$fecha);
    if ($insertar == True){
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
    else{
    	header("Location: ".HOST."registrar_usuario?url_redirect=$url_redirect&validate_msj=Ha ocurrido un error insertar, intentelo nuevamente");
		exit;
    }

	$url_redirect = $url;
	$active = 'cuenta';
	$titulo = 'Se envió un correo electronico de confirmación, revise la bandeja de entrada de su correo para completar la activación de su cuenta. <a href="'.HOST.'email_active">Volver a enviar correo de activación</a>';
	header("Location: ".HOST."inicio/success?&url_redirect=$url_redirect&active=$active&titulo=$titulo");
	exit;
  
?>

