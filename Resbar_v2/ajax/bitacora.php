<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos
$columns = array('id','idUsuario', 'fecha', 'suceso');

// metodo para mostrar y buscar por fechas
$query = "SELECT * FROM bitacora WHERE ";
if($_POST["is_date_search"] == "yes")
{
 $query .= 'fecha BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (id LIKE "%'.$_POST["search"]["value"].'%" 
  OR idUsuario LIKE "%'.$_POST["search"]["value"].'%" 
  OR fecha LIKE "%'.$_POST["search"]["value"].'%"
  OR suceso LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id desc ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$number_filter_row = mysqli_num_rows(mysqli_query($con, $query));

$result = mysqli_query($con, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $fecha=$row["fecha"];			
 $sub_array = array();
 $sub_array[] = $row["id"];
 $idUsuario= $row["idUsuario"];
 $sql = mysqli_query($con, "select nombreCompleto from usuario where id=$idUsuario");
 if($c=mysqli_fetch_array($sql)) {
 $sub_array[] =$c["nombreCompleto"];
 }
 $sub_array[] = $row["fecha"];
 $sub_array[] = $row["suceso"];
 
 $data[] = $sub_array;
}

function get_all_data($con)
{
 $query = "SELECT * FROM bitacora";
 $result = mysqli_query($con, $query);
 return mysqli_num_rows($result);
}


$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($con),
 "recordsFiltered" => $number_filter_row,
 "data" => $data
);

echo json_encode($output);

?>