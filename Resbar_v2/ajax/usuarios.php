<?php
    session_start();
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from usuario where id='".$id_del."'");
        $count=mysqli_num_rows($query);

        foreach ($query as $u) {
            $nombre=$u['nombreCompleto'];
        }

        //Datos para insertar en tabla bitacora
        $id_usuario=$_SESSION['user_id'];
        $create_bitacora="NOW()";
        $suceso="Eliminó al usuario $nombre con id $id_del";
        //Sentencia para insertar bitacora
        $sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";
        if ($delete1=mysqli_query($con,"DELETE FROM usuario WHERE id='".$id_del."'")){
            $insertar_bitacora = mysqli_query($con, $sql_bitacora);

            echo 1;

        }else {
            echo 0;
        
        } //end else
    } //end if
?>

<?php
    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('nombreCompleto', 'login');//Columnas de busqueda
         $sTable = "usuario";
         $sWhere = "";
        if ( $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        $sWhere.=" order by id asc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 4; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './usuarios.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <!-- style=" width:25%" -->
                    <tr class="headings" style=" width:40%" >
                        <th class="column-title">Nombre </th>
                        <th class="column-title">Usuario</th>
                        <th class="column-title">Rol</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                   while ($r=mysqli_fetch_array($query)) {
                    $id=$r['id'];
                    $nombre=$r['nombreCompleto'];
                    $usuario=$r['login'];
                    $pin=$r['pin'];
                    $rol=$r['rol'];
                    if ($rol=='G'){$rol="Gerente";}else {$rol="Mesero";}
                          
                ?>
                    
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $nombre;?>" id="nombre<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $usuario;?>" id="usuario<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $pin;?>" id="pin<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $rol;?>" id="rol<?php echo $id;?>">

                    

                    <tr class="even pointer">
                     
                        <td style="width: 20%"><?php echo $nombre;?></td>
                        <td style="width: 20%"><?php echo $usuario;?></td>
                        <td style="width: 20%"><?php echo $rol;?></td>


                        <td style="width: 20%"><span class="pull-left">
                        <a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a> 
                        <a href="#" class='btn btn-default' title='Eliminar usuario' onclick="alertaEliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                <?php
                    } //end while
                ?>
                <tr>
                    <td colspan=4><span class="pull-right">
                        <?php echo paginate($reload, $page, $total_pages, $adjacents);?>
                    </span></td>
                </tr>
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