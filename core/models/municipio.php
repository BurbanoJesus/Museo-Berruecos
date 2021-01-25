<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Municipio extends Db{

	public function __construct(){
		parent::__construct();
	}

	function insertar($id,$municipio){
		$sql = "INSERT INTO municipios VALUES(:id,:municipio)";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'municipio' => $municipio]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function listar(){
		$sql = "SELECT * FROM municipios";
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

	function __destruct(){
	}

}

?>