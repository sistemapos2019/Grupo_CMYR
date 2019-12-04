<?php
	include "../config/config.php";//Contiene funcion que conecta a la base de datos

	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from categoria where id='".$id_del."'");
        $count=mysqli_num_rows($query);

        foreach ($query as $c) {
            $nombre=$c['nombre'];
        }
        
        //Datos para insertar en tabla bitacora
        $id_usuario=$_SESSION['user_id'];
        $create_bitacora="NOW()";
        $suceso="Eliminó la categoria $nombre con id $id_del";
        //Sentencia para insertar bitacora
        $sql_bitacora="insert into bitacora (idUsuario,fecha,suceso) value ($id_usuario,$create_bitacora, \"$suceso\")";

        if ($delete1=mysqli_query($con,"DELETE FROM categoria WHERE id='".$id_del."'")){
            $insertar_bitacora = mysqli_query($con, $sql_bitacora);

            echo "eliminado";

        }else {
            echo "error";
        
        } //end else
    } //end if
    ?>
<?php
    if($action == 'ajax'){
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('nombre');//Columnas de busqueda
         $sTable = "categoria";
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
        $reload = './categorias.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <!-- style=" width:25%" -->
                    <tr class="headings" style="width: 20%">
                        <th class="column-title">Id</th>
                        <th class="column-title">Categoria</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                           while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $categoria=$r['nombre'];
                ?>
                    
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $categoria;?>" id="categoria<?php echo $id;?>">

                    <tr class="even pointer">
                    <td style="width: 20%"><?php echo $id;?></td>
                        <td style="width: 20%"><?php echo $categoria;?></td>
                        <td style="width: 20%"><span class="pull-left">
                        <a href="#" class='btn btn-default' title='Editar categoria' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a> 
                        <a href="#" class='btn btn-default' title='Eliminar categoria' onclick="alertaEliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                <?php
                    } //end while
                ?>
                <tr>
                    <td colspan=3><span class="pull-right">
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