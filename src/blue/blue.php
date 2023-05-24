<?php

/*
Parametros:
  - imagen: url de la imagen a la que queremos poner en azul

Ejemplos:
	https://pruebas.enuttisworking.com/blue/blue.php?imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg
*/

ini_set("display_errors", 0);
$imagen_url = $_GET['imagen'];

//if(!checkRootDomain($imagen_url)) die; //Si la imagen no es de los dominios aprobados casca

//Generamos las cabeceras
header("Content-type: image/png");
header('Content-disposition: filename="'.basename($imagen_url).'"');

//SI existe en cache no la creamos de nuevo
if(file_exists("./cache/".basename($imagen_url))) {
	$path = "./cache/".basename($imagen_url);
	if(exif_imagetype($path) == IMAGETYPE_JPEG){
		$image = @imagecreatefromjpeg($path);
	} else {
		$image = @imagecreatefrompng($path);
	}
	imagepng($image);
	imagedestroy($image);
} else { //Creamos la imagen
	$filter_r = 0;
	$filter_g = 159;
	$filter_b = 223;
	$path=$imagen_url;
	if(exif_imagetype($path) == IMAGETYPE_JPEG){
		$image = @imagecreatefromjpeg($path);
	} else {
		$image = @imagecreatefrompng($path);
	}
	imagepalettetotruecolor($image);
	imagefilter($image, IMG_FILTER_GRAYSCALE);

	$imagex = imagesx($image);
	$imagey = imagesy($image);
	for ($x = 0; $x <$imagex; ++$x) {
		for ($y = 0; $y <$imagey; ++$y) {
			$rgb = imagecolorat($image, $x, $y);
			$TabColors = imagecolorsforindex ( $image , $rgb );
			$color_r = floor($TabColors['red'] * $filter_r/255);
			$color_g = floor($TabColors['green'] * $filter_g/255);
			$color_b = floor($TabColors['blue'] * $filter_b/255);
			$newcol = imagecolorallocate($image, $color_r, $color_g, $color_b);
			$newcol = imagecolorclosestalpha($image, $color_r, $color_g, $color_b, $TabColors['alpha']);
			imagesetpixel($image, $x, $y, $newcol);
		}
	}

	imagepng($image);
	imagepng($image, "./cache/".basename($imagen_url));

	imagedestroy($image);
}


function checkRootDomain($url) {
	$domains = ["pbs.twimg.com"];
  $url = parse_url($url);
  if(in_array($url['host'], $domains)) return true;
  else return false;
}

