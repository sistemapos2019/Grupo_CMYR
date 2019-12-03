<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (
		 !empty($_POST['nombre']) &&
		 !empty($_POST['usuario']) &&
		 !empty($_POST['rol']) &&
		 !empty($_POST['contra']) &&
		 !empty($_POST['pin'])
	 ){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		//Datos del nuevo usuario
		$nombre = $_POST["nombre"];
		$usuario = $_POST["usuario"];
		$rol=$_POST["rol"];
		$contra=mysqli_real_escape_string($con,(strip_tags(sha1(md5($_POST["contra"])),ENT_QUOTES)));
		$pin = $_POST["pin"];
		
		//Sentencia para insertar usuario
		$sql="insert into usuario (nombreCompleto,login,clave,pin,rol) value (\"$nombre\",\"$usuario\",\"$contra\",\"$pin\",\"$rol\")";

		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				//obteniendo el último id insertado (metodologia orientada a objetos)
				$usuario_insertado=$con->insert_id;
			    //Datos para insertar en tabla bitacora
				$id_usuario=$_SESSION['user_id'];
				$create_bitacora="NOW()";
				$suceso="Agregó al usuario $nombre con id $usuario_insertado";
				//Sentencia para insertar bitacora
				$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
				$insertar_bitacora = mysqli_query($con, $sql_bitacora);

				// $messages[] = "Usuario agregado satisfactoriamente.";
				//devolver mensaje clave para mostrar alerta insertado
				echo "agregado";
			} else{
				// $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
				//mensaje cuando no se pudo insertar
				echo "error de duplicidad";
			}
		} else {
			// $errors []= "Error desconocido.";
			echo "otro error";

		}
		
?>