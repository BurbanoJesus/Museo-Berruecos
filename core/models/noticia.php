<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Noticia extends Db{

	public function __construct(){
		parent::__construct();
	}

	function insertar($id,$titulo,$descripcion,$preview,$fecha){
		$sql = "INSERT INTO noticias VALUES(:id,:titulo,:descripcion,:preview,:fecha)";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'titulo' => $titulo, 'descripcion' => $descripcion, 'preview' => $preview, 'fecha' => $fecha]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function listar(){
		$sql = "SELECT * FROM noticias ORDER BY fecha DESC LIMIT 5";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute();
			
		$collect = Null;
		
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function listar_admin(){
		$sql = "SELECT * FROM noticias ORDER BY fecha DESC";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute();
		
		$collect = Null;

		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function ultimo_registro(){
		$sql = "SELECT id_noticia FROM noticias ORDER BY id_noticia DESC LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute();
		$row = $query->rowCount();
		if ($row == 0) return False;
		$row =  $query->fetchObject();
		return $row;
	}

	function detalles($id){
		$sql = "SELECT * FROM NOTICIAS NATURAL JOIN multimedia_noticias WHERE id_noticia = :id";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
		echo($query->rowCount());

		if ($query->rowCount() == 0){
			$sql = "SELECT * FROM noticias WHERE id_noticia = :id";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id]);
		}

		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function insertar_mu($id,$multimedia,$url_host){
		$sql = "INSERT INTO multimedia_noticias VALUES(:id, :multimedia, :url_host)";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'multimedia' => $multimedia, 'url_host' => $url_host]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function actualizar_img($id,$str_preview){
		try{
			$sql = "UPDATE noticias SET 
			foto_principal = :str_preview
			WHERE id_noticia = :id";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id, 'str_preview' => $str_preview]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Actualizar - Noticia Img';
			$this->debug($error,$tipo);
		}
	}

	function eliminar($id){
		$sql = "DELETE FROM noticias WHERE id_noticia = :id";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
		if ($query->rowCount() == 0 ) return False;
		return True;
	}

	function eliminar_archivos($id){
		// $id = 'NT5eeacf73e065b3.04209314';
		$carpeta_server =  SERVER."static/multimedia/noticias/$id/";
		$sel_archivos =  SERVER."static/multimedia/noticias/$id/*";
		$files = glob($sel_archivos);
		if (file_exists($carpeta_server)) {
			foreach($files as $file){
			    if(is_file($file))
			    unlink($file);
			}
			rmdir($carpeta_server);
		}else{
			return False;
		}
		return True;
	}


	function __destruct(){
	}

}

?>