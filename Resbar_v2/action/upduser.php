<?php
session_start();

if (
	 !empty($_POST['mod_nombre']) &&
	 !empty($_POST['mod_usuario']) &&
	 !empty($_POST['mod_rol']) &&
	 !empty($_POST['mod_contra']) &&
	 !empty($_POST['mod_pin'])
 ){


		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		//Datos del usuario
		$nombre = $_POST["mod_nombre"];
		$usuario = $_POST["mod_usuario"];
		$rol=$_POST["mod_rol"];
		$contra=mysqli_real_escape_string($con,(strip_tags(sha1(md5($_POST["mod_contra"])),ENT_QUOTES)));
		$pin = $_POST["mod_pin"];
		$id=$_POST["mod_id"];
		//Datos para insertar en tabla bitacora
		$id_usuario=$_SESSION['user_id'];
		$create_bitacora="NOW()";
		$suceso="Modificó el usuario $nombre con id $id";

		//Sentencia para actualizar usuario
		$sql="update usuario set nombreCompleto=\"$nombre\",login=\"$usuario\",pin=\"$pin\",rol=\"$rol\",clave=\"$contra\" where id=$id";
		//Sentencia para insertar bitacora
		$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

		$query_update = mysqli_query($con,$sql);

		if ($query_update){
			$insertar_bitacora = mysqli_query($con, $sql_bitacora);

			//devolver mensaje clave para mostrar alerta
			echo "actualizado";
			// $messages[] = "El usuario se ha actualizado satisfactoriamente.";
		} else{
			//mensaje cuando no se pudo insertar
			echo "error";

			// $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
		}
 } else {
	//Error desconocido
	echo "otro error";
}
		
?>