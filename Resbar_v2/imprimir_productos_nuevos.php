<?php
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
include "config/config.php";
session_start();
//impresora
$connector = new WindowsPrintConnector("POS-80C");
$printer = new Printer($connector);
//obtener todos los parametros
$sql="SELECT * FROM  parametro";
$query = mysqli_query($con, $sql);

while ($r=mysqli_fetch_array($query)) {
  //separar los valores de los parametros a utilizar
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
      $imprimir_preparados=$valor;
  }

  if ($id==9) {
      $imprimir_rapidos=$valor;
  }

  if ($id==10) {
      $tiempo_rapidos=$valor;
  }

  if ($id==11) {
      $tiempo_preparados=$valor;
  }
}

//Obtener id de la orden y comentario
$idOrden=intval($_POST['numeroOrden']);

$comentario=$_POST['comentario'];
//traer todos los datos de la orden de la vista dashboardprincipal
$orden = mysqli_query($con, "SELECT * from dashboardprincipal where IdOrden=$idOrden");
while ($row = mysqli_fetch_array($orden)) {
  $idMesa = $row['Mesa'];
  $mesero = $row['Mesero'];
  $cliente = $row['Cliente'];
  $total = $row['Total'];
  $llevar=$row['llevar'];
}

//Obtener productos del arreglo que se encuentra en session y ver si trae productos preparados
if(isset($_SESSION['ticketampliados'])):
  $i=0;
  $numrowsPre = 0;
  foreach (@$_SESSION['ticketampliados'] as $key) {
      $pre=explode("||", @$key);
      $id = $pre[0];
  //comprobar si hay productos preparados en el arreglo
  $count_preparados=mysqli_query($con,"SELECT count(nombre) as numrowsPre from producto where id=$id and preparado=1");
  $rowPre=mysqli_fetch_array($count_preparados);
  $numrowsPre=$numrowsPre + $rowPre['numrowsPre'];

  $i++;
  }
endif;

