<?php

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ordenes para llevar</title>
    <link rel="icon" href="images/favicon.ico" />


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!--Ticketly-->
    <link rel="stylesheet" href="custom.min.css">

    <link rel="stylesheet" href="css/jquery.nice-number.css">

    <!-- Sweet alert  2  -->
    <link rel="stylesheet" href="css/sweetalert2.min.css" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>

    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="right_col" role="main">
           

            <!--Panel para ordenes activas-->
            <div class="x_panel"  style="margin-top:-1%">
                <div class="x_title">
                    <h2>Ordenes para llevar</h2>
                    <div class="clearfix"></div>
                </div>
                <!-- formulario para busar ordenes activas-->
                <form class="form-horizontal" role="form" id="gastos">
                   
                    <span id="loader"></span>
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
<!-- jQuery 3 -->
<script src="js/jquery/dist/jquery.min.js"></script>
<!-- Datatables -->
<script src="js/datatables.net/js/jquery.dataTables.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="css/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- jQuery 3 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="js/jquery.nice-number.js"></script>


<!-- <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script> -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!--    Plugin sweet Alert 2  -->
<script src="js/sweetalert2.all.min.js"></script>

</body>

</html>

<script type="text/javascript" src="js/llevar.js"></script>
<script>
        
$(document).ready(function() {
 load(1);
});


	</script>