<?php
session_start();

if (
	 !empty($_POST['mod_categoria']) &&
	 !empty($_POST['mod_producto']) &&
	 !empty($_POST['mod_precio']) &&
	 !empty($_POST['mod_preparado'])
 	){

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	//Datos del producto
	$categoria = $_POST["mod_categoria"];
	$producto = $_POST["mod_producto"];
	$precio = $_POST["mod_precio"];
	$inventario=$_POST["mod_inventario"];
	$preparado=$_POST['mod_preparado'];
	if ($preparado=="Si"){$preparado=1;}else {$preparado=0;}
	$id = $_POST['mod_id'];
	//Datos para insertar en tabla bitacora
	$id_usuario=$_SESSION['user_id'];
	$create_bitacora="NOW()";
	$suceso="Modificó el producto $producto con id $id";

	//Sentencia para actualizar producto
	$sql = "update producto set nombre=\"$producto\", precio=\"$precio\", inventario=\"$inventario\", preparado=$preparado, idCategoria=\"$categoria\" where id=$id";
	//Sentencia para insertar bitacora
	$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

	$query_update = mysqli_query($con, $sql);

	if ($query_update) {
		$insertar_bitacora = mysqli_query($con, $sql_bitacora);

		//devolver mensaje clave para mostrar alerta
		echo "actualizado";

	} else {
		//mensaje cuando no se pudo insertar
		echo "error";
	}
} else {
	//Error desconocido
	echo "otro error";
}

?>