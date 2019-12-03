$(document).ready(function() {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/productos.php?action=ajax&page=' + page + '&q=' + q,
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}


function eliminar(id) {
    var q = $("#q").val();
    $.ajax({
        type: "GET",
        url: "./ajax/productos.php",
        data: "id=" + id,
        "q": q,
        beforeSend: function(objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {

            if (datos == 'eliminado') {
                load(1);
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: 'Producto eliminado exitosamente',
                    showConfirmButton: false,
                    timer: 1700
                });
            }

            if (datos == 'error') {
                Swal.fire({
                    type: 'error',
                    title: '¡Error!',
                    text: 'No puede eliminar Producto que ya se encuentra en una Orden',
                   
                })

            }
        }
    });
}

function alertaEliminar(id) {
    Swal.fire({
        title: '¿Realmente desea eliminar el producto?',
        // text: "You won't be able to revert this!",
        type: 'warning',

        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            eliminar(id);

        }
    })
}