<!-- modal para ingresar el efectivo y calcular el cambio a la hora de imprimir factura -->

<div class="modal fade modal-confirmar-cobro in" id="modalConfirmar" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Cobro</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="cobro" name="cobro">
                    <div id="result"></div>
                    <input type="hidden" id="idOrden" value="<?php echo $id ?>">

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Subtotal ($)</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="subtotalOrden" name="subtotalOrden" class="form-control" placeholder="00.00" value="<?php echo $total ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Propina (%)</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="number" step="0.01" min="0" max="1" id="desc_propina" name="desc_propina" class="form-control" placeholder="0.00" value="<?php echo $propina ?>" onkeyup="calcularPropina(this.value)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">propina ($)</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="number" id="propina" name="propina" class="form-control" placeholder="00.00" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12"><strong>Total ($)</strong></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="tex" id="total" name="total" class="form-control" placeholder="00.00" readonly style="border: 1px solid #39c;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Efectivo ($)</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="number" step="0.01" min="0" max="1000" id="efectivo" name="efectivo" required class="form-control" placeholder="00.00" onkeyup="calcularCambio(this.value)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Cambio ($)</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="cambio" name="cambio" class="form-control" placeholder="00.00" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3" style="padding-top: 2%">
                            <span class="pull-right">
                                <button id="confirmar" onclick="cobrar();finalizarOrden();" class="btn btn-primary" disabled>Confirmar</button>
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

