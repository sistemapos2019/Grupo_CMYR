<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5; //how much records you want to show
    $adjacents  = 2; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Capturar fecha actual
	date_default_timezone_set('America/Mexico_city');
	$fecha_actual=DATE("Y-m-d");

	//$sql=mysqli_query($con, "SELECT * FROM orden where estado='cc' and fecha= '$fecha_actual'  order by id asc");

    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM orden WHERE estado='cc' and fecha= '$fecha_actual'");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row["numrows"];
    $total_pages = ceil($numrows / $per_page);
    $reload = './ventasDiarias.php';
    //main query to fetch the data
    $sql = "SELECT * FROM orden where estado='cc' and fecha= '$fecha_actual'  order by id asc LIMIT $offset,$per_page ";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {

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
	while ($row=mysqli_fetch_array($query)){
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
		$subtotal = $row['total'];
		$propina = $row['propina'];
		$total= $subtotal + $propina;
		
	
		?>
		<tr>
			<td><?php echo $orden;?></td>
			<td><?php echo $cliente;?></td>
			<td><?php echo $mesero;?></td>
			<td><?php echo $tipo;?></td>
			<td><?php echo $fecha_actual;?></td>
			<td><?php echo $subtotal;?></td>
			<td><?php echo $propina;?></td>
			<td><?php echo number_format(($total),2);?></td>
			
			</tr>
			</tbody>		
		<?php
		 $totalDiario= number_format(($totalDiario + $total),2);
	}

?>
<tr>
<td colspan="8" style="width: 45%; padding-right:10px; font-size: 16px"><span class="pull-right"><strong>Ventas diarias: <?php echo "$".$totalDiario; ?> </strong></span></td>
</tr>
<!-- <tr>
    <td colspan=8><span class="pull-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </span></td>
</tr> -->
</table>
<?php
    } else {
        ?>
        
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            ¡No existen ventas que mostrar este día!
        </div>
    <?php
    }
}
?>