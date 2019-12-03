<?php
	session_start();

	if (isset($_POST['token']) && $_POST['token']!=='') {
			
	//Contiene las variables de configuracion para conectar a la base de datos
	include "../config/config.php";

	$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
	$password=sha1(md5(mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)))));

    $query = mysqli_query($con,"SELECT * FROM usuario WHERE login =\"$email\" AND clave = \"$password\";");

		if ($row = mysqli_fetch_array($query)) {
			
				$_SESSION['user_id'] = $row['id'];
				header("location: ../dashboard.php");
				
				//Datos para insertar en tabla bitacora
				$id_usuario=$_SESSION['user_id'];
				$create_bitacora="NOW()";
				$suceso="Ingresó al sistema";
				//Sentencia para insertar bitacora
				$sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
				$insertar_bitacora = mysqli_query($con, $sql_bitacora);

		}else{
			$invalid=sha1(md5("contrasena y email invalido"));
			header("location: ../index.php?invalid=$invalid");
		}
	}else{
		header("location: ../");
	}

?>