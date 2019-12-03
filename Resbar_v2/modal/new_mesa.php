<div class="modal fade bs-example-modal-lg-add in" id="newMesa" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Agregar Mesa</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add" required style="padding-right: 10%">
                    <div id="result"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mesa <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" required name="name" class="form-control" placeholder="Escriba algun nombre o descripción">
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