<?php
session_start();
//quitar productos de la tabla temporal
$index=intval($_POST['indice']);
var_dump($index);
echo($index);

/*unset($_SESSION['tablaproductosnuevos'][$index]);
$datos=array_values($_SESSION['tablaproductosnuevos']);
unset($_SESSION['tablaproductosnuevos']);
$_SESSION['tablaproductosnuevos']=$datos;
*/
// si el tamaño del arreglo es 1 significa que es el ultimo producto a eliminar entonces que vacie el arreglo
if (sizeof($_SESSION['tablaproductosnuevos']) == 1) {
	unset($_SESSION['tablaproductosnuevos']);
	
}else{
	// sino solo que elimine el elemento de la posicion $index
	unset($_SESSION['tablaproductosnuevos'][$index]);
	// reordenamos los elementos y los guardamos en una variable
	$datos=array_values($_SESSION['tablaproductosnuevos']);
	// vaciamos el arreglo
	unset($_SESSION['tablaproductosnuevos']);
	// llenando de nuevo el arreglo con los datos restantes ya ordenados
	$_SESSION['tablaproductosnuevos']=$datos;
}

?>