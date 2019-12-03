<?php
include "config/config.php";
//codigo que trae capturado con el lector de barras o introducido con el teclado
$orden=$_POST['orden'];
//varaible tipo tendra si el tipo es preparado o rapido
$tipo=strtoupper(substr($orden, 0,3));
//variale numero sera el numero de orden donde ira a cambiar el timpo de preparacion
$numero=substr($orden, 4);
//se evalua si  el numero y el tipo de orden no estan vacios para proceder a las operaciones
if(!empty($numero) and !empty($tipo)){
//se evalua si el tipo es PRE coresponde a los productos preparados
 if($tipo=="PRE"){
    $sql="UPDATE orden set tiempoPreparado = NULL  WHERE  id=$numero";
    $query_update = mysqli_query($con,$sql);
    if ($query_update){
        // si el registro se actualiza con exito mostrara el mensaje para poder emitir la alerta de exito
        echo "actualizado";  
    } else{
        //si ocurre algun error mostrarara el mensaje de error para poder emitir la alerta de error
        echo "error";
    }
}
//se evalua si el tipo es RAP coresponde a los productos rapidos
if($tipo=="RAP"){
    $sql="UPDATE orden set tiempoRapido= NULL WHERE id=$numero";
    $query_update = mysqli_query($con,$sql);
    if ($query_update){
        // si el registro se actualiza con exito mostrara el mensaje para poder emitir la alerta de exito
        echo "actualizado";
    } else{
        //si ocurre algun error mostrarara el mensaje de error para poder emitir la alerta de error
        echo "error";
    }
        
    }
}
?>