# Details #

# tablas necesarias #
## busqueda ##
> idbusqueda, idusuario, nombre de busqueda, id carpeta padre, ....... etc....

> >>al crearce un nuevo usuario debe crearse la carpeta 0 que es la carpeta raiz.
## carpeta\_de\_busqueda ##
> > idcarpeta, idusuario, idpadre, nombre de carpeta




procedures de búsquedas.

## nuevabusqueda ##
  * input (nombre de busqueda, carpeta padre).
  * ouput idBusqueda.


## nuevacarpeta ##
  * input idPadre, nombre de carpeta
  * output idCarpeta

## actualizar\_nombre\_de\_busqueda ##
  * input (idBusqueda, nuevo\_nombre)


## obtiene\_busquedas\_por\_usuario ##
  * input idUsuario
  * output recorset con las busquedas.


## obtiene\_habilidades\_duras\_de\_busqueda ##
  * input idBusqueda
  * output LAS HABILIDADES DURAS

## obtiene\_habilidades\_blandas\_de\_busqueda ##
  * input idBusqueda
  * output LAS HABILIDADES DURAS

## obtiene\_experiencia\_laboral\_de\_busqueda ##
  * input idBusqueda
  * output LAS experiencias laborales.

## obtiene\_edu\_formal de busqueda ##
  * input idBusqueda
  * output EDUS FORMALES.


## obtiene\_edu\_no\_formal de busqueda ##
  * input idBusqueda
  * output EDUS NO FORMALES.


## obtiene datos personales de busqueda ##
  * Edad (rango),  sexo (masc, fem, indistinto), provincia en la que vive, localidad en la que vive,  tiene twitter, tiene sms.


## obtiene\_Otros\_criterios ##
  * (no entiendo este item todavia, VER CUS)


**de todos los obtiene debe tener tambien los actualiza correspondientes.**


## ejecutar\_busqueda ##
  * input idBusqueda
  * output recorset de EL\_RESULTADO\_DE\_LA\_BUSQUEDA