<?php
session_start();
/*Inicia validacion del lado del servidor*/
if (
	 !empty($_POST['categoria']) &&
	 !empty($_POST['producto']) &&
	 !empty($_POST['precio']) &&
	 !empty($_POST['preparado'])
 ){

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	//Datos del nuevo producto
	$categoria = $_POST["categoria"];
	$producto = $_POST["producto"];
	$precio = $_POST["precio"];
	$inventario=$_POST["inventario"];
	$preparado=$_POST["preparado"];

    if ($preparado=="Si"){
    	$preparado=1;
    }else {
    	$preparado=0;
    }

	//Sentencia para insertar producto
	$sql="insert into producto (nombre,precio,inventario,preparado,idCategoria) value (\"$producto\",\"$precio\",\"$inventario\",\"$preparado\",\"$categoria\")";
	
	$query_new_insert = mysqli_query($con, $sql);

	if ($query_new_insert) {
		//obteniendo el último id insertado (metodologia orientada a objetos)
		$id_producto=$con->insert_id;
	    //Datos para insertar en tabla bitacora
		$id_usuario=$_SESSION['user_id'];
		$create_bitacora="NOW()";
		$suceso="Agregó el producto $producto con id $id_producto";
		//Sentencia para insertar bitacora
		$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
		$insertar_bitacora = mysqli_query($con, $sql_bitacora);

		//devolver mensaje clave para mostrar alerta
		echo "agregado";
	} else {
		//mensaje cuando no se pudo insertar
		echo "error";
	}
} else {
	//Error desconocido
	echo "otro error";
}


?>