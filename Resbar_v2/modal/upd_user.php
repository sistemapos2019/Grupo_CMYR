    <!-- Modal Editar Usuario-->
    <div class="modal fade bs-example-modal-lg-udp" id="updateUser" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Completo <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" required id="mod_nombre" name="mod_nombre" class="form-control" placeholder="Escriba el nombre del nuevo usuario">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Usuario <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" required id="mod_usuario" name="mod_usuario" class="form-control" placeholder="Escriba el usuario">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Rol <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" required name="mod_rol" id="mod_rol">
                                    <option value="Mesero">Mesero</option>
                                    <option value="Gerente">Gerente</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="Password" required id="mod_contra" name="mod_contra" class="form-control" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pin <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" required id="mod_pin" name="mod_pin" class="form-control" placeholder="Pin">
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