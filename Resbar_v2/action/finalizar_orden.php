<?php
include "../config/config.php";
session_start();

$idOrden=intval($_POST['idOrden']);
$cliente=($_POST['cliente']);
$comentario=$_POST['comentario'];


$sql1=mysqli_query($con,"UPDATE orden SET observacion=\"$comentario\" Where id=$idOrden");

//Datos para insertar en tabla bitacora
$id_usuario=$_SESSION['user_id'];
$create_bitacora="NOW()";
$suceso="Agregó productos a la orden del cliente $cliente con id $idOrden";
//Sentencia para insertar bitacora
$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
$insertar_bitacora = mysqli_query($con, $sql_bitacora);

?>