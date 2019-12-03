<?php
    $title ="Ventas diarias ";
    include "head.php";
    include "sidebar.php";
    
?>
<div class="content-wrapper">
<!-- Main content -->
<section class="content">
        <div class="right_col" role="main">
            <div class="x_panel" style="width:80%; height:50%; margin-top:-1%">
                <div class="x_title">
                    <h2>Ventas diarias</h2>
                    
                    <div class="clearfix"></div>
                </div>
                <!-- formulario para buscar productos-->
                <!-- <form class="form-horizontal" role="form" id="productos">
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
                </form> -->
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
    <script type="text/javascript" src="js/ventasDiarias.js"></script>



                            