<?php
include "../config/config.php"; //Contiene funcion que conecta a la base de datos
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
}
session_start();
$id_usuario = $_SESSION['user_id'];
if (isset($id)) {
    $query = mysqli_query($con, "SELECT precio from producto where id=$id");
    while ($row = mysqli_fetch_array($query)) {
        $precio = $row['precio'];
    }
}
$maxorden = mysqli_query($con, " SELECT MAX(id) FROM orden WHERE idUsuario =$id_usuario");
while ($ordenes = mysqli_fetch_array($maxorden)) {
    $idOrden = $ordenes['MAX(id)'];
}
if (!empty($idOrden) and !empty($id) and !empty($cantidad) and !empty($precio)) {
    $sqli = "insert into detalleorden (idOrden,idProducto,cantidad,precioUnitario) value (\"$idOrden\",\"$id\",\"$cantidad\",\"$precio\") ON DUPLICATE KEY UPDATE cantidad =\"$cantidad\"";
    $query = mysqli_query($con, $sqli);
}
?>
<?php

// escaping, additionally removing everything that could be (html/javascript-) code


include 'pagination.php'; //include pagination file
//pagination variables
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
$per_page = 5; //how much records you want to show
$adjacents  = 2; //gap between pages after number of adjacents
$offset = ($page - 1) * $per_page;
//Count the total number of row in your table*/
$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM detalleorden WHERE idOrden=$idOrden");
$row = mysqli_fetch_array($count_query);
$numrows = $row["numrows"];
$total_pages = ceil($numrows / $per_page);
$reload = './nueva_orden.php';
//main query to fetch the data
$sql = "SELECT * FROM  detalleorden WHERE idOrden=$idOrden LIMIT $offset,$per_page ";
$query = mysqli_query($con, $sql);
//loop through fetched data
if ($numrows > 0) {

    ?>
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <!-- style=" width:25%" -->
            <tr class="headings" style="width: 10%">
                <th class="column-title">Cantidad</th>
                <th class="column-title">Producto</th>
                <th class="column-title">Precio unit $</th>
                <th class="column-title">Subtotal $</th>
                <th class="column-title no-link last"><span class="nobr"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_orden = $row["idOrden"];
                    $id_producto = $row["idProducto"];
                    $_cantidad = $row["cantidad"];
                    $_precioUnitario = $row["precioUnitario"];

                    $sql1 = mysqli_query($con, "select nombre from producto where id=$id_producto");
                    if ($c = mysqli_fetch_array($sql1)) {
                        $producto = $c['nombre'];
                    }
                    $sql2 = mysqli_query($con, "select Total from dashboardprincipal where IdOrden=$id_orden");
                    if ($t = mysqli_fetch_array($sql2)) {
                        $Total = $t['Total'];
                    }
                    $precio_total = $_precioUnitario * $_cantidad;
                    ?>



                <tr class="even pointer">
                    <td style="width: 5%"><?php echo number_format($_cantidad, 0); ?></td>
                    <td><?php echo $producto; ?></td>
                    <td><?php echo $_precioUnitario; ?></td>
                    <td><?php echo number_format($precio_total, 2); ?></td>
                    <td><a href="#" onclick="eliminar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>

                </tr>
            <?php
                } //end while
                ?>
            <tr>
                <td colspan=5 style="width: 45%; padding-right:20px; font-size: 16px"><span class="pull-right"><strong>TOTAL:  $<?php echo number_format($Total, 2); ?></strong></span></td>

            </tr>
            <tr>
                <td colspan=5><span class="pull-right">
                        <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                    </span></td>
            </tr>
    </table>
    </div>
    <script>
        //al agregar poductos se hace visible el div para insertar comentario y finalizar orden
        document.getElementById('insertar_coment').style.display='block';
    </script>
<?php
} else {
    ?>
    <script>
        //al agregar poductos se hace visible el div para insertar comentario y finalizar orden
        document.getElementById('insertar_coment').style.display='none';
    </script>
<?php
}

?>