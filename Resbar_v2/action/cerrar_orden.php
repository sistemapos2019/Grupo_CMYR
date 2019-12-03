<?php
include "../config/config.php";
session_start();

$idOrden=intval($_POST['idOrden']);
$propina=($_POST['propina']);
$cliente=($_POST['cliente']);

//Datos para insertar en tabla bitacora
$id_usuario=$_SESSION['user_id'];
$create_bitacora="NOW()";
$suceso="Cobró la orden del cliente $cliente con id $idOrden";
//Sentencia para insertar bitacora
$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

//si la propina está vacía no se inserta
if ($propina=="") {
	$sql1=mysqli_query($con,"UPDATE orden SET estado='cc' Where id=$idOrden");
	$insertar_bitacora = mysqli_query($con, $sql_bitacora);
}else{
	$sql1=mysqli_query($con,"UPDATE orden SET estado='cc', propina=$propina Where id=$idOrden");
	$insertar_bitacora = mysqli_query($con, $sql_bitacora);
}

?>