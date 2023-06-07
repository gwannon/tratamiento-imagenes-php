<?php

/*
    Converite todos los PNGs deñ directorio media en imágenes de 272x272 con la imagen anterior en el centro y rediemnsionada.
*/ 

if (!file_exists("./media/")) {
    echo "No existe el directorio de imágenes\n";
    die; 
}

$images = glob("./media/" . '*.{png}', GLOB_BRACE);

$newdir = "./new/";

if (!file_exists()) {
    mkdir($newdir, 0755);
}


foreach ($images as $image_path) {

  echo str_replace("/media/", "/new/", $image_path)."\n";
  //Creamos la imagen del marco con transparencia
  $imagen = resize_image($image_path, 272, 272, false);

  //Generamos la imagen y mostramos la imagen
  imagepng($imagen, str_replace("/media/", "/new/", $image_path), 0);

  //Destruimos las imágenes
  imagedestroy($imagen);
}


function resize_image($file, $w, $h, $margin = 10) {
    $dst = imagecreate($w, $h);

    $w = $w - ($margin*2);
    $h = $h - ($margin*2);
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($w/$h > $r) {
        $newwidth = $h*$r;
        $newheight = $h;
    } else {
        $newheight = $w/$r;
        $newwidth = $w;
    }

    $new_dst_y = (($h + ($margin*2)) - $newheight) / 2;

    $src = imagecreatefrompng($file);
    
    imagecopyresampled($dst, $src, $margin, $new_dst_y, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}