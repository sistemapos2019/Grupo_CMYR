<?php
    $title ="Parametros";
    include "head.php";
    include "sidebar.php";
?>
 <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="right_col" role="main">
                    <div class="">
                                <!-- aqui se exportaran los modales -->
                                <?php
                                include("modal/upd_parametro.php");
                                ?>
                    </div>
                    
                    <div class="x_panel" style="width:80%; height:50%; margin-top:-1%">
                        <div class="x_title">
                            <h2>Parámetros de ResBar</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="width:100%; height:75%">
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
<script type="text/javascript" src="js/parametros.js"></script>
<script>

    // success

    $("#upd").submit(function(event) {
        $('#upd_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/updparametro.php",
            data: parametros,
            beforeSend: function(objeto) {
            },
            success: function(datos) {
                if (datos == 'actualizado') {
                    $('#upd_data').attr("disabled", false);
                    load(1);
                    $("#updateParametro").modal("hide");
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Datos del parametro actualizado',
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
                        text: 'Falló al intentar modificar el parametro',
                       
                    })
                    $('#upd_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })

    function obtener_datos(id) {
        var nombre = $("#nombre" + id).val();
        var valor = $("#valor" + id).val();
        $("#mod_id").val(id);
        $("#parametro").val(nombre);
        $("#mod_nombre").html(nombre);
        $("#mod_valor").val(valor);
        /*$("#mod_nombre").empty();
        $("#mod_nombre").append(nombre);*/
    }
</script>