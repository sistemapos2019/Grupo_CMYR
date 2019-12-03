<?php
$mesas = mysqli_query($con, "select * from mesa");
$categorias = mysqli_query($con, "select * from categoria");

$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * from usuario where id=$id");
while ($row = mysqli_fetch_array($query)) {
    $id = $row['id'];
    $nombre = $row['nombreCompleto'];
    $rol = $row['rol'];
}

?>
<div class="modal fade bs-example-modal-lg-add in" data-backdrop="static" data-keyboard="false" id="nuevaOrden" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear orden</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                    <div class="col-md-6">
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" id="tipo" name="tipo" required onchange="habilitar_mesa(this);">
                                    <option selected="" value="">-- Seleccione --</option>
                                    <option value="aqui">Comer aquí</option>
                                    <option value="llevar">Llevar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mesa</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" id="mesa" name="mesa" disabled onchange="habilitar_crear(this);">
                                    <option selected="" value="">-- Seleccione --</option>
                                    <?php foreach ($mesas as $mesa) : ?>
                                        <option value="<?php echo $mesa['id']; ?>"><?php echo $mesa['mesa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mesero
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="" name="mesero" class="form-control" value="<?php echo $nombre ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cliente<span></span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="cliente" name="cliente" class="form-control" placeholder="Nombre del Cliente" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3" style="padding-top: 2%">
                            <span class="pull-right">
                            <a href="../nueva_orden.php"><button id="save_data" type="submit" class="btn btn-primary" disabled="">Crear</button></a>
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

<script>
    
    var mesa = document.getElementById('mesa');
    var cliente = document.getElementById('cliente');
    var btn_crear = document.getElementById('save_data');

    function habilitar_mesa(elemento) {
      d = elemento.value;
      
      switch(d){
        case "":
          mesa.disabled = true;
          mesa.selectedIndex = 0;
          btn_crear.disabled = true;
          cliente.disabled = true;
          break;
        case "aqui":
          mesa.disabled = false;
          btn_crear.disabled = true;
          cliente.disabled = true;
          cliente.required = false;
          break;
        case "llevar":
            mesa.disabled = true;
            mesa.selectedIndex = 0;
            btn_crear.disabled = false;
            cliente.disabled = false;
            cliente.required = true;
          break;
      }
    }

    function habilitar_crear(lista_mesa) {
      
      if(lista_mesa.value != ""){
        cliente.disabled = false;
        btn_crear.disabled = false;
      }else{
        cliente.disabled = true;
        btn_crear.disabled = true;
      }
    }

</script>