<?php
$title = "Dashbaord";
include "head.php";
include "sidebar.php";
$mesas = mysqli_query($con, "select * from mesa");
$categorias = mysqli_query($con, "select * from categoria");

$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * from usuario where id=$id");
while ($row = mysqli_fetch_array($query)) {
    $id = $row['id'];
    $nombre = $row['nombreCompleto'];
    $rol = $row['rol'];
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#nuevaOrden" style="margin-top:-1%; margin-left:-1%;"><i class="fa fa-plus-circle"></i> Nueva Orden</button>
                        <!-- aqui se exportaran los modales -->
                        <?php
                        include("modal/new_order.php");
                        ?>
                    </div>
                </div>
            </div>

            <!--Panel para ordenes activas-->
            <div class="x_panel"  style="margin-top:-2%">
                <div class="x_title">
                    <h2>Ordenes activas</h2>
                    <div class="col-md-1 pull-right">
                        <input type="text" class="form-control" id="codigo">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- formulario para busar ordenes activas-->
                <form class="form-horizontal" role="form" id="gastos">
                    <div class="form-group row">
                        <label for="q" class="col-md-2 control-label">Buscar Orden</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="q" onkeyup="load(1);">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" onclick="load(1);">
                                <span class="glyphicon glyphicon-search"></span> Buscar</button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>

                <div class="x_content">
                    <div class="table-responsive">
                        <!-- ajax -->
                        <div id="resultados"></div><!-- Carga los datos ajax -->
                        <div class='outer_div'></div><!-- Carga los datos ajax -->

                        <!-- /ajax -->
                    </div>
                </div>

            </div>
        </div>
</div>
</div>
<?php include "footer.php" ?>
<script type="text/javascript" src="js/dashboard.js"></script>
<script>
        
$(document).ready(function() {
    load(1);
    //Pasar el foco al textbox de trazabilidad siempre
    document.getElementById("codigo").focus();
});

// function load(page) {
//     var q = $("#q").val();
//     $("#loader").fadeIn('slow');
//     $.ajax({
//         url: './ajax/productosOrden.php?action=ajax&page=' + page + '&q=' + q,
//         success: function(data) {
//             $("#resultado").html(data).fadeIn('slow');
//             $('#loader').html('');
//         }
//     })
// }

    //Crear orden
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/add_orden.php",
            data: parametros,
            beforeSend: function(objeto) {},
            success: function(datos) {
                load(1);
                $("#resultorden").val(datos);
               location.href="nueva_orden.php";
                
            }
        });
        event.preventDefault();
    })

    function cobrar(id){
    var parametros = {
				"idOrden": id,
                
	};
            $.ajax({
				type: "POST",
				url: "./imprimir_factura.php",
				data: parametros,
				beforeSend: function(objeto) {

					// $("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
                    // location.href="dashboard.php";

				}
			});
    }

    //Funcion para la trazabilidad de los tickets de preparados o rapidos

    //verifica si se presionado enter sobre el tetxbox donde estara el codigo de trazabilidad    
    $('#codigo').keyup(function(e) {
        if (e.keyCode == 13) {
            //si es la tecla enter que se ha preciodado que obtenga el valor que contenga el textbox y que lo envie al archivo por medio de post
            var orden = document.getElementById("codigo").value;
            var parametros = {
                "orden": orden,
            };
            $.ajax({
                type: "POST",
                url: "./trazabilidad.php",
                data: parametros,
                beforeSend: function(objeto) {
                    // $("#resultados").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    //  si los datos de la orden son actualizados
                    if (datos == 'actualizado') {
                        load(1);
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Orden actualizada',
                            showConfirmButton: false,
                            timer: 1700
                        });
                    }
                    // si la actualizacion de la orden da algun error
                    if (datos == 'error') {
                        load(1);
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Orden no actualizada',
                            showConfirmButton: false,
                            timer: 1700
                        });
                    }
                    //Si la orden no se encuentra o da algun error desconocido
                    if (datos == "") {
                        load(1);
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Orden no encontrada',
                            showConfirmButton: false,
                            timer: 1700
                        });
                    }
                    //se actualize o de error siempre limpiar el contenido del textbox
                    $('#codigo').val("");
                }
            });
        }
    });
    //Termina la funcion de trazzabilidad de los tickets preparados y rapidos
</script>