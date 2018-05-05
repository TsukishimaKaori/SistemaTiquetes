$(document).ready(function () {
    tablaInventario();
tablaMovimiento();
    $('#fechaI').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    })
    $('#fechaF').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    })
});

function tablaInventario() {
    $('#tablaInventario').DataTable({
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
function tablaMovimiento() {
    $('#tablaMovimiento').DataTable({
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

        }

    });
}
function FiltrarInventario() {
    var codigoI = $("#codigoI").val();
    var descripcion = $("#descripcionI").val();
    var categoria = $("#categoriaI").val();
    $.ajax({
        data: {'codigoI': codigoI, 'descripcion': descripcion, 'categoria': categoria
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReportesInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            $('#tablaInventario').DataTable().destroy();
            $("#tbodyInventario").html(response);
           tablaInventario();

        }

    });
}
function filtrarMovimiento() {
    var codigoM = $("#codigoM").val();
    var fechaI = $("#fechaI").val();
    var fechaF = $("#fechaF").val();
    var categoria = $("#categoriaM").val();
    $.ajax({
        data: {'codigoM': codigoM, 'categoria': categoria, 'fechaI': fechaI, 'fechaF': fechaF
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReportesInventario.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
           $('#tablaMovimiento').DataTable().destroy();
            $("#tbodyMovimiento").html(response);
           tablaMovimiento();
        }

    });
}

function exportarInventario(){
    $('#tablaInventario').DataTable().destroy();
$('#tablaInventario').tableExport({
    type:'excel',
    escape:'false',

});  
 tablaInventario();
}
function exportarMovimientos(){
$('#tablaMovimiento').DataTable().destroy();
$('#tablaMovimiento').tableExport(
{type:'excel',
escape:'false',

});
tablaMovimiento();
}