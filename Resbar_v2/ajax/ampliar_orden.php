<?php
session_start();

//agregar productos al arreglo para después mostrarlos en la tabla temporal que se dibuja en el archivo ./ajax/tabla_productos_nuevos_tmp.php
if (isset($_POST['id']) &&
    isset($_POST['cantidad'])
){

    include "../config/config.php"; //Contiene funcion que conecta a la base de datos
    
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    $query = mysqli_query($con, "SELECT precio, nombre from producto where id=$id");
    while ($row = mysqli_fetch_array($query)) {
        $precio = $row['precio'];
        $producto = $row['nombre'];
        $subtotal = $precio * $cantidad;

    }

    $productos=$id."||".$cantidad."||".$producto."||".$precio;

    //si el arreglo ya tiene valores hay que recorrerlo y verificar si el producto ya se encuentra en el, para que en vez de volverlo a agregar solo reemplace su cantidad
    if (isset($_SESSION['tablaproductosnuevos'])) {
    	$i=0;
    	foreach (@$_SESSION['tablaproductosnuevos'] as $key) {
                      
            $d=explode("||", @$key);
            if ($d[0] == $id) {
				$index = $i;		
            }

            $i++;
        }

        if (isset($index)) {
        	$_SESSION['tablaproductosnuevos'][$index]=$productos;
        }else{
        	$_SESSION['tablaproductosnuevos'][]=$productos;
        }
    	
    }else{
    	$_SESSION['tablaproductosnuevos'][]=$productos;
    }

}
?>
   