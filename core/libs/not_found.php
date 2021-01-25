<?php 
    if ($object === False || $object === Null){
        include VIEWS.'templates/not_found.php';
        $flag_not_found = True;
    }else{
    	$flag_not_found = False;
    }
?>