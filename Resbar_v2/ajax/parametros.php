<?php
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         
        //obtener todos los parametros excepto el 12 porque no hay login en cada pantalla
        $sTable = "parametro";
        // $sWhere =" order by id asc";
        $sWhere =" where id!=12 order by id asc";
        //Count the total number of row in your table*/
        $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $reload = './parametros.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere";
        
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                </thead>
                <tbody>
                <?php 
                           while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $nombre=$r['nombre'];
                            $valor=$r['valor'];

                ?>
                    
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $nombre;?>" id="nombre<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $valor;?>" id="valor<?php echo $id;?>">

                    <tr class="even pointer">
                        <td><?php echo $nombre;?></td>
                        <td><?php echo $valor;?></td>
                        <td><span class="pull-right">
                        <a href="#" class='btn btn-default btn-sm' title='Editar parámetro' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a></span></td>
                    </tr>
                <?php
                    } //end while
                ?>
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos que mostrar
            </div>
        <?php    
        }
    }
?>