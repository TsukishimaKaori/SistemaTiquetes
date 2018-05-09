$(document).ready(function () {

    tablaTiquetes();

});

function tablaTiquetes() {
    $('#tablaTiquetes').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar búsqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        },

    });
}


function FiltrarTiquete() {
    var estado = $("#estado").val();

    $.ajax({
        data: {'estado': estado
        },
        dataType: 'json',
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesEstado.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            $('#CantidadInfo').html(response['cantidad']);
            $('#tablaTiquetes').DataTable().destroy();
            $("#tbodyTiquetes").html(response['tiquetes']);
            tablaTiquetes();

        }

    });
}
function mostrarDetalleTIquetes($codigo) {

    $.ajax({
        data: {'codigo': $codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesEstado.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            $('#infoTiquete').html(response);


        }

    });
}