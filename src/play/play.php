<?php


/*
Parametros:
  - imagen: url de la imagen a la que queremos poner el play 

Ejemplos:
	https://pruebas.enuttisworking.com/play/play.php?imagen=https://pbs.twimg.com/media/FvyMutbWcAEPHdi?format=jpg&name=large
*/

$imagen_url = $_GET['imagen'];

//if(!checkRootDomain($imagen_url)) die; //Si la imagen no es de spri casca

//Generamos las cabeceras
header("Content-type: image/png");
header('Content-disposition: filename="'.basename($imagen_url).'"');

if(file_exists("./cache/".basename($imagen_url))) {
	$path = "./cache/".basename($imagen_url);
	if(exif_imagetype($path) == IMAGETYPE_JPEG){
		$image=@imagecreatefromjpeg($path);
	} else {
		$image=@imagecreatefrompng($path);
	}
	imagepng($image);
	imagedestroy($image);
} else {
	//Creamos la imagen del play con transparencia
	$play = imagecreatefrompng("./video.png");
	if(isset($_REQUEST['reverse']) && $_REQUEST['reverse'] == 'yes') $gradient = imagecreatefrompng("./gradient-reverse.png");
	else $gradient = imagecreatefrompng("./gradient.png");

	//Cargamos la imagen del producto desde una URL y la redimensionamos al tamaño del play
	$imagen = resize_image($imagen_url, imagesx($play), imagesy($play));

	//Copiamos el play encima de la imagen del producto
	imagecopy($imagen, $gradient, 0, 0, 0, 0, imagesx($play), imagesy($play));


	//Copiamos el play encima de la imagen del producto
	imagecopy($imagen, $play, 0, 0, 0, 0, imagesx($play), imagesy($play));

	//Generamos la imagen y mostramos la imagen
	imagepng($imagen);

	imagepng($imagen, "./cache/".basename($imagen_url));

	//Destruimos las imágenes
	imagedestroy($imagen);
	imagedestroy($play);
}

function resize_image($image, $x, $y) {
	$path_parts = pathinfo($image);
	if($path_parts['extension'] == "png") $source = imagecreatefrompng($image);
	else $source = imagecreatefromjpeg($image);
	
	//$x=288; $y=202; // my final thumb
	$ratio_thumb=$x/$y; // ratio thumb

	list($xx, $yy) = getimagesize($image); // original size
	$ratio_original=$xx/$yy; // ratio original

	if ($ratio_original>=$ratio_thumb) {
			$yo=$yy; 
			$xo=ceil(($yo*$x)/$y);
			$xo_ini=ceil(($xx-$xo)/2);
			$xy_ini=0;
	} else {
			$xo=$xx; 
			$yo=ceil(($xo*$y)/$x);
			$xy_ini=ceil(($yy-$yo)/2);
			$xo_ini=0;
	}
	$thumb = imagecreatetruecolor($x, $y);
	imagecopyresampled($thumb, $source, 0, 0, $xo_ini, $xy_ini, $x, $y, $xo, $yo);
	return $thumb;
}

function checkRootDomain($url) {
	$domains = ["pbs.twimg.com"];
  $url = parse_url($url);
  if(in_array($url['host'], $domains)) return true;
  else return false;
}
