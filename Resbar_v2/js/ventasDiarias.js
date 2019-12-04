$(document).ready(function() {
    load(1);

});

function load(page) {

    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/ventasDiarias.php?action=ajax&page=' + page,
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}