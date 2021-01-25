<?php 
    if (!isset($_SESSION['usuario'])){
        header("Location: ".HOST);
        exit();
    }
?>