<?php
function optimizar_imagen($source, $url_archivo, $xf, $yf, $extension, $size = 500, $quality = 100) { 
    $carpeta_destino = pathinfo($url_archivo)['dirname'].'/';
    $name = pathinfo($url_archivo)['filename'];
    $extension = ($extension == 'jpeg') ? 'jpg': $extension;
    switch($extension){ 
        case 'jpg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'png': 
            $image = imagecreatefrompng($source);
            break; 
        case 'gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            break;
    } 

    $x = imagesx($image);  
    $y = imagesy($image);

    if($x <= $xf && $y <= $yf){
        $nuevax = $x;  
        $nuevay = $y;  
    }
    else if($x >= $y) {  
        $nuevax = $xf;  
        $nuevay = $nuevax * ($y / $x);  
    }  
    else{  
        $nuevay = $yf;  
        $nuevax = ($x / $y) * $nuevay;  
    } 

    $copia = imagecreatetruecolor($nuevax, $nuevay);

    if ($extension == 'png') {
        imagealphablending($copia, false);
        imagesavealpha($copia,true);
        $transparent = imagecolorallocatealpha($copia, 255, 255, 255, 127);
        imagefilledrectangle($copia, 0, 0, $x, $y, $transparent);
    }

    imagecopyresized($copia, $image, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);

    if ($quality != 99) {
        $quality = ($size <= 500) ? 80 : 40;
        $quality = ($size > 3000) ? 30 : $quality;
    }


    $cont_existe_file = 1;
    $name_archivo = $name.'.'.$extension;
    $url_archivo = $carpeta_destino.$name_archivo;


    while(file_exists($url_archivo)){
        $name_archivo =  $name.'_'.$cont_existe_file.'.'.$extension;
        $url_archivo = $carpeta_destino.$name_archivo;
        // echo "while: ".$name_archivo.'<br>';
        $cont_existe_file++;
    }

    switch($extension){ 
        case 'jpg': 
            imagejpeg($copia, $url_archivo, $quality); 
            break; 
        case 'png':
            $quality = $quality/100;
            imagepng($copia, $url_archivo);
            break; 
        case 'gif': 
            imagegif($copia, $url_archivo); 
            break; 
        default: 
           break;
    }
      
    imagedestroy($image);
    imagedestroy($copia);
    return $name_archivo; 
}

function recortar_imagen($source, $url_archivo, $xf, $yf, $post_x, $post_y, $post_w, $post_h, $jcrop_x, $extension, $size = 500, $quality = 99) { 
    $carpeta_destino = pathinfo($url_archivo)['dirname'].'/';
    $name = pathinfo($url_archivo)['filename'];
    $extension = ($extension == 'jpeg') ? 'jpg': $extension;
    switch($extension){ 
        case 'jpg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            break;
    }
    $x = imagesx($image);  
    $y = imagesy($image);
    $scale = ($x / $jcrop_x);
    // echo $scale."<br>";
    $post_x = $post_x * $scale;
    $post_y = $post_y * $scale;
    $post_w = $post_w * $scale;
    $post_h = $post_h * $scale;

    $copia = ImageCreateTrueColor($xf,$yf);

    if ($extension == 'png') {
        imagealphablending($copia, false);
        imagesavealpha($copia,true);
        $transparent = imagecolorallocatealpha($copia, 255, 255, 255, 127);
        imagefilledrectangle($copia, 0, 0, $x, $y, $transparent);
    }

    imagecopyresampled($copia,$image,0,0,$post_x,$post_y,$xf,$yf,$post_w,$post_h);

    if ($quality != 99) {
        $quality = ($size <= 500) ? 80 : 40;
        $quality = ($size > 3000) ? 30 : $quality;
    }


    $cont_existe_file = 1;
    $name_archivo = $name.'.'.$extension;
    $url_archivo = $carpeta_destino.$name_archivo;

    while(file_exists($url_archivo)){
        $name_archivo =  $name.'_'.$cont_existe_file.'.'.$extension;
        $url_archivo = $carpeta_destino.$name_archivo;
        // echo "while: ".$name_archivo.'<br>';
        $cont_existe_file++;
    }

    switch($extension){ 
        case 'jpg': 
            imagejpeg($copia, $url_archivo, $quality); 
            break; 
        case 'png': 
            $quality = $quality/100;
            imagepng($copia, $url_archivo, $quality);
            break; 
        case 'gif': 
            imagegif($copia, $url_archivo); 
            break; 
        default: 
           break;
    }
      
    imagedestroy($image);
    imagedestroy($copia);
    return $name_archivo; 
}

