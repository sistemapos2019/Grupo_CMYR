$(document).ready(function() {
    load(1);
});

//cargar productos de detalle orden
function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/productos_pedido.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}