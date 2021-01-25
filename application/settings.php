<?php
	// header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
 //    header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
 //    header( "Cache-Control: no-cache, must-revalidate" );
 //    header( "Pragma: no-cache" );
	define('HOST','http://localhost/museo/');
	define('SERVER',$_SERVER['DOCUMENT_ROOT'].'/museo/');
	define('VIEWS',SERVER.'views/');
	define('STATIC',SERVER.'static/');
	define('MODELS',SERVER.'core/models/');
	define('LIBS',SERVER.'core/libs/');
	define('DATABASE',SERVER.'application/database/');
	define('MULTIMEDIA_S',SERVER.'static/multimedia/');
	define('IMG',HOST.'static/img/');
	define('JS',HOST.'static/js/');
	define('CSS',HOST.'static/css/');
	define('CONTROLLERS',HOST.'core/controllers/');
	define('MULTIMEDIA_H',HOST.'static/multimedia/');

	// Nombres Principales
	define('NOMBRE_APP','Museo');
	define('NOMBRE_MUNICIPIO','Arboleda');
	define('NOMBRE_CABECERA','Berruecos');

	// Menu Inicio
	$inicio = "";
	$actualidad = "";
	$visita = "";
	$aprende = "";
	$museo = "";
	$registro = "";
	$cuenta = "";

	//
	date_default_timezone_set('America/Bogota');
	$fecha_actual = date("Y-m-d H:i:s"); //se utiliza i en minutos porque m es para mes.
	$year_actual = date("Y");
	// var_dump($fecha_actual);
	$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

	//Funcion para convertir array en cadena sql separada de comas
	function to_datos_sql($array=[])
	{
		$str_sql = '';
		foreach ($array as $key => $value) {
			if ($key == 0) {
				if (is_int($value)) {
					$str_sql .= $value;
				}
				else{
					$str_sql .= '"'.$value.'"';
				}
			} else {
				if (is_int($value)) {
					$str_sql .= ','.$value;
				}else{
					$str_sql .= ',"'.$value.'"';
				}
			}
		}
		return $str_sql;
	}

	//Funcion para convertir fecha (yyyy-mm-dd hh:mm:ss) en string dia de mes de año.
	function to_fecha_str($fecha){
		global $months;
		$fecha = substr($fecha,0,10);
		$fecha = explode('-', $fecha);
		$yy = $fecha[0];
		$month = $fecha[1];
		$day = $fecha[2];
		// $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$fecha = $day.' de '.$months[$month-1].' de '.$yy;
		return $fecha;
	}

	//Funcion para convertir fecha (yyyy-mm-dd hh:mm:ss) en string HH:MM [a.m.,p.m.].
	function to_hora_str($fecha){
		$hora = substr($fecha,-9);
		$hora = explode(':', $hora);
		$hour = $hora[0];
		$min = $hora[1];
		$sec = $hora[2];
		$hour =(int) $hour;
		$format = ($hour >= 12)  ? " p.m." : " a.m.";
		$hour = ($hour > 12)  ? $hour-12 : $hour;
		$hour = ($hour == 0)  ? 12 : $hour;
		$hour = ($hour < 10)  ? "0".$hour : $hour;
		$hora = $hour.':'.$min.$format;
		// $fecha = date('h:i a', strtotime($fecha));
		// $fecha = str_replace('am', 'a.m.', $fecha);
		// $fecha = str_replace('pm', 'p.m.', $fecha);
		return $hora;
	}

	//Funcion para convertir fecha (yyyy-mm-dd hh:mm:ss) en string DD/MM/YYYY.
	function to_fecha_simp_str($fecha){
		$fecha = substr($fecha,0,10);
		$fecha = explode('-', $fecha);
		$yy = $fecha[0];
		$month = $fecha[1];
		$day = $fecha[2];
		// $months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
		// $fecha = $day.'/'.$months[$month-1].'/'.$yy;
		$fecha = $day.'/'.$month.'/'.$yy;
		return $fecha;
	}

	
	//Funcion para saber el tipo de archivo multimedia.
	function type_multimedia($url){
		$url = explode('/', $url);
		$nombre = end($url);
		$nombre = explode('.', $nombre);
		$extension = end($nombre);
		$extension = trim($extension);
		$extension = strtolower($extension);
		// echo $extension;
		if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
			$type = 'image';
		} else if ($extension == 'mp4' || $extension == 'ogg' || $extension == 'webm') {
			$type = 'video';
		} else if ($extension == 'mp3' || $extension == 'wav'){
			$type = 'audio';
		} else {
			$type = 'other';
		}
		return $type;
	}

	//Funcion para saber el tipo de archivo multimedia.
	function ext_multimedia($url){
		$url = explode('/', $url);
		$nombre = end($url);
		$nombre = explode('.', $nombre);
		$extension = end($nombre);
		$extension = trim($extension);
		$extension = strtolower($extension);
		return $extension;
	}

	//Funcion para saber si hay conexion a la base de datos.
	function ping($bd){
		if ($bd->ping()) {
		    printf ("¡La conexión está bien!\n");
		} else {
		    printf ("Error: %s\n", $bd->error);
		}
	}
	//

 ?>