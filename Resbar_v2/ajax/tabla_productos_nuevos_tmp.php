<?php
session_start();
// Dibujar tabla con productos temporales
// print_r($_SESSION['tablaproductosnuevos']);
if(isset($_SESSION['tablaproductosnuevos'])){

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
            $total=0;
                    $i=0;
                    foreach (@$_SESSION['tablaproductosnuevos'] as $key) {
                        $d=explode("||", @$key);
            ?>

            <tr class="even pointer">
            <td style="width: 5%"><?php echo number_format($d[1])?></td>
 		        <td><?php echo $d[2] ?></td>
                <td><?php echo $d[3] ?></td>
                <td><?php echo number_format($d[1]*$d[3],2) ?></td>
                <td>
                <span class="btn btn-default btn-xs" onclick="quitarp('<?php echo $i; ?>')">
 				<span class="glyphicon glyphicon-trash"></span>
                  </span>
                    </td>
                <!-- <td><a href="#" onclick=""><i class="glyphicon glyphicon-trash"></i></a></td> -->
            </tr>
            </tbody>
            <?php
            $total= number_format(($total + $d[1]*$d[3]),2);
            $i++;
        }
        
      
        ?>
        <tr>
            <td colspan="5" style="width: 45%; padding-right:20px; font-size: 16px"><span class="pull-right"><strong>Total extra: <?php echo "$".$total; ?> </strong></span></td>
        </tr>
    </table>

    <script>
        //al agregar poductos se hace visible el div para insertar comentario y finalizar orden
        document.getElementById('insertar_coment').style.display='block';
    </script>

    <?php
    }else{
    ?>
        <script>
            //al no haber poductos se oculta el div para insertar comentario y finalizar orden
            document.getElementById('insertar_coment').style.display='none';
        </script>
    <?php
    }
    ?>