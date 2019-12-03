<?php
    $categorias =mysqli_query($con, "select * from categoria");
?>

<div class="modal fade bs-example-modal-lg-add in" id="newProducto" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add" style="padding-right: 10%">
                    <div id="result"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" required name="categoria">
                                <option selected="" value="">-- Seleccione --</option>
                                <?php foreach($categorias as $p):?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Producto <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" required name="producto" class="form-control" placeholder="Escriba el nombre del nuevo producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Precio ($) <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" step="0.01" required name="precio" class="form-control" placeholder="00.00">
                        </div>
                    </div>
                    <div class="form-group" style="display: none">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Inventario </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" name="inventario" class="form-control" placeholder="Ingrese la cantidad del producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preparado <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" required name="preparado">
                                <option selected="" value="">-- Seleccione --</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3" style="padding-top: 2%">
                            <span class="pull-right">
                                <button id="save_data" type="submit" class="btn btn-primary">Agregar</button>
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