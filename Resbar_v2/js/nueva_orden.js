$(document).ready(function() {
    load(1);
    $('.detalle_orden').load("./ajax/nueva_orden_detalle.php");
});

//cargar productos de detalle orden
function load(page) {
    $.ajax({
        url: './ajax/agregar_pedidoSinPag.php?action=ajax&page=' + page,
        beforeSend: function(objeto) {
        },
        success: function(data) {
            $(".detalle_orden").html(data).fadeIn('slow');
        }
    })
}