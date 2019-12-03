<?php
$title = "Cobrar Orden ";
include "head.php";
include "sidebar.php";

//cargar los datos de la orden
if (isset($_GET['ordenCobrar'])) {
    $id=intval($_GET['ordenCobrar']);

    $orden = mysqli_query($con, "SELECT ord.id, ord.llevar, ord.fecha, ord.cliente, ord.idMesa, us.nombreCompleto as mesero from orden ord, usuario us where ord.idUsuario=us.id and ord.id=$id");

    foreach ($orden as $ord) {
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

    //traer el total de la orden de la vista dashboardprincipal
    $totalOrden = mysqli_query($con, "SELECT Total from dashboardprincipal where IdOrden=$id");
    foreach ($totalOrden as $t) {
        $total = $t['Total'];
    }

    //traer el porcentaje de propina de los parametros
    $parametro = mysqli_query($con, "select valor from parametro where id=13");
    foreach ($parametro as $p) {
        $propina = $p['valor'];
    }
    
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
                    <h2 style="font-size: 16px !important;">Cobrar Orden</h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <form class="form-horizontal form-label-left input_mask" method="post">
                            <!-- <div id="result"></div> -->
                            <!--Datos de la orden a cobrar-->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input type="hidden" id="numrows" value="<?php echo $numrows?>">
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
                                        <input type="text" id="mesero" name="mesero" readonly class="form-control  input-sm" value="<?php echo $mesero ?>">
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

                            <div class="col-md-12 col-sm-12 col-xs-12" id="btn_cobrar" style="display:none;">
                                <span class="pull-right"><button class="btn btn-primary" data-toggle="modal" data-target=".modal-confirmar-cobro">
                                <span class="glyphicon glyphicon-usd"></span> Cobrar</button></span>
                                <!-- aqui se exportara el modal para ingresar efectivo y calcular el cambio de la roden -->
                                <?php
                                include("modal/confirmar_cobro.php");
                                ?>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12" id="btnRegresar" style="display:none;">
                                <div class="form-group">
                                <span class="pull-right"><a href="dashboard.php" class="btn btn-primary form-control"><span class="glyphicon glyphicon-arrow-left"></span> Regresar </a></span>
                                </div>
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
        //$('.outer_div').load("./ajax/cobrar_orden.php");
    });

    function load(page) {
        var q = $("#q").val();
        var numeroOrden = $('#numeroOrden').val();
        var parametros = {
            "action": "ajax",
            "page": page,
            "q": q,
            "numeroOrden": numeroOrden
        };
        //$("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/cobrar_orden.php', 
            data: parametros,
            beforeSend: function(objeto) {
                //$('#loader').html('');
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
            }
        })
    }

    //traer el total de la orden y el porcentaje de propina
    var subtotal = document.getElementById('subtotalOrden').value;
    var desc_propina = document.getElementById('desc_propina').value;
    var btn_confirmar = document.getElementById('confirmar');
    // var inputDescPropina = document.getElementById();

    //calcular la cantidad de propina y el nuevo total a pagar
    var propina = subtotal * desc_propina;
    var total = parseFloat(subtotal) + parseFloat(propina);

    //asignando los valores calculados
    $("#propina").val(parseFloat(propina).toFixed(2));
    $("#total").val(parseFloat(total).toFixed(2));

    //metodo que cálcula la propina si cambia el porcentaje ingresado
    function calcularPropina(porcentaje){
        var porcentaje = parseFloat(porcentaje).toFixed(2);
        var efectivo = parseFloat(document.getElementById('efectivo').value).toFixed(2);
        total = 0;
        // si el porcentaje de propina contiene algun valor entre cero y uno calcula la propina y el total
        if ((porcentaje != null) && (porcentaje != "") && (porcentaje != undefined) && (porcentaje > 0) && (porcentaje < 1)) {
            //calcular la nueva propina y el nuevo total a pagar
            propina = 0;
            propina = subtotal * porcentaje;
            total = parseFloat(subtotal) + parseFloat(propina);
            //asignando los nuevos valores calculados
            $("#propina").val(parseFloat(propina).toFixed(2));
            $("#total").val(parseFloat(total).toFixed(2));

            //llamamos al método para calcular el nuevo cambio, pasandole como parametros el efectivo y el nuevo total
            Cambio(efectivo, total);

        }else if (porcentaje == 0){
            //si porcentaje es igual a cero el total no incluye propina
            total = parseFloat(subtotal);
            $("#propina").val("");
            $("#total").val(parseFloat(total).toFixed(2));

            //llamamos al método para calcular el nuevo cambio, pasandole como parametros el efectivo y el nuevo total
            Cambio(efectivo, total);

        }else{
            //si porcentaje está vacío o no cumple algunas de las otras condiciones el total no incluye propina
            total = parseFloat(subtotal);
            $("#propina").val("");
            $("#total").val(parseFloat(total).toFixed(2));

            //llamamos al método para calcular el nuevo cambio, pasandole como parametros el efectivo y el nuevo total
            Cambio(efectivo, total);

        }
    }

    //metodo que cálcula el cambio cuando ingresamos el efectivo o cambiamos su valor pero tomando el porcentaje de propina ya cargado desde la base de datos
    function calcularCambio(efectivo){
        var efectivo = parseFloat(efectivo).toFixed(2);
        // si efectivo contiene algun valor mayor a cero calcula el cambio y permite cobrar
        if ((efectivo != null) && (efectivo != "") && (efectivo != undefined) && (efectivo > total)) {
            var cambio = efectivo - total;
            $("#cambio").val(parseFloat(cambio).toFixed(2));
            
            btn_confirmar.disabled = false;

        }else if (Math.round(efectivo * 100) == Math.round(total * 100)){
            //si efectivo es igual a total el cambio es cero y permite cobrar
            $("#cambio").val(0.00);
            btn_confirmar.disabled = false;

        }else if (Math.round(efectivo * 100) < Math.round(total * 100)){
            //si efectivo es menor a total cálcula lo que falta y no deja cobrar
            var cambio = total - efectivo;
            $("#cambio").val("Faltan: $" + parseFloat(cambio).toFixed(2));
            btn_confirmar.disabled = true;

        }else{
            //y si efectivo esta vacio el cambio también y no deja cobrar
            $("#cambio").val("");
            btn_confirmar.disabled = true;
        }
    }

    //método que cacula el cambio cuando cambiamos el porcentaje de propina
    function Cambio(efectivo, total){
        // si efectivo contiene algun valor mayor a cero calcula el cambio y permite cobrar
        if ((efectivo != null) && (efectivo != "") && (efectivo != undefined) && (efectivo > total)) {
            var cambio = efectivo - total;
            $("#cambio").val(parseFloat(cambio).toFixed(2));
            
            btn_confirmar.disabled = false;

        }else if (Math.round(efectivo * 100) == Math.round(total * 100)){
        //si efectivo es igual a total el cambio es cero y permite cobrar
        $("#cambio").val(0.00);
        btn_confirmar.disabled = false;

        }else if (Math.round(efectivo * 100) < Math.round(total * 100)){
            //si efectivo es menor a total cálcula lo que falta y no deja cobrar
            var cambio = total - efectivo;
            $("#cambio").val("Faltan: $" + parseFloat(cambio).toFixed(2));
            btn_confirmar.disabled = true;

        }else{
            //y si efectivo esta vacio el cambio también y no deja cobrar
            $("#cambio").val("");
            btn_confirmar.disabled = true;
        }
    }

    // $("#cobro").submit(function(event) {

    //     var parametros = $(this).serialize();
    //     $.ajax({
    //         type: "POST",
    //         url: "./imprimir_factura.php",
    //         data: parametros,
    //         beforeSend: function(objeto) {

    //         },
    //         success: function(datos) {
    //            //location.href="nueva_orden.php";
                
    //         }
    //     });
    //     event.preventDefault();
    // })

    //enviar datos para imprimir factura
    function cobrar(){

        var idOrden = $('#idOrden').val();
        var mesero = $('#mesero').val();
        var cliente = $('#cliente').val();
        var efectivo=$('#efectivo').val();
        var subtotalOrden=$('#subtotalOrden').val();
        var propina=$('#propina').val();
        var cambio=$('#cambio').val();
        var total=$('#total').val();
        var parametros = {
                "idOrden": idOrden,
                "cliente": cliente,
                "mesero": mesero,
                "efectivo": efectivo,
                "subtotalOrden": subtotalOrden,
                "propina": propina,
                "cambio": cambio,
                "total": total
    };
            $.ajax({
                type: "POST",
                url: "./imprimir_factura.php",
                data: parametros,
                beforeSend: function(objeto) {

                    // $("#resultados").html("Mensaje: Cargando...");
                },
                success: function(datos) {

                    $("#modalConfirmar").modal("hide");

                }
            });
    }     
    
    //enviar datos para cerrar orden y guardar la propina
    function finalizarOrden(){
        var idOrden = $('#idOrden').val();
        var propina = $('#propina').val();
        var cliente = $('#cliente').val();
	    var parametros = {
					"idOrden": idOrden,
                    "propina": propina,
                    "cliente": cliente,
		};
            $.ajax({
				type: "POST",
				url: "./action/cerrar_orden.php",
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