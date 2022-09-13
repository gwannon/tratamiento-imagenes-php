<?php

/*
    Parametros:
        - nombre: Nombre del producto, se muestra en la parte superior derecha.
        - precio: Precio del producto, se muestra en la parte inferior izquierda. El propio script pone el formato del precio.
        - color: color en hexadecimal de los textos
        - imagen: url de la imagen a la que queremos poner el marco 

    Ejemplos:
	https://pruebas.enuttisworking.com/coches/image.php?nombre=KIA%20Niro&precio=27400&color=ffffff&imagen=https://pruebas.enuttisworking.com/coches/kia-niro-1-6-hev-emotion-9.jpg
*/

//Configuración
$fontprecio = "./MsMadi-Regular.ttf";
$fontnombre = "./Montserrat-Bold.ttf";
$fontsize = 25;
$degrees = 0;

//Recogemos los datos por GET
$nombre = $_GET['nombre'];
$precio = "Precio: ".number_format($_GET['precio'], 0, ",", ".")."€";
$imagen_url = $_GET['imagen'];

//Generamos las cabeceras
header("Content-type: image/png");
header('Content-disposition: filename="'.basename($imagen_url).'"');

//Creamos la imagen del marco con transparencia
$marco = imagecreatefrompng("./marco.png");

//Cargamos la imagen del producto desde una URL y la redimensionamos al tamaño del marco
$imagen = resize_image($imagen_url, imagesx($marco), imagesy($marco), true);

//Copiamos el marco encima de la imagen del producto
imagecopy($imagen, $marco, 0, 0, 0, 0, imagesx($marco), imagesy($marco));

//preparamos el color del texto
list($r, $g, $b) = sscanf($_GET['color'], "%02x%02x%02x");
$color = imagecolorallocate($imagen, $r, $g, $b);

//Calculamos la posición de los texto y los metemos dentro de la imagen
imagettftext($imagen, $fontsize, $degrees, imagesx($imagen) - 30 - (strlen($nombre) * ($fontsize / 1.2)), 30 + $fontsize, $color, $fontnombre, $nombre);
imagettftext($imagen, $fontsize, $degrees, 30, imagesy($imagen) - 30, $color, $fontprecio, $precio);

//Generamos la imagen y mostramos la imagen
imagepng($imagen);

//Destruimos las imágenes
imagedestroy($imagen);
imagedestroy($marco);

function resize_image($file, $w, $h, $crop = false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}
