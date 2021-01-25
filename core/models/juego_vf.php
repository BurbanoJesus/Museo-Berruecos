<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Juego_vf extends Db{
	private $paginaActual;
    private $totalPaginas;
    private $nResultados;
    private $resultadosPorPagina;
    private $indice;

	public function __construct(){
		parent::__construct();
		$this->resultadosPorPagina = 2;
        $this->indice = 0;
        $this->paginaActual = 1;
	}

	function insertar($id,$titulo,$fecha){
		try{
			$sql = "INSERT INTO juegos_vf VALUES(:id,:titulo,:fecha)";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id, 'titulo' => $titulo, 'fecha' => $fecha]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Insertar - Juego vf';
			$this->debug($error,$tipo);
		}
	}

	function listar(){
		$sql_count = "SELECT COUNT(*) AS total FROM juegos_vf";
        $count = $this->db->prepare($sql_count);
        $count->execute();
        if ($count->rowCount() == 0) return False;
        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
        $this->calcularPaginas($count);

		$sql = "SELECT * FROM juegos_vf LIMIT :since, :numero";
		$query = $this->db->prepare($sql);
        $query->execute(['since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
		if ($query->rowCount() == 0) return False;
		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function detalles($id){
		$sql = "SELECT * FROM juegos_vf NATURAL JOIN preguntas_juegos_vf WHERE id_juego_vf = :id";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);

		if ($query->rowCount() == 0){
			$sql = "SELECT * FROM juegos_vf WHERE id_juego_vf = '$id'";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id]);
			if ($query->rowCount() == 0) return False;
		}
		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function insertar_pg($id,$preguntas,$str_pregunta,$str_respuesta,$url_host){
		try{
			$sql = "INSERT INTO preguntas_juegos_vf VALUES(:id,:preguntas,:str_pregunta,:str_respuesta,:url_host)";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id, 'preguntas' => $preguntas, 'str_pregunta' => $str_pregunta, 'str_respuesta' => $str_respuesta, 'url_host' => $url_host]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Insertar - Juego vf Preguntas';
			$this->debug($error,$tipo);
		}
	}

	function listar_pg($preguntas){
		$sql = "SELECT * FROM preguntas_juegos_vf WHERE preguntas = $preguntas";
		$query = $this->db->prepare($sql);
		$query->execute();
		if ($query->rowCount() == 0) return False;
		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function eliminar($id_juego){
		try{
			$id_pg = 'PG_'.$id_juego;
			$sql_a = "DELETE FROM juegos_vf WHERE id_juego_vf = :id";
			$query_a = $this->db->prepare($sql_a);
			$query_a->execute(['id' => $id_juego]);
			//
			// $sql_b = "DELETE FROM preguntas_juegos_vf WHERE preguntas = :id_pg";
			// $query_b = $this->db->prepare($sql_b);
			// $query_b->execute(['id_pg' => $id_pg]);
			// // 
			// $sql_c = "DELETE FROM juegos_progreso WHERE id_juego = :id AND nombre_juego = :nombre_juego AND usuario = :usuario";
			// $query_c = $this->db->prepare($sql_c);
			// $query_c->execute(['id' => $id_juego, 'nombre_juego' => 'juego_vf', 'usuario' => $_SESSION['usuario']->usuario]);

			if ($query_a->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Eliminar - Juego vf';
			$this->debug($error,$tipo);
		}
	}

	function eliminar_archivos($id){
		try{
			$carpeta_server = MULTIMEDIA_S."juegos_vf/$id/";
			$sel_archivos = MULTIMEDIA_S."juegos_vf/$id/*";
			if (file_exists($carpeta_server)) {
				$files = glob($sel_archivos);
				foreach($files as $file){
				    if(is_file($file))
				    unlink($file);
				}
				rmdir($carpeta_server);
				return True;
			}else{
				$error = 'No existe carpeta';
				$tipo = 'Eliminar';
				$this->debug($error,$tipo);
			}
		}catch(Exception $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Eliminar - Juego vf carpeta';
			$this->debug($error,$tipo);
		}
	}

	function calcularPaginas($count){
        $this->nResultados  = $count;
        $this->totalPaginas = ceil($this->nResultados / $this->resultadosPorPagina);

        if(isset($_GET['pagina'])){
            $this->paginaActual = $_GET['pagina'];
            $this->indice = ($this->paginaActual - 1) * $this->resultadosPorPagina;
        }
    }

    function mostrarPaginas($rango){
    	if ($this->totalPaginas > 1 && $this->paginaActual <= $this->totalPaginas){
	        $actual = '';
	        $sincePag = 1;
	        $untilPag = $this->totalPaginas;
	        $rangoPag = $rango;
	        if($rangoPag <= $this->totalPaginas){
		        if($rangoPag % 2 == 0) {
		        	$limitIn = $rangoPag/2;
			        $limitOut= $rangoPag/2;
			        $isPar = True;
		        }else{
			        $limitIn = floor($rangoPag/2);
			        $limitOut= ceil($rangoPag/2);
			        $isPar = False;
		        }
		        
		        if($this->paginaActual <= $limitOut){
		        	// echo "strin a";
		        	$sincePag = 1;
		        	$untilPag = $rangoPag;
		        }

		        if($this->paginaActual > $limitOut && $this->paginaActual <= $this->totalPaginas - $limitOut){
		        	if ($isPar == True) {
		        		$sincePag = $this->paginaActual - $limitIn + 1;
		        		$untilPag = $this->paginaActual + $limitOut;
		        	}else{
			        	$sincePag = $this->paginaActual - $limitIn;
			        	$untilPag = $this->paginaActual + $limitOut - 1;
		        	}
		        }

		        if($this->paginaActual > $this->totalPaginas - $limitOut){
		        	$sincePag = $this->totalPaginas - $rangoPag + 1;
		        	$untilPag = $this->totalPaginas;
		        }
		    }
		    // 
		    if (isset($_GET)) {
		    	$href = '?';
			    foreach ($_GET as $key => $value){
			    	if ($key != 'pagina') {
			    		$href .= $key.'='.$value.'&';
			    	}
			    }
			    $href .= 'pagina=';
		    }else{
		    	$href = '?pagina=';
		    }
		    // 
	        echo '<ul class="paginador">';
	        if($this->paginaActual > 1){
        		echo '<li class="paginador"><a class="next_prev" href="'.$href.($this->paginaActual - 1).'">Anterior</a><li>';
	        }else{
        		echo '<li class="paginador"><a class="next_prev none" href=""></a><li>';
	        } 
	        for($i=$sincePag; $i <= $untilPag; $i++){
	            if(($i) == $this->paginaActual){
	                $actual = ' class="actual" ';
	            }else{
	                $actual = '';
	            }
	            echo '<li class="paginador"><a '.$actual.'href="'.$href.($i).'">'.($i).'</a></li>';
	        }
	        if($this->paginaActual < $this->totalPaginas){
	        	// var_dump($_GET);
        		echo '<li class="paginador"><a class="next_prev" href="'.$href.($this->paginaActual + 1).'">Siguiente</a><li>';
	        }else{
        		echo '<li class="paginador"><a class="next_prev none" href=""></a><li>';
	        } 
	        echo '</ul>';
	    }
    }

    function mostrarTotalResultados(){
        return $this->nResultados;
    }

    function __destruct(){
	}

}

?>