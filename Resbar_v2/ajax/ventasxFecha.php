<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos

// metodo para mostrar y buscar por fechas
$query = "SELECT * FROM orden WHERE estado='cc' AND ";
if($_POST["is_date_search"] == "yes")
{
 $query .= 'fecha BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" ORDER BY id asc ';


// if(isset($_POST["search"]["value"]))
// {
//  $query .= '
//   (id LIKE "%'.$_POST["search"]["value"].'%" 
//   OR idUsuario LIKE "%'.$_POST["search"]["value"].'%" 
//   OR fecha LIKE "%'.$_POST["search"]["value"].'%"
//   OR total LIKE "%'.$_POST["search"]["value"].'%")
//  ';
// }

// if(isset($_POST["order"]))
// {
//  $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
//  ';
// }


// $query1 = '';

// if($_POST["length"] != -1)
// {
//  $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
// }


// $number_filter_row = mysqli_num_rows(mysqli_query($con, $query));

// $result = mysqli_query($con, $query . $query1);

?>
<table class="table table-striped jambo_table bulk_action">
<thead>
<tr class="headings" style="width: 10%">
<th class="column-title">Orden</th>
<th class="column-title">Cliente</th>
<th class="column-title">Mesero</th>
<th class="column-title">Tipo</th>
<th class="column-title">Fecha</th>
<th class="column-title">Subtotal $</th>
<th class="column-title">Propina $</th>
<th class="column-title">Total $</th>
</tr>
</thead>
<tbody>
<?php
            $totalDiario=0;
            @$result =  mysqli_query($con, $query);
            while(@$row = mysqli_fetch_array(@$result)){
            
      
    $orden=$row['id'];

		$idUsuario=$row['idUsuario'];
		$meseros = mysqli_query($con, "SELECT nombreCompleto from usuario where id=$idUsuario");
		if ($mes = mysqli_fetch_array($meseros)) {
			$mesero = $mes['nombreCompleto'];
		}

		$cliente = $row['cliente'];
		
		$llevar=$row['llevar'];
		if($llevar=="0"){
			$tipo='Aquí';
		}
		if($llevar=="1"){
			$tipo='Llevar';
		}
		$fecha = $row['fecha'];
		$subtotal = $row['total'];
        $propina = $row['propina'];
        $total= $subtotal + $propina;
       
		?>
		<tr>
			<td><?php echo $orden;?></td>
			<!-- <td style="width: 13%"><?php echo $cliente;?></td> -->
			<td><?php echo $cliente;?></td>
			<td><?php echo $mesero;?></td>
			<td><?php echo $tipo;?></td>
			<td><?php echo $fecha;?></td>
			<td><?php echo $subtotal;?></td>
			<td><?php echo $propina;?></td>
			<td><?php echo number_format(($total),2);?></td>
			
			</tr>
			</tbody>		
		<?php
		 $totalDiario= number_format(($totalDiario + $total),2);
	} //end while
    ?>
    <tr>
    <td colspan="8" style="width: 45%; padding-right:10px; font-size: 16px"><span class="pull-right"><strong>Total de ventas: <?php echo "$".$totalDiario; ?> </strong></span></td>
    </tr>
    </table>
<?php  
} else {
    ?>
    
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        ¡Seleccione el Rango de fechas para mostrar las ventas!
    </div>
<?php
}
?>