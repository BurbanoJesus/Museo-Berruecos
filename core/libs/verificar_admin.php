<?php 
    if (!isset($_SESSION['usuario'])){
        header("Location: ".HOST);
        exit();
    }else if($_SESSION['usuario']->tipo_usuario !== 'administrador'){
    	header("Location: ".HOST);
        exit();
    }
?>