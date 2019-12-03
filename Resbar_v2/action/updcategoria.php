<?php
session_start();

if (
	!empty($_POST['mod_name'])
) {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	//Datos de categoria
	$name = $_POST["mod_name"];
	$id = $_POST['mod_id'];

	//Datos para insertar en tabla bitacora
	$id_usuario=$_SESSION['user_id'];
	$create_bitacora="NOW()";
	$suceso="Modificó la categoria $name con id $id";

	//Sentencia para actualizar categoria
	$sql = "update categoria set nombre=\"$name\" where id=$id";
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