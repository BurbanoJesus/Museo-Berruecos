<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/museo/application/database/database.php';
Class Pieza extends Db{
	private $paginaActual;
    private $totalPaginas;
    private $nResultados;
    private $resultadosPorPagina;
    private $indice;

	public function __construct(){
		parent::__construct();
		$this->resultadosPorPagina = 15;
        $this->indice = 0;
        $this->paginaActual = 1;
	}

	function insertar($id,$titulo,$categoria,$descripcion,$preview,$type_preview,$fecha){
		$sql = "INSERT INTO piezas VALUES(:id,:titulo,:categoria,:descripcion,:preview,:type_preview,:fecha)";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'titulo' => $titulo, 'categoria' => $categoria, 'descripcion' => $descripcion, 'preview' => $preview, 'type_preview' => $type_preview, 'fecha' => $fecha]);
		$row = $query->rowCount();
		if ($row == 0) return False;
		return True;
	}

	function listar(){
		$sql_count = "SELECT COUNT(*) AS total FROM piezas";
        $count = $this->db->prepare($sql_count);
        $count->execute();
        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
        $this->calcularPaginas($count);
		$sql = "SELECT * FROM piezas LIMIT :since, :numero";
		$query = $this->db->prepare($sql);
		// var_dump($query);
        $query->execute(['since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
		// $query->get_result();
		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function filtrar($categoria,$busqueda){
		$categoria = ($categoria == '') ? '%%' : $categoria;
		$busqueda = ($busqueda == '') ? '%%' : $busqueda;

        $sql_count = "SELECT COUNT(*) AS total FROM piezas WHERE categoria like :categoria AND titulo like :busqueda";
        $count = $this->db->prepare($sql_count);
        $count->execute(['categoria' => $categoria,'busqueda' => '%'.$busqueda.'%']);
        $count = $count->fetch(PDO::FETCH_OBJ)->total; 
        $this->calcularPaginas($count);

		$sql = "SELECT * FROM piezas WHERE categoria like :categoria AND titulo like :busqueda LIMIT :since, :numero";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['categoria' => $categoria,'busqueda' => '%'.$busqueda.'%','since' => $this->indice, 'numero' => $this->resultadosPorPagina]);
			
		$collect = Null;

		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function detalles($id){
		$sql = "SELECT * FROM piezas NATURAL JOIN multimedia_piezas WHERE id_pieza = :id";
		// echo($sql);
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
	
		if ($query == False){
			$sql = "SELECT * FROM piezas WHERE id_pieza = :id";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id]);
		}

		$collect = Null;
		while($row = $query->fetchObject()){
		    $collect[] = $row;
		}
		return $collect;
	}

	function insertar_mu($id,$multimedia,$url_host,$tipo){
		$sql = "INSERT INTO multimedia_piezas VALUES(:id,:multimedia,:url_host,:tipo)";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id, 'multimedia' => $multimedia, 'url_host' => $url_host, 'tipo' => $tipo]);
		return true;
	}

	function eliminar($id){
		$sql = "DELETE FROM piezas WHERE id_pieza = :id";
		$query = $this->db->prepare($sql);
		$query->execute(['id' => $id]);
		if ($query->rowCount() == 0) return False;
		return True;
	}


	function actualizar_img($id,$str_preview,$type_preview){
		try{
			$sql = "UPDATE piezas SET 
			preview = :str_preview, 
			tipo_preview = :type_preview
			WHERE id_pieza = :id";
			$query = $this->db->prepare($sql);
			$query->execute(['id' => $id, 'str_preview' => $str_preview, 'type_preview' => $type_preview]);
			if ($query->rowCount() == 0) return False;
			return True;
		}catch(PDOException $e){
			$error = $e->getMessage().' -- '.$e->getCode();
			$tipo = 'Actualizar - Pieza Img';
			$this->debug($error,$tipo);
		}
	}

	function eliminar_archivos($id){
		$carpeta_server =  SERVER."/static/multimedia/piezas/$id/";
		$sel_archivos =  SERVER."/static/multimedia/piezas/$id/*";
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

    function calcularPaginas($count){
        $this->nResultados  = $count;
        $this->totalPaginas = $this->nResultados / $this->resultadosPorPagina;

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