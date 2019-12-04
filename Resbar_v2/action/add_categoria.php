<?php
session_start();
/*Inicia validacion del lado del servidor*/
if (
	!empty($_POST['name'])
) {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos
	//Nombre categoria
	$name = $_POST["name"];

	//Sentencia para insertar categoria
	$sql = "insert into categoria (nombre) value (\"$name\")";
	
	$query_new_insert = mysqli_query($con, $sql);
	if ($query_new_insert) {
		//obteniendo el último id insertado (metodologia orientada a objetos)
		$id_cat=$con->insert_id;
		//Datos para insertar en tabla bitacora
		$id_usuario=$_SESSION['user_id'];
		$create_bitacora="NOW()";
		$suceso="Agregó la categoria $name con id $id_cat";
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