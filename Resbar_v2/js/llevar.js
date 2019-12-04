$(document).ready(function() {

    load(1);
});

function load(page) {
    var q = $("#q").val();
    // $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/llevar.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            // $('#loader').html('');
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}


function sendRequest() {
    $.ajax({
        url: './ajax/llevar.php?action=ajax',
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
            }, 5000);
        }
    });
};

/* primera petición que echa a andar la maquinaria */
$(function() {
    sendRequest();
});