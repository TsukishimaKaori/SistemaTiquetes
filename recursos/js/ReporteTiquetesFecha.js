$(document).ready(function () {
    tabla();
    $('#fechaI').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    })
    $('#fechaF').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    })
    
    
});
function tabla(){
$('#tablaMisTiquetes').DataTable({
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
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Reporte de Tiquetes por fecha -'+correoUsuario
            }
        ]

    });
    }
    

function Filtrar() {
    var fechaI = $("#fechaI").val();
    var fechaF = $("#fechaF").val();
    
    $.ajax({
        data: {'fechaI': fechaI, 'fechaF': fechaF
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesFecha.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            $('#tablaMisTiquetes').DataTable().destroy();
            $("#tbody-roles-usuariosCreados").html(response);
           tabla();

        }

    });
}  
