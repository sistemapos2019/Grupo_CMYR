   
    <!-- Modal Agregar productos a la orden-->
    <div class="modal fade agregar-productos-orden" data-backdrop="static" data-keyboard="false" id="productos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Productos</h4>
                </div>
                <div div class="modal-body" id="product" name="product">
                    <!-- formulario para buscar productos-->
                    <form class="form-horizontal">
                        
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
                            </div>
                            <button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
                        </div>
                    </form>
                    <!-- Fin Form buscar -->
                    <div id="loader" style="position: absolute; text-align: center; top: 55px;  width: 100%;display:none;"></div>
                    <div class="otrodiv"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
