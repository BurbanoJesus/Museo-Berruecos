<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';

require SERVER.'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

Class Usuario extends Db{

	public function __construct(){
		parent::__construct();
	}

	function insertar($correo,$nombres,$usuario,$password,$tipo_usuario,$lugar,$img_preview,$img_usuario,$codigo,$fecha_codigo,$carpeta_usuario,$fecha){
		$sql = "INSERT INTO usuarios VALUES(:correo,:nombres,:usuario,:password,:tipo_usuario,:lugar,:img_preview,:img_usuario,:codigo,:fecha_codigo,:carpeta_usuario,:estado_juego_vf,:estado_juego_ahorcado,:estado_juego_arrastrar,:estado,:fecha)";
		$query = $this->db->prepare($sql);
		$query->execute(['correo' => $correo, 'nombres' => $nombres, 'usuario' => $usuario, 'password' => $password, 'tipo_usuario' => $tipo_usuario, 'lugar' => $lugar, 'img_preview' => $img_preview, 'img_usuario' => $img_usuario, 'codigo' => $codigo, 'fecha_codigo' => $fecha_codigo, 'carpeta_usuario' => $carpeta_usuario, 'estado_juego_vf' => 'D', 'estado_juego_ahorcado' => 'D', 'estado_juego_arrastrar' => 'D', 'estado' => 'D', 'fecha' => $fecha]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function listar(){
		$sql = "SELECT * FROM usuarios";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute();
		// 
		$collect = Null;
		while($row = $query->fetchObject()){
			if ($row == False) return False;
		    $collect[] = $row;
		}
		return $collect;
	}

	function login($usuario,$pass){
		$sql = "SELECT * FROM usuarios WHERE usuario = :usuario OR correo = :correo LIMIT 1";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['usuario' => $usuario, 'correo' => $usuario]);
		$row = $query->fetchObject();
		if ($row == False) return False;
		if (password_verify($pass, $row->password) === False) return False;
		if ($row->estado == 'D') return False;
		return $row;
	}

	function usuario_por_email($correo,$email_active = 0){
		$sql = "SELECT correo,estado,nombres,usuario FROM usuarios WHERE correo = :correo LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(['correo' => $correo]);
		$row = $query->fetchObject();
		if ($row == False) return False;
		if ($email_active === 0) {
			if ($row->estado == 'D') return False;
		}
		return $row;
	}

	function usuario_por_nickname($usuario){
		$sql = "SELECT usuario,estado FROM usuarios WHERE usuario = :usuario LIMIT 1";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['usuario' => $usuario]);
		$row = $query->fetchObject();
		if ($row == False) return False;
		if ($row->estado == 'D') return False;
		return $row;
	}

	function usuario_por_nickname_all($usuario){
		$sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['usuario' => $usuario]);
		$row = $query->fetchObject();
		if ($row == False) return False;
		if ($row->estado == 'D') return False;
		return $row;
	}

	function flag_usuario_email($correo){
		$sql = "SELECT correo,estado FROM usuarios WHERE correo = :correo LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(['correo' => $correo]);
		if ($query->rowCount() == 0) return False;
		return True;
	}

	function flag_usuario_nickname($usuario){
		$sql = "SELECT usuario,estado FROM usuarios WHERE usuario = :usuario LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(['usuario' => $usuario]);
		if ($query->rowCount() == 0) return False;
		return True;
	}

	function comprobar_codigo($usuario,$codigo){
		$sql = "SELECT usuario,codigo,fecha_codigo FROM usuarios WHERE usuario= BINARY :usuario LIMIT 1";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['usuario' => $usuario]);
		$row = $query->fetchObject();
		if ($row == False) return False;
		$fecha_actual = date("Y-m-d H:i:s");
		if ($codigo != $row->codigo) return False;
		if (strtotime($fecha_actual) > strtotime($row->fecha_codigo)) return False;
		return $row;
	}

	function actualizar_estado($usuario){
		$sql = "UPDATE usuarios SET estado= :estado WHERE usuario = :usuario";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['estado' => 'A', 'usuario' => $usuario]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function actualizar_codigo($usuario,$codigo,$fecha_codigo){
		$sql = "UPDATE usuarios SET codigo= :codigo, fecha_codigo= :fecha_codigo WHERE usuario = :usuario";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['codigo' => $codigo, 'fecha_codigo' => $fecha_codigo, 'usuario' => $usuario]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function actualizar_pass($usuario,$password){
		$sql = "UPDATE usuarios SET password= BINARY :password WHERE usuario = :usuario";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['password' => $password, 'usuario' => $usuario]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function enviar_email($correoElectronico, $nombre, $template, $subject)
    {	
    	$mail = new PHPMailer;
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// SMTP::DEBUG_OFF = off (for production use)
		// SMTP::DEBUG_CLIENT = client messages
		// SMTP::DEBUG_SERVER = client and server messages
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->Host = 'smtp.gmail.com';
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = 'museoberruecos@gmail.com';
		$mail->Password = '@mube2020';

		$mail->setFrom('museoberruecos@gmail.com', 'Museo Arqueologico Berruecos');
		$mail->addAddress($correoElectronico, $nombre);
		$mail->Subject = $subject;
		$mail->msgHTML($template);
		if (!$mail->send()) {
		    // echo 'Mailer Error: '. $mail->ErrorInfo;
		} else {
		    // echo 'Message sent!';
		}
    }

    function actualizar_progreso($nombre_juego,$id_juego)
    {
    	$sql = "INSERT INTO JUEGOS_PROGRESO VALUES(Null,:nombre_juego,:estado,:id_juego,:usuario)";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['nombre_juego' => $nombre_juego, 'estado' => 'A', 'id_juego' => $id_juego, 'usuario' => $_SESSION['usuario']->usuario]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
    }

    function actualizar_progreso_juegos($nombre_juego)
    {	
    	switch ($nombre_juego) {
    		case 'juego_vf':
    			$str_tb_juego = 'JUEGOS_VF';
    			$str_estado_juego = 'estado_juego_vf';
    			break;
    		
    		case 'juego_ahorcado':
    			$str_tb_juego = 'JUEGOS_AHORCADO';
    			$str_estado_juego = 'estado_juego_ahorcado';
    			break;

    		case 'juego_arrastrar':
    			$str_tb_juego = 'JUEGOS_ARRASTRAR';
    			$str_estado_juego = 'estado_juego_arrastrar';
    			break;

    		default:
    			# code...
    			break;
    	}
    	$sql_count = "SELECT COUNT(*) AS total FROM $str_tb_juego";
    	$query_count = $this->db->prepare($sql_count);
		$query_count->execute();
		$count = $query_count->fetchObject()->total;
		$row = $query_count->rowCount();
		if ($row == 0) return False;

    	$sql = "SELECT COUNT(*) AS total FROM JUEGOS_PROGRESO WHERE nombre_juego = :nombre_juego AND usuario = :usuario";
		$query = $this->db->prepare($sql);
		$query->execute(['nombre_juego' => $nombre_juego, 'usuario' => $_SESSION['usuario']->usuario]);
		$count_2 = $query->fetchObject()->total;
		$row = $query->rowCount();
		if ($row == 0) return False;

		if ($count == $count_2){
			$sql = "UPDATE usuarios SET $str_estado_juego = :estado WHERE usuario = :usuario";
			$query = $this->db->prepare($sql);
			$query->execute(['estado' => 'A', 'usuario' => $_SESSION['usuario']->usuario]);
			$_SESSION['usuario']->$str_estado_juego = 'A';
		}

		return True;
    }

    function createRandomCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
    
        return time().$pass;
    }

	function __destruct(){
	}

}

?>