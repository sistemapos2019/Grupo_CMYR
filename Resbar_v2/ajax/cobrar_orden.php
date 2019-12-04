<?php
session_start();

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $numeroOrden = $_REQUEST['numeroOrden'];
    $per_page = 5; //how much records you want to show
    $adjacents  = 2; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM detalleorden WHERE idOrden=$numeroOrden");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row["numrows"];
    $total_pages = ceil($numrows / $per_page);
    $reload = './cobrar_orden.php';
    //main query to fetch the data
    $sql = "SELECT det.*, prod.nombre as producto FROM  detalleorden det, producto prod WHERE det.idOrden=$numeroOrden and det.idProducto=prod.id LIMIT $offset,$per_page ";
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
                    <th class="column-title">Subtotal $</th></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_array($query)) {
                        $id_orden = $row["idOrden"];
                        $id_producto = $row["idProducto"];
                        $_cantidad = $row["cantidad"];
                        $_precioUnitario = $row["precioUnitario"];
                        $producto = $row['producto'];
                        $subtotal = $_precioUnitario * $_cantidad;
                        ?>



                    <tr class="even pointer">
                        <td style="width: 5%"><?php echo number_format($_cantidad, 0); ?></td>
                        <td><?php echo $producto; ?></td>
                        <td><?php echo $_precioUnitario; ?></td>
                        <td><?php echo number_format($subtotal, 2); ?></td>

                    </tr>
                <?php
                    } //end while
                    //traer el total de la orden
                    $sql2 = mysqli_query($con, "select Total from dashboardprincipal where IdOrden=$numeroOrden");
                    if ($t = mysqli_fetch_array($sql2)) {
                        $Total = $t['Total'];
                    }
                ?>
                <tr>
                    <td colspan=4 style="width: 45%; padding-right:20px; font-size: 16px"><span class="pull-right"><strong>TOTAL:  $<?php echo number_format($Total, 2); ?></strong></span></td>

                </tr>
                <tr>
                    <td colspan=4><span class="pull-right">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span></td>
                </tr>
        </table>
        <script>
            //cuando la orden tiene productos se hace visible el div para cobrar orden y el boton regresar que solo lo lleva al dashboard sigue oculto
            document.getElementById('btn_cobrar').style.display='block';
        </script>
        
    <?php
    } else {
        ?>
        <script>
            //cuando la orden no tiene productos se oculta el div para cobrar orden y se muestra el boton regresar que solo lo lleva al dashboard
            document.getElementById('btn_cobrar').style.display='none';
            document.getElementById('btnRegresar').style.display='block';
            
        </script>
        
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Actualmente no hay Productos en la Orden!</strong>
        </div>
    <?php
    }
}
?>