//Imprimir productos preparados cuando la orden es para comer aqui
if (($imprimir_preparados=="SI") && ($llevar=="0") && ($numrowsPre>0)) {
  $mesas=mysqli_query($con,"SELECT mesa from mesa WHERE id=$idMesa");
  while($m=mysqli_fetch_array($mesas)){
      $mesa=$m['mesa'];
  }

  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text("Productos Preparados Extra Orden para Comer Aquí" . "\n");
  $printer->text("        " ."         " . "\n");
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text("Orden: " . $idOrden .  "\n");
  $printer->text("Mesa: " . $mesa. "\n");
  $printer->text("Mesero: " . $mesero. "\n");
  $printer->text("Cliente: " . $cliente. "\n");
  $printer->text("Tiempo preparación: " . $tiempo_preparados." minutos" . "\n");
  $printer->text("Fecha: " . date('d/m/Y g:ia') . "\n");
  $printer->feed(1);
  $printer->text("Cant." ."  Producto          " ."\n");
  $printer->text("-----------------------------------------------" ."\n");

  //Obtener productos del arreglo que se encuentra en session
  if(isset($_SESSION['ticketampliados'])):
    $i=0;
    foreach (@$_SESSION['ticketampliados'] as $key) {
        $p=explode("||", @$key);
        $idProducto = $p[0];
        $cantidad = $p[1];
    //filtrar los productos preparados que vienen en el arreglo
    $preparados=mysqli_query($con,"SELECT nombre from producto where id=$idProducto and preparado=1");

    while($pre=mysqli_fetch_array($preparados)){
      $nomProducto=$pre['nombre'];

      $printer->text(number_format($cantidad)."     ". $nomProducto. "\n");
      $printer->text("-----------------------------------------------" ."\n");
    }
    $i++;
    }
  endif;

  $printer->text("Comentario : " . $comentario. "\n");
  $printer->text("        " ."         " . "\n");
  
  //generar codigo de barra
  $printer->setJustification(Printer::JUSTIFY_CENTER);

  $standards = array (
   
    Printer::BARCODE_CODE39 => array (
           
            "example" => array (
                  
                    array (
                           
                            "content" => "*PRE $idOrden*"
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

}

//Obtener productos del arreglo que se encuentra en session y ver si trae productos rapidos
if(isset($_SESSION['ticketampliados'])):
  $j=0;
  $numrowsRap = 0;
  foreach (@$_SESSION['ticketampliados'] as $key) {
      $rap=explode("||", @$key);
      $idP = $rap[0];
  //comprobar si hay productos rapidos en el arreglo
  $count_rapidos=mysqli_query($con,"SELECT count(nombre) as numrowsRap from producto where id=$idP and preparado=0");
  $rowRap=mysqli_fetch_array($count_rapidos);
  $numrowsRap=$numrowsRap + $rowRap['numrowsRap'];

  $j++;
  }
endif;

//Imprimir productos rapidos cuando la orden es para comer aqui
if (($imprimir_rapidos=="SI") && ($llevar=="0") && ($numrowsRap>0)) {

  $mesas=mysqli_query($con,"SELECT mesa from mesa WHERE id=$idMesa");
  while($m=mysqli_fetch_array($mesas)){
      $mesa=$m['mesa'];
  }

  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text("Productos Rápidos Extra Orden para Comer Aquí" . "\n");
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text("Orden: " . $idOrden .  "\n");
  $printer->text("Mesa : " . $mesa. "\n");
  $printer->text("Mesero : " . $mesero. "\n");
  $printer->text("Cliente : " . $cliente. "\n");
  $printer->text("Tiempo entrega : " . $tiempo_rapidos. " minutos" . "\n");
  $printer->text("Fecha : " . date('d/m/Y g:ia') . "\n");
  $printer->feed(1);
  $printer->text("Cant." ."  Producto          " ."\n");
  $printer->text("-----------------------------------------------" ."\n");

  //Obtener productos del arreglo que se encuentra en session
  if(isset($_SESSION['ticketampliados'])):
    $i=0;
    foreach (@$_SESSION['ticketampliados'] as $key) {
        $p=explode("||", @$key);
        $idProducto = $p[0];
        $cantidad = $p[1];
    //filtrar los productos preparados q vienen en el arreglo
    $rapidos=mysqli_query($con,"SELECT nombre from producto where id=$idProducto and preparado=0");

    while($rap=mysqli_fetch_array($rapidos)){
      $nomProducto=$rap['nombre'];

      $printer->text(number_format($cantidad)."     ". $nomProducto. "\n");
      $printer->text("-----------------------------------------------" ."\n");
    }

    $i++;
    }
  endif;

  $printer->text("Comentario : " . $comentario. "\n");
  $printer->text("        " ."         " . "\n");
  
  //generar codigo de barra
  $printer->setJustification(Printer::JUSTIFY_CENTER);

  $standards = array (
   
    Printer::BARCODE_CODE39 => array (
           
            "example" => array (
                  
                    array (
                           
                            "content" => "*RAP $idOrden*"
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

}

//Imprimir todos los productos como preparados cuando la orden es para llevar
if (($imprimir_preparados=="SI") && ($llevar=="1")) {

  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text("Productos Extra Orden Para Llevar" . "\n");
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text("Orden: " . $idOrden .  "\n");
  $printer->text("Mesero : " . $mesero. "\n");
  $printer->text("Cliente : " . $cliente. "\n");
  $printer->text("Tiempo entrega : " . $tiempo_preparados. " minutos" . "\n");
  $printer->text("Fecha : " . date('d/m/Y g:ia') . "\n");
  $printer->feed(1);
  $printer->text("Cant." ."  Producto          " ."\n");
  $printer->text("-----------------------------------------------" ."\n");

  //Obtener nombre y cantidad de todos los productos del arreglo que se encuentra en session
  if(isset($_SESSION['ticketampliados'])):
    $i=0;
    foreach (@$_SESSION['ticketampliados'] as $key) {
      $p=explode("||", @$key);
      $cantidad = $p[1];
      $nomProducto = $p[2];

      $printer->text(number_format($cantidad)."     ". $nomProducto. "\n");
      $printer->text("-----------------------------------------------" ."\n");

    $i++;
    }
  endif;

  $printer->text("Comentario : " . $comentario. "\n");
  $printer->text("        " ."         " . "\n");
  
  //generar codigo de barra
  $printer->setJustification(Printer::JUSTIFY_CENTER);

  $standards = array (
   
    Printer::BARCODE_CODE39 => array (
           
            "example" => array (
                  
                    array (
                           
                            "content" => "*PRE $idOrden*"
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
}
?>
