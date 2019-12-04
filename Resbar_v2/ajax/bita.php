<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos
$columns = array('id','idUsuario', 'fecha', 'suceso');

//metodo para eliminar bitacoras

$type=$_POST['type'];
if($type=="delete"){
$sql=("TRUNCATE TABLE bitacora");
$query = mysqli_query($con, $sql);
 }
   
?>