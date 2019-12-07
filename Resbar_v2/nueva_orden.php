<?php
$title = "Nueva Orden ";
include "head.php";
include "sidebar.php";
$mesas = mysqli_query($con, "select * from mesa");
$categorias = mysqli_query($con, "select * from categoria");
$id = $_SESSION['user_id'];
$maxorden = mysqli_query($con," SELECT MAX(id) FROM orden WHERE idUsuario = $id");
while($ordenes=mysqli_fetch_array($maxorden)){
    $orden=$ordenes['MAX(id)'];

}

$datos=mysqli_query($con,"SELECT * FROM orden WHERE id=$orden");
while($dato=mysqli_fetch_array($datos)){
    $llevar=$dato['llevar'];
    if($llevar=="0"){
        $tipo="Comer aquí";
    }
    else{
        $tipo="Llevar";
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

$query = mysqli_query($con, "SELECT * from usuario where id=$idUsuario");
while ($row = mysqli_fetch_array($query)) {
    $id = $row['id'];
    $nombre = $row['nombreCompleto'];
    $rol = $row['rol'];
    
}
?>

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <!-- page content -->
        <div class="right_col" role="main">

            <!-- panel con informacion de la orden y añadir productos -->

            <div class="x_panel" style="margin-top:-1%">
                <div class="x_title">
                    <h2 style="font-size: 16px !important;">Nueva Orden</h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                            <div id="result"></div>
                            <!--Datos de la nueva orden-->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5" for="first-name">Orden </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="text" id="numeroOrden" readonly class="form-control  input-sm"  value="<?php echo $orden ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5">Tipo </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="text" name="cliente" readonly class="form-control input-sm" value="<?php echo $tipo ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5" for="first-name">Mesa </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" name="order" readonly class="form-control  input-sm" id="resultorden" value="<?php echo $mesa ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="first-name">Mesero </label>
                                    <div class="col-md-9 col-sm-9 col-xs-6">
                                        <input type="text" name="mesero" readonly class="form-control  input-sm" value="<?php echo $nombre ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5">Cliente </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" id="cliente" name="cliente" readonly class="form-control  input-sm" value="<?php echo $cliente ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5">Fecha </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" id="fecha" name="fecha" class="form-control input-sm" value="<?php echo $fecha ?>" readonly>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">

                                <span class="pull-right"><button id="btnagregar"  class="btn btn-primary" data-toggle="modal" data-target="#productos">
                                <span class="glyphicon glyphicon-plus"></span> Agregar productos</button></span>
                                <!-- aqui se exportara el modal con los productos que puede agregar a la roden -->
                                <?php
                                include("modal/productos_orden.php");
                                ?>
                        </div>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <div class="table-responsive">
                        <!-- ajax -->
                        <div class='outer_div'></div><!-- Carga los datos ajax -->
                        <!-- /ajax --> 
                        </div>   
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12" id="insertar_coment" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Comentario</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea class="form-control" rows="6" id="comentario" name="comentario" placeholder="Escribe un comentario"></textarea>
                            </div>                       
                        </div>

                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                            <span class="pull-right"><button id="btn_finalizar"  class="btn btn-primary" onclick="finalizarOrden();imprimir();">
                            <span class="glyphicon glyphicon-ok"></span> Finalizar Orden</button></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div><!-- /page content -->

<?php include "footer.php" ?>


<script>
    $(document).ready(function() {
        load(1);
        $('.outer_div').load("./ajax/agregar_pedido.php");
    });

    function load(page) {
        var q = $("#q").val();
        var parametros = {
            "action": "ajax",
            "page": page,
            "q": q
        };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido.php', 
            data: parametros,
            beforeSend: function(objeto) {
                $('#loader').html('');
            },
            success: function(data) {
                $(".otrodiv").html(data).fadeIn('slow');
                $('#loader').html('');
                $.ajax({
				type: "POST",
				url: "./ajax/agregar_pedido.php",
				data: parametros,
				beforeSend: function(objeto) {

					$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
                    $(".outer_div").html(datos).fadeIn('slow');

				}
			});

            }
        })
    }
  
    //enviar datos del producto para insertarlo directamente a la base de datos y luego mostrarlo en la tabla, el proceso se hace en ./ajax/agregar_pedido.php
	function agregar(id) {
		var cantidad = parseInt($('#cantidad_' + id).val());
        if(cantidad>0){
		//Fin validacion
		var parametros = {
			"id": id,
			"cantidad": cantidad
		};
		$.ajax({
			type: "POST",
			url: "./ajax/agregar_pedido.php",
			data: parametros,
			beforeSend: function(objeto) {

				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function(datos) {
                $(".outer_div").html(datos).fadeIn('slow');
                alertify.success('Producto añadido');


			}
		});}
	}

    //enviar datos para insertar el comentario e insertar bitacora de productos agregados, el proceso se hace en ./action/finalizar_orden.php y luego regresar al dashboard.php
    function finalizarOrden(){
    var idOrden = document.getElementById("numeroOrden").value;
    var cliente = document.getElementById("cliente").value;
    var comentario=document.getElementById("comentario").value;

    var parametros = {
				"idOrden": idOrden,
                "cliente": cliente,
                "comentario": comentario
	};
            $.ajax({
				type: "POST",
				url: "./action/finalizar_orden.php",
				data: parametros,
				beforeSend: function(objeto) {

					// $("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
                    location.href="dashboard.php";

				}
			});

    }

    //enviar id de la orden y del producto para eliminar de la BD, el proceso se hace en ./action/del_producto.php
    function eliminar(id) {
        var idOrden = document.getElementById("numeroOrden").value;
        var parametros = {
            "idProducto": id,
            "idOrden": idOrden
        };
        
            $.ajax({
             type: "GET",
             url: "./action/del_producto.php",
             data: parametros,
             beforeSend: function(objeto) {
                 // $("#resultados").html("Mensaje: Cargando...");
             },
             success: function(datos) {
                 // $("#resultados").html(datos);
                 alertify.error('Producto eliminado');
                 load(1);
             }
         });
     
    }

    //imprimir tickets de los productos a preparar de la orden recien creada, el proceso se hace en ./imprimir_productos.php
    function imprimir(){
    var idOrden = document.getElementById("numeroOrden").value;
    var comentario=document.getElementById("comentario").value;

    var parametros = {
                "idOrden": idOrden,
                "comentario": comentario,                
    };
            $.ajax({
                type: "POST",
                url: "./imprimir_productos.php",
                data: parametros,
                beforeSend: function(objeto) {

                    // $("#resultados").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    // location.href="dashboard.php";

                }
            });

    }
       
</script>