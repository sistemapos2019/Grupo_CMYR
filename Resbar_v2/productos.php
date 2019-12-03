<?php
$title = "Productos";
include "head.php";
include "sidebar.php";

?>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-primary" style="margin-top:-1%; margin-left:-1%;" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Producto</button>
                        <!-- aqui se exportaran los modales -->
                        <?php
                        include("modal/new_producto.php");
                        include("modal/upd_producto.php");
                        ?>
                    </div>
                </div>
            </div>

            <div class="x_panel" style="width:70%; height:50%; margin-top:-2%">
                <div class="x_title">
                    <h2>Produtos</h2>
                    <div class="clearfix"></div>
                </div>
                <!-- formulario para buscar productos-->
                <form class="form-horizontal" role="form" id="productos">
                    <div class="form-group row">
                        <label for="q" class="col-md-2 control-label">Buscar Producto</label>
                        <div class="col-md-4">
                            <input type="search" class="form-control" id="q" onkeyup="load(1);">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" onclick="load(1);">
                                <span class="glyphicon glyphicon-search"></span> Buscar</button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                <!-- Fin Form buscar -->

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
</div><!-- /page content -->

<?php include "footer.php" ?>

<!--productos-->
<script type="text/javascript" src="js/productos.js"></script>
<script>
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/add_producto.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#result").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                if (datos == 'agregado') {
                    $('#save_data').attr("disabled", false);
                    load(1);
                    $("#newProducto").modal("hide");
                    $("#add")[0].reset();//borrar todos los datos del form add
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Producto agregado exitosamente',
                        showConfirmButton: false,
                        timer: 1700
                    });
                }
                if (datos == 'error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Algo ha salido mal intenta nuevamente',
                       
                    })

                    $('#save_data').attr("disabled", false);

                }
                if (datos == 'otro error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Falló al intentar agregar el nuevo producto',
                       
                    })
                    $('#save_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })

    // success

    $("#upd").submit(function(event) {
        $('#upd_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/updproducto.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#result2").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                if (datos == 'actualizado') {
                    $('#upd_data').attr("disabled", false);
                    load(1);
                    $("#updateProducto").modal("hide");
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Datos del producto actualizados',
                        showConfirmButton: false,
                        timer: 1700
                    });
                }

                if (datos == 'error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Algo ha salido mal intenta nuevamente',
                       
                    })

                    $('#upd_data').attr("disabled", false);

                }

                if (datos == 'otro error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Falló al intentar modificar el producto',
                       
                    })
                    $('#upd_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })

    function obtener_datos(id) {
        var producto = $("#producto" + id).val();
        var precio = $("#precio" + id).val();
        var inventario = $("#inventario" + id).val();
        var preparado = $("#preparado" + id).val();
        var categoria = $("#categoria" + id).val();
        $("#mod_id").val(id);
        $("#mod_producto").val(producto);
        $("#mod_precio").val(precio);
        $("#mod_inventario").val(inventario);
        $("#mod_preparado").val(preparado);
        $("#mod_categoria").val(categoria);
    }
</script>