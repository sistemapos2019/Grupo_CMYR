<?php
$title = "Ventas por fecha ";
include "head.php";
include "sidebar.php";
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="right_col" role="main">

            <div class="x_panel" id="recargar" style="width:75%; height:50%;  margin-top:-1%">
                <div class="x_title">
                    <h2>Ventas por fecha</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive" style="overflow-x: hidden;">
                        <br />
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4" style="width:25%">
                                    <span>Desde:</span>
                                    <input type="date" name="start_date" id="start_date" class="form-control" />
                                </div>
                                <div class="col-md-4" style="width:25%;">
                                    <span>Hasta:</span>
                                    <input type="date" name="end_date" id="end_date" class="form-control" />
                                </div>
                                <div class="col-md-4" style="width:20%; margin-top:2%">
                                    <span>
                                        <input type="button" name="search" id="search" value="Buscar Ventas" class="btn btn-info active"/>
                                    </span>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="ln_solid"></div>



                                <div class="table-responsive">
                                    <!-- ajax -->
                                    
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                    <!-- /ajax -->
                                </div>


                      
                    

                </div>
            </div>
        </div>
</div><!-- /page content -->
</section>
</div>
</div>
<?php include "footer.php" ?>
<script type="text/javascript" src="js/ventasxFecha.js"></script>