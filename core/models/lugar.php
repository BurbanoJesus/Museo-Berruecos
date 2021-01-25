<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Lugar extends Db{

	public function __construct(){
		parent::__construct();
	}

	function insertar($id,$titulo,$descripcion,$latitud,$longitud,$fecha){
		$sql = "INSERT INTO lugares VALUES(:id,:titulo,:descripcion,:latitud,:longitud,:fecha)";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'titulo' => $titulo, 'descripcion' => $descripcion, 'latitud' => $latitud, 'longitud' => $longitud, 'fecha' => $fecha]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function listar(){
		$sql = "SELECT * FROM lugares";
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

	function listar_detalles(){
		$sql = "SELECT * FROM lugares NATURAL JOIN multimedia_lugares";
		$query = $this->db->prepare($sql);
		$query->execute();
			
		$collect = Null;

		while($row = $query->fetchObject()){
			if ($row == False) return False;
		    $collect[] = $row;
		}
		return $collect;
	}

	function detalles($id){
		$sql = "SELECT * FROM lugares NATURAL JOIN multimedia_lugares WHERE id_lugar = :id";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
	
		if ($query == False){
			$sql = "SELECT * FROM lugares WHERE id_lugar = :id";
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
		$sql = "INSERT INTO multimedia_lugares VALUES(:id,:multimedia,:url_host)";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'multimedia' => $multimedia, 'url_host' => $url_host]);
		return true;
	}

	function __destruct(){
	}

}

?>