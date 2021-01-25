<?php
include_once $_SERVER['DOCUMENT_ROOT']."/museo/application/settings.php";
include_once LIBS."validate.php";
require MODELS.'publicacion.php';
use Museo\Libs\Validate;
	
	$id = uniqid('PB', true);
	$multimedia = 'MU_'.$id;
	$titulo = $_POST['titulo'];
	$descripcion = $_POST['descripcion'];
	$fecha = $_POST['fecha'];
	$files = $_FILES['images'];

	var_dump($files);

	// Validate
	$view = 'registrar_publicacion';

	$carpeta_destino = $servermultimedia."/publicaciones/";
	$carpeta_host = $hostmultimedia."/publicaciones/";


	$check_files = count($_FILES["images"]["name"]);
	$obj_publicacion = new Publicacion();
    $cont_existe_file = 1;
    if ($check_files > 1) {

    	for($i = 0; $i < count($files["name"]); $i++){
        // var_dump($files["name"][$i]);
		    if(strlen($files["name"][$i]) > 0 && strlen($files["tmp_name"][$i]) > 0){
		        if(file_exists($carpeta_destino)){
		            $name_archivo = $files["name"][$i];
		            $name_clear = pathinfo($name_archivo)['filename'];
		            $origen_archivo= $files["tmp_name"][$i];
		            $url_archivo= $carpeta_destino.$name_archivo;

		            $mime = $files["type"][$i];
	   				$type = type_source($mime);
	   				$extension = ext_source($mime);
	   				$size = round(($files["size"][$i] / 1000));
	   				$xf = 1920;
	   				$yf = 1080;
		            if ($type == 'image') {
		            	if ($i == 0) {
		            		$url_archivo_preview = $carpeta_destino.$name_clear.'_preview.'.$extension;
		            		$img_preview = optimizar_imagen($origen_archivo, $url_archivo_preview, 300, 300, $extension, Null, 90);
		    				$name_mult = optimizar_imagen($origen_archivo, $url_archivo, $xf, $yf, $extension, $size);
		            	}else{
		    				$name_mult = optimizar_imagen($origen_archivo, $url_archivo, $xf, $yf, $extension, $size);
		            	}
		            }else if($type == 'video') {
		            	if ($extension != 'mp4'){
		            		$name_clear = str_replace(' ', '_', $name_clear);
		            		$name_archivo = $name_clear.'.mp4';
		            		//
		            		$url_nuevo = $carpeta_destino.$name_archivo;
		            		$cmd = "ffmpeg -i ".SERVER."static\multimedia\publicaciones\PZ5edb44bad3a348.84982570\s.mp4 -an ".SERVER."static\multimedia\publicaciones\PZ5edb44bad3a348.84982570\s3.mp4 2>&1";
		            		echo $cmd."<br>";
		            		exec('unset DYLD_LIBRARY_PATH ;');
							putenv('DYLD_LIBRARY_PATH');
							putenv('DYLD_LIBRARY_PATH=/usr/bin');
		            		exec("ffmpeg", $output);
		            		exec($cmd, $output);
		            		var_dump($output);
		            		// 
							$name_mult = $name_archivo;
		            	}else{
					        $url_archivo = $carpeta_destino.$name_archivo;
		            		while(file_exists($url_archivo)){
		            			$name_archivo = $name_clear.'_'.$cont_existe_file.'.'.$extension;
					        	$url_archivo = $carpeta_destino.$name_archivo;
					        	$cont_existe_file++;
					        }
						    $flag_validar = (@move_uploaded_file($origen_archivo, $url_archivo)) ? True : False;
						    $name_mult = $name_archivo;
		            	}
	            		if ($i == 0) {
					        $img_preview = $name_archivo;
					    }
		            }

		            $preview = $carpeta_host.$img_preview;
		            $url_host = $carpeta_host.$name_mult;
		            $array = [Null,$multimedia,$url_host];
					$datos = to_datos_sql($array);
					$insertar_mu = $obj_publicacion->insertar_mu($datos);
		        }
		        else{
		            echo 'Error en Carpeta Archivo<br>';
		        }
		    }
		}
    } else {
    	$url_host = $img."default/default.png";
		$preview = $url_host;
    }
    
	$insertar = $obj_publicacion->insertar($id,$titulo,$descripcion,$preview,$fecha,$multimedia);
	header("Location: ".HOST."aprende");
	exit;
  
?>

