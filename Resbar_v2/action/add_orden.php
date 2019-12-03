<?php	
	session_start();

		// $sqlmesa="select id from mesa where mesa = (\"$mesa\")";
		// $idmesa=mysqli_query($con,$sqlmesa);
		// $usuario=$_POST["usuario"];
		// $sqlusuario="select id from usuario where nombreCompleto = (\"$usuario\")";

		if (!empty($_POST['tipo'])) {
			
			include "../config/config.php";//Contiene funcion que conecta a la base de datos

			//Datos de la nueva orden
			$idusuario=$_SESSION['user_id'];
			$tipo=$_POST["tipo"];
			$cliente=$_POST["cliente"];
			// $fecha="NOW()";
			date_default_timezone_set('America/Mexico_city');
			$fecha=date("Y-m-d H:i:s");
			if($tipo=="aqui"){
				$idtipo=0;
				$estado="aa";
				$idmesa = $_POST["mesa"];
				$sql="insert into orden (idMesa,idUsuario,fecha,llevar,estado,cliente) value (\"$idmesa\", \"$idusuario\", \"$fecha\",\"$idtipo\", \"$estado\", \"$cliente\")";
			}
			if($tipo=="llevar"){
				$idtipo=1;
				$estado="cp";
				$sql="insert into orden (idUsuario,fecha,llevar,estado,cliente) value (\"$idusuario\", \"$fecha\",\"$idtipo\", \"$estado\", \"$cliente\")";
			}

			$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$id_orden = mysqli_insert_id($con);
				echo $id_orden;

				//Datos para insertar en tabla bitacora
				$create_bitacora="NOW()";
				$suceso="Creó la orden del cliente $cliente con id $id_orden";

				//Sentencia para insertar bitacora
				$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($idusuario,$create_bitacora, \"$suceso\")";
				$insertar_bitacora = mysqli_query($con, $sql_bitacora);
				// $messages[] = "Mesa agregada satisfactoriamente.";
				// echo "agregada";
			} else{
				
				// echo "Lo siento algo ha salido mal intenta nuevamente. ".mysqli_error($con);
				// echo "error";
			}

		}
		//$idorden=$_POST['resultorden'];
		

		// $idtipo=$_POST["tipo"];
		
				
			
		
		
		
		
		
?>