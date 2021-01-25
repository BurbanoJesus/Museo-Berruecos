<?php
namespace Museo\Libs;

class Validate
{
	private $reg_ip = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
	private $reg_tag_html = '/^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/';
	private $reg_url = '/^(http|https|ftp)+\:+\/\/+(www\.|)+[a-z0-9\-\.]+([a-z\.]|)+\.[a-z]{2,4}$/';
	private $reg_nombres = '/^[a-zA-Z ]{2,80}$/';
	private $reg_usuario = '/^[a-zA-Z0-9\_\-]{3,40}$/';
	private $reg_pass = '/^[a-zA-Z0-9\-\.\_\@]{4,25}$/';
	private $reg_numeros = '/^[0-9]{7,10}$/';
	private $reg_decimales = '/^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$/';
	private	$reg_correo = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
	private $view; 
	private	$msj;
	private	$flag;
	//

	function __construct($view, $get = ''){
		$this->view = $view;
		$this->host = HOST;
		$this->get = $get;
	}


	function validar_nombre($nombres){
	    if (!preg_match($this->reg_nombres, $nombres)){
		 	$this->msj = "Nombre no valido";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True;
	}

	function validar_usuario($usuario){
	    if (!preg_match($this->reg_usuario, $usuario)){
		 	$this->msj = "Usuario no valido";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True; 
	}

	function validar_texto($texto){
	    if (strlen($texto) <= 4){
		 	$this->msj = "Hay un error en el texto";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True; 
	}

	function validar_correo($email){
	    if (!preg_match($this->reg_correo, $email) || strlen($email) > 60){
		 	$this->msj = "Correo no valido";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True; 
	}

	function validar_pass_equal($pass_a,$pass_b){
	    if ($pass_a != $pass_b){
		 	$this->msj = "Las contraseñas no coinciden";
		 	$this->flag = False;
		 	return $this->validar();
		}else if (!preg_match($this->reg_pass, $pass_a)){
		 	$this->msj = "Contraseña no valida";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True;  
	}

	function validar_fecha_min($fecha,$fecha_min){
		$fecha = date('Y-m-d H:i:s',strtotime($fecha));
		$fecha_min = date('Y-m-d H:i:s',strtotime($fecha_min));
	    if ($fecha < $fecha_min){
		 	$this->msj = "Fecha no valida";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True;  
	}

	function validar_fecha_max($fecha,$fecha_max){
		$fecha = date('Y-m-d H:i:s',strtotime($fecha));
		$fecha_max = date('Y-m-d H:i:s',strtotime($fecha_max));
	    if ($fecha > $fecha_max){
		 	$this->msj = "Fecha no valida";
		 	$this->flag = False;
	    	return $this->validar();
		}
		return True;  
	}
	//
	//
	function validar_fecha_actual($fecha){
		$fecha_actual = date('Y-m-d H:i:s');
		$fecha_actual_next = date('Y-m-d H:i:s', strtotime($fecha_actual.'+2 hours'));
		$fecha_client = date('Y-m-d H:i:s', strtotime($fecha.'+1 hours'));
	    if ($fecha_client <= $fecha_actual || $fecha_client >= $fecha_actual_next){
		 	return $fecha_actual;
		}
		return $fecha;  
	}

	function randerizar_texto_sql($texto){
		// $replace = ["<",">","&",'"',"'"];
		// $find = ["&lt;","&gt;","&amp;","&quot;","&apos;"];
		// var_dump($texto);
		$texto = preg_replace('/&/mi', '&amp;', $texto);
		$texto = preg_replace('/</mi', '&lt;', $texto);
		$texto = preg_replace('/>/mi', '&gt;', $texto);
		$texto = preg_replace('/"/mi', '&quot;', $texto);
		$texto = preg_replace('/\'/mi', '&apos;', $texto);
		$texto = preg_replace('/update+\s*+[\S*]+\s+set/mi', '', $texto);
		$texto = preg_replace('/drop+\s*+table/mi', '', $texto);
		$texto = preg_replace('/drop+\s*+database/mi', '', $texto);
		return $texto;  
	}

	function validar()
	{
		if ($this->flag == False){
			$url = "$this->host$this->view?validate_msj=$this->msj$this->get";
			// echo $url;
			header("Location: $url");
			exit;
		}
		return True;
	}

	function validar_datos_db($flag,$msj)
	{
		if ($flag != False){
			$url = "$this->host$this->view?validate_msj=$msj$this->get";
			// echo $url;
			header("Location: $url");
			exit;
		}
		return True;
	}
}


	
 ?>