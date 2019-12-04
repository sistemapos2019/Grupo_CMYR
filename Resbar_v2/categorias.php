<?php
$title = "Categorías";
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
                        <button type="button" class="btn btn-primary" style="margin-top:-1%; margin-left:-1%" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Categoría</button>
                        <!-- aqui se exportaran los modales -->
                        <?php
                        include("modal/new_categoria.php");
                        include("modal/upd_categoria.php");
                        ?>
                    </div>
                </div>
            </div>

            <div class="x_panel" style="width:60%; height:50%; margin-top:-2%">
                <div class="x_title">
                    <h2>Categorías</h2>
                    <div class="clearfix"></div>
                </div>
                <!-- formulario para buscar categorias-->
                <form class="form-horizontal" role="form" id="categorias">
                    <div class="form-group row">
                        <label for="q" class="col-md-3 control-label">Buscar Categoría</label>
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

<!--categorias-->
<script type="text/javascript" src="js/categorias.js"></script>
<script>
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/add_categoria.php",
            data: parametros,
            beforeSend: function(objeto) {
            },
            success: function(datos) {
                if (datos == 'agregado') {
                    $('#save_data').attr("disabled", false);
                    load(1);
                    $("#newCategoria").modal("hide");
                    $("#add")[0].reset();
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Categoría agregada exitosamente',
                        showConfirmButton: false,
                        timer: 1700
                    });
                }
                if (datos == 'error') {
                    // swal("¡Error!", "Usuario y/o pin deben de ser únicos", "error")
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
                        text: 'Falló al intentar agregar la nueva categoria',
                       
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
            url: "action/updcategoria.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#result2").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                if (datos == 'actualizado') {
                    $('#upd_data').attr("disabled", false);
                    load(1);
                    $("#updateCategoria").modal("hide");
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Datos de la Categoría actualizados',
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
                        text: 'Falló al intentar modificar la categoria',
                       
                    })
                    $('#upd_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })

    function obtener_datos(id) {
        var categoria = $("#categoria" + id).val();
        $("#mod_id").val(id);
        $("#mod_name").val(categoria);
    }
</script>