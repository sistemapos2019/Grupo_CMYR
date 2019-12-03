   
    <!-- Modal Editar Parametros-->
    <div class="modal fade bs-example-modal-lg-udp" id="updateParametro" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-edit"></i> Editar Parámetro</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                        <div id="result"></div>
                        <input type="hidden" id="mod_id" name="mod_id">
                        <input type="hidden" id="parametro" name="parametro">
                        <div class="form-group">
                            <label class="control-label" id="mod_nombre" name="mod_nombre" style="font-size: 14px; margin-bottom: 4px"><span class="required"></span></label>
                            <input type="text" id="mod_valor" required name="mod_valor" class="form-control" placeholder="Parametro">
                        </div>

                        <div class="form-group">
                                <span class="pull-right">
                                    <button id="upd_data" type="submit" class="btn btn-primary">Guardar</button>
                                </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div> <!-- /Modal -->