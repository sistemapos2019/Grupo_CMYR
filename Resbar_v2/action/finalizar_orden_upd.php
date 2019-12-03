<?php
include "../config/config.php";
session_start();

$idOrden=intval($_POST['idOrden']);
$cliente=($_POST['cliente']);

//consultamos si la orden tiene productos en detalleorden
$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM detalleorden WHERE idOrden=$idOrden");
$row = mysqli_fetch_array($count_query);
$numrows = $row["numrows"];

//si tiene productos insertar bitacora modificados y sino insertar bitacora eliminados
if ($numrows > 0) {
//Datos para insertar en tabla bitacora
$id_usuario=$_SESSION['user_id'];
$create_bitacora="NOW()";
$suceso="Modificó productos de la orden del cliente $cliente con id $idOrden";
//Sentencia para insertar bitacora
$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
$insertar_bitacora = mysqli_query($con, $sql_bitacora);

}else{
	//Datos para insertar en tabla bitacora
	$id_usuario=$_SESSION['user_id'];
	$create_bitacora="NOW()";
	$suceso="Eliminó todos los productos de la orden del cliente $cliente con id $idOrden";
	//Sentencia para insertar bitacora
	$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
	$insertar_bitacora = mysqli_query($con, $sql_bitacora);
	}

?>