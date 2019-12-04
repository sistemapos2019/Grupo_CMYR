<?php
    $categorias =mysqli_query($con, "select * from categoria");
?>    
    <!-- Modal Editar Productos-->
    <div class="modal fade bs-example-modal-lg-udp" id="updateProducto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd" style="padding-right: 10%">
                        <div id="result2"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Id </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="mod_id" name="mod_id"  class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="mod_categoria" required id="mod_categoria">
                                    <option selected="" value="">-- Seleccione --</option>
                                    <?php foreach($categorias as $cat):?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Producto <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="mod_producto" required name="mod_producto" class="form-control" placeholder="Nombre producto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Precio ($) <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="number" step="0.01" id="mod_precio" required name="mod_precio" class="form-control" placeholder="00.00">
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Inventario </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="number" id="mod_inventario" name="mod_inventario" class="form-control" placeholder="Ingrese la cantidad del producto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Preparado <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" required name="mod_preparado" id="mod_preparado">
                                    <option selected value="">-- Seleccione --</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3" style="padding-top: 2%">
                                <span class="pull-right">
                                    <button id="upd_data" type="submit" class="btn btn-primary">Guardar</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div> <!-- /Modal -->