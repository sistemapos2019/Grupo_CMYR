

function load(page) {
    var q = $("#q").val();
    //$("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/dashboard.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            //$('#loader').html('');
        },
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
        url: "./ajax/dashboard.php",
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
                    title: 'Orden eliminada exitosamente',
                    showConfirmButton: false,
                    timer: 1700
                });
            }

            if (datos == 'error') {
                Swal.fire({
                    type: 'error',
                    title: '¡Error!',
                    text: 'No puede eliminar una orden que ya tenga productos',

                })

            }

        }
    });
}

function alertaEliminar(id) {
    Swal.fire({
        title: '¿Realmente desea eliminar la orden?',
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


function cobrar(id) {
    //Fin validacion
    var parametros = {
        "id": id

    };
    $.ajax({
        type: "POST",
        url: "./imprimir_factura.php",
        data: parametros,
        beforeSend: function(objeto) {

            // $("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
            // $(".outer_div").html(datos).fadeIn('slow');

        }
    });
}



function sendRequest() {
    var q = $("#q").val();
    $.ajax({
        url: './ajax/dashboard.php?action=ajax',
        // success: function(data) {
        //     /* si es success mostramos resultados */
        //     $('.outer_div').html(data);
        // },
        complete: function() {
            load(1);
            /* solo una vez que la petición se completa (success o no success) 
               pedimos una nueva petición en 3 segundos */
            setTimeout(function() {
                sendRequest();
            }, 15000);
        }
    });
};

/* primera petición que echa a andar la maquinaria */
$(function() {
    sendRequest();
});