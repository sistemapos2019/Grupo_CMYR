<?php

	
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $mod_id = $_REQUEST['mod_id'];
		 $aColumns = array('prod.nombre', 'cat.nombre');//Columnas de busqueda
		 $sTable = "detalleorden det, producto prod, categoria cat";
		 $sWhere = "WHERE det.idProducto=prod.id and prod.idCategoria=cat.id and det.idOrden=$mod_id";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ") and det.idProducto=prod.id and prod.idCategoria=cat.id and det.idOrden=$mod_id";
		}
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './modificar_orden.php';
		//main query to fetch the data
		$sql="SELECT det.*, prod.nombre as producto, prod.preparado, cat.nombre as categoria FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
            <table class="table">
			  <tr class="headings" style="width: 20%">
					<th>Id</th>
					<th>Nombre</th>
                    <th>Tipo</th>
                	<th>Categoría</th>
					<th>Precio</th>
					<th>Cantidad</th>
					<th style="width: 36px;"></th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_producto=$row['idProducto'];
				    $producto=$row['producto'];
				    $cantidad=$row['cantidad'];
					$cantidad=number_format($cantidad);
					$precio=$row['precioUnitario'];
					$precio=number_format($precio,2);
					$preparado=$row['preparado'];
					$categoria=$row['categoria'];
					if ($preparado==1){
						$preparado="Preparado";
					}else {
						$preparado="Rápido";}

					?>
					<tr>
						<td><?php echo $id_producto; ?></td>
						<td><?php echo $producto; ?></td>
						<td ><?php echo $preparado; ?></td>
						<td><?php echo $categoria;?></td>
						<td><?php echo $precio;?></td>
						
						<td class='col-xs-1'>
							<div class="pull-right">
								<input type="number" class="nice-number"  id="cantidad_<?php echo $id_producto; ?>" min="0" max="50" value="<?php echo $cantidad; ?>">
							</div>
						</td>
						<td ><span class="pull-right"><a href="#" class="btn btn-default btn-sm" title="Actualizar" onclick="modificar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-shopping-cart"></i></a></span></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=8><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
				<script type="text/javascript">
					$(function() {
						$('input[type="number"]').niceNumber();
					});
				</script>
			  </table>
			</div>
			<?php
		}
	}
?>