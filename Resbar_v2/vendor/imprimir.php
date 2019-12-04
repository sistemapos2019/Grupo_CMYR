<?php
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
include "config/config.php";
session_start();
$idOrden=intval($_POST['idOrden']);
$tot = mysqli_query($con, "select Total from dashboardprincipal where IdOrden=$idOrden");
                    if ($t = mysqli_fetch_array($tot)) {
                        $Total = $t['Total'];
                    }
$datos=mysqli_query($con,"SELECT * FROM orden WHERE id=$idOrden");
while($dato=mysqli_fetch_array($datos)){
    $llevar=$dato['llevar'];
    if($llevar=="0"){
        $tipo="Comer aquí";
    }
    else{
        $tipo="llevar";
    }
    $cliente=$dato['cliente'];
    $idUsuario=$dato['idUsuario'];
    $fecha=$dato['fecha'];
    $idMesa=$dato['idMesa'];
    if($idMesa==NULL){
        $mesa=" ";
    }
    else{
        $mesas=mysqli_query($con,"SELECT mesa from mesa WHERE id=$idMesa");
        while($m=mysqli_fetch_array($mesas)){
            $mesa=$m['mesa'];
        }        
    }
}
$sql="SELECT * FROM  parametro";
$query = mysqli_query($con, $sql);
?>
 <?php 
while ($r=mysqli_fetch_array($query)) {
  $id=$r['id'];
  $parametro=$r['nombre'];
  $valor=$r['valor'];

  if ($id==2) {
      $nombre=$valor;
      //print_r($nombre);
  }

  if ($id==3) {
      $descripcion=$valor;

  }

  if ($id==4) {
      $telefono=$valor;
  }

  if ($id==5) {
      $nit=$valor;
  }

  if ($id==6) {
      $giro=$valor;
  }

  if ($id==7) {
      $direccion=$valor;
  }

  if ($id==8) {
      $preparados=$valor;
  }

  if ($id==9) {
      $rapidos=$valor;
  }
}
  
  $connector = new WindowsPrintConnector("POS-80C");
  $printer = new Printer($connector);
  
  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text( $nombre. "\n");
  $printer->text( $descripcion. "\n");
  $printer->text(  $direccion. "\n");
  $printer->text($telefono. "\n");
  $printer->text( $nit. "\n");
  $printer->text( $giro . "\n");
  $printer->setJustification(Printer::JUSTIFY_LEFT);

  $printer->text( date('d/m/Y g:ia') . "\n");
  
  $printer->text("Orden: " . $idOrden .  "\n");
  $printer->text("Cliente: " . $cliente. "\n");
  $printer->text("Tipo : " . $tipo. "\n");
  $printer->text("Mesa : " . $mesa. "\n");
  $printer->text("        " ."         " . "\n");
  $printer->text("Cnt." ."  Produc          " ."    P.unit   "."      SubTot" ."\n");

 


  $productos = mysqli_query ($con,"SELECT * FROM  detalleorden WHERE idOrden=$idOrden");
  
  while ($row = mysqli_fetch_array($productos)) {
    $id_producto = $row["idProducto"];
    $_cantidad=$row["cantidad"];
    
    $sql1 = mysqli_query($con, "select nombre from producto where id=$id_producto");
                    if ($c = mysqli_fetch_array($sql1)) {
                        $producto = $c['nombre'];
                    }
                    
                    $_precioUnitario = $row["precioUnitario"];
                    $subTotal = $_precioUnitario * $_cantidad;


    $printer->text("        " ."         " . "\n");
    $printer->text(number_format($_cantidad)."     ". $producto."           ".(number_format(($_precioUnitario),2))."  ".(number_format(($subTotal),2)). "\n");
    $printer->text("-----------------------------------------------" ."\n");
  }
  $printer->setJustification(Printer::JUSTIFY_RIGHT);
  $printer->text("Total: $" . $Total .  "\n");
  $printer->text("        " ."         " . "\n");


  
  
//   // $printer->text("-----------------------------------------------" ."\n");

//   $printer->feed(4);
//   $printer->cut();
//   $printer->close();
$printer->setJustification(Printer::JUSTIFY_CENTER);

$standards = array (
 
  Printer::BARCODE_CODE39 => array (
         
          "example" => array (
                
                  array (
                         
                          "content" => "*ORDEN  $idOrden*"
                  )
          )
  ),
 
);
$printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
foreach ($standards as $type => $standard) {
$printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
// $printer->text($standard ["title"] . "\n");
$printer->selectPrintMode();
// $printer->text($standard ["caption"] . "\n\n");
foreach ($standard ["example"] as $id => $barcode) {
  $printer->setEmphasis(true);
  // $printer->text($barcode ["caption"] . "\n");
  $printer->setEmphasis(false);
  // $printer->text("Content: " . $barcode ["content"] . "\n");
  $printer->barcode($barcode ["content"], $type);
 
}
}
$printer->feed(4);
$printer->cut();
$printer->close();



  ?>
