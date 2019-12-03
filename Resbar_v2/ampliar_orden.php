<?php
$title = "Ampliar Orden ";
include "head.php";
include "sidebar.php";

//recibir los datos de la orden
if (isset($_GET['idOrden'])) {
    $id=intval($_GET['idOrden']);

    $orden = mysqli_query($con, "SELECT ord.id, ord.llevar, ord.fecha, ord.cliente, ord.idMesa, us.nombreCompleto as mesero from orden ord, usuario us where ord.idUsuario=us.id and ord.id=$id");

    foreach ($orden as $ord) {
        $idOrden=$ord['id'];
        $llevar=$ord['llevar'];
        $idMesa=$ord['idMesa'];
        if($llevar=="0"){
            $llevar="Comer aquí";
            $mesas = mysqli_query($con, "select mesa from mesa where id=$idMesa");
            foreach ($mesas as $m) {
                $mesa=$m['mesa'];
            }
        }
        if($llevar=="1"){
            $llevar='Llevar';
            $mesa="";
        }
        $mesero=$ord['mesero'];
        $cliente=$ord['cliente'];
        $fecha=$ord['fecha'];
    }
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
                    <h2 style="font-size: 16px !important;">Ampliar Orden</h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                            <!-- <div id="result"></div> -->
                            <!--Datos de la nueva orden-->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5" for="first-name">Orden </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="text" id="numeroOrden" readonly class="form-control  input-sm"  value="<?php echo $id ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-5">Tipo </label>
                                    <div class="col-md-8 col-sm-8 col-xs-7">
                                        <input type="text" name="tipo" readonly class="form-control input-sm" value="<?php echo $llevar ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-5" for="first-name">Mesa </label>
                                    <div class="col-md-9 col-sm-9 col-xs-7">
                                        <input type="text" name="mesa" readonly class="form-control  input-sm" value="<?php echo $mesa ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="first-name">Mesero </label>
                                    <div class="col-md-9 col-sm-9 col-xs-6">
                                        <input type="text" name="mesero" readonly class="form-control  input-sm" value="<?php echo $mesero ?>">
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
                        <div class="col-md-3 col-sm-3 col-xs-8">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <span class="pull-right"><button id="btnagregar"  class="btn btn-primary" data-toggle="modal" data-target="#productos">
                                <span class="glyphicon glyphicon-plus"></span> Agregar productos</button></span>
                                <!-- aqui se exportara el modal con los productos que puede agregar a la roden -->
                                <?php
                                include("modal/productos_orden.php");
                                ?>
                                </div>
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
                            <span class="pull-right"><button id="btn_finalizar" class="btn btn-primary" onclick="agregarProductos();imprimirNuevos();">
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
        $('.outer_div').load("./ajax/tabla_productos_nuevos_tmp.php");
    });

    function load(page) {
        var q = $("#q").val();
        var parametros = {
            "action": "ajax",
            "page": page,
            "q": q
        };
        //$("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido.php', 
            data: parametros,
            beforeSend: function(objeto) {
                //$('#loader').html('');
            },
            success: function(data) {
                $(".otrodiv").html(data).fadeIn('slow');
                //$('#loader').html('');
                $.ajax({
				type: "POST",
				url: "./ajax/ampliar_orden.php",
				data: parametros,
				beforeSend: function(objeto) {

					//$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
                    //$(".outer_div").html(datos).fadeIn('slow');
                    $('.outer_div').load("./ajax/tabla_productos_nuevos_tmp.php");

				}
			});

            }
        })
    }
        
    //enviar datos del producto para añadir al arreglo en el archivo ./ajax/ampliar_orden.php y luego mostrarlos en la tabla temporal que se dibuja en ./ajax/tabla_productos_nuevos_tmp.php
	function agregar(id) {
		var cantidad = parseInt($('#cantidad_' + id).val());
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
        };
        $.ajax({
            type: "POST",
            url: "./ajax/ampliar_orden.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $('.outer_div').load("./ajax/tabla_productos_nuevos_tmp.php");

            }
        });
            
        }
	}

    //quitar producto temporal, el proceso se hace en el archivo ./ajax/quitarProdTmp.php
    function quitarp(index){
        var parametros = {
                    "indice": index,
                                   
        };
        $.ajax({
            type:"POST",
            data: parametros,
            url:"./ajax/quitarProdTmp.php",
            success:function(r){
                $('.outer_div').load("./ajax/tabla_productos_nuevos_tmp.php");
            }
        });

    }

    //metodo para mandar los datos a insertar en la base de datos, el proceso se hace en ./ajax/agregar_productos_ampliar.php
    function agregarProductos(){
        //Dos formas diferentes de obtener el valor de un elemento a través del id
        var numeroOrden = $('#numeroOrden').val();
        var cliente = $('#cliente').val();
        var comentario=document.getElementById("comentario").value;
        //Inicia validacion
        
            var parametros = {
            "numeroOrden": numeroOrden,
            "cliente": cliente,
            "comentario": comentario,
        };
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_productos_ampliar.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $('.outer_div').load("./ajax/tabla_productos_nuevos_tmp.php");
                location.href="dashboard.php";

            }
        });
            
    }

    //imprimir tickets de los productos nuevos a preparar de la orden que se está ampliando, el proceso se hace en ./imprimir_productos_nuevos.php
    function imprimirNuevos(){
  
        var numeroOrden = $('#numeroOrden').val();
        var comentario=document.getElementById("comentario").value;
        //Inicia validacion
        
            var parametros = {
            "numeroOrden": numeroOrden,
            "comentario": comentario,
        };
        $.ajax({
            type: "POST",
            url: "./imprimir_productos_nuevos.php",
            data: parametros,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                //location.href="dashboard.php";
                // $('.outer_div').load("./ajax/tabla_productos_nuevos.php");

            }
        });
            
    }
       
</script>