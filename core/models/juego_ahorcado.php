<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Juego_ahorcado extends Db{
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

	function insertar($id,$enunciado,$respuesta){
		try{
			$sql = "INSERT INTO juegos_ahorcado VALUES(:id,:enunciado,:respuesta)";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id, 'enunciado' => $enunciado, 'respuesta' => $respuesta]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Insertar - Juego Ahorcado';
			$this->debug($error,$tipo);
		}
	}

	function listar(){
		$sql_count = "SELECT COUNT(*) AS total FROM juegos_ahorcado";
        $count = $this->db->prepare($sql_count);
        $count->execute();
        if ($count->rowCount() == 0) return False;
        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
        $this->calcularPaginas($count);
		$sql = "SELECT * FROM juegos_ahorcado LIMIT :since, :numero";
		$query = $this->db->prepare($sql);
        $query->execute(['since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
		if ($query->rowCount() == 0) return False;
		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function listar_load(){
		try{
			$sql_count = "SELECT COUNT(*) AS total FROM juegos_ahorcado left join juegos_progreso ON juegos_ahorcado.id_juego = juegos_progreso.id_juego AND juegos_progreso.nombre_juego = 'juego_ahorcado' WHERE juegos_progreso.id_juego is NULL";
	        $count = $this->db->prepare($sql_count);
	        $count->execute();
	        if ($count->rowCount() == 0) return False;
	        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
	        $this->calcularPaginas($count);
			$sql = "SELECT juegos_ahorcado.id_juego, enunciado, respuesta FROM juegos_ahorcado left join juegos_progreso ON juegos_ahorcado.id_juego = juegos_progreso.id_juego AND juegos_progreso.nombre_juego = 'juego_ahorcado' WHERE juegos_progreso.id_juego is NULL LIMIT :since, :numero";
			$query = $this->db->prepare($sql);
	        $query->execute(['since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
			if ($query->rowCount() == 0) return False;
			$collect = Null;
			while($row = $query->fetchObject()){
			    $collect[] = $row;
			}
			if ($collect === Null){
				$sql = "UPDATE USUARIOS SET estado_juego_ahorcado= :estado WHERE usuario = :usuario";
				$query = $this->db->prepare($sql);
				$query->execute(['estado' => 'A', 'usuario' => $_SESSION['usuario']->usuario]);
				if ($query->rowCount() == 0) return False;
				$_SESSION['usuario']->estado_juego_ahorcado = 'A';
				$this->restaurar_completado();
				return $this->listar_load();
			}
			return $collect;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Actualizar - Estado Juego Ahorcado';
			$this->debug($error,$tipo);
		}
	}

	function restaurar_completado(){
		try{
			$sql = "DELETE FROM juegos_progreso WHERE usuario = :usuario AND nombre_juego = :nombre_juego";
			$query = $this->db->prepare($sql);
			$query->execute(['nombre_juego' => 'juego_ahorcado', 'usuario' => $_SESSION['usuario']->usuario]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Limpiar - Juego Ahorcado';
			$this->debug($error,$tipo);
		}
	}

	function filtrar($categoria,$busqueda){
		$categoria = ($categoria == '') ? '%%' : $categoria;
		$busqueda = ($busqueda == '') ? '%%' : $busqueda;

        $sql_count = "SELECT COUNT(*) AS total FROM juegos_ahorcado WHERE titulo like :busqueda";
        $count = $this->db->prepare($sql_count);
        $count->execute(['categoria' => $categoria,'busqueda' => '%'.$busqueda.'%']);
        if ($query->rowCount() == 0) return False;
        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
        $this->calcularPaginas($count);

		$sql = "SELECT * FROM juegos_ahorcado WHERE titulo like :busqueda LIMIT :since, :numero";
		$query = $this->db->prepare($sql);
		$query->execute(['categoria' => $categoria,'busqueda' => '%'.$busqueda.'%','since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
		if ($query->rowCount() == 0) return False;

		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function detalles($id){
		$sql = "SELECT * FROM juegos_ahorcado WHERE id_juego = :id";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
		if ($query->rowCount() == 0) return False;
		$row = $query->fetchObject();
		return $row;
	}

	function actualizar($id,$enunciado,$respuesta){
		try{
			$sql = "UPDATE juegos_ahorcado SET 
			enunciado = :enunciado, 
			respuesta = :respuesta
			WHERE id_juego = :id";
			$query = $this->db->prepare($sql);
			$query->execute(['enunciado' => $enunciado, 'respuesta' => $respuesta, 'id' => $id]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Actualizar - Juego Ahorcado';
			$this->debug($error,$tipo);
		}
	}

	function eliminar($id_juego){
		try{
			$sql = "DELETE FROM juegos_ahorcado WHERE id_juego = :id_juego";
			$query = $this->db->prepare($sql);
			$query->execute(['id_juego' => $id_juego]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Eliminar - Juego Ahorcado';
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