function filtro_imagen($source, $url_archivo, $xf, $yf, $extension , $size, $quality = 100){
    $carpeta_destino = pathinfo($url_archivo)['dirname'].'/';
    $name = pathinfo($url_archivo)['filename'];
    $extension = ($extension == 'jpeg') ? 'jpg': $extension;

    switch($extension){ 
        case 'jpg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            break;
    }


    $cont_existe_file = 1;
    $name_archivo = $name.'.'.$extension;
    $url_archivo = $carpeta_destino.$name_archivo;

    while(file_exists($url_archivo)){
        $name_archivo =  $name.'_'.$cont_existe_file.'.'.$extension;
        $url_archivo = $carpeta_destino.$name_archivo;
        // echo "while: ".$name_archivo.'<br>';
        $cont_existe_file++;
    }

    if($quality != 99){
        $quality = ($size <= 500) ? 80 : 40;
        $quality = ($size > 3000) ? 30 : $quality;
    }

    $x = imagesx($image);  
    $y = imagesy($image);

    if($x <= $xf && $y <= $yf){
        $nuevax = $x;  
        $nuevay = $y;  
    }
    else if($x >= $y) {  
        $nuevax = $xf;  
        $nuevay = $nuevax * ($y / $x);  
    }  
    else{  
        $nuevay = $yf;  
        $nuevax = ($x / $y) * $nuevay;  
    }

    $copia = imagecreatetruecolor($nuevax, $nuevay);

    if ($extension == 'png') {
        imagealphablending($copia, false);
        imagesavealpha($copia,true);
        $transparent = imagecolorallocatealpha($copia, 255, 255, 255, 127);
        imagefilledrectangle($copia, 0, 0, $x, $y, $transparent);
    }

    imagecopyresized($copia, $image, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);

    imagefilter($copia, IMG_FILTER_BRIGHTNESS, -40);
    for($i=0; $i<= 20;$i++){
        imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR, 999);
    }

    switch($extension){ 
        case 'jpg': 
            imagejpeg($copia, $url_archivo, $quality); 
            break; 
        case 'png': 
            $image = imagecreatefrompng($source);
            imagefilter($image, IMG_FILTER_BRIGHTNESS, -45);
            $quality = $quality/100;
            imagepng($image, $url_archivo, $quality);  
            break; 
        case 'gif': 
            $image = imagecreatefromgif($source);
            imagefilter($image, IMG_FILTER_BRIGHTNESS, -45);
            imagegif($image, $url_archivo); 
            break; 
        default: 
            break;
    } 

    imagedestroy ($image);
    imagedestroy ($copia);
    return $name_archivo;
}

function type_source($source){
    $source = explode('/', $source);
    $type = $source[0];
    return $type;
}

function ext_source($source){
    $source = explode('/', $source);
    $extension = end($source);
    return $extension;
}

function tipo_ext_bd($type,$extension){
    if ($type == 'application') {
        switch ($extension) {
            case 'msword':
                $str_type = 'word';
                break;
            case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $str_type = 'excel';
                break;

            case 'vnd.openxmlformats-officedocument.presentationml.presentation':
                $str_type = 'power';
                break;

            case 'pdf':
                $str_type = 'pdf';
                break;

            case 'octet-stream':
                $str_type = 'rar';
                break;

            default:
                $str_type = 'otro';
                break;
        }
    }
    if ($type == 'text') {
        switch ($extension) {
            case 'plain':
                $str_type = 'txt';
                break;

            default:
                $str_type = 'text';
                break;
        }
    }
    if ($type == 'image') {
        $str_type = 'image';
    }
    if ($type == 'video') {
        $str_type = 'video';
    }
    return $str_type;
}
?>