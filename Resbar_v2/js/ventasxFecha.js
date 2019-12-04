$(document).ready(function() {
    $('.input-daterange').datepicker({
        "locale": {
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },

        format: "yyyy-mm-dd",
        autoclose: true

    });

    fetch_data('no');

    function fetch_data(is_date_search, start_date = '', end_date = '') {

        $.ajax({
            url: "ajax/ventasxFecha.php",
            type: "POST",
            data: {
                is_date_search: is_date_search,
                start_date: start_date,
                end_date: end_date
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader').html('');
            }
        })

    }

    $('#search').click(function() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date != '' && end_date != '') {
            $('#order_data').DataTable().destroy();
            fetch_data('yes', start_date, end_date);
        } else {
            swal.fire({
                title: "Por favor seleccione el rango de fechas",
                type: 'info',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                showCancelButton: false,
            });
        }
    });
    // $('#delete').click(function() {
    //     Swal.fire({
    //     title: '¿Realmente desea eliminar todas las bitácoras?',
    //     // text: "You won't be able to revert this!",
    //     type: 'warning',

    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Si',
    //     showCancelButton: true,
    //     }).then((result) => {
    //         if (result.value) {
    //             $.ajax({
    //             url: "ajax/bita.php",
    //             method: "POST",
    //             data: { type: "delete" }
    //             });
    //             location.reload(true);

    //     }
    //     })

    // });



});