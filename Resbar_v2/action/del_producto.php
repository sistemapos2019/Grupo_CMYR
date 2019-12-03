<?php	
	include "../config/config.php";
	session_start();
	/*Inicia validacion del lado del servidor*/
	/*$idUsuario = $_SESSION['user_id'];
	$maxorden = mysqli_query($con," SELECT MAX(id) FROM orden WHERE idUsuario = $idUsuario");
	while($ordenes=mysqli_fetch_array($maxorden)){
		$orden=$ordenes['MAX(id)'];
	
	}*/
	
		//eliminar un producto de la orden
		$idProducto=intval($_GET['idProducto']);
		$idOrden=intval($_GET['idOrden']);
		
		$delete1=mysqli_query($con,"DELETE FROM detalleorden WHERE idOrden=$idOrden AND idProducto=$idProducto");

?>