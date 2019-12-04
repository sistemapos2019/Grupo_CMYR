<?php
$title = " Usuarios";
include "head.php";
include "sidebar.php";

?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-1%; margin-left:-1%">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Usuario</button>
                        <!-- aqui se exportaran los modales -->
                        <?php
                        include("modal/new_user.php");
                        include("modal/upd_user.php");
                        ?>
                    </div>
                </div>
            </div>

            <div class="x_panel" style="width:60%; height:50%; margin-top:-2%">
                <div class="x_title">
                    <h2>Usuarios</h2>

                    <div class="clearfix"></div>
                </div>
                <!-- formulario para buscar usuarios-->
                <form class="form-horizontal" role="form" id="mesas">
                    <div class="form-group row">
                        <label for="q" class="col-md-3 control-label">Buscar Usuario</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="q" onkeyup="load(1);" placeholder="Nombre o usuario">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" onclick="load(1);">
                                <span class="glyphicon glyphicon-search"></span> Buscar</button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                <!-- end Form buscar -->

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

<script type="text/javascript" src="js/usuarios.js"></script>

<script>
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/add_user.php",
            data: parametros,
            beforeSend: function(objeto) {},
            success: function(datos) {
                if (datos == 'agregado') {
                    $('#save_data').attr("disabled", false);
                    load(1);
                    $("#newUser").modal("hide");
                    $("#add")[0].reset();//borrar todos los datos del form add
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Usuario agregado exitosamente',
                        showConfirmButton: false,
                        timer: 1700
                    });
                }
                if (datos == 'error de duplicidad') {
                    // swal("¡Error!", "Usuario y/o pin deben de ser únicos", "error")
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Usuario y/o pin deben ser únicos',
                       
                    })

                    $('#save_data').attr("disabled", false);

                }
                if (datos == 'otro error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Falló al intentar agregar el nuevo usuario',
                       
                    })
                    $('#save_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })


$( "#upd" ).submit(function( event ) {
  $('#upd_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/upduser.php",
            data: parametros,
             beforeSend: function(objeto){
              
              },
            success: function(datos){
                if (datos == 'actualizado') {
                    $('#upd_data').attr("disabled", false);
                    load(1);
                    $("#updateUser").modal("hide");
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Datos del usuario actualizados',
                        showConfirmButton: false,
                        timer: 1700
                    });
                }

                if (datos == 'error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Usuario y/o pin deben ser únicos',
                       
                    })

                    $('#upd_data').attr("disabled", false);

                }

                if (datos == 'otro error') {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        text: 'Falló al intentar modificar el usuario',
                       
                    })
                    $('#upd_data').attr("disabled", false);
                }
            
          }
    });
  event.preventDefault();
})

    function obtener_datos(id) {
        var nombre = $("#nombre" + id).val();
        var usuario = $("#usuario" + id).val();
        var rol = $("#rol" + id).val();
        var contra = $("#contra" + id).val();
        var pin = $("#pin" + id).val();
        $("#mod_id").val(id);
        $("#mod_nombre").val(nombre);
        $("#mod_usuario").val(usuario);
        $("#mod_rol").val(rol);
        $("#mod_contra").val(rol);
        $("#mod_pin").val(pin);
    }
</script>