<?php 
    if ($object === False || $object === Null){
        include VIEWS.'templates/error404.php';
        $flag_error404 = True;
    }else{
    	$flag_error404 = False;
    }
?>