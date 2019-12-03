<?php	
	session_start();

		if (!empty($_POST['mod_tipo'])) {
			
			include "../config/config.php";//Contiene funcion que conecta a la base de datos

			//Datos a modificar de la orden
			$id = $_POST['mod_id'];
			$tipo=$_POST["mod_tipo"];
			$cliente=$_POST["mod_cliente"];
			if($tipo=="aqui"){
				$idtipo=0;
				$estado="aa";
				$idmesa = $_POST["mod_mesa"];
				$sql="update orden set idMesa=\"$idmesa\", llevar=\"$idtipo\", estado=\"$estado\", cliente=\"$cliente\" where id=$id";
			
			}
			if($tipo=="llevar"){
				$idtipo=1;
				$estado="cp";
				$sql="update orden set llevar=\"$idtipo\", estado=\"$estado\", cliente=\"$cliente\" where id=$id";
			}
			
			//Datos para insertar en tabla bitacora
			$id_usuario=$_SESSION['user_id'];
			$create_bitacora="NOW()";
			$suceso="Modificó los datos de la orden del cliente $cliente con id $id";

			//Sentencia para insertar bitacora
			$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

			$query_update = mysqli_query($con,$sql);

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