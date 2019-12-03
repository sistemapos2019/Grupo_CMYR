<?php
session_start();
include "../config/config.php";
$numeroOrden = $_POST['numeroOrden'];
$cliente = $_POST['cliente'];
$comentario = $_POST['comentario'];

//insertar y/o actualizar los productos, en la tabla detalleorden
$datos=$_SESSION['tablaproductosnuevos'];
$r=0;
for($i=0; $i < count($datos); $i++){
    $d=explode("||", $datos[$i]);
    $sql="insert into detalleorden (idOrden,idProducto,cantidad,precioUnitario) values (\"$numeroOrden\",\"$d[0]\",\"$d[1]\",\"$d[3]\") ON DUPLICATE KEY UPDATE cantidad=cantidad+$d[1]";

    $r= $r + $result=mysqli_query($con,$sql);

}

echo $r;

//añadir el comentario a la tabla orden
if (!empty($comentario)){
$comentario = " Ampliación: " . $comentario;
$com=mysqli_query($con,"UPDATE orden SET observacion=CONCAT(observacion,\"$comentario\") Where id=$numeroOrden");
}

//Datos para insertar en tabla bitacora
$id_usuario=$_SESSION['user_id'];
$create_bitacora="NOW()";
$suceso="Amplió la orden del cliente $cliente con id $numeroOrden";
//Sentencia para insertar bitacora
$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
$insertar_bitacora = mysqli_query($con, $sql_bitacora);

//
$ticket=array_values($_SESSION['tablaproductosnuevos']);
unset($_SESSION['tablaproductosnuevos']);
$_SESSION['ticketampliados']=$ticket;

?>