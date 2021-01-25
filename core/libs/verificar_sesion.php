<?php 
    if (!isset($_SESSION['usuario'])){
        include VIEWS.'templates/init_session.php';
        $flag_session = True;
    }else if ($_SESSION['usuario'] == ""){
        include VIEWS.'templates/session_fin.php';
        $flag_session = True;
    }else{
    	$usuario = $_SESSION['usuario'];
    	$flag_session = False;
    }
?>