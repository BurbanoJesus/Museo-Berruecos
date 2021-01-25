<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS.'validate.php';
include_once LIBS."gd_imagen.php";
require MODELS.'juego_vf.php';
use Museo\Libs\Validate;

	$id = uniqid('JG', true);
	$preguntas = 'PG_'.$id;
	$titulo = $_POST['titulo'];
	$fecha = $_POST['fecha'];
	
	// Validate
	$view = 'registrar_juego_vf';
	$obj_validar = new Validate($view);
	// $obj_validar->validar_texto($titulo);
	// $fecha = $obj_validar->validar_fecha_actual($fecha);


	$carpeta_destino = MULTIMEDIA_S."juegos_vf/".$id."/";
	$carpeta_host = MULTIMEDIA_H."juegos_vf/".$id."/";

	if(!file_exists($carpeta_destino)){
	    $flag_validar = (@mkdir($carpeta_destino)) ? True : False; 
	    // if(@mkdir($carpeta_destino)) echo "si"; //para comprobar si se creo la carpeta.

		$obj_juego_vf = new juego_vf();

		$cont = 1;
		while(isset($_POST['pregunta_'.$cont])){
			$pregunta = $_POST['pregunta_'.$cont];
			$respuesta = $_POST['respuesta_'.$cont];
			$files = $_FILES['image_'.$cont];
		    if(strlen($files["name"]) > 0 && strlen($files["tmp_name"]) > 0){
	            $explode_name = explode(".",$files["name"]);
	            $name_clear = $explode_name[0];
	            $extension = '.'.$explode_name[1];
	            $origen_archivo= $files["tmp_name"];
	            $name_archivo = $files["name"];
	            // $url_archivo= $carpeta_destino.sha1(uniqid($name_archivo)).".".$extension;
	            $url_archivo= $carpeta_destino.$name_archivo;
	            $mime = $files["type"];
   				$type = type_source($mime);
   				$extension = ext_source($mime);
   				$size = round(($files["size"] / 1000));
   				$xf = 1920;
   				$yf = 1080;
	            if ($type == 'image') {
	    			$name_mult = optimizar_imagen($origen_archivo, $url_archivo, $xf, $yf, $extension, $size);
	            }
	            $url_host = $carpeta_host.$name_mult;
	            $str_pregunta = $pregunta;
	            $str_respuesta = $respuesta;

				$insertar_mu = $obj_juego_vf->insertar_pg(Null,$preguntas,$str_pregunta,$str_respuesta,$url_host);
		    }else{
		    	$flag_validar = False;
		    }
			$cont++;
		}
	}else{
		header("Location: ".HOST."$view?validate_msj=Ha ocurrido un error, intentelo nuevamente");
		exit;
	}

	$insertar = $obj_juego_vf->insertar($id,$titulo,$fecha,$preguntas);
    
	$url_redirect = HOST.'lista_juego_vf';
	$active = 'juegos';
	header("Location: ".HOST."inicio/success?&url_redirect=$url_redirect&active=$active");
	exit;
?>

