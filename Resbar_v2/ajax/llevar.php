<?php

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_del = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * from dashboardllevar where id='" . $id_del . "'");
    $count = mysqli_num_rows($query);

    if ($delete1 = mysqli_query($con, "DELETE FROM dashboardllevar WHERE id='" . $id_del . "'")) {
        ?>
        echo "eliminado"
    <?php
        } else {
            ?>
        echo "error"
<?php
    } //end else
} //end if
?>
<?php
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code

    $sTable = "dashboardllevar";
    
    $sWhere = " order by  IdOrden asc";
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
    $reload = './llevar.php';
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
                    <th class="column-title">Cliente </th>
                    <th class="column-title">Pedido </th>
                    <th class="column-title">Tiempo(Minutos) </th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                        while ($r = mysqli_fetch_array($query)) {
                            $ordenId = $r['IdOrden'];
                            
                            // $mesero = $r['Mesero'];
                            $cliente = $r['Cliente'];
                            $total = $r['Total'];
                            $tiempo = $r['TiempoPreparado'];


                            // $rapido = $r['Preparado'];

                    //         if ($rapido=='VERDE'){
                    //             $rapido="green";
                    //             $styler="width: 100%";
                    //         }
                    //             if($rapido=='AMARILLO'){
                    //                 $rapido="yellow";
                    //                 $styler="width: 100%";
                    //         }
                    //         if($rapido=='ROJO'){
                    //             $rapido="red";
                    //             $styler="width: 100%";

                    //     }
                    //     if($rapido==NULL){
                    //         $rapido="aqua";
                    //         $styler="width: 0%";

                    // }
                            $preparado = $r['Preparado'];

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

                               
                                
                            // $tipo=$r['tipo'];
                            // if($tipo=='AQUI'){
                            //     $tipo="cutlery";
                            // }
                            // if($tipo=='LLEVAR'){
                            //     $tipo="shopping-cart";
                            // }
                            ?>


                    <tr class="even pointer">
                        <td style="width: 5%"><?php echo $ordenId; ?></td>
                        <td style="width: 10%"><?php echo $cliente; ?></td>
                        <td style="width: 5%; text-align:center">
                        <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-<?php echo $preparado?>" style="<?php echo $stylep?>">
                        </div>
                        </div>
                        </td>

                        <td style="width: 10%"><?php echo $tiempo; ?></td>
                        
                        
                        
                        
                      
                    </tr>
                <?php
                        } //end while
                        ?>
                <tr>
                     <td colspan=4><span class="pull-right">
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
             <strong>No existen ordenes para llevar actualmente</strong>
        </div>
<?php
    }
}
?>