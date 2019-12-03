<?php
$title = "Modificar Orden ";
include "head.php";
include "sidebar.php";

//recibir los datos de la orden a modificar
if (isset($_GET['orden'])) {
    $id=intval($_GET['orden']);

    $orden = mysqli_query($con, "SELECT ord.id, ord.llevar, ord.fecha, ord.cliente, ord.idMesa, us.nombreCompleto as mesero from orden ord, usuario us where ord.idUsuario=us.id and ord.id=$id");

    foreach ($orden as $ord) {
        $llevar=$ord['llevar'];
        if($llevar=="0"){
            $llevar="aqui";
        }
        if($llevar=="1"){
            $llevar='llevar';
        }
        $idMesa=$ord['idMesa'];
        $mesero=$ord['mesero'];
        $cliente=$ord['cliente'];
        $fecha=$ord['fecha'];
    }

    $mesas = mysqli_query($con, "select * from mesa");

    //consultamos si la orden tiene productos en detalleorden
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM detalleorden WHERE idOrden=$id");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row["numrows"];

    }
?>

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <!-- page content -->
        <div class="right_col" role="main">

            <!-- panel con informacion de la orden y sus productos -->

            <div class="x_panel" style="margin-top:-1%">
                <div class="x_title">
                    <h2 style="font-size: 16px !important;">Modificar Orden</h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                        <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                            <!-- <div id="result"></div> -->
                            <!--Datos de la orden a modificar-->
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input type="hidden" id="numrows" value="<?php echo $numrows?>">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5" for="orden">Orden </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="text" id="mod_id" name="mod_id" readonly class="form-control input-sm"  value="<?php echo $id?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5">Tipo </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="hidden" id="tipo" value="<?php echo $llevar?>">
                                        <select class="form-control input-sm" id="mod_tipo" name="mod_tipo" required  onchange="desbloquear_mesa(this);">
                                            <option value="">-- Seleccione --</option>
                                            <option value="aqui">Comer aquí</option>
                                            <option value="llevar">Llevar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5" for="mesa">Mesa </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="hidden" id="mesa" value="<?php echo $idMesa?>">
                                        <select class="form-control input-sm" id="mod_mesa" name="mod_mesa" disabled onchange="desbloquear_crear(this);">
                                            <option selected="" value="">-- Seleccione --</option>
                                            <?php foreach ($mesas as $m) : ?>
                                                <option value="<?php echo $m['id']; ?>"><?php echo $m['mesa']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="mesero">Mesero </label>
                                    <div class="col-md-9 col-sm-9 col-xs-6">
                                        <input type="text" id="mod_mesero" name="mod_mesero" readonly class="form-control  input-sm" value="<?php echo $mesero ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5">Cliente </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" id="mod_cliente" name="mod_cliente" disabled class="form-control  input-sm" value="<?php echo $cliente ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5">Fecha </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" id="mod_fecha" name="mod_fecha" class="form-control input-sm" value="<?php echo $fecha ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <span class="pull-right">
                                        <button id="upd_data" type="submit" class="btn btn-primary" disabled=""><span class="glyphicon glyphicon-floppy-disk"></span> Guardar Datos</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                        
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

                    <div class="col-md-4 col-sm-4 col-xs-12" id="save_productos" style="display:none;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="pull-right"><button  class="btn btn-primary form-control" data-toggle="modal" data-target=".modificar-productos-orden">
                            <span class="glyphicon glyphicon-edit"></span> Editar producto</button></span>
                            <!-- aqui se exportara el modal con los productos que puede agregar a la roden -->
                            <?php
                            include("modal/productos_orden_modificar.php");
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12" id="btnFinalizar" style="display:none;">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 10px">
                            <div class="form-group">
                            <span class="pull-right"><button class="btn btn-primary form-control" onclick="finalizarOrden();"><span class="glyphicon glyphicon-ok"></span> Finalizar Orden</button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12" id="btnRegresar" style="display:none;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                            <span class="pull-right"><a href="dashboard.php" class="btn btn-primary form-control"><span class="glyphicon glyphicon-arrow-left"></span> Regresar </a></span>
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
        $('.outer_div').load("./ajax/modificar_pedido.php");
        
    });

    function load(page) {
        var q = $("#q").val();
        var mod_id = $('#mod_id').val();
        var parametros = {
            "action": "ajax",
            "page": page,
            "q": q,
            "mod_id": mod_id
        };
        //$("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido_modificar.php', 
            data: parametros,
            beforeSend: function(objeto) {
                //$('#loader').html('');
            },
            success: function(data) {
                $(".otrodiv").html(data).fadeIn('slow');
                //$('#loader').html('');
                $.ajax({
				type: "POST",
				url: "./ajax/modificar_pedido.php",
				data: parametros,
				beforeSend: function(objeto) {

					//$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
                    //$(".outer_div").html(datos).fadeIn('slow');
                    $('.outer_div').html(datos).fadeIn('slow');

				}
			});

            }
        })
    }

    //mostrar valores de tipo y mesa que tiene la orden en los select
    var tipo = $("#tipo").val();
    var mesa = $("#mesa").val();
    $("#mod_tipo").val(tipo);
    $("#mod_mesa").val(mesa);

    //al nomas cargar si la orden tiene productos todo normal se muestran sus productos y los botones de editar y finalizar, ese proceso se hace en ./ajax/modificar_pedido.php, pero si no tiene entonces se muestra el boton Regresar
    var numrows = $("#numrows").val();
    if (numrows > 0) {

    }else{
        document.getElementById('btnRegresar').style.display='block';
    }

    //bloquear y desbloquear opciones segun el tipo que ya trae la orden

    var mod_mesa = document.getElementById('mod_mesa');
    var mod_cliente = document.getElementById('mod_cliente');
    var btn_guardar = document.getElementById('upd_data');

    if ($("#mod_tipo").val()=="aqui") {
        mod_mesa.disabled = false;
        btn_guardar.disabled = false;
        mod_cliente.disabled = false;
        mod_cliente.required = false;
    }else if($("#mod_tipo").val()=="llevar"){
        mod_mesa.disabled = true;
        mod_mesa.selectedIndex = 0;
        btn_guardar.disabled = false;
        mod_cliente.disabled = false;
        mod_cliente.required = true;
    }

    //bloquear y desbloquear segun cambie la opcion
    function desbloquear_mesa(list_tipo) {
      d = list_tipo.value;

      if(d == "aqui"){
            mod_mesa.disabled = false;
            btn_guardar.disabled = true;
            mod_cliente.disabled = true;
            mod_cliente.required = false;
      }else if(d == "llevar"){
            mod_mesa.disabled = true;
            mod_mesa.selectedIndex = 0;
            btn_guardar.disabled = false;
            mod_cliente.disabled = false;
            mod_cliente.required = true;
      }else if(d==""){
            mod_mesa.disabled = true;
            mod_mesa.selectedIndex = 0;
            btn_guardar.disabled = true;
            mod_cliente.disabled = true;
      }
      
    }

    function desbloquear_crear(lista_mesa) {
      
      if(lista_mesa.value != ""){
        mod_cliente.disabled = false;
        btn_guardar.disabled = false;
      }else{
        mod_cliente.disabled = true;
        btn_guardar.disabled = true;
      }
    }

    //Enviar solo los datos de la orden para actualizar, el proceso se hace en action/updorden.php
    $("#upd").submit(function(event) {
        $('#upd_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/updorden.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#result2").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                if (datos == 'actualizado') {
                    $('#upd_data').attr("disabled", false);
                    load(1);
                    $("#updateOrden").modal("hide");
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Datos de la orden actualizados',
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
                        text: 'Falló al intentar modificar la orden',
                       
                    })
                    $('#upd_data').attr("disabled", false);
                }
            }
        });
        event.preventDefault();
    })
        
    //enviar datos para modificar productos en detalleorden, el proceso se hace en action/upd_productos_orden.php
	function modificar(id) {
		var cantidad = parseInt($('#cantidad_' + id).val());
        var numeroOrden = parseInt($('#mod_id').val());
		//Inicia validacion
		if (isNaN(cantidad)) {
			alert('Esto no es un numero');
			document.getElementById('cantidad_' + id).focus();
			return false;
		}
		
		if (cantidad>0) {
            var parametros = {
            "id": id,
            "cantidad": cantidad,
            "numeroOrden": numeroOrden
        };
        $.ajax({
            type: "POST",
            url: "action/upd_productos_orden.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
            load(1);
            $('.outer_div').load("./ajax/modificar_pedido.php");

            }
        });
            
        }
	}

    //enviar id de la orden y del producto a eliminar, el proceso se hace en ./action/del_producto.php
    function eliminar(id) {
        var idOrden = document.getElementById("mod_id").value;
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
                 load(1);
             }
         });
     
    }

    //enviar datos para insertar bitacora de productos modificados, el proceso se hace en ./action/finalizar_orden_upd.php y luego regresar al dashboard.php
    function finalizarOrden(){
    var idOrden = document.getElementById("mod_id").value;
    var cliente = document.getElementById("mod_cliente").value;

    var parametros = {
                "idOrden": idOrden,
                "cliente": cliente,
    };
            $.ajax({
                type: "POST",
                url: "./action/finalizar_orden_upd.php",
                data: parametros,
                beforeSend: function(objeto) {

                    // $("#resultados").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    location.href="dashboard.php";

                }
            });

    }
       
</script>