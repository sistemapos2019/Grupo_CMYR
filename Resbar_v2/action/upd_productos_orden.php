<?php	
	session_start();

	if (isset($_POST['id']) &&
	    isset($_POST['cantidad']) &&
	    isset($_POST['numeroOrden'])
    ){
			
		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		//datos del producto a modificar
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];
        $numeroOrden = $_POST['numeroOrden'];

        $sql = "UPDATE detalleorden set cantidad=$cantidad where idOrden=$numeroOrden and idProducto=$id";
        echo $sql;
        $query_update = mysqli_query($con, $sql);

    }
		
?>