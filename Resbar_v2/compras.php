<?php
    $title ="Compras | ";
    include "head.php";
    include "sidebar.php";
    include "footer.php";
    
?>
 <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">


                            <div class="col-md-12 col-sm-12 col-xs-12">

                            </div>
                        </div>

                        <!--Modal para cobrar orden-->

                        <h2> Compras</h2>
                        <div class="clearfix"></div>


                    </div>
                    <!--Cuerpo del modal-->
                    <div class="modal-body">

                        <input type="hidden" name="mod_id" id="mod_id" value="46">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">fecha<span
                                            class="required"></span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NDOC</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">NRC</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">DUI</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" class="form-control" d>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Proveedor<span></span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="clearfix"></div>
                    <!--Tabla de los productos-->
                    <div class="x_content">
                        <div class="outer_div">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">producto </th>
                                        <th class="column-title">Cantidad </th>
                                        <th class="column-title">P/U </th>
                                        <th class="column-title">Subtotal $ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--Registros de pruebas-->
                                    <tr class="even pointer">
                                        <td>Carne asada</td>
                                        <td>2</td>
                                        <td>5.75</td>
                                        <td>11.50</td>
                                    </tr>

                                    <tr class="even pointer">
                                        <td>Pastel de chocolate</td>
                                        <td>4</td>
                                        <td>3.25</td>
                                        <td>13.00</td>
                                    </tr>

                                    <tr class="even pointer">
                                        <td>Coca cola</td>
                                        <td>6</td>
                                        <td>1.25</td>
                                        <td>7.50</td>
                                    </tr>
                                    <tr class="even pointer">
                                        <td>Frozen</td>
                                        <td>1</td>
                                        <td>2.50</td>
                                        <td>2.50</td>
                                    </tr>

                                    <tr>
                                        <td colspan="10"><span class="pull-right">
                                                <div class="form-group">
                                                    <label class="col-md-4" for="total"
                                                        class="control-label">Total
                                                        ($)</label>
                                                    <div class="col-md-6">
                                                        <input type="total" class="form-control"
                                                            id="total" placeholder="34.50" disabled>
                                                    </div>
                                                </div>
                                            </span></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--Cierre tabla productos-->
                    </form>
                </div>
                <!--arriba se cierra el modal-body-->

        </div>
    </div>
    </div>
    <!--Cierre modal cobrar orden-->

    </div>
    </form>


    </section>
    </div>
    </div>