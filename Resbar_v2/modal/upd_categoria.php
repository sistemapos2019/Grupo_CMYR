    <!-- Modal Editar Categoria-->
    <div class="modal fade bs-example-modal-lg-udp" id="updateCategoria" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Categoria</h4>
                </div>
                <!--Cuerpo del modal-->
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
                                <input type="text" id="mod_name" required name="mod_name" class="form-control" placeholder="Nombre">
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