<?php
    session_start();
    include "../config/config.php"; //Contiene funcion que conecta a la base de datos

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
    if (isset($_GET['id'])) {
        $id_del = intval($_GET['id']);
        $query = mysqli_query($con, "SELECT * from orden where id='" . $id_del . "'");
        $query_detalle = mysqli_query($con, "SELECT * from detalleorden where id='" . $id_del . "'");
        $count = mysqli_num_rows($query);

        foreach ($query as $orden) {
                $cliente=$orden['cliente'];
        }

        //Datos para insertar en tabla bitacora
        $id_usuario=$_SESSION['user_id'];
        $create_bitacora="NOW()";
        $suceso="Eliminó la orden del cliente $cliente con id $id_del";
        //Sentencia para insertar bitacora
        $sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

        if ($delete1 = mysqli_query($con, "DELETE FROM orden WHERE id='" . $id_del . "'")) {
            $insertar_bitacora = mysqli_query($con, $sql_bitacora);

            echo "eliminado";

        }else {
            echo "error";
        
        } //end else
    } //end if
?>
<?php
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('IdOrden', 'Mesa', 'Mesero', 'Cliente'); //Columnas de busqueda
    $sTable = "dashboardprincipal";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by  IdOrden asc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './dashboard.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        ?>
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <!-- style=" width:25%" -->
                <tr class="headings" style=" width:2%">
                    <th class="column-title">Orden </th>
                    <th class="column-title">Mesa </th>
                    <th class="column-title">Mesero </th>
                    <th class="column-title">Cliente </th>
                    <th class="column-title">Total $ </th>
                    <th class="column-title">Rápido </th>
                    <th class="column-title">Preparado </th>
                    <th class="column-title">Tipo </th>
                    <th class="column-title no-link last"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($r = mysqli_fetch_array($query)) {
                        $orden = $r['IdOrden'];
                        $mesa = $r['Mesa'];
                        $mesero = $r['Mesero'];
                        $cliente = $r['Cliente'];
                        $total = $r['Total'];
                        $llevar=$r['llevar'];
                        $rapido = $r['Rapido'];
                        $preparado = $r['Preparado'];

                        if($llevar=="0"){
                            $llevar='aqui';
                            $mesa = $r['Mesa'];

                            if ($rapido=='VERDE'){
                            $rapido="green";
                            $styler="width: 100%";
                            }
                            if($rapido=='AMARILLO'){
                                    $rapido="yellow";
                                    $styler="width: 100%";
                            }
                            if($rapido=='ROJO'){
                                $rapido="red";
                                $styler="width: 100%";

                            }

                            if($rapido==NULL){
                                $rapido="aqua";
                                $styler="width: 0%";

                            }

                            if ($preparado=='VERDE'){
                                $preparado="green";
                                $stylep="width: 100%";
                            }

                            if($preparado=='AMARILLO'){
                                $preparado="yellow";
                                $stylep="width: 100%";
                            }

                            if($preparado=='ROJO'){
                                $preparado="red";
                                $stylep="width: 100%";
                            }
                            if($preparado==NULL){
                                $preparado="aqua";
                                $stylep="width: 0%";
                            }

                        }else{
                            $llevar='llevar';
                            $mesa="";

                            $rapido="aqua";
                            $styler="width: 0%";

                            if ($preparado=='VERDE'){
                                $preparado="green";
                                $stylep="width: 100%";
                            }

                            if($preparado=='AMARILLO'){
                                $preparado="yellow";
                                $stylep="width: 100%";
                            }

                            if($preparado=='ROJO'){
                                $preparado="red";
                                $stylep="width: 100%";
                            }
                            if($preparado==NULL){
                                $preparado="aqua";
                                $stylep="width: 0%";
                            }
                        }

                        $ordenes = mysqli_query($con, "SELECT fecha from orden where id=$orden");
                        if ($ord = mysqli_fetch_array($ordenes)) {
                            $fecha = $ord['fecha'];
                        }

                        

                        
       
                        $tipo=$r['tipo'];
                        if($tipo=='AQUI'){
                            $tipo="cutlery";
                        }
                        if($tipo=='LLEVAR'){
                            $tipo="shopping-cart";
                        }
                    ?>
                
                    <input type="hidden" value="<?php echo $orden; ?>" id="orden<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $llevar; ?>" id="llevar<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $mesa; ?>" id="mesa<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $mesero; ?>" id="mesero<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $cliente; ?>" id="cliente<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $total; ?>" id="total<?php echo $orden; ?>">
                    <input type="hidden" value="<?php echo $fecha; ?>" id="fecha<?php echo $orden; ?>">

                    <tr class="even pointer">
                        <td style="width: 5%"><?php echo $orden; ?></td>
                        <td style="width: 5%"><?php echo $mesa; ?></td>
                        <td style="width: 10%"><?php echo $mesero; ?></td>
                        <td style="width: 10%"><?php echo $cliente; ?></td>
                        <td style="width: 10%"><?php echo $total; ?></td>
                        <td style="width: 5%">
                        <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-<?php echo $rapido?>" style="<?php echo $styler?>">
                        </div>
                        </div>
                        </td>
                        <td style="width: 5%; text-align:center">
                        <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-<?php echo $preparado?>" style="<?php echo $stylep?>">
                        </div>
                        </div>
                        </td>
                        <td style="width: 5%"><i class="glyphicon glyphicon-<?php echo $tipo?>"></i></td>
                        
                        <td style="width: 15%">
                            <span class="pull-left">
                                <a href="./ampliar_orden.php?idOrden=<?php echo $orden; ?>" class="btn btn-default btn-sm" title="Agregar Productos a Orden" onclick=""><i class="glyphicon glyphicon-plus"></i></a>
                                <a href="./modificar_orden.php?orden=<?php echo $orden; ?>" class="btn btn-default btn-sm" title="Modificar orden" onclick=""><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="./cobrar_orden.php?ordenCobrar=<?php echo $orden; ?>" class="btn btn-default btn-sm" title="Cobrar orden" onclick=""><i class="glyphicon glyphicon-usd"></i></a>
                                <a href="#" class="btn btn-default btn-sm" title="Eliminar orden" onclick="alertaEliminar('<?php echo $orden; ?>');" data-toggle="modal" data-target="#modal-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                
                            </span>
                        </td>
                    </tr>

                <?php
                        } //end while
                        ?>
                <tr>
                     <td colspan=9><span class="pull-right">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span></td>
                </tr>
        </table>
        </div>
    <?php
        } else {
            ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> No existen ordenes activas actualmente</strong>
        </div>
<?php
    }
}
?>