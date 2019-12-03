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

  }

  //Obtener id de la orden y datos para factura
  $idOrden=intval($_POST['idOrden']);
  $cliente=($_POST['cliente']);
  $mesero=($_POST['mesero']);
  $efectivo=($_POST['efectivo']);
  $subtotalOrden=($_POST['subtotalOrden']);
  $propina=($_POST['propina']);
  $totalOrden=($_POST['total']);
  $cambio=($_POST['cambio']);

  //traer todos los datos de la orden de la vista dashboardprincipal
  // $orden = mysqli_query($con, "SELECT * from dashboardprincipal where IdOrden=$idOrden");
  // while ($row = mysqli_fetch_array($orden)) {
  //   $mesero = $row['Mesero'];
  //   $cliente = $row['Cliente'];
  // }

  //Imprimir factura
  //Datos del negocio al centro
  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text($nombre. "\n");
  $printer->text($descripcion. "\n");
  $printer->text($direccion. "\n");
  $printer->text("Tel: " . $telefono. "\n");
  $printer->text("NIT: " . $nit. "\n");
  $printer->text("Giro: " . $giro . "\n");
  //datos de la orden a la izquierda
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text("Orden: " . $idOrden .  "\n");
  $printer->text("Atendido por: " . $mesero. "\n");
  $printer->text("Cliente: " . $cliente. "\n");
  $printer->text("Fecha: " . date('d/m/Y g:ia') . "\n");
  $printer->feed(1);
  //detalle de los productos de la orden
  $printer->text("Cant." ."  Producto            "."    P.unit"."     SubTot" ."\n");
  $printer->text("------------------------------------------------" ."\n");

  //obtener cantidad, nombre y precio unitario de todos los productos
  $productos=mysqli_query($con,"SELECT d.cantidad, d.precioUnitario, p.nombre from detalleorden d, producto p where d.idProducto=p.id and d.idOrden=$idOrden");

  while($prod=mysqli_fetch_array($productos)){
    $cantidad=$prod['cantidad'];
    $nomProducto=$prod['nombre'];
    $precioUnitario=$prod['precioUnitario'];
    $subTotal = $precioUnitario * $cantidad;

    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text(number_format($cantidad)."     ". $nomProducto. "\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text((number_format(($precioUnitario),2))."       ".(number_format(($subTotal),2)). "\n");
    $printer->text("------------------------------------------------" ."\n");
  }

  $printer->setJustification(Printer::JUSTIFY_RIGHT);
  $printer->text("Total:   $" . $subtotalOrden .  "\n");

  $printer->text("Propina:   $" . (number_format(($propina),2)) . "\n");
  $printer->text("Total a pagar:   $" . (number_format(($totalOrden),2)) .  "\n");
  //falta traer el efectivo y calcular el cambio
  $printer->text("Efectivo:  $" . (number_format(($efectivo),2)) . "\n");
  $printer->text("Cambio:  $" . (number_format(($cambio),2)) . "\n");
  $printer->text("        " ."         " . "\n");
  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text("¡¡¡MUCHAS GRACIAS POR SU COMPRA!!!" . "\n");
  $printer->text("        " ."         " . "\n");
  
  $printer->feed(4);
  $printer->cut();
  $printer->close();

?>
