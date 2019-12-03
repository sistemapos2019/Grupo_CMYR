<script>
	$(document).ready(function() {
    load();
});

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
</script>

<?php

/*if (isset($_GET['idOrden'])) {
	$id=intval($_GET['idOrden']);
	echo "<p> $id </p>";
}else{
	echo "no recibido";
}*/

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
	$id= $_REQUEST['q'];
	echo $id;
}else{
	echo "Vacio";
}