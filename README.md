# tratamiento-imagenes-php
Ejemplo de tratamiento de imágenes con las librerías de imagen de PHP.

![Imagen original](https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg)

## coche.php

### Parametros:
* nombre: Nombre del producto, se muestra en la parte superior derecha.
* precio: Precio del producto, se muestra en la parte inferior izquierda. El propio script pone el formato del precio.
* color: color en hexadecimal de los textos
* imagen: url de la imagen a la que queremos poner el marco 

### Ejemplos:
* https://pruebas.enuttisworking.com/coches/image.php?nombre=KIA%20Niro&precio=27400&color=ffffff&imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg

![Coche con marco](https://pruebas.enuttisworking.com/coches/image.php?nombre=KIA%20Niro&precio=27400&color=ffffff&imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg)

## blue.php

### Parametros:
* imagen: url de la imagen a la que queremos poner en azul

### Ejemplos:
* https://pruebas.enuttisworking.com/blue/blue.php?imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg

![Coche Azul](https://pruebas.enuttisworking.com/blue/blue.php?imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg)

## play.php

### Parametros:
* imagen: url de la imagen a la que queremos poner un degradado un botón de play 

### Ejemplos:
* https://pruebas.enuttisworking.com/play/play.php?imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg

![Coche con Play](https://pruebas.enuttisworking.com/play/play.php?imagen=https://raw.githubusercontent.com/gwannon/tratamiento-imagenes-php/main/src/coche.jpg)


## resizer.php
Convierte todos los PNGs del directorio /media/ en imágenes de 272x272 con la imagen en PNG anterior en el centro y redimensionada